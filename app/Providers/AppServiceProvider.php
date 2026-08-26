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

        return view(
            'ppks.import',
            compact(
                'totalImported',
                'totalPerluDiperiksa'
            )
        );
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
        | 2. Ambil data baru dari Google Sheet
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
        | 3. Ambil respons terakhir untuk setiap NIK
        |--------------------------------------------------------------------------
        |
        | Jika dalam data baru terdapat NIK yang sama beberapa kali,
        | respons dengan sheet_row paling akhir yang digunakan.
        |
        */

        $latestByNik = [];

        foreach ($rows as $index => $row) {

            if (empty($row)) {
                continue;
            }

            $sheetRow = $startRow + $index;

            $nik = $this->normalizeNik(
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
            | 5. Cari data lama berdasarkan NIK
            |--------------------------------------------------------------------------
            */

            $existing = $this->findByNik($nik);

            /*
            |--------------------------------------------------------------------------
            | ATURAN 1
            |
            | NIK SAMA + IDENTITAS SAMA
            |
            | Data dianggap respons terbaru dari orang yang sama.
            |--------------------------------------------------------------------------
            */

            if ($existing) {

                $oldIdentity = $this->getIdentity(
                    $existing->data
                );

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
                | NIK SAMA + IDENTITAS BERBEDA
                |
                | Jangan overwrite data lama.
                | Data baru masuk sebagai perlu diperiksa.
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
            */

            $possibleDuplicate = $this->findByIdentity(
                $newIdentity
            );

            /*
            |--------------------------------------------------------------------------
            | ATURAN 3
            |
            | NIK BERBEDA + IDENTITAS SAMA
            |
            | Masuk perlu diperiksa.
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
            | Cek kemungkinan identitas sangat mirip.
            |--------------------------------------------------------------------------
            */

            $similarDuplicate = $this->findSimilarIdentity(
                $newIdentity
            );

            if ($similarDuplicate) {

                Ppks::create([
                    'sheet_row' => $sheetRow,
                    'data' => $row,
                    'status' => 'perlu_diperiksa',
                    'possible_duplicate_of' =>
                        $similarDuplicate->id,
                    'duplicate_note' =>
                        'Identitas memiliki kemiripan tinggi. Perlu pemeriksaan admin.',
                    'imported_at' => now(),
                ]);

                $perluDiperiksa++;

                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | ATURAN 5
            |
            | NIK BERBEDA + IDENTITAS BERBEDA
            |
            | Data dianggap normal.
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
        | 7. Hasil Import
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

            $oldNik = $this->normalizeNik(
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
    | Cari berdasarkan identitas lengkap
    |--------------------------------------------------------------------------
    */

    private function findByIdentity(
        array $identity
    ): ?Ppks {

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
    | Cari berdasarkan identitas yang sangat mirip
    |--------------------------------------------------------------------------
    */

    private function findSimilarIdentity(
        array $identity
    ): ?Ppks {

        /*
        | Nama harus tersedia.
        */

        if ($identity['nama'] === '') {
            return null;
        }

        $allPpks = Ppks::orderByDesc('sheet_row')->get();

        foreach ($allPpks as $ppks) {

            /*
            | Jangan membandingkan dengan data yang sudah duplikat.
            */

            if ($ppks->status === 'duplikat') {
                continue;
            }

            $oldIdentity = $this->getIdentity(
                $ppks->data
            );

            if ($oldIdentity['nama'] === '') {
                continue;
            }

            /*
            | Hitung kemiripan nama.
            */

            similar_text(
                $identity['nama'],
                $oldIdentity['nama'],
                $namePercent
            );

            /*
            | Nama minimal 85% mirip.
            */

            if ($namePercent < 85) {
                continue;
            }

            /*
            | Jenis kelamin harus sama jika keduanya tersedia.
            */

            if (
                $identity['jenis_kelamin'] !== '' &&
                $oldIdentity['jenis_kelamin'] !== '' &&
                $identity['jenis_kelamin'] !==
                    $oldIdentity['jenis_kelamin']
            ) {
                continue;
            }

            /*
            | Tempat lahir harus sama jika tersedia.
            */

            if (
                $identity['tempat_lahir'] !== '' &&
                $oldIdentity['tempat_lahir'] !== '' &&
                $identity['tempat_lahir'] !==
                    $oldIdentity['tempat_lahir']
            ) {
                continue;
            }

            /*
            | Tanggal lahir harus sama jika tersedia.
            */

            if (
                $identity['tanggal_lahir'] !== '' &&
                $oldIdentity['tanggal_lahir'] !== '' &&
                $identity['tanggal_lahir'] !==
                    $oldIdentity['tanggal_lahir']
            ) {
                continue;
            }

            return $ppks;
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

    private function getIdentity(
        array $data
    ): array {

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
    | Bandingkan identitas lengkap
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
            $a['jenis_kelamin'] ===
                $b['jenis_kelamin'] &&

            $a['tempat_lahir'] ===
                $b['tempat_lahir'] &&

            $a['tanggal_lahir'] ===
                $b['tanggal_lahir'];
    }

    /*
    |--------------------------------------------------------------------------
    | Normalisasi NIK
    |--------------------------------------------------------------------------
    */

    private function normalizeNik(
        $value
    ): string {

        $value = trim((string) $value);

        /*
        | Hanya angka.
        */

        return preg_replace(
            '/[^0-9]/',
            '',
            $value
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Normalisasi teks
    |--------------------------------------------------------------------------
    */

    private function normalize(
        $value
    ): string {

        $value = strtolower(
            trim((string) $value)
        );

        /*
        | Hilangkan karakter khusus.
        */

        $value = preg_replace(
            '/[^a-z0-9\s]/u',
            ' ',
            $value
        );

        /*
        | Rapikan spasi.
        */

        $value = preg_replace(
            '/\s+/',
            ' ',
            $value
        );

        return trim($value);
    }
}
