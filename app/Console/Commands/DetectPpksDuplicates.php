<?php

namespace App\Console\Commands;

use App\Models\Ppks;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

#[Signature('app:detect-ppks-duplicates')]
#[Description('Mendeteksi data PPKS yang kemungkinan duplikat berdasarkan NIK dan identitas lengkap')]
class DetectPpksDuplicates extends Command
{
    public function handle(): int
    {
        $this->info('Memulai pemeriksaan duplikat PPKS...');

        $ppks = Ppks::query()
            ->whereIn('status', [
                'normal',
                'perlu_diperiksa',
            ])
            ->orderBy('id')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Kelompok berdasarkan NIK
        |--------------------------------------------------------------------------
        */

        $groupsByNik = [];

        /*
        |--------------------------------------------------------------------------
        | Kelompok berdasarkan identitas lengkap
        |--------------------------------------------------------------------------
        */

        $groupsByIdentity = [];

        foreach ($ppks as $item) {

            $data = $item->data;

            if (!is_array($data)) {
                continue;
            }

            $nik = $this->normalizeNik(
                $data[2] ?? null
            );

            $identity = $this->getIdentity($data);

            /*
            | Simpan berdasarkan NIK
            */

            if ($nik) {
                $groupsByNik[$nik][] = $item;
            }

            /*
            | Simpan berdasarkan identitas lengkap
            */

            if ($this->identityComplete($identity)) {

                $identityKey = implode('|', [
                    $identity['nama'],
                    $identity['jenis_kelamin'],
                    $identity['tempat_lahir'],
                    $identity['tanggal_lahir'],
                ]);

                $groupsByIdentity[$identityKey][] = $item;
            }
        }

        $checked = [];

        /*
        |--------------------------------------------------------------------------
        | 1. NIK SAMA
        |--------------------------------------------------------------------------
        |
        | NIK sama tidak langsung dianggap duplikat.
        |
        | Kita cek identitas lengkap:
        |
        | NIK sama + identitas sama
        | -> normal
        |
        | NIK sama + identitas berbeda
        | -> perlu diperiksa
        |
        */

        foreach ($groupsByNik as $nik => $items) {

            if (count($items) < 2) {
                continue;
            }

            foreach ($items as $item) {

                foreach ($items as $comparison) {

                    if ($item->id === $comparison->id) {
                        continue;
                    }

                    $itemIdentity = $this->getIdentity(
                        $item->data
                    );

                    $comparisonIdentity = $this->getIdentity(
                        $comparison->data
                    );

                    /*
                    | Identitas sama.
                    |
                    | Ini adalah respons orang yang sama.
                    | Tidak perlu masuk pemeriksaan.
                    */

                    if (
                        $this->sameIdentity(
                            $itemIdentity,
                            $comparisonIdentity
                        )
                    ) {
                        continue;
                    }

                    /*
                    | NIK sama tetapi identitas berbeda.
                    */

                    $this->markForReview(
                        $item,
                        $comparison,
                        'NIK sama tetapi identitas berbeda. Perlu pemeriksaan admin.'
                    );

                    $checked[$item->id] = true;

                    break;
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | 2. IDENTITAS LENGKAP SAMA + NIK BERBEDA
        |--------------------------------------------------------------------------
        |
        | Identitas yang digunakan:
        |
        | Nama
        | Jenis Kelamin
        | Tempat Lahir
        | Tanggal Lahir
        |
        | Nama saja TIDAK cukup.
        |
        */

        foreach ($groupsByIdentity as $identityKey => $items) {

            if (count($items) < 2) {
                continue;
            }

            foreach ($items as $item) {

                foreach ($items as $comparison) {

                    if ($item->id === $comparison->id) {
                        continue;
                    }

                    $itemNik = $this->normalizeNik(
                        $item->data[2] ?? null
                    );

                    $comparisonNik = $this->normalizeNik(
                        $comparison->data[2] ?? null
                    );

                    /*
                    | Kalau NIK sama, sudah ditangani
                    | pada pemeriksaan sebelumnya.
                    */

                    if (
                        $itemNik &&
                        $comparisonNik &&
                        $itemNik === $comparisonNik
                    ) {
                        continue;
                    }

                    /*
                    | Identitas lengkap sama,
                    | tetapi NIK berbeda.
                    */

                    $this->markForReview(
                        $item,
                        $comparison,
                        'Identitas lengkap sama tetapi NIK berbeda. Perlu pemeriksaan admin.'
                    );

                    $checked[$item->id] = true;

                    break;
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | 3. Bersihkan status "perlu_diperiksa" yang tidak lagi memenuhi
        |    kriteria duplikat
        |--------------------------------------------------------------------------
        */

        foreach ($ppks as $item) {

            /*
            | Jangan menyentuh data yang sudah diputuskan admin.
            */

            if (
                in_array(
                    $item->duplicate_decision,
                    [
                        'pilih_data_ini',
                        'pilih_data_pembanding',
                        'bukan_duplikat',
                        'duplikat',
                    ],
                    true
                )
            ) {
                continue;
            }

            /*
            | Kalau sebelumnya perlu diperiksa tetapi sekarang
            | tidak ditemukan pasangan duplikat, kembalikan normal.
            */

            if (
                $item->status === 'perlu_diperiksa' &&
                !isset($checked[$item->id])
            ) {
                $item->update([
                    'status' => 'normal',
                    'possible_duplicate_of' => null,
                    'duplicate_note' => null,
                ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | HASIL
        |--------------------------------------------------------------------------
        */

        $this->newLine();

        $this->info('Pemeriksaan selesai.');

        $this->info(
            'Jumlah data yang ditandai perlu diperiksa: '
            . count($checked)
        );

        return self::SUCCESS;
    }

    /*
    |--------------------------------------------------------------------------
    | Ambil identitas
    |--------------------------------------------------------------------------
    */

    private function getIdentity(array $data): array
    {
        return [
            'nama' => $this->normalize(
                $data[1] ?? null
            ),

            'jenis_kelamin' => $this->normalize(
                $data[3] ?? null
            ),

            'tempat_lahir' => $this->normalize(
                $data[4] ?? null
            ),

            'tanggal_lahir' => $this->normalize(
                $data[5] ?? null
            ),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Cek apakah identitas lengkap
    |--------------------------------------------------------------------------
    */

    private function identityComplete(array $identity): bool
    {
        return
            !empty($identity['nama']) &&
            !empty($identity['jenis_kelamin']) &&
            !empty($identity['tempat_lahir']) &&
            !empty($identity['tanggal_lahir']);
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
        if (
            !$this->identityComplete($a) ||
            !$this->identityComplete($b)
        ) {
            return false;
        }

        return
            $a['nama'] === $b['nama'] &&
            $a['jenis_kelamin'] === $b['jenis_kelamin'] &&
            $a['tempat_lahir'] === $b['tempat_lahir'] &&
            $a['tanggal_lahir'] === $b['tanggal_lahir'];
    }

    /*
    |--------------------------------------------------------------------------
    | Tandai perlu diperiksa
    |--------------------------------------------------------------------------
    */

    private function markForReview(
        Ppks $item,
        Ppks $comparison,
        string $note
    ): void {

        /*
        | Jangan mengubah data yang sudah menjadi duplikat.
        */

        if ($item->status === 'duplikat') {
            return;
        }

        /*
        | Jangan mengubah keputusan admin.
        */

        if (
            in_array(
                $item->duplicate_decision,
                [
                    'pilih_data_ini',
                    'pilih_data_pembanding',
                    'bukan_duplikat',
                    'duplikat',
                ],
                true
            )
        ) {
            return;
        }

        $item->update([
            'status' => 'perlu_diperiksa',
            'possible_duplicate_of' => $comparison->id,
            'duplicate_note' => $note,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Normalisasi nama / teks
    |--------------------------------------------------------------------------
    */

    private function normalize(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $value = trim($value);

        if ($value === '') {
            return null;
        }

        $value = Str::lower($value);

        /*
        | Hilangkan spasi berlebihan.
        */

        $value = preg_replace(
            '/\s+/',
            ' ',
            $value
        );

        return $value ?: null;
    }

    /*
    |--------------------------------------------------------------------------
    | Normalisasi NIK
    |--------------------------------------------------------------------------
    */

    private function normalizeNik($value): ?string
    {
        if ($value === null) {
            return null;
        }

        $value = trim((string) $value);

        /*
        | Hilangkan karakter selain angka.
        */

        $value = preg_replace(
            '/[^0-9]/',
            '',
            $value
        );

        return $value ?: null;
    }
}
