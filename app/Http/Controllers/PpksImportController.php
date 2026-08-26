<?php

namespace App\Http\Controllers;

use App\Models\ImportLog;
use App\Models\Ppks;
use App\Services\GoogleSheetService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Throwable;

class PpksImportController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Konfigurasi Google Sheet
    |--------------------------------------------------------------------------
    */

    private string $spreadsheetId =
        '1uWDJthPz5yW61BPWG5v1FhcyAHekXpSfWsFGBxJr1pM';

    private string $sheetName = 'Form Responses 1';


    /*
    |--------------------------------------------------------------------------
    | HALAMAN IMPORT
    |--------------------------------------------------------------------------
    */

    public function index(): View
    {
        $totalImported = Ppks::count();

        $totalPerluDiperiksa = Ppks::where(
            'status',
            'perlu_diperiksa'
        )->count();

        $importLogs = ImportLog::latest('created_at')
            ->take(20)
            ->get();

        return view('ppks.import', [
            'totalImported' => $totalImported,
            'totalPerluDiperiksa' => $totalPerluDiperiksa,
            'importLogs' => $importLogs,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | IMPORT DATA BARU
    |--------------------------------------------------------------------------
    */

    public function import(
        GoogleSheetService $googleSheetService
    ): JsonResponse {

        $importLog = ImportLog::create([
            'started_at' => now(),
            'status' => 'proses',
            'message' => 'Import data baru sedang diproses.',
        ]);

        try {

            /*
            |--------------------------------------------------------------------------
            | Ambil baris terakhir
            |--------------------------------------------------------------------------
            */

            $lastImportedRow = Ppks::max('sheet_row');

            $startRow = $lastImportedRow
                ? $lastImportedRow + 1
                : 2;


            /*
            |--------------------------------------------------------------------------
            | Ambil data baru dari Google Sheet
            |--------------------------------------------------------------------------
            */

            $rows = $googleSheetService->getRows(
                $this->spreadsheetId,
                $this->sheetName,
                $startRow
            );


            /*
            |--------------------------------------------------------------------------
            | Tidak ada data baru
            |--------------------------------------------------------------------------
            */

            if (empty($rows)) {

                $importLog->update([
                    'finished_at' => now(),
                    'data_ditemukan' => 0,
                    'nik_unik' => 0,
                    'data_normal' => 0,
                    'data_perlu_diperiksa' => 0,
                    'data_diupdate' => 0,
                    'status' => 'berhasil',
                    'message' => 'Tidak ada data baru.',
                ]);

                return response()->json([
                    'message' => 'Tidak ada data baru.',
                    'start_row' => $startRow,
                    'data_ditemukan' => 0,
                    'nik_unik' => 0,
                    'imported' => 0,
                    'updated' => 0,
                    'perlu_diperiksa' => 0,
                    'total_in_database' => Ppks::count(),
                ]);
            }


            /*
            |--------------------------------------------------------------------------
            | Ambil respons terakhir berdasarkan NIK
            |--------------------------------------------------------------------------
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


            /*
            |--------------------------------------------------------------------------
            | Cache database
            |--------------------------------------------------------------------------
            */

            $existingPpks = Ppks::orderByDesc('sheet_row')->get();

            $existingByNik = [];
            $existingByIdentity = [];

            foreach ($existingPpks as $ppks) {

                if (!is_array($ppks->data)) {
                    continue;
                }

                $oldNik = $this->normalizeNik(
                    $ppks->data[2] ?? ''
                );

                $oldIdentity = $this->getIdentity(
                    $ppks->data
                );

                if (
                    $oldNik !== '' &&
                    !isset($existingByNik[$oldNik])
                ) {
                    $existingByNik[$oldNik] = $ppks;
                }

                $identityKey = $this->identityKey(
                    $oldIdentity
                );

                if (
                    $identityKey !== null &&
                    !isset($existingByIdentity[$identityKey])
                ) {
                    $existingByIdentity[$identityKey] = $ppks;
                }
            }


            /*
            |--------------------------------------------------------------------------
            | Counter
            |--------------------------------------------------------------------------
            */

            $imported = 0;
            $updated = 0;
            $perluDiperiksa = 0;


            /*
            |--------------------------------------------------------------------------
            | Proses data
            |--------------------------------------------------------------------------
            */

            foreach ($latestByNik as $nik => $item) {

                $row = $item['data'];

                $sheetRow = $item['sheet_row'];

                $newIdentity = $this->getIdentity(
                    $row
                );


                /*
                |--------------------------------------------------------------------------
                | Cari NIK
                |--------------------------------------------------------------------------
                */

                $existing = $existingByNik[$nik] ?? null;


                /*
                |--------------------------------------------------------------------------
                | NIK SAMA
                |--------------------------------------------------------------------------
                */

                if ($existing) {

                    $oldIdentity = $this->getIdentity(
                        $existing->data
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | NIK sama + identitas sama
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

                        $existingByNik[$nik] = $existing;

                        $identityKey = $this->identityKey(
                            $newIdentity
                        );

                        if ($identityKey !== null) {
                            $existingByIdentity[$identityKey] =
                                $existing;
                        }

                        $updated++;

                        continue;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | NIK sama + identitas berbeda
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
                | NIK berbeda + identitas sama
                |--------------------------------------------------------------------------
                */

                $identityKey = $this->identityKey(
                    $newIdentity
                );

                $possibleDuplicate =
                    $identityKey !== null
                        ? ($existingByIdentity[$identityKey] ?? null)
                        : null;


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
                | Data benar-benar baru
                |--------------------------------------------------------------------------
                */

                $newPpks = Ppks::create([
                    'sheet_row' => $sheetRow,
                    'data' => $row,
                    'status' => 'normal',
                    'possible_duplicate_of' => null,
                    'duplicate_note' => null,
                    'imported_at' => now(),
                ]);

                $existingByNik[$nik] = $newPpks;

                if ($identityKey !== null) {
                    $existingByIdentity[$identityKey] =
                        $newPpks;
                }

                $imported++;
            }


            /*
            |--------------------------------------------------------------------------
            | Simpan log
            |--------------------------------------------------------------------------
            */

            $importLog->update([
                'finished_at' => now(),
                'data_ditemukan' => count($rows),
                'nik_unik' => count($latestByNik),
                'data_normal' => $imported,
                'data_perlu_diperiksa' => $perluDiperiksa,
                'data_diupdate' => $updated,
                'status' => 'berhasil',
                'message' => 'Import data baru selesai.',
            ]);


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

        } catch (Throwable $e) {

            $importLog->update([
                'finished_at' => now(),
                'status' => 'gagal',
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Import gagal.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | CEK ULANG SEMUA DATA
    |--------------------------------------------------------------------------
    */

    public function recheck(
        GoogleSheetService $googleSheetService
    ): RedirectResponse {

        $importLog = ImportLog::create([
            'started_at' => now(),
            'status' => 'proses',
            'message' => 'Pengecekan ulang seluruh data sedang diproses.',
        ]);

        try {

            /*
            |--------------------------------------------------------------------------
            | Ambil SEMUA data dari Google Sheet mulai baris 2
            |--------------------------------------------------------------------------
            */

            $rows = $googleSheetService->getRows(
                $this->spreadsheetId,
                $this->sheetName,
                2
            );


            if (empty($rows)) {

                $importLog->update([
                    'finished_at' => now(),
                    'status' => 'berhasil',
                    'data_ditemukan' => 0,
                    'nik_unik' => 0,
                    'data_normal' => 0,
                    'data_perlu_diperiksa' => 0,
                    'data_diupdate' => 0,
                    'message' => 'Google Sheet tidak memiliki data.',
                ]);

                return back()->with(
                    'success',
                    'Tidak ada data dari Google Sheet.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Database
            |--------------------------------------------------------------------------
            */

            $existingPpks = Ppks::orderByDesc('sheet_row')->get();

            $existingByNik = [];
            $existingByIdentity = [];

            foreach ($existingPpks as $ppks) {

                if (!is_array($ppks->data)) {
                    continue;
                }

                $nik = $this->normalizeNik(
                    $ppks->data[2] ?? ''
                );

                if (
                    $nik !== '' &&
                    !isset($existingByNik[$nik])
                ) {
                    $existingByNik[$nik] = $ppks;
                }

                $identity = $this->getIdentity(
                    $ppks->data
                );

                $identityKey = $this->identityKey(
                    $identity
                );

                if (
                    $identityKey !== null &&
                    !isset($existingByIdentity[$identityKey])
                ) {
                    $existingByIdentity[$identityKey] = $ppks;
                }
            }


            /*
            |--------------------------------------------------------------------------
            | Counter
            |--------------------------------------------------------------------------
            */

            $normal = 0;
            $perluDiperiksa = 0;
            $updated = 0;
            $newData = 0;


            /*
            |--------------------------------------------------------------------------
            | CEK SETIAP BARIS GOOGLE SHEET
            |--------------------------------------------------------------------------
            */

            foreach ($rows as $index => $row) {

                if (empty($row)) {
                    continue;
                }

                $sheetRow = 2 + $index;

                $nik = $this->normalizeNik(
                    $row[2] ?? ''
                );

                if ($nik === '') {
                    continue;
                }

                $newIdentity = $this->getIdentity(
                    $row
                );

                $existing = $existingByNik[$nik] ?? null;


                /*
                |--------------------------------------------------------------------------
                | NIK SAMA
                |--------------------------------------------------------------------------
                */

                if ($existing) {

                    $oldIdentity = $this->getIdentity(
                        $existing->data
                    );


                    /*
                    | NIK sama + identitas sama
                    | → NORMAL
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
                        ]);

                        $normal++;
                        $updated++;

                        continue;
                    }


                    /*
                    | NIK sama + identitas berbeda
                    | → PERLU DIPERIKSA
                    */

                    $existing->update([
                        'sheet_row' => $sheetRow,
                        'data' => $row,
                        'status' => 'perlu_diperiksa',
                        'possible_duplicate_of' => $existing->id,
                        'duplicate_note' =>
                            'NIK sama tetapi identitas berbeda. Perlu pemeriksaan admin.',
                    ]);

                    $perluDiperiksa++;
                    $updated++;

                    continue;
                }


                /*
                |--------------------------------------------------------------------------
                | NIK BERBEDA
                |--------------------------------------------------------------------------
                */

                $identityKey = $this->identityKey(
                    $newIdentity
                );

                $possibleDuplicate =
                    $identityKey !== null
                        ? ($existingByIdentity[$identityKey] ?? null)
                        : null;


                /*
                |--------------------------------------------------------------------------
                | Identitas sama → PERLU DIPERIKSA
                |--------------------------------------------------------------------------
                */

                if ($possibleDuplicate) {

                    $newPpks = Ppks::create([
                        'sheet_row' => $sheetRow,
                        'data' => $row,
                        'status' => 'perlu_diperiksa',
                        'possible_duplicate_of' =>
                            $possibleDuplicate->id,
                        'duplicate_note' =>
                            'Identitas sama tetapi NIK berbeda. Perlu pemeriksaan admin.',
                        'imported_at' => now(),
                    ]);

                    $existingByNik[$nik] = $newPpks;

                    $perluDiperiksa++;
                    $newData++;

                    continue;
                }


                /*
                |--------------------------------------------------------------------------
                | Data benar-benar normal
                |--------------------------------------------------------------------------
                */

                $newPpks = Ppks::create([
                    'sheet_row' => $sheetRow,
                    'data' => $row,
                    'status' => 'normal',
                    'possible_duplicate_of' => null,
                    'duplicate_note' => null,
                    'imported_at' => now(),
                ]);

                $existingByNik[$nik] = $newPpks;

                if ($identityKey !== null) {
                    $existingByIdentity[$identityKey] =
                        $newPpks;
                }

                $normal++;
                $newData++;
            }


            /*
            |--------------------------------------------------------------------------
            | Log hasil recheck
            |--------------------------------------------------------------------------
            */

            $importLog->update([
                'finished_at' => now(),
                'data_ditemukan' => count($rows),
                'nik_unik' => count(array_filter(
                    array_map(
                        fn ($row) =>
                            $this->normalizeNik($row[2] ?? ''),
                        $rows
                    )
                )),
                'data_normal' => $normal,
                'data_perlu_diperiksa' => $perluDiperiksa,
                'data_diupdate' => $updated,
                'status' => 'berhasil',
                'message' =>
                    'Pengecekan ulang seluruh data selesai.',
            ]);


            return back()->with(
                'success',
                "Pengecekan selesai. Normal: {$normal}, Perlu diperiksa: {$perluDiperiksa}, Data baru: {$newData}."
            );

        } catch (Throwable $e) {

            $importLog->update([
                'finished_at' => now(),
                'status' => 'gagal',
                'message' => $e->getMessage(),
            ]);

            return back()->with(
                'error',
                'Pengecekan gagal: ' . $e->getMessage()
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | IDENTITY KEY
    |--------------------------------------------------------------------------
    */

    private function identityKey(
        array $identity
    ): ?string {

        if (
            $identity['nama'] === '' ||
            $identity['jenis_kelamin'] === '' ||
            $identity['tempat_lahir'] === '' ||
            $identity['tanggal_lahir'] === ''
        ) {
            return null;
        }

        return implode('|', [
            $identity['nama'],
            $identity['jenis_kelamin'],
            $identity['tempat_lahir'],
            $identity['tanggal_lahir'],
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | GET IDENTITY
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
    | SAME IDENTITY
    |--------------------------------------------------------------------------
    */

    private function sameIdentity(
        array $a,
        array $b
    ): bool {

        $keyA = $this->identityKey($a);

        $keyB = $this->identityKey($b);

        return
            $keyA !== null &&
            $keyB !== null &&
            $keyA === $keyB;
    }


    /*
    |--------------------------------------------------------------------------
    | NORMALIZE NIK
    |--------------------------------------------------------------------------
    */

    private function normalizeNik(
        $value
    ): string {

        $value = trim((string) $value);

        return preg_replace(
            '/[^0-9]/',
            '',
            $value
        );
    }


    /*
    |--------------------------------------------------------------------------
    | NORMALIZE TEXT
    |--------------------------------------------------------------------------
    */

    private function normalize(
        $value
    ): string {

        $value = strtolower(
            trim((string) $value)
        );

        $value = preg_replace(
            '/[^a-z0-9\s]/u',
            ' ',
            $value
        );

        $value = preg_replace(
            '/\s+/',
            ' ',
            $value
        );

        return trim($value);
    }
}
