<x-app-layout>

    {{-- =====================================================
    STATISTICS
    ====================================================== --}}
    <section class="stats-grid">

        {{-- TOTAL PENDAFTAR --}}
        <div class="stat-card">

            <div class="stat-header">
                <span class="stat-title">
                    Total Pendaftar
                </span>

                <span class="material-symbols-outlined stat-icon blue">
                    groups
                </span>
            </div>

            <div class="stat-value">
                {{ number_format($totalPendaftar) }}
                <span>peserta</span>
            </div>

            <div class="stat-progress">
                <div
                    class="stat-progress-fill blue"
                    style="width: 100%">
                </div>
            </div>

            <div class="stat-meta">
                <span>Seluruh peserta mendaftar</span>
                <strong>100%</strong>
            </div>

        </div>


        {{-- SUDAH DILAYANI --}}
        <div class="stat-card">

            <div class="stat-header">
                <span class="stat-title">
                    Sudah Dilayani
                </span>

                <span class="material-symbols-outlined stat-icon green">
                    task_alt
                </span>
            </div>

            <div class="stat-value">
                {{ number_format($sudahDilayani) }}
                <span>peserta</span>
            </div>

            <div class="stat-progress">
                <div
                    class="stat-progress-fill green"
                    style="width: {{ $sudahDilayaniPercentage }}%">
                </div>
            </div>

            <div class="stat-meta">
                <span>
                    Dari {{ number_format($totalPendaftar) }} pendaftar
                </span>

                <strong>
                    {{ $sudahDilayaniPercentage }}%
                </strong>
            </div>

        </div>


        {{-- BELUM DILAYANI --}}
        <div class="stat-card">

            <div class="stat-header">
                <span class="stat-title">
                    Belum Dilayani
                </span>

                <span class="material-symbols-outlined stat-icon orange">
                    pending_actions
                </span>
            </div>

            <div class="stat-value">
                {{ number_format($belumDilayani) }}
                <span>peserta</span>
            </div>

            <div class="stat-progress">
                <div
                    class="stat-progress-fill orange"
                    style="width: {{ $belumDilayaniPercentage }}%">
                </div>
            </div>

            <div class="stat-meta">
                <span>
                    Dari {{ number_format($totalPendaftar) }} pendaftar
                </span>

                <strong>
                    {{ $belumDilayaniPercentage }}%
                </strong>
            </div>

        </div>


        {{-- PENDING --}}
        <div class="stat-card">

            <div class="stat-header">
                <span class="stat-title">
                    Siswa Pending
                </span>

                <span class="material-symbols-outlined stat-icon purple">
                    person_alert
                </span>
            </div>

            <div class="stat-value">
                {{ number_format($pending) }}
                <span>peserta</span>
            </div>

            <div class="stat-progress">
                <div
                    class="stat-progress-fill purple"
                    style="width: {{ $pendingPercentage }}%">
                </div>
            </div>

            <div class="stat-meta">
                <span>
                    Dari {{ number_format($totalPendaftar) }} pendaftar
                </span>

                <strong>
                    {{ $pendingPercentage }}%
                </strong>
            </div>

        </div>

    </section>


    {{-- =====================================================
    ROW 1 — TREN PENDAFTAR
    ====================================================== --}}
    <section class="dashboard-grid">

        <div class="content-card">

            <div class="table-card-header">

                <div>

                    <h2 class="section-title">
                        Pendaftar Berdasarkan Periode
                    </h2>

                    <div class="chart-subtitle">
                        Tren jumlah pendaftar setiap bulan
                    </div>

                </div>


                {{-- TAHUN DARI DATABASE --}}
                <select
                    id="yearFilter"
                    class="chart-filter"
                    onchange="
                        if (this.value) {
                            window.location.href =
                            '{{ route('dashboard') }}?year=' + this.value;
                        }
                    "
                >

                    @forelse ($availableYears as $year)

                        <option
                            value="{{ $year }}"
                            @selected((int) $selectedYear === (int) $year)
                        >
                            {{ $year }}
                        </option>

                    @empty

                        <option value="">
                            Tidak ada data tahun
                        </option>

                    @endforelse

                </select>

            </div>


            <div class="chart-container chart-large">

                <canvas id="registrationTrend"></canvas>

            </div>

        </div>

    </section>


    {{-- =====================================================
    ROW 2
    ====================================================== --}}
    <section class="dashboard-grid grid-large-small">


        {{-- 5 PROVINSI TERTINGGI --}}
        <div class="content-card">

            <div class="section-title">
                5 Provinsi Pendaftar Tertinggi
            </div>

            <div class="chart-subtitle">
                Berdasarkan jumlah pendaftar
            </div>

            <div class="chart-container">

                <canvas id="regionChart"></canvas>

            </div>

        </div>


        {{-- JENIS DISABILITAS --}}
        <div class="content-card">

            <div class="section-title">
                Jenis Disabilitas
            </div>

            <div class="chart-subtitle">
                Komposisi pendaftar
            </div>

            <div class="chart-container">

                <canvas id="disabilityChart"></canvas>

            </div>

        </div>

    </section>


    {{-- =====================================================
    ROW 3
    ====================================================== --}}
    <section class="dashboard-grid grid-status-major">


        {{-- TAHAPAN PESERTA --}}
        <div class="content-card status-chart-card">

            <div class="section-title">
                Tahapan Peserta
            </div>

            <div class="chart-subtitle">
                Posisi peserta dalam proses pendaftaran
            </div>

            <div class="chart-container chart-status">

                <canvas id="statusChart"></canvas>

            </div>

        </div>


        {{-- JURUSAN DIMINATI --}}
        <div class="content-card major-chart-card">

            <div class="section-title">
                Jurusan yang Diminati
            </div>

            <div class="chart-subtitle">
                Berdasarkan pilihan peserta
            </div>

            <div class="chart-container chart-major">

                <canvas id="majorChart"></canvas>

            </div>

        </div>

    </section>


    {{-- =====================================================
    TABLE REKOMENDASI
    ====================================================== --}}
    <section class="table-card">

        <div class="table-card-header">

            <h2 class="section-title">
                Rekomendasi Siswa Berdasarkan Data Pending
            </h2>

            <a href="#" class="view-all-link">
                Lihat Semua
            </a>

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
                            $ppksData = $recommendation['ppks']->data ?? [];
                        @endphp

                        <tr>

                            <td>
                                {{ $index + 1 }}
                            </td>

                            <td>
                                {{ data_get($ppksData, 'nama_lengkap', '-') }}
                            </td>

                            <td>
                                {{ data_get($ppksData, 'nik', '-') }}
                            </td>

                            <td>
                                {{ $recommendation['age'] ?? '-' }}
                            </td>

                            <td>
                                {{ data_get($ppksData, 'jenis_ppks', '-') }}
                            </td>

                            <td>
                                {{ data_get($ppksData, 'jurusan_yang_diminati', '-') }}
                            </td>


                            {{-- HASIL --}}
                            <td>

                                <div class="result-wrapper">

                                    <span class="result-title result-health">
                                        Pending
                                    </span>

                                    <span class="result-status pending">

                                        <span class="status-dot pending"></span>

                                        Pending

                                    </span>

                                </div>

                            </td>


                            {{-- KETERANGAN --}}
                            <td>

                                @php
                                    $processes = $recommendation['ppks']
                                        ->prosesPesertas()
                                        ->where('tahap', 'case_conference')
                                        ->orderByDesc('tanggal_proses')
                                        ->orderByDesc('created_at')
                                        ->first();
                                @endphp

                                {{ $processes?->catatan
                                    ?: $processes?->alasan_pending
                                    ?: '-' }}

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="8"
                                style="text-align: center;"
                            >
                                Belum ada peserta pending.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </section>


    {{-- =====================================================
    CHART JS
    ====================================================== --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <script>

        document.addEventListener('DOMContentLoaded', function () {

            /* =====================================================
               COLOR SYSTEM
            ====================================================== */

            const rootStyles =
                getComputedStyle(
                    document.documentElement
                );


            const colors = {

                blue:
                    rootStyles
                        .getPropertyValue('--blue')
                        .trim(),

                blueLight:
                    rootStyles
                        .getPropertyValue('--blue-light')
                        .trim(),

                purple:
                    rootStyles
                        .getPropertyValue('--purple')
                        .trim(),

                purpleLight:
                    rootStyles
                        .getPropertyValue('--purple-light')
                        .trim(),

                green:
                    rootStyles
                        .getPropertyValue('--green')
                        .trim(),

                greenLight:
                    rootStyles
                        .getPropertyValue('--green-light')
                        .trim(),

                orange:
                    rootStyles
                        .getPropertyValue('--orange')
                        .trim(),

                orangeLight:
                    rootStyles
                        .getPropertyValue('--orange-light')
                        .trim(),

                red:
                    rootStyles
                        .getPropertyValue('--red')
                        .trim(),

                redLight:
                    rootStyles
                        .getPropertyValue('--red-light')
                        .trim(),

                border:
                    rootStyles
                        .getPropertyValue('--border')
                        .trim(),

                text:
                    rootStyles
                        .getPropertyValue('--text-secondary')
                        .trim(),

                muted:
                    rootStyles
                        .getPropertyValue('--muted')
                        .trim()

            };


            /* =====================================================
               DEFAULT CHART
            ====================================================== */

            Chart.defaults.font.family = 'Poppins';

            Chart.defaults.font.size = 11;

            Chart.defaults.color = colors.text;


            /* =====================================================
               1. REGISTRATION TREND
            ====================================================== */

            const trendCanvas =
                document.getElementById(
                    'registrationTrend'
                );


            if (trendCanvas) {

                new Chart(
                    trendCanvas,
                    {

                        type: 'line',

                        data: {

                            labels: @json($monthLabels),

                            datasets: [{

                                label: 'Pendaftar',

                                data:
                                    @json($registrationValues),

                                borderColor:
                                    colors.blue,

                                backgroundColor:
                                    'rgba(32, 93, 145, .08)',

                                borderWidth: 2.5,

                                pointRadius: 3.5,

                                pointHoverRadius: 6,

                                pointBackgroundColor:
                                    colors.blue,

                                pointBorderColor:
                                    colors.blue,

                                fill: true,

                                tension: .35

                            }]

                        },


                        options: {

                            responsive: true,

                            maintainAspectRatio: false,

                            interaction: {

                                intersect: false,

                                mode: 'index'

                            },


                            plugins: {

                                legend: {

                                    display: false

                                },


                                tooltip: {

                                    callbacks: {

                                        label:
                                            function (context) {

                                                return ' ' +
                                                    context.parsed.y +
                                                    ' pendaftar';

                                            }

                                    }

                                }

                            },


                            scales: {

                                y: {

                                    beginAtZero: true,

                                    grid: {

                                        color:
                                            colors.border

                                    },

                                    ticks: {

                                        precision: 0

                                    }

                                },


                                x: {

                                    grid: {

                                        display: false

                                    }

                                }

                            }

                        }

                    }
                );

            }


            /* =====================================================
               2. PROVINSI
            ====================================================== */

            const regionCanvas =
                document.getElementById(
                    'regionChart'
                );


            if (regionCanvas) {

                new Chart(
                    regionCanvas,
                    {

                        type: 'bar',

                        data: {

                            labels:
                                @json($provinceLabels),

                            datasets: [{

                                label:
                                    'Pendaftar',

                                data:
                                    @json($provinceValues),

                                backgroundColor:
                                    colors.blue,

                                borderRadius: 5,

                                barThickness: 14

                            }]

                        },


                        options: {

                            indexAxis: 'y',

                            responsive: true,

                            maintainAspectRatio: false,


                            plugins: {

                                legend: {

                                    display: false

                                }

                            },


                            scales: {

                                x: {

                                    beginAtZero: true,

                                    grid: {

                                        color:
                                            colors.border

                                    },

                                    ticks: {

                                        precision: 0

                                    }

                                },


                                y: {

                                    grid: {

                                        display: false

                                    }

                                }

                            }

                        }

                    }
                );

            }


            /* =====================================================
               3. STATUS / TAHAPAN
               POLAR AREA
            ====================================================== */

            const statusCanvas =
                document.getElementById(
                    'statusChart'
                );


            if (statusCanvas) {

                new Chart(
                    statusCanvas,
                    {

                        type: 'polarArea',

                        data: {

                            labels:
                                @json($stageLabels),

                            datasets: [{

                                data:
                                    @json($stageValues),

                                backgroundColor: [

                                    colors.blueLight,

                                    colors.orange,

                                    colors.purple,

                                    colors.green,

                                    colors.purpleLight,

                                    colors.orangeLight,

                                    colors.red

                                ],

                                borderColor:
                                    '#ffffff',

                                borderWidth: 3

                            }]

                        },


                        options: {

                            responsive: true,

                            maintainAspectRatio: false,


                            plugins: {

                                legend: {

                                    position:
                                        'bottom',

                                    labels: {

                                        boxWidth: 10,

                                        boxHeight: 10,

                                        padding: 10,

                                        usePointStyle:
                                            true,

                                        pointStyle:
                                            'circle',

                                        font: {

                                            size: 10

                                        }

                                    }

                                },


                                tooltip: {

                                    callbacks: {

                                        label:
                                            function (context) {

                                                return (
                                                    context.label +
                                                    ': ' +
                                                    context.raw +
                                                    ' Peserta'
                                                );

                                            }

                                    }

                                }

                            },


                            scales: {

                                r: {

                                    beginAtZero: true,

                                    ticks: {

                                        precision: 0

                                    },

                                    grid: {

                                        color:
                                            colors.border

                                    }

                                }

                            }

                        }

                    }
                );

            }


            /* =====================================================
               4. JURUSAN
            ====================================================== */

            const majorCanvas =
                document.getElementById(
                    'majorChart'
                );


            if (majorCanvas) {

                new Chart(
                    majorCanvas,
                    {

                        type: 'bar',

                        data: {

                            labels:
                                @json($majorLabels),

                            datasets: [{

                                label:
                                    'Peminat',

                                data:
                                    @json($majorValues),

                                backgroundColor:
                                    colors.blue,

                                borderRadius: 6,

                                barThickness: 32

                            }]

                        },


                        options: {

                            responsive: true,

                            maintainAspectRatio: false,


                            plugins: {

                                legend: {

                                    display: false

                                },


                                tooltip: {

                                    callbacks: {

                                        label:
                                            function (context) {

                                                return (
                                                    context.raw +
                                                    ' peminat'
                                                );

                                            }

                                    }

                                }

                            },


                            scales: {

                                y: {

                                    beginAtZero: true,

                                    grid: {

                                        color:
                                            colors.border

                                    },

                                    ticks: {

                                        precision: 0

                                    }

                                },


                                x: {

                                    grid: {

                                        display: false

                                    }

                                }

                            }

                        }

                    }
                );

            }


            /* =====================================================
               5. JENIS PPKS / DISABILITAS
            ====================================================== */

            const disabilityCanvas =
                document.getElementById(
                    'disabilityChart'
                );


            if (disabilityCanvas) {

                new Chart(
                    disabilityCanvas,
                    {

                        type: 'doughnut',

                        data: {

                            labels:
                                @json($disabilityLabels),

                            datasets: [{

                                data:
                                    @json($disabilityValues),

                                backgroundColor: [

                                    colors.blue,

                                    colors.blueLight,

                                    colors.orange,

                                    colors.purple,

                                    colors.green,

                                    colors.orangeLight,

                                    colors.red,

                                    colors.purpleLight

                                ],

                                borderWidth: 0

                            }]

                        },


                        options: {

                            cutout: '65%',

                            responsive: true,

                            maintainAspectRatio: false,


                            plugins: {

                                legend: {

                                    position:
                                        'bottom',

                                    labels: {

                                        boxWidth: 10,

                                        boxHeight: 10,

                                        padding: 10,

                                        font: {

                                            size: 10

                                        }

                                    }

                                }

                            }

                        }

                    }
                );

            }

        });

    </script>

</x-app-layout>