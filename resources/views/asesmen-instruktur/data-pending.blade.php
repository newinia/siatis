<x-app-layout>

    <div class="main-page">

        {{-- =====================================================
             HEADER
        ====================================================== --}}

        <div class="main-page-header">

            <div>
                <h1>Data Pending Instruktur</h1>

                <p>
                    Data PPKS yang masih berstatus pending setelah Asesmen Instruktur.
                </p>
            </div>

            {{-- DATE FILTER --}}

            <div class="date-filter-wrapper">

                <button
                    type="button"
                    class="date-filter"
                    id="dateFilterButton"
                    aria-expanded="false"
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
                        <rect x="3" y="4" width="18" height="18" rx="2"></rect>
                        <path d="M16 2v4"></path>
                        <path d="M8 2v4"></path>
                        <path d="M3 10h18"></path>
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
                        <path d="m6 9 6 6 6-6"></path>
                    </svg>
                </button>

                <div class="date-picker" id="datePicker">

                    <div class="date-picker-header">
                        <strong>Pilih Rentang Tanggal</strong>
                    </div>

                    <div class="date-input-group">

                        <div>
                            <label for="startDate">Dari</label>

                            <input
                                type="date"
                                id="startDate"
                            >
                        </div>

                        <div>
                            <label for="endDate">Sampai</label>

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
             NAVIGASI HASIL ASESMEN
        ====================================================== --}}

        <div class="result-navigation">

            <a href="{{ route('ppks.normal.instruktur') }}">
                Semua
            </a>

            <a href="{{ route('ppks.normal.asesmen-instruktur.lulus') }}">
                Lulus
            </a>

            <a
                href="{{ route('ppks.normal.asesmen-instruktur.pending') }}"
                class="active"
            >
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
                    <circle cx="11" cy="11" r="7"></circle>
                    <path d="m20 20-3.5-3.5"></path>
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

                            /*
                            |--------------------------------------------------------------------------
                            | DATA
                            |--------------------------------------------------------------------------
                            */

                            $data = $item->data;

                            if (is_string($data)) {
                                $data = json_decode($data, true) ?? [];
                            }

                            if (!is_array($data)) {
                                $data = [];
                            }

                            /*
                            |--------------------------------------------------------------------------
                            | NAMA
                            | Google Sheet:
                            | B = index 1
                            |--------------------------------------------------------------------------
                            */

                            $nama = '-';

                            if (
                                array_key_exists(1, $data) &&
                                trim((string) $data[1]) !== ''
                            ) {
                                $nama = $data[1];
                            } elseif (
                                array_key_exists('B', $data) &&
                                trim((string) $data['B']) !== ''
                            ) {
                                $nama = $data['B'];
                            } elseif (
                                !empty($data['nama_lengkap'])
                            ) {
                                $nama = $data['nama_lengkap'];
                            } elseif (
                                !empty($data['nama'])
                            ) {
                                $nama = $data['nama'];
                            }

                            /*
                            |--------------------------------------------------------------------------
                            | NIK
                            | Google Sheet:
                            | C = index 2
                            |--------------------------------------------------------------------------
                            */

                            $nik = '-';

                            if (
                                array_key_exists(2, $data) &&
                                trim((string) $data[2]) !== ''
                            ) {
                                $nik = $data[2];
                            } elseif (
                                array_key_exists('C', $data) &&
                                trim((string) $data['C']) !== ''
                            ) {
                                $nik = $data['C'];
                            } elseif (
                                !empty($data['nik'])
                            ) {
                                $nik = $data['nik'];
                            } elseif (
                                !empty($item->nik)
                            ) {
                                $nik = $item->nik;
                            }

                            /*
                            |--------------------------------------------------------------------------
                            | UMUR
                            | Google Sheet:
                            | G = index 6
                            |--------------------------------------------------------------------------
                            */

                            $umur = null;

                            if (
                                array_key_exists(6, $data) &&
                                $data[6] !== null &&
                                trim((string) $data[6]) !== ''
                            ) {
                                $umur = $data[6];
                            } elseif (
                                array_key_exists('G', $data) &&
                                $data['G'] !== null &&
                                trim((string) $data['G']) !== ''
                            ) {
                                $umur = $data['G'];
                            } elseif (
                                array_key_exists('umur', $data) &&
                                $data['umur'] !== null &&
                                trim((string) $data['umur']) !== ''
                            ) {
                                $umur = $data['umur'];
                            } elseif (
                                array_key_exists('usia', $data) &&
                                $data['usia'] !== null &&
                                trim((string) $data['usia']) !== ''
                            ) {
                                $umur = $data['usia'];
                            }

                            if (
                                $umur === null ||
                                trim((string) $umur) === ''
                            ) {
                                $umur = '-';
                            }

                            $umur = trim((string) $umur);

                            /*
                            |--------------------------------------------------------------------------
                            | JENIS PPKS
                            | Google Sheet:
                            | M = index 12
                            |--------------------------------------------------------------------------
                            */

                            $jenisPpks = '-';

                            if (
                                array_key_exists(12, $data) &&
                                trim((string) $data[12]) !== ''
                            ) {
                                $jenisPpks = $data[12];
                            } elseif (
                                array_key_exists('M', $data) &&
                                trim((string) $data['M']) !== ''
                            ) {
                                $jenisPpks = $data['M'];
                            } elseif (
                                !empty($data['jenis_ppks'])
                            ) {
                                $jenisPpks = $data['jenis_ppks'];
                            }

                            /*
                            |--------------------------------------------------------------------------
                            | JURUSAN
                            | Google Sheet:
                            | O = index 14
                            |--------------------------------------------------------------------------
                            */

                            $jurusan = '-';

                            if (
                                array_key_exists(14, $data) &&
                                trim((string) $data[14]) !== ''
                            ) {
                                $jurusan = $data[14];
                            } elseif (
                                array_key_exists('O', $data) &&
                                trim((string) $data['O']) !== ''
                            ) {
                                $jurusan = $data['O'];
                            } elseif (
                                !empty($data['jurusan_yang_diminati'])
                            ) {
                                $jurusan = $data['jurusan_yang_diminati'];
                            } elseif (
                                !empty($data['jurusan'])
                            ) {
                                $jurusan = $data['jurusan'];
                            }

                            /*
                            |--------------------------------------------------------------------------
                            | PROSES INSTRUKTUR
                            |--------------------------------------------------------------------------
                            */

                            $prosesInstruktur = $item->prosesPesertas
                                ->where('tahap', 'instruktur')
                                ->sortByDesc(function ($proses) {
                                    return $proses->tanggal_proses
                                        ?? $proses->created_at;
                                })
                                ->first();

                            /*
                            |--------------------------------------------------------------------------
                            | TANGGAL PROSES
                            |--------------------------------------------------------------------------
                            */

                            $tanggal = $prosesInstruktur?->tanggal_proses;

                            /*
                            |--------------------------------------------------------------------------
                            | KETERANGAN
                            |
                            | PRIORITAS:
                            | 1. catatan_asesmen_instruktur
                            | 2. catatan pada proses
                            | 3. alasan_pending
                            |--------------------------------------------------------------------------
                            */

                            $keterangan = null;

                            if (
                                isset($data['catatan_asesmen_instruktur']) &&
                                trim((string) $data['catatan_asesmen_instruktur']) !== ''
                            ) {
                                $keterangan =
                                    $data['catatan_asesmen_instruktur'];
                            }

                            if (
                                (!$keterangan || trim((string) $keterangan) === '') &&
                                $prosesInstruktur
                            ) {
                                if (
                                    isset($prosesInstruktur->catatan) &&
                                    trim((string) $prosesInstruktur->catatan) !== ''
                                ) {
                                    $keterangan =
                                        $prosesInstruktur->catatan;
                                }
                            }

                            if (
                                (!$keterangan || trim((string) $keterangan) === '') &&
                                $prosesInstruktur
                            ) {
                                if (
                                    isset($prosesInstruktur->alasan_pending) &&
                                    trim((string) $prosesInstruktur->alasan_pending) !== ''
                                ) {
                                    $keterangan =
                                        $prosesInstruktur->alasan_pending;
                                }
                            }

                            if (
                                !$keterangan ||
                                trim((string) $keterangan) === ''
                            ) {
                                $keterangan = '-';
                            }

                            /*
                            |--------------------------------------------------------------------------
                            | STATUS
                            |--------------------------------------------------------------------------
                            */

                            $statusProses =
                                $prosesInstruktur?->status ?? 'pending';

                        @endphp

                        <tr
                            data-nama="{{ strtolower((string) $nama) }}"
                            data-nik="{{ strtolower((string) $nik) }}"
                            data-ppks="{{ strtolower((string) $jenisPpks) }}"
                            data-tanggal="{{ $tanggal ? \Carbon\Carbon::parse($tanggal)->format('Y-m-d') : '' }}"
                        >

                            {{-- NO --}}

                            <td class="row-number">
                                {{ $ppks->firstItem() + $index }}
                            </td>

                            {{-- NAMA --}}

                            <td>
                                <strong
                                    style="font-weight: 600; color: #1f2937;"
                                >
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

                                <div class="result-badge result-instructor">

                                    <span class="material-symbols-outlined result-icon">
                                        assignment
                                    </span>

                                    <div class="result-content">

                                        <span class="result-title">
                                            Asesmen Instruktur
                                        </span>

                                        <span class="result-status pending">

                                            <span class="status-dot pending"></span>

                                            Pending

                                        </span>

                                    </div>

                                </div>

                            </td>

                            {{-- KETERANGAN --}}

                            <td class="keterangan-cell">

                                @if ($keterangan !== '-')

                                    <span class="keterangan-text">
                                        {{ $keterangan }}
                                    </span>

                                @else

                                    <span class="keterangan-empty">
                                        -
                                    </span>

                                @endif

                            </td>

                            {{-- AKSI --}}

                            <td>

                                <a
                                    href="{{ route('ppks.normal.asesmen-instruktur.data-detail', $item->id) }}"
                                    class="detail-button"
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

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="9"
                                class="empty-state"
                            >

                                <div class="empty-state-icon">

                                    <span class="material-symbols-outlined">
                                        assignment_late
                                    </span>

                                </div>

                                <p class="empty-state-title">
                                    Belum ada data Pending
                                </p>

                                <p class="empty-state-text">
                                    Belum ada data PPKS yang berstatus Pending setelah Asesmen Instruktur.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                    {{-- EMPTY HASIL FILTER --}}

                    @if ($ppks->count() > 0)

                        <tr
                            id="filterEmptyRow"
                            class="filter-empty-row"
                        >

                            <td colspan="9">

                                <div class="empty-state-icon">

                                    <span class="material-symbols-outlined">
                                        search_off
                                    </span>

                                </div>

                                <p class="empty-state-title">
                                    Data tidak ditemukan
                                </p>

                                <p class="empty-state-text">
                                    Tidak ada data yang sesuai dengan filter yang dipilih.
                                </p>

                            </td>

                        </tr>

                    @endif

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

    {{-- =========================================================
         JAVASCRIPT
    ========================================================== --}}

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const searchInput =
                document.getElementById('searchInput');

            const ppksFilter =
                document.getElementById('ppksFilter');

            const rows =
                document.querySelectorAll(
                    '.table tbody tr[data-nama]'
                );

            /* =====================================================
               DATE FILTER
            ===================================================== */

            const dateButton =
                document.getElementById('dateFilterButton');

            const datePicker =
                document.getElementById('datePicker');

            const dateText =
                document.getElementById('dateFilterText');

            const startDate =
                document.getElementById('startDate');

            const endDate =
                document.getElementById('endDate');

            const applyDate =
                document.getElementById('applyDate');

            const resetDate =
                document.getElementById('resetDate');

            const filterEmptyRow =
                document.getElementById('filterEmptyRow');

            /* =====================================================
               SIMPAN NOMOR ASLI
            ===================================================== */

            rows.forEach(function (row) {

                const numberCell =
                    row.querySelector('.row-number');

                if (numberCell) {

                    row.dataset.originalNumber =
                        numberCell.textContent.trim();

                }

            });

            /* =====================================================
               FILTER TABLE
            ===================================================== */

            function filterTable() {

                const search =
                    searchInput
                        ? searchInput.value.toLowerCase().trim()
                        : '';

                const ppks =
                    ppksFilter
                        ? ppksFilter.value.toLowerCase().trim()
                        : '';

                const start =
                    startDate
                        ? startDate.value
                        : '';

                const end =
                    endDate
                        ? endDate.value
                        : '';

                let visibleNumber = 1;
                let visibleCount = 0;

                rows.forEach(function (row) {

                    const nama =
                        row.dataset.nama || '';

                    const nik =
                        row.dataset.nik || '';

                    const jenis =
                        row.dataset.ppks || '';

                    const tanggal =
                        row.dataset.tanggal || '';

                    /* SEARCH */

                    const searchMatch =
                        search === '' ||
                        nama.includes(search) ||
                        nik.includes(search);

                    /* JENIS PPKS */

                    const ppksMatch =
                        ppks === '' ||
                        jenis === ppks;

                    /* TANGGAL */

                    let dateMatch = true;

                    if (start) {

                        if (!tanggal || tanggal < start) {
                            dateMatch = false;
                        }

                    }

                    if (end) {

                        if (!tanggal || tanggal > end) {
                            dateMatch = false;
                        }

                    }

                    const show =
                        searchMatch &&
                        ppksMatch &&
                        dateMatch;

                    row.style.display =
                        show
                            ? ''
                            : 'none';

                    if (show) {

                        visibleCount++;

                        const numberCell =
                            row.querySelector('.row-number');

                        if (numberCell) {

                            const hasFilter =
                                search !== '' ||
                                ppks !== '' ||
                                start !== '' ||
                                end !== '';

                            if (hasFilter) {

                                numberCell.textContent =
                                    visibleNumber++;

                            } else {

                                numberCell.textContent =
                                    row.dataset.originalNumber;

                            }

                        }

                    }

                });

                /* EMPTY FILTER */

                if (filterEmptyRow) {

                    filterEmptyRow.style.display =
                        visibleCount === 0
                            ? 'table-row'
                            : 'none';

                }

            }

            /* =====================================================
               SEARCH
            ===================================================== */

            if (searchInput) {

                searchInput.addEventListener(
                    'input',
                    filterTable
                );

            }

            /* =====================================================
               JENIS PPKS
            ===================================================== */

            if (ppksFilter) {

                ppksFilter.addEventListener(
                    'change',
                    filterTable
                );

            }

            /* =====================================================
               BUKA DATE PICKER
            ===================================================== */

            if (dateButton) {

                dateButton.addEventListener(
                    'click',
                    function (event) {

                        event.stopPropagation();

                        const active =
                            datePicker.classList.toggle('active');

                        dateButton.setAttribute(
                            'aria-expanded',
                            active ? 'true' : 'false'
                        );

                    }
                );

            }

            /* =====================================================
               DATE PICKER TIDAK MENUTUP SAAT DIKLIK
            ===================================================== */

            if (datePicker) {

                datePicker.addEventListener(
                    'click',
                    function (event) {
                        event.stopPropagation();
                    }
                );

            }

            /* =====================================================
               TERAPKAN TANGGAL
            ===================================================== */

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

                        dateText.textContent =
                            formatDate(start) +
                            ' - ' +
                            formatDate(end);

                        datePicker.classList.remove(
                            'active'
                        );

                        dateButton.setAttribute(
                            'aria-expanded',
                            'false'
                        );

                        filterTable();

                    }
                );

            }

            /* =====================================================
               RESET TANGGAL
            ===================================================== */

            if (resetDate) {

                resetDate.addEventListener(
                    'click',
                    function () {

                        startDate.value = '';
                        endDate.value = '';

                        dateText.textContent =
                            'Pilih Tanggal';

                        datePicker.classList.remove(
                            'active'
                        );

                        dateButton.setAttribute(
                            'aria-expanded',
                            'false'
                        );

                        filterTable();

                    }
                );

            }

            /* =====================================================
               FORMAT TANGGAL
            ===================================================== */

            function formatDate(value) {

                const date =
                    new Date(
                        value + 'T00:00:00'
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

            /* =====================================================
               KLIK DI LUAR DATE PICKER
            ===================================================== */

            document.addEventListener(
                'click',
                function () {

                    if (
                        datePicker &&
                        datePicker.classList.contains('active')
                    ) {

                        datePicker.classList.remove(
                            'active'
                        );

                        dateButton.setAttribute(
                            'aria-expanded',
                            'false'
                        );

                    }

                }
            );

            /* =====================================================
               FILTER PERTAMA KALI
            ===================================================== */

            filterTable();

        });

    </script>

</x-app-layout>
```
