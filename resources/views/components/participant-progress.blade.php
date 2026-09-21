@props([
    'activeStep' => 1,
    'detail' => false,

    /*
     * Status setiap tahapan.
     *
     * completed = sudah selesai
     * current   = sedang dikerjakan
     * pending   = sedang menunggu
     * failed    = tidak lulus
     * waiting   = belum masuk tahap
     *
     * Contoh:
     * [
     *     1 => 'completed',
     *     2 => 'completed',
     *     3 => 'current',
     *     4 => 'waiting',
     *     5 => 'waiting',
     * ]
     */
    'stageStatuses' => [],

    /*
     * Status hasil akhir.
     *
     * active   = Peserta Aktif
     * inactive = Tidak Aktif
     * waiting  = Belum ada hasil
     */
    'finalStatus' => 'waiting',
])

@php
    $steps = [
        [
            'number' => 1,
            'label' => "Data Calon<br>PPKS",
        ],
        [
            'number' => 2,
            'label' => "Asesmen<br>Instruktur",
        ],
        [
            'number' => 3,
            'label' => "Asesmen Kesehatan<br>Awal",
        ],
        [
            'number' => 4,
            'label' => "Case<br>Conference",
        ],
        [
            'number' => 5,
            'label' => "Kesehatan<br>Lanjutan",
        ],
    ];

    /*
     * Helper untuk mengambil status tahap.
     */
    $getStageStatus = function ($stepNumber) use (
        $stageStatuses,
        $activeStep,
        $detail
    ) {
        /*
         * KHUSUS DETAIL CALON PPKS
         * Data Calon PPKS dianggap selesai.
         */
        if ($detail && $stepNumber === 1) {
            return 'completed';
        }

        /*
         * Kalau status diberikan dari Blade,
         * gunakan status tersebut.
         */
        if (isset($stageStatuses[$stepNumber])) {
            return $stageStatuses[$stepNumber];
        }

        /*
         * Fallback jika status belum dikirim.
         */
        if ($stepNumber < $activeStep) {
            return 'completed';
        }

        if ($stepNumber === (int) $activeStep) {
            return 'current';
        }

        return 'waiting';
    };
@endphp


<section class="participant-progress">

    {{-- =====================================================
        5 TAHAP PROSES
    ====================================================== --}}

    @foreach ($steps as $step)

        @php
            $stepNumber = $step['number'];
            $status = $getStageStatus($stepNumber);
        @endphp


        {{-- =================================================
            STEP
        ================================================== --}}
        <div class="progress-step {{ $status }}">

            <div class="progress-circle">

                {{-- COMPLETED --}}
                @if ($status === 'completed')

                    <span class="material-symbols-outlined">
                        check
                    </span>


                {{-- FAILED --}}
                @elseif ($status === 'failed')

                    <span class="material-symbols-outlined">
                        close
                    </span>


                {{-- PENDING --}}
                @elseif ($status === 'pending')

                    <span class="material-symbols-outlined">
                        schedule
                    </span>


                {{-- CURRENT --}}
                @elseif ($status === 'current')

                    <span class="progress-current-dot"></span>


                {{-- WAITING --}}
                @else

                    <span class="progress-number">
                        {{ $stepNumber }}
                    </span>

                @endif

            </div>


            <span class="progress-label">
                {!! $step['label'] !!}
            </span>

        </div>


        {{-- =================================================
            LINE
        ================================================== --}}
        @if (!$loop->last)

            @php
                /*
                 * Garis hanya aktif kalau tahap sebelumnya
                 * benar-benar COMPLETED.
                 *
                 * Jadi khusus detail:
                 * Step 1 boleh centang,
                 * tetapi garis tetap tidak aktif.
                 */
                $lineCompleted =
                    !$detail &&
                    $status === 'completed';
            @endphp

            <div class="progress-line {{ $lineCompleted ? 'completed' : '' }}"></div>

        @endif

    @endforeach


    {{-- =====================================================
        LINE MENUJU HASIL AKHIR
    ====================================================== --}}

    @php
        /*
         * Garis menuju hasil akhir hanya aktif
         * jika Kesehatan Lanjutan sudah selesai.
         */
        $finalLineCompleted =
            !$detail &&
            $getStageStatus(5) === 'completed';
    @endphp

    <div class="progress-line {{ $finalLineCompleted ? 'completed' : '' }}"></div>


    {{-- =====================================================
        HASIL AKHIR
    ====================================================== --}}

    @php
        $finalStepClass = match ($finalStatus) {
            'active' => 'active',
            'inactive' => 'inactive',
            default => 'waiting',
        };
    @endphp

    <div class="progress-step final-step {{ $finalStepClass }}">

        <div class="progress-circle">

            {{-- PESERTA AKTIF --}}
            @if ($finalStatus === 'active')

                <span class="material-symbols-outlined">
                    check
                </span>


            {{-- TIDAK AKTIF --}}
            @elseif ($finalStatus === 'inactive')

                <span class="material-symbols-outlined">
                    close
                </span>


            {{-- BELUM ADA HASIL --}}
            @else

                <span class="progress-number">
                    6
                </span>

            @endif

        </div>


        <span class="progress-label">
            Hasil<br>Akhir
        </span>

    </div>

</section>