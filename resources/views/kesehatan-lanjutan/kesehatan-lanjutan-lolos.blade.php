<x-app-layout>

    <div class="main-page">

        {{-- =====================================================
        HEADER
        ====================================================== --}}
        <div class="main-page-header">

            <div>
                <h1>Data Kesehatan Lanjutan</h1>

                <p>
                    Data peserta yang telah lulus asesmen kesehatan lanjutan dan menjadi peserta aktif.
                </p>
            </div>

        </div>



        {{-- =====================================================
        FILTER
        ====================================================== --}}
        <div class="filter-wrapper">

            {{-- SEARCH --}}
            <form
                method="GET"
                action="{{ url()->current() }}"
                class="search"
                id="searchForm"
            >

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
                    name="search"
                    id="searchInput"
                    value="{{ request('search') }}"
                    placeholder="Cari Nama atau NIK"
                    autocomplete="off"
                >

            </form>



            {{-- =================================================
            JENIS PPKS
            ================================================== --}}
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

                    </tr>

                </thead>



                <tbody>

                    @forelse ($ppks as $index => $peserta)

                        @php

                            /*
                            |--------------------------------------------------------------------------
                            | DATA PPKS
                            |--------------------------------------------------------------------------
                            */

                            $data =
                                is_array($peserta->data)
                                ? $peserta->data
                                : [];



                            /*
                            |--------------------------------------------------------------------------
                            | IDENTITAS
                            |--------------------------------------------------------------------------
                            */

                            $nama =
                                $data['nama_lengkap']
                                ?? $data['nama']
                                ?? $data['Nama Lengkap']
                                ?? '-';


                            $nik =
                                $data['nik']
                                ?? $data['NIK']
                                ?? '-';


                            $umur =
                                $data['usia']
                                ?? $data['umur']
                                ?? '-';


                            $jenisPpks =
                                $data['jenis_ppks']
                                ?? $data['jenis PPKS']
                                ?? $data['Jenis PPKS']
                                ?? '-';



                            /*
                            |--------------------------------------------------------------------------
                            | CASE CONFERENCE
                            |--------------------------------------------------------------------------
                            */

                            $caseConference =
                                $caseConferences[$peserta->id]
                                ?? null;


                            $jurusan =
                                $caseConference?->jurusan_diterima
                                ?? '-';



                            /*
                            |--------------------------------------------------------------------------
                            | KESEHATAN LANJUTAN
                            |--------------------------------------------------------------------------
                            */

                            $kesehatanLanjutan =
                                $peserta->kesehatanLanjutan
                                ?? null;



                            /*
                            |--------------------------------------------------------------------------
                            | TAHAPAN
                            |--------------------------------------------------------------------------
                            */

                            $tahapan =
                                'Asesmen Kesehatan Lanjutan';



                            /*
                            |--------------------------------------------------------------------------
                            | HASIL
                            |--------------------------------------------------------------------------
                            */

                            $hasil =
                                'Lulus';



                            /*
                            |--------------------------------------------------------------------------
                            | KETERANGAN
                            |--------------------------------------------------------------------------
                            */

                            $keterangan =
                                $kesehatanLanjutan?->catatan_asesmen
                                ?? '-';



                            /*
                            |--------------------------------------------------------------------------
                            | DETAIL ROUTE
                            |--------------------------------------------------------------------------
                            */

                            $detailRoute =
                                route(
                                    'ppks.normal.kesehatan-lanjutan.detail',
                                    $peserta
                                );

                        @endphp



                        <tr
                            data-nama="{{ strtolower($nama) }}"
                            data-nik="{{ strtolower($nik) }}"
                            data-ppks="{{ strtolower($jenisPpks) }}"
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
                            UMUR
                            ================================================== --}}
                            <td>

                                {{ $umur }}

                            </td>



                            {{-- =================================================
                            JENIS PPKS
                            ================================================== --}}
                            <td>

                                {{ $jenisPpks }}

                            </td>



                            {{-- =================================================
                            JURUSAN
                            ================================================== --}}
                            <td>

                                {{ $jurusan }}

                            </td>



                            {{-- =================================================
                            HASIL
                            ================================================== --}}
                            <td>

                                <a
                                    href="{{ $detailRoute }}"
                                    class="result-badge result-health-advanced"
                                >

                                    {{-- ICON TAHAPAN --}}
                                    <span class="material-symbols-outlined result-icon">
                                        medical_services
                                    </span>



                                    <div class="result-content">

                                        {{-- NAMA TAHAPAN --}}
                                        <span class="result-title">
                                            Asesmen Kesehatan Lanjutan
                                        </span>



                                        {{-- STATUS --}}
                                        <span class="result-status lulus">

                                            <span class="status-dot lulus"></span>

                                            Lulus

                                        </span>

                                    </div>



                                    {{-- ARROW --}}
                                    <span class="result-arrow">
                                        ›
                                    </span>

                                </a>

                            </td>



                            {{-- =================================================
                            KETERANGAN
                            ================================================== --}}
                            <td>

                                <span class="keterangan-lolos">

                                    {{ $keterangan }}

                                </span>

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td
                                colspan="8"
                                style="text-align:center; padding:40px;"
                            >

                                <div class="empty-state">

                                    <span class="material-symbols-outlined">
                                        assignment_late
                                    </span>

                                    <p>
                                        Belum ada data PPKS yang lulus Asesmen Kesehatan Lanjutan
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse



                    {{-- =================================================
                    EMPTY FILTER
                    ================================================== --}}
                    <tr
                        id="emptyRow"
                        style="display: none;"
                    >

                        <td
                            colspan="8"
                            class="empty-state"
                        >

                            Data tidak ditemukan.

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>



    {{-- =========================================================
    JAVASCRIPT
    ========================================================== --}}
    <script>

        document.addEventListener('DOMContentLoaded', function () {


            /*
            |--------------------------------------------------------------------------
            | ELEMENT
            |--------------------------------------------------------------------------
            */

            const searchInput =
                document.getElementById('searchInput');


            const ppksFilter =
                document.getElementById('ppksFilter');


            const tableRows =
                document.querySelectorAll(
                    '.table tbody tr:not(#emptyRow)'
                );


            const emptyRow =
                document.getElementById('emptyRow');



            /*
            |--------------------------------------------------------------------------
            | FILTER TABLE
            |--------------------------------------------------------------------------
            */

            function filterTable() {

                const search =
                    searchInput.value
                        .toLowerCase()
                        .trim();


                const ppks =
                    ppksFilter.value
                        .toLowerCase()
                        .trim();


                let visibleCount = 0;



                tableRows.forEach(function (row) {


                    /*
                    |--------------------------------------------------------------------------
                    | DATA ROW
                    |--------------------------------------------------------------------------
                    */

                    const nama =
                        row.dataset.nama
                        || '';


                    const nik =
                        row.dataset.nik
                        || '';


                    const jenisPpks =
                        row.dataset.ppks
                        || '';



                    /*
                    |--------------------------------------------------------------------------
                    | SEARCH
                    |--------------------------------------------------------------------------
                    */

                    const matchSearch =
                        !search
                        ||
                        nama.includes(search)
                        ||
                        nik.includes(search);



                    /*
                    |--------------------------------------------------------------------------
                    | JENIS PPKS
                    |--------------------------------------------------------------------------
                    */

                    const matchPpks =
                        !ppks
                        ||
                        jenisPpks === ppks;



                    /*
                    |--------------------------------------------------------------------------
                    | FINAL RESULT
                    |--------------------------------------------------------------------------
                    */

                    const visible =
                        matchSearch
                        &&
                        matchPpks;



                    /*
                    |--------------------------------------------------------------------------
                    | SHOW / HIDE
                    |--------------------------------------------------------------------------
                    */

                    row.style.display =
                        visible
                            ? ''
                            : 'none';



                    /*
                    |--------------------------------------------------------------------------
                    | NUMBER
                    |--------------------------------------------------------------------------
                    */

                    if (visible) {

                        visibleCount++;


                        row.querySelector(
                            '.row-number'
                        ).textContent =
                            visibleCount;

                    }

                });



                /*
                |--------------------------------------------------------------------------
                | EMPTY ROW
                |--------------------------------------------------------------------------
                */

                emptyRow.style.display =
                    visibleCount === 0
                        ? 'table-row'
                        : 'none';

            }



            /*
            |--------------------------------------------------------------------------
            | SEARCH
            |--------------------------------------------------------------------------
            */

            searchInput.addEventListener(
                'input',
                filterTable
            );



            /*
            |--------------------------------------------------------------------------
            | JENIS PPKS
            |--------------------------------------------------------------------------
            */

            ppksFilter.addEventListener(
                'change',
                filterTable
            );



            /*
            |--------------------------------------------------------------------------
            | INITIAL FILTER
            |--------------------------------------------------------------------------
            */

            filterTable();

        });

    </script>

</x-app-layout>