<?php

namespace App\Console\Commands;

use App\Models\Ppks;
use Illuminate\Console\Command;

class PreviewPpksCleanup extends Command
{
    protected $signature = 'ppks:preview-cleanup';

    protected $description = 'Preview pembersihan duplikat PPKS tanpa menghapus data';

    public function handle(): int
    {
        $ppks = Ppks::orderBy('sheet_row')->get();

        $groups = [];

        /*
        |--------------------------------------------------------------------------
        | Kelompokkan berdasarkan NIK
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
        $recordsToKeep = 0;
        $recordsToDelete = 0;

        foreach ($groups as $nik => $items) {

            if (count($items) <= 1) {
                continue;
            }

            $duplicateGroups++;

            /*
            |--------------------------------------------------------------------------
            | Cari respons terakhir
            |--------------------------------------------------------------------------
            |
            | sheet_row terbesar = respons paling baru
            |--------------------------------------------------------------------------
            */

            $latest = collect($items)
                ->sortByDesc('sheet_row')
                ->first();

            $recordsToKeep++;

            /*
            | Semua selain respons terakhir akan menjadi kandidat
            | untuk dihapus.
            */

            $recordsToDelete += count($items) - 1;
        }

        /*
        |--------------------------------------------------------------------------
        | Kemungkinan duplikat dengan NIK berbeda
        |--------------------------------------------------------------------------
        */

        $identityGroups = [];

        foreach ($ppks as $item) {

            $data = $item->data;

            if (!is_array($data)) {
                continue;
            }

            $nama = $this->normalize($data[1] ?? '');
            $jenisKelamin = $this->normalize($data[3] ?? '');
            $tempatLahir = $this->normalize($data[4] ?? '');
            $tanggalLahir = $this->normalize($data[5] ?? '');
            $nik = $this->normalize($data[2] ?? '');

            if (
                $nama === '' ||
                $jenisKelamin === '' ||
                $tempatLahir === '' ||
                $tanggalLahir === ''
            ) {
                continue;
            }

            $key = implode('|', [
                $nama,
                $jenisKelamin,
                $tempatLahir,
                $tanggalLahir,
            ]);

            $identityGroups[$key][] = $nik;
        }

        $possibleDuplicateGroups = 0;
        $possibleDuplicateRecords = 0;

        foreach ($identityGroups as $items) {

            $uniqueNik = collect($items)
                ->filter()
                ->unique()
                ->count();

            if (count($items) >= 2 && $uniqueNik > 1) {

                $possibleDuplicateGroups++;

                $possibleDuplicateRecords += count($items);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | HASIL PREVIEW
        |--------------------------------------------------------------------------
        */

        $this->newLine();

        $this->info('==============================================');
        $this->info('       PREVIEW CLEANUP DUPLIKAT PPKS');
        $this->info('==============================================');

        $this->line(
            'Total data sekarang              : ' . $ppks->count()
        );

        $this->line(
            'Kelompok NIK duplikat            : ' . $duplicateGroups
        );

        $this->line(
            'Data yang dipertahankan           : ' . $recordsToKeep
        );

        $this->line(
            'Data kandidat untuk dihapus       : ' . $recordsToDelete
        );

        $this->line(
            'Kelompok kemungkinan duplikat     : ' .
            $possibleDuplicateGroups
        );

        $this->line(
            'Record kemungkinan duplikat       : ' .
            $possibleDuplicateRecords
        );

        $this->newLine();

        $this->warn(
            'MODE PREVIEW: TIDAK ADA DATA YANG DIHAPUS.'
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
