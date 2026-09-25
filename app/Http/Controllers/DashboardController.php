<?php

namespace App\Http\Controllers;

use App\Models\Ppks;
use App\Models\ProsesPeserta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Controllers\PpksRecommendationController;

class DashboardController extends Controller
{
    /**
     * Dashboard utama
     */
    public function index(
        Request $request,
        PpksRecommendationController $recommendationController
    ): View {

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
            ->orderByDesc('tanggal_proses')
            ->orderByDesc('created_at')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | GROUP PROSES BERDASARKAN PPKS
        |--------------------------------------------------------------------------
        */

        $prosesByPpks = $prosesPesertas->groupBy('ppks_id');


        /*
        |--------------------------------------------------------------------------
        | TAHUN YANG TERSEDIA DARI DATABASE
        |--------------------------------------------------------------------------
        */

        $availableYears = collect();

        foreach ($ppks as $item) {

            $timestamp = data_get(
                $item->data,
                'timestamp'
            );

            if (empty($timestamp)) {
                continue;
            }

            $date = $this->parseTimestamp($timestamp);

            if (!$date) {
                continue;
            }

            $availableYears->push(
                (int) $date->format('Y')
            );
        }

        $availableYears = $availableYears
            ->unique()
            ->sortDesc()
            ->values()
            ->toArray();


        /*
        |--------------------------------------------------------------------------
        | TENTUKAN TAHUN YANG DIPILIH
        |--------------------------------------------------------------------------
        */

        $selectedYear = $request->query('year');

        if (
            empty($selectedYear) ||
            !in_array(
                (int) $selectedYear,
                $availableYears,
                true
            )
        ) {
            $selectedYear = $availableYears[0] ?? null;
        }

        $selectedYear = $selectedYear !== null
            ? (int) $selectedYear
            : null;


        /*
        |--------------------------------------------------------------------------
        | TREND PENDAFTAR PER BULAN
        |--------------------------------------------------------------------------
        */

        $monthlyRegistrations = array_fill(1, 12, 0);

        if ($selectedYear !== null) {

            foreach ($ppks as $item) {

                $timestamp = data_get(
                    $item->data,
                    'timestamp'
                );

                if (empty($timestamp)) {
                    continue;
                }

                $date = $this->parseTimestamp($timestamp);

                if (!$date) {
                    continue;
                }

                if ((int) $date->format('Y') !== $selectedYear) {
                    continue;
                }

                $month = (int) $date->format('n');

                $monthlyRegistrations[$month]++;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | LABEL BULAN
        |--------------------------------------------------------------------------
        */

        $monthLabels = [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'Mei',
            'Jun',
            'Jul',
            'Agu',
            'Sep',
            'Okt',
            'Nov',
            'Des',
        ];

        $registrationValues = array_values(
            $monthlyRegistrations
        );


        /*
        |--------------------------------------------------------------------------
        | STATISTIK STATUS PESERTA
        |--------------------------------------------------------------------------
        |
        | DITERIMA
        | ---------------------------------------------------------------
        | Peserta dianggap diterima apabila:
        |
        | tahap  = kesehatan_lanjutan
        | status = lulus
        |
        |
        | TIDAK DITERIMA
        | ---------------------------------------------------------------
        | Peserta dianggap tidak diterima apabila:
        |
        | status = tidak_lulus
        |
        | Tahap tidak dibatasi.
        |
        | Bisa berasal dari:
        | - instruktur
        | - kesehatan_awal
        | - case_conference
        | - kesehatan_lanjutan
        |
        |--------------------------------------------------------------------------
        */

        $diterima = $prosesPesertas
            ->where('tahap', 'kesehatan_lanjutan')
            ->where('status', 'lulus')
            ->pluck('ppks_id')
            ->unique()
            ->count();


        $tidakDiterima = $prosesPesertas
            ->where('status', 'tidak_lulus')
            ->pluck('ppks_id')
            ->unique()
            ->count();


        /*
        |--------------------------------------------------------------------------
        | PENDING
        |--------------------------------------------------------------------------
        |
        | Untuk sementara logika pending tetap mengikuti
        | logika dashboard sebelumnya:
        |
        | mengambil CASE CONFERENCE terbaru.
        |
        |--------------------------------------------------------------------------
        */

        $pending = 0;

        foreach ($ppks as $item) {

            $processes = $prosesByPpks
                ->get(
                    $item->id,
                    collect()
                );


            /*
            |--------------------------------------------------------------------------
            | AMBIL CASE CONFERENCE TERBARU
            |--------------------------------------------------------------------------
            */

            $caseConference = $processes
                ->where(
                    'tahap',
                    'case_conference'
                )
                ->sortByDesc(function ($process) {

                    return [
                        optional(
                            $process->tanggal_proses
                        )->timestamp ?? 0,

                        optional(
                            $process->created_at
                        )->timestamp ?? 0,
                    ];
                })
                ->first();


            if (!$caseConference) {
                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | STATUS CASE CONFERENCE PENDING
            |--------------------------------------------------------------------------
            */

            if (
                $caseConference->status === 'pending'
            ) {
                $pending++;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | TOTAL PENDAFTAR
        |--------------------------------------------------------------------------
        */

        $totalPendaftar = $ppks->count();


        /*
        |--------------------------------------------------------------------------
        | PERSENTASE STATISTIK
        |--------------------------------------------------------------------------
        */

        $diterimaPercentage = $totalPendaftar > 0
            ? round(
                ($diterima / $totalPendaftar) * 100,
                1
            )
            : 0;


        $tidakDiterimaPercentage = $totalPendaftar > 0
            ? round(
                ($tidakDiterima / $totalPendaftar) * 100,
                1
            )
            : 0;


        $pendingPercentage = $totalPendaftar > 0
            ? round(
                ($pending / $totalPendaftar) * 100,
                1
            )
            : 0;


        /*
        |--------------------------------------------------------------------------
        | 5 PROVINSI DENGAN PENDAFTAR TERBANYAK
        |--------------------------------------------------------------------------
        */

        $provinceCounts = [];

        foreach ($ppks as $item) {

            $province = trim(
                (string) data_get(
                    $item->data,
                    'provinsi',
                    ''
                )
            );

            if ($province === '') {
                $province = 'Tidak Diketahui';
            }

            $provinceCounts[$province] =
                ($provinceCounts[$province] ?? 0) + 1;
        }

        arsort($provinceCounts);

        $topProvinces = array_slice(
            $provinceCounts,
            0,
            5,
            true
        );

        $provinceLabels = array_keys(
            $topProvinces
        );

        $provinceValues = array_values(
            $topProvinces
        );


        /*
        |--------------------------------------------------------------------------
        | JENIS PPKS
        |--------------------------------------------------------------------------
        |
        | KATEGORI TETAP:
        |
        | 1. Disabilitas Fisik
        | 2. Disabilitas Rungu Wicara
        | 3. Disabilitas Netra
        | 4. Disabilitas Mental
        | 5. Disabilitas Intelektual
        | 6. Kelompok Rentan
        | 7. Other
        |
        |--------------------------------------------------------------------------
        */

        $ppksCategories = [
            'Disabilitas Fisik',
            'Disabilitas Rungu Wicara',
            'Disabilitas Netra',
            'Disabilitas Mental',
            'Disabilitas Intelektual',
            'Kelompok Rentan',
            'Other',
        ];


        /*
        |--------------------------------------------------------------------------
        | INISIALISASI SEMUA KATEGORI
        |--------------------------------------------------------------------------
        */

        $disabilityCounts = [];

        foreach ($ppksCategories as $category) {
            $disabilityCounts[$category] = 0;
        }


        /*
        |--------------------------------------------------------------------------
        | NORMALISASI JENIS PPKS
        |--------------------------------------------------------------------------
        */

        foreach ($ppks as $item) {

            $type = trim(
                (string) data_get(
                    $item->data,
                    'jenis_ppks',
                    ''
                )
            );


            /*
            |--------------------------------------------------------------------------
            | KOSONG -> OTHER
            |--------------------------------------------------------------------------
            */

            if ($type === '') {

                $disabilityCounts['Other']++;

                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | NORMALISASI TEKS
            |--------------------------------------------------------------------------
            */

            $typeNormalized = mb_strtolower(
                preg_replace(
                    '/\s+/',
                    ' ',
                    $type
                )
            );

            $matchedCategory = null;


            /*
            |--------------------------------------------------------------------------
            | DISABILITAS FISIK
            |--------------------------------------------------------------------------
            */

            if (
                str_contains(
                    $typeNormalized,
                    'fisik'
                )
            ) {

                $matchedCategory =
                    'Disabilitas Fisik';
            }


            /*
            |--------------------------------------------------------------------------
            | RUNGU WICARA
            |--------------------------------------------------------------------------
            */

            elseif (
                str_contains(
                    $typeNormalized,
                    'rungu'
                ) ||
                str_contains(
                    $typeNormalized,
                    'wicara'
                )
            ) {

                $matchedCategory =
                    'Disabilitas Rungu Wicara';
            }


            /*
            |--------------------------------------------------------------------------
            | NETRA
            |--------------------------------------------------------------------------
            */

            elseif (
                str_contains(
                    $typeNormalized,
                    'netra'
                )
            ) {

                $matchedCategory =
                    'Disabilitas Netra';
            }


            /*
            |--------------------------------------------------------------------------
            | MENTAL
            |--------------------------------------------------------------------------
            */

            elseif (
                str_contains(
                    $typeNormalized,
                    'mental'
                )
            ) {

                $matchedCategory =
                    'Disabilitas Mental';
            }


            /*
            |--------------------------------------------------------------------------
            | INTELEKTUAL
            |--------------------------------------------------------------------------
            */

            elseif (
                str_contains(
                    $typeNormalized,
                    'intelektual'
                )
            ) {

                $matchedCategory =
                    'Disabilitas Intelektual';
            }


            /*
            |--------------------------------------------------------------------------
            | KELOMPOK RENTAN
            |--------------------------------------------------------------------------
            */

            elseif (
                str_contains(
                    $typeNormalized,
                    'rentan'
                )
            ) {

                $matchedCategory =
                    'Kelompok Rentan';
            }


            /*
            |--------------------------------------------------------------------------
            | JIKA TIDAK SESUAI 6 KATEGORI -> OTHER
            |--------------------------------------------------------------------------
            */

            if ($matchedCategory === null) {
                $matchedCategory = 'Other';
            }

            $disabilityCounts[$matchedCategory]++;
        }


        /*
        |--------------------------------------------------------------------------
        | LABEL DAN VALUE JENIS PPKS
        |--------------------------------------------------------------------------
        */

        $disabilityLabels = array_keys(
            $disabilityCounts
        );

        $disabilityValues = array_values(
            $disabilityCounts
        );


        /*
        |--------------------------------------------------------------------------
        | JURUSAN YANG DIMINATI
        |--------------------------------------------------------------------------
        |
        | KATEGORI DISPLAY:
        |
        | 1. Desain Grafis
        | 2. Contact Center
        | 3. Penjahitan
        | 4. Komputer
        | 5. Otomotif
        | 6. Elektro
        | 7. Las
        | 8. Other
        |
        |--------------------------------------------------------------------------
        */

        $majorCategories = [
            'Desain Grafis',
            'Contact Center',
            'Penjahitan',
            'Komputer',
            'Otomotif',
            'Elektro',
            'Las',
        ];

        $majorCounts = [];

        foreach ($majorCategories as $category) {
            $majorCounts[$category] = 0;
        }

        $majorCounts['Other'] = 0;


        foreach ($ppks as $item) {

            $major = trim(
                (string) data_get(
                    $item->data,
                    'jurusan_yang_diminati',
                    ''
                )
            );


            /*
            |--------------------------------------------------------------------------
            | KOSONG -> OTHER
            |--------------------------------------------------------------------------
            */

            if ($major === '') {

                $majorCounts['Other']++;

                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | NORMALISASI
            |--------------------------------------------------------------------------
            */

            $majorNormalized = mb_strtolower(
                preg_replace(
                    '/\s+/',
                    ' ',
                    $major
                )
            );

            $matched = false;


            /*
            |--------------------------------------------------------------------------
            | CEK KATEGORI
            |--------------------------------------------------------------------------
            */

            foreach ($majorCategories as $category) {

                $categoryNormalized =
                    mb_strtolower($category);

                if (
                    str_contains(
                        $majorNormalized,
                        $categoryNormalized
                    )
                ) {

                    $majorCounts[$category]++;

                    $matched = true;

                    break;
                }
            }


            /*
            |--------------------------------------------------------------------------
            | TIDAK COCOK -> OTHER
            |--------------------------------------------------------------------------
            */

            if (!$matched) {

                $majorCounts['Other']++;
            }
        }

        $majorLabels = array_keys(
            $majorCounts
        );

        $majorValues = array_values(
            $majorCounts
        );


        /*
        |--------------------------------------------------------------------------
        | TAHAPAN PESERTA
        |--------------------------------------------------------------------------
        */

        $stageCounts = [
            'Belum Diolah' => 0,
            'Asesmen Instruktur' => 0,
            'Asesmen Kesehatan Awal' => 0,
            'Case Conference' => 0,
            'Kesehatan Lanjutan' => 0,
            'Pending' => 0,
            'Tidak Lulus' => 0,
        ];


        foreach ($ppks as $item) {

            $processes = $prosesByPpks
                ->get(
                    $item->id,
                    collect()
                );


            /*
            |--------------------------------------------------------------------------
            | AMBIL PROSES TERBARU SETIAP TAHAP
            |--------------------------------------------------------------------------
            */

            $latestByStage = [];

            foreach ($processes as $process) {

                $stage = $process->tahap;

                if (!isset($latestByStage[$stage])) {

                    $latestByStage[$stage] = $process;

                    continue;
                }

                $currentTimestamp =
                    optional(
                        $process->tanggal_proses
                    )->timestamp ?? 0;

                $latestTimestamp =
                    optional(
                        $latestByStage[$stage]
                            ->tanggal_proses
                    )->timestamp ?? 0;

                if (
                    $currentTimestamp >
                    $latestTimestamp
                ) {

                    $latestByStage[$stage] =
                        $process;
                }
            }


            /*
            |--------------------------------------------------------------------------
            | PRIORITAS STATUS
            |--------------------------------------------------------------------------
            */

            $hasPending = collect(
                $latestByStage
            )->contains(function ($process) {

                return $process->status === 'pending';
            });


            $hasTidakLulus = collect(
                $latestByStage
            )->contains(function ($process) {

                return $process->status === 'tidak_lulus';
            });


            if ($hasPending) {

                $stageCounts['Pending']++;

                continue;
            }


            if ($hasTidakLulus) {

                $stageCounts['Tidak Lulus']++;

                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | TENTUKAN TAHAP TERAKHIR
            |--------------------------------------------------------------------------
            */

            $stageOrder = [
                'kesehatan_lanjutan',
                'case_conference',
                'kesehatan_awal',
                'instruktur',
            ];

            $foundStage = false;

            foreach ($stageOrder as $stage) {

                if (!isset($latestByStage[$stage])) {
                    continue;
                }

                $process =
                    $latestByStage[$stage];

                if ($process->status !== 'lulus') {
                    continue;
                }


                switch ($stage) {

                    case 'kesehatan_lanjutan':

                        $stageCounts[
                            'Kesehatan Lanjutan'
                        ]++;

                        break;


                    case 'case_conference':

                        $stageCounts[
                            'Case Conference'
                        ]++;

                        break;


                    case 'kesehatan_awal':

                        $stageCounts[
                            'Asesmen Kesehatan Awal'
                        ]++;

                        break;


                    case 'instruktur':

                        $stageCounts[
                            'Asesmen Instruktur'
                        ]++;

                        break;
                }

                $foundStage = true;

                break;
            }


            /*
            |--------------------------------------------------------------------------
            | BELUM ADA PROSES
            |--------------------------------------------------------------------------
            */

            if (!$foundStage) {

                $stageCounts['Belum Diolah']++;
            }
        }


        $stageLabels = array_keys(
            $stageCounts
        );

        $stageValues = array_values(
            $stageCounts
        );


        /*
        |--------------------------------------------------------------------------
        | REKOMENDASI
        |--------------------------------------------------------------------------
        */

        $recommendations =
            $recommendationController
                ->getRecommendations();


        /*
        |--------------------------------------------------------------------------
        | KIRIM DATA KE BLADE
        |--------------------------------------------------------------------------
        */

        return view(
            'dashboard',
            compact(

                'totalPendaftar',

                'diterima',
                'diterimaPercentage',

                'tidakDiterima',
                'tidakDiterimaPercentage',

                'pending',
                'pendingPercentage',

                'availableYears',
                'selectedYear',

                'monthLabels',
                'registrationValues',

                'provinceLabels',
                'provinceValues',

                'disabilityLabels',
                'disabilityValues',

                'stageLabels',
                'stageValues',

                'majorLabels',
                'majorValues'
            )
        )->with(
            'recommendations',
            $recommendations
        );
    }


    /**
     * Parse timestamp dari data Google Sheets / database.
     */
    private function parseTimestamp($timestamp): ?Carbon
    {
        if ($timestamp === null) {
            return null;
        }

        $timestamp = trim(
            (string) $timestamp
        );

        if ($timestamp === '') {
            return null;
        }


        /*
        |--------------------------------------------------------------------------
        | FORMAT GOOGLE SHEETS
        |--------------------------------------------------------------------------
        */

        $formats = [
            'n/j/Y H:i:s',
            'm/d/Y H:i:s',

            'n/j/Y H:i',
            'm/d/Y H:i',

            'Y-m-d H:i:s',
            'Y-m-d H:i',

            'd/m/Y H:i:s',
            'd/m/Y H:i',

            'd-m-Y H:i:s',
            'd-m-Y H:i',
        ];


        foreach ($formats as $format) {

            try {

                return Carbon::createFromFormat(
                    $format,
                    $timestamp
                );

            } catch (\Throwable $e) {

                // Lanjut ke format berikutnya
            }
        }


        /*
        |--------------------------------------------------------------------------
        | FALLBACK
        |--------------------------------------------------------------------------
        */

        try {

            return Carbon::parse(
                $timestamp
            );

        } catch (\Throwable $e) {

            return null;
        }
    }
}