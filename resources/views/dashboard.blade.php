<x-app-layout>

    <div class="min-h-screen bg-[#f3f4f8] text-gray-800">

        <div class="flex min-h-screen p-[18px] gap-[12px]">

            {{-- =========================================================
                 SIDEBAR
            ========================================================== --}}
            <aside
                id="sidebar"
                class="w-[180px] min-w-[180px] bg-white rounded-[14px] flex flex-col px-[10px] py-[14px] shadow-sm">

                {{-- Judul --}}
                <div class="px-[5px] pb-[8px]">
                    <div class="text-[8px] text-gray-400 mb-[6px]">
                        Dashboard
                    </div>

                    <div class="h-[1px] bg-gray-200"></div>
                </div>


                {{-- ================= DASHBOARD ================= --}}
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-[9px] h-[35px] px-[10px] rounded-[11px] bg-[#205d91] text-white text-[11px] mb-[3px]">

                    <svg width="13" height="13" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="1.8">
                        <rect x="4" y="4" width="6" height="6"/>
                        <rect x="14" y="4" width="6" height="6"/>
                        <rect x="4" y="14" width="6" height="6"/>
                        <rect x="14" y="14" width="6" height="6"/>
                    </svg>

                    <span>Dashboard</span>
                </a>


                {{-- ================= CASE CONFERENCE ================= --}}
                <a href="#"
                   class="menu-item">

                    <svg width="13" height="13" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="1.7">
                        <circle cx="8" cy="8" r="3"/>
                        <circle cx="16" cy="8" r="3"/>
                        <path d="M3 20c0-3 2-5 5-5"/>
                        <path d="M21 20c0-3-2-5-5-5"/>
                        <path d="M8 20c0-3 1.5-5 4-5s4 2 4 5"/>
                    </svg>

                    <span>Case Conference</span>
                </a>


                {{-- ================= DATA ================= --}}
                <a href="#" class="menu-item">

                    <svg width="13" height="13" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="1.7">
                        <path d="M6 3h12v18H6z"/>
                        <path d="M9 7h6"/>
                        <path d="M9 11h6"/>
                        <path d="M9 15h4"/>
                    </svg>

                    <span>Data</span>
                </a>


                {{-- ================= ASESMEN INSTRUKTUR ================= --}}
                <a href="#" class="menu-item">

                    <svg width="13" height="13" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="1.7">
                        <rect x="5" y="4" width="14" height="16" rx="1"/>
                        <circle cx="12" cy="9" r="2.5"/>
                        <path d="M8 17c.8-2 2.1-3 4-3s3.2 1 4 3"/>
                    </svg>

                    <span>Asesmen Instruktur</span>
                </a>


                {{-- SUB MENU --}}
                <a href="#" class="submenu">
                    <span class="arrow">↳</span>
                    <span>Data Lolos</span>
                </a>

                <a href="#" class="submenu">
                    <span class="arrow">↳</span>
                    <span>Data Pending</span>
                </a>

                <a href="#" class="submenu">
                    <span class="arrow">↳</span>
                    <span>Data Tidak Lolos</span>
                </a>


                {{-- ================= ASESMEN KESEHATAN ================= --}}
                <a href="#" class="menu-item">

                    <svg width="13" height="13" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="1.7">
                        <rect x="5" y="4" width="14" height="16" rx="1"/>
                        <path d="M9 12h6"/>
                        <path d="M12 9v6"/>
                    </svg>

                    <span>Asesmen Kesehatan</span>
                </a>


                <a href="#" class="submenu">
                    <span class="arrow">↳</span>
                    <span>Data Lolos</span>
                </a>

                <a href="#" class="submenu">
                    <span class="arrow">↳</span>
                    <span>Data Pending</span>
                </a>

                <a href="#" class="submenu">
                    <span class="arrow">↳</span>
                    <span>Data Tidak Lolos</span>
                </a>


                {{-- ================= PEMANGGILAN ================= --}}
                <a href="#" class="menu-item">

                    <svg width="13" height="13" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="1.7">
                        <rect x="4" y="6" width="16" height="12" rx="1"/>
                        <path d="M8 10h8"/>
                        <path d="M8 14h5"/>
                    </svg>

                    <span>Pemanggilan Peserta</span>
                </a>


                {{-- ================= PESERTA AKTIF ================= --}}
                <a href="#" class="menu-item">

                    <svg width="13" height="13" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="1.7">
                        <circle cx="9" cy="8" r="3"/>
                        <path d="M3 20c0-4 2-6 6-6"/>
                        <path d="M16 11v6"/>
                        <path d="M13 14h6"/>
                    </svg>

                    <span>Peserta Aktif</span>
                </a>


                {{-- ================= KELUAR ================= --}}
                <div class="mt-auto pt-[12px] px-[9px]">

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button type="submit"
                            class="w-full h-[38px] border border-gray-300 rounded-[10px] flex items-center gap-[9px] px-[12px] text-[10px] text-gray-700 hover:bg-gray-50">

                            <svg width="13" height="13" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="1.7">
                                <path d="M10 5H6a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h4"/>
                                <path d="M14 8l4 4-4 4"/>
                                <path d="M18 12H9"/>
                            </svg>

                            <span>Keluar</span>

                        </button>
                    </form>

                </div>

            </aside>


            {{-- =========================================================
                 MAIN CONTENT
            ========================================================== --}}
            <main class="flex-1 min-w-0">


                {{-- =====================================================
                     TOP NAVBAR
                ====================================================== --}}
                <div
                    class="h-[42px] bg-white rounded-[13px] shadow-sm flex items-center justify-between px-[14px]">

                    {{-- Hamburger --}}
                    <button
                        type="button"
                        class="w-[28px] h-[28px] flex items-center justify-center">

                        <svg width="19" height="19" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="1.7">

                            <path d="M4 6h16"/>
                            <path d="M4 12h16"/>
                            <path d="M4 18h16"/>

                        </svg>

                    </button>


                    {{-- USER --}}
                    <div class="flex items-center gap-[7px]">

                        <div class="text-right leading-tight">

                            <div class="text-[8px] font-semibold text-gray-800">
                                {{ Auth::user()->name }}
                            </div>

                            <div class="text-[6px] text-gray-500">
                                {{ Auth::user()->role ?? 'Super Admin' }}
                            </div>

                        </div>


                        <div
                            class="w-[21px] h-[21px] rounded-full bg-gray-700 flex items-center justify-center text-white">

                            <svg width="14" height="14" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2">

                                <circle cx="12" cy="8" r="3"/>
                                <path d="M5 21c0-4 3-7 7-7s7 3 7 7"/>

                            </svg>

                        </div>

                    </div>

                </div>


                {{-- =====================================================
                     DATE FILTER
                ====================================================== --}}
                <div class="mt-[9px] mb-[10px]">

                    <button
                        class="h-[31px] bg-white rounded-[10px] px-[9px] flex items-center gap-[7px] text-[9px] text-gray-700 shadow-sm">

                        <svg width="11" height="11" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="1.8">

                            <rect x="4" y="5" width="16" height="15" rx="1"/>
                            <path d="M8 3v4"/>
                            <path d="M16 3v4"/>
                            <path d="M4 10h16"/>

                        </svg>

                        Oct 12, 2023 – Oct 19, 2023

                        <svg width="10" height="10" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2">

                            <path d="M6 9l6 6 6-6"/>

                        </svg>

                    </button>

                </div>


                {{-- =====================================================
                     STATISTICS
                ====================================================== --}}
                <div class="grid grid-cols-4 gap-[14px] mb-[10px]">

                    <div class="dashboard-card">
                        <div class="card-title">Total Response</div>
                        <div class="card-number">300</div>
                    </div>

                    <div class="dashboard-card">
                        <div class="card-title">Sudah Dilayani</div>
                        <div class="card-number">300</div>
                    </div>

                    <div class="dashboard-card">
                        <div class="card-title">Belum Dilayani</div>
                        <div class="card-number">300</div>
                    </div>

                    <div class="dashboard-card">
                        <div class="card-title">Siswa Pending</div>
                        <div class="card-number">300</div>
                    </div>

                </div>


                {{-- =====================================================
                     CHART ROW 1
                ====================================================== --}}
                <div class="grid grid-cols-[1.7fr_1fr] gap-[10px] mb-[10px]">


                    {{-- LINE --}}
                    <div class="chart-card">

                        <div class="chart-title">
                            Google Form Response
                        </div>

                        <div class="h-[132px]">
                            <canvas id="responseChart"></canvas>
                        </div>

                    </div>


                    {{-- PIE --}}
                    <div class="chart-card">

                        <div class="chart-title">
                            Disabilitas Fisik
                        </div>

                        <div class="h-[132px]">
                            <canvas id="disabilityChart"></canvas>
                        </div>

                    </div>

                </div>


                {{-- =====================================================
                     CHART ROW 2
                ====================================================== --}}
                <div class="grid grid-cols-[1.35fr_1fr] gap-[10px] mb-[12px]">


                    {{-- BAR --}}
                    <div class="chart-card">

                        <div class="chart-title">
                            Pendaftar Berdasarkan PPKS
                        </div>

                        <div class="h-[132px]">
                            <canvas id="ppksBar"></canvas>
                        </div>

                    </div>


                    {{-- DONUT --}}
                    <div class="chart-card">

                        <div class="chart-title">
                            Pendaftar Berdasarkan PPKS
                        </div>

                        <div class="h-[132px]">
                            <canvas id="ppksDonut"></canvas>
                        </div>

                    </div>

                </div>


                {{-- =====================================================
                     TABLE
                ====================================================== --}}
                <div class="bg-white rounded-[13px] shadow-sm px-[16px] pt-[15px] pb-[12px]">


                    {{-- TITLE --}}
                    <div class="flex items-center justify-between mb-[10px]">

                        <div class="text-[10px] font-semibold text-gray-800">
                            Rekomendasi Siswa Berdasarkan Data Pending
                        </div>

                        <a href="#"
                           class="text-[7px] text-[#205d91] hover:underline">

                            Lihat Semua

                        </a>

                    </div>


                    {{-- TABLE --}}
                    <div class="overflow-hidden rounded-[11px] border border-gray-100">

                        <table class="w-full border-collapse">

                            <thead>

                                <tr class="bg-[#205d91] text-white">

                                    <th class="table-head w-[38px]">No</th>
                                    <th class="table-head">Nama</th>
                                    <th class="table-head">NIK</th>
                                    <th class="table-head">No HP</th>
                                    <th class="table-head">Jenis PPKS</th>
                                    <th class="table-head w-[175px]">Tahapan</th>
                                    <th class="table-head">Keterangan</th>

                                </tr>

                            </thead>


                            <tbody>

                                @php

                                    $students = [

                                        [
                                            'nama' => 'Siti Rahmawati',
                                            'nik' => '012345678',
                                            'hp' => '0897654321',
                                            'ppks' => 'Disabilitas fisik',
                                            'tahapan' => 'Asesmen Instruktur',
                                            'ket' => 'Masih Sekolah',
                                            'warna' => 'yellow'
                                        ],

                                        [
                                            'nama' => 'Siti Rahmawati',
                                            'nik' => '012345678',
                                            'hp' => '0897654321',
                                            'ppks' => 'Disabilitas fisik',
                                            'tahapan' => 'Asesmen Instruktur',
                                            'ket' => 'Sudah bekerja',
                                            'warna' => 'yellow'
                                        ],

                                        [
                                            'nama' => 'Siti Rahmawati',
                                            'nik' => '012345678',
                                            'hp' => '0897654321',
                                            'ppks' => 'Disabilitas fisik',
                                            'tahapan' => 'Asesmen Kesehatan Awal',
                                            'ket' => 'Minum obat',
                                            'warna' => 'purple'
                                        ],

                                        [
                                            'nama' => 'Siti Rahmawati',
                                            'nik' => '012345678',
                                            'hp' => '0897654321',
                                            'ppks' => 'Disabilitas fisik',
                                            'tahapan' => 'Asesmen Instruktur',
                                            'ket' => 'Masih Sekolah',
                                            'warna' => 'yellow'
                                        ],

                                        [
                                            'nama' => 'Siti Rahmawati',
                                            'nik' => '012345678',
                                            'hp' => '0897654321',
                                            'ppks' => 'Disabilitas fisik',
                                            'tahapan' => 'Asesmen Instruktur',
                                            'ket' => 'Sudah bekerja',
                                            'warna' => 'yellow'
                                        ]

                                    ];

                                @endphp


                                @foreach ($students as $index => $student)

                                    <tr class="border-b border-gray-100 last:border-b-0 hover:bg-gray-50">


                                        <td class="table-cell text-center">
                                            {{ $index + 1 }}
                                        </td>


                                        <td class="table-cell">
                                            {{ $student['nama'] }}
                                        </td>


                                        <td class="table-cell">
                                            {{ $student['nik'] }}
                                        </td>


                                        <td class="table-cell">
                                            {{ $student['hp'] }}
                                        </td>


                                        <td class="table-cell">
                                            {{ $student['ppks'] }}
                                        </td>


                                        <td class="table-cell">

                                            @if($student['warna'] === 'purple')

                                                <div class="stage purple-stage">

                                                    <div class="stage-icon purple-icon">
                                                        ✓
                                                    </div>

                                                    <div class="flex-1">

                                                        <div class="stage-title">
                                                            {{ $student['tahapan'] }}
                                                        </div>

                                                        <div class="stage-status">
                                                            Pending
                                                        </div>

                                                    </div>

                                                    <div class="stage-arrow">
                                                        ›
                                                    </div>

                                                </div>

                                            @else

                                                <div class="stage yellow-stage">

                                                    <div class="stage-icon yellow-icon">
                                                        ✓
                                                    </div>

                                                    <div class="flex-1">

                                                        <div class="stage-title">
                                                            {{ $student['tahapan'] }}
                                                        </div>

                                                        <div class="stage-status">
                                                            Pending
                                                        </div>

                                                    </div>

                                                    <div class="stage-arrow">
                                                        ›
                                                    </div>

                                                </div>

                                            @endif

                                        </td>


                                        <td class="table-cell">
                                            {{ $student['ket'] }}
                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

            </main>

        </div>

    </div>


    {{-- ================================================================
         CSS
    ================================================================= --}}
    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            overflow-x: hidden;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 9px;
            height: 30px;
            padding: 0 10px;
            border-radius: 9px;
            color: #202020;
            font-size: 9px;
            transition: .15s;
        }

        .menu-item:hover {
            background: #f3f4f6;
        }

        .submenu {
            display: flex;
            align-items: center;
            gap: 8px;
            height: 25px;
            padding-left: 13px;
            color: #202020;
            font-size: 9px;
            transition: .15s;
        }

        .submenu:hover {
            color: #205d91;
        }

        .arrow {
            font-size: 15px;
            line-height: 1;
        }

        .dashboard-card {
            height: 69px;
            background: white;
            border-radius: 13px;
            padding: 14px;
            box-shadow: 0 1px 2px rgba(0,0,0,.02);
        }

        .card-title {
            font-size: 9px;
            color: #222;
            margin-bottom: 6px;
        }

        .card-number {
            font-size: 21px;
            line-height: 1;
            font-weight: 700;
            color: #205d91;
        }

        .chart-card {
            background: white;
            border-radius: 13px;
            padding: 12px 14px;
            min-width: 0;
        }

        .chart-title {
            font-size: 10px;
            font-weight: 500;
            color: #1d1d1d;
            margin-bottom: 4px;
        }

        .table-head {
            height: 31px;
            padding: 0 9px;
            text-align: left;
            font-size: 7px;
            font-weight: 500;
        }

        .table-cell {
            height: 31px;
            padding: 3px 9px;
            font-size: 7px;
            color: #222;
            white-space: nowrap;
        }

        .stage {
            height: 25px;
            width: 100%;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 5px;
            padding: 3px 6px;
        }

        .yellow-stage {
            background: #fff9e8;
        }

        .purple-stage {
            background: #f5ebff;
        }

        .stage-icon {
            width: 15px;
            height: 15px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 8px;
            color: white;
            flex-shrink: 0;
        }

        .yellow-icon {
            background: #f4bd18;
        }

        .purple-icon {
            background: #a855f7;
        }

        .stage-title {
            font-size: 7px;
            font-weight: 500;
            line-height: 8px;
        }

        .stage-status {
            font-size: 6px;
            color: #9ca3af;
            line-height: 7px;
        }

        .stage-arrow {
            font-size: 14px;
            color: #555;
            margin-left: auto;
        }


        /* Desktop */
        @media (min-width: 1200px) {

            .table-cell {
                font-size: 7px;
            }

        }


        /* Laptop */
        @media (max-width: 1100px) {

            .flex.min-h-screen {
                padding: 10px !important;
            }

            aside {
                width: 170px !important;
                min-width: 170px !important;
            }

            .grid-cols-4 {
                gap: 8px !important;
            }

            .dashboard-card {
                padding: 10px;
            }

            .card-number {
                font-size: 18px;
            }

        }


        /* Mobile */
        @media (max-width: 768px) {

            aside {
                display: none;
            }

            .grid-cols-4 {
                grid-template-columns: repeat(2, 1fr) !important;
            }

            .grid-cols-\[1\.7fr_1fr\],
            .grid-cols-\[1\.35fr_1fr\] {
                grid-template-columns: 1fr !important;
            }

            .table-cell {
                font-size: 8px;
            }

        }

    </style>


    {{-- ================================================================
         CHART.JS
    ================================================================= --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>

        document.addEventListener('DOMContentLoaded', function () {


            /* ==========================================================
               LINE CHART
            =========================================================== */

            const responseCanvas =
                document.getElementById('responseChart');

            if (responseCanvas) {

                new Chart(responseCanvas, {

                    type: 'line',

                    data: {

                        labels: [
                            'Senin',
                            'Selasa',
                            'Rabu',
                            'Kamis',
                            'Jumat',
                            'Sabtu',
                            'Minggu'
                        ],

                        datasets: [{

                            data: [
                                2,
                                6,
                                7,
                                11,
                                3,
                                13,
                                15
                            ],

                            borderColor: '#205d91',

                            borderWidth: 2.5,

                            pointRadius: 0,

                            tension: .42,

                            fill: false

                        }]

                    },

                    options: {

                        responsive: true,

                        maintainAspectRatio: false,

                        plugins: {

                            legend: {
                                display: false
                            }

                        },

                        scales: {

                            y: {

                                beginAtZero: true,

                                max: 20,

                                ticks: {
                                    stepSize: 5,
                                    font: {
                                        size: 7
                                    },
                                    color: '#999'
                                },

                                grid: {
                                    color: '#d9d9d9'
                                }

                            },

                            x: {

                                ticks: {
                                    font: {
                                        size: 7
                                    },
                                    color: '#222'
                                },

                                grid: {
                                    display: false
                                }

                            }

                        }

                    }

                });

            }


            /* ==========================================================
               PIE CHART
            =========================================================== */

            const disabilityCanvas =
                document.getElementById('disabilityChart');

            if (disabilityCanvas) {

                new Chart(disabilityCanvas, {

                    type: 'pie',

                    data: {

                        labels: [
                            'Disabilitas Fisik',
                            'Disabilitas Fisik',
                            'Disabilitas Fisik'
                        ],

                        datasets: [{

                            data: [
                                60,
                                30,
                                10
                            ],

                            backgroundColor: [
                                '#22c55e',
                                '#f59e0b',
                                '#ef4444'
                            ],

                            borderWidth: 0

                        }]

                    },

                    options: {

                        responsive: true,

                        maintainAspectRatio: false,

                        layout: {
                            padding: 0
                        },

                        plugins: {

                            legend: {

                                position: 'right',

                                labels: {

                                    boxWidth: 6,

                                    boxHeight: 6,

                                    padding: 5,

                                    font: {
                                        size: 7
                                    }

                                }

                            }

                        }

                    }

                });

            }


            /* ==========================================================
               BAR CHART
            =========================================================== */

            const barCanvas =
                document.getElementById('ppksBar');

            if (barCanvas) {

                new Chart(barCanvas, {

                    type: 'bar',

                    data: {

                        labels: [
                            'DKI Jakarta',
                            'Jawa Barat',
                            'Kalimantan Timur',
                            'Sumatra Barat',
                            'Sulawesi Barat'
                        ],

                        datasets: [{

                            data: [
                                42,
                                40,
                                12,
                                78,
                                50
                            ],

                            backgroundColor: '#205d91',

                            borderRadius: 0,

                            barThickness: 9

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

                                max: 90,

                                ticks: {

                                    stepSize: 10,

                                    font: {
                                        size: 7
                                    },

                                    color: '#999'

                                },

                                grid: {
                                    color: '#d9d9d9'
                                }

                            },

                            y: {

                                ticks: {

                                    font: {
                                        size: 7
                                    },

                                    color: '#222'

                                },

                                grid: {
                                    display: false
                                }

                            }

                        }

                    }

                });

            }


            /* ==========================================================
               DONUT
            =========================================================== */

            const donutCanvas =
                document.getElementById('ppksDonut');

            if (donutCanvas) {

                new Chart(donutCanvas, {

                    type: 'doughnut',

                    data: {

                        labels: [
                            'Disabilitas Fisik',
                            'Disabilitas Fisik',
                            'Disabilitas Fisik',
                            'Disabilitas Fisik'
                        ],

                        datasets: [{

                            data: [
                                60,
                                30,
                                7,
                                3
                            ],

                            backgroundColor: [
                                '#22c55e',
                                '#f59e0b',
                                '#38bdf8',
                                '#ef4444'
                            ],

                            borderWidth: 0

                        }]

                    },

                    options: {

                        cutout: '60%',

                        responsive: true,

                        maintainAspectRatio: false,

                        plugins: {

                            legend: {

                                position: 'right',

                                labels: {

                                    boxWidth: 6,

                                    boxHeight: 6,

                                    padding: 5,

                                    font: {
                                        size: 7
                                    }

                                }

                            }

                        }

                    }

                });

            }

        });

    </script>

</x-app-layout>
