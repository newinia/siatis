<x-app-layout>

```
<div class="case-conference-page">

    {{-- =====================================================
    HEADER
    ====================================================== --}}
    <div class="case-conference-header">

        <div>
            <h1>Asesmen Kesehatan Awal</h1>

            <p>
                Data PPKS yang telah lulus Asesmen Instruktur
                dan belum menjalani Asesmen Kesehatan Awal.
            </p>
        </div>

        {{-- =====================================================
        DATE FILTER
        ====================================================== --}}
        <div class="date-filter-wrapper">

            <button type="button"
                class="date-filter"
                id="dateFilterButton">

                <svg xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8">

                    <rect x="3" y="4" width="18" height="18" rx="2" />
                    <path d="M16 2v4" />
                    <path d="M8 2v4" />
                    <path d="M3 10h18" />

                </svg>

                <span id="dateFilterText">
                    Pilih Tanggal
                </span>

                <svg xmlns="http://www.w3.org/2000/svg"
                    width="17"
                    height="17"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2">

                    <path d="m6 9 6 6 6-6" />

                </svg>

            </button>

            {{-- DATE PICKER --}}
            <div class="date-picker" id="datePicker">

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

                        <input type="date" id="startDate">
                    </div>

                    <div>
                        <label for="endDate">
                            Sampai
                        </label>

                        <input type="date" id="endDate">
                    </div>

                </div>

                <div class="date-picker-actions">

                    <button type="button"
                        id="resetDate"
                        class="date-reset">
                        Reset
                    </button>

                    <button type="button"
                        id="applyDate"
                        class="date-apply">
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

            <svg xmlns="http://www.w3.org/2000/svg"
                width="16"
                height="16"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2">

                <circle cx="11" cy="11" r="7" />
                <path d="m20 20-3.5-3.5" />

            </svg>

            <input type="text"
                id="searchInput"
                placeholder="Cari Nama atau NIK"
                autocomplete="off">

        </div>


        {{-- FILTER PPKS --}}
        <div class="select-wrapper">

            <select id="ppksFilter"
                class="case-filter-button">

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


        {{-- FILTER TAHAPAN --}}
        <div class="select-wrapper">

            <select id="tahapanFilter"
                class="case-filter-button">

                <option value="">
                    Semua Jenis Tahapan
                </option>

                <option value="Asesmen Kesehatan Awal">
                    Asesmen Kesehatan Awal
                </option>

                <option value="Asesmen Kesehatan Lanjutan">
                    Asesmen Kesehatan Lanjutan
                </option>

                <option value="Asesmen Instruktur">
                    Asesmen Instruktur
                </option>

                <option value="Case Conference">
                    Case Conference
                </option>

            </select>

            <span class="material-symbols-outlined select-arrow">
                keyboard_arrow_down
            </span>

        </div>


        {{-- FILTER HASIL --}}
        <div class="select-wrapper">

            <select id="hasilFilter"
                class="case-filter-button">

                <option value="">
                    Semua Hasil
                </option>

                <option value="Belum Asesmen">
                    Belum Asesmen
                </option>

                <option value="Lulus">
                    Lulus
                </option>

                <option value="Pending">
                    Pending
                </option>

                <option value="Tidak Lulus">
                    Tidak Lulus
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

                @forelse ($ppks as $index => $item)

                    @php

                        /*
                        |--------------------------------------------------------------------------
                        | DATA PPKS
                        |--------------------------------------------------------------------------
                        */

                        $data = is_array($item->data)
                            ? $item->data
                            : [];


                        /*
                        |--------------------------------------------------------------------------
                        | HELPER
                        |--------------------------------------------------------------------------
                        */

                        $getValue = function ($value, $default = '-') {

                            if (is_array($value)) {
                                return implode(', ', array_filter($value));
                            }

                            if ($value === null || $value === '') {
                                return $default;
                            }

                            return (string) $value;
                        };


                        /*
                        |--------------------------------------------------------------------------
                        | IDENTITAS
                        |--------------------------------------------------------------------------
                        */

                        $nama = $getValue(
                            $data['nama_lengkap'] ?? $data[1] ?? '-'
                        );

                        $nik = $getValue(
                            $data['nik'] ?? $data[2] ?? '-'
                        );

                        $umur = $getValue(
                            $data['usia'] ?? $data[6] ?? '-'
                        );

                        $jenisPpks = $getValue(
                            $data['jenis_ppks'] ?? $data[12] ?? '-'
                        );

                        $jurusan = $getValue(
                            $data['jurusan_yang_diminati'] ?? $data[14] ?? '-'
                        );


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
                        | PROSES KESEHATAN AWAL
                        |--------------------------------------------------------------------------
                        */

                        $prosesKesehatan = $item->prosesPesertas
                            ->where('tahap', 'kesehatan_awal')
                            ->sortByDesc(function ($proses) {

                                return $proses->tanggal_proses
                                    ?? $proses->created_at;

                            })
                            ->first();


                        /*
                        |--------------------------------------------------------------------------
                        | TANGGAL
                        |--------------------------------------------------------------------------
                        */

                        $tanggalProses = $prosesInstruktur?->tanggal_proses
                            ? \Carbon\Carbon::parse(
                                $prosesInstruktur->tanggal_proses
                            )->format('Y-m-d')
                            : (
                                $prosesInstruktur?->created_at
                                ? $prosesInstruktur->created_at->format('Y-m-d')
                                : $item->updated_at?->format('Y-m-d')
                            );


                        /*
                        |--------------------------------------------------------------------------
                        | STATUS KESEHATAN
                        |--------------------------------------------------------------------------
                        */

                        $statusKesehatan =
                            $prosesKesehatan?->status ?? 'belum';


                        /*
                        |--------------------------------------------------------------------------
                        | HASIL
                        |--------------------------------------------------------------------------
                        */

                        if ($statusKesehatan === 'belum') {

                            $hasil = 'Belum Asesmen';

                            $keterangan =
                                'Menunggu Asesmen Kesehatan Awal';

                            $status = 'not-done';

                        } elseif ($statusKesehatan === 'sedang_diperiksa') {

                            $hasil = 'Belum Asesmen';

                            $keterangan =
                                'Asesmen Kesehatan Sedang Berlangsung';

                            $status = 'processing';

                        } elseif ($statusKesehatan === 'lulus') {

                            $hasil = 'Lulus';

                            $keterangan =
                                'Lulus Asesmen Kesehatan Awal';

                            $status = 'passed';

                        } elseif ($statusKesehatan === 'pending') {

                            $hasil = 'Pending';

                            $keterangan =
                                'Pending Asesmen Kesehatan Awal';

                            $status = 'pending';

                        } elseif ($statusKesehatan === 'tidak_lulus') {

                            $hasil = 'Tidak Lulus';

                            $keterangan =
                                'Tidak Lulus Asesmen Kesehatan Awal';

                            $status = 'rejected';

                        } else {

                            $hasil = 'Belum Asesmen';

                            $keterangan =
                                'Menunggu Asesmen Kesehatan Awal';

                            $status = 'not-done';

                        }

                    @endphp


                    <tr
                        data-nama="{{ strtolower($nama) }}"
                        data-nik="{{ strtolower($nik) }}"
                        data-ppks="{{ strtolower($jenisPpks) }}"
                        data-tahapan="asesmen kesehatan awal"
                        data-hasil="{{ strtolower($hasil) }}"
                        data-tanggal="{{ $tanggalProses }}"
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


                            <a href="{{ route(
                                'ppks.normal.asesmen-kesehatan.awal',
                                $item->id
                            ) }}"
                                class="result-badge
                                @if($status === 'passed')
                                    result-passed
                                @elseif($status === 'rejected')
                                    result-rejected
                                @elseif($status === 'pending')
                                    result-pending
                                @elseif($status === 'processing')
                                    result-processing
                                @else
                                    result-not-done
                                @endif">

                                <span class="material-symbols-outlined result-icon">

                                    @if($status === 'passed')
                                        check_circle
                                    @elseif($status === 'rejected')
                                        cancel
                                    @elseif($status === 'pending')
                                        pending
                                    @elseif($status === 'processing')
                                        progress_activity
                                    @else
                                        medical_services
                                    @endif

                                </span>


                                <div class="result-content">

                                    <span class="result-title">
                                        Asesmen Kesehatan Awal
                                    </span>

                                    <span class="result-status">

                                        <span class="status-dot
                                            @if($status === 'passed')
                                                passed
                                            @elseif($status === 'rejected')
                                                rejected
                                            @elseif($status === 'pending')
                                                pending
                                            @elseif($status === 'processing')
                                                processing
                                            @else
                                                not-done
                                            @endif">
                                        </span>

                                        {{ $hasil }}

                                    </span>

                                </div>


                                <span class="result-arrow">
                                    ›
                                </span>

                            </a>

                        </td>


                        {{-- KETERANGAN --}}
                        <td>

                            @if($status === 'passed')

                                <span class="keterangan-lolos">
                                    Lulus Asesmen Kesehatan Awal
                                </span>

                            @elseif($status === 'rejected')

                                <span class="keterangan-tidak-lolos">
                                    Tidak Lulus Asesmen Kesehatan Awal
                                </span>

                            @elseif($status === 'pending')

                                <span class="keterangan-pending">
                                    Pending Asesmen Kesehatan Awal
                                </span>

                            @elseif($status === 'processing')

                                <span class="keterangan-processing">
                                    Asesmen Sedang Berlangsung
                                </span>

                            @else

                                <span class="keterangan-belum">
                                    Menunggu Asesmen Kesehatan Awal
                                </span>

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr id="emptyRow">

                        <td colspan="8"
                            style="
                                text-align:center;
                                padding:40px;
                                color:#6b7280;
                            ">

                            Belum ada PPKS yang siap menjalani
                            Asesmen Kesehatan Awal.

                        </td>

                    </tr>

                @endforelse


                <tr id="filterEmptyRow"
                    style="display:none;">

                    <td colspan="8"
                        style="
                            text-align:center;
                            padding:40px;
                            color:#6b7280;
                        ">

                        Data tidak ditemukan.

                    </td>

                </tr>

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

        const ppksFilter =
            document.getElementById('ppksFilter');

        const tahapanFilter =
            document.getElementById('tahapanFilter');

        const hasilFilter =
            document.getElementById('hasilFilter');

        const tableRows =
            document.querySelectorAll(
                '.table tbody tr[data-nama]'
            );

        const filterEmptyRow =
            document.getElementById('filterEmptyRow');


        /*
        |--------------------------------------------------------------------------
        | DATE
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | FILTER TABLE
        |--------------------------------------------------------------------------
        */

        function filterTable() {

            const searchValue =
                searchInput.value
                    .toLowerCase()
                    .trim();

            const ppksValue =
                ppksFilter.value
                    .toLowerCase()
                    .trim();

            const tahapanValue =
                tahapanFilter.value
                    .toLowerCase()
                    .trim();

            const hasilValue =
                hasilFilter.value
                    .toLowerCase()
                    .trim();

            const selectedStart =
                startDate.value;

            const selectedEnd =
                endDate.value;


            let visibleNumber = 1;

            let found = false;


            tableRows.forEach(function (row) {

                const nama =
                    row.dataset.nama || '';

                const nik =
                    row.dataset.nik || '';

                const ppks =
                    row.dataset.ppks || '';

                const tahapan =
                    row.dataset.tahapan || '';

                const hasil =
                    row.dataset.hasil || '';

                const tanggal =
                    row.dataset.tanggal || '';


                /*
                |------------------------------------------------------------------
                | SEARCH
                |------------------------------------------------------------------
                */

                const matchSearch =
                    searchValue === '' ||
                    nama.includes(searchValue) ||
                    nik.includes(searchValue);


                /*
                |------------------------------------------------------------------
                | PPKS
                |------------------------------------------------------------------
                */

                const matchPpks =
                    ppksValue === '' ||
                    ppks.includes(ppksValue);


                /*
                |------------------------------------------------------------------
                | TAHAPAN
                |------------------------------------------------------------------
                */

                const matchTahapan =
                    tahapanValue === '' ||
                    tahapan === tahapanValue;


                /*
                |------------------------------------------------------------------
                | HASIL
                |------------------------------------------------------------------
                */

                const matchHasil =
                    hasilValue === '' ||
                    hasil === hasilValue;


                /*
                |------------------------------------------------------------------
                | DATE
                |------------------------------------------------------------------
                */

                let matchDate = true;


                if (selectedStart) {

                    matchDate =
                        tanggal >= selectedStart;

                }


                if (
                    selectedEnd &&
                    matchDate
                ) {

                    matchDate =
                        tanggal <= selectedEnd;

                }


                /*
                |------------------------------------------------------------------
                | FINAL
                |------------------------------------------------------------------
                */

                const shouldShow =
                    matchSearch &&
                    matchPpks &&
                    matchTahapan &&
                    matchHasil &&
                    matchDate;


                if (shouldShow) {

                    row.style.display = '';

                    visibleNumber++;

                    row.querySelector(
                        '.row-number'
                    ).textContent =
                        visibleNumber - 1;

                    found = true;

                } else {

                    row.style.display = 'none';

                }

            });


            filterEmptyRow.style.display =
                found
                    ? 'none'
                    : 'table-row';

        }


        /*
        |--------------------------------------------------------------------------
        | EVENT
        |--------------------------------------------------------------------------
        */

        searchInput.addEventListener(
            'input',
            filterTable
        );

        ppksFilter.addEventListener(
            'change',
            filterTable
        );

        tahapanFilter.addEventListener(
            'change',
            filterTable
        );

        hasilFilter.addEventListener(
            'change',
            filterTable
        );


        /*
        |--------------------------------------------------------------------------
        | DATE PICKER
        |--------------------------------------------------------------------------
        */

        dateFilterButton.addEventListener(
            'click',
            function (event) {

                event.stopPropagation();

                datePicker.classList.toggle(
                    'active'
                );

            }
        );


        datePicker.addEventListener(
            'click',
            function (event) {

                event.stopPropagation();

            }
        );


        /*
        |--------------------------------------------------------------------------
        | APPLY DATE
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | RESET DATE
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | FORMAT DATE
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | CLICK OUTSIDE
        |--------------------------------------------------------------------------
        */

        document.addEventListener(
            'click',
            function () {

                datePicker.classList.remove(
                    'active'
                );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | INITIAL
        |--------------------------------------------------------------------------
        */

        filterTable();

    });

</script>


{{-- =====================================================
STYLE
====================================================== --}}
<style>

    .case-conference-page {
        padding: 20px 0 30px;
    }


    .case-conference-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 24px;
    }


    .case-conference-header h1 {
        margin: 0;
        font-size: 22px;
        font-weight: 700;
        color: #1f2937;
    }


    .case-conference-header p {
        margin-top: 6px;
        font-size: 14px;
        color: #6b7280;
    }


    .date-filter-wrapper {
        position: relative;
    }


    .date-filter {
        display: flex;
        align-items: center;
        gap: 8px;
        min-width: 180px;
        justify-content: space-between;
        padding: 9px 12px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        background: #fff;
        cursor: pointer;
        font-size: 14px;
        color: #374151;
    }


    .date-picker {
        display: none;
        position: absolute;
        right: 0;
        top: calc(100% + 8px);
        width: 300px;
        padding: 16px;
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, .10);
        z-index: 50;
    }


    .date-picker.active {
        display: block;
    }


    .date-picker-header {
        margin-bottom: 14px;
        font-size: 14px;
        color: #1f2937;
    }


    .date-input-group {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }


    .date-input-group label {
        display: block;
        margin-bottom: 5px;
        font-size: 12px;
        color: #6b7280;
    }


    .date-input-group input {
        width: 100%;
        padding: 8px;
        border: 1px solid #d1d5db;
        border-radius: 7px;
        font-size: 12px;
    }


    .date-picker-actions {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
        margin-top: 15px;
    }


    .date-reset,
    .date-apply {
        padding: 8px 12px;
        border-radius: 7px;
        border: none;
        cursor: pointer;
        font-size: 12px;
    }


    .date-reset {
        background: #f3f4f6;
        color: #374151;
    }


    .date-apply {
        background: #286693;
        color: #fff;
    }


    .case-filter-wrapper {
        display: flex;
        gap: 10px;
        margin-bottom: 18px;
        flex-wrap: wrap;
    }


    .case-search {
        display: flex;
        align-items: center;
        gap: 8px;
        flex: 1;
        min-width: 220px;
        padding: 9px 12px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        background: #fff;
    }


    .case-search input {
        width: 100%;
        border: none;
        outline: none;
        font-size: 14px;
    }


    .select-wrapper {
        position: relative;
    }


    .case-filter-button {
        appearance: none;
        min-width: 180px;
        padding: 9px 36px 9px 12px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        background: #fff;
        font-size: 13px;
        color: #374151;
        cursor: pointer;
    }


    .select-arrow {
        position: absolute;
        right: 9px;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
        font-size: 18px;
        color: #6b7280;
    }


    .table-wrapper {
        overflow-x: auto;
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
    }


    .table {
        width: 100%;
        border-collapse: collapse;
    }


    .table th {
        padding: 12px 14px;
        background: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
        text-align: left;
        font-size: 12px;
        font-weight: 700;
        color: #374151;
        white-space: nowrap;
    }


    .table td {
        padding: 13px 14px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 13px;
        color: #374151;
        vertical-align: middle;
    }


    .table tbody tr:last-child td {
        border-bottom: none;
    }


    .row-number {
        width: 45px;
        text-align: center;
        font-weight: 600;
        color: #6b7280;
    }


    .result-badge {
        display: flex;
        align-items: center;
        gap: 9px;
        min-width: 210px;
        padding: 8px 10px;
        border-radius: 8px;
        text-decoration: none;
        transition: .2s ease;
    }


    .result-badge:hover {
        transform: translateY(-1px);
    }


    .result-passed {
        background: #ecfdf5;
        color: #15803d;
    }


    .result-rejected {
        background: #fef2f2;
        color: #b91c1c;
    }


    .result-pending {
        background: #fffbeb;
        color: #b45309;
    }


    .result-processing {
        background: #eff6ff;
        color: #2563eb;
    }


    .result-not-done {
        background: #f8fafc;
        color: #64748b;
    }


    .result-icon {
        font-size: 20px;
    }


    .result-content {
        display: flex;
        flex-direction: column;
        gap: 2px;
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
    }


    .status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
    }


    .status-dot.passed {
        background: #22c55e;
    }


    .status-dot.rejected {
        background: #ef4444;
    }


    .status-dot.pending {
        background: #f59e0b;
    }


    .status-dot.processing {
        background: #3b82f6;
    }


    .status-dot.not-done {
        background: #94a3b8;
    }


    .keterangan-lolos {
        display: inline-block;
        padding: 5px 9px;
        border-radius: 6px;
        background: #ecfdf5;
        color: #15803d;
        font-size: 11px;
        font-weight: 600;
    }


    .keterangan-tidak-lolos {
        display: inline-block;
        padding: 5px 9px;
        border-radius: 6px;
        background: #fef2f2;
        color: #b91c1c;
        font-size: 11px;
        font-weight: 600;
    }


    .keterangan-pending {
        display: inline-block;
        padding: 5px 9px;
        border-radius: 6px;
        background: #fffbeb;
        color: #b45309;
        font-size: 11px;
        font-weight: 600;
    }


    .keterangan-processing {
        display: inline-block;
        padding: 5px 9px;
        border-radius: 6px;
        background: #eff6ff;
        color: #2563eb;
        font-size: 11px;
        font-weight: 600;
    }


    .keterangan-belum {
        display: inline-block;
        padding: 5px 9px;
        border-radius: 6px;
        background: #f8fafc;
        color: #64748b;
        font-size: 11px;
        font-weight: 600;
    }


    .pagination-wrapper {
        margin-top: 18px;
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
        }

    }

</style>
```

</x-app-layout>
