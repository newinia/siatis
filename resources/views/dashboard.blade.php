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
                500
                <span>peserta</span>
            </div>

            <div class="stat-progress">
                <div class="stat-progress-fill blue" style="width: 100%"></div>
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
                300
                <span>peserta</span>
            </div>

            <div class="stat-progress">
                <div class="stat-progress-fill green" style="width: 60%"></div>
            </div>

            <div class="stat-meta">
                <span>Dari 500 pendaftar</span>
                <strong>60%</strong>
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
                200
                <span>peserta</span>
            </div>

            <div class="stat-progress">
                <div class="stat-progress-fill orange" style="width: 40%"></div>
            </div>

            <div class="stat-meta">
                <span>Dari 500 pendaftar</span>
                <strong>40%</strong>
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
                45
                <span>peserta</span>
            </div>

            <div class="stat-progress">
                <div class="stat-progress-fill purple" style="width: 9%"></div>
            </div>

            <div class="stat-meta">
                <span>Dari 500 pendaftar</span>
                <strong>9%</strong>
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

                <select id="yearFilter" class="chart-filter">

                    <option value="2025">
                        2025
                    </option>

                    <option value="2024">
                        2024
                    </option>

                    <option value="2023">
                        2023
                    </option>

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


        {{-- 10 WILAYAH TERTINGGI --}}
        <div class="content-card">

            <div class="section-title">
                10 Wilayah Pendaftar Tertinggi
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
    TABLE
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

                    @php

                        $students = [

                            [
                                'nama' => 'Siti Rahmawati',
                                'nik' => '012345678',
                                'umur' => '18',
                                'ppks' => 'Disabilitas Fisik',
                                'jurusan' => 'Contact Center',
                                'hasil' => 'Asesmen Kesehatan',
                                'status' => 'health',
                                'keterangan' => '-',
                            ],

                            [
                                'nama' => 'Andi Saputra',
                                'nik' => '012345679',
                                'umur' => '20',
                                'ppks' => 'Disabilitas Fisik',
                                'jurusan' => 'Komputer',
                                'hasil' => 'Asesmen Kesehatan',
                                'status' => 'health',
                                'keterangan' => 'Tidak memenuhi syarat',
                            ],

                            [
                                'nama' => 'Budi Santoso',
                                'nik' => '012345680',
                                'umur' => '19',
                                'ppks' => 'Disabilitas Fisik',
                                'jurusan' => 'Desain Grafis',
                                'hasil' => 'Asesmen kesehatan',
                                'status' => 'instructor',
                                'keterangan' => '-',
                            ],

                            [
                                'nama' => 'Citra Lestari',
                                'nik' => '012345681',
                                'umur' => '23',
                                'ppks' => 'Disabilitas Fisik',
                                'jurusan' => 'Menjahit',
                                'hasil' => 'Asesmen kesehatan',
                                'status' => 'instructor',
                                'keterangan' => '-',
                            ],

                            [
                                'nama' => 'Dewi Anggraini',
                                'nik' => '012345682',
                                'umur' => '27',
                                'ppks' => 'Disabilitas Fisik',
                                'jurusan' => 'Teknik Elektro',
                                'hasil' => 'Asesmen Kesehatan',
                                'status' => 'health',
                                'keterangan' => '-',
                            ],

                            [
                                'nama' => 'Rizky Maulana',
                                'nik' => '012345683',
                                'umur' => '30',
                                'ppks' => 'Disabilitas Fisik',
                                'jurusan' => 'Teknik Mesin',
                                'hasil' => 'Asesmen Kesehatan',
                                'status' => 'health',
                                'keterangan' => '-',
                            ],

                        ];

                    @endphp


                    @foreach ($students as $index => $student)

                        <tr>

                            {{-- NO --}}
                            <td>
                                {{ $index + 1 }}
                            </td>


                            {{-- NAMA --}}
                            <td>
                                {{ $student['nama'] }}
                            </td>


                            {{-- NIK --}}
                            <td>
                                {{ $student['nik'] }}
                            </td>


                            {{-- UMUR --}}
                            <td>
                                {{ $student['umur'] }}
                            </td>


                            {{-- PPKS --}}
                            <td>
                                {{ $student['ppks'] }}
                            </td>


                            {{-- JURUSAN --}}
                            <td>
                                {{ $student['jurusan'] }}
                            </td>


                            {{-- HASIL --}}
                            <td>

                                {{-- ==========================
                                DITERIMA
                                =========================== --}}
                                @if ($student['status'] === 'accepted')

                                    <a href="#" class="result-badge result-accepted">

                                        <span class="material-symbols-outlined result-icon">
                                            task_alt
                                        </span>

                                        <span>
                                            Diterima
                                        </span>

                                        <span class="result-arrow">
                                            ›
                                        </span>

                                    </a>


                                    {{-- ==========================
                                    TIDAK DITERIMA
                                    =========================== --}}
                                @elseif ($student['status'] === 'rejected')

                                    <a href="#" class="result-badge result-rejected">

                                        <span class="material-symbols-outlined result-icon">
                                            cancel
                                        </span>

                                        <span>
                                            Tidak Diterima
                                        </span>

                                        <span class="result-arrow">
                                            ›
                                        </span>

                                    </a>


                                    {{-- ==========================
                                    ASESMEN kesehatan
                                    =========================== --}}
                                @elseif ($student['status'] === 'instructor')

                                    <a href="#" class="result-badge result-instructor">

                                        <span class="material-symbols-outlined result-icon">
                                            assignment
                                        </span>

                                        <div class="result-content">

                                            <span class="result-title result-instructor">
                                                Asesmen kesehatan
                                            </span>

                                            <span class="result-status pending">

                                                <span class="status-dot pending"></span>

                                                Pending

                                            </span>

                                        </div>

                                        <span class="result-arrow">
                                            ›
                                        </span>

                                    </a>


                                    {{-- ==========================
                                    ASESMEN KESEHATAN
                                    =========================== --}}
                                @elseif ($student['status'] === 'health')

                                    <a href="#" class="result-badge result-health">

                                        <span class="material-symbols-outlined result-icon">
                                            medical_services
                                        </span>

                                        <div class="result-content">

                                            <span class="result-title result-health">
                                                Asesmen Kesehatan
                                            </span>

                                            <span class="result-status pending">

                                                <span class="status-dot pending"></span>

                                                Pending

                                            </span>

                                        </div>

                                        <span class="result-arrow">
                                            ›
                                        </span>

                                    </a>

                                @endif

                            </td>


                            {{-- KETERANGAN --}}
                            <td>
                                {{ $student['keterangan'] }}
                            </td>

                        </tr>

                    @endforeach

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
            ===================================================== */

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
            ===================================================== */

            Chart.defaults.font.family = 'Poppins';

            Chart.defaults.font.size = 11;

            Chart.defaults.color = colors.text;


            /* =====================================================
               1. REGISTRATION TREND
            ===================================================== */

            const trendCanvas =
                document.getElementById(
                    'registrationTrend'
                );


            if (trendCanvas) {

                const yearlyData = {

                    2025: [
                        35, 48, 62, 75,
                        92, 110, 98, 125,
                        138, 120, 105, 88
                    ],

                    2024: [
                        28, 35, 45, 58,
                        72, 85, 90, 102,
                        110, 95, 82, 70
                    ],

                    2023: [
                        20, 30, 38, 42,
                        55, 65, 72, 80,
                        88, 75, 68, 60
                    ]

                };


                const trendChart =
                    new Chart(
                        trendCanvas,
                        {

                            type: 'line',

                            data: {

                                labels: [

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
                                    'Des'

                                ],

                                datasets: [{

                                    label:
                                        'Pendaftar',

                                    data:
                                        yearlyData[2025],

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


                const yearFilter =
                    document.getElementById(
                        'yearFilter'
                    );


                if (yearFilter) {

                    yearFilter.addEventListener(
                        'change',
                        function () {

                            const selectedYear =
                                this.value;

                            trendChart
                                .data
                                .datasets[0]
                                .data =
                                yearlyData[
                                selectedYear
                                ];

                            trendChart.update();

                        }
                    );

                }

            }


            /* =====================================================
               2. REGION
            ===================================================== */

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

                            labels: [

                                'Jawa Barat',
                                'Jawa Timur',
                                'Jawa Tengah',
                                'DKI Jakarta',
                                'Banten',

                            ],

                            datasets: [{

                                label:
                                    'Pendaftar',

                                data: [

                                    120,
                                    108,
                                    96,
                                    85,
                                    74,
                                    63,
                                    55,
                                    48,
                                    42,
                                    36

                                ],

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
            ===================================================== */

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

                            labels: [

                                'Belum Diolah',
                                'Asesmen kesehatan',
                                'Asesmen Kesehatan',
                                'Kesehatan Lanjutan',
                                'Case Conference',
                                'Pending',
                                'Ditolak'

                            ],

                            datasets: [{

                                data: [

                                    70,
                                    85,
                                    55,
                                    35,
                                    25,
                                    45,
                                    20

                                ],

                                backgroundColor: [

                                    colors.blueLight,
                                    colors.orange,
                                    colors.purple,
                                    colors.purpleLight,
                                    colors.green,
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

                                        display: false

                                    },

                                    grid: {

                                        color:
                                            colors.border

                                    },

                                    angleLines: {

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
               VERTICAL BAR
            ===================================================== */

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

                            labels: [

                                'Komputer',
                                'Desain Grafis',
                                'Penjahitan',
                                'CC',
                                'Elektro',
                                'Logam',
                                'Mesin'

                            ],

                            datasets: [{

                                label:
                                    'Peminat',

                                data: [

                                    50,
                                    120,
                                    85,
                                    65,
                                    75,
                                    55,
                                    70

                                ],

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
               5. DISABILITY
               DOUGHNUT
            ===================================================== */

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

                            labels: [

                                'Disabilitas Fisik',
                                'Disabilitas Sensorik',
                                'Disabilitas Mental',
                                'Disabilitas Intelektual'

                            ],

                            datasets: [{

                                data: [

                                    60,
                                    20,
                                    12,
                                    8

                                ],

                                backgroundColor: [

                                    colors.blue,
                                    colors.blueLight,
                                    colors.orange,
                                    colors.purple

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