<?php

namespace App\Console\Commands;

use App\Models\Ppks;
use Illuminate\Console\Command;

class CheckPpksDuplicates extends Command
{
    protected $signature = 'ppks:check-duplicates';

    protected $description = 'Mengecek jumlah duplikat PPKS tanpa menampilkan data pribadi';

    public function handle(): int
    {
        $ppks = Ppks::orderBy('sheet_row')->get();

        $total = $ppks->count();

        /*
        |--------------------------------------------------------------------------
        | 1. CEK NIK SAMA
        |--------------------------------------------------------------------------
        */

        $nikGroups = [];

        foreach ($ppks as $item) {

            $data = $item->data;

            if (!is_array($data)) {
                continue;
            }

            $nik = $this->normalize($data[2] ?? '');

            if ($nik === '') {
                continue;
            }

            $nikGroups[$nik][] = $item->id;
        }

        $duplicateNikGroups = collect($nikGroups)
            ->filter(fn ($items) => count($items) > 1);

        $duplicateNikRecords = $duplicateNikGroups
            ->flatten()
            ->count();

        /*
        |--------------------------------------------------------------------------
        | 2. CEK IDENTITAS SAMA TAPI NIK BERBEDA
        |--------------------------------------------------------------------------
        */

        $identityGroups = [];

        foreach ($ppks as $item) {

            $data = $item->data;

            if (!is_array($data)) {
                continue;
            }

            $nama = $this->normalize($data[1] ?? '');
            $nik = $this->normalize($data[2] ?? '');
            $jenisKelamin = $this->normalize($data[3] ?? '');
            $tempatLahir = $this->normalize($data[4] ?? '');
            $tanggalLahir = $this->normalize($data[5] ?? '');

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

            $identityGroups[$key][] = [
                'id' => $item->id,
                'nik' => $nik,
            ];
        }

        $possibleDuplicateGroups = collect($identityGroups)
            ->filter(function ($items) {

                if (count($items) < 2) {
                    return false;
                }

                $nikCount = collect($items)
                    ->pluck('nik')
                    ->filter()
                    ->unique()
                    ->count();

                return $nikCount > 1;
            });

        $possibleDuplicateRecords = $possibleDuplicateGroups
            ->flatten(1)
            ->count();

        /*
        |--------------------------------------------------------------------------
        | 3. DATA YANG MEMILIKI STATUS DUPLIKAT
        |--------------------------------------------------------------------------
        */

        $markedDuplicate = $ppks
            ->where('status', 'possible_duplicate')
            ->count();

        /*
        |--------------------------------------------------------------------------
        | 4. HASIL
        |--------------------------------------------------------------------------
        */

        $this->newLine();

        $this->info('==========================================');
        $this->info('       HASIL CEK DUPLIKAT PPKS');
        $this->info('==========================================');

        $this->line(
            'Total data diperiksa       : ' . $total
        );

        $this->line(
            'Kelompok NIK duplikat      : ' .
            $duplicateNikGroups->count()
        );

        $this->line(
            'Record dengan NIK duplikat : ' .
            $duplicateNikRecords
        );

        $this->line(
            'Kelompok identitas sama    : ' .
            $possibleDuplicateGroups->count()
        );

        $this->line(
            'Record kemungkinan duplikat: ' .
            $possibleDuplicateRecords
        );

        $this->line(
            'Sudah ditandai sistem      : ' .
            $markedDuplicate
        );

        $this->newLine();

        $this->comment(
            'Tidak ada data yang diubah atau dihapus.'
        );

        $this->info('==========================================');

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
