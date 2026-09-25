<x-app-layout>

    <div class="main-page">

        {{-- =====================================================
        HEADER
        ====================================================== --}}
        <div class="main-page-header">

            <div>
                <h1>Asesmen Kesehatan Awal</h1>

                <p>
                    Data peserta yang telah lulus Asesmen Instruktur
                    dan sedang mengikuti proses Asesmen Kesehatan Awal.
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


                {{-- FILTER STATUS --}}
                <div class="select-wrapper">

                    <select
                        id="filterStatus"
                        class="filter-button"
                    >

                        <option value="">
                            Semua Status
                        </option>

                        <option value="belum asesmen">
                            Belum Asesmen
                        </option>

                        <option value="lulus">
                            Lulus
                        </option>

                        <option value="pending">
                            Pending
                        </option>

                        <option value="tidak lulus">
                            Tidak Lulus
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
                        <th width="60">No</th>
                        <th>Nama</th>
                        <th>NIK</th>
                        <th>Umur</th>
                        <th>Jenis PPKS</th>
                        <th>Jurusan Peminatan</th>
                        <th>Hasil</th>
                        <th>Keterangan</th>
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
                            | PROSES INSTRUKTUR
                            |--------------------------------------------------------------------------
                            */

                            $prosesInstruktur = $item->prosesPesertas
                                ->where('tahap', 'instruktur')
                                ->sortByDesc(
                                    fn ($p) =>
                                        $p->tanggal_proses
                                        ?? $p->created_at
                                )
                                ->first();


                            /*
                            |--------------------------------------------------------------------------
                            | PROSES KESEHATAN AWAL
                            |--------------------------------------------------------------------------
                            */

                            $prosesKesehatan = $item->prosesPesertas
                                ->where('tahap', 'kesehatan_awal')
                                ->sortByDesc(
                                    fn ($p) =>
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
                                ?? $prosesInstruktur?->tanggal_proses
                                ?? $prosesInstruktur?->created_at
                                ?? $item->updated_at;


                            /*
                            |--------------------------------------------------------------------------
                            | STATUS DATABASE
                            |
                            | Database kesehatan awal hanya memiliki:
                            | lulus
                            | pending
                            | tidak_lulus
                            |
                            | Jika belum ada record kesehatan awal,
                            | status database = null.
                            |--------------------------------------------------------------------------
                            */

                            $statusKesehatan =
                                $prosesKesehatan?->status;


                            /*
                            |--------------------------------------------------------------------------
                            | STATUS TAMPILAN
                            |
                            | "belum" hanya status tampilan.
                            | Tidak disimpan ke database.
                            |--------------------------------------------------------------------------
                            */

                            $statusTampilan =
                                $statusKesehatan ?? 'belum';


                            /*
                            |--------------------------------------------------------------------------
                            | HASIL & KETERANGAN
                            |--------------------------------------------------------------------------
                            */

                            switch ($statusTampilan) {

                                case 'lulus':

                                    $hasil = 'Lulus';

                                    $keterangan =
                                        'Lulus Asesmen Kesehatan Awal';

                                    $statusClass = 'lulus';

                                    break;


                                case 'pending':

                                    $hasil = 'Pending';

                                    $keterangan =
                                        'Menunggu Keputusan Hasil Asesmen Kesehatan Awal';

                                    $statusClass = 'pending';

                                    break;


                                case 'tidak_lulus':

                                    $hasil = 'Tidak Lulus';

                                    $keterangan =
                                        'Tidak Lulus Asesmen Kesehatan Awal';

                                    $statusClass = 'tidak-lulus';

                                    break;


                                case 'belum':

                                default:

                                    $hasil = 'Belum Asesmen';

                                    $keterangan =
                                        'Menunggu Asesmen Kesehatan Awal';

                                    $statusClass = 'belum-dimulai';

                                    break;
                            }

                        @endphp


                        {{-- =================================================
                        ROW
                        ================================================== --}}
                        <tr
                            data-nama="{{ strtolower($nama) }}"
                            data-nik="{{ $nik }}"
                            data-ppks="{{ strtolower($jenisPpks) }}"
                            data-tahapan="asesmen kesehatan awal"
                            data-hasil="{{ strtolower($hasil) }}"
                            data-status="{{ $statusTampilan }}"
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

                                        @if ($statusTampilan === 'lulus')

                                            check_circle

                                        @elseif ($statusTampilan === 'tidak_lulus')

                                            cancel

                                        @elseif ($statusTampilan === 'pending')

                                            pending

                                        @else

                                            medical_information

                                        @endif

                                    </span>


                                    {{-- RESULT CONTENT --}}
                                    <div class="result-content">

                                        <span class="result-title">
                                            Asesmen Kesehatan Awal
                                        </span>


                                        <span class="result-status {{ $statusClass }}">

                                            @if ($statusTampilan === 'lulus')

                                                <span class="status-dot lulus"></span>

                                            @elseif ($statusTampilan === 'tidak_lulus')

                                                <span class="status-dot tidak-lulus"></span>

                                            @elseif ($statusTampilan === 'pending')

                                                <span class="status-dot pending"></span>

                                            @else

                                                <span class="status-dot belum-dimulai"></span>

                                            @endif

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

                                @if ($statusTampilan === 'lulus')

                                    <span class="keterangan-lolos">
                                        {{ $keterangan }}
                                    </span>

                                @elseif ($statusTampilan === 'tidak_lulus')

                                    <span class="keterangan-tidak-lolos">
                                        {{ $keterangan }}
                                    </span>

                                @elseif ($statusTampilan === 'pending')

                                    <span class="keterangan-pending">
                                        {{ $keterangan }}
                                    </span>

                                @else

                                    <span class="keterangan-belum">
                                        {{ $keterangan }}
                                    </span>

                                @endif

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
                                        Belum ada data Asesmen Kesehatan Awal.
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

            const filterPpks =
                document.getElementById('filterPpks');

            const filterStatus =
                document.getElementById('filterStatus');

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

                const ppks =
                    filterPpks
                        ? filterPpks.value.toLowerCase().trim()
                        : '';

                const status =
                    filterStatus
                        ? filterStatus.value.toLowerCase().trim()
                        : '';

                const start =
                    startDate
                        ? startDate.value
                        : '';

                const end =
                    endDate
                        ? endDate.value
                        : '';


                rows.forEach(function (row) {

                    const jenisPpks =
                        row.dataset.ppks || '';

                    const statusKesehatan =
                        row.dataset.status || '';

                    const tanggal =
                        row.dataset.tanggal || '';


                    /* =================================================
                       FILTER JENIS PPKS
                    ================================================== */

                    const matchPpks =
                        !ppks ||
                        jenisPpks.includes(ppks);


                    /* =================================================
                       FILTER STATUS
                    ================================================== */

                    let matchStatus = true;

                    if (status) {

                        if (status === 'belum asesmen') {

                            matchStatus =
                                statusKesehatan === 'belum';

                        } else if (status === 'tidak lulus') {

                            matchStatus =
                                statusKesehatan === 'tidak_lulus';

                        } else {

                            matchStatus =
                                statusKesehatan === status;

                        }

                    }


                    /* =================================================
                       FILTER TANGGAL
                    ================================================== */

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


                    /* =================================================
                       TAMPILKAN DATA
                    ================================================== */

                    row.style.display =
                        matchPpks &&
                        matchStatus &&
                        matchDate
                            ? ''
                            : 'none';

                });

            }


            /* =================================================
               FILTER JENIS PPKS
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
               FILTER TANGGAL
            ================================================== */

            if (applyDate) {

                applyDate.addEventListener(
                    'click',
                    filterData
                );

            }


            /* =================================================
               RESET TANGGAL
            ================================================== */

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

                        filterData();

                    }
                );

            }

        });

    </script>

</x-app-layout>
