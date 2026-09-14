<x-app-layout>


<div class="main-page">

    {{-- =====================================================
        HEADER
    ====================================================== --}}

    <div class="main-page-header">

        <div>
            <h1>Data Lulus Instruktur</h1>

            <p>
                Data PPKS yang telah lulus Asesmen Instruktur
                dan dapat melanjutkan ke Asesmen Kesehatan Awal.
            </p>
        </div>


        {{-- DATE FILTER --}}

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
                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <path d="M16 2v4"/>
                    <path d="M8 2v4"/>
                    <path d="M3 10h18"/>
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
                    <path d="m6 9 6 6 6-6"/>
                </svg>

            </button>


            <div
                class="date-picker"
                id="datePicker"
            >

                <div class="date-picker-header">
                    <strong>Pilih Rentang Tanggal</strong>
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
        NAVIGASI HASIL
    ====================================================== --}}

    <div class="result-navigation">

        <a href="{{ route('ppks.normal.instruktur') }}">
            Semua
        </a>

        <a
            href="{{ route('ppks.normal.asesmen-instruktur.lulus') }}"
            class="active"
        >
            Lulus
        </a>

        <a href="{{ route('ppks.normal.asesmen-instruktur.pending') }}">
            Pending
        </a>

        <a href="{{ route('ppks.normal.asesmen-instruktur.tidak-lulus') }}">
            Tidak Lulus
        </a>

    </div>


    {{-- =====================================================
        FILTER
    ====================================================== --}}

    <div class="filter-wrapper">

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
                <circle cx="11" cy="11" r="7"/>
                <path d="m20 20-3.5-3.5"/>
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
                class="filter-button"
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

                        $data = is_array($item->data)
                            ? $item->data
                            : (
                                json_decode(
                                    $item->data ?? '{}',
                                    true
                                ) ?? []
                            );


                        /*
                        |--------------------------------------------------------------------------
                        | NAMA
                        |--------------------------------------------------------------------------
                        */

                        $nama =
                            $data['nama_lengkap']
                            ?? $data['nama']
                            ?? '-';


                        /*
                        |--------------------------------------------------------------------------
                        | NIK
                        |--------------------------------------------------------------------------
                        */

                        $nik =
                            $data['nik']
                            ?? $item->nik
                            ?? '-';


                        /*
                        |--------------------------------------------------------------------------
                        | UMUR
                        |--------------------------------------------------------------------------
                        */

                        $umur =
                            $data['umur']
                            ?? '-';


                        /*
                        |--------------------------------------------------------------------------
                        | JENIS PPKS
                        |--------------------------------------------------------------------------
                        */

                        $jenisPpks =
                            $data['jenis_ppks']
                            ?? '-';


                        /*
                        |--------------------------------------------------------------------------
                        | JURUSAN YANG DIMINATI
                        |--------------------------------------------------------------------------
                        */

                        $jurusan =
                            $data['jurusan_yang_diminati']
                            ?? $data['jurusan']
                            ?? $data['jurusan_pelatihan']
                            ?? '-';


                        /*
                        |--------------------------------------------------------------------------
                        | PROSES INSTRUKTUR
                        |--------------------------------------------------------------------------
                        */

                        $prosesInstruktur =
                            $item->prosesPesertas
                                ->where('tahap', 'instruktur')
                                ->first();


                        /*
                        |--------------------------------------------------------------------------
                        | TANGGAL PROSES
                        |--------------------------------------------------------------------------
                        */

                        $tanggal =
                            $prosesInstruktur?->tanggal_proses;


                        /*
                        |--------------------------------------------------------------------------
                        | KETERANGAN
                        |
                        | Diambil dari catatan yang ditulis saat
                        | Asesmen Instruktur.
                        |--------------------------------------------------------------------------
                        */

                        $keterangan =
                            $data['catatan_asesmen_instruktur']
                            ?? $prosesInstruktur?->catatan
                            ?? '-';

                    @endphp


                    <tr
                        data-nama="{{ strtolower($nama) }}"
                        data-nik="{{ strtolower($nik) }}"
                        data-ppks="{{ strtolower($jenisPpks) }}"
                        data-tanggal="{{
                            $tanggal
                                ? \Carbon\Carbon::parse($tanggal)->format('Y-m-d')
                                : ''
                        }}"
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

                            <span class="result-badge result-instructor">

                                <span class="material-symbols-outlined result-icon">
                                    assignment
                                </span>

                                <div class="result-content">

                                    <span class="result-title">
                                        Asesmen Instruktur
                                    </span>

                                    <span class="result-status lolos">

                                        <span class="status-dot"></span>

                                        Lulus

                                    </span>

                                </div>

                            </span>

                        </td>


                        {{-- KETERANGAN --}}

                        <td>

                            <span class="keterangan-text">
                                {{ $keterangan }}
                            </span>

                        </td>


                        {{-- AKSI --}}

                        <td>

                            <a
                                href="{{ route(
                                    'ppks.normal.asesmen-instruktur.data-detail',
                                    $item->id
                                ) }}"
                                class="result-badge result-instructor"
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


                            <a
                                href="{{ route(
                                    'ppks.normal.asesmen-kesehatan.awal',
                                    $item->id
                                ) }}"
                                class="result-badge result-health"
                            >

                                <span class="material-symbols-outlined result-icon">
                                    medical_services
                                </span>

                                <span>
                                    Kesehatan Awal
                                </span>

                                <span class="result-arrow">
                                    ›
                                </span>

                            </a>

                        </td>

                    </tr>


                @empty

                    <tr>

                        <td colspan="9">

                            Belum ada data PPKS yang lulus
                            Asesmen Instruktur.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    {{-- =====================================================
        PAGINATION
    ====================================================== --}}

    <div class="pagination-wrapper">

        {{ $ppks->links() }}

    </div>

</div>


{{-- =========================================================
    JAVASCRIPT FILTER
========================================================= --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    const searchInput =
        document.getElementById('searchInput');

    const ppksFilter =
        document.getElementById('ppksFilter');

    const tableRows =
        document.querySelectorAll(
            '.table tbody tr[data-nama]'
        );

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


    /* =====================================================
       FILTER TABLE
    ===================================================== */

    function filterTable() {

        const search =
            searchInput.value
                .toLowerCase()
                .trim();

        const ppks =
            ppksFilter.value
                .toLowerCase()
                .trim();

        const start =
            startDate.value;

        const end =
            endDate.value;

        let number = 1;


        tableRows.forEach(function (row) {

            const nama =
                row.dataset.nama || '';

            const nik =
                row.dataset.nik || '';

            const jenis =
                row.dataset.ppks || '';

            const tanggal =
                row.dataset.tanggal || '';


            const matchSearch =
                nama.includes(search) ||
                nik.includes(search);


            const matchPpks =
                ppks === '' ||
                jenis === ppks;


            let matchDate = true;


            if (start) {

                if (!tanggal) {

                    matchDate = false;

                } else {

                    matchDate =
                        tanggal >= start;

                }

            }


            if (end && matchDate) {

                if (!tanggal) {

                    matchDate = false;

                } else {

                    matchDate =
                        tanggal <= end;

                }

            }


            const show =
                matchSearch &&
                matchPpks &&
                matchDate;


            row.style.display =
                show ? '' : 'none';


            if (show) {

                const numberCell =
                    row.querySelector('.row-number');

                if (numberCell) {

                    numberCell.textContent =
                        number++;

                }

            }

        });

    }


    /* =====================================================
       SEARCH
    ===================================================== */

    searchInput.addEventListener(
        'input',
        filterTable
    );


    /* =====================================================
       PPKS FILTER
    ===================================================== */

    ppksFilter.addEventListener(
        'change',
        filterTable
    );


    /* =====================================================
       DATE PICKER
    ===================================================== */

    dateFilterButton.addEventListener(
        'click',
        function (event) {

            event.stopPropagation();

            datePicker.classList.toggle('active');

        }
    );


    datePicker.addEventListener(
        'click',
        function (event) {

            event.stopPropagation();

        }
    );


    /* =====================================================
       APPLY DATE
    ===================================================== */

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
                + ' - '
                + formatDate(end);


            datePicker.classList.remove('active');

            filterTable();

        }
    );


    /* =====================================================
       RESET DATE
    ===================================================== */

    resetDate.addEventListener(
        'click',
        function () {

            startDate.value = '';

            endDate.value = '';

            dateFilterText.textContent =
                'Pilih Tanggal';

            datePicker.classList.remove('active');

            filterTable();

        }
    );


    /* =====================================================
       FORMAT DATE
    ===================================================== */

    function formatDate(value) {

        const date =
            new Date(value + 'T00:00:00');


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
       CLOSE DATE PICKER
    ===================================================== */

    document.addEventListener(
        'click',
        function () {

            datePicker.classList.remove('active');

        }
    );


    /* =====================================================
       INITIAL FILTER
    ===================================================== */

    filterTable();

});

</script>

</x-app-layout>
