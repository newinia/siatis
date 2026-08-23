<?php

namespace App\Http\Controllers;

use App\Models\Ppks;
use App\Services\GoogleSheetService;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class PpksImportController extends Controller
{
    public function index(): View
    {
        $totalImported = Ppks::count();

        $totalPerluDiperiksa = Ppks::where(
            'status',
            'perlu_diperiksa'
        )->count();

        return view('ppks.import', compact(
            'totalImported',
            'totalPerluDiperiksa'
        ));
    }

    public function import(
        GoogleSheetService $googleSheetService
    ): JsonResponse {
        $spreadsheetId =
            '1uWDJthPz5yW61BPWG5v1FhcyAHekXpSfWsFGBxJr1pM';

        $sheetName = 'Form Responses 1';

        /*
        |--------------------------------------------------------------------------
        | 1. Tentukan baris terakhir yang sudah diproses
        |--------------------------------------------------------------------------
        */

        $lastImportedRow = Ppks::max('sheet_row');

        $startRow = $lastImportedRow
            ? $lastImportedRow + 1
            : 2;

        /*
        |--------------------------------------------------------------------------
        | 2. Ambil data baru
        |--------------------------------------------------------------------------
        */

        $rows = $googleSheetService->getRows(
            $spreadsheetId,
            $sheetName,
            $startRow,
            5000
        );

        if (empty($rows)) {
            return response()->json([
                'message' => 'Tidak ada data baru.',
                'start_row' => $startRow,
                'data_ditemukan' => 0,
                'imported' => 0,
                'updated' => 0,
                'perlu_diperiksa' => 0,
                'total_in_database' => Ppks::count(),
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | 3. Ambil respons TERAKHIR untuk setiap NIK
        |--------------------------------------------------------------------------
        |
        | Kalau dalam batch baru terdapat NIK yang sama beberapa kali,
        | respons paling akhir yang digunakan.
        |
        */

        $latestByNik = [];

        foreach ($rows as $index => $row) {

            if (empty($row)) {
                continue;
            }

            $sheetRow = $startRow + $index;

            $nik = $this->normalize(
                $row[2] ?? ''
            );

            if ($nik === '') {
                continue;
            }

            $latestByNik[$nik] = [
                'sheet_row' => $sheetRow,
                'data' => $row,
            ];
        }

        $imported = 0;
        $updated = 0;
        $perluDiperiksa = 0;

        /*
        |--------------------------------------------------------------------------
        | 4. Proses setiap NIK
        |--------------------------------------------------------------------------
        */

        foreach ($latestByNik as $nik => $item) {

            $row = $item['data'];
            $sheetRow = $item['sheet_row'];

            $newIdentity = $this->getIdentity($row);

            /*
            |--------------------------------------------------------------------------
            | 5. Cari NIK yang sama
            |--------------------------------------------------------------------------
            */

            $existing = $this->findByNik($nik);

            /*
            |--------------------------------------------------------------------------
            | 5A. NIK SAMA
            |--------------------------------------------------------------------------
            */

            if ($existing) {

                $oldIdentity = $this->getIdentity(
                    $existing->data
                );

                /*
                |--------------------------------------------------------------------------
                | ATURAN 1
                |
                | NIK sama + identitas sama
                | -> respons terakhir
                |--------------------------------------------------------------------------
                */

                if (
                    $this->sameIdentity(
                        $oldIdentity,
                        $newIdentity
                    )
                ) {
                    $existing->update([
                        'sheet_row' => $sheetRow,
                        'data' => $row,
                        'status' => 'normal',
                        'possible_duplicate_of' => null,
                        'duplicate_note' => null,
                        'imported_at' => now(),
                    ]);

                    $updated++;

                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | ATURAN 2
                |
                | NIK sama + identitas berbeda
                | -> perlu pemeriksaan admin
                | -> TIDAK overwrite data lama
                |--------------------------------------------------------------------------
                */

                Ppks::create([
                    'sheet_row' => $sheetRow,
                    'data' => $row,
                    'status' => 'perlu_diperiksa',
                    'possible_duplicate_of' => $existing->id,
                    'duplicate_note' =>
                        'NIK sama tetapi identitas berbeda. Perlu pemeriksaan admin.',
                    'imported_at' => now(),
                ]);

                $perluDiperiksa++;

                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | 6. NIK BERBEDA
            |--------------------------------------------------------------------------
            |
            | Cari apakah identitas sama dengan data lama.
            |
            */

            $possibleDuplicate = $this->findByIdentity(
                $newIdentity
            );

            /*
            |--------------------------------------------------------------------------
            | ATURAN 3
            |
            | NIK berbeda + identitas sama
            | -> perlu pemeriksaan admin
            | -> TIDAK dihapus
            |--------------------------------------------------------------------------
            */

            if ($possibleDuplicate) {

                Ppks::create([
                    'sheet_row' => $sheetRow,
                    'data' => $row,
                    'status' => 'perlu_diperiksa',
                    'possible_duplicate_of' =>
                        $possibleDuplicate->id,
                    'duplicate_note' =>
                        'Identitas sama tetapi NIK berbeda. Perlu pemeriksaan admin.',
                    'imported_at' => now(),
                ]);

                $perluDiperiksa++;

                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | ATURAN 4
            |
            | NIK berbeda + identitas berbeda
            | -> data baru
            |--------------------------------------------------------------------------
            */

            Ppks::create([
                'sheet_row' => $sheetRow,
                'data' => $row,
                'status' => 'normal',
                'possible_duplicate_of' => null,
                'duplicate_note' => null,
                'imported_at' => now(),
            ]);

            $imported++;
        }

        /*
        |--------------------------------------------------------------------------
        | 7. Hasil import
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'message' => 'Import selesai.',
            'start_row' => $startRow,
            'data_ditemukan' => count($rows),
            'nik_unik' => count($latestByNik),
            'imported' => $imported,
            'updated' => $updated,
            'perlu_diperiksa' => $perluDiperiksa,
            'total_in_database' => Ppks::count(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Cari berdasarkan NIK
    |--------------------------------------------------------------------------
    */

    private function findByNik(string $nik): ?Ppks
    {
        $allPpks = Ppks::orderByDesc('sheet_row')->get();

        foreach ($allPpks as $ppks) {

            $data = $ppks->data;

            if (!is_array($data)) {
                continue;
            }

            $oldNik = $this->normalize(
                $data[2] ?? ''
            );

            if ($oldNik === $nik) {
                return $ppks;
            }
        }

        return null;
    }

    /*
    |--------------------------------------------------------------------------
    | Cari berdasarkan identitas
    |--------------------------------------------------------------------------
    */

    private function findByIdentity(array $identity): ?Ppks
    {
        $allPpks = Ppks::orderByDesc('sheet_row')->get();

        foreach ($allPpks as $ppks) {

            $oldIdentity = $this->getIdentity(
                $ppks->data
            );

            if (
                $this->sameIdentity(
                    $oldIdentity,
                    $identity
                )
            ) {
                return $ppks;
            }
        }

        return null;
    }

    /*
    |--------------------------------------------------------------------------
    | Ambil identitas
    |--------------------------------------------------------------------------
    |
    | B = Nama
    | D = Jenis Kelamin
    | E = Tempat Lahir
    | F = Tanggal Lahir
    |--------------------------------------------------------------------------
    */

    private function getIdentity(array $data): array
    {
        return [
            'nama' => $this->normalize(
                $data[1] ?? ''
            ),

            'jenis_kelamin' => $this->normalize(
                $data[3] ?? ''
            ),

            'tempat_lahir' => $this->normalize(
                $data[4] ?? ''
            ),

            'tanggal_lahir' => $this->normalize(
                $data[5] ?? ''
            ),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Bandingkan identitas
    |--------------------------------------------------------------------------
    */

    private function sameIdentity(
        array $a,
        array $b
    ): bool {
        return
            $a['nama'] !== '' &&
            $b['nama'] !== '' &&
            $a['jenis_kelamin'] !== '' &&
            $b['jenis_kelamin'] !== '' &&
            $a['tempat_lahir'] !== '' &&
            $b['tempat_lahir'] !== '' &&
            $a['tanggal_lahir'] !== '' &&
            $b['tanggal_lahir'] !== '' &&
            $a['nama'] === $b['nama'] &&
            $a['jenis_kelamin'] === $b['jenis_kelamin'] &&
            $a['tempat_lahir'] === $b['tempat_lahir'] &&
            $a['tanggal_lahir'] === $b['tanggal_lahir'];
    }

    /*
    |--------------------------------------------------------------------------
    | Normalisasi teks
    |--------------------------------------------------------------------------
    */

    private function normalize($value): string
    {
        return strtolower(
            preg_replace(
                '/\s+/',
                ' ',
                trim((string) $value)
            )
        );
    }
}
