<x-app-layout>

    <div class="main-page">

        {{-- =====================================================
        HEADER
        ====================================================== --}}
        <div class="main-page-header">

            <div>

                <h1>
                    Data Kesehatan Lanjutan Tidak Lulus
                </h1>

                <p>
                    Data peserta yang tidak lulus asesmen kesehatan lanjutan dan tidak dapat melanjutkan ke tahap berikutnya.
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

                    <circle
                        cx="11"
                        cy="11"
                        r="7"
                    />

                    <path
                        d="m20 20-3.5-3.5"
                    />

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
                            | HASIL
                            |--------------------------------------------------------------------------
                            */

                            $hasil =
                                'Tidak Lulus';


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
                                        <span class="result-title healt">
                                            Asesmen Kesehatan Lanjutan
                                        </span>


                                        {{-- STATUS --}}
                                        <span class="result-status tidak-lulus">

                                            <span class="status-dot tidak-lulus"></span>

                                            Tidak Lulus

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

                                <span class="keterangan-tidak-lolos">
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
                                        Belum ada data PPKS yang tidak lulus Asesmen Kesehatan Lanjutan
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

                const ppks =
                    ppksFilter.value
                        .toLowerCase()
                        .trim();


                let visibleCount = 0;


                tableRows.forEach(function (row) {

                    const jenisPpks =
                        row.dataset.ppks
                        || '';


                    /*
                    |--------------------------------------------------------------------------
                    | MATCH JENIS PPKS
                    |--------------------------------------------------------------------------
                    */

                    const matchPpks =
                        !ppks
                        ||
                        jenisPpks === ppks;


                    /*
                    |--------------------------------------------------------------------------
                    | SHOW / HIDE
                    |--------------------------------------------------------------------------
                    */

                    row.style.display =
                        matchPpks
                            ? ''
                            : 'none';


                    /*
                    |--------------------------------------------------------------------------
                    | NOMOR
                    |--------------------------------------------------------------------------
                    */

                    if (matchPpks) {

                        visibleCount++;


                        const numberCell =
                            row.querySelector(
                                '.row-number'
                            );


                        if (numberCell) {

                            numberCell.textContent =
                                visibleCount;

                        }

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
            | FILTER JENIS PPKS
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