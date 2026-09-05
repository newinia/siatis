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

        .date-filter-wrapper {
            position: relative;
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

        .date-picker {
            display: none;
            position: absolute;
            right: 0;
            top: calc(100% + 8px);
            width: 320px;
            padding: 18px;
            background: #fff;
            border: 1px solid #dfe4e1;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .10);
            z-index: 50;
        }

        .date-picker.active {
            display: block;
        }

        .date-picker-header {
            margin-bottom: 16px;
            font-size: 14px;
            color: #26302a;
        }

        .date-input-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .date-input-group label {
            display: block;
            margin-bottom: 6px;
            font-size: 12px;
            color: #69736d;
        }

        .date-input-group input {
            width: 100%;
            height: 38px;
            padding: 0 9px;
            border: 1px solid #d9dedb;
            border-radius: 7px;
            outline: none;
            font-size: 12px;
        }

        .date-picker-actions {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
            margin-top: 16px;
        }

        .date-reset,
        .date-apply {
            border: none;
            border-radius: 7px;
            padding: 8px 14px;
            font-size: 12px;
            cursor: pointer;
        }

        .date-reset {
            background: #f0f2f0;
            color: #4e5751;
        }

        .date-apply {
            background: #286c3a;
            color: #fff;
        }

        .case-filter-wrapper {
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
            min-width: 1100px;
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
            min-width: 180px;
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

            .date-filter-wrapper {
                width: 100%;
            }

            .date-filter {
                width: 100%;
                justify-content: center;
            }

            .date-picker {
                left: 0;
                right: auto;
                width: 100%;
            }

            .case-search {
                width: 100%;
            }

            .case-filter-button {
                width: 100%;
            }

            .select-wrapper {
                width: 100%;
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
                    Case Conference
                </h1>

                <p>
                    Data peserta yang telah melaksanakan Case Conference.
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


    /*
    |--------------------------------------------------------------------------
    | NAMA
    |--------------------------------------------------------------------------
    */

    $nama =
        $item['nama_lengkap'] ??
        $item['nama'] ??
        $item['Nama'] ??
        $item['NAMA'] ??
        '-';


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
    | Hitung otomatis berdasarkan tanggal lahir.
    */

    $umur = '-';

    if (!empty($item['tanggal_lahir'])) {

        try {

            $umur = \Carbon\Carbon::parse(
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
        $item['jurusan_diterima'] ??
        $item['jurusan'] ??
        $item['Jurusan'] ??
        $item['JURUSAN'] ??
        $item['jurusan_yang_diminati'] ??
        '-';


    /*
    |--------------------------------------------------------------------------
    | CASE CONFERENCE
    |--------------------------------------------------------------------------
    */

    $caseConference =
        $ppks->prosesPesertas
            ->where('tahap', 'case_conference')
            ->sortByDesc('tanggal_proses')
            ->first();


    /*
    |--------------------------------------------------------------------------
    | STATUS CASE CONFERENCE
    |--------------------------------------------------------------------------
    */

    $status =
        $caseConference->status ?? 'pending';


    $statusLower =
        strtolower(trim($status));


    /*
    |--------------------------------------------------------------------------
    | HASIL
    |--------------------------------------------------------------------------
    */

    if (
        in_array($statusLower, [
            'diterima',
            'lulus',
            'accepted'
        ])
    ) {

        $hasilText = 'Diterima';

        $hasilClass = 'result-accepted';

        $icon = 'task_alt';

        $dotClass = 'accepted';

    } elseif (
        in_array($statusLower, [
            'tidak_diterima',
            'tidak_lulus',
            'ditolak',
            'tidak lulus',
            'rejected'
        ])
    ) {

        $hasilText = 'Tidak Diterima';

        $hasilClass = 'result-rejected';

        $icon = 'cancel';

        $dotClass = 'rejected';

    } else {

        $hasilText = 'Pending';

        $hasilClass = 'result-pending';

        $icon = 'pending';

        $dotClass = 'pending';

    }


    /*
    |--------------------------------------------------------------------------
    | TANGGAL CASE CONFERENCE
    |--------------------------------------------------------------------------
    */

    $tanggal =
        $caseConference->tanggal_proses ??
        $caseConference->created_at ??
        null;


    $tanggalFilter =
        $tanggal
            ? \Carbon\Carbon::parse($tanggal)->format('Y-m-d')
            : '';

@endphp
                        <tr
                            class="case-row"

                            data-nama="{{ strtolower($nama) }}"

                            data-nik="{{ strtolower($nik) }}"

                            data-ppks="{{ strtolower($jenisPpks) }}"

                            data-hasil="{{ strtolower($hasilText) }}"

                            data-tanggal="{{ $tanggalFilter }}"
                        >

                            {{-- NO --}}

                            <td class="row-number">
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


                            {{-- KETERANGAN --}}

                            <td>

                                @if ($statusLower === 'pending')

                                    Menunggu penyelesaian Case Conference

                                @elseif (
                                    in_array($statusLower, [
                                        'diterima',
                                        'lulus',
                                        'accepted'
                                    ])
                                )

                                    Peserta diterima

                                @else

                                    Peserta tidak diterima

                                @endif

                            </td>

                        </tr>


                    @empty

                        <tr id="emptyRow">

                            <td
                                colspan="8"
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
                            style="display:none;"
                        >

                            <td
                                colspan="8"
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

        document.addEventListener('DOMContentLoaded', function () {

            const searchInput =
                document.getElementById('searchInput');

            const ppksFilter =
                document.getElementById('ppksFilter');

            const hasilFilter =
                document.getElementById('hasilFilter');

            const tableRows =
                document.querySelectorAll('.case-row');

            const filterEmptyRow =
                document.getElementById('filterEmptyRow');


            // =====================================================
            // DATE
            // =====================================================

            const dateFilterButton =
                document.getElementById('dateFilterButton');

            const datePicker =
                document.getElementById('datePicker');

            const dateFilterText =
                document.getElementById('dateFilterText');

            const startDate =
                document.getElementById('startDate');

            const endDate =
                document.getElementById('endDate');

            const applyDate =
                document.getElementById('applyDate');

            const resetDate =
                document.getElementById('resetDate');


            // =====================================================
            // FILTER TABLE
            // =====================================================

            function filterTable() {

                const searchValue =
                    searchInput
                        ? searchInput.value.toLowerCase().trim()
                        : '';


                const ppksValue =
                    ppksFilter
                        ? ppksFilter.value.toLowerCase().trim()
                        : '';


                const hasilValue =
                    hasilFilter
                        ? hasilFilter.value.toLowerCase().trim()
                        : '';


                const selectedStart =
                    startDate
                        ? startDate.value
                        : '';


                const selectedEnd =
                    endDate
                        ? endDate.value
                        : '';


                let found = false;

                let visibleNumber = 1;


                tableRows.forEach(function (row) {

                    const nama =
                        row.dataset.nama || '';

                    const nik =
                        row.dataset.nik || '';

                    const ppks =
                        row.dataset.ppks || '';

                    const hasil =
                        row.dataset.hasil || '';

                    const tanggal =
                        row.dataset.tanggal || '';


                    // =================================================
                    // SEARCH
                    // =================================================

                    const matchSearch =
                        searchValue === '' ||
                        nama.includes(searchValue) ||
                        nik.includes(searchValue);


                    // =================================================
                    // JENIS PPKS
                    // =================================================

                    const matchPpks =
                        ppksValue === '' ||
                        ppks === ppksValue;


                    // =================================================
                    // HASIL
                    // =================================================

                    const matchHasil =
                        hasilValue === '' ||
                        hasil === hasilValue;


                    // =================================================
                    // DATE
                    // =================================================

                    let matchDate = true;


                    if (selectedStart) {

                        matchDate =
                            tanggal !== '' &&
                            tanggal >= selectedStart;

                    }


                    if (
                        selectedEnd &&
                        matchDate
                    ) {

                        matchDate =
                            tanggal !== '' &&
                            tanggal <= selectedEnd;

                    }


                    // =================================================
                    // FINAL
                    // =================================================

                    const shouldShow =
                        matchSearch &&
                        matchPpks &&
                        matchHasil &&
                        matchDate;


                    if (shouldShow) {

                        row.style.display = '';

                        const numberCell =
                            row.querySelector('.row-number');

                        if (numberCell) {

                            numberCell.textContent =
                                visibleNumber;

                        }

                        visibleNumber++;

                        found = true;

                    } else {

                        row.style.display = 'none';

                    }

                });


                // =====================================================
                // FILTER EMPTY
                // =====================================================

                if (filterEmptyRow) {

                    if (found) {

                        filterEmptyRow.style.display =
                            'none';

                    } else {

                        filterEmptyRow.style.display =
                            'table-row';

                    }

                }

            }


            // =====================================================
            // SEARCH
            // =====================================================

            if (searchInput) {

                searchInput.addEventListener(
                    'input',
                    filterTable
                );

            }


            // =====================================================
            // FILTER PPKS
            // =====================================================

            if (ppksFilter) {

                ppksFilter.addEventListener(
                    'change',
                    filterTable
                );

            }


            // =====================================================
            // FILTER HASIL
            // =====================================================

            if (hasilFilter) {

                hasilFilter.addEventListener(
                    'change',
                    filterTable
                );

            }


            // =====================================================
            // DATE OPEN
            // =====================================================

            if (dateFilterButton && datePicker) {

                dateFilterButton.addEventListener(
                    'click',
                    function (event) {

                        event.stopPropagation();

                        datePicker.classList.toggle(
                            'active'
                        );

                    }
                );

            }


            // =====================================================
            // DATE PICKER CLICK
            // =====================================================

            if (datePicker) {

                datePicker.addEventListener(
                    'click',
                    function (event) {

                        event.stopPropagation();

                    }
                );

            }


            // =====================================================
            // APPLY DATE
            // =====================================================

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


                        dateFilterText.textContent =
                            formatDate(start) +
                            ' - ' +
                            formatDate(end);


                        datePicker.classList.remove(
                            'active'
                        );


                        filterTable();

                    }
                );

            }


            // =====================================================
            // RESET DATE
            // =====================================================

            if (resetDate) {

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

            }


            // =====================================================
            // FORMAT DATE
            // =====================================================

            function formatDate(dateString) {

                const date =
                    new Date(
                        dateString + 'T00:00:00'
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


            // =====================================================
            // CLICK OUTSIDE
            // =====================================================

            document.addEventListener(
                'click',
                function () {

                    if (datePicker) {

                        datePicker.classList.remove(
                            'active'
                        );

                    }

                }
            );


            // =====================================================
            // INITIAL FILTER
            // =====================================================

            filterTable();

        });

    </script>

</x-app-layout>
