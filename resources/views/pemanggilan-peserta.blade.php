<x-app-layout>

    <div class="main-page">

        {{-- =====================================================
        HEADER
        ====================================================== --}}
        <div class="main-page-header">

            <div>
                <h1>Data Pemanggilan Peserta</h1>

                <p>
                    Data PPKS yang telah diterima pada Case Conference
                </p>
            </div>

            {{-- =================================================
            DATE FILTER
            ================================================== --}}
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
                                $data = json_decode(
                                    $data,
                                    true
                                ) ?? [];
                            }


                            /*
                            |--------------------------------------------------------------------------
                            | DATA PEMANGGILAN
                            |--------------------------------------------------------------------------
                            */

                            $pemanggilan =
                                $ppks->pemanggilanPeserta;


                            /*
                            |--------------------------------------------------------------------------
                            | DATA CASE CONFERENCE
                            |--------------------------------------------------------------------------
                            */

                            $caseConference =
                                $caseConferences->get(
                                    $ppks->id
                                );


                            /*
                            |--------------------------------------------------------------------------
                            | IDENTITAS
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


                            /*
                            |--------------------------------------------------------------------------
                            | LABEL STATUS
                            |--------------------------------------------------------------------------
                            */

                            $statusLabel = match ($status) {

                                'sudah_dipanggil' =>
                                    'Sudah Dipanggil',

                                'belum_datang' =>
                                    'Belum Datang',

                                'sudah_datang' =>
                                    'Sudah Datang',

                                default =>
                                    'Belum Dipanggil',

                            };


                            /*
                            |--------------------------------------------------------------------------
                            | CLASS STATUS
                            |--------------------------------------------------------------------------
                            */

                            $statusClass =
                                str_replace(
                                    '_',
                                    '-',
                                    $status
                                );

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

                            {{-- NO --}}
                            <td class="row-number">
                                {{ $index + 1 }}
                            </td>


                            {{-- NAMA --}}
                            <td>
                                {{ $nama }}
                            </td>


                            {{-- NIK --}}
                            <td>
                                {{ $nik }}
                            </td>


                            {{-- JENIS PPKS --}}
                            <td>
                                {{ $jenisPpks }}
                            </td>


                            {{-- PEMINATAN --}}
                            <td>
                                {{ $peminatan }}
                            </td>


                            {{-- KEBERANGKATAN --}}
                            <td>
                                {{ $keberangkatan }}
                            </td>


                            {{-- NO HP --}}
                            <td>
                                {{ $noHp }}
                            </td>


                            {{-- STATUS --}}
                            <td>

                                <span
                                    class="pemanggilan-status-badge {{ $statusClass }}"
                                >

                                    <span
                                        class="pemanggilan-status-dot"
                                    ></span>

                                    {{ $statusLabel }}

                                </span>

                            </td>


                            {{-- TANGGAL PEMANGGILAN --}}
                            <td>
                                {{ $tanggalPemanggilanTampil }}
                            </td>


                            {{-- TANGGAL KEDATANGAN --}}
                            <td>
                                {{ $tanggalKedatanganTampil }}
                            </td>


                            {{-- AKSI --}}
                            <td>

                                <button
                                    type="button"
                                    class="btn-ubah-pemanggilan"
                                    data-action="{{ route(
                                        'ppks.normal.pemanggilan.proses',
                                        $ppks
                                    ) }}"
                                    data-id="{{ $ppks->id }}"
                                    data-nama="{{ $nama }}"
                                    data-nik="{{ $nik }}"
                                    data-status="{{ $status }}"
                                    data-tanggal-pemanggilan="{{ $tanggalPemanggilanValue }}"
                                    data-tanggal-kedatangan="{{ $tanggalKedatanganValue }}"
                                >

                                    <span class="material-symbols-outlined">
                                        edit
                                    </span>

                                    Ubah

                                </button>

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


                    {{-- EMPTY FILTER --}}
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
    GLOBAL POPUP PEMANGGILAN
    ====================================================== --}}
    <div
        class="global-popup info"
        id="pemanggilanPopup"
    >

        <div
            class="global-popup-box pemanggilan-popup-box"
            style="position: relative;"
        >

            <button
                type="button"
                class="global-popup-close"
                onclick="closePemanggilanPopup()"
            >

                <span class="material-symbols-outlined">
                    close
                </span>

            </button>


            <div class="global-popup-icon">

                <span class="material-symbols-outlined">
                    campaign
                </span>

            </div>


            <h3 class="global-popup-title">
                Pemanggilan Peserta
            </h3>


            <p class="global-popup-message">
                Perbarui status dan tanggal pemanggilan peserta.
            </p>


            {{-- IDENTITAS --}}
            <div class="pemanggilan-popup-identity">

                <p
                    class="pemanggilan-popup-name"
                    id="popupNama"
                >
                    -
                </p>

                <p
                    class="pemanggilan-popup-nik"
                    id="popupNik"
                >
                    NIK: -
                </p>

            </div>


            {{-- FORM --}}
            <form
                method="POST"
                id="pemanggilanPopupForm"
                class="pemanggilan-popup-form"
            >

                @csrf


                {{-- STATUS --}}
                <div class="pemanggilan-popup-field">

                    <label for="popupStatus">
                        Status Pemanggilan
                    </label>

                    <select
                        name="status_pemanggilan"
                        id="popupStatus"
                        required
                    >

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

                </div>


                {{-- TANGGAL PEMANGGILAN --}}
                <div class="pemanggilan-popup-field">

                    <label for="popupTanggalPemanggilan">
                        Tanggal Pemanggilan
                    </label>

                    <input
                        type="date"
                        name="tanggal_pemanggilan"
                        id="popupTanggalPemanggilan"
                    >

                </div>


                {{-- TANGGAL KEDATANGAN --}}
                <div class="pemanggilan-popup-field">

                    <label for="popupTanggalKedatangan">
                        Tanggal Kedatangan
                    </label>

                    <input
                        type="date"
                        name="tanggal_kedatangan"
                        id="popupTanggalKedatangan"
                    >

                </div>


                {{-- ACTION --}}
                <div class="pemanggilan-popup-actions">

                    <button
                        type="button"
                        class="global-popup-btn cancel"
                        onclick="closePemanggilanPopup()"
                    >
                        Batal
                    </button>

                    <button
                        type="submit"
                        class="global-popup-btn primary"
                    >

                        <span class="material-symbols-outlined">
                            save
                        </span>

                        Simpan

                    </button>

                </div>

            </form>

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

                const statusFilter =
                    document.getElementById(
                        'statusFilter'
                    );

                const dateFilterButton =
                    document.getElementById(
                        'dateFilterButton'
                    );

                const dateFilterText =
                    document.getElementById(
                        'dateFilterText'
                    );

                const datePicker =
                    document.getElementById(
                        'datePicker'
                    );

                const startDate =
                    document.getElementById(
                        'startDate'
                    );

                const endDate =
                    document.getElementById(
                        'endDate'
                    );

                const resetDate =
                    document.getElementById(
                        'resetDate'
                    );

                const applyDate =
                    document.getElementById(
                        'applyDate'
                    );

                const emptyFilterRow =
                    document.getElementById(
                        'emptyFilterRow'
                    );


                /*
                |--------------------------------------------------------------------------
                | POPUP ELEMENT
                |--------------------------------------------------------------------------
                */

                const pemanggilanPopup =
                    document.getElementById(
                        'pemanggilanPopup'
                    );

                const pemanggilanPopupForm =
                    document.getElementById(
                        'pemanggilanPopupForm'
                    );

                const popupNama =
                    document.getElementById(
                        'popupNama'
                    );

                const popupNik =
                    document.getElementById(
                        'popupNik'
                    );

                const popupStatus =
                    document.getElementById(
                        'popupStatus'
                    );

                const popupTanggalPemanggilan =
                    document.getElementById(
                        'popupTanggalPemanggilan'
                    );

                const popupTanggalKedatangan =
                    document.getElementById(
                        'popupTanggalKedatangan'
                    );


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

                if (
                    dateFilterButton &&
                    datePicker
                ) {

                    dateFilterButton.addEventListener(
                        'click',
                        function (event) {

                            event.stopPropagation();

                            datePicker.classList.toggle(
                                'show'
                            );

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
                            !datePicker.contains(
                                event.target
                            ) &&
                            !dateFilterButton.contains(
                                event.target
                            )
                        ) {

                            datePicker.classList.remove(
                                'show'
                            );

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
                        (
                            searchInput?.value ||
                            ''
                        )
                            .toLowerCase()
                            .trim();

                    const selectedStatus =
                        statusFilter?.value ||
                        '';

                    const rows =
                        document.querySelectorAll(
                            'tbody tr[data-nama]'
                        );

                    let visibleCount = 0;


                    rows.forEach(
                        function (row) {

                            const nama =
                                row.dataset.nama ||
                                '';

                            const nik =
                                row.dataset.nik ||
                                '';

                            const jenisPpks =
                                row.dataset.ppks ||
                                '';

                            const peminatan =
                                row.dataset.peminatan ||
                                '';

                            const keberangkatan =
                                row.dataset.keberangkatan ||
                                '';

                            const status =
                                row.dataset.status ||
                                '';

                            const tanggal =
                                row.dataset.tanggal ||
                                '';


                            /*
                            |--------------------------------------------------------------------------
                            | SEARCH
                            |--------------------------------------------------------------------------
                            */

                            const matchSearch =
                                !searchValue ||
                                nama.includes(
                                    searchValue
                                ) ||
                                nik.includes(
                                    searchValue
                                ) ||
                                jenisPpks.includes(
                                    searchValue
                                ) ||
                                peminatan.includes(
                                    searchValue
                                ) ||
                                keberangkatan.includes(
                                    searchValue
                                );


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
                                    tanggal >=
                                        activeStartDate;

                            }

                            if (
                                matchDate &&
                                activeEndDate
                            ) {

                                matchDate =
                                    tanggal &&
                                    tanggal <=
                                        activeEndDate;

                            }


                            /*
                            |--------------------------------------------------------------------------
                            | SHOW
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

                        }
                    );


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

                    rows.forEach(
                        function (row) {

                            if (
                                row.style.display !==
                                'none'
                            ) {

                                const numberCell =
                                    row.querySelector(
                                        '.row-number'
                                    );

                                if (numberCell) {

                                    numberCell.textContent =
                                        nomor++;

                                }

                            }

                        }
                    );

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
                                startDate?.value ||
                                '';

                            const end =
                                endDate?.value ||
                                '';


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


                            activeStartDate =
                                start;

                            activeEndDate =
                                end;


                            if (dateFilterText) {

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


                            datePicker?.classList.remove(
                                'show'
                            );

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


                            datePicker?.classList.remove(
                                'show'
                            );

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

                    if (
                        parts.length !== 3
                    ) {
                        return dateString;
                    }

                    return `${parts[2]}-${parts[1]}-${parts[0]}`;

                }


                /*
                |--------------------------------------------------------------------------
                | OPEN POPUP
                |--------------------------------------------------------------------------
                */

                document
                    .querySelectorAll(
                        '.btn-ubah-pemanggilan'
                    )
                    .forEach(
                        function (button) {

                            button.addEventListener(
                                'click',
                                function () {

                                    if (
                                        !pemanggilanPopup ||
                                        !pemanggilanPopupForm
                                    ) {
                                        return;
                                    }


                                    /*
                                    | FORM ACTION
                                    */

                                    pemanggilanPopupForm.action =
                                        button.dataset.action;


                                    /*
                                    | IDENTITAS
                                    */

                                    popupNama.textContent =
                                        button.dataset.nama ||
                                        '-';

                                    popupNik.textContent =
                                        `NIK: ${
                                            button.dataset.nik ||
                                            '-'
                                        }`;


                                    /*
                                    | DATA FORM
                                    */

                                    popupStatus.value =
                                        button.dataset.status ||
                                        'belum_dipanggil';

                                    popupTanggalPemanggilan.value =
                                        button.dataset.tanggalPemanggilan ||
                                        '';

                                    popupTanggalKedatangan.value =
                                        button.dataset.tanggalKedatangan ||
                                        '';


                                    updatePopupTanggalKedatangan();


                                    /*
                                    | SHOW
                                    */

                                    pemanggilanPopup.classList.add(
                                        'show'
                                    );

                                    document.body.style.overflow =
                                        'hidden';

                                }
                            );

                        }
                    );


                /*
                |--------------------------------------------------------------------------
                | CLOSE POPUP
                |--------------------------------------------------------------------------
                */

                window.closePemanggilanPopup =
                    function () {

                        if (!pemanggilanPopup) {
                            return;
                        }

                        pemanggilanPopup.classList.remove(
                            'show'
                        );

                        document.body.style.overflow =
                            '';

                    };


                /*
                |--------------------------------------------------------------------------
                | UPDATE TANGGAL KEDATANGAN
                |--------------------------------------------------------------------------
                */

                function updatePopupTanggalKedatangan() {

                    if (
                        !popupStatus ||
                        !popupTanggalKedatangan
                    ) {
                        return;
                    }


                    if (
                        popupStatus.value ===
                        'sudah_datang'
                    ) {

                        popupTanggalKedatangan.disabled =
                            false;

                    } else {

                        popupTanggalKedatangan.disabled =
                            true;

                        popupTanggalKedatangan.value =
                            '';

                    }

                }


                if (popupStatus) {

                    popupStatus.addEventListener(
                        'change',
                        updatePopupTanggalKedatangan
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | CLOSE KETIKA KLIK OVERLAY
                |--------------------------------------------------------------------------
                */

                if (pemanggilanPopup) {

                    pemanggilanPopup.addEventListener(
                        'click',
                        function (event) {

                            if (
                                event.target ===
                                pemanggilanPopup
                            ) {

                                closePemanggilanPopup();

                            }

                        }
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | ESC UNTUK CLOSE
                |--------------------------------------------------------------------------
                */

                document.addEventListener(
                    'keydown',
                    function (event) {

                        if (
                            event.key === 'Escape' &&
                            pemanggilanPopup?.classList.contains(
                                'show'
                            )
                        ) {

                            closePemanggilanPopup();

                        }

                    }
                );


                /*
                |--------------------------------------------------------------------------
                | VALIDASI FORM POPUP
                |--------------------------------------------------------------------------
                */

                if (pemanggilanPopupForm) {

                    pemanggilanPopupForm.addEventListener(
                        'submit',
                        function (event) {

                            const status =
                                popupStatus?.value ||
                                '';

                            const tanggalPemanggilan =
                                popupTanggalPemanggilan?.value ||
                                '';

                            const tanggalKedatangan =
                                popupTanggalKedatangan?.value ||
                                '';


                            /*
                            |--------------------------------------------------------------------------
                            | SUDAH DIPANGGIL
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
                            | SUDAH DATANG
                            |--------------------------------------------------------------------------
                            */

                            if (
                                status ===
                                'sudah_datang'
                            ) {

                                if (
                                    !tanggalPemanggilan
                                ) {

                                    event.preventDefault();

                                    alert(
                                        'Tanggal pemanggilan wajib diisi.'
                                    );

                                    return;

                                }


                                if (
                                    !tanggalKedatangan
                                ) {

                                    event.preventDefault();

                                    alert(
                                        'Tanggal kedatangan wajib diisi.'
                                    );

                                    return;

                                }


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

                }


                /*
                |--------------------------------------------------------------------------
                | INITIAL
                |--------------------------------------------------------------------------
                */

                applyFilters();

            }
        );

    </script>

</x-app-layout>