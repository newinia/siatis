<x-app-layout>
    <div class="main-page">
        <div class="main-page-header">
            <div>
                <h1>Prioritas Peserta Pending</h1>
                <p>
                    Peserta pending berdasarkan urutan prioritas
                </p>
            </div>
        </div>

            <div class="table-wrapper">

                <table class="table">

                    <thead>

                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>NIK</th>
                            <th>Umur</th>
                            <th>Jenis PPKS</th>
                            <th>Jurusan</th>
                            <th>Hasil</th>
                            <th>Keterangan</th>
                        </tr>

                    </thead>


                    <tbody>

                        @forelse ($recommendations as $index => $recommendation)

                                                @php

                                                    /*
                                                    |--------------------------------------------------------------------------
                                                    | DATA PPKS
                                                    |--------------------------------------------------------------------------
                                                    */

                                                    $ppks = $recommendation['ppks'] ?? null;

                                                    $ppksData = $ppks?->data ?? [];

                                                    if (!is_array($ppksData)) {
                                                        $ppksData = [];
                                                    }


                                                    /*
                                                    |--------------------------------------------------------------------------
                                                    | PROSES PENDING
                                                    |--------------------------------------------------------------------------
                                                    */

                                                    $pendingProcess =
                                                        $recommendation['pending_process']
                                                        ?? null;


                                                    /*
                                                    |--------------------------------------------------------------------------
                                                    | TAHAP PENDING
                                                    |--------------------------------------------------------------------------
                                                    */

                                                    $pendingStage =
                                                        $recommendation['pending_stage']
                                                        ?? null;


                                                    /*
                                                    |--------------------------------------------------------------------------
                                                    | LABEL TAHAP
                                                    |--------------------------------------------------------------------------
                                                    */

                                                    $stageLabel = match ($pendingStage) {

                                                        'instruktur' =>
                                                            'Asesmen Instruktur',

                                                        'kesehatan_awal' =>
                                                            'Asesmen Kesehatan Awal',

                                                        'case_conference' =>
                                                            'Case Conference',

                                                        'kesehatan_lanjutan' =>
                                                            'Asesmen Kesehatan Lanjutan',

                                                        default =>
                                                            'Pending',

                                                    };


                                                    /*
                                                    |--------------------------------------------------------------------------
                                                    | ROUTE DETAIL
                                                    |--------------------------------------------------------------------------
                                                    |
                                                    | ROUTE MENGIKUTI TAHAP PENDING.
                                                    | Semua route diambil dari web.php yang kamu kirim.
                                                    |
                                                    */

                                                    $route = match ($pendingStage) {

                                                        'instruktur' =>
                                                            route(
                                                                'ppks.normal.asesmen-instruktur.detail',
                                                                $ppks
                                                            ),

                                                        'kesehatan_awal' =>
                                                            route(
                                                                'ppks.normal.asesmen-kesehatan.awal',
                                                                $ppks
                                                            ),

                                                        'case_conference' =>
                                                            route(
                                                                'ppks.normal.case-conference.detail',
                                                                $ppks
                                                            ),

                                                        'kesehatan_lanjutan' =>
                                                            route(
                                                                'ppks.normal.kesehatan-lanjutan.detail',
                                                                $ppks
                                                            ),

                                                        default =>
                                                            '#',

                                                    };


                                                    /*
                                                    |--------------------------------------------------------------------------
                                                    | BADGE CLASS
                                                    |--------------------------------------------------------------------------
                                                    |
                                                    | SAMA DENGAN KODE A / DATA NORMAL.
                                                    |
                                                    */

                                                    $badgeClass = match ($pendingStage) {

                                                        'instruktur' =>
                                                            'result-instructor',

                                                        'kesehatan_awal' =>
                                                            'result-health',

                                                        'case_conference' =>
                                                            'result-case-conference',

                                                        'kesehatan_lanjutan' =>
                                                            'result-health-advanced',

                                                        default =>
                                                            'result-not-done',

                                                    };


                                                    /*
                                                    |--------------------------------------------------------------------------
                                                    | ICON BADGE
                                                    |--------------------------------------------------------------------------
                                                    |
                                                    | SAMA DENGAN KODE A / DATA NORMAL.
                                                    |
                                                    */

                                                    $hasilIcon = match ($pendingStage) {

                                                        'instruktur' =>
                                                            'assignment',

                                                        'kesehatan_awal' =>
                                                            'medical_services',

                                                        'case_conference' =>
                                                            'groups',

                                                        'kesehatan_lanjutan' =>
                                                            'medical_services',

                                                        default =>
                                                            'progress_activity',

                                                    };


                                                    /*
                                                    |--------------------------------------------------------------------------
                                                    | STATUS
                                                    |--------------------------------------------------------------------------
                                                    |
                                                    | REKOMENDASI DASHBOARD KHUSUS MENAMPILKAN
                                                    | PESERTA YANG STATUSNYA PENDING.
                                                    |
                                                    */

                                                    $hasil =
                                                        'Pending';

                                                    $hasilClass =
                                                        'pending';

                                                    $hasilDotClass =
                                                        'pending';


                                                    /*
                                                    |--------------------------------------------------------------------------
                                                    | KETERANGAN
                                                    |--------------------------------------------------------------------------
                                                    */

                                                    $keterangan =
                                                        $pendingProcess?->catatan
                                                        ?: $pendingProcess?->alasan_pending
                                                        ?: '-';

                                                @endphp


                                                <tr>

                                                    {{-- NO --}}
                                                    <td>
                                                        {{ $index + 1 }}
                                                    </td>


                                                    {{-- NAMA --}}
                                                    <td>
                                                        {{ data_get(
                                $ppksData,
                                'nama_lengkap',
                                '-'
                            ) }}
                                                    </td>


                                                    {{-- NIK --}}
                                                    <td>
                                                        {{ data_get(
                                $ppksData,
                                'nik',
                                '-'
                            ) }}
                                                    </td>


                                                    {{-- UMUR --}}
                                                    <td>
                                                        {{ $recommendation['age'] ?? '-' }}
                                                    </td>


                                                    {{-- JENIS PPKS --}}
                                                    <td>
                                                        {{ data_get(
                                $ppksData,
                                'jenis_ppks',
                                '-'
                            ) }}
                                                    </td>


                                                    {{-- JURUSAN --}}
                                                    <td>
                                                        {{ data_get(
                                $ppksData,
                                'jurusan_yang_diminati',
                                '-'
                            ) }}
                                                    </td>


                                                    {{-- =================================================
                                                    HASIL / RESULT BADGE
                                                    ================================================== --}}
                                                    <td>

                                                        <x-result-badge :route="$route" :badge-class="$badgeClass" :hasil-icon="$hasilIcon"
                                                            :label-tahapan="$stageLabel" :hasil-class="$hasilClass"
                                                            :hasil-dot-class="$hasilDotClass" :hasil="$hasil" />

                                                    </td>


                                                    {{-- KETERANGAN --}}
                                                    <td>
                                                        {{ $keterangan }}
                                                    </td>

                                                </tr>


                        @empty

                            <tr>

                                <td colspan="8" style="text-align: center;">
                                    Belum ada peserta pending.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>
        </div>
    </div>
    </div>
</x-app-layout>