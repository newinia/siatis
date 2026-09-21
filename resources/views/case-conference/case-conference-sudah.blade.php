```blade
<x-app-layout>

    <style>

        /* =====================================================
           PAGE
        ===================================================== */

        .case-conference-page {
            width: 100%;
            padding: 10px 0 35px;
            color: #172018;
        }


        /* =====================================================
           HEADER
        ===================================================== */

        .case-conference-header {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 24px;
            margin-bottom: 22px;
        }

        .case-header-left {
            flex: 1;
            min-width: 0;
        }

        .case-header-left h1 {
            margin: 0;
            font-size: 28px;
            line-height: 1.2;
            font-weight: 700;
            color: #172018;
        }

        .case-header-left p {
            margin: 7px 0 0;
            color: #68716b;
            font-size: 14px;
            line-height: 1.5;
        }


        /* =====================================================
           HEADER ACTION
        ===================================================== */

        .case-header-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }


        /* =====================================================
           PDF BUTTON
        ===================================================== */

        .pdf-filter-wrapper {
            position: relative;
        }

        .pdf-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            height: 40px;
            min-width: 120px;
            padding: 0 18px;
            background: #b42318;
            color: #fff;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: .15s ease;
            white-space: nowrap;
            cursor: pointer;
        }

        .pdf-button:hover {
            background: #981b12;
        }


        /* =====================================================
           PDF FILTER POPUP
        ===================================================== */

        .pdf-filter {
            display: none;
            position: absolute;
            right: 0;
            top: calc(100% + 8px);
            width: 270px;
            padding: 17px;
            background: #fff;
            border: 1px solid #dfe4e1;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .10);
            z-index: 100;
            box-sizing: border-box;
        }

        .pdf-filter.active {
            display: block;
        }

        .pdf-filter-title {
            margin-bottom: 14px;
            font-size: 14px;
            font-weight: 700;
            color: #26302a;
        }

        .pdf-filter-group {
            margin-bottom: 12px;
        }

        .pdf-filter-group label {
            display: block;
            margin-bottom: 6px;
            font-size: 12px;
            color: #69736d;
        }

        .pdf-filter-group select {
            width: 100%;
            height: 38px;
            padding: 0 10px;
            border: 1px solid #d9dedb;
            border-radius: 7px;
            background: #fff;
            color: #303932;
            font-size: 12px;
            outline: none;
            box-sizing: border-box;
        }

        .pdf-filter-group select:focus {
            border-color: #286c3a;
        }

        .pdf-filter-actions {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
            margin-top: 15px;
        }

        .pdf-reset,
        .pdf-generate {
            border: none;
            border-radius: 7px;
            padding: 8px 13px;
            font-size: 12px;
            cursor: pointer;
        }

        .pdf-reset {
            background: #f0f2f0;
            color: #4e5751;
        }

        .pdf-reset:hover {
            background: #e6e9e6;
        }

        .pdf-generate {
            background: #b42318;
            color: #fff;
        }

        .pdf-generate:hover {
            background: #981b12;
        }


        /* =====================================================
           FILTER
        ===================================================== */

        .case-filter-wrapper {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 18px;
            flex-wrap: wrap;
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
            box-sizing: border-box;
        }

        .case-search:focus-within {
            border-color: #286c3a;
        }

        .case-search .material-symbols-outlined {
            flex-shrink: 0;
            color: #7a847d;
            font-size: 19px;
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

        .select-wrapper {
            position: relative;
        }

        .case-filter-button {
            height: 40px;
            min-width: 175px;
            appearance: none;
            padding: 0 38px 0 13px;
            border: 1px solid #d9dedb;
            border-radius: 8px;
            background: #fff;
            color: #4d5751;
            font-size: 13px;
            cursor: pointer;
            outline: none;
        }

        .case-filter-button:focus {
            border-color: #286c3a;
        }

        .select-arrow {
            position: absolute;
            right: 11px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 18px;
            color: #68716b;
            pointer-events: none;
        }


        /* =====================================================
           TABLE
        ===================================================== */

        .table-wrapper {
            width: 100%;
            background: #fff;
            border: 1px solid #e0e4e1;
            border-radius: 10px;
            overflow-x: auto;
            box-sizing: border-box;
        }

        .table {
            width: 100%;
            min-width: 1200px;
            border-collapse: collapse;
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

        .row-number {
            width: 45px;
            color: #68716b !important;
        }

        .participant-name {
            min-width: 180px;
            font-weight: 600;
            color: #26302a;
        }

        .address-cell {
            min-width: 220px;
            max-width: 280px;
            line-height: 1.5;
        }

        .ppks-cell {
            min-width: 170px;
        }

        .jurusan-cell {
            min-width: 150px;
        }

        .keterangan-cell {
            min-width: 220px;
            max-width: 300px;
            line-height: 1.5;
            color: #59635c;
        }


        /* =====================================================
           RESULT BADGE
        ===================================================== */

        .result-badge {
            min-width: 180px;
            display: inline-flex;
            align-items: center;
            gap: 9px;
            padding: 8px 10px;
            border-radius: 8px;
            text-decoration: none;
            transition: .15s ease;
            box-sizing: border-box;
        }

        .result-badge:hover {
            opacity: .85;
            transform: translateX(2px);
        }

        .result-accepted {
            background: #edf8f0;
            color: #28733c;
        }

        .result-rejected {
            background: #fff0f0;
            color: #b33b3b;
        }

        .result-pending {
            background: #fff8e8;
            color: #a56a00;
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
            min-width: 0;
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
            flex-shrink: 0;
        }

        .status-dot.accepted {
            background: #39a354;
        }

        .status-dot.rejected {
            background: #c74747;
        }

        .status-dot.pending {
            background: #d49317;
        }

        .result-arrow {
            font-size: 22px;
            line-height: 1;
            color: #6d776f;
        }


        /* =====================================================
           KETERANGAN
        ===================================================== */

        .keterangan-lolos {
            color: #28733c;
            font-weight: 600;
        }

        .keterangan-tidak-lolos {
            color: #b33b3b;
            font-weight: 600;
        }

        .keterangan-pending {
            color: #a56a00;
            font-weight: 600;
        }


        /* =====================================================
           EMPTY
        ===================================================== */

        .empty-state {
            text-align: center;
            padding: 55px 20px !important;
            color: #747d77 !important;
        }

        .empty-state .material-symbols-outlined {
            display: block;
            font-size: 45px;
            margin-bottom: 10px;
            color: #9aa39d;
        }

        .empty-state p {
            margin: 0;
            font-size: 14px;
        }


        /* =====================================================
           PAGINATION
        ===================================================== */

        .pagination-wrapper {
            padding: 15px 18px;
            border-top: 1px solid #edf0ee;
        }


        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media (max-width: 900px) {

            .case-conference-header {
                flex-direction: column;
                gap: 15px;
            }

            .case-header-actions {
                width: 100%;
            }

            .pdf-filter-wrapper {
                width: 100%;
            }

            .pdf-button {
                width: 100%;
            }

            .pdf-filter {
                left: 0;
                right: auto;
                width: 100%;
            }

            .case-search {
                width: 100%;
            }

            .select-wrapper {
                width: 100%;
            }

            .case-filter-button {
                width: 100%;
            }

        }

    </style>


    <div class="case-conference-page">

        {{-- =====================================================
        HEADER
        ====================================================== --}}

        <div class="case-conference-header">

            <div class="case-header-left">

                <h1>
                    Case Conference
                </h1>

                <p>
                    Data peserta yang telah melaksanakan Case Conference.
                </p>

            </div>


            {{-- =================================================
            HEADER ACTION
            ================================================== --}}

            <div class="case-header-actions">

                {{-- =================================================
                PDF
                ================================================== --}}

                <div class="pdf-filter-wrapper">

                    <button
                        type="button"
                        class="pdf-button"
                        id="pdfButton"
                    >

                        <span class="material-symbols-outlined">
                            picture_as_pdf
                        </span>

                        PDF

                    </button>


                    {{-- =================================================
                    PDF FILTER POPUP
                    ================================================== --}}

                    <div
                        class="pdf-filter"
                        id="pdfFilter"
                    >

                        <div class="pdf-filter-title">
                            Cetak Data Case Conference
                        </div>


                        {{-- GELOMBANG --}}

                        <div class="pdf-filter-group">

                            <label for="pdfGelombang">
                                Gelombang
                            </label>

                            <select id="pdfGelombang">

                                <option value="">
                                    Semua Gelombang
                                </option>

                                @for ($i = 1; $i <= 10; $i++)

                                    <option value="{{ $i }}">
                                        Gelombang {{ $i }}
                                    </option>

                                @endfor

                            </select>

                        </div>


                        {{-- TAHUN --}}

                        <div class="pdf-filter-group">

                            <label for="pdfTahun">
                                Tahun
                            </label>

                            <select id="pdfTahun">

                                <option value="">
                                    Semua Tahun
                                </option>

                                @for ($tahun = 2026; $tahun <= 2036; $tahun++)

                                    <option value="{{ $tahun }}">
                                        {{ $tahun }}
                                    </option>

                                @endfor

                            </select>

                        </div>


                        {{-- ACTION --}}

                        <div class="pdf-filter-actions">

                            <button
                                type="button"
                                class="pdf-reset"
                                id="pdfReset"
                            >
                                Reset
                            </button>

                            <button
                                type="button"
                                class="pdf-generate"
                                id="pdfGenerate"
                            >
                                Buat PDF
                            </button>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- =====================================================
        FILTER
        ====================================================== --}}

        <div class="case-filter-wrapper">

            {{-- SEARCH --}}

            <div class="case-search">

                <span class="material-symbols-outlined">
                    search
                </span>

                <input
                    type="text"
                    id="searchInput"
                    placeholder="Cari Nama atau NIK"
                    autocomplete="off"
                >

            </div>


            {{-- =================================================
            FILTER JENIS PPKS
            ================================================== --}}

            <div class="select-wrapper">

                <select
                    id="ppksFilter"
                    class="case-filter-button"
                >

                    <option value="">
                        Semua Jenis PPKS
                    </option>

                    <option value="disabilitas fisik">
                        Disabilitas Fisik
                    </option>

                    <option value="disabilitas rungu wicara">
                        Disabilitas Rungu Wicara
                    </option>

                    <option value="disabilitas netra">
                        Disabilitas Netra
                    </option>

                    <option value="disabilitas mental">
                        Disabilitas Mental
                    </option>

                    <option value="disabilitas intelektual">
                        Disabilitas Intelektual
                    </option>

                    <option value="kelompok rentan">
                        Kelompok Rentan
                    </option>

                    <option value="other">
                        Other
                    </option>

                </select>

                <span class="material-symbols-outlined select-arrow">
                    keyboard_arrow_down
                </span>

            </div>


            {{-- =================================================
            FILTER HASIL
            ================================================== --}}

            <div class="select-wrapper">

                <select
                    id="hasilFilter"
                    class="case-filter-button"
                >

                    <option value="">
                        Semua Hasil
                    </option>

                    <option value="diterima">
                        Diterima
                    </option>

                    <option value="tidak diterima">
                        Tidak Diterima
                    </option>

                    <option value="pending">
                        Pending
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
                        <th>Alamat</th>
                        <th>Umur</th>
                        <th>Jenis PPKS</th>
                        <th>Jurusan</th>
                        <th>Hasil</th>
                        <th>Keterangan</th>

                    </tr>

                </thead>


                <tbody id="caseTableBody">

                    @forelse ($data as $index => $ppks)

                        @php

                            /*
                            |--------------------------------------------------------------------------
                            | DATA PPKS
                            |--------------------------------------------------------------------------
                            */

                            $item = is_array($ppks->data ?? null)
                                ? $ppks->data
                                : [];


                            /*
                            |--------------------------------------------------------------------------
                            | NAMA
                            |--------------------------------------------------------------------------
                            */

                            $nama =
                                $item['nama_lengkap']
                                ?? $item['nama']
                                ?? $item['Nama']
                                ?? $item['NAMA']
                                ?? '-';


                            /*
                            |--------------------------------------------------------------------------
                            | NIK
                            |--------------------------------------------------------------------------
                            */

                            $nik =
                                $item['nik']
                                ?? $item['NIK']
                                ?? $item['Nik']
                                ?? '-';


                            /*
                            |--------------------------------------------------------------------------
                            | ALAMAT
                            |--------------------------------------------------------------------------
                            */

                            $alamat =
                                $item['alamat']
                                ?? $item['Alamat']
                                ?? $item['alamat_lengkap']
                                ?? $item['Alamat Lengkap']
                                ?? $item['alamat_domisili']
                                ?? $item['Alamat Domisili']
                                ?? '-';


                            /*
                            |--------------------------------------------------------------------------
                            | UMUR
                            |--------------------------------------------------------------------------
                            */

                            $umur = '-';

                            if (!empty($item['tanggal_lahir'])) {

                                try {

                                    $umur =
                                        \Carbon\Carbon::parse(
                                            $item['tanggal_lahir']
                                        )->age . ' tahun';

                                } catch (\Exception $e) {

                                    $umur =
                                        !empty($item['usia'])
                                            ? $item['usia'] . ' tahun'
                                            : '-';

                                }

                            } elseif (!empty($item['usia'])) {

                                $umur =
                                    $item['usia'] . ' tahun';

                            }


                            /*
                            |--------------------------------------------------------------------------
                            | JENIS PPKS
                            |--------------------------------------------------------------------------
                            */

                            $jenisPpks =
                                $item['jenis_ppks']
                                ?? $item['Jenis PPKS']
                                ?? $item['jenis ppks']
                                ?? $item['jenis']
                                ?? $item['Jenis']
                                ?? '-';


                            /*
                            |--------------------------------------------------------------------------
                            | JURUSAN
                            |--------------------------------------------------------------------------
                            */

                            $jurusan =
                                $item['jurusan_diterima']
                                ?? $item['jurusan']
                                ?? $item['Jurusan']
                                ?? $item['JURUSAN']
                                ?? $item['jurusan_yang_diminati']
                                ?? '-';


                            /*
                            |--------------------------------------------------------------------------
                            | CASE CONFERENCE TERBARU
                            |--------------------------------------------------------------------------
                            */

                            $caseConference = $ppks->prosesPesertas
                                ->where('tahap', 'case_conference')
                                ->sortByDesc(function ($proses) {

                                    return $proses->tanggal_proses
                                        ?? $proses->created_at;

                                })
                                ->first();


                            /*
                            |--------------------------------------------------------------------------
                            | STATUS
                            |--------------------------------------------------------------------------
                            */

                            $status =
                                $caseConference->status
                                ?? 'pending';

                            $statusLower =
                                strtolower(
                                    trim(
                                        str_replace(
                                            '-',
                                            '_',
                                            $status
                                        )
                                    )
                                );


                            /*
                            |--------------------------------------------------------------------------
                            | HASIL
                            |--------------------------------------------------------------------------
                            */

                            if (
                                in_array(
                                    $statusLower,
                                    [
                                        'diterima',
                                        'lulus',
                                        'accepted'
                                    ],
                                    true
                                )
                            ) {

                                $hasilText = 'Diterima';

                                $hasilClass = 'result-accepted';

                                $icon = 'task_alt';

                                $dotClass = 'accepted';

                                $keteranganClass =
                                    'keterangan-lolos';

                            } elseif (
                                in_array(
                                    $statusLower,
                                    [
                                        'tidak_diterima',
                                        'tidak_lulus',
                                        'ditolak',
                                        'rejected'
                                    ],
                                    true
                                )
                            ) {

                                $hasilText = 'Tidak Diterima';

                                $hasilClass = 'result-rejected';

                                $icon = 'cancel';

                                $dotClass = 'rejected';

                                $keteranganClass =
                                    'keterangan-tidak-lolos';

                            } else {

                                $hasilText = 'Pending';

                                $hasilClass = 'result-pending';

                                $icon = 'pending';

                                $dotClass = 'pending';

                                $keteranganClass =
                                    'keterangan-pending';

                            }


                            /*
                            |--------------------------------------------------------------------------
                            | KETERANGAN
                            |--------------------------------------------------------------------------
                            */

                            $keterangan =
                                $caseConference?->catatan
                                ?? '-';

                        @endphp


                        <tr
                            class="case-row"
                            data-nama="{{ strtolower((string) $nama) }}"
                            data-nik="{{ strtolower((string) $nik) }}"
                            data-ppks="{{ strtolower((string) $jenisPpks) }}"
                            data-hasil="{{ strtolower((string) $hasilText) }}"
                        >

                            {{-- NO --}}

                            <td class="row-number">
                                {{ $data->firstItem() + $index }}
                            </td>


                            {{-- NAMA --}}

                            <td>

                                <div class="participant-name">
                                    {{ $nama }}
                                </div>

                            </td>


                            {{-- NIK --}}

                            <td>
                                {{ $nik }}
                            </td>


                            {{-- ALAMAT --}}

                            <td class="address-cell">
                                {{ $alamat }}
                            </td>


                            {{-- UMUR --}}

                            <td>
                                {{ $umur }}
                            </td>


                            {{-- JENIS PPKS --}}

                            <td class="ppks-cell">
                                {{ $jenisPpks }}
                            </td>


                            {{-- JURUSAN --}}

                            <td class="jurusan-cell">
                                {{ $jurusan }}
                            </td>


                            {{-- HASIL --}}

                            <td>

                                <a
                                    href="{{ route(
                                        'ppks.normal.case-conference.detail',
                                        $ppks->id
                                    ) }}"
                                    class="result-badge {{ $hasilClass }}"
                                >

                                    <span class="material-symbols-outlined result-icon">
                                        {{ $icon }}
                                    </span>


                                    <div class="result-content">

                                        <span class="result-title">
                                            Case Conference
                                        </span>

                                        <span class="result-status">

                                            <span class="status-dot {{ $dotClass }}"></span>

                                            {{ $hasilText }}

                                        </span>

                                    </div>


                                    <span class="material-symbols-outlined result-arrow">
                                        chevron_right
                                    </span>

                                </a>

                            </td>


                            {{-- KETERANGAN --}}

                            <td class="keterangan-cell">

                                <span class="{{ $keteranganClass }}">
                                    {{ $keterangan }}
                                </span>

                            </td>

                        </tr>

                    @empty

                        <tr id="emptyRow">

                            <td
                                colspan="9"
                                class="empty-state"
                            >

                                <span class="material-symbols-outlined">
                                    event_busy
                                </span>

                                <p>
                                    Belum ada peserta yang telah melakukan Case Conference.
                                </p>

                            </td>

                        </tr>

                    @endforelse


                    {{-- EMPTY HASIL FILTER --}}

                    @if ($data->count())

                        <tr
                            id="filterEmptyRow"
                            style="display: none;"
                        >

                            <td
                                colspan="9"
                                class="empty-state"
                            >

                                <span class="material-symbols-outlined">
                                    search_off
                                </span>

                                <p>
                                    Data tidak ditemukan.
                                </p>

                            </td>

                        </tr>

                    @endif

                </tbody>

            </table>


            {{-- =================================================
            PAGINATION
            ================================================== --}}

            @if ($data->hasPages())

                <div class="pagination-wrapper">
                    {{ $data->links() }}
                </div>

            @endif

        </div>

    </div>


    {{-- =====================================================
    JAVASCRIPT
    ====================================================== --}}

    <script>

        document.addEventListener(
            'DOMContentLoaded',
            function () {

                /*
                |--------------------------------------------------------------------------
                | ELEMENT
                |--------------------------------------------------------------------------
                */

                const searchInput =
                    document.getElementById(
                        'searchInput'
                    );

                const ppksFilter =
                    document.getElementById(
                        'ppksFilter'
                    );

                const hasilFilter =
                    document.getElementById(
                        'hasilFilter'
                    );

                const tableRows =
                    document.querySelectorAll(
                        '.case-row'
                    );

                const filterEmptyRow =
                    document.getElementById(
                        'filterEmptyRow'
                    );


                /*
                |--------------------------------------------------------------------------
                | PDF ELEMENT
                |--------------------------------------------------------------------------
                */

                const pdfButton =
                    document.getElementById(
                        'pdfButton'
                    );

                const pdfFilter =
                    document.getElementById(
                        'pdfFilter'
                    );

                const pdfGelombang =
                    document.getElementById(
                        'pdfGelombang'
                    );

                const pdfTahun =
                    document.getElementById(
                        'pdfTahun'
                    );

                const pdfGenerate =
                    document.getElementById(
                        'pdfGenerate'
                    );

                const pdfReset =
                    document.getElementById(
                        'pdfReset'
                    );


                /*
                |--------------------------------------------------------------------------
                | BUKA / TUTUP PDF FILTER
                |--------------------------------------------------------------------------
                */

                if (pdfButton && pdfFilter) {

                    pdfButton.addEventListener(
                        'click',
                        function (event) {

                            event.stopPropagation();

                            pdfFilter.classList.toggle(
                                'active'
                            );

                        }
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | KLIK DI DALAM POPUP
                |--------------------------------------------------------------------------
                */

                if (pdfFilter) {

                    pdfFilter.addEventListener(
                        'click',
                        function (event) {

                            event.stopPropagation();

                        }
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | RESET PDF
                |--------------------------------------------------------------------------
                */

                if (pdfReset) {

                    pdfReset.addEventListener(
                        'click',
                        function () {

                            if (pdfGelombang) {
                                pdfGelombang.value = '';
                            }

                            if (pdfTahun) {
                                pdfTahun.value = '';
                            }

                        }
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | BUAT PDF
                |--------------------------------------------------------------------------
                */

                if (pdfGenerate) {

                    pdfGenerate.addEventListener(
                        'click',
                        function () {

                            const gelombang =
                                pdfGelombang
                                    ? pdfGelombang.value
                                    : '';

                            const tahun =
                                pdfTahun
                                    ? pdfTahun.value
                                    : '';


                            const url =
                                new URL(
                                    "{{ route('ppks.normal.case-conference.pdf') }}",
                                    window.location.origin
                                );


                            if (gelombang) {

                                url.searchParams.set(
                                    'gelombang',
                                    gelombang
                                );

                            }


                            if (tahun) {

                                url.searchParams.set(
                                    'tahun',
                                    tahun
                                );

                            }


                            window.open(
                                url.toString(),
                                '_blank'
                            );


                            if (pdfFilter) {

                                pdfFilter.classList.remove(
                                    'active'
                                );

                            }

                        }
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | FILTER TABLE
                |--------------------------------------------------------------------------
                */

                function filterTable() {

                    const searchValue =
                        searchInput
                            ? searchInput.value
                                .toLowerCase()
                                .trim()
                            : '';


                    const ppksValue =
                        ppksFilter
                            ? ppksFilter.value
                                .toLowerCase()
                                .trim()
                            : '';


                    const hasilValue =
                        hasilFilter
                            ? hasilFilter.value
                                .toLowerCase()
                                .trim()
                            : '';


                    let found = false;

                    let visibleNumber = 1;


                    tableRows.forEach(
                        function (row) {

                            const nama =
                                row.dataset.nama
                                || '';

                            const nik =
                                row.dataset.nik
                                || '';

                            const ppks =
                                row.dataset.ppks
                                || '';

                            const hasil =
                                row.dataset.hasil
                                || '';


                            /*
                            |--------------------------------------------------------------------------
                            | SEARCH
                            |--------------------------------------------------------------------------
                            */

                            const matchSearch =
                                searchValue === ''
                                ||
                                nama.includes(
                                    searchValue
                                )
                                ||
                                nik.includes(
                                    searchValue
                                );


                            /*
                            |--------------------------------------------------------------------------
                            | JENIS PPKS
                            |--------------------------------------------------------------------------
                            */

                            const matchPpks =
                                ppksValue === ''
                                ||
                                ppks === ppksValue;


                            /*
                            |--------------------------------------------------------------------------
                            | HASIL
                            |--------------------------------------------------------------------------
                            */

                            const matchHasil =
                                hasilValue === ''
                                ||
                                hasil === hasilValue;


                            /*
                            |--------------------------------------------------------------------------
                            | FINAL
                            |--------------------------------------------------------------------------
                            */

                            const shouldShow =
                                matchSearch
                                &&
                                matchPpks
                                &&
                                matchHasil;


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

                                row.style.display =
                                    'none';

                            }

                        }
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | EMPTY FILTER
                    |--------------------------------------------------------------------------
                    */

                    if (filterEmptyRow) {

                        filterEmptyRow.style.display =
                            found
                                ? 'none'
                                : 'table-row';

                    }

                }


                /*
                |--------------------------------------------------------------------------
                | SEARCH EVENT
                |--------------------------------------------------------------------------
                */

                if (searchInput) {

                    searchInput.addEventListener(
                        'input',
                        filterTable
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | PPKS FILTER EVENT
                |--------------------------------------------------------------------------
                */

                if (ppksFilter) {

                    ppksFilter.addEventListener(
                        'change',
                        filterTable
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | HASIL FILTER EVENT
                |--------------------------------------------------------------------------
                */

                if (hasilFilter) {

                    hasilFilter.addEventListener(
                        'change',
                        filterTable
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | CLICK OUTSIDE PDF
                |--------------------------------------------------------------------------
                */

                document.addEventListener(
                    'click',
                    function () {

                        if (pdfFilter) {

                            pdfFilter.classList.remove(
                                'active'
                            );

                        }

                    }
                );


                /*
                |--------------------------------------------------------------------------
                | INITIAL FILTER
                |--------------------------------------------------------------------------
                */

                filterTable();

            }
        );

    </script>

</x-app-layout>
