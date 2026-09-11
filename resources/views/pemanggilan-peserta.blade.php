<x-app-layout>

    <div class="main-page">

        {{-- =====================================================
        HEADER
        ====================================================== --}}
        <div class="main-page-header">

            <div>
                <h1>Data Pemanggilan Peserta</h1>

                <p>
                    Data PPKS Pemanggilan Peserta
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
                        <rect x="3" y="4" width="18" height="18" rx="2" />
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


                {{-- DATE PICKER --}}
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
        <div class="filter-wrapper">

            {{-- SEARCH --}}
            <div class="search">

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
                    id="searchInput"
                    placeholder="Cari Nama atau NIK"
                    autocomplete="off"
                >

            </div>


            {{-- FILTER STATUS --}}
            <div class="select-wrapper">

                <select
                    id="statusFilter"
                    class="filter-button"
                >

                    <option value="">
                        Semua Status
                    </option>

                    <option value="belum_dipanggil">
                        Belum Dipanggil
                    </option>

                    <option value="sudah_dipanggil">
                        Sudah Dipanggil
                    </option>

                    <option value="belum_datang">
                        Belum Datang
                    </option>

                    <option value="sudah_datang">
                        Sudah Datang
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
                        <th>Jenis PPKS</th>
                        <th>Peminatan</th>
                        <th>Jenis Keberangkatan</th>
                        <th>No HP</th>
                        <th>Status Pemanggilan</th>
                        <th>Tanggal Pemanggilan</th>
                        <th>Tanggal Kedatangan</th>
                        <th>Aksi</th>

                    </tr>

                </thead>


                <tbody>

                    @forelse ($pesertas as $index => $ppks)

                        @php

                            /*
                            |--------------------------------------------------------------------------
                            | DATA PPKS
                            |--------------------------------------------------------------------------
                            */

                            $data = $ppks->data ?? [];

                            if (!is_array($data)) {
                                $data = json_decode($data, true) ?? [];
                            }


                            /*
                            |--------------------------------------------------------------------------
                            | DATA PEMANGGILAN
                            |--------------------------------------------------------------------------
                            */

                            $pemanggilan = $ppks->pemanggilanPeserta;


                            /*
                            |--------------------------------------------------------------------------
                            | DATA CASE CONFERENCE
                            |--------------------------------------------------------------------------
                            */

                            $caseConference = $caseConferences->get($ppks->id);


                            /*
                            |--------------------------------------------------------------------------
                            | IDENTITAS PPKS
                            |--------------------------------------------------------------------------
                            */

                            $nama =
                                $data['nama_lengkap']
                                ?? '-';

                            $nik =
                                $data['nik']
                                ?? '-';

                            $jenisPpks =
                                $data['jenis_ppks']
                                ?? '-';

                            $noHp =
                                $data['no_hp_1']
                                ?? $data['no_hp_2']
                                ?? '-';


                            /*
                            |--------------------------------------------------------------------------
                            | PEMINATAN
                            |--------------------------------------------------------------------------
                            */

                            $peminatan =
                                $caseConference?->jurusan_diterima
                                ?? '-';


                            /*
                            |--------------------------------------------------------------------------
                            | JENIS KEBERANGKATAN
                            |--------------------------------------------------------------------------
                            */

                            $keberangkatan =
                                $data['baznas']
                                ?? '-';


                            /*
                            |--------------------------------------------------------------------------
                            | STATUS PEMANGGILAN
                            |--------------------------------------------------------------------------
                            */

                            $status =
                                $pemanggilan?->status_pemanggilan
                                ?? 'belum_dipanggil';


                            /*
                            |--------------------------------------------------------------------------
                            | TANGGAL PEMANGGILAN
                            |--------------------------------------------------------------------------
                            */

                            $tanggalPemanggilan =
                                $pemanggilan?->tanggal_pemanggilan;

                            $tanggalPemanggilanValue =
                                $tanggalPemanggilan
                                ? $tanggalPemanggilan->format('Y-m-d')
                                : '';

                            $tanggalPemanggilanTampil =
                                $tanggalPemanggilan
                                ? $tanggalPemanggilan->format('d-m-Y')
                                : '-';


                            /*
                            |--------------------------------------------------------------------------
                            | TANGGAL KEDATANGAN
                            |--------------------------------------------------------------------------
                            */

                            $tanggalKedatangan =
                                $pemanggilan?->tanggal_kedatangan;

                            $tanggalKedatanganValue =
                                $tanggalKedatangan
                                ? $tanggalKedatangan->format('Y-m-d')
                                : '';

                            $tanggalKedatanganTampil =
                                $tanggalKedatangan
                                ? $tanggalKedatangan->format('d-m-Y')
                                : '-';

                        @endphp


                        <tr
                            data-nama="{{ strtolower($nama) }}"
                            data-nik="{{ strtolower($nik) }}"
                            data-ppks="{{ strtolower($jenisPpks) }}"
                            data-peminatan="{{ strtolower($peminatan) }}"
                            data-keberangkatan="{{ strtolower($keberangkatan) }}"
                            data-status="{{ $status }}"
                            data-tanggal="{{ $tanggalPemanggilanValue }}"
                        >

                            {{-- =================================================
                            NO
                            ================================================== --}}
                            <td class="row-number">
                                {{ $index + 1 }}
                            </td>


                            {{-- =================================================
                            NAMA
                            ================================================== --}}
                            <td>
                                {{ $nama }}
                            </td>


                            {{-- =================================================
                            NIK
                            ================================================== --}}
                            <td>
                                {{ $nik }}
                            </td>


                            {{-- =================================================
                            JENIS PPKS
                            ================================================== --}}
                            <td>
                                {{ $jenisPpks }}
                            </td>


                            {{-- =================================================
                            PEMINATAN
                            ================================================== --}}
                            <td>
                                {{ $peminatan }}
                            </td>


                            {{-- =================================================
                            JENIS KEBERANGKATAN
                            ================================================== --}}
                            <td>
                                {{ $keberangkatan }}
                            </td>


                            {{-- =================================================
                            NO HP
                            ================================================== --}}
                            <td>
                                {{ $noHp }}
                            </td>


                            {{-- =================================================
                            FORM EDIT PEMANGGILAN
                            ================================================== --}}
                            <td colspan="4">

                                <form
                                    action="{{ route(
                                        'ppks.normal.pemanggilan.proses',
                                        $ppks
                                    ) }}"
                                    method="POST"
                                    class="pemanggilan-form"
                                >

                                    @csrf


                                    <div class="pemanggilan-edit-row">

                                        {{-- STATUS --}}
                                        <div class="pemanggilan-field">

                                            <label>
                                                Status
                                            </label>

                                            <select
                                                name="status_pemanggilan"
                                                class="pemanggilan-input status-edit"
                                                data-current-status="{{ $status }}"
                                                required
                                            >

                                                <option
                                                    value="belum_dipanggil"
                                                    {{ $status === 'belum_dipanggil' ? 'selected' : '' }}
                                                >
                                                    Belum Dipanggil
                                                </option>

                                                <option
                                                    value="sudah_dipanggil"
                                                    {{ $status === 'sudah_dipanggil' ? 'selected' : '' }}
                                                >
                                                    Sudah Dipanggil
                                                </option>

                                                <option
                                                    value="belum_datang"
                                                    {{ $status === 'belum_datang' ? 'selected' : '' }}
                                                >
                                                    Belum Datang
                                                </option>

                                                <option
                                                    value="sudah_datang"
                                                    {{ $status === 'sudah_datang' ? 'selected' : '' }}
                                                >
                                                    Sudah Datang
                                                </option>

                                            </select>

                                        </div>


                                        {{-- TANGGAL PEMANGGILAN --}}
                                        <div class="pemanggilan-field">

                                            <label>
                                                Tanggal Pemanggilan
                                            </label>

                                            <input
                                                type="date"
                                                name="tanggal_pemanggilan"
                                                class="pemanggilan-input tanggal-pemanggilan"
                                                value="{{ $tanggalPemanggilanValue }}"
                                            >

                                        </div>


                                        {{-- TANGGAL KEDATANGAN --}}
                                        <div class="pemanggilan-field">

                                            <label>
                                                Tanggal Kedatangan
                                            </label>

                                            <input
                                                type="date"
                                                name="tanggal_kedatangan"
                                                class="pemanggilan-input tanggal-kedatangan"
                                                value="{{ $tanggalKedatanganValue }}"
                                                {{ $status !== 'sudah_datang' ? 'disabled' : '' }}
                                            >

                                        </div>


                                        {{-- SIMPAN --}}
                                        <div class="pemanggilan-action">

                                            <button
                                                type="submit"
                                                class="btn-simpan-pemanggilan"
                                            >

                                                <span class="material-symbols-outlined">
                                                    save
                                                </span>

                                                Simpan

                                            </button>

                                        </div>

                                    </div>

                                </form>

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td
                                colspan="11"
                                style="text-align: center; padding: 30px;"
                            >
                                Belum ada peserta yang diterima
                                pada Case Conference.
                            </td>

                        </tr>

                    @endforelse


                    {{-- =====================================================
                    EMPTY FILTER
                    ====================================================== --}}
                    @if ($pesertas->count() > 0)

                        <tr
                            id="emptyFilterRow"
                            style="display: none;"
                        >

                            <td
                                colspan="11"
                                style="text-align: center; padding: 30px;"
                            >
                                Data tidak ditemukan.
                            </td>

                        </tr>

                    @endif

                </tbody>

            </table>

        </div>

    </div>


    {{-- =====================================================
    STYLE
    ====================================================== --}}
    <style>

        /* =====================================================
           PEMANGGILAN FORM
        ====================================================== */

        .pemanggilan-edit-row {
            display: grid;
            grid-template-columns: 180px 170px 170px auto;
            gap: 10px;
            align-items: end;
            width: 100%;
        }

        .pemanggilan-field {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .pemanggilan-field label {
            font-size: 11px;
            font-weight: 600;
            color: #64748b;
        }

        .pemanggilan-input {
            width: 100%;
            height: 38px;
            padding: 0 10px;
            border: 1px solid #dbe2ea;
            border-radius: 8px;
            background: #fff;
            font-size: 12px;
            color: #334155;
            outline: none;
            transition: all 0.2s ease;
            box-sizing: border-box;
        }

        .pemanggilan-input:focus {
            border-color: #205d91;
            box-shadow:
                0 0 0 3px rgba(32, 93, 145, 0.08);
        }

        .pemanggilan-input:disabled {
            background: #f1f5f9;
            color: #94a3b8;
            cursor: not-allowed;
        }

        .pemanggilan-action {
            display: flex;
            align-items: flex-end;
        }

        .btn-simpan-pemanggilan {
            height: 38px;
            padding: 0 14px;
            border: none;
            border-radius: 8px;
            background: #205d91;
            color: #fff;
            font-size: 12px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            cursor: pointer;
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .btn-simpan-pemanggilan:hover {
            background: #174b76;
            transform: translateY(-1px);
        }

        .btn-simpan-pemanggilan:active {
            transform: translateY(0);
        }


        /* =====================================================
           DATE FILTER
        ====================================================== */

        .date-filter-wrapper {
            position: relative;
        }

        .date-filter {
            height: 40px;
            padding: 0 12px;
            border: 1px solid #dbe2ea;
            border-radius: 8px;
            background: #fff;
            color: #334155;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .date-filter:hover {
            border-color: #205d91;
        }

        .date-picker {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            width: 320px;
            padding: 16px;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow:
                0 10px 30px rgba(15, 23, 42, 0.12);
            z-index: 100;
            display: none;
        }

        .date-picker.show {
            display: block;
        }

        .date-picker-header {
            margin-bottom: 15px;
            font-size: 13px;
            color: #334155;
        }

        .date-input-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .date-input-group > div {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .date-input-group label {
            font-size: 11px;
            font-weight: 600;
            color: #64748b;
        }

        .date-input-group input {
            width: 100%;
            height: 38px;
            padding: 0 8px;
            border: 1px solid #dbe2ea;
            border-radius: 8px;
            font-size: 12px;
            color: #334155;
            box-sizing: border-box;
        }

        .date-picker-actions {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
            margin-top: 15px;
        }

        .date-reset,
        .date-apply {
            height: 36px;
            padding: 0 13px;
            border-radius: 7px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
        }

        .date-reset {
            border: 1px solid #dbe2ea;
            background: #fff;
            color: #64748b;
        }

        .date-apply {
            border: none;
            background: #205d91;
            color: #fff;
        }


        /* =====================================================
           FILTER
        ====================================================== */

        .filter-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .search {
            position: relative;
            flex: 1;
        }

        .search svg {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            pointer-events: none;
        }

        .search input {
            width: 100%;
            height: 40px;
            padding: 0 12px 0 38px;
            border: 1px solid #dbe2ea;
            border-radius: 8px;
            outline: none;
            font-size: 13px;
            color: #334155;
            box-sizing: border-box;
        }

        .search input:focus {
            border-color: #205d91;
            box-shadow:
                0 0 0 3px rgba(32, 93, 145, 0.08);
        }

        .select-wrapper {
            position: relative;
        }

        .filter-button {
            appearance: none;
            height: 40px;
            min-width: 180px;
            padding: 0 38px 0 12px;
            border: 1px solid #dbe2ea;
            border-radius: 8px;
            background: #fff;
            color: #334155;
            font-size: 13px;
            outline: none;
            cursor: pointer;
        }

        .select-arrow {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            pointer-events: none;
            font-size: 19px;
        }


        /* =====================================================
           RESPONSIVE
        ====================================================== */

        @media (max-width: 1100px) {

            .pemanggilan-edit-row {
                grid-template-columns: 1fr 1fr;
            }

            .pemanggilan-action {
                align-items: stretch;
            }

            .btn-simpan-pemanggilan {
                width: 100%;
            }

        }


        @media (max-width: 768px) {

            .filter-wrapper {
                flex-direction: column;
                align-items: stretch;
            }

            .filter-button {
                width: 100%;
            }

            .date-picker {
                right: auto;
                left: 0;
                width: min(320px, calc(100vw - 30px));
            }

            .date-input-group {
                grid-template-columns: 1fr;
            }

            .pemanggilan-edit-row {
                grid-template-columns: 1fr;
            }

        }

    </style>


    {{-- =====================================================
    JAVASCRIPT
    ====================================================== --}}
    <script>

        document.addEventListener('DOMContentLoaded', function () {

            /*
            |--------------------------------------------------------------------------
            | ELEMENT
            |--------------------------------------------------------------------------
            */

            const searchInput =
                document.getElementById('searchInput');

            const statusFilter =
                document.getElementById('statusFilter');

            const dateFilterButton =
                document.getElementById('dateFilterButton');

            const dateFilterText =
                document.getElementById('dateFilterText');

            const datePicker =
                document.getElementById('datePicker');

            const startDate =
                document.getElementById('startDate');

            const endDate =
                document.getElementById('endDate');

            const resetDate =
                document.getElementById('resetDate');

            const applyDate =
                document.getElementById('applyDate');

            const emptyFilterRow =
                document.getElementById('emptyFilterRow');


            /*
            |--------------------------------------------------------------------------
            | DATA TANGGAL AKTIF
            |--------------------------------------------------------------------------
            */

            let activeStartDate = '';

            let activeEndDate = '';


            /*
            |--------------------------------------------------------------------------
            | DATE PICKER TOGGLE
            |--------------------------------------------------------------------------
            */

            if (dateFilterButton && datePicker) {

                dateFilterButton.addEventListener(
                    'click',
                    function (event) {

                        event.stopPropagation();

                        datePicker.classList.toggle('show');

                    }
                );

            }


            /*
            |--------------------------------------------------------------------------
            | CLOSE DATE PICKER
            |--------------------------------------------------------------------------
            */

            document.addEventListener(
                'click',
                function (event) {

                    if (
                        datePicker &&
                        dateFilterButton &&
                        !datePicker.contains(event.target) &&
                        !dateFilterButton.contains(event.target)
                    ) {

                        datePicker.classList.remove('show');

                    }

                }
            );


            /*
            |--------------------------------------------------------------------------
            | FILTER FUNCTION
            |--------------------------------------------------------------------------
            */

            function applyFilters() {

                const searchValue =
                    (searchInput?.value || '')
                    .toLowerCase()
                    .trim();

                const selectedStatus =
                    statusFilter?.value || '';

                const rows =
                    document.querySelectorAll(
                        'tbody tr[data-nama]'
                    );

                let visibleCount = 0;

                rows.forEach(function (row) {

                    const nama =
                        row.dataset.nama || '';

                    const nik =
                        row.dataset.nik || '';

                    const jenisPpks =
                        row.dataset.ppks || '';

                    const peminatan =
                        row.dataset.peminatan || '';

                    const keberangkatan =
                        row.dataset.keberangkatan || '';

                    const status =
                        row.dataset.status || '';

                    const tanggal =
                        row.dataset.tanggal || '';


                    /*
                    |--------------------------------------------------------------------------
                    | SEARCH
                    |--------------------------------------------------------------------------
                    */

                    const matchSearch =
                        !searchValue ||
                        nama.includes(searchValue) ||
                        nik.includes(searchValue) ||
                        jenisPpks.includes(searchValue) ||
                        peminatan.includes(searchValue) ||
                        keberangkatan.includes(searchValue);


                    /*
                    |--------------------------------------------------------------------------
                    | STATUS
                    |--------------------------------------------------------------------------
                    */

                    const matchStatus =
                        !selectedStatus ||
                        status === selectedStatus;


                    /*
                    |--------------------------------------------------------------------------
                    | DATE
                    |--------------------------------------------------------------------------
                    */

                    let matchDate = true;

                    if (activeStartDate) {

                        matchDate =
                            tanggal &&
                            tanggal >= activeStartDate;

                    }

                    if (
                        matchDate &&
                        activeEndDate
                    ) {

                        matchDate =
                            tanggal &&
                            tanggal <= activeEndDate;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | HASIL
                    |--------------------------------------------------------------------------
                    */

                    const show =
                        matchSearch &&
                        matchStatus &&
                        matchDate;

                    row.style.display =
                        show
                            ? ''
                            : 'none';

                    if (show) {
                        visibleCount++;
                    }

                });


                /*
                |--------------------------------------------------------------------------
                | EMPTY FILTER
                |--------------------------------------------------------------------------
                */

                if (emptyFilterRow) {

                    emptyFilterRow.style.display =
                        visibleCount === 0
                            ? ''
                            : 'none';

                }


                /*
                |--------------------------------------------------------------------------
                | NOMOR URUT
                |--------------------------------------------------------------------------
                */

                let nomor = 1;

                rows.forEach(function (row) {

                    if (
                        row.style.display !== 'none'
                    ) {

                        const numberCell =
                            row.querySelector('.row-number');

                        if (numberCell) {

                            numberCell.textContent =
                                nomor++;

                        }

                    }

                });

            }


            /*
            |--------------------------------------------------------------------------
            | SEARCH EVENT
            |--------------------------------------------------------------------------
            */

            if (searchInput) {

                searchInput.addEventListener(
                    'input',
                    applyFilters
                );

            }


            /*
            |--------------------------------------------------------------------------
            | STATUS EVENT
            |--------------------------------------------------------------------------
            */

            if (statusFilter) {

                statusFilter.addEventListener(
                    'change',
                    applyFilters
                );

            }


            /*
            |--------------------------------------------------------------------------
            | APPLY DATE
            |--------------------------------------------------------------------------
            */

            if (applyDate) {

                applyDate.addEventListener(
                    'click',
                    function () {

                        const start =
                            startDate?.value || '';

                        const end =
                            endDate?.value || '';


                        if (
                            start &&
                            end &&
                            start > end
                        ) {

                            alert(
                                'Tanggal "Dari" tidak boleh lebih besar dari tanggal "Sampai".'
                            );

                            return;

                        }


                        activeStartDate = start;

                        activeEndDate = end;


                        /*
                        |--------------------------------------------------------------------------
                        | TEXT BUTTON
                        |--------------------------------------------------------------------------
                        */

                        if (
                            dateFilterText
                        ) {

                            if (
                                start &&
                                end
                            ) {

                                dateFilterText.textContent =
                                    `${formatDate(start)} - ${formatDate(end)}`;

                            } else if (start) {

                                dateFilterText.textContent =
                                    `Dari ${formatDate(start)}`;

                            } else if (end) {

                                dateFilterText.textContent =
                                    `Sampai ${formatDate(end)}`;

                            } else {

                                dateFilterText.textContent =
                                    'Pilih Tanggal';

                            }

                        }


                        datePicker?.classList.remove('show');

                        applyFilters();

                    }
                );

            }


            /*
            |--------------------------------------------------------------------------
            | RESET DATE
            |--------------------------------------------------------------------------
            */

            if (resetDate) {

                resetDate.addEventListener(
                    'click',
                    function () {

                        if (startDate) {
                            startDate.value = '';
                        }

                        if (endDate) {
                            endDate.value = '';
                        }

                        activeStartDate = '';

                        activeEndDate = '';


                        if (dateFilterText) {

                            dateFilterText.textContent =
                                'Pilih Tanggal';

                        }


                        datePicker?.classList.remove('show');

                        applyFilters();

                    }
                );

            }


            /*
            |--------------------------------------------------------------------------
            | FORMAT DATE
            |--------------------------------------------------------------------------
            */

            function formatDate(dateString) {

                if (!dateString) {
                    return '';
                }

                const parts =
                    dateString.split('-');

                if (parts.length !== 3) {
                    return dateString;
                }

                return `${parts[2]}-${parts[1]}-${parts[0]}`;

            }


            /*
            |--------------------------------------------------------------------------
            | STATUS → TANGGAL KEDATANGAN
            |--------------------------------------------------------------------------
            */

            document
                .querySelectorAll('.status-edit')
                .forEach(function (statusSelect) {

                    const form =
                        statusSelect.closest(
                            '.pemanggilan-form'
                        );

                    if (!form) {
                        return;
                    }

                    const tanggalKedatangan =
                        form.querySelector(
                            '.tanggal-kedatangan'
                        );


                    function updateTanggalKedatangan() {

                        if (!tanggalKedatangan) {
                            return;
                        }

                        if (
                            statusSelect.value ===
                            'sudah_datang'
                        ) {

                            tanggalKedatangan.disabled =
                                false;

                        } else {

                            tanggalKedatangan.disabled =
                                true;

                            /*
                            | Kosongkan tanggal kedatangan
                            | ketika status bukan sudah datang.
                            */

                            tanggalKedatangan.value =
                                '';

                        }

                    }


                    statusSelect.addEventListener(
                        'change',
                        updateTanggalKedatangan
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | INITIAL STATE
                    |--------------------------------------------------------------------------
                    */

                    updateTanggalKedatangan();

                });


            /*
            |--------------------------------------------------------------------------
            | VALIDASI FORM
            |--------------------------------------------------------------------------
            */

            document
                .querySelectorAll('.pemanggilan-form')
                .forEach(function (form) {

                    form.addEventListener(
                        'submit',
                        function (event) {

                            const status =
                                form.querySelector(
                                    '.status-edit'
                                )?.value;

                            const tanggalPemanggilan =
                                form.querySelector(
                                    '.tanggal-pemanggilan'
                                )?.value;

                            const tanggalKedatangan =
                                form.querySelector(
                                    '.tanggal-kedatangan'
                                )?.value;


                            /*
                            |--------------------------------------------------------------------------
                            | STATUS SUDAH DIPANGGIL
                            |--------------------------------------------------------------------------
                            */

                            if (
                                status ===
                                'sudah_dipanggil' &&
                                !tanggalPemanggilan
                            ) {

                                event.preventDefault();

                                alert(
                                    'Tanggal pemanggilan wajib diisi.'
                                );

                                return;

                            }


                            /*
                            |--------------------------------------------------------------------------
                            | STATUS SUDAH DATANG
                            |--------------------------------------------------------------------------
                            */

                            if (
                                status ===
                                'sudah_datang'
                            ) {

                                if (!tanggalPemanggilan) {

                                    event.preventDefault();

                                    alert(
                                        'Tanggal pemanggilan wajib diisi.'
                                    );

                                    return;

                                }

                                if (!tanggalKedatangan) {

                                    event.preventDefault();

                                    alert(
                                        'Tanggal kedatangan wajib diisi.'
                                    );

                                    return;

                                }


                                /*
                                | Tanggal kedatangan tidak boleh
                                | sebelum tanggal pemanggilan.
                                */

                                if (
                                    tanggalKedatangan <
                                    tanggalPemanggilan
                                ) {

                                    event.preventDefault();

                                    alert(
                                        'Tanggal kedatangan tidak boleh lebih awal dari tanggal pemanggilan.'
                                    );

                                    return;

                                }

                            }

                        }
                    );

                });


            /*
            |--------------------------------------------------------------------------
            | INITIAL FILTER
            |--------------------------------------------------------------------------
            */

            applyFilters();

        });

    </script>

</x-app-layout>
