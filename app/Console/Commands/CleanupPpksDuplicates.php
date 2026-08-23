<?php

namespace App\Console\Commands;

use App\Models\Ppks;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CleanupPpksDuplicates extends Command
{
    protected $signature = 'ppks:cleanup-duplicates';

    protected $description = 'Membersihkan duplikat PPKS berdasarkan NIK dan mempertahankan respons terakhir';

    public function handle(): int
    {
        $ppks = Ppks::orderBy('sheet_row')->get();

        $groups = [];

        /*
        |--------------------------------------------------------------------------
        | 1. Kelompokkan data berdasarkan NIK
        |--------------------------------------------------------------------------
        */

        foreach ($ppks as $item) {

            $data = $item->data;

            if (!is_array($data)) {
                continue;
            }

            $nik = $this->normalize($data[2] ?? '');

            if ($nik === '') {
                continue;
            }

            $groups[$nik][] = $item;
        }

        $duplicateGroups = 0;
        $deleted = 0;
        $kept = 0;

        /*
        |--------------------------------------------------------------------------
        | 2. Proses setiap kelompok NIK
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $groups,
            &$duplicateGroups,
            &$deleted,
            &$kept
        ) {

            foreach ($groups as $nik => $items) {

                /*
                | Kalau NIK hanya muncul sekali,
                | tidak ada duplikat.
                */

                if (count($items) <= 1) {
                    continue;
                }

                $duplicateGroups++;

                /*
                |--------------------------------------------------------------------------
                | Respons terakhir = sheet_row terbesar
                |--------------------------------------------------------------------------
                */

                $latest = collect($items)
                    ->sortByDesc('sheet_row')
                    ->first();

                $kept++;

                /*
                |--------------------------------------------------------------------------
                | Hapus semua record lama.
                |--------------------------------------------------------------------------
                */

                foreach ($items as $item) {

                    if ($item->id === $latest->id) {
                        continue;
                    }

                    $item->delete();

                    $deleted++;
                }
            }
        });

        /*
        |--------------------------------------------------------------------------
        | 3. Hasil
        |--------------------------------------------------------------------------
        */

        $totalAfter = Ppks::count();

        $this->newLine();

        $this->info('==============================================');
        $this->info('       CLEANUP DUPLIKAT PPKS SELESAI');
        $this->info('==============================================');

        $this->line(
            'Kelompok NIK duplikat diproses : ' .
            $duplicateGroups
        );

        $this->line(
            'Data terbaru dipertahankan      : ' .
            $kept
        );

        $this->line(
            'Data duplikat dihapus           : ' .
            $deleted
        );

        $this->line(
            'Total data sekarang              : ' .
            $totalAfter
        );

        $this->newLine();

        $this->warn(
            'Data dengan NIK berbeda tetapi identitas sama TIDAK dihapus.'
        );

        $this->info('==============================================');

        return self::SUCCESS;
    }

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
