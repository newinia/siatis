<?php

namespace App\Console\Commands;

use App\Models\Ppks;
use App\Services\GoogleSheetService;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:restore-missing-ppks')]
#[Description('Mengembalikan baris PPKS yang hilang dari Google Sheet')]
class RestoreMissingPpks extends Command
{
    public function handle(
        GoogleSheetService $googleSheetService
    ): int {

        $this->info('Memulai pemulihan data PPKS yang hilang...');

        $spreadsheetId =
            '1uWDJthPz5yW61BPWG5v1FhcyAHekXpSfWsFGBxJr1pM';

        $sheetName = 'Form Responses 1';

        /*
        |--------------------------------------------------------------------------
        | BATAS DATA GOOGLE SHEET
        |--------------------------------------------------------------------------
        */

        $maxSheetRow = 1430;

        /*
        |--------------------------------------------------------------------------
        | 1. Ambil semua sheet_row yang sudah ada
        |--------------------------------------------------------------------------
        */

        $existingRows = Ppks::pluck('sheet_row')
            ->map(fn ($row) => (int) $row)
            ->flip();

        /*
        |--------------------------------------------------------------------------
        | 2. Cari sheet_row yang hilang
        |--------------------------------------------------------------------------
        */

        $missingRows = [];

        for ($row = 2; $row <= $maxSheetRow; $row++) {

            if (!$existingRows->has($row)) {
                $missingRows[] = $row;
            }
        }

        $this->info(
            'Jumlah baris yang belum ada: '
            . count($missingRows)
        );

        if (empty($missingRows)) {

            $this->info(
                'Semua baris Google Sheet sudah ada di database.'
            );

            return self::SUCCESS;
        }

        /*
        |--------------------------------------------------------------------------
        | 3. Kelompokkan baris hilang menjadi rentang
        |--------------------------------------------------------------------------
        |
        | Contoh:
        |
        | 100,101,102,103
        |
        | menjadi:
        |
        | 100-103
        |
        | Sehingga kita tidak melakukan 4 request API.
        |
        */

        $ranges = $this->makeRanges($missingRows);

        $this->info(
            'Jumlah rentang yang akan dibaca: '
            . count($ranges)
        );

        $restored = 0;
        $failed = 0;

        /*
        |--------------------------------------------------------------------------
        | 4. Ambil data per rentang
        |--------------------------------------------------------------------------
        */

        foreach ($ranges as $range) {

            $startRow = $range['start'];
            $endRow = $range['end'];

            try {

                $this->line(
                    "Mengambil baris {$startRow} - {$endRow}..."
                );

                /*
                |--------------------------------------------------------------------------
                | Satu request untuk satu rentang
                |--------------------------------------------------------------------------
                */

                $rows = $googleSheetService->getRows(
                    $spreadsheetId,
                    $sheetName,
                    $startRow,
                    $endRow - $startRow + 1
                );

                /*
                |--------------------------------------------------------------------------
                | 5. Simpan setiap baris
                |--------------------------------------------------------------------------
                */

                foreach ($rows as $index => $row) {

                    if (empty($row)) {
                        continue;
                    }

                    $sheetRow = $startRow + $index;

                    /*
                    |--------------------------------------------------------------------------
                    | Pastikan sheet_row belum ada
                    |--------------------------------------------------------------------------
                    */

                    if (
                        Ppks::where(
                            'sheet_row',
                            $sheetRow
                        )->exists()
                    ) {
                        continue;
                    }

                    Ppks::create([
                        'sheet_row' => $sheetRow,
                        'data' => $row,

                        /*
                        |--------------------------------------------------------------------------
                        | Untuk sementara normal.
                        | Setelah semua data masuk,
                        | baru jalankan deteksi duplikat.
                        |--------------------------------------------------------------------------
                        */

                        'status' => 'normal',

                        'possible_duplicate_of' => null,
                        'duplicate_note' => null,

                        'selected_for_assessment' => false,
                        'selected_from_duplicate_id' => null,
                        'duplicate_decision' => null,

                        'imported_at' => now(),
                    ]);

                    $restored++;
                }

            } catch (\Throwable $e) {

                $failed++;

                $this->error(
                    "Gagal mengambil rentang "
                    . "{$startRow}-{$endRow}: "
                    . $e->getMessage()
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | 6. Hasil
        |--------------------------------------------------------------------------
        */

        $this->newLine();

        $this->info('Pemulihan selesai.');

        $this->table(
            [
                'Keterangan',
                'Jumlah',
            ],
            [
                [
                    'Baris hilang',
                    count($missingRows),
                ],
                [
                    'Rentang',
                    count($ranges),
                ],
                [
                    'Berhasil dipulihkan',
                    $restored,
                ],
                [
                    'Rentang gagal',
                    $failed,
                ],
                [
                    'Total database',
                    Ppks::count(),
                ],
            ]
        );

        $this->newLine();

        $this->warn(
            'Data yang baru dipulihkan masih berstatus normal.'
        );

        $this->warn(
            'Jangan jalankan deteksi duplikat sebelum seluruh data masuk.'
        );

        return self::SUCCESS;
    }

    /**
     * Mengubah daftar nomor baris menjadi rentang.
     */
    private function makeRanges(array $rows): array
    {
        sort($rows);

        $ranges = [];

        $start = null;
        $previous = null;

        foreach ($rows as $row) {

            if ($start === null) {

                $start = $row;
                $previous = $row;

                continue;
            }

            /*
            |----------------------------------------------------------------------
            | Kalau berurutan, lanjutkan rentang.
            |----------------------------------------------------------------------
            */

            if ($row === $previous + 1) {

                $previous = $row;

                continue;
            }

            /*
            |----------------------------------------------------------------------
            | Rentang selesai.
            |----------------------------------------------------------------------
            */

            $ranges[] = [
                'start' => $start,
                'end' => $previous,
            ];

            $start = $row;
            $previous = $row;
        }

        /*
        |--------------------------------------------------------------------------
        | Tambahkan rentang terakhir
        |--------------------------------------------------------------------------
        */

        if ($start !== null) {

            $ranges[] = [
                'start' => $start,
                'end' => $previous,
            ];
        }

        return $ranges;
    }
}
