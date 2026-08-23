<?php

namespace App\Console\Commands;

use App\Models\Ppks;
use Illuminate\Console\Command;

class MarkPpksDuplicates extends Command
{
    protected $signature = 'ppks:mark-duplicates';

    protected $description = 'Menandai kemungkinan duplikat PPKS untuk pemeriksaan admin';

    public function handle(): int
    {
        $ppks = Ppks::orderBy('sheet_row')->get();

        /*
        |--------------------------------------------------------------------------
        | Kelompokkan data berdasarkan identitas
        |--------------------------------------------------------------------------
        |
        | Identitas:
        | Nama + Jenis Kelamin + Tempat Lahir + Tanggal Lahir
        |
        */

        $groups = [];

        foreach ($ppks as $ppksData) {

            $data = $ppksData->data;

            if (!is_array($data)) {
                continue;
            }

            $identity = $this->getIdentity($data);

            if (!$this->identityComplete($identity)) {
                continue;
            }

            $key = implode('|', [
                $identity['nama'],
                $identity['jenis_kelamin'],
                $identity['tempat_lahir'],
                $identity['tanggal_lahir'],
            ]);

            $groups[$key][] = $ppksData;
        }

        $marked = 0;
        $groupsFound = 0;

        /*
        |--------------------------------------------------------------------------
        | Periksa setiap kelompok
        |--------------------------------------------------------------------------
        */

        foreach ($groups as $group) {

            /*
            | Hanya perlu diperiksa kalau ada lebih dari satu record.
            */

            if (count($group) < 2) {
                continue;
            }

            /*
            | Kumpulkan NIK yang berbeda.
            */

            $niks = [];

            foreach ($group as $item) {

                $data = $item->data;

                $nik = $this->normalize(
                    $data[2] ?? ''
                );

                if ($nik !== '') {
                    $niks[$nik] = true;
                }
            }

            /*
            | Kalau semua NIK sama, ini bukan kasus
            | NIK berbeda + identitas sama.
            */

            if (count($niks) < 2) {
                continue;
            }

            $groupsFound++;

            /*
            |--------------------------------------------------------------------------
            | Tandai data yang NIK-nya berbeda
            |--------------------------------------------------------------------------
            */

            $first = $group[0];

            foreach ($group as $item) {

                /*
                | Kalau sudah pernah ditandai, jangan timpa.
                */

                if ($item->status === 'perlu_diperiksa') {
                    continue;
                }

                $item->update([
                    'status' => 'perlu_diperiksa',
                    'possible_duplicate_of' => $first->id,
                    'duplicate_note' =>
                        'Identitas sama tetapi NIK berbeda. Perlu pemeriksaan admin.',
                ]);

                $marked++;
            }
        }

        $this->newLine();

        $this->info('==============================================');
        $this->info('       PENANDAAN DUPLIKAT PPKS');
        $this->info('==============================================');

        $this->line(
            'Kelompok kemungkinan duplikat : ' . $groupsFound
        );

        $this->line(
            'Data ditandai perlu diperiksa  : ' . $marked
        );

        $this->line(
            'Total data sekarang            : ' . Ppks::count()
        );

        $this->newLine();

        $this->warn(
            'Tidak ada data yang dihapus.'
        );

        $this->info('==============================================');

        return self::SUCCESS;
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
    | Pastikan semua identitas tersedia
    |--------------------------------------------------------------------------
    */

    private function identityComplete(array $identity): bool
    {
        return
            $identity['nama'] !== '' &&
            $identity['jenis_kelamin'] !== '' &&
            $identity['tempat_lahir'] !== '' &&
            $identity['tanggal_lahir'] !== '';
    }

    /*
    |--------------------------------------------------------------------------
    | Normalisasi
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
