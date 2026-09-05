<x-app-layout>

    <style>
        .case-conference-page {
            width: 100%;
            padding: 10px 0 35px;
            color: #172018;
        }

        .case-conference-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
            margin-bottom: 24px;
        }

        .case-conference-header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
            color: #172018;
        }

        .case-conference-header p {
            margin: 6px 0 0;
            color: #68716b;
            font-size: 14px;
        }

        .date-filter {
            display: flex;
            align-items: center;
            gap: 9px;
            border: 1px solid #d9dedb;
            background: #fff;
            border-radius: 8px;
            padding: 9px 13px;
            color: #4d5751;
            font-size: 13px;
            cursor: pointer;
        }

        .case-filter-wrapper {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 18px;
        }

        .case-search {
            display: flex;
            align-items: center;
            gap: 9px;
            width: 310px;
            height: 40px;
            padding: 0 13px;
            background: #fff;
            border: 1px solid #d9dedb;
            border-radius: 8px;
        }

        .case-search svg {
            flex-shrink: 0;
            color: #7a847d;
        }

        .case-search input {
            width: 100%;
            border: none;
            outline: none;
            background: transparent;
            font-size: 13px;
            color: #26302a;
        }

        .case-search input::placeholder {
            color: #929a95;
        }

        .case-filter-button {
            height: 40px;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 0 14px;
            border: 1px solid #d9dedb;
            border-radius: 8px;
            background: #fff;
            color: #4d5751;
            font-size: 13px;
            cursor: pointer;
        }

        .table-wrapper {
            width: 100%;
            background: #fff;
            border: 1px solid #e0e4e1;
            border-radius: 10px;
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1050px;
        }

        .table thead {
            background: #f7f8f7;
        }

        .table th {
            padding: 14px 16px;
            text-align: left;
            font-size: 12px;
            font-weight: 700;
            color: #59635c;
            border-bottom: 1px solid #e1e5e2;
            white-space: nowrap;
        }

        .table td {
            padding: 15px 16px;
            font-size: 13px;
            color: #303932;
            border-bottom: 1px solid #edf0ee;
            vertical-align: middle;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .table tbody tr:hover {
            background: #fafbfa;
        }

        .result-badge {
            min-width: 190px;
            display: inline-flex;
            align-items: center;
            gap: 9px;
            padding: 8px 10px;
            border-radius: 8px;
            text-decoration: none;
            transition: .15s ease;
        }

        .result-badge:hover {
            opacity: .85;
        }

        .result-health {
            background: #edf8f0;
            color: #28733c;
        }

        .result-icon {
            font-size: 20px;
            flex-shrink: 0;
        }

        .result-content {
            display: flex;
            flex-direction: column;
            gap: 3px;
            flex: 1;
        }

        .result-title {
            font-size: 12px;
            font-weight: 700;
        }

        .result-status {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 11px;
            font-weight: 600;
        }

        .status-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            display: inline-block;
        }

        .status-dot.lolos {
            background: #39a354;
        }

        .result-arrow {
            font-size: 22px;
            line-height: 1;
            color: #6d776f;
        }

        .empty-state {
            text-align: center;
            padding: 55px 20px !important;
            color: #747d77 !important;
        }

        .empty-state .material-symbols-outlined {
            font-size: 45px;
            margin-bottom: 10px;
            color: #9aa39d;
        }

        .empty-state p {
            margin: 0;
            font-size: 14px;
        }

        .case-pagination {
            padding: 15px 18px;
            border-top: 1px solid #edf0ee;
        }

        @media (max-width: 900px) {

            .case-conference-header {
                flex-direction: column;
            }

            .date-filter {
                width: 100%;
                justify-content: center;
            }

            .case-filter-wrapper {
                flex-wrap: wrap;
            }

            .case-search {
                width: 100%;
            }

            .case-filter-button {
                flex: 1;
                justify-content: center;
            }
        }
    </style>


    <div class="case-conference-page">

        {{-- =====================================================
        HEADER
        ====================================================== --}}

        <div class="case-conference-header">

            <div>
                <h1>Case Conference</h1>

                <p>
                    Peserta yang telah lulus Asesmen Kesehatan Awal
                    dan belum melakukan Case Conference.
                </p>
            </div>


            {{-- DATE FILTER --}}

            <button type="button" class="date-filter">

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                >
                    <rect
                        x="3"
                        y="4"
                        width="18"
                        height="18"
                        rx="2"
                    />

                    <path d="M16 2v4" />
                    <path d="M8 2v4" />
                    <path d="M3 10h18" />
                </svg>

                <span>
                    Semua Tanggal
                </span>

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="17"
                    height="17"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path d="m6 9 6 6 6-6" />
                </svg>

            </button>

        </div>


        {{-- =====================================================
        FILTER
        ====================================================== --}}

        <div class="case-filter-wrapper">

            {{-- SEARCH --}}

            <div class="case-search">

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <circle cx="11" cy="11" r="7" />

                    <path d="m20 20-3.5-3.5" />
                </svg>

                <input
                    type="text"
                    placeholder="Cari Nama atau NIK"
                    id="caseSearch"
                >

            </div>


            {{-- FILTER JENIS PPKS --}}

            <button
                type="button"
                class="case-filter-button"
            >

                <span>
                    Semua Jenis PPKS
                </span>

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="13"
                    height="13"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path d="m6 9 6 6 6-6" />
                </svg>

            </button>


            {{-- FILTER HASIL --}}

            <button
                type="button"
                class="case-filter-button"
            >

                <span>
                    Lolos Kesehatan Awal
                </span>

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="13"
                    height="13"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path d="m6 9 6 6 6-6" />
                </svg>

            </button>

        </div>


        {{-- =====================================================
        TABLE
        ====================================================== --}}

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

                    @forelse ($data as $index => $ppks)

                        @php

                            $item = $ppks->data ?? [];

                            /*
                            |--------------------------------------------------------------------------
                            | NAMA
                            |--------------------------------------------------------------------------
                            */

                            $nama = $item['nama']
                            ?? $item['Nama']
                            ?? $item['NAMA']
                            ?? $item['nama_lengkap']
                            ?? $item['Nama Lengkap']
                            ?? $item['NAMA LENGKAP']
                            ?? $item['nama peserta']
                            ?? $item['Nama Peserta']
                            ?? '-';



                            /*
                            |--------------------------------------------------------------------------
                            | NIK
                            |--------------------------------------------------------------------------
                            */

                            $nik =
                                $item['nik'] ??
                                $item['NIK'] ??
                                $item['Nik'] ??
                                '-';


                            /*
                            |--------------------------------------------------------------------------
                            | UMUR
                            |--------------------------------------------------------------------------
                            */

                            $umur =
                                $item['umur'] ??
                                $item['Umur'] ??
                                $item['UMUR'] ??
                                '-';


                            /*
                            |--------------------------------------------------------------------------
                            | JENIS PPKS
                            |--------------------------------------------------------------------------
                            */

                            $jenisPpks =
                                $item['jenis_ppks'] ??
                                $item['Jenis PPKS'] ??
                                $item['jenis ppks'] ??
                                $item['jenis'] ??
                                $item['Jenis'] ??
                                '-';


                            /*
                            |--------------------------------------------------------------------------
                            | JURUSAN
                            |--------------------------------------------------------------------------
                            */

                            $jurusan =
                                $item['jurusan'] ??
                                $item['Jurusan'] ??
                                $item['JURUSAN'] ??
                                '-';

                        @endphp


                        <tr>

                            {{-- NO --}}

                            <td>
                                {{ $data->firstItem() + $index }}
                            </td>


                            {{-- NAMA --}}

                            <td>
                                <strong>
                                    {{ $nama }}
                                </strong>
                            </td>


                            {{-- NIK --}}

                            <td>
                                {{ $nik }}
                            </td>


                            {{-- UMUR --}}

                            <td>
                                {{ $umur }}
                            </td>


                            {{-- JENIS PPKS --}}

                            <td>
                                {{ $jenisPpks }}
                            </td>


                            {{-- JURUSAN --}}

                            <td>
                                {{ $jurusan }}
                            </td>


                            {{-- HASIL --}}

                            <td>

                                <a
                                    href="{{ route(
                                        'ppks.normal.case-conference.detail',
                                        $ppks->id
                                    ) }}"
                                    class="result-badge result-health"
                                >

                                    <span class="material-symbols-outlined result-icon">
                                        medical_services
                                    </span>


                                    <div class="result-content">

                                        <span class="result-title">
                                            Asesmen Kesehatan
                                        </span>


                                        <span class="result-status">

                                            <span class="status-dot lolos"></span>

                                            Lolos

                                        </span>

                                    </div>


                                    <span class="result-arrow">
                                        ›
                                    </span>

                                </a>

                            </td>


                            {{-- KETERANGAN --}}

                            <td>
                                Belum dilakukan Case Conference
                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td
                                colspan="8"
                                class="empty-state"
                            >

                                <span class="material-symbols-outlined">
                                    event_busy
                                </span>

                                <p>
                                    Belum ada peserta yang perlu
                                    melakukan Case Conference.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>


            {{-- =================================================
            PAGINATION
            ================================================== --}}

            @if ($data->hasPages())

                <div class="case-pagination">

                    {{ $data->links() }}

                </div>

            @endif

        </div>

    </div>


    {{-- =====================================================
    SEARCH FRONTEND
    ====================================================== --}}

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const searchInput =
                document.getElementById('caseSearch');

            if (!searchInput) {
                return;
            }

            searchInput.addEventListener('input', function () {

                const keyword =
                    this.value.toLowerCase().trim();

                const rows =
                    document.querySelectorAll(
                        '.table tbody tr'
                    );

                rows.forEach(function (row) {

                    const text =
                        row.textContent.toLowerCase();

                    if (text.includes(keyword)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }

                });

            });

        });

    </script>

</x-app-layout>
