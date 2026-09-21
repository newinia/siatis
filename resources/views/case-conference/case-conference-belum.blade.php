<x-app-layout>

    <div class="main-page">

        {{-- =====================================================
        HEADER
        ====================================================== --}}
        <div class="main-page-header">

            <div>
                <h1>Case Conference</h1>

                <p>
                    Peserta yang telah lulus Asesmen Kesehatan Awal
                    dan belum melakukan Case Conference.
                </p>
            </div>


            {{-- =====================================================
            DATE FILTER
            ====================================================== --}}
            <div class="date-filter-wrapper">

                <div class="date-filter">

                    <div class="date-picker">

                        <div class="date-picker-header">

                            <span class="material-symbols-outlined">
                                calendar_month
                            </span>

                            <span>Filter Tanggal</span>

                        </div>


                        <div class="date-input-group">

                            <div>

                                <label for="startDate">
                                    Dari
                                </label>

                                <input
                                    type="date"
                                    id="startDate"
                                    class="date-picker-input"
                                >

                            </div>


                            <div>

                                <label for="endDate">
                                    Sampai
                                </label>

                                <input
                                    type="date"
                                    id="endDate"
                                    class="date-picker-input"
                                >

                            </div>

                        </div>


                        <div class="date-picker-actions">

                            <button
                                type="button"
                                class="date-reset"
                                id="resetDate"
                            >
                                Reset
                            </button>

                            <button
                                type="button"
                                class="date-apply"
                                id="applyDate"
                            >
                                Terapkan
                            </button>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- =====================================================
        FILTER
        ====================================================== --}}
        <div class="filter-wrapper">

            <div class="filter-group">


                {{-- =================================================
                SEARCH
                ================================================== --}}
                <div
                    class="search"
                    id="searchWrapper"
                >

                    <span class="material-symbols-outlined">
                        search
                    </span>

                    <input
                        type="text"
                        id="searchInput"
                        placeholder="Cari Nama atau NIK"
                    >

                </div>


                {{-- =================================================
                FILTER JENIS PPKS
                ================================================== --}}
                <div class="select-wrapper">

                    <select
                        id="filterPpks"
                        class="filter-button"
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

                    </select>


                    <span class="material-symbols-outlined select-arrow">
                        expand_more
                    </span>

                </div>


                {{-- =================================================
                FILTER HASIL
                ================================================== --}}
                <div class="select-wrapper">

                    <select
                        id="filterStatus"
                        class="filter-button"
                    >

                        <option value="lolos">
                            Lolos Kesehatan Awal
                        </option>

                        <option value="">
                            Semua Status
                        </option>

                    </select>


                    <span class="material-symbols-outlined select-arrow">
                        expand_more
                    </span>

                </div>

            </div>

        </div>


        {{-- =====================================================
        TABLE
        ====================================================== --}}
        <div class="table-wrapper">

            <table class="table">

                <thead>

                    <tr>

                        <th width="60">
                            No
                        </th>

                        <th>
                            Nama
                        </th>

                        <th>
                            NIK
                        </th>

                        <th>
                            Umur
                        </th>

                        <th>
                            Jenis PPKS
                        </th>

                        <th>
                            Jurusan
                        </th>

                        <th>
                            Hasil
                        </th>

                        <th>
                            Keterangan
                        </th>

                    </tr>

                </thead>


                <tbody id="dataTable">

                    @forelse ($data as $index => $ppks)

                        @php

                            /*
                            |--------------------------------------------------------------------------
                            | DATA PESERTA
                            |--------------------------------------------------------------------------
                            */

                            $item = $ppks->data ?? [];


                            /*
                            |--------------------------------------------------------------------------
                            | NAMA
                            |--------------------------------------------------------------------------
                            */

                            $nama =
                                $item['nama']
                                ?? $item['Nama']
                                ?? $item['NAMA']
                                ?? $item['nama_lengkap']
                                ?? $item['Nama Lengkap']
                                ?? $item['NAMA LENGKAP']
                                ?? $item['nama peserta']
                                ?? $item['Nama Peserta']
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
                            | UMUR
                            |--------------------------------------------------------------------------
                            */

                            $umur =
                                $item['umur']
                                ?? $item['Umur']
                                ?? $item['UMUR']
                                ?? '-';


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
                                $item['jurusan']
                                ?? $item['Jurusan']
                                ?? $item['JURUSAN']
                                ?? '-';


                            /*
                            |--------------------------------------------------------------------------
                            | STATUS CASE CONFERENCE
                            |--------------------------------------------------------------------------
                            */

                            $hasil = 'Belum Dimulai';

                            $keterangan =
                                'Belum dilakukan Case Conference';

                        @endphp


                        <tr
                            data-nama="{{ strtolower($nama) }}"
                            data-nik="{{ strtolower($nik) }}"
                            data-ppks="{{ strtolower($jenisPpks) }}"
                            data-status="lolos"
                        >


                            {{-- =================================================
                            NO
                            ================================================== --}}
                            <td class="row-number">

                                {{ $data->firstItem() + $index }}

                            </td>


                            {{-- =================================================
                            NAMA
                            ================================================== --}}
                            <td>

                                <div class="participant-name">

                                    {{ $nama }}

                                </div>

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
                                    href="{{ route(
                                        'ppks.normal.case-conference.detail',
                                        $ppks->id
                                    ) }}"
                                    class="result-badge result-case-conference"
                                >

                                    {{-- RESULT ICON --}}
                                    <span class="material-symbols-outlined result-icon">
                                        groups
                                    </span>


                                    {{-- RESULT CONTENT --}}
                                    <div class="result-content">

                                        <span class="result-title">
                                            Case Conference
                                        </span>


                                        <span class="result-status belum-dimulai">

                                            <span class="status-dot belum-dimulai"></span>

                                            {{ $hasil }}

                                        </span>

                                    </div>


                                    {{-- RESULT ARROW --}}
                                    <span class="result-arrow">
                                        ›
                                    </span>

                                </a>

                            </td>


                            {{-- =================================================
                            KETERANGAN
                            ================================================== --}}
                            <td>

                                <span class="keterangan-pending">
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
                                        event_busy
                                    </span>

                                    <p>
                                        Belum ada peserta yang perlu
                                        melakukan Case Conference.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- =====================================================
        PAGINATION
        ====================================================== --}}
        @if ($data->hasPages())

            <div class="pagination-wrapper">

                {{ $data->links() }}

            </div>

        @endif

    </div>  


    {{-- =====================================================
    JAVASCRIPT
    ====================================================== --}}
    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const searchInput =
                document.getElementById('searchInput');

            const filterPpks =
                document.getElementById('filterPpks');

            const filterStatus =
                document.getElementById('filterStatus');

            const rows =
                document.querySelectorAll(
                    '#dataTable tr[data-nama]'
                );


            /* =================================================
               FILTER DATA
            ================================================== */

            function filterData() {

                const search =
                    searchInput
                        ? searchInput.value
                            .toLowerCase()
                            .trim()
                        : '';


                const ppks =
                    filterPpks
                        ? filterPpks.value
                            .toLowerCase()
                            .trim()
                        : '';


                const status =
                    filterStatus
                        ? filterStatus.value
                            .toLowerCase()
                            .trim()
                        : '';


                rows.forEach(function (row) {

                    const nama =
                        row.dataset.nama || '';


                    const nik =
                        row.dataset.nik || '';


                    const jenisPpks =
                        row.dataset.ppks || '';


                    const rowStatus =
                        row.dataset.status || '';


                    const matchSearch =
                        !search ||
                        nama.includes(search) ||
                        nik.includes(search);


                    const matchPpks =
                        !ppks ||
                        jenisPpks.includes(ppks);


                    const matchStatus =
                        !status ||
                        rowStatus === status;


                    row.style.display =
                        matchSearch &&
                        matchPpks &&
                        matchStatus
                            ? ''
                            : 'none';

                });

            }


            /* =================================================
               SEARCH
            ================================================== */

            if (searchInput) {

                searchInput.addEventListener(
                    'input',
                    filterData
                );

            }


            /* =================================================
               FILTER PPKS
            ================================================== */

            if (filterPpks) {

                filterPpks.addEventListener(
                    'change',
                    filterData
                );

            }


            /* =================================================
               FILTER STATUS
            ================================================== */

            if (filterStatus) {

                filterStatus.addEventListener(
                    'change',
                    filterData
                );

            }


            /* =================================================
               DATE
               Belum mengubah data server-side.
               Disiapkan mengikuti komponen Kode A.
            ================================================== */

            const startDate =
                document.getElementById('startDate');

            const endDate =
                document.getElementById('endDate');

            const resetDate =
                document.getElementById('resetDate');

            const applyDate =
                document.getElementById('applyDate');


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

                    }
                );

            }


            if (applyDate) {

                applyDate.addEventListener(
                    'click',
                    function () {

                        /*
                         * Date filter UI mengikuti Kode A.
                         * Filtering tanggal dapat dihubungkan
                         * ke field tanggal Case Conference
                         * ketika field tersebut tersedia.
                         */

                    }
                );

            }

        });

    </script>

</x-app-layout>