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
     */
    'stageStatuses' => [],
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
                        hourglass_empty
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
                 * Kalau FAILED, garis tidak dilanjutkan.
                 */
                $lineCompleted =
                    !$detail &&
                    $status === 'completed';
            @endphp

            <div class="progress-line {{ $lineCompleted ? 'completed' : '' }}"></div>

        @endif

    @endforeach

</section>