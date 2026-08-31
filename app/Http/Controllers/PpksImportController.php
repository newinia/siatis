<?php

namespace App\Http\Controllers;

use App\Models\ImportLog;
use App\Models\Ppks;
use App\Models\RecheckResult;
use App\Services\GoogleSheetService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Throwable;

class PpksImportController extends Controller
{
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
        return view('ppks.import', [
            'totalImported' => Ppks::count(),

            'totalPerluDiperiksa' => Ppks::where(
                'status',
                'perlu_diperiksa'
            )->count(),

            'importLogs' => ImportLog::latest('created_at')
                ->take(20)
                ->get(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | PROCESS IMPORT BARU
    |--------------------------------------------------------------------------
    */

    public function process(
        GoogleSheetService $googleSheetService
    ): RedirectResponse {
        $response = $this->import($googleSheetService);

        $data = $response->getData(true);

        if ($response->getStatusCode() >= 400) {
            return back()->with(
                'error',
                $data['error'] ?? 'Import data gagal.'
            );
        }

        return back()->with(
            'success',
            $data['message'] ?? 'Import data berhasil.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | IMPORT DATA BARU
    |--------------------------------------------------------------------------
    |
    | ATURAN:
    |
    | 1. NIK sama + identitas sama
    |    -> UPDATE
    |
    | 2. NIK sama + identitas berbeda
    |    -> CREATE perlu_diperiksa
    |
    | 3. NIK berbeda + identitas sama
    |    -> CREATE perlu_diperiksa
    |
    | 4. NIK berbeda + identitas berbeda
    |    -> CREATE normal
    |
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
            | 1. CARI BARIS TERAKHIR
            |--------------------------------------------------------------------------
            */

            $lastImportedRow = Ppks::max('sheet_row');

            $startRow = $lastImportedRow
                ? $lastImportedRow + 1
                : 2;

            /*
            |--------------------------------------------------------------------------
            | 2. AMBIL DATA BARU
            |--------------------------------------------------------------------------
            */

            $rows = $googleSheetService->getRows(
                $this->spreadsheetId,
                $this->sheetName,
                $startRow,
                5000
            );

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
            | 3. AMBIL RESPONSE TERAKHIR PER NIK
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
            | 4. CACHE DATABASE
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

                if (
                    $oldNik !== '' &&
                    !isset($existingByNik[$oldNik])
                ) {
                    $existingByNik[$oldNik] = $ppks;
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
            | 5. COUNTER
            |--------------------------------------------------------------------------
            */

            $normal = 0;
            $perluDiperiksa = 0;
            $updated = 0;

            /*
            |--------------------------------------------------------------------------
            | 6. PROSES DATA
            |--------------------------------------------------------------------------
            */

            foreach ($latestByNik as $nik => $item) {
                $row = $item['data'];
                $sheetRow = $item['sheet_row'];

                $newIdentity = $this->getIdentity($row);

                $identityKey = $this->identityKey(
                    $newIdentity
                );

                $existing = $existingByNik[$nik] ?? null;

                /*
                |--------------------------------------------------------------------------
                | ATURAN 1
                | NIK SAMA + IDENTITAS SAMA
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

                        $existingByNik[$nik] = $existing;

                        if ($identityKey !== null) {
                            $existingByIdentity[$identityKey] =
                                $existing;
                        }

                        $normal++;
                        $updated++;

                        continue;
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | ATURAN 2
                    | NIK SAMA + IDENTITAS BERBEDA
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
                | NIK TIDAK ADA
                |--------------------------------------------------------------------------
                */

                $possibleDuplicate = null;

                if ($identityKey !== null) {
                    $possibleDuplicate =
                        $existingByIdentity[$identityKey] ?? null;
                }

                /*
                |--------------------------------------------------------------------------
                | ATURAN 3
                | NIK BERBEDA + IDENTITAS SAMA
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

                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | ATURAN 4
                | NIK BERBEDA + IDENTITAS BERBEDA
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
            }

            /*
            |--------------------------------------------------------------------------
            | 7. LOG
            |--------------------------------------------------------------------------
            */

            $importLog->update([
                'finished_at' => now(),
                'data_ditemukan' => count($rows),
                'nik_unik' => count($latestByNik),
                'data_normal' => $normal,
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
                'imported' => $normal,
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
    |
    | Recheck:
    |
    | 1. Membaca semua data Google Sheet
    | 2. Mengambil response terakhir setiap NIK
    | 3. Membandingkan dengan data PPKS
    | 4. Mendeteksi identitas sama
    | 5. Mendeteksi identitas MIRIP
    | 6. Menyimpan hasil ke recheck_results
    |
    | Recheck TIDAK membuat Ppks baru.
    |
    */

    public function recheck(
        GoogleSheetService $googleSheetService
    ): RedirectResponse {
        $importLog = ImportLog::create([
            'started_at' => now(),
            'status' => 'proses',
            'message' =>
                'Pengecekan ulang seluruh data sedang diproses.',
        ]);

        try {
            /*
            |--------------------------------------------------------------------------
            | 1. AMBIL SEMUA DATA GOOGLE SHEET
            |--------------------------------------------------------------------------
            */

            $rows = $googleSheetService->getRows(
                $this->spreadsheetId,
                $this->sheetName,
                2,
                5000
            );

            if (empty($rows)) {
                $importLog->update([
                    'finished_at' => now(),
                    'data_ditemukan' => 0,
                    'nik_unik' => 0,
                    'data_normal' => 0,
                    'data_perlu_diperiksa' => 0,
                    'data_diupdate' => 0,
                    'status' => 'berhasil',
                    'message' =>
                        'Google Sheet tidak memiliki data.',
                ]);

                return back()->with(
                    'success',
                    'Tidak ada data dari Google Sheet.'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | 2. AMBIL RESPONSE TERAKHIR SETIAP NIK
            |--------------------------------------------------------------------------
            */

            $latestByNik = [];

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

                $latestByNik[$nik] = [
                    'sheet_row' => $sheetRow,
                    'data' => $row,
                ];
            }

            /*
            |--------------------------------------------------------------------------
            | 3. HAPUS HASIL RECHECK PENDING LAMA
            |--------------------------------------------------------------------------
            */

            RecheckResult::where(
                'status',
                'pending'
            )->delete();

            /*
            |--------------------------------------------------------------------------
            | 4. CACHE DATA PPKS
            |--------------------------------------------------------------------------
            */

            $existingPpks = Ppks::orderByDesc('sheet_row')->get();

            $existingByNik = [];
            $existingByIdentity = [];

            foreach ($existingPpks as $ppks) {
                if (!is_array($ppks->data)) {
                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | CACHE NIK
                |--------------------------------------------------------------------------
                */

                $nik = $this->normalizeNik(
                    $ppks->data[2] ?? ''
                );

                if (
                    $nik !== '' &&
                    !isset($existingByNik[$nik])
                ) {
                    $existingByNik[$nik] = $ppks;
                }

                /*
                |--------------------------------------------------------------------------
                | CACHE IDENTITAS PERSIS
                |--------------------------------------------------------------------------
                */

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
            | 5. COUNTER
            |--------------------------------------------------------------------------
            */

            $normal = 0;
            $perluDiperiksa = 0;
            $newData = 0;

            /*
            |--------------------------------------------------------------------------
            | 6. CEK SATU PER SATU
            |--------------------------------------------------------------------------
            */

            foreach ($latestByNik as $nik => $item) {
                $row = $item['data'];
                $sheetRow = $item['sheet_row'];

                $newIdentity = $this->getIdentity($row);

                $identityKey = $this->identityKey(
                    $newIdentity
                );

                /*
                |--------------------------------------------------------------------------
                | CARI BERDASARKAN NIK
                |--------------------------------------------------------------------------
                */

                $existing = $existingByNik[$nik] ?? null;

                /*
                |--------------------------------------------------------------------------
                | ATURAN 1
                | NIK SAMA + IDENTITAS SAMA
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
                        $normal++;

                        continue;
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | ATURAN 2
                    | NIK SAMA + IDENTITAS BERBEDA
                    |--------------------------------------------------------------------------
                    */

                    /*
                    | Sebelum dianggap berbeda total,
                    | cek dulu apakah identitas sebenarnya MIRIP.
                    */

                    $similar = $this->findSimilarIdentity(
                        $newIdentity,
                        collect([$existing])
                    );

                    if ($similar) {
                        RecheckResult::create([
                            'ppks_id' => $existing->id,
                            'sheet_row' => $sheetRow,
                            'data' => $row,
                            'jenis' =>
                                'NIK sama tetapi identitas mirip',
                            'status' => 'pending',
                        ]);
                    } else {
                        RecheckResult::create([
                            'ppks_id' => $existing->id,
                            'sheet_row' => $sheetRow,
                            'data' => $row,
                            'jenis' =>
                                'NIK sama tetapi identitas berbeda',
                            'status' => 'pending',
                        ]);
                    }

                    $perluDiperiksa++;

                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | NIK BERBEDA
                |--------------------------------------------------------------------------
                */

                $possibleDuplicate = null;

                /*
                |--------------------------------------------------------------------------
                | 1. CARI IDENTITAS PERSIS
                |--------------------------------------------------------------------------
                */

                if ($identityKey !== null) {
                    $possibleDuplicate =
                        $existingByIdentity[$identityKey] ?? null;
                }

                /*
                |--------------------------------------------------------------------------
                | 2. JIKA TIDAK ADA, CARI IDENTITAS MIRIP
                |--------------------------------------------------------------------------
                */

                $isSimilar = false;

                if (!$possibleDuplicate) {
                    $possibleDuplicate =
                        $this->findSimilarIdentity(
                            $newIdentity,
                            $existingPpks
                        );

                    if ($possibleDuplicate) {
                        $isSimilar = true;
                    }
                }

                /*
                |--------------------------------------------------------------------------
                | ATURAN 3
                | NIK BERBEDA + IDENTITAS SAMA
                | ATAU IDENTITAS MIRIP
                |--------------------------------------------------------------------------
                */

                if ($possibleDuplicate) {
                    RecheckResult::create([
                        'ppks_id' => $possibleDuplicate->id,
                        'sheet_row' => $sheetRow,
                        'data' => $row,
                        'jenis' => $isSimilar
                            ? 'Identitas mirip tetapi NIK berbeda'
                            : 'Identitas sama tetapi NIK berbeda',
                        'status' => 'pending',
                    ]);

                    $perluDiperiksa++;

                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | ATURAN 4
                | NIK BERBEDA + IDENTITAS BERBEDA
                |--------------------------------------------------------------------------
                */

                RecheckResult::create([
                    'ppks_id' => null,
                    'sheet_row' => $sheetRow,
                    'data' => $row,
                    'jenis' => 'Data baru',
                    'status' => 'pending',
                ]);

                $newData++;
            }

            /*
            |--------------------------------------------------------------------------
            | 7. LOG
            |--------------------------------------------------------------------------
            */

            $importLog->update([
                'finished_at' => now(),
                'data_ditemukan' => count($rows),
                'nik_unik' => count($latestByNik),
                'data_normal' => $normal,
                'data_perlu_diperiksa' => $perluDiperiksa,
                'data_diupdate' => 0,
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
    | CARI DATA BERDASARKAN NIK
    |--------------------------------------------------------------------------
    */

    private function findByNik(string $nik): ?Ppks
    {
        $allPpks = Ppks::orderByDesc('sheet_row')->get();

        foreach ($allPpks as $ppks) {
            if (!is_array($ppks->data)) {
                continue;
            }

            $oldNik = $this->normalizeNik(
                $ppks->data[2] ?? ''
            );

            if ($oldNik === $nik) {
                return $ppks;
            }
        }

        return null;
    }

    /*
    |--------------------------------------------------------------------------
    | CARI DATA BERDASARKAN IDENTITAS
    |--------------------------------------------------------------------------
    */

    private function findByIdentity(array $identity): ?Ppks
    {
        $allPpks = Ppks::orderByDesc('sheet_row')->get();

        foreach ($allPpks as $ppks) {
            if (!is_array($ppks->data)) {
                continue;
            }

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
    | CARI IDENTITAS MIRIP
    |--------------------------------------------------------------------------
    |
    | Kriteria:
    |
    | - Nama minimal 85% mirip
    | - Jenis kelamin harus sama jika keduanya tersedia
    | - Tempat lahir harus sama jika keduanya tersedia
    | - Tanggal lahir harus sama jika keduanya tersedia
    |
    */

    private function findSimilarIdentity(
        array $identity,
        $allPpks
    ): ?Ppks {
        if ($identity['nama'] === '') {
            return null;
        }

        foreach ($allPpks as $ppks) {
            if (!is_array($ppks->data)) {
                continue;
            }

            /*
            | Jangan membandingkan dengan record duplikat.
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
            |--------------------------------------------------------------------------
            | HITUNG KEMIRIPAN NAMA
            |--------------------------------------------------------------------------
            */

            similar_text(
                $identity['nama'],
                $oldIdentity['nama'],
                $namePercent
            );

            /*
            | Minimal 85% kemiripan nama.
            */

            if ($namePercent < 85) {
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | JENIS KELAMIN
            |--------------------------------------------------------------------------
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
            |--------------------------------------------------------------------------
            | TEMPAT LAHIR
            |--------------------------------------------------------------------------
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
            |--------------------------------------------------------------------------
            | TANGGAL LAHIR
            |--------------------------------------------------------------------------
            */

            if (
                $identity['tanggal_lahir'] !== '' &&
                $oldIdentity['tanggal_lahir'] !== '' &&
                $identity['tanggal_lahir'] !==
                    $oldIdentity['tanggal_lahir']
            ) {
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | DITEMUKAN
            |--------------------------------------------------------------------------
            */

            return $ppks;
        }

        return null;
    }

    /*
    |--------------------------------------------------------------------------
    | IDENTITY KEY
    |--------------------------------------------------------------------------
    */

    private function identityKey(array $identity): ?string
    {
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
    | AMBIL IDENTITAS
    |--------------------------------------------------------------------------
    |
    | B = Nama
    | D = Jenis Kelamin
    | E = Tempat Lahir
    | F = Tanggal Lahir
    |
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
    | BANDINGKAN IDENTITAS PERSIS
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

    private function normalizeNik($value): string
    {
        return preg_replace(
            '/[^0-9]/',
            '',
            trim((string) $value)
        );
    }

    /*
    |--------------------------------------------------------------------------
    | NORMALIZE TEXT
    |--------------------------------------------------------------------------
    */

    private function normalize($value): string
    {
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
