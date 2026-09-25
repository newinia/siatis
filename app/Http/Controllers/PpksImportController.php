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
            'totalImported' => Ppks::where(
                'status',
                'normal'
            )->count(),

            'totalPerluDiperiksa' => Ppks::where(
                'status',
                'perlu_diperiksa'
            )->count(),

            'importLogs' => ImportLog::orderByDesc('created_at')
                ->take(20)
                ->get(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | PROCESS IMPORT
    |--------------------------------------------------------------------------
    */

    public function process(
        GoogleSheetService $googleSheetService
    ): RedirectResponse {
        $result = $this->import($googleSheetService);

        $data = $result->getData(true);

        if (($data['success'] ?? false) === true) {
            return redirect()
                ->route('ppks.import')
                ->with(
                    'success',
                    $data['message'] ?? 'Import berhasil.'
                );
        }

        return redirect()
            ->route('ppks.import')
            ->with(
                'error',
                $data['message'] ?? 'Import gagal.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | IMPORT GOOGLE SHEET
    |--------------------------------------------------------------------------
    |
    | ATURAN:
    |
    | 1. NIK sama + NAMA sama
    |    -> dianggap data yang sama
    |    -> jika muncul beberapa kali di Sheet,
    |       ambil BARIS TERAKHIR
    |
    | 2. NIK sama + NAMA sama dan sudah ada di DB
    |    -> jangan insert
    |
    | 3. NIK sama + NAMA berbeda
    |    -> perlu_diperiksa
    |
    | 4. NIK berbeda + identitas sama
    |    -> perlu_diperiksa
    |
    | 5. NIK berbeda + identitas berbeda
    |    -> normal
    |
    */

    public function import(
        GoogleSheetService $googleSheetService
    ): JsonResponse {
        $importLog = ImportLog::create([
            'status' => 'proses',
            'message' => 'Import sedang diproses.',
            'started_at' => now(),
        ]);

        try {

            /*
            |--------------------------------------------------------------------------
            | AMBIL ROW TERAKHIR YANG SUDAH DIPROSES
            |--------------------------------------------------------------------------
            */

            $lastImportedRow = Ppks::whereNotNull('sheet_row')
                ->whereNotNull('imported_at')
                ->where(function ($query) {
                    $query
                        ->whereNull('data->sumber_data')
                        ->orWhere(
                            'data->sumber_data',
                            'sheet'
                        );
                })
                ->max('sheet_row');

            $startRow = $lastImportedRow
                ? $lastImportedRow + 1
                : 2;

            /*
            |--------------------------------------------------------------------------
            | AMBIL DATA GOOGLE SHEET
            |--------------------------------------------------------------------------
            */

            $rows = $googleSheetService->getRows(
                $this->spreadsheetId,
                $this->sheetName,
                $startRow
            );

            /*
            |--------------------------------------------------------------------------
            | TIDAK ADA DATA BARU
            |--------------------------------------------------------------------------
            */

            if (empty($rows)) {
                $message =
                    'Tidak ada data baru dari Google Sheet.';

                $importLog->update([
                    'status' => 'berhasil',
                    'message' => $message,
                    'finished_at' => now(),
                ]);

                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'inserted' => 0,
                    'updated' => 0,
                    'perlu_diperiksa' => 0,
                    'sudah_ada' => 0,
                    'duplikat_sheet' => 0,
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | PASTIKAN 35 KOLOM
            |--------------------------------------------------------------------------
            */

            foreach ($rows as &$row) {
                $row = array_pad($row, 35, '');
            }

            unset($row);

            /*
            |--------------------------------------------------------------------------
            | AMBIL DATA YANG SUDAH ADA DI DATABASE
            |--------------------------------------------------------------------------
            */

            $existingPpks = Ppks::orderByDesc('sheet_row')
                ->get();

            /*
            |--------------------------------------------------------------------------
            | COLLECTION PEMBANDING
            |--------------------------------------------------------------------------
            |
            | Ini digunakan untuk membandingkan data berikutnya.
            |
            | Data baru yang sudah berhasil dibuat juga dimasukkan
            | supaya konflik antar-data dalam satu proses import
            | tetap bisa terdeteksi.
            |
            */

            $comparisonPpks = $existingPpks->values();

            /*
            |--------------------------------------------------------------------------
            | COUNTER
            |--------------------------------------------------------------------------
            */

            $inserted = 0;
            $perluDiperiksa = 0;
            $sudahAda = 0;
            $duplikatSheet = 0;

            /*
            |--------------------------------------------------------------------------
            | TAHAP 1
            |--------------------------------------------------------------------------
            | CARI DATA TERAKHIR DI DALAM GOOGLE SHEET
            |--------------------------------------------------------------------------
            |
            | KUNCI DUPLIKAT:
            |
            | NIK + NAMA
            |
            | Jadi kalau:
            |
            | Row 10 -> NIK 123, Budi
            | Row 20 -> NIK 123, Budi
            | Row 30 -> NIK 123, Budi
            |
            | yang dipakai hanya Row 30.
            |
            */

            $latestRows = [];

            foreach ($rows as $index => $row) {

                $sheetRow = $startRow + $index;

                $data = $this->mapSheetRowToData($row);

                $nik = $this->normalizeNik(
                    $data['nik'] ?? ''
                );

                $nama = $this->normalize(
                    $data['nama_lengkap'] ?? ''
                );

                /*
                |--------------------------------------------------------------------------
                | NIK + NAMA LENGKAP
                |--------------------------------------------------------------------------
                */

                if (
                    $nik !== '' &&
                    $nama !== ''
                ) {
                    $key =
                        'nik_nama|' .
                        $nik .
                        '|' .
                        $nama;
                } else {

                    /*
                    |--------------------------------------------------------------------------
                    | Kalau NIK atau nama kosong,
                    | jangan digabung dengan data lain.
                    |--------------------------------------------------------------------------
                    */

                    $key =
                        'row|' .
                        $sheetRow;
                }

                /*
                |--------------------------------------------------------------------------
                | Kalau key sudah ada,
                | berarti ada duplikat di Sheet.
                |
                | Karena kita berjalan dari atas ke bawah,
                | row terbaru otomatis menggantikan row lama.
                |--------------------------------------------------------------------------
                */

                if (isset($latestRows[$key])) {
                    $duplikatSheet++;
                }

                $latestRows[$key] = [
                    'sheetRow' => $sheetRow,
                    'data' => $data,
                ];
            }

            /*
            |--------------------------------------------------------------------------
            | URUTKAN BERDASARKAN SHEET ROW
            |--------------------------------------------------------------------------
            */

            uasort(
                $latestRows,
                fn ($a, $b) =>
                    $a['sheetRow'] <=> $b['sheetRow']
            );

            /*
            |--------------------------------------------------------------------------
            | TAHAP 2
            |--------------------------------------------------------------------------
            | PROSES DATA TERAKHIR SAJA
            |--------------------------------------------------------------------------
            */

            foreach ($latestRows as $item) {

                $sheetRow = $item['sheetRow'];

                $data = $item['data'];

                $nik = $this->normalizeNik(
                    $data['nik'] ?? ''
                );

                /*
                |--------------------------------------------------------------------------
                | CARI DATA DENGAN NIK + NAMA YANG SAMA
                |--------------------------------------------------------------------------
                |
                | Ini harus dicek PALING DULU.
                |
                | Kalau ketemu:
                |
                | -> data sudah ada
                | -> jangan insert
                | -> jangan perlu pemeriksaan
                |--------------------------------------------------------------------------
                */

                $sameNikAndName =
                    $this->findByNikAndName(
                        $data,
                        $comparisonPpks
                    );

                if ($sameNikAndName) {

                    $sudahAda++;

                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | CARI DATA DENGAN NIK YANG SAMA
                |--------------------------------------------------------------------------
                */

                $sameNik = $this->findByNik(
                    $nik,
                    $comparisonPpks
                );

                /*
                |--------------------------------------------------------------------------
                | RULE:
                |
                | NIK SAMA + NAMA BERBEDA
                |
                | -> PERLU DIPERIKSA
                |--------------------------------------------------------------------------
                */

                if ($sameNik) {

                    $duplicate = Ppks::create([
                        'sheet_row' =>
                            $sheetRow,

                        'data' =>
                            $data,

                        'status' =>
                            'perlu_diperiksa',

                        'possible_duplicate_of' =>
                            $sameNik->id,

                        'duplicate_note' =>
                            'NIK sama tetapi nama berbeda.',

                        'imported_at' =>
                            now(),
                    ]);

                    $comparisonPpks->prepend(
                        $duplicate
                    );

                    $perluDiperiksa++;

                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | NIK TIDAK DITEMUKAN
                |--------------------------------------------------------------------------
                |
                | Sekarang cari berdasarkan identitas.
                |
                | Identitas:
                |
                | - Nama
                | - Jenis Kelamin
                | - Tempat Lahir
                | - Tanggal Lahir
                |
                */

                $sameIdentity =
                    $this->findByIdentity(
                        $data,
                        $comparisonPpks
                    );

                /*
                |--------------------------------------------------------------------------
                | RULE:
                |
                | NIK BERBEDA + IDENTITAS SAMA
                |
                | -> PERLU DIPERIKSA
                |--------------------------------------------------------------------------
                */

                if ($sameIdentity) {

                    $duplicate = Ppks::create([
                        'sheet_row' =>
                            $sheetRow,

                        'data' =>
                            $data,

                        'status' =>
                            'perlu_diperiksa',

                        'possible_duplicate_of' =>
                            $sameIdentity->id,

                        'duplicate_note' =>
                            'Identitas sama tetapi NIK berbeda.',

                        'imported_at' =>
                            now(),
                    ]);

                    $comparisonPpks->prepend(
                        $duplicate
                    );

                    $perluDiperiksa++;

                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | RULE:
                |
                | NIK BERBEDA + IDENTITAS BERBEDA
                |
                | -> NORMAL
                |--------------------------------------------------------------------------
                */

                $newPpks = Ppks::create([
                    'sheet_row' =>
                        $sheetRow,

                    'data' =>
                        $data,

                    'status' =>
                        'normal',

                    'imported_at' =>
                        now(),
                ]);

                /*
                |--------------------------------------------------------------------------
                | Tambahkan ke collection pembanding.
                |--------------------------------------------------------------------------
                */

                $comparisonPpks->prepend(
                    $newPpks
                );

                $inserted++;
            }

            /*
            |--------------------------------------------------------------------------
            | BUAT PESAN HASIL IMPORT
            |--------------------------------------------------------------------------
            */

            $parts = [];

            if ($inserted > 0) {
                $parts[] =
                    "Data baru: {$inserted}";
            }

            if ($perluDiperiksa > 0) {
                $parts[] =
                    "Perlu pemeriksaan: {$perluDiperiksa}";
            }

            if ($sudahAda > 0) {
                $parts[] =
                    "Sudah ada di database: {$sudahAda}";
            }

            if ($duplikatSheet > 0) {
                $parts[] =
                    "Duplikat dalam Sheet: {$duplikatSheet} " .
                    "(diambil respons terakhir)";
            }

            if (empty($parts)) {
                $parts[] =
                    'Tidak ada perubahan data.';
            }

            $message =
                'Import selesai. ' .
                implode(', ', $parts) .
                '.';

            /*
            |--------------------------------------------------------------------------
            | LOG IMPORT
            |--------------------------------------------------------------------------
            */

            $importLog->update([
                'status' => 'berhasil',

                'message' => $message,

                'finished_at' => now(),

                'data_ditemukan' =>
                    count($rows),

                'nik_unik' =>
                    count($latestRows),

                'data_normal' =>
                    $inserted,

                'data_perlu_diperiksa' =>
                    $perluDiperiksa,

                'data_diupdate' =>
                    0,
            ]);

            /*
            |--------------------------------------------------------------------------
            | RESPONSE
            |--------------------------------------------------------------------------
            */

            return response()->json([
                'success' => true,

                'message' => $message,

                'inserted' =>
                    $inserted,

                'updated' =>
                    0,

                'perlu_diperiksa' =>
                    $perluDiperiksa,

                'sudah_ada' =>
                    $sudahAda,

                'duplikat_sheet' =>
                    $duplikatSheet,
            ]);

        } catch (Throwable $e) {

            /*
            |--------------------------------------------------------------------------
            | LOG ERROR
            |--------------------------------------------------------------------------
            */

            $importLog->update([
                'status' => 'gagal',

                'message' =>
                    $e->getMessage(),

                'finished_at' =>
                    now(),
            ]);

            return response()->json([
                'success' => false,

                'message' =>
                    'Import gagal: ' .
                    $e->getMessage(),
            ], 500);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | RECHECK
    |--------------------------------------------------------------------------
    */

    public function recheck(
        GoogleSheetService $googleSheetService
    ): RedirectResponse {
        try {

            /*
            |--------------------------------------------------------------------------
            | AMBIL SEMUA DATA GOOGLE SHEET
            |--------------------------------------------------------------------------
            */

            $rows = $googleSheetService->getRows(
                $this->spreadsheetId,
                $this->sheetName,
                2
            );

            if (empty($rows)) {
                return redirect()
                    ->route('ppks.import')
                    ->with(
                        'error',
                        'Tidak ada data dari Google Sheet.'
                    );
            }

            /*
            |--------------------------------------------------------------------------
            | PASTIKAN 35 KOLOM
            |--------------------------------------------------------------------------
            */

            foreach ($rows as &$row) {
                $row = array_pad($row, 35, '');
            }

            unset($row);

            /*
            |--------------------------------------------------------------------------
            | DATA DATABASE
            |--------------------------------------------------------------------------
            */

            $existingPpks = Ppks::orderByDesc('sheet_row')
                ->get();

            /*
            |--------------------------------------------------------------------------
            | HAPUS HASIL RECHECK PENDING
            |--------------------------------------------------------------------------
            */

            RecheckResult::where(
                'status',
                'pending'
            )->delete();

            /*
            |--------------------------------------------------------------------------
            | PROSES SEMUA ROW
            |--------------------------------------------------------------------------
            */

            foreach ($rows as $index => $row) {

                $data =
                    $this->mapSheetRowToData($row);

                $nik =
                    $this->normalizeNik(
                        $data['nik'] ?? ''
                    );

                /*
                |--------------------------------------------------------------------------
                | CARI NIK + NAMA TERLEBIH DAHULU
                |--------------------------------------------------------------------------
                */

                $sameNikAndName =
                    $this->findByNikAndName(
                        $data,
                        $existingPpks
                    );

                /*
                |--------------------------------------------------------------------------
                | KALAU SUDAH ADA PERSIS
                |--------------------------------------------------------------------------
                */

                if ($sameNikAndName) {

                    $status = 'normal';

                } else {

                    /*
                    |--------------------------------------------------------------------------
                    | CARI NIK
                    |--------------------------------------------------------------------------
                    */

                    $sameNik = $this->findByNik(
                        $nik,
                        $existingPpks
                    );

                    if ($sameNik) {

                        /*
                        |--------------------------------------------------------------------------
                        | NIK sama + nama berbeda
                        |--------------------------------------------------------------------------
                        */

                        $status =
                            'perlu_diperiksa';

                    } else {

                        /*
                        |--------------------------------------------------------------------------
                        | NIK berbeda
                        |--------------------------------------------------------------------------
                        */

                        $sameIdentity =
                            $this->findByIdentity(
                                $data,
                                $existingPpks
                            );

                        if ($sameIdentity) {

                            $status =
                                'perlu_diperiksa';

                        } else {

                            $status =
                                'normal';
                        }
                    }
                }

                /*
                |--------------------------------------------------------------------------
                | SIMPAN HASIL RECHECK
                |--------------------------------------------------------------------------
                */

                RecheckResult::create([
                    'sheet_row' =>
                        2 + $index,

                    'data' =>
                        $data,

                    'jenis' =>
                        'sheet',

                    'status' =>
                        $status,
                ]);
            }

            return redirect()
                ->route('ppks.import')
                ->with(
                    'success',
                    'Recheck data berhasil dilakukan.'
                );

        } catch (Throwable $e) {

            return redirect()
                ->route('ppks.import')
                ->with(
                    'error',
                    'Recheck gagal: ' .
                    $e->getMessage()
                );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | MAPPING GOOGLE SHEET
    |--------------------------------------------------------------------------
    */

    private function mapSheetRowToData(array $row): array
    {
        return [
            'timestamp' =>
                $row[0] ?? '',

            'nama_lengkap' =>
                $row[1] ?? '',

            'nik' =>
                $row[2] ?? '',

            'jenis_kelamin' =>
                $row[3] ?? '',

            'tempat_lahir' =>
                $row[4] ?? '',

            'tanggal_lahir' =>
                $row[5] ?? '',

            'usia' =>
                $row[6] ?? '',

            'alamat_lengkap' =>
                $row[7] ?? '',

            'provinsi' =>
                $row[8] ?? '',

            'kabupaten' =>
                $row[9] ?? '',

            'pendidikan_terakhir' =>
                $row[10] ?? '',

            'keterangan_pendidikan' =>
                $row[11] ?? '',

            'jenis_ppks' =>
                $row[12] ?? '',

            'keterangan_disabilitas' =>
                $row[13] ?? '',

            'jurusan_yang_diminati' =>
                $row[14] ?? '',

            'upload_ktp' =>
                $row[15] ?? '',

            'upload_kk' =>
                $row[16] ?? '',

            'upload_ijazah_terakhir' =>
                $row[17] ?? '',

            'upload_foto_full_badan' =>
                $row[18] ?? '',

            'pelatihan_kursus' =>
                $row[19] ?? '',

            'no_hp_1' =>
                $row[20] ?? '',

            'email' =>
                $row[21] ?? '',

            'kemampuan_membaca_menulis' =>
                $row[22] ?? '',

            'aktivitas_sehari_hari' =>
                $row[23] ?? '',

            'bersedia_pelatihan_vokasional' =>
                $row[24] ?? '',

            'upload_video' =>
                $row[25] ?? '',

            'kondisi_kesehatan' =>
                $row[26] ?? '',

            'peminatan' =>
                $row[27] ?? '',

            'alumni_stis' =>
                $row[28] ?? '',

            'kecamatan' =>
                $row[29] ?? '',

            'kelurahan' =>
                $row[30] ?? '',

            'no_hp_2' =>
                $row[31] ?? '',

            'no_hp_2_2' =>
                $row[32] ?? '',

            'nomor_kk' =>
                $row[33] ?? '',

            'upload_transkrip' =>
                $row[34] ?? '',

            'sumber_data' =>
                'sheet',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | AMBIL NIK
    |--------------------------------------------------------------------------
    */

    private function getNikFromData(array $data): string
    {
        if (isset($data['nik'])) {
            return $this->normalizeNik(
                $data['nik']
            );
        }

        return $this->normalizeNik(
            $data[2] ?? ''
        );
    }

    /*
    |--------------------------------------------------------------------------
    | FIND BY NIK + NAMA
    |--------------------------------------------------------------------------
    */

    private function findByNikAndName(
        array $data,
        $ppksCollection
    ): ?Ppks {

        $nik = $this->normalizeNik(
            $data['nik'] ?? ''
        );

        $nama = $this->normalize(
            $data['nama_lengkap'] ?? ''
        );

        if (
            $nik === '' ||
            $nama === ''
        ) {
            return null;
        }

        foreach ($ppksCollection as $ppks) {

            $existingNik =
                $this->getNikFromData(
                    $ppks->data ?? []
                );

            $existingNama =
                $this->normalize(
                    ($ppks->data ?? [])['nama_lengkap'] ?? ''
                );

            if (
                $existingNik !== '' &&
                $existingNama !== '' &&
                $existingNik === $nik &&
                $existingNama === $nama
            ) {
                return $ppks;
            }
        }

        return null;
    }

    /*
    |--------------------------------------------------------------------------
    | FIND BY NIK
    |--------------------------------------------------------------------------
    */

    private function findByNik(
        string $nik,
        $ppksCollection
    ): ?Ppks {

        $nik = $this->normalizeNik($nik);

        if ($nik === '') {
            return null;
        }

        foreach ($ppksCollection as $ppks) {

            $existingNik =
                $this->getNikFromData(
                    $ppks->data ?? []
                );

            if (
                $existingNik !== '' &&
                $existingNik === $nik
            ) {
                return $ppks;
            }
        }

        return null;
    }

    /*
    |--------------------------------------------------------------------------
    | FIND BY IDENTITY
    |--------------------------------------------------------------------------
    */

    private function findByIdentity(
        array $data,
        $ppksCollection
    ): ?Ppks {

        foreach ($ppksCollection as $ppks) {

            if (
                $this->sameIdentity(
                    $ppks->data ?? [],
                    $data
                )
            ) {
                return $ppks;
            }
        }

        return null;
    }

    /*
    |--------------------------------------------------------------------------
    | GET IDENTITY
    |--------------------------------------------------------------------------
    |
    | Identitas:
    |
    | - Nama
    | - Jenis Kelamin
    | - Tempat Lahir
    | - Tanggal Lahir
    |
    */

    private function getIdentity(array $data): array
    {
        if (isset($data['nama_lengkap'])) {

            return [
                'nama' =>
                    $this->normalize(
                        $data['nama_lengkap'] ?? ''
                    ),

                'jenis_kelamin' =>
                    $this->normalize(
                        $data['jenis_kelamin'] ?? ''
                    ),

                'tempat_lahir' =>
                    $this->normalize(
                        $data['tempat_lahir'] ?? ''
                    ),

                'tanggal_lahir' =>
                    $this->normalizeDate(
                        $data['tanggal_lahir'] ?? ''
                    ),
            ];
        }

        return [
            'nama' =>
                $this->normalize(
                    $data[1] ?? ''
                ),

            'jenis_kelamin' =>
                $this->normalize(
                    $data[3] ?? ''
                ),

            'tempat_lahir' =>
                $this->normalize(
                    $data[4] ?? ''
                ),

            'tanggal_lahir' =>
                $this->normalizeDate(
                    $data[5] ?? ''
                ),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | NORMALIZE DATE
    |--------------------------------------------------------------------------
    */

    private function normalizeDate($value): string
    {
        $value = trim((string) $value);

        if ($value === '') {
            return '';
        }

        /*
        |--------------------------------------------------------------------------
        | Kalau ada waktu setelah tanggal,
        | ambil bagian tanggal saja.
        |--------------------------------------------------------------------------
        */

        if (str_contains($value, ' ')) {
            $value = explode(' ', $value)[0];
        }

        $formats = [
            'd/m/Y',
            'm/d/Y',
            'Y-m-d',
            'd-m-Y',
            'm-d-Y',
            'd/m/y',
            'm/d/y',
        ];

        foreach ($formats as $format) {

            $date = \DateTime::createFromFormat(
                $format,
                $value
            );

            if (
                $date !== false &&
                $date->format($format) === $value
            ) {
                return $date->format('Y-m-d');
            }
        }

        return $this->normalize($value);
    }

    /*
    |--------------------------------------------------------------------------
    | IDENTITY KEY
    |--------------------------------------------------------------------------
    */

    private function identityKey(
        array $identity
    ): ?string {

        foreach ($identity as $value) {

            if ($value === '') {
                return null;
            }
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
    | SAME IDENTITY
    |--------------------------------------------------------------------------
    */

    private function sameIdentity(
        array $dataA,
        array $dataB
    ): bool {

        $identityA =
            $this->getIdentity($dataA);

        $identityB =
            $this->getIdentity($dataB);

        $keyA =
            $this->identityKey($identityA);

        $keyB =
            $this->identityKey($identityB);

        if (
            $keyA === null ||
            $keyB === null
        ) {
            return false;
        }

        return $keyA === $keyB;
    }

    /*
    |--------------------------------------------------------------------------
    | NORMALIZE NIK
    |--------------------------------------------------------------------------
    */

    private function normalizeNik($value): string
    {
        return preg_replace(
            '/\D/',
            '',
            (string) $value
        ) ?? '';
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
            '/\s+/',
            ' ',
            $value
        ) ?? '';

        return $value;
    }
}
