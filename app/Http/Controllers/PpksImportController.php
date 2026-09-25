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
    |
    | ATURAN IMPORT:
    |
    | 1. NIK sama + identitas sama
    |    -> ambil respons terakhir
    |
    | 2. NIK sama + identitas berbeda
    |    -> perlu pemeriksaan admin
    |       tidak overwrite data lama
    |
    | 3. NIK berbeda + identitas sama
    |    -> perlu pemeriksaan admin
    |       tidak otomatis dihapus
    |
    | 4. NIK berbeda + identitas berbeda
    |    -> data baru
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
             * HANYA ambil sheet_row milik data Google Sheet.
             *
             * Data manual mempunyai:
             * sheet_row = null
             * imported_at = null
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
            | Ambil response terbaru berdasarkan NIK
            |--------------------------------------------------------------------------
            */

            $latestByNik = [];

            foreach ($rows as $index => $row) {

                $nik = $this->normalizeNik(
                    $row[2] ?? ''
                );

                /*
                 * Kalau NIK kosong, tetap diproses sebagai data baru.
                 */
                if ($nik === '') {
                    $latestByNik['row_' . $index] = [
                        'row' => $row,
                        'index' => $index,
                    ];

                    continue;
                }

                $latestByNik[$nik] = [
                    'row' => $row,
                    'index' => $index,
                ];
            }

            /*
            |--------------------------------------------------------------------------
            | Cache data PPKS yang sudah ada
            |--------------------------------------------------------------------------
            */

            $existingPpks = Ppks::orderByDesc('sheet_row')
                ->get();

            $existingByNik = [];

            foreach ($existingPpks as $ppks) {

                $nik = $this->getNikFromData(
                    $ppks->data ?? []
                );

                if ($nik !== '') {
                    $existingByNik[$nik] = $ppks;
                }
            }

            /*
            |--------------------------------------------------------------------------
            | PROSES SETIAP DATA
            |--------------------------------------------------------------------------
            */

            $inserted = 0;
            $updated = 0;
            $perluDiperiksa = 0;
            $sudahAda = 0;
            $duplikatSheet = 0;

            foreach ($latestByNik as $item) {

                $row = $item['row'];
                $index = $item['index'];

                /*
                 * Row Google Sheet sebenarnya:
                 *
                 * startRow + index
                 */
                $sheetRow = $startRow + $index;

                /*
                 * Ubah array numerik Google Sheet
                 * menjadi array associative.
                 */
                $data = $this->mapSheetRowToData($row);

                $nik = $this->normalizeNik(
                    $data['nik'] ?? ''
                );

                /*
                 * Cari berdasarkan NIK
                 */
                $existing = null;

                if ($nik !== '') {
                    $existing = $existingByNik[$nik] ?? null;
                }

                /*
                 * Cari berdasarkan IDENTITAS
                 */
                $sameIdentity = $this->findByIdentity(
                    $data,
                    $existingPpks
                );

                /*
                |--------------------------------------------------------------------------
                | RULE 1
                |
                | NIK sama + identitas sama
                | = update data lama
                |--------------------------------------------------------------------------
                */

                if (
                    $existing &&
                    $this->sameIdentity(
                        $existing->data ?? [],
                        $data
                    )
                ) {

                    $existing->update([
                        'sheet_row' => $sheetRow,
                        'data' => $data,
                        'status' => 'normal',
                        'imported_at' => now(),
                    ]);

                    $updated++;

                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | RULE 2
                |
                | NIK sama + identitas berbeda
                | = perlu pemeriksaan
                |--------------------------------------------------------------------------
                */

                if (
                    $existing &&
                    !$this->sameIdentity(
                        $existing->data ?? [],
                        $data
                    )
                ) {

                    Ppks::create([
                        'sheet_row' => $sheetRow,
                        'data' => $data,
                        'status' => 'perlu_diperiksa',
                        'possible_duplicate_of' => $existing->id,
                        'duplicate_note' =>
                            'NIK sama tetapi nama berbeda.',

                        'imported_at' =>
                            now(),
                    ]);

                    $perluDiperiksa++;

                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | RULE 3
                |
                | NIK berbeda + identitas sama
                | = perlu pemeriksaan
                |--------------------------------------------------------------------------
                */

                if ($sameIdentity) {

                    Ppks::create([
                        'sheet_row' => $sheetRow,
                        'data' => $data,
                        'status' => 'perlu_diperiksa',
                        'possible_duplicate_of' =>
                            $sameIdentity->id,

                        'duplicate_note' =>
                            'Identitas sama tetapi NIK berbeda.',

                        'imported_at' =>
                            now(),
                    ]);

                    $perluDiperiksa++;

                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | RULE 4
                |
                | NIK berbeda + identitas berbeda
                | = data baru normal
                |--------------------------------------------------------------------------
                */

                Ppks::create([
                    'sheet_row' => $sheetRow,
                    'data' => $data,
                    'status' => 'normal',
                    'imported_at' => now(),
                ]);

                $inserted++;
            }

            /*
            |--------------------------------------------------------------------------
            | LOG
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
                    count($latestByNik),

                'data_normal' =>
                    $inserted,

                'data_perlu_diperiksa' =>
                    $perluDiperiksa,

                'data_diupdate' =>
                    $updated,
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
                    $updated,

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
                'message' => 'Import gagal: ' . $e->getMessage(),
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
            | Ambil response terbaru berdasarkan NIK
            |--------------------------------------------------------------------------
            */

            $latestByNik = [];

            foreach ($rows as $index => $row) {

                $nik = $this->normalizeNik(
                    $row[2] ?? ''
                );

                /*
                 * Kalau NIK kosong, tetap diproses sebagai data baru.
                 */
                if ($nik === '') {

                    $latestByNik['row_' . $index] = [
                        'row' => $row,
                        'index' => $index,
                    ];

                    continue;
                }

                $latestByNik[$nik] = [
                    'row' => $row,
                    'index' => $index,
                ];
            }

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

            $existingPpks = Ppks::orderByDesc('sheet_row')
                ->get();

            foreach ($latestByNik as $item) {

                $row = $item['row'];
                $index = $item['index'];

                $data = $this->mapSheetRowToData($row);

                $nik =
                    $this->normalizeNik(
                        $data['nik'] ?? ''
                    );

                $existing = null;

                foreach ($existingPpks as $ppks) {

                    $existingNik = $this->getNikFromData(
                        $ppks->data ?? []
                    );

                    if (
                        $nik !== '' &&
                        $nik === $existingNik
                    ) {
                        $existing = $ppks;
                        break;
                    }
                }

                /*
                 * Tentukan hasil recheck
                 */

                if ($existing) {

                    /*
                     * NIK sama + identitas sama
                     * = data normal
                     */
                    if (
                        $this->sameIdentity(
                            $existing->data ?? [],
                            $data
                        )
                    ) {

                        $status = 'normal';

                    } else {

                        /*
                         * NIK sama + identitas berbeda
                         * = perlu pemeriksaan
                         */
                        $sameNik = $this->findByNik(
                            $nik,
                            $existingPpks
                        );

                        if ($sameNik) {
                            $status = 'perlu_diperiksa';
                        } else {
                            $status = 'normal';
                        }
                    }

                } else {

                    /*
                     * Tidak ditemukan NIK yang sama.
                     *
                     * Cek apakah identitas sama
                     * tetapi NIK berbeda.
                     */
                    $sameIdentity = $this->findByIdentity(
                        $data,
                        $existingPpks
                    );

                    if ($sameIdentity) {
                        $status = 'perlu_diperiksa';
                    } else {
                        $status = 'normal';
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

            /*
             * Jangan membandingkan data dengan dirinya sendiri
             * jika suatu saat collection berisi row yang sama.
             */

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
    |
    | Mencari data dengan identitas yang sama persis:
    |
    | - Nama
    | - Jenis Kelamin
    | - Tempat Lahir
    | - Tanggal Lahir
    |
    */

    private function findByIdentity(
        array $data,
        $ppksCollection
    ): ?Ppks {

        $identity = $this->getIdentity($data);

        $identityKey = $this->identityKey($identity);

        if ($identityKey === null) {
            return null;
        }

        foreach ($ppksCollection as $ppks) {

            $existingIdentity = $this->getIdentity(
                $ppks->data ?? []
            );

            $existingKey = $this->identityKey(
                $existingIdentity
            );

            if (
                $existingKey !== null &&
                $existingKey === $identityKey
            ) {
                return $ppks;
            }
        }

        return null;
    }

    /*
    |--------------------------------------------------------------------------
    | FIND SIMILAR IDENTITY
    |--------------------------------------------------------------------------
    */

    private function findSimilarIdentity(
        array $data,
        $ppksCollection
    ): ?Ppks {

        $identity = $this->getIdentity($data);

        foreach ($ppksCollection as $ppks) {

            $existingIdentity = $this->getIdentity(
                $ppks->data ?? []
            );

            if (
                $identity['nama'] === '' ||
                $existingIdentity['nama'] === ''
            ) {
                continue;
            }

            similar_text(
                $identity['nama'],
                $existingIdentity['nama'],
                $percentage
            );

            if ($percentage < 85) {
                continue;
            }

            if (
                $identity['jenis_kelamin'] !== '' &&
                $existingIdentity['jenis_kelamin'] !== '' &&
                $identity['jenis_kelamin'] !==
                $existingIdentity['jenis_kelamin']
            ) {
                continue;
            }

            if (
                $identity['tempat_lahir'] !== '' &&
                $existingIdentity['tempat_lahir'] !== '' &&
                $identity['tempat_lahir'] !==
                $existingIdentity['tempat_lahir']
            ) {
                continue;
            }

            if (
                $identity['tanggal_lahir'] !== '' &&
                $existingIdentity['tanggal_lahir'] !== '' &&
                $identity['tanggal_lahir'] !==
                $existingIdentity['tanggal_lahir']
            ) {
                continue;
            }

            return $ppks;
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
        /*
         * FORMAT BARU
         */
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

        /*
         * FORMAT LAMA
         */
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