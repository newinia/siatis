<x-app-layout>

    <style>

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
        padding: 0 20px;
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
            min-width: 1100px;
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

        /* =====================================================
           HASIL
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
           EMPTY
        ===================================================== */

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

        /* =====================================================
           PAGINATION
        ===================================================== */

        .case-pagination {
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
                flex: 1;
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

                        <span
                            class="material-symbols-outlined"
                            style="font-size: 19px;"
                        >
                            picture_as_pdf
                        </span>

                        PDF

                    </button>


                    {{-- PDF FILTER --}}

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


            {{-- FILTER JENIS PPKS --}}

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


            {{-- FILTER HASIL --}}

            <div class="select-wrapper">

                <select
                    id="hasilFilter"
                    class="case-filter-button"
                >

                    <option value="">
                        Semua Hasil
                    </option>

                    <option value="Diterima">
                        Diterima
                    </option>

                    <option value="Tidak Diterima">
                        Tidak Diterima
                    </option>

                    <option value="Pending">
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

                            $item = is_array($ppks->data)
                                ? $ppks->data
                                : [];


                            /* NAMA */

                            $nama =
                                $item['nama_lengkap'] ??
                                $item['nama'] ??
                                $item['Nama'] ??
                                $item['NAMA'] ??
                                '-';


                            /* NIK */

                            $nik =
                                $item['nik'] ??
                                $item['NIK'] ??
                                $item['Nik'] ??
                                '-';
                            /* ALAMAT */

                            $alamat =
                                $item['alamat'] ??
                                $item['Alamat'] ??
                                $item['alamat_lengkap'] ??
                                $item['Alamat Lengkap'] ??
                                $item['alamat_domisili'] ??
                                $item['Alamat Domisili'] ??
                                '-';

                            /* UMUR */

                            $umur = '-';

                            if (!empty($item['tanggal_lahir'])) {

                                try {

                                    $umur =
                                        \Carbon\Carbon::parse(
                                            $item['tanggal_lahir']
                                        )->age . ' tahun';

                                } catch (\Exception $e) {

                                    $umur =
                                        $item['usia'] ??
                                        '-';

                                }

                            } elseif (!empty($item['usia'])) {

                                $umur =
                                    $item['usia'] . ' tahun';

                            }


                            /* JENIS PPKS */

                            $jenisPpks =
                                $item['jenis_ppks'] ??
                                $item['Jenis PPKS'] ??
                                $item['jenis ppks'] ??
                                $item['jenis'] ??
                                $item['Jenis'] ??
                                '-';


                            /* JURUSAN */

                            $jurusan =
                                $item['jurusan_diterima'] ??
                                $item['jurusan'] ??
                                $item['Jurusan'] ??
                                $item['JURUSAN'] ??
                                $item['jurusan_yang_diminati'] ??
                                '-';


                            /* CASE CONFERENCE */

                            $caseConference =
                                $ppks->prosesPesertas
                                    ->where(
                                        'tahap',
                                        'case_conference'
                                    )
                                    ->sortByDesc(
                                        function ($item) {

                                            return
                                                $item->tanggal_proses
                                                ?? $item->created_at;

                                        }
                                    )
                                    ->first();


                            /* STATUS */

                            $status =
                                $caseConference->status
                                ?? 'pending';

                            $statusLower =
                                strtolower(trim($status));


                            /* HASIL */

                            if (
                                in_array(
                                    $statusLower,
                                    [
                                        'diterima',
                                        'lulus',
                                        'accepted'
                                    ]
                                )
                            ) {

                                $hasilText =
                                    'Diterima';

                                $hasilClass =
                                    'result-accepted';

                                $icon =
                                    'task_alt';

                                $dotClass =
                                    'accepted';

                            } elseif (
                                in_array(
                                    $statusLower,
                                    [
                                        'tidak_diterima',
                                        'tidak_lulus',
                                        'ditolak',
                                        'tidak lulus',
                                        'rejected'
                                    ]
                                )
                            ) {

                                $hasilText =
                                    'Tidak Diterima';

                                $hasilClass =
                                    'result-rejected';

                                $icon =
                                    'cancel';

                                $dotClass =
                                    'rejected';

                            } else {

                                $hasilText =
                                    'Pending';

                                $hasilClass =
                                    'result-pending';

                                $icon =
                                    'pending';

                                $dotClass =
                                    'pending';

                            }

                        @endphp


                        <tr
                            class="case-row"
                            data-nama="{{ strtolower($nama) }}"
                            data-nik="{{ strtolower($nik) }}"
                            data-ppks="{{ strtolower($jenisPpks) }}"
                            data-hasil="{{ strtolower($hasilText) }}"
                        >

                            <td class="row-number">
                                {{ $data->firstItem() + $index }}
                            </td>


                            <td>

                                <strong>
                                    {{ $nama }}
                                </strong>

                            </td>


                            <td>
                                {{ $nik }}
                            </td>

                            <td>
                                {{ $alamat }}
                            </td>


                            <td>
                                {{ $umur }}
                            </td>


                            <td>
                                {{ $jenisPpks }}
                            </td>


                            <td>
                                {{ $jurusan }}
                            </td>


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

                                            <span
                                                class="status-dot {{ $dotClass }}"
                                            ></span>

                                            {{ $hasilText }}

                                        </span>

                                    </div>


                                    <span class="result-arrow">
                                        ›
                                    </span>

                                </a>

                            </td>


                            <td>
                                {{ $caseConference?->catatan ?? '-' }}
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


                    @if ($data->count())

                        <tr
                            id="filterEmptyRow"
                            style="display:none;"
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


            {{-- PAGINATION --}}

            @if ($data->hasPages())

                <div class="case-pagination">

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


                /* =================================================
                   PDF
                ================================================= */

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


                /* BUKA PDF FILTER */

                if (
                    pdfButton &&
                    pdfFilter
                ) {

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


                /* KLIK DI DALAM PDF FILTER */

                if (pdfFilter) {

                    pdfFilter.addEventListener(
                        'click',
                        function (event) {

                            event.stopPropagation();

                        }
                    );

                }


                /* RESET PDF */

                if (pdfReset) {

                    pdfReset.addEventListener(
                        'click',
                        function () {

                            pdfGelombang.value = '';
                            pdfTahun.value = '';

                        }
                    );

                }


                /* BUAT PDF */

                if (pdfGenerate) {

                    pdfGenerate.addEventListener(
                        'click',
                        function () {

                            const gelombang =
                                pdfGelombang.value;

                            const tahun =
                                pdfTahun.value;


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


                            pdfFilter.classList.remove(
                                'active'
                            );

                        }
                    );

                }


                /* =================================================
                   FILTER TABLE
                ================================================= */

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


                            /* SEARCH */

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


                            /* JENIS PPKS */

                            const matchPpks =
                                ppksValue === ''
                                ||
                                ppks === ppksValue;


                            /* HASIL */

                            const matchHasil =
                                hasilValue === ''
                                ||
                                hasil === hasilValue;


                            /* FINAL */

                            const shouldShow =
                                matchSearch
                                &&
                                matchPpks
                                &&
                                matchHasil;


                            if (shouldShow) {

                                row.style.display =
                                    '';

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


                    /* EMPTY FILTER */

                    if (filterEmptyRow) {

                        filterEmptyRow.style.display =
                            found
                                ? 'none'
                                : 'table-row';

                    }

                }


                /* SEARCH */

                if (searchInput) {

                    searchInput.addEventListener(
                        'input',
                        filterTable
                    );

                }


                /* PPKS */

                if (ppksFilter) {

                    ppksFilter.addEventListener(
                        'change',
                        filterTable
                    );

                }


                /* HASIL */

                if (hasilFilter) {

                    hasilFilter.addEventListener(
                        'change',
                        filterTable
                    );

                }


                /* =================================================
                   CLICK OUTSIDE
                ================================================= */

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


                /* =================================================
                   INITIAL FILTER
                ================================================= */

                filterTable();

            }
        );

    </script>

</x-app-layout>

