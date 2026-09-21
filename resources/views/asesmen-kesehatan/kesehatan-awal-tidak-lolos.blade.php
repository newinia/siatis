
<x-app-layout>

    <div class="main-page">

        {{-- =====================================================
        HEADER
        ====================================================== --}}
        <div class="main-page-header">

            <div>

                <h1>
                    Data Tidak Lulus Asesmen Kesehatan Awal
                </h1>

                <p>
                    Data peserta yang telah menjalani Asesmen Kesehatan Awal
                    tetapi tidak lulus dan tidak dapat melanjutkan ke tahap berikutnya.
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

                            <span>
                                Filter Tanggal
                            </span>

                        </div>


                        <div class="date-input-group">

                            <div>

                                <label for="startDate">
                                    Dari
                                </label>

                                <input
                                    type="date"
                                    id="startDate"
                                    class="date-picker"
                                >

                            </div>


                            <div>

                                <label for="endDate">
                                    Sampai
                                </label>

                                <input
                                    type="date"
                                    id="endDate"
                                    class="date-picker"
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

                {{-- SEARCH --}}
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


                {{-- FILTER JENIS PPKS --}}
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

                    @forelse ($ppks as $index => $item)

                        @php

                            /*
                            |--------------------------------------------------------------------------
                            | DATA PESERTA
                            |--------------------------------------------------------------------------
                            */

                            $data = is_array($item->data)
                                ? $item->data
                                : [];


                            /*
                            |--------------------------------------------------------------------------
                            | HELPER GET VALUE
                            |--------------------------------------------------------------------------
                            */

                            $getValue = function ($key, $fallback = null) use ($data) {

                                $value = $data[$key] ?? $fallback;

                                if (is_array($value)) {

                                    return implode(
                                        ', ',
                                        array_filter($value)
                                    );

                                }

                                return $value !== null && $value !== ''
                                    ? $value
                                    : '-';

                            };


                            /*
                            |--------------------------------------------------------------------------
                            | IDENTITAS
                            |--------------------------------------------------------------------------
                            */

                            $nama = $getValue(
                                'nama_lengkap',
                                $data[1] ?? null
                            );


                            $nik = $getValue(
                                'nik',
                                $data[2] ?? null
                            );


                            $usia = $getValue(
                                'usia',
                                $data[6] ?? null
                            );


                            $jenisPpks = $getValue(
                                'jenis_ppks',
                                $data[12] ?? null
                            );


                            $jurusan = $getValue(
                                'jurusan_yang_diminati',
                                $data[14] ?? null
                            );


                            /*
                            |--------------------------------------------------------------------------
                            | PROSES KESEHATAN AWAL
                            |--------------------------------------------------------------------------
                            */

                            $prosesKesehatan = $item->prosesPesertas
                                ->where('tahap', 'kesehatan_awal')
                                ->sortByDesc(
                                    fn($p) =>
                                        $p->tanggal_proses
                                        ?? $p->created_at
                                )
                                ->first();


                            /*
                            |--------------------------------------------------------------------------
                            | TANGGAL PROSES
                            |--------------------------------------------------------------------------
                            */

                            $tanggalProses =
                                $prosesKesehatan?->tanggal_proses
                                ?? $prosesKesehatan?->created_at
                                ?? $item->updated_at;


                            /*
                            |--------------------------------------------------------------------------
                            | STATUS
                            |--------------------------------------------------------------------------
                            |
                            | Untuk halaman ini status yang ditampilkan adalah
                            | TIDAK LULUS.
                            |
                            | Status tetap diambil dari database jika tersedia.
                            | Jika tidak tersedia, gunakan fallback tidak_lulus.
                            |
                            */

                            $statusKesehatan =
                                $prosesKesehatan?->status ?? 'tidak_lulus';


                            /*
                            |--------------------------------------------------------------------------
                            | HASIL
                            |--------------------------------------------------------------------------
                            */

                            $hasil = 'Tidak Lulus';


                            /*
                            |--------------------------------------------------------------------------
                            | KETERANGAN
                            |--------------------------------------------------------------------------
                            |
                            | Prioritas:
                            | 1. Catatan dari proses kesehatan_awal terbaru
                            | 2. Catatan asesmen kesehatan dari data peserta
                            | 3. -
                            |
                            */

                            $keterangan =
                                $prosesKesehatan?->catatan
                                ?? $data['catatan_asesmen_kesehatan']
                                ?? '-';

                        @endphp


                        <tr
                            data-nama="{{ strtolower($nama) }}"
                            data-nik="{{ $nik }}"
                            data-ppks="{{ strtolower($jenisPpks) }}"
                            data-tahapan="asesmen kesehatan awal"
                            data-hasil="tidak_lulus"
                            data-status="tidak_lulus"
                            data-tanggal="{{ $tanggalProses ? \Carbon\Carbon::parse($tanggalProses)->format('Y-m-d') : '' }}"
                        >


                            {{-- =================================================
                            NO
                            ================================================== --}}
                            <td class="row-number">

                                {{ $ppks->firstItem() + $index }}

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

                                {{ $usia }}

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
                                    href="{{ route('ppks.normal.asesmen-kesehatan.awal', $item->id) }}"
                                    class="result-badge result-health"
                                >

                                    {{-- RESULT ICON --}}
                                    <span class="material-symbols-outlined result-icon">
                                        medical_information
                                    </span>


                                    {{-- RESULT CONTENT --}}
                                    <div class="result-content">

                                        <span class="result-title">
                                            Asesmen Kesehatan Awal
                                        </span>


                                        <span class="result-status tidak-lulus">

                                            <span class="status-dot tidak-lulus"></span>

                                            Tidak Lulus

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
                                        folder_open
                                    </span>

                                    <p>
                                        Belum ada data peserta yang tidak lulus
                                        Asesmen Kesehatan Awal.
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

        document.addEventListener('DOMContentLoaded', function () {

            const searchInput =
                document.getElementById('searchInput');


            const filterPpks =
                document.getElementById('filterPpks');


            const rows =
                document.querySelectorAll(
                    '#dataTable tr[data-nama]'
                );


            const startDate =
                document.getElementById('startDate');


            const endDate =
                document.getElementById('endDate');


            const resetDate =
                document.getElementById('resetDate');


            const applyDate =
                document.getElementById('applyDate');


            /* =================================================
               FILTER DATA
            ================================================== */

            function filterData() {

                const search =
                    searchInput.value
                        .toLowerCase()
                        .trim();


                const ppks =
                    filterPpks.value
                        .toLowerCase()
                        .trim();


                const start =
                    startDate.value;


                const end =
                    endDate.value;


                rows.forEach(row => {

                    const nama =
                        row.dataset.nama || '';


                    const nik =
                        row.dataset.nik || '';


                    const jenisPpks =
                        row.dataset.ppks || '';


                    const tanggal =
                        row.dataset.tanggal || '';


                    const matchSearch =
                        !search ||
                        nama.includes(search) ||
                        nik.includes(search);


                    const matchPpks =
                        !ppks ||
                        jenisPpks.includes(ppks);


                    let matchDate = true;


                    if (start && tanggal) {

                        matchDate =
                            tanggal >= start;

                    }


                    if (end && tanggal) {

                        matchDate =
                            matchDate &&
                            tanggal <= end;

                    }


                    row.style.display =
                        matchSearch &&
                        matchPpks &&
                        matchDate
                            ? ''
                            : 'none';

                });

            }


            /* =================================================
               EVENT FILTER
            ================================================== */

            if (searchInput) {

                searchInput.addEventListener(
                    'input',
                    filterData
                );

            }


            if (filterPpks) {

                filterPpks.addEventListener(
                    'change',
                    filterData
                );

            }


            /* =================================================
               DATE
            ================================================== */

            if (applyDate) {

                applyDate.addEventListener(
                    'click',
                    filterData
                );

            }


            if (resetDate) {

                resetDate.addEventListener(
                    'click',
                    function () {

                        startDate.value = '';
                        endDate.value = '';

                        filterData();

                    }
                );

            }

        });

    </script>

</x-app-layout>

