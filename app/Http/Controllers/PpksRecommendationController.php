<?php

namespace App\Http\Controllers;

use App\Models\Ppks;
use App\Models\ProsesPeserta;

class PpksRecommendationController extends Controller
{
    /**
     * Mendapatkan seluruh rekomendasi peserta pending.
     *
     * Prioritas tahap:
     * 1. Asesmen Instruktur
     * 2. Case Conference
     * 3. Asesmen Kesehatan Awal
     * 4. Kesehatan Lanjutan
     *
     * Setelah prioritas tahap:
     * 1. Umur paling dekat dengan 18 tahun
     * 2. Disabilitas Fisik
     * 3. Disabilitas Rungu Wicara
     * 4. Kategori lainnya
     *
     * Catatan:
     * - Penentuan pending berdasarkan STATUS, bukan waktu.
     * - Satu PPKS hanya muncul satu kali.
     * - Jika satu PPKS memiliki beberapa tahap pending,
     *   hanya tahap dengan prioritas tertinggi yang ditampilkan.
     */
    public function getRecommendations(): array
    {
        /*
        |--------------------------------------------------------------------------
        | AMBIL DATA PPKS
        |--------------------------------------------------------------------------
        */

        $ppks = Ppks::query()
            ->select([
                'id',
                'data',
                'status',
            ])
            ->get();

        /*
        |--------------------------------------------------------------------------
        | AMBIL SELURUH PROSES PESERTA
        |--------------------------------------------------------------------------
        */

        $prosesPesertas = ProsesPeserta::query()
            ->select([
                'id',
                'ppks_id',
                'tahap',
                'status',
                'alasan_pending',
                'catatan',
                'tanggal_panggil_kembali',
                'tanggal_proses',
                'created_at',
            ])
            ->get();

        /*
        |--------------------------------------------------------------------------
        | GROUP PROSES BERDASARKAN PPKS
        |--------------------------------------------------------------------------
        */

        $prosesByPpks = $prosesPesertas->groupBy('ppks_id');

        /*
        |--------------------------------------------------------------------------
        | PRIORITAS TAHAP REKOMENDASI
        |--------------------------------------------------------------------------
        |
        | Semakin kecil angka = semakin tinggi prioritas.
        |
        */

        $stagePriority = [
            'instruktur' => 0,
            'case_conference' => 1,
            'kesehatan_awal' => 2,
            'kesehatan_lanjutan' => 3,
        ];

        /*
        |--------------------------------------------------------------------------
        | INISIALISASI REKOMENDASI
        |--------------------------------------------------------------------------
        */

        $recommendations = [];

        /*
        |--------------------------------------------------------------------------
        | CEK SETIAP PPKS
        |--------------------------------------------------------------------------
        */

        foreach ($ppks as $item) {

            $processes = $prosesByPpks->get(
                $item->id,
                collect()
            );

            /*
            |--------------------------------------------------------------------------
            | CARI STATUS PENDING BERDASARKAN PRIORITAS TAHAP
            |--------------------------------------------------------------------------
            |
            | Kita TIDAK menentukan pending berdasarkan tanggal.
            |
            | Yang dicek adalah:
            |
            | "Apakah PPKS ini memiliki proses dengan tahap tersebut
            |  dan status = pending?"
            |
            | Kalau ada, tahap tersebut menjadi rekomendasi.
            |
            | Kalau ada lebih dari satu tahap pending, yang dipilih
            | adalah tahap dengan prioritas paling tinggi.
            |
            */

            $selectedPendingProcess = null;
            $selectedStage = null;
            $selectedStagePriority = null;

            foreach ($stagePriority as $stage => $priority) {

                /*
                |--------------------------------------------------------------------------
                | CARI PROSES PENDING PADA TAHAP INI
                |--------------------------------------------------------------------------
                */

                $pendingProcess = $processes
                    ->where('tahap', $stage)
                    ->where('status', 'pending')
                    ->first();

                /*
                |--------------------------------------------------------------------------
                | TIDAK ADA PENDING PADA TAHAP INI
                |--------------------------------------------------------------------------
                */

                if (!$pendingProcess) {
                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | DITEMUKAN PENDING
                |--------------------------------------------------------------------------
                */

                $selectedPendingProcess = $pendingProcess;
                $selectedStage = $stage;
                $selectedStagePriority = $priority;

                /*
                |--------------------------------------------------------------------------
                | BERHENTI
                |--------------------------------------------------------------------------
                |
                | Karena tahap sudah ditemukan berdasarkan urutan prioritas,
                | tidak perlu mengecek tahap berikutnya.
                |
                */

                break;
            }

            /*
            |--------------------------------------------------------------------------
            | TIDAK ADA PENDING
            |--------------------------------------------------------------------------
            */

            if (!$selectedPendingProcess) {
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | AMBIL UMUR
            |--------------------------------------------------------------------------
            */

            $age = data_get(
                $item->data,
                'usia'
            );

            $age = is_numeric($age)
                ? (int) $age
                : null;

            /*
            |--------------------------------------------------------------------------
            | HITUNG JARAK UMUR DARI 18 TAHUN
            |--------------------------------------------------------------------------
            */

            $ageDifference = $age !== null
                ? abs(18 - $age)
                : PHP_INT_MAX;

            /*
            |--------------------------------------------------------------------------
            | AMBIL JENIS PPKS
            |--------------------------------------------------------------------------
            */

            $type = trim(
                (string) data_get(
                    $item->data,
                    'jenis_ppks',
                    ''
                )
            );

            /*
            |--------------------------------------------------------------------------
            | NORMALISASI JENIS PPKS
            |--------------------------------------------------------------------------
            */

            $typeLower = mb_strtolower(
                preg_replace(
                    '/\s+/',
                    ' ',
                    $type
                )
            );

            /*
            |--------------------------------------------------------------------------
            | PRIORITAS JENIS PPKS
            |--------------------------------------------------------------------------
            |
            | 0 = Disabilitas Fisik
            | 1 = Disabilitas Rungu Wicara
            | 2 = Kategori lainnya
            |
            */

            if (
                str_contains(
                    $typeLower,
                    'fisik'
                )
            ) {

                $physicalPriority = 0;

            } elseif (
                str_contains(
                    $typeLower,
                    'rungu'
                ) ||
                str_contains(
                    $typeLower,
                    'wicara'
                )
            ) {

                $physicalPriority = 1;

            } else {

                $physicalPriority = 2;
            }

            /*
            |--------------------------------------------------------------------------
            | SIMPAN REKOMENDASI
            |--------------------------------------------------------------------------
            */

            $recommendations[] = [
                'ppks' => $item,

                'pending_process' => $selectedPendingProcess,

                'pending_stage' => $selectedStage,

                'stage_priority' => $selectedStagePriority,

                'age' => $age,

                'age_difference' => $ageDifference,

                'physical_priority' => $physicalPriority,
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | URUTKAN REKOMENDASI
        |--------------------------------------------------------------------------
        |
        | Urutan:
        |
        | 1. Prioritas tahap
        | 2. Umur paling dekat dengan 18
        | 3. Disabilitas Fisik
        | 4. Disabilitas Rungu Wicara
        | 5. Kategori lainnya
        |
        */

        usort(
            $recommendations,
            function ($a, $b) {

                /*
                |--------------------------------------------------------------------------
                | PRIORITAS TAHAP
                |--------------------------------------------------------------------------
                */

                if (
                    $a['stage_priority']
                    !==
                    $b['stage_priority']
                ) {

                    return
                        $a['stage_priority']
                        <=>
                        $b['stage_priority'];
                }

                /*
                |--------------------------------------------------------------------------
                | JARAK UMUR DARI 18
                |--------------------------------------------------------------------------
                */

                if (
                    $a['age_difference']
                    !==
                    $b['age_difference']
                ) {

                    return
                        $a['age_difference']
                        <=>
                        $b['age_difference'];
                }

                /*
                |--------------------------------------------------------------------------
                | PRIORITAS JENIS PPKS
                |--------------------------------------------------------------------------
                */

                return
                    $a['physical_priority']
                    <=>
                    $b['physical_priority'];
            }
        );

        /*
        |--------------------------------------------------------------------------
        | KEMBALIKAN SEMUA REKOMENDASI
        |--------------------------------------------------------------------------
        |
        | Tidak menggunakan array_slice().
        |
        | Semua PPKS yang memiliki status pending
        | akan dikembalikan.
        |
        */

        return $recommendations;
    }
    public function index()
    {
        $recommendations = $this->getRecommendations();

        return view(
            'rekomendasi',
            compact('recommendations')
        );
    }
}
