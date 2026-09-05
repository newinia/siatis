<x-app-layout>

    <style>

        /* =====================================================
           DATA LULUS ASESMEN KESEHATAN AWAL
        ====================================================== */

        .case-conference-page {
            width: 100%;
            padding: 10px 0 35px;
            color: #172018;
        }

        /* =====================================================
           HEADER
        ====================================================== */

        .case-conference-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 25px;
            margin-bottom: 24px;
        }

        .case-conference-header h1 {
            margin: 0;
            font-size: 28px;
            line-height: 1.25;
            font-weight: 800;
            letter-spacing: -0.6px;
            color: #172018;
        }

        .case-conference-header p {
            max-width: 720px;
            margin: 8px 0 0;
            font-size: 14px;
            line-height: 1.65;
            color: #707970;
            font-weight: 400;
        }

        /* =====================================================
           DATE FILTER
        ====================================================== */

        .date-filter-wrapper {
            position: relative;
            flex-shrink: 0;
        }

        .date-filter {
            height: 44px;
            min-width: 178px;
            padding: 0 14px;

            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;

            border: 1px solid #dfe7da;
            border-radius: 12px;
            background: #ffffff;

            color: #394339;
            font-size: 13px;
            font-weight: 700;

            cursor: pointer;

            box-shadow: 0 3px 10px rgba(36, 55, 30, 0.04);

            transition:
                border-color .2s ease,
                box-shadow .2s ease,
                color .2s ease,
                transform .2s ease;
        }

        .date-filter:hover {
            border-color: #97D94D;
            color: #328300;
            box-shadow: 0 6px 18px rgba(99, 174, 0, .12);
        }

        .date-filter:active {
            transform: translateY(1px);
        }

        .date-picker {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            z-index: 1000;

            width: 320px;
            padding: 19px;

            background: #ffffff;
            border: 1px solid #e2e9de;
            border-radius: 16px;

            box-shadow:
                0 18px 45px rgba(25, 45, 20, .13),
                0 4px 12px rgba(25, 45, 20, .05);

            opacity: 0;
            visibility: hidden;
            pointer-events: none;

            transform: translateY(-8px);

            transition:
                opacity .2s ease,
                visibility .2s ease,
                transform .2s ease;
        }

        .date-picker.active {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
            transform: translateY(0);
        }

        .date-picker-header {
            padding-bottom: 14px;
            margin-bottom: 15px;

            border-bottom: 1px solid #edf1eb;

            color: #263126;
            font-size: 14px;
        }

        .date-picker-header strong {
            font-weight: 800;
        }

        .date-input-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .date-input-group label {
            display: block;
            margin-bottom: 7px;

            color: #727a71;
            font-size: 11px;
            font-weight: 800;
        }

        .date-input-group input {
            width: 100%;
            height: 40px;
            padding: 0 10px;

            border: 1px solid #dfe6db;
            border-radius: 9px;

            background: #fafcf9;
            color: #374137;

            font-family: inherit;
            font-size: 12px;

            outline: none;
            box-sizing: border-box;

            transition: .2s ease;
        }

        .date-input-group input:hover {
            border-color: #cbd8c5;
        }

        .date-input-group input:focus {
            border-color: #97D94D;
            background: #ffffff;

            box-shadow:
                0 0 0 3px rgba(151, 217, 77, .13);
        }

        .date-picker-actions {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
            margin-top: 17px;
        }

        .date-reset,
        .date-apply {
            height: 37px;
            padding: 0 15px;

            border: none;
            border-radius: 9px;

            font-family: inherit;
            font-size: 12px;
            font-weight: 800;

            cursor: pointer;

            transition: .2s ease;
        }

        .date-reset {
            background: #f1f3f0;
            color: #596158;
        }

        .date-reset:hover {
            background: #e5e9e3;
        }

        .date-apply {
            background: linear-gradient(
                135deg,
                #97D94D,
                #63AE00
            );

            color: #ffffff;

            box-shadow:
                0 5px 13px rgba(99, 174, 0, .20);
        }

        .date-apply:hover {
            transform: translateY(-1px);

            box-shadow:
                0 7px 17px rgba(99, 174, 0, .25);
        }

        /* =====================================================
           RESULT NAVIGATION
        ====================================================== */

        .result-navigation {
            display: inline-flex;
            align-items: center;
            gap: 4px;

            padding: 5px;
            margin: 0 0 20px;

            background: #f6f9f4;
            border: 1px solid #e5ebe2;
            border-radius: 13px;

            box-shadow:
                inset 0 1px 2px rgba(0, 0, 0, .02);
        }

        .result-navigation a {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            min-height: 38px;
            padding: 0 18px;

            border-radius: 9px;

            text-decoration: none;

            color: #687168;
            background: transparent;

            font-size: 13px;
            font-weight: 750;

            transition:
                background .2s ease,
                color .2s ease,
                box-shadow .2s ease,
                transform .2s ease;
        }

        .result-navigation a:hover {
            background: #ffffff;
            color: #328300;
        }

        .result-navigation a.active {
            background: linear-gradient(
                135deg,
                #97D94D,
                #63AE00
            );

            color: #ffffff;

            box-shadow:
                0 5px 12px rgba(99, 174, 0, .20);
        }

        .result-navigation a.active:hover {
            color: #ffffff;
            transform: translateY(-1px);
        }

        /* =====================================================
           FILTER
        ====================================================== */

        .case-filter-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 12px;
            margin-bottom: 16px;
        }

        .case-search {
            position: relative;
            width: 100%;
            max-width: 440px;
        }

        .case-search svg {
            position: absolute;

            left: 14px;
            top: 50%;

            width: 17px;
            height: 17px;

            transform: translateY(-50%);

            color: #9aa29a;
            pointer-events: none;
        }

        .case-search input {
            width: 100%;
            height: 44px;

            padding: 0 15px 0 42px;

            border: 1px solid #e1e7de;
            border-radius: 12px;

            background: #ffffff;
            color: #273027;

            font-family: inherit;
            font-size: 13px;

            outline: none;

            box-shadow:
                0 3px 10px rgba(0, 0, 0, .025);

            transition: .2s ease;

            box-sizing: border-box;
        }

        .case-search input::placeholder {
            color: #a0a6a0;
        }

        .case-search input:hover {
            border-color: #cfd9ca;
        }

        .case-search input:focus {
            border-color: #97D94D;

            box-shadow:
                0 0 0 3px rgba(151, 217, 77, .12),
                0 4px 12px rgba(0, 0, 0, .025);
        }

        .select-wrapper {
            position: relative;
            width: 210px;
            flex-shrink: 0;
        }

        .case-filter-button {
            width: 100%;
            height: 44px;

            appearance: none;
            -webkit-appearance: none;

            padding: 0 42px 0 14px;

            border: 1px solid #e1e7de;
            border-radius: 12px;

            background: #ffffff;
            color: #4b554c;

            font-family: inherit;
            font-size: 13px;
            font-weight: 650;

            outline: none;
            cursor: pointer;

            box-shadow:
                0 3px 10px rgba(0, 0, 0, .025);

            transition: .2s ease;

            box-sizing: border-box;
        }

        .case-filter-button:hover {
            border-color: #cfd9ca;
        }

        .case-filter-button:focus {
            border-color: #97D94D;

            box-shadow:
                0 0 0 3px rgba(151, 217, 77, .12);
        }

        .select-arrow {
            position: absolute;

            right: 13px;
            top: 50%;

            transform: translateY(-50%);

            color: #899289;
            font-size: 20px;

            pointer-events: none;
        }

        /* =====================================================
           TABLE
        ====================================================== */

        .table-wrapper {
            width: 100%;

            overflow-x: auto;

            background: #ffffff;

            border: 1px solid #e4e9e2;
            border-radius: 16px;

            box-shadow:
                0 4px 15px rgba(30, 45, 25, .035),
                0 15px 35px rgba(30, 45, 25, .025);

            scrollbar-width: thin;
            scrollbar-color: #cfd8ca transparent;
        }

        .table {
            width: 100%;
            min-width: 1350px;

            border-collapse: separate;
            border-spacing: 0;
        }

        .table thead th {
            height: 53px;

            padding: 0 15px;

            background: #f7f9f6;

            border-bottom: 1px solid #e5eae3;

            color: #697269;

            font-size: 10.5px;
            font-weight: 850;

            text-transform: uppercase;
            letter-spacing: .55px;

            white-space: nowrap;
        }

        .table thead th:first-child {
            padding-left: 20px;
            border-top-left-radius: 16px;
        }

        .table thead th:last-child {
            border-top-right-radius: 16px;
        }

        .table tbody td {
            padding: 15px;

            border-bottom: 1px solid #edf0eb;

            background: #ffffff;

            color: #3f4740;

            font-size: 13px;

            vertical-align: middle;

            transition:
                background .18s ease;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .table tbody tr:hover td {
            background: #fbfdf9;
        }

        .table tbody td:first-child {
            padding-left: 20px;
        }

        .table tbody td:nth-child(2) {
            min-width: 180px;

            color: #202820;
            font-weight: 750;
        }

        .table tbody td:nth-child(3) {
            color: #6c746d;
            font-size: 12px;
            letter-spacing: .2px;
        }

        .table tbody td:nth-child(5) {
            color: #515b52;
        }

        /* =====================================================
           ROW NUMBER
        ====================================================== */

        .row-number {
            width: 45px;

            color: #9aa19a !important;

            font-size: 12px !important;
            font-weight: 750;
        }

        /* =====================================================
           RESULT BADGE
        ====================================================== */

        .result-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;

            min-height: 38px;

            padding: 7px 11px;

            border-radius: 10px;

            text-decoration: none;

            font-size: 12px;
            font-weight: 750;

            transition:
                background .2s ease,
                border-color .2s ease,
                transform .2s ease,
                box-shadow .2s ease;
        }

        .result-health {
            background: #f0f8f8;

            border: 1px solid #d8eceb;

            color: #347575;

            cursor: pointer;
        }

        .result-health:hover {
            background: #e7f4f3;

            border-color: #bfe0de;

            color: #286666;

            transform: translateY(-1px);

            box-shadow:
                0 4px 10px rgba(52, 117, 117, .08);
        }

        .result-icon {
            font-size: 18px;
        }

        .result-content {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .result-title {
            font-size: 11px;
            font-weight: 850;
        }

        .result-status {
            display: flex;
            align-items: center;
            gap: 5px;

            font-size: 11px;
            font-weight: 750;
        }

        .result-status.lolos {
            color: #328300;
        }

        .status-dot.lolos {
            width: 6px;
            height: 6px;

            border-radius: 50%;

            background: #63AE00;
        }

        .result-arrow {
            margin-left: auto;

            font-size: 19px;
            line-height: 1;

            opacity: .55;
        }

        .table tbody td:nth-child(7) {
            min-width: 190px;
        }

        .table tbody td:nth-child(7) .result-badge {
            width: 100%;

            justify-content: flex-start;

            box-sizing: border-box;
        }

        /* =====================================================
           KETERANGAN
        ====================================================== */

        .keterangan-text {
            display: block;

            max-width: 260px;

            color: #596158;

            font-size: 12px;
            line-height: 1.6;

            white-space: normal;
            word-break: break-word;
        }

        /* =====================================================
           ACTION
        ====================================================== */

        .action-cell {
            min-width: 205px;

            padding: 12px 16px !important;
        }

        .action-button {
            width: 100%;

            min-height: 38px;

            padding: 7px 11px;

            display: flex;
            align-items: center;

            gap: 8px;

            border-radius: 10px;

            text-decoration: none;

            font-size: 12px;
            font-weight: 750;

            box-sizing: border-box;

            transition:
                background .2s ease,
                border-color .2s ease,
                transform .2s ease,
                box-shadow .2s ease;
        }

        .action-button + .action-button {
            margin-top: 7px;
        }

        /* DETAIL */

        .action-detail {
            background: #f1f8e9;

            border: 1px solid #d8ebc4;

            color: #4d7f16;
        }

        .action-detail:hover {
            background: #e8f4dc;

            border-color: #c5dfa9;

            color: #3f6e0c;

            transform: translateY(-1px);

            box-shadow:
                0 4px 10px rgba(99, 174, 0, .08);
        }

        /* CASE CONFERENCE */

        .action-case {
            background: #f0f8f8;

            border: 1px solid #d8eceb;

            color: #347575;
        }

        .action-case:hover {
            background: #e7f4f3;

            border-color: #bfe0de;

            color: #286666;

            transform: translateY(-1px);

            box-shadow:
                0 4px 10px rgba(52, 117, 117, .08);
        }

        .action-icon {
            font-size: 18px;
            flex-shrink: 0;
        }

        .action-title {
            flex: 1;
            text-align: left;
        }

        .action-arrow {
            font-size: 19px;
            line-height: 1;
            opacity: .55;
        }

        /* =====================================================
           EMPTY ROW
        ====================================================== */

        .table tbody td[colspan="9"] {
            padding: 65px 20px !important;

            color: #9aa19a !important;

            font-size: 14px !important;
            font-weight: 550;

            text-align: center;
        }

        /* =====================================================
           PAGINATION
        ====================================================== */

        .pagination-wrapper {
            display: flex;
            justify-content: flex-end;

            margin-top: 18px;
        }

        .pagination-wrapper nav {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .pagination-wrapper nav a,
        .pagination-wrapper nav span {
            min-width: 34px;
            height: 34px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            padding: 0 9px;

            border: 1px solid #e3e8e1;
            border-radius: 8px;

            background: #ffffff;
            color: #6c746d;

            font-size: 12px;
            font-weight: 750;

            text-decoration: none;

            transition: .2s ease;
        }

        .pagination-wrapper nav a:hover {
            border-color: #97D94D;

            background: #f5faef;

            color: #328300;
        }

        .pagination-wrapper nav span[aria-current="page"] {
            border-color: #63AE00;

            background: #63AE00;

            color: #ffffff;
        }

        /* =====================================================
           RESPONSIVE
        ====================================================== */

        @media (max-width: 1200px) {

            .case-filter-wrapper {
                flex-wrap: wrap;
            }

            .case-search {
                max-width: 100%;
                flex: 1 1 100%;
            }

            .select-wrapper {
                flex: 1 1 30%;
                width: auto;
            }
        }

        @media (max-width: 900px) {

            .case-conference-header {
                flex-direction: column;
                gap: 16px;
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
                max-width: 360px;

                box-sizing: border-box;
            }

            .result-navigation {
                width: 100%;

                display: flex;

                overflow-x: auto;

                scrollbar-width: none;
            }

            .result-navigation::-webkit-scrollbar {
                display: none;
            }

            .result-navigation a {
                flex: 1;
                white-space: nowrap;
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
                padding-bottom: 20px;
            }

            .case-conference-header h1 {
                font-size: 23px;
            }

            .case-conference-header p {
                font-size: 12px;
            }

            .date-input-group {
                grid-template-columns: 1fr;
            }

            .result-navigation a {
                min-height: 36px;

                padding: 0 13px;

                font-size: 12px;
            }

            .table-wrapper {
                border-radius: 12px;
            }

            .table {
                min-width: 1150px;
            }

            .pagination-wrapper {
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

                <h1>
                    Data Lulus Kesehatan Awal
                </h1>

                <p>
                    Data PPKS yang telah lulus pada tahap Asesmen Kesehatan Awal.
                </p>

            </div>


            {{-- =====================================================
            DATE FILTER
            ====================================================== --}}

            <div class="date-filter-wrapper">

                <button
                    type="button"
                    class="date-filter"
                    id="dateFilterButton"
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
                        <path d="m6 9 6 6 6-6" />
                    </svg>

                </button>


                <div
                    class="date-picker"
                    id="datePicker"
                >

                    <div class="date-picker-header">

                        <strong>
                            Pilih Rentang Tanggal
                        </strong>

                    </div>


                    <div class="date-input-group">

                        <div>

                            <label for="startDate">
                                Dari
                            </label>

                            <input
                                type="date"
                                id="startDate"
                            >

                        </div>


                        <div>

                            <label for="endDate">
                                Sampai
                            </label>

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
        RESULT NAVIGATION
        ====================================================== --}}

        <div class="result-navigation">

            <a href="{{ route('ppks.normal.kesehatan') }}">
                Belum Asesmen
            </a>

            <a
                href="{{ route('ppks.normal.asesmen-kesehatan.lulus') }}"
                class="active"
            >
                Lulus
            </a>

            <a
                href="{{ route('ppks.normal.asesmen-kesehatan.pending') }}"
            >
                Pending
            </a>

            <a
                href="{{ route('ppks.normal.asesmen-kesehatan.tidak-lulus') }}"
            >
                Tidak Lulus
            </a>

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
                    <circle
                        cx="11"
                        cy="11"
                        r="7"
                    />

                    <path d="m20 20-3.5-3.5" />

                </svg>


                <input
                    type="text"
                    id="searchInput"
                    placeholder="Cari Nama atau NIK"
                    autocomplete="off"
                >

            </div>


            {{-- FILTER PPKS --}}

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


            {{-- FILTER TAHAPAN --}}

            <div class="select-wrapper">

                <select
                    id="tahapanFilter"
                    class="case-filter-button"
                >

                    <option value="">
                        Semua Jenis Tahapan
                    </option>

                    <option value="Asesmen Kesehatan Awal">
                        Asesmen Kesehatan Awal
                    </option>

                    <option value="Asesmen Kesehatan Lanjutan">
                        Asesmen Kesehatan Lanjutan
                    </option>

                    <option value="Asesmen Instruktur">
                        Asesmen Instruktur
                    </option>

                    <option value="Case Conference">
                        Case Conference
                    </option>

                </select>


                <span class="material-symbols-outlined select-arrow">
                    keyboard_arrow_down
                </span>

            </div>


            {{-- FILTER HASIL --}}

            <div class="select-wrapper">

                <select
                    id="hasilFilter"
                    class="case-filter-button"
                >

                    <option value="">
                        Semua Hasil
                    </option>

                    <option value="Lulus">
                        Lulus
                    </option>

                    <option value="Pending">
                        Pending
                    </option>

                    <option value="Tidak Lulus">
                        Tidak Lulus
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

                    @forelse ($ppks as $index => $ppksItem)

                        @php

                            $data = $ppksItem->data ?? [];

                            if (!is_array($data)) {
                                $data = [];
                            }


                            $nama =
                                $data['nama_lengkap']
                                ?? $data['nama']
                                ?? '-';


                            $nik =
                                $data['nik']
                                ?? '-';


                            $jenisPpks =
                                $data['jenis_ppks']
                                ?? '-';


                            $jurusan =
                                $data['jurusan_yang_diminati']
                                ?? $data['jurusan']
                                ?? $data['jurusan_pelatihan']
                                ?? $data['program_keahlian']
                                ?? '-';


                            $umur = '-';


                            if (!empty($data['tanggal_lahir'])) {

                                try {

                                    $umur =
                                        \Carbon\Carbon::parse(
                                            $data['tanggal_lahir']
                                        )->age;

                                } catch (\Throwable $e) {

                                    $umur = '-';

                                }

                            }


                            $prosesKesehatan =
                                $ppksItem
                                    ->prosesPesertas
                                    ->where(
                                        'tahap',
                                        'kesehatan_awal'
                                    )
                                    ->sortByDesc(
                                        function ($item) {

                                            return $item->tanggal_proses
                                                ?? $item->created_at;

                                        }
                                    )
                                    ->first();


                            $tanggalProses =
                                $prosesKesehatan?->tanggal_proses
                                ? \Carbon\Carbon::parse(
                                    $prosesKesehatan->tanggal_proses
                                )->format('Y-m-d')
                                : '';


                            $keterangan =
                                $prosesKesehatan?->catatan
                                ?? $data['catatan_asesmen_kesehatan']
                                ?? '-';

                        @endphp


                        <tr
                            data-nama="{{ strtolower($nama) }}"
                            data-nik="{{ strtolower($nik) }}"
                            data-ppks="{{ strtolower($jenisPpks) }}"
                            data-tahapan="asesmen kesehatan awal"
                            data-hasil="lulus"
                            data-tanggal="{{ $tanggalProses }}"
                        >

                            {{-- NO --}}

                            <td class="row-number">
                                {{ $ppks->firstItem() + $index }}
                            </td>


                            {{-- NAMA --}}

                            <td>
                                {{ $nama }}
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
                                        'ppks.normal.asesmen-kesehatan.lolos',
                                        $ppksItem->id
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


                                        <span class="result-status lolos">

                                            <span class="status-dot lolos"></span>

                                            Lulus

                                        </span>

                                    </div>


                                    <span class="result-arrow">
                                        ›
                                    </span>

                                </a>

                            </td>


                            {{-- KETERANGAN --}}

                            <td>

                                <span class="keterangan-text">
                                    {{ $keterangan }}
                                </span>

                            </td>
{{-- AKSI --}}
<td class="action-cell">

    {{-- DETAIL ASESMEN KESEHATAN AWAL --}}
    <a
        href="{{ route(
            'ppks.normal.asesmen-kesehatan.awal',
            ['ppks' => $ppksItem->id]
        ) }}"
        class="action-button action-detail"
    >
        <span class="material-symbols-outlined action-icon">
            visibility
        </span>

        <span class="action-title">
            Detail
        </span>

        <span class="action-arrow">
            ›
        </span>
    </a>

    {{-- CASE CONFERENCE --}}
    <a
        href="{{ route(
            'ppks.normal.case-conference.detail',
            ['ppks' => $ppksItem->id]
        ) }}"
        class="action-button action-case"
    >
        <span class="material-symbols-outlined action-icon">
            medical_services
        </span>

        <span class="action-title">
            Case Conference
        </span>

        <span class="action-arrow">
            ›
        </span>
    </a>

</td>



                        </tr>

                    @empty

                        <tr id="emptyRow">

                            <td colspan="9">
                                Belum ada data PPKS yang lulus.
                            </td>

                        </tr>

                    @endforelse

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


    {{-- =====================================================
    JAVASCRIPT
    ====================================================== --}}

    <script>

        document.addEventListener(
            'DOMContentLoaded',
            function () {

                const searchInput =
                    document.getElementById('searchInput');

                const ppksFilter =
                    document.getElementById('ppksFilter');

                const tahapanFilter =
                    document.getElementById('tahapanFilter');

                const hasilFilter =
                    document.getElementById('hasilFilter');

                const tableRows =
                    document.querySelectorAll(
                        '.table tbody tr[data-nama]'
                    );

                const emptyRow =
                    document.getElementById('emptyRow');


                /* =================================================
                   DATE ELEMENT
                ================================================== */

                const dateFilterButton =
                    document.getElementById(
                        'dateFilterButton'
                    );

                const datePicker =
                    document.getElementById(
                        'datePicker'
                    );

                const dateFilterText =
                    document.getElementById(
                        'dateFilterText'
                    );

                const startDate =
                    document.getElementById(
                        'startDate'
                    );

                const endDate =
                    document.getElementById(
                        'endDate'
                    );

                const applyDate =
                    document.getElementById(
                        'applyDate'
                    );

                const resetDate =
                    document.getElementById(
                        'resetDate'
                    );


                /* =================================================
                   FILTER TABLE
                ================================================== */

                function filterTable() {

                    const searchValue =
                        searchInput.value
                            .toLowerCase()
                            .trim();


                    const ppksValue =
                        ppksFilter.value
                            .toLowerCase()
                            .trim();


                    const tahapanValue =
                        tahapanFilter.value
                            .toLowerCase()
                            .trim();


                    const hasilValue =
                        hasilFilter.value
                            .toLowerCase()
                            .trim();


                    const selectedStart =
                        startDate.value;


                    const selectedEnd =
                        endDate.value;


                    let visibleNumber = 1;

                    let found = false;


                    tableRows.forEach(
                        function (row) {

                            const nama =
                                row.dataset.nama || '';


                            const nik =
                                row.dataset.nik || '';


                            const ppks =
                                row.dataset.ppks || '';


                            const tahapan =
                                row.dataset.tahapan || '';


                            const hasil =
                                row.dataset.hasil || '';


                            const tanggal =
                                row.dataset.tanggal || '';


                            /* SEARCH */

                            const matchSearch =
                                nama.includes(searchValue)
                                ||
                                nik.includes(searchValue);


                            /* PPKS */

                            const matchPpks =
                                ppksValue === ''
                                ||
                                ppks === ppksValue;


                            /* TAHAPAN */

                            const matchTahapan =
                                tahapanValue === ''
                                ||
                                tahapan === tahapanValue;


                            /* HASIL */

                            const matchHasil =
                                hasilValue === ''
                                ||
                                hasil === hasilValue;


                            /* DATE */

                            let matchDate = true;


                            if (selectedStart) {

                                matchDate =
                                    tanggal !== ''
                                    &&
                                    tanggal >= selectedStart;

                            }


                            if (
                                selectedEnd
                                &&
                                matchDate
                            ) {

                                matchDate =
                                    tanggal !== ''
                                    &&
                                    tanggal <= selectedEnd;

                            }


                            /* FINAL */

                            const shouldShow =
                                matchSearch
                                &&
                                matchPpks
                                &&
                                matchTahapan
                                &&
                                matchHasil
                                &&
                                matchDate;


                            if (shouldShow) {

                                row.style.display = '';


                                const numberCell =
                                    row.querySelector(
                                        '.row-number'
                                    );


                                if (numberCell) {

                                    numberCell.textContent =
                                        visibleNumber;

                                }


                                visibleNumber++;

                                found = true;

                            } else {

                                row.style.display = 'none';

                            }

                        }
                    );


                    if (emptyRow) {

                        emptyRow.style.display =
                            found
                            ? 'none'
                            : 'table-row';

                    }

                }


                /* =================================================
                   SEARCH
                ================================================== */

                searchInput.addEventListener(
                    'input',
                    filterTable
                );


                /* =================================================
                   FILTER
                ================================================== */

                ppksFilter.addEventListener(
                    'change',
                    filterTable
                );


                tahapanFilter.addEventListener(
                    'change',
                    filterTable
                );


                hasilFilter.addEventListener(
                    'change',
                    filterTable
                );


                /* =================================================
                   DATE PICKER
                ================================================== */

                dateFilterButton.addEventListener(
                    'click',
                    function (event) {

                        event.stopPropagation();

                        datePicker.classList.toggle(
                            'active'
                        );

                    }
                );


                datePicker.addEventListener(
                    'click',
                    function (event) {

                        event.stopPropagation();

                    }
                );


                /* =================================================
                   APPLY DATE
                ================================================== */

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


                        dateFilterText.textContent =
                            formatDate(start)
                            +
                            ' - '
                            +
                            formatDate(end);


                        datePicker.classList.remove(
                            'active'
                        );


                        filterTable();

                    }
                );


                /* =================================================
                   RESET DATE
                ================================================== */

                resetDate.addEventListener(
                    'click',
                    function () {

                        startDate.value = '';

                        endDate.value = '';

                        dateFilterText.textContent =
                            'Pilih Tanggal';


                        datePicker.classList.remove(
                            'active'
                        );


                        filterTable();

                    }
                );


                /* =================================================
                   FORMAT DATE
                ================================================== */

                function formatDate(dateString) {

                    const date =
                        new Date(
                            dateString
                            +
                            'T00:00:00'
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


                /* =================================================
                   CLICK OUTSIDE
                ================================================== */

                document.addEventListener(
                    'click',
                    function () {

                        datePicker.classList.remove(
                            'active'
                        );

                    }
                );


                /* =================================================
                   INITIAL FILTER
                ================================================== */

                filterTable();

            }
        );

    </script>

</x-app-layout>
