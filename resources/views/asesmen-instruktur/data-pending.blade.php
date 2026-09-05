```blade
<x-app-layout>

    <style>
        /* =========================================================
           DATA PENDING INSTRUKTUR
        ========================================================= */

        .case-conference-page {
            width: 100%;
            padding: 10px 0 30px;
            color: #111827;
        }

        /* =========================================================
           HEADER
        ========================================================= */

        .case-conference-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 22px;
        }

        .case-conference-header h1 {
            margin: 0;
            font-size: 25px;
            line-height: 1.3;
            font-weight: 700;
            color: #111827;
        }

        .case-conference-header p {
            margin: 7px 0 0;
            font-size: 14px;
            color: #6b7280;
        }

        /* =========================================================
           DATE FILTER
        ========================================================= */

        .date-filter-wrapper {
            position: relative;
            flex-shrink: 0;
        }

        .date-filter {
            min-width: 175px;
            height: 42px;
            padding: 0 13px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 9px;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            background: #ffffff;
            color: #374151;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all .2s ease;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .04);
        }

        .date-filter:hover {
            border-color: #97D94D;
            color: #328300;
        }

        .date-filter svg {
            flex-shrink: 0;
        }

        .date-picker {
            position: absolute;
            z-index: 100;
            top: calc(100% + 8px);
            right: 0;
            width: 310px;
            padding: 16px;
            display: none;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 12px 35px rgba(0, 0, 0, .12);
        }

        .date-picker.active {
            display: block;
        }

        .date-picker-header {
            padding-bottom: 13px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 14px;
            color: #111827;
        }

        .date-input-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-top: 15px;
        }

        .date-input-group label {
            display: block;
            margin-bottom: 6px;
            font-size: 12px;
            font-weight: 600;
            color: #6b7280;
        }

        .date-input-group input {
            width: 100%;
            height: 38px;
            padding: 0 9px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: #ffffff;
            color: #374151;
            font-size: 12px;
            outline: none;
            transition: border-color .2s ease;
        }

        .date-input-group input:focus {
            border-color: #63AE00;
            box-shadow: 0 0 0 3px rgba(151, 217, 77, .15);
        }

        .date-picker-actions {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
            margin-top: 16px;
        }

        .date-reset,
        .date-apply {
            height: 36px;
            padding: 0 14px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all .2s ease;
        }

        .date-reset {
            border: 1px solid #e5e7eb;
            background: #f9fafb;
            color: #6b7280;
        }

        .date-reset:hover {
            background: #f3f4f6;
        }

        .date-apply {
            border: 1px solid #63AE00;
            background: #63AE00;
            color: #ffffff;
        }

        .date-apply:hover {
            background: #328300;
            border-color: #328300;
        }

        /* =========================================================
           NAVIGASI HASIL
        ========================================================= */

        .result-navigation {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
            margin: 0 0 20px;
        }

        .result-navigation a {
            min-height: 40px;
            padding: 9px 17px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            text-decoration: none;
            background: #f3f4f6;
            color: #374151;
            font-size: 13px;
            font-weight: 600;
            transition: all .2s ease;
        }

        .result-navigation a:hover {
            background: #e5e7eb;
            color: #111827;
        }

        .result-navigation a.active {
            background: #97D94D;
            color: #ffffff;
            box-shadow: 0 4px 10px rgba(99, 174, 0, .18);
        }

        .result-navigation a.active:hover {
            background: #63AE00;
        }

        /* =========================================================
           FILTER SEARCH
        ========================================================= */

        .case-filter-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 16px;
        }

        .case-search {
            width: 100%;
            max-width: 390px;
            height: 42px;
            padding: 0 13px;
            display: flex;
            align-items: center;
            gap: 9px;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            background: #ffffff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .03);
            transition: all .2s ease;
        }

        .case-search:focus-within {
            border-color: #63AE00;
            box-shadow: 0 0 0 3px rgba(151, 217, 77, .13);
        }

        .case-search svg {
            flex-shrink: 0;
            color: #9ca3af;
        }

        .case-search input {
            width: 100%;
            height: 100%;
            border: 0;
            outline: 0;
            background: transparent;
            color: #111827;
            font-size: 13px;
        }

        .case-search input::placeholder {
            color: #9ca3af;
        }

        .select-wrapper {
            position: relative;
            width: 230px;
            flex-shrink: 0;
        }

        .case-filter-button {
            width: 100%;
            height: 42px;
            padding: 0 38px 0 13px;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            background: #ffffff;
            color: #374151;
            font-size: 13px;
            outline: none;
            cursor: pointer;
            appearance: none;
            -webkit-appearance: none;
            transition: all .2s ease;
        }

        .case-filter-button:focus {
            border-color: #63AE00;
            box-shadow: 0 0 0 3px rgba(151, 217, 77, .13);
        }

        .select-arrow {
            position: absolute;
            top: 50%;
            right: 11px;
            transform: translateY(-50%);
            pointer-events: none;
            color: #6b7280;
            font-size: 19px;
        }

        /* =========================================================
           TABLE
        ========================================================= */

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .03);
        }

        .table {
            width: 100%;
            min-width: 1150px;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table thead th {
            padding: 14px 12px;
            background: #f9fafb;
            border-bottom: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 11px;
            font-weight: 700;
            text-align: left;
            text-transform: uppercase;
            letter-spacing: .025em;
            white-space: nowrap;
        }

        .table thead th:first-child {
            border-top-left-radius: 12px;
        }

        .table thead th:last-child {
            border-top-right-radius: 12px;
        }

        .table tbody td {
            padding: 15px 12px;
            border-bottom: 1px solid #f1f5f9;
            color: #374151;
            font-size: 13px;
            vertical-align: middle;
        }

        .table tbody tr:last-child td {
            border-bottom: 0;
        }

        .table tbody tr {
            transition: background .15s ease;
        }

        .table tbody tr:hover {
            background: #fbfdf9;
        }

        .row-number {
            width: 55px;
            color: #6b7280 !important;
            font-weight: 600;
        }

        /* =========================================================
           HASIL
        ========================================================= */

        .result-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .result-instructor {
            color: #374151;
        }

        .result-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            border-radius: 9px;
            background: #f1f8e9;
            color: #63AE00;
            font-size: 19px;
            flex-shrink: 0;
        }

        .result-content {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .result-title {
            font-size: 12px;
            font-weight: 600;
            color: #374151;
            white-space: nowrap;
        }

        .result-status {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 11px;
            font-weight: 600;
        }

        .result-status.pending {
            color: #b7791f;
        }

        .status-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            display: inline-block;
        }

        .status-dot.pending {
            background: #d69e2e;
        }

        /* =========================================================
           KETERANGAN
        ========================================================= */

        .keterangan-cell {
            max-width: 280px;
            min-width: 220px;
            line-height: 1.5;
            color: #6b7280 !important;
            white-space: normal;
            word-break: break-word;
        }

        .keterangan-text {
            display: block;
            color: #4b5563;
            font-size: 12px;
            line-height: 1.55;
        }

        .keterangan-empty {
            color: #9ca3af;
        }

        /* =========================================================
           DETAIL BUTTON
        ========================================================= */

        .detail-button {
            min-width: 92px;
            padding: 7px 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            border: 1px solid #dcebcf;
            border-radius: 8px;
            background: #f7fbf3;
            color: #4d8d0b;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all .2s ease;
        }

        .detail-button:hover {
            background: #97D94D;
            border-color: #97D94D;
            color: #ffffff;
        }

        .detail-button .result-icon {
            width: auto;
            height: auto;
            padding: 0;
            background: transparent;
            color: inherit;
            font-size: 17px;
        }

        .result-arrow {
            font-size: 18px;
            line-height: 1;
        }

        /* =========================================================
           EMPTY STATE
        ========================================================= */

        .empty-state {
            padding: 55px 25px !important;
            text-align: center !important;
            color: #9ca3af !important;
        }

        .empty-state-icon {
            width: 48px;
            height: 48px;
            margin: 0 auto 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            background: #f3f4f6;
            color: #9ca3af;
        }

        .empty-state-icon .material-symbols-outlined {
            font-size: 25px;
        }

        .empty-state-title {
            margin: 0;
            color: #6b7280;
            font-size: 14px;
            font-weight: 600;
        }

        .empty-state-text {
            margin: 5px 0 0;
            color: #9ca3af;
            font-size: 12px;
        }

        /* =========================================================
           FILTER EMPTY
        ========================================================= */

        .filter-empty-row {
            display: none;
        }

        .filter-empty-row td {
            padding: 45px 20px !important;
            text-align: center !important;
            color: #9ca3af !important;
        }

        /* =========================================================
           PAGINATION
        ========================================================= */

        .pagination-wrapper {
            margin-top: 18px;
        }

        .pagination-wrapper nav {
            display: flex;
            justify-content: center;
        }

        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media (max-width: 900px) {
            .case-conference-header {
                flex-direction: column;
            }

            .date-filter-wrapper {
                width: 100%;
            }

            .date-filter {
                width: 100%;
            }

            .date-picker {
                left: 0;
                right: auto;
                width: 100%;
                max-width: 310px;
            }

            .case-filter-wrapper {
                flex-direction: column;
                align-items: stretch;
            }

            .case-search {
                max-width: none;
            }

            .select-wrapper {
                width: 100%;
            }
        }

        @media (max-width: 600px) {
            .case-conference-page {
                padding-top: 5px;
            }

            .case-conference-header h1 {
                font-size: 21px;
            }

            .case-conference-header p {
                font-size: 12px;
                line-height: 1.5;
            }

            .result-navigation {
                gap: 6px;
            }

            .result-navigation a {
                flex: 1;
                padding: 8px 10px;
                font-size: 12px;
            }

            .date-input-group {
                grid-template-columns: 1fr;
            }

            .date-picker {
                max-width: 100%;
            }
        }
    </style>

    <div class="case-conference-page">

        {{-- =====================================================
             HEADER
        ====================================================== --}}

        <div class="case-conference-header">

            <div>
                <h1>Data Pending Instruktur</h1>

                <p>
                    Data PPKS yang masih berstatus pending setelah Asesmen Instruktur.
                </p>
            </div>

            {{-- DATE FILTER --}}

            <div class="date-filter-wrapper">

                <button
                    type="button"
                    class="date-filter"
                    id="dateFilterButton"
                    aria-expanded="false"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="16"
                        height="16"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <rect x="3" y="4" width="18" height="18" rx="2"></rect>
                        <path d="M16 2v4"></path>
                        <path d="M8 2v4"></path>
                        <path d="M3 10h18"></path>
                    </svg>

                    <span id="dateFilterText">
                        Pilih Tanggal
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
                        <path d="m6 9 6 6 6-6"></path>
                    </svg>
                </button>

                <div class="date-picker" id="datePicker">

                    <div class="date-picker-header">
                        <strong>Pilih Rentang Tanggal</strong>
                    </div>

                    <div class="date-input-group">

                        <div>
                            <label for="startDate">Dari</label>

                            <input
                                type="date"
                                id="startDate"
                            >
                        </div>

                        <div>
                            <label for="endDate">Sampai</label>

                            <input
                                type="date"
                                id="endDate"
                            >
                        </div>

                    </div>

                    <div class="date-picker-actions">

                        <button
                            type="button"
                            id="resetDate"
                            class="date-reset"
                        >
                            Reset
                        </button>

                        <button
                            type="button"
                            id="applyDate"
                            class="date-apply"
                        >
                            Terapkan
                        </button>

                    </div>

                </div>

            </div>

        </div>

        {{-- =====================================================
             NAVIGASI HASIL ASESMEN
        ====================================================== --}}

        <div class="result-navigation">

            <a href="{{ route('ppks.normal.instruktur') }}">
                Semua
            </a>

            <a href="{{ route('ppks.normal.asesmen-instruktur.lulus') }}">
                Lulus
            </a>

            <a
                href="{{ route('ppks.normal.asesmen-instruktur.pending') }}"
                class="active"
            >
                Pending
            </a>

            <a href="{{ route('ppks.normal.asesmen-instruktur.tidak-lulus') }}">
                Tidak Lulus
            </a>

        </div>

        {{-- =====================================================
             FILTER
        ====================================================== --}}

        <div class="case-filter-wrapper">

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
                    <circle cx="11" cy="11" r="7"></circle>
                    <path d="m20 20-3.5-3.5"></path>
                </svg>

                <input
                    type="text"
                    id="searchInput"
                    placeholder="Cari Nama atau NIK"
                    autocomplete="off"
                >

            </div>

            <div class="select-wrapper">

                <select
                    id="ppksFilter"
                    class="case-filter-button"
                >
                    <option value="">
                        Semua Jenis PPKS
                    </option>

                    <option value="Disabilitas Fisik">
                        Disabilitas Fisik
                    </option>

                    <option value="Disabilitas Rungu Wicara">
                        Disabilitas Rungu Wicara
                    </option>

                    <option value="Disabilitas Netra">
                        Disabilitas Netra
                    </option>

                    <option value="Disabilitas Mental">
                        Disabilitas Mental
                    </option>

                    <option value="Disabilitas Intelektual">
                        Disabilitas Intelektual
                    </option>

                    <option value="Kelompok Rentan">
                        Kelompok Rentan
                    </option>

                    <option value="Other">
                        Other
                    </option>

                </select>

                <span class="material-symbols-outlined select-arrow">
                    keyboard_arrow_down
                </span>

            </div>

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
                        <th>Aksi</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse ($ppks as $index => $item)

                        @php

                            /*
                            |--------------------------------------------------------------------------
                            | DATA
                            |--------------------------------------------------------------------------
                            */

                            $data = $item->data;

                            if (is_string($data)) {
                                $data = json_decode($data, true) ?? [];
                            }

                            if (!is_array($data)) {
                                $data = [];
                            }

                            /*
                            |--------------------------------------------------------------------------
                            | NAMA
                            | Google Sheet:
                            | B = index 1
                            |--------------------------------------------------------------------------
                            */

                            $nama = '-';

                            if (
                                array_key_exists(1, $data) &&
                                trim((string) $data[1]) !== ''
                            ) {
                                $nama = $data[1];
                            } elseif (
                                array_key_exists('B', $data) &&
                                trim((string) $data['B']) !== ''
                            ) {
                                $nama = $data['B'];
                            } elseif (
                                !empty($data['nama_lengkap'])
                            ) {
                                $nama = $data['nama_lengkap'];
                            } elseif (
                                !empty($data['nama'])
                            ) {
                                $nama = $data['nama'];
                            }

                            /*
                            |--------------------------------------------------------------------------
                            | NIK
                            | Google Sheet:
                            | C = index 2
                            |--------------------------------------------------------------------------
                            */

                            $nik = '-';

                            if (
                                array_key_exists(2, $data) &&
                                trim((string) $data[2]) !== ''
                            ) {
                                $nik = $data[2];
                            } elseif (
                                array_key_exists('C', $data) &&
                                trim((string) $data['C']) !== ''
                            ) {
                                $nik = $data['C'];
                            } elseif (
                                !empty($data['nik'])
                            ) {
                                $nik = $data['nik'];
                            } elseif (
                                !empty($item->nik)
                            ) {
                                $nik = $item->nik;
                            }

                            /*
                            |--------------------------------------------------------------------------
                            | UMUR
                            | Google Sheet:
                            | G = index 6
                            |--------------------------------------------------------------------------
                            */

                            $umur = null;

                            if (
                                array_key_exists(6, $data) &&
                                $data[6] !== null &&
                                trim((string) $data[6]) !== ''
                            ) {
                                $umur = $data[6];
                            } elseif (
                                array_key_exists('G', $data) &&
                                $data['G'] !== null &&
                                trim((string) $data['G']) !== ''
                            ) {
                                $umur = $data['G'];
                            } elseif (
                                array_key_exists('umur', $data) &&
                                $data['umur'] !== null &&
                                trim((string) $data['umur']) !== ''
                            ) {
                                $umur = $data['umur'];
                            } elseif (
                                array_key_exists('usia', $data) &&
                                $data['usia'] !== null &&
                                trim((string) $data['usia']) !== ''
                            ) {
                                $umur = $data['usia'];
                            }

                            if (
                                $umur === null ||
                                trim((string) $umur) === ''
                            ) {
                                $umur = '-';
                            }

                            $umur = trim((string) $umur);

                            /*
                            |--------------------------------------------------------------------------
                            | JENIS PPKS
                            | Google Sheet:
                            | M = index 12
                            |--------------------------------------------------------------------------
                            */

                            $jenisPpks = '-';

                            if (
                                array_key_exists(12, $data) &&
                                trim((string) $data[12]) !== ''
                            ) {
                                $jenisPpks = $data[12];
                            } elseif (
                                array_key_exists('M', $data) &&
                                trim((string) $data['M']) !== ''
                            ) {
                                $jenisPpks = $data['M'];
                            } elseif (
                                !empty($data['jenis_ppks'])
                            ) {
                                $jenisPpks = $data['jenis_ppks'];
                            }

                            /*
                            |--------------------------------------------------------------------------
                            | JURUSAN
                            | Google Sheet:
                            | O = index 14
                            |--------------------------------------------------------------------------
                            */

                            $jurusan = '-';

                            if (
                                array_key_exists(14, $data) &&
                                trim((string) $data[14]) !== ''
                            ) {
                                $jurusan = $data[14];
                            } elseif (
                                array_key_exists('O', $data) &&
                                trim((string) $data['O']) !== ''
                            ) {
                                $jurusan = $data['O'];
                            } elseif (
                                !empty($data['jurusan_yang_diminati'])
                            ) {
                                $jurusan = $data['jurusan_yang_diminati'];
                            } elseif (
                                !empty($data['jurusan'])
                            ) {
                                $jurusan = $data['jurusan'];
                            }

                            /*
                            |--------------------------------------------------------------------------
                            | PROSES INSTRUKTUR
                            |--------------------------------------------------------------------------
                            */

                            $prosesInstruktur = $item->prosesPesertas
                                ->where('tahap', 'instruktur')
                                ->sortByDesc(function ($proses) {
                                    return $proses->tanggal_proses
                                        ?? $proses->created_at;
                                })
                                ->first();

                            /*
                            |--------------------------------------------------------------------------
                            | TANGGAL PROSES
                            |--------------------------------------------------------------------------
                            */

                            $tanggal = $prosesInstruktur?->tanggal_proses;

                            /*
                            |--------------------------------------------------------------------------
                            | KETERANGAN
                            |
                            | PRIORITAS:
                            | 1. catatan_asesmen_instruktur
                            | 2. catatan pada proses
                            | 3. alasan_pending
                            |--------------------------------------------------------------------------
                            */

                            $keterangan = null;

                            if (
                                isset($data['catatan_asesmen_instruktur']) &&
                                trim((string) $data['catatan_asesmen_instruktur']) !== ''
                            ) {
                                $keterangan =
                                    $data['catatan_asesmen_instruktur'];
                            }

                            if (
                                (!$keterangan || trim((string) $keterangan) === '') &&
                                $prosesInstruktur
                            ) {
                                if (
                                    isset($prosesInstruktur->catatan) &&
                                    trim((string) $prosesInstruktur->catatan) !== ''
                                ) {
                                    $keterangan =
                                        $prosesInstruktur->catatan;
                                }
                            }

                            if (
                                (!$keterangan || trim((string) $keterangan) === '') &&
                                $prosesInstruktur
                            ) {
                                if (
                                    isset($prosesInstruktur->alasan_pending) &&
                                    trim((string) $prosesInstruktur->alasan_pending) !== ''
                                ) {
                                    $keterangan =
                                        $prosesInstruktur->alasan_pending;
                                }
                            }

                            if (
                                !$keterangan ||
                                trim((string) $keterangan) === ''
                            ) {
                                $keterangan = '-';
                            }

                            /*
                            |--------------------------------------------------------------------------
                            | STATUS
                            |--------------------------------------------------------------------------
                            */

                            $statusProses =
                                $prosesInstruktur?->status ?? 'pending';

                        @endphp

                        <tr
                            data-nama="{{ strtolower((string) $nama) }}"
                            data-nik="{{ strtolower((string) $nik) }}"
                            data-ppks="{{ strtolower((string) $jenisPpks) }}"
                            data-tanggal="{{ $tanggal ? \Carbon\Carbon::parse($tanggal)->format('Y-m-d') : '' }}"
                        >

                            {{-- NO --}}

                            <td class="row-number">
                                {{ $ppks->firstItem() + $index }}
                            </td>

                            {{-- NAMA --}}

                            <td>
                                <strong
                                    style="font-weight: 600; color: #1f2937;"
                                >
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

                                <div class="result-badge result-instructor">

                                    <span class="material-symbols-outlined result-icon">
                                        assignment
                                    </span>

                                    <div class="result-content">

                                        <span class="result-title">
                                            Asesmen Instruktur
                                        </span>

                                        <span class="result-status pending">

                                            <span class="status-dot pending"></span>

                                            Pending

                                        </span>

                                    </div>

                                </div>

                            </td>

                            {{-- KETERANGAN --}}

                            <td class="keterangan-cell">

                                @if ($keterangan !== '-')

                                    <span class="keterangan-text">
                                        {{ $keterangan }}
                                    </span>

                                @else

                                    <span class="keterangan-empty">
                                        -
                                    </span>

                                @endif

                            </td>

                            {{-- AKSI --}}

                            <td>

                                <a
                                    href="{{ route('ppks.normal.asesmen-instruktur.data-detail', $item->id) }}"
                                    class="detail-button"
                                >

                                    <span class="material-symbols-outlined result-icon">
                                        visibility
                                    </span>

                                    <span>
                                        Detail
                                    </span>

                                    <span class="result-arrow">
                                        ›
                                    </span>

                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="9"
                                class="empty-state"
                            >

                                <div class="empty-state-icon">

                                    <span class="material-symbols-outlined">
                                        assignment_late
                                    </span>

                                </div>

                                <p class="empty-state-title">
                                    Belum ada data Pending
                                </p>

                                <p class="empty-state-text">
                                    Belum ada data PPKS yang berstatus Pending setelah Asesmen Instruktur.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                    {{-- EMPTY HASIL FILTER --}}

                    @if ($ppks->count() > 0)

                        <tr
                            id="filterEmptyRow"
                            class="filter-empty-row"
                        >

                            <td colspan="9">

                                <div class="empty-state-icon">

                                    <span class="material-symbols-outlined">
                                        search_off
                                    </span>

                                </div>

                                <p class="empty-state-title">
                                    Data tidak ditemukan
                                </p>

                                <p class="empty-state-text">
                                    Tidak ada data yang sesuai dengan filter yang dipilih.
                                </p>

                            </td>

                        </tr>

                    @endif

                </tbody>

            </table>

        </div>

        {{-- =====================================================
             PAGINATION
        ====================================================== --}}

        @if ($ppks->hasPages())

            <div class="pagination-wrapper">
                {{ $ppks->links() }}
            </div>

        @endif

    </div>

    {{-- =========================================================
         JAVASCRIPT
    ========================================================== --}}

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const searchInput =
                document.getElementById('searchInput');

            const ppksFilter =
                document.getElementById('ppksFilter');

            const rows =
                document.querySelectorAll(
                    '.table tbody tr[data-nama]'
                );

            /* =====================================================
               DATE FILTER
            ===================================================== */

            const dateButton =
                document.getElementById('dateFilterButton');

            const datePicker =
                document.getElementById('datePicker');

            const dateText =
                document.getElementById('dateFilterText');

            const startDate =
                document.getElementById('startDate');

            const endDate =
                document.getElementById('endDate');

            const applyDate =
                document.getElementById('applyDate');

            const resetDate =
                document.getElementById('resetDate');

            const filterEmptyRow =
                document.getElementById('filterEmptyRow');

            /* =====================================================
               SIMPAN NOMOR ASLI
            ===================================================== */

            rows.forEach(function (row) {

                const numberCell =
                    row.querySelector('.row-number');

                if (numberCell) {

                    row.dataset.originalNumber =
                        numberCell.textContent.trim();

                }

            });

            /* =====================================================
               FILTER TABLE
            ===================================================== */

            function filterTable() {

                const search =
                    searchInput
                        ? searchInput.value.toLowerCase().trim()
                        : '';

                const ppks =
                    ppksFilter
                        ? ppksFilter.value.toLowerCase().trim()
                        : '';

                const start =
                    startDate
                        ? startDate.value
                        : '';

                const end =
                    endDate
                        ? endDate.value
                        : '';

                let visibleNumber = 1;
                let visibleCount = 0;

                rows.forEach(function (row) {

                    const nama =
                        row.dataset.nama || '';

                    const nik =
                        row.dataset.nik || '';

                    const jenis =
                        row.dataset.ppks || '';

                    const tanggal =
                        row.dataset.tanggal || '';

                    /* SEARCH */

                    const searchMatch =
                        search === '' ||
                        nama.includes(search) ||
                        nik.includes(search);

                    /* JENIS PPKS */

                    const ppksMatch =
                        ppks === '' ||
                        jenis === ppks;

                    /* TANGGAL */

                    let dateMatch = true;

                    if (start) {

                        if (!tanggal || tanggal < start) {
                            dateMatch = false;
                        }

                    }

                    if (end) {

                        if (!tanggal || tanggal > end) {
                            dateMatch = false;
                        }

                    }

                    const show =
                        searchMatch &&
                        ppksMatch &&
                        dateMatch;

                    row.style.display =
                        show
                            ? ''
                            : 'none';

                    if (show) {

                        visibleCount++;

                        const numberCell =
                            row.querySelector('.row-number');

                        if (numberCell) {

                            const hasFilter =
                                search !== '' ||
                                ppks !== '' ||
                                start !== '' ||
                                end !== '';

                            if (hasFilter) {

                                numberCell.textContent =
                                    visibleNumber++;

                            } else {

                                numberCell.textContent =
                                    row.dataset.originalNumber;

                            }

                        }

                    }

                });

                /* EMPTY FILTER */

                if (filterEmptyRow) {

                    filterEmptyRow.style.display =
                        visibleCount === 0
                            ? 'table-row'
                            : 'none';

                }

            }

            /* =====================================================
               SEARCH
            ===================================================== */

            if (searchInput) {

                searchInput.addEventListener(
                    'input',
                    filterTable
                );

            }

            /* =====================================================
               JENIS PPKS
            ===================================================== */

            if (ppksFilter) {

                ppksFilter.addEventListener(
                    'change',
                    filterTable
                );

            }

            /* =====================================================
               BUKA DATE PICKER
            ===================================================== */

            if (dateButton) {

                dateButton.addEventListener(
                    'click',
                    function (event) {

                        event.stopPropagation();

                        const active =
                            datePicker.classList.toggle('active');

                        dateButton.setAttribute(
                            'aria-expanded',
                            active ? 'true' : 'false'
                        );

                    }
                );

            }

            /* =====================================================
               DATE PICKER TIDAK MENUTUP SAAT DIKLIK
            ===================================================== */

            if (datePicker) {

                datePicker.addEventListener(
                    'click',
                    function (event) {
                        event.stopPropagation();
                    }
                );

            }

            /* =====================================================
               TERAPKAN TANGGAL
            ===================================================== */

            if (applyDate) {

                applyDate.addEventListener(
                    'click',
                    function () {

                        const start =
                            startDate.value;

                        const end =
                            endDate.value;

                        if (!start || !end) {

                            alert(
                                'Silakan pilih tanggal awal dan tanggal akhir.'
                            );

                            return;
                        }

                        if (start > end) {

                            alert(
                                'Tanggal awal tidak boleh lebih besar dari tanggal akhir.'
                            );

                            return;
                        }

                        dateText.textContent =
                            formatDate(start) +
                            ' - ' +
                            formatDate(end);

                        datePicker.classList.remove(
                            'active'
                        );

                        dateButton.setAttribute(
                            'aria-expanded',
                            'false'
                        );

                        filterTable();

                    }
                );

            }

            /* =====================================================
               RESET TANGGAL
            ===================================================== */

            if (resetDate) {

                resetDate.addEventListener(
                    'click',
                    function () {

                        startDate.value = '';
                        endDate.value = '';

                        dateText.textContent =
                            'Pilih Tanggal';

                        datePicker.classList.remove(
                            'active'
                        );

                        dateButton.setAttribute(
                            'aria-expanded',
                            'false'
                        );

                        filterTable();

                    }
                );

            }

            /* =====================================================
               FORMAT TANGGAL
            ===================================================== */

            function formatDate(value) {

                const date =
                    new Date(
                        value + 'T00:00:00'
                    );

                return date.toLocaleDateString(
                    'id-ID',
                    {
                        day: '2-digit',
                        month: 'short',
                        year: 'numeric'
                    }
                );

            }

            /* =====================================================
               KLIK DI LUAR DATE PICKER
            ===================================================== */

            document.addEventListener(
                'click',
                function () {

                    if (
                        datePicker &&
                        datePicker.classList.contains('active')
                    ) {

                        datePicker.classList.remove(
                            'active'
                        );

                        dateButton.setAttribute(
                            'aria-expanded',
                            'false'
                        );

                    }

                }
            );

            /* =====================================================
               FILTER PERTAMA KALI
            ===================================================== */

            filterTable();

        });

    </script>

</x-app-layout>
```
