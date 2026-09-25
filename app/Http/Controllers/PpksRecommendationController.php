<?php

namespace App\Http\Controllers;

use App\Models\Ppks;
use App\Models\ProsesPeserta;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PpksRecommendationController extends Controller
{
    /**
     * Ambil data rekomendasi peserta pending.
     *
     * Prioritas:
     * 1. Umur 18 → 19 → 20 → ... → 35
     * 2. Jika umur sama:
     *    Fisik → Rungu Wicara → lainnya
     */
    public function getRecommendations()
    {
        /*
        |--------------------------------------------------------------------------
        | Ambil data PPKS
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
        | Ambil proses peserta
        |--------------------------------------------------------------------------
        */
        $prosesPeserta = ProsesPeserta::query()
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
        | Kelompokkan proses berdasarkan PPKS
        |--------------------------------------------------------------------------
        */
        $prosesByPpks = $prosesPeserta->groupBy('ppks_id');

        $recommendations = [];

        /*
        |--------------------------------------------------------------------------
        | Cari peserta yang memiliki proses PENDING
        |--------------------------------------------------------------------------
        */
        foreach ($ppks as $item) {

            $processes = $prosesByPpks->get(
                $item->id,
                collect()
            );

            /*
            |--------------------------------------------------------------------------
            | Ambil proses pending terbaru
            |--------------------------------------------------------------------------
            */
            $pendingProcess = $processes
                ->filter(function ($process) {
                    return strtolower(
                        trim((string) $process->status)
                    ) === 'pending';
                })
                ->sortByDesc(function ($process) {
                    return $process->created_at
                        ?? $process->tanggal_proses;
                })
                ->first();

            /*
            |--------------------------------------------------------------------------
            | Kalau tidak ada pending, lewati
            |--------------------------------------------------------------------------
            */
            if (!$pendingProcess) {
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Ambil data peserta
            |--------------------------------------------------------------------------
            */
            $data = is_array($item->data)
                ? $item->data
                : [];

            /*
            |--------------------------------------------------------------------------
            | Ambil umur
            |--------------------------------------------------------------------------
            */
            $ageRaw = $data['usia'] ?? null;

            $age = is_numeric($ageRaw)
                ? (int) $ageRaw
                : null;

            /*
            |--------------------------------------------------------------------------
            | Hanya umur 18 - 35 tahun
            |--------------------------------------------------------------------------
            */
            if (
                $age === null ||
                $age < 18 ||
                $age > 35
            ) {
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Ambil jenis disabilitas
            |--------------------------------------------------------------------------
            */
            $disabilityType =
                $data['jenis_ppks']
                ?? $data['jenis_disabilitas']
                ?? $data['jenis_disabilitas_ppks']
                ?? '';

            $disabilityType = trim(
                (string) $disabilityType
            );

            $normalizedType = strtolower(
                $disabilityType
            );

            /*
            |--------------------------------------------------------------------------
            | Prioritas disabilitas
            |
            | 0 = Fisik
            | 1 = Rungu Wicara
            | 2 = Lainnya
            |--------------------------------------------------------------------------
            */
            if (
                str_contains(
                    $normalizedType,
                    'fisik'
                )
            ) {

                $physicalPriority = 0;

            } elseif (
                str_contains(
                    $normalizedType,
                    'rungu'
                ) ||
                str_contains(
                    $normalizedType,
                    'wicara'
                )
            ) {

                $physicalPriority = 1;

            } else {

                $physicalPriority = 2;
            }

            /*
            |--------------------------------------------------------------------------
            | Simpan kandidat rekomendasi
            |--------------------------------------------------------------------------
            */
            $recommendations[] = [
                'ppks' => $item,

                'data' => $data,

                'age' => $age,

                'disability_type' => $disabilityType,

                'physical_priority' =>
                    $physicalPriority,

                'process' => $pendingProcess,

                'pending_process' =>
                    $pendingProcess,

                'pending_stage' =>
                    $pendingProcess->tahap,

                'alasan_pending' =>
                    $pendingProcess->alasan_pending,

                'catatan' =>
                    $pendingProcess->catatan,

                'tanggal_panggil_kembali' =>
                    $pendingProcess->tanggal_panggil_kembali,

                'tanggal_proses' =>
                    $pendingProcess->tanggal_proses,
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | SORTING REKOMENDASI
        |--------------------------------------------------------------------------
        |
        | PRIORITAS PERTAMA:
        | UMUR
        |
        | 18 → 19 → 20 → 21 → ... → 35
        |
        | PRIORITAS KEDUA:
        | JENIS DISABILITAS
        |
        | Fisik → Rungu Wicara → lainnya
        |
        |--------------------------------------------------------------------------
        */
        usort(
            $recommendations,
            function ($a, $b) {

                /*
                |--------------------------------------------------------------------------
                | 1. UMUR TERLEBIH DAHULU
                |--------------------------------------------------------------------------
                */
                if ($a['age'] !== $b['age']) {
                    return $a['age'] <=> $b['age'];
                }

                /*
                |--------------------------------------------------------------------------
                | 2. KALAU UMUR SAMA, BARU DISABILITAS
                |--------------------------------------------------------------------------
                */
                return $a['physical_priority']
                    <=> $b['physical_priority'];
            }
        );

        return $recommendations;
    }

    /**
     * Halaman rekomendasi.
     */
    public function index(Request $request): View
    {
        $recommendations =
            $this->getRecommendations();

        return view(
            'ppks.normal.rekomendasi',
            compact('recommendations')
        );
    }
}