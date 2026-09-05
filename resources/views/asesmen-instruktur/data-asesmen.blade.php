<x-app-layout>

    <div class="case-conference-page">

        {{-- =====================================================
        HEADER
        ====================================================== --}}
        <div class="case-conference-header">

            <div>
                <h1>Data Calon PPKS Belum Asesmen Instruktur

                <p>
                    Data calon PPKS yang telah diverifikasi dan siap diproses ke tahap selanjutnya.
                </p>
            </div>

            {{-- DATE FILTER --}}
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

                <div class="date-picker" id="datePicker">

                    <div class="date-picker-header">
                        <strong>Pilih Rentang Tanggal</strong>
                    </div>

                    <div class="date-input-group">

                        <div>
                            <label for="startDate">Dari</label>

                            <input type="date"
                                id="startDate">
                        </div>

                        <div>
                            <label for="endDate">Sampai</label>

                            <input type="date"
                                id="endDate">
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

                    <option value="Belum Dimulai">
                        Belum Dimulai
                    </option>

                    <option value="Asesmen Instruktur">
                        Asesmen Instruktur
                    </option>

                    <option value="Asesmen Kesehatan Awal">
                        Asesmen Kesehatan Awal
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

                    <option value="Diterima">
                        Diterima
                    </option>

                    <option value="Tidak Diterima">
                        Tidak Diterima
                    </option>

                    <option value="Belum Dimulai">
                        Belum Dimulai
                    </option>

                    <option value="Pending">
                        Pending
                    </option>

                    <option value="Lulus">
                        Lulus
                    </option>

                    <option value="Tidak Lulus">
                        Tidak Lulus
                    </option>

                    <option value="Sedang Diperiksa">
                        Sedang Diperiksa
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
                            | DATA
                            |--------------------------------------------------------------------------
                            |
                            | DATA GOOGLE SHEET:
                            |   [1] nama
                            |   [2] nik
                            |   [6] usia
                            |   [12] jenis ppks
                            |   [14] jurusan
                            |
                            | DATA MANUAL:
                            |   ['nama_lengkap']
                            |   ['nik']
                            |   ['usia']
                            |   ['jenis_ppks']
                            |   ['jurusan_yang_diminati']
                            |
                            | Di sini keduanya didukung.
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
                            | CEK SUMBER DATA
                            |--------------------------------------------------------------------------
                            */

                            $sumberData =
                                $data['sumber_data']
                                ?? null;


                            /*
                            |--------------------------------------------------------------------------
                            | NAMA
                            |--------------------------------------------------------------------------
                            */

                            if (isset($data['nama_lengkap'])) {

                                // DATA MANUAL
                                $nama =
                                    $data['nama_lengkap'];

                            } else {

                                // GOOGLE SHEET
                                $nama =
                                    $data[1] ?? '-';

                            }


                            /*
                            |--------------------------------------------------------------------------
                            | NIK
                            |--------------------------------------------------------------------------
                            */

                            if (isset($data['nik'])) {

                                $nik =
                                    $data['nik'];

                            } else {

                                $nik =
                                    $data[2] ?? '-';

                            }


                            /*
                            |--------------------------------------------------------------------------
                            | UMUR
                            |--------------------------------------------------------------------------
                            */

                            if (
                                isset($data['usia']) &&
                                $data['usia'] !== ''
                            ) {

                                $umur =
                                    $data['usia'];

                            } else {

                                $umur =
                                    $data[6] ?? '-';

                            }


                            /*
                            |--------------------------------------------------------------------------
                            | JENIS PPKS
                            |--------------------------------------------------------------------------
                            */

                            if (isset($data['jenis_ppks'])) {

                                $jenisPpks =
                                    $data['jenis_ppks'];

                            } else {

                                $jenisPpks =
                                    $data[12] ?? '-';

                            }


                            /*
                            |--------------------------------------------------------------------------
                            | JURUSAN
                            |--------------------------------------------------------------------------
                            */

                            if (
                                isset(
                                    $data['jurusan_yang_diminati']
                                )
                            ) {

                                $jurusan =
                                    $data['jurusan_yang_diminati'];

                            } else {

                                $jurusan =
                                    $data[14] ?? '-';

                            }


                            /*
                            |--------------------------------------------------------------------------
                            | PROSES
                            |--------------------------------------------------------------------------
                            |
                            | Ambil proses terbaru.
                            |--------------------------------------------------------------------------
                            */

                            $proses = $item->prosesPesertas
                                ->sortByDesc(function ($p) {

                                    return $p->tanggal_proses
                                        ?? $p->created_at;

                                })
                                ->first();


                            /*
                            |--------------------------------------------------------------------------
                            | TAHAPAN
                            |--------------------------------------------------------------------------
                            */

                            if (!$proses) {

                                $tahapan =
                                    'Belum Dimulai';

                            } else {

                                $tahapan = match (
                                    $proses->tahap
                                ) {

                                    'instruktur' =>
                                        'Asesmen Instruktur',

                                    'kesehatan_awal' =>
                                        'Asesmen Kesehatan Awal',

                                    'case_conference' =>
                                        'Case Conference',

                                    default =>
                                        'Belum Dimulai',

                                };

                            }


                            /*
                            |--------------------------------------------------------------------------
                            | HASIL
                            |--------------------------------------------------------------------------
                            */

                            if (
                                $item->status ===
                                'diterima'
                            ) {

                                $hasil =
                                    'Diterima';

                                $hasilClass =
                                    'accepted';

                                $hasilIcon =
                                    'task_alt';

                            } elseif (
                                $item->status ===
                                'tidak_diterima'
                            ) {

                                $hasil =
                                    'Tidak Diterima';

                                $hasilClass =
                                    'rejected';

                                $hasilIcon =
                                    'cancel';

                            } elseif (!$proses) {

                                $hasil =
                                    'Belum Dimulai';

                                $hasilClass =
                                    'not-done';

                                $hasilIcon =
                                    'progress_activity';

                            } elseif (
                                $proses->status ===
                                'pending'
                            ) {

                                $hasil =
                                    'Pending';

                                $hasilClass =
                                    'pending';

                                $hasilIcon =
                                    'schedule';

                            } elseif (
                                $proses->status ===
                                'lulus'
                            ) {

                                $hasil =
                                    'Lulus';

                                $hasilClass =
                                    'lolos';

                                $hasilIcon =
                                    'check_circle';

                            } elseif (
                                $proses->status ===
                                'tidak_lulus'
                            ) {

                                $hasil =
                                    'Tidak Lulus';

                                $hasilClass =
                                    'rejected';

                                $hasilIcon =
                                    'cancel';

                            } elseif (
                                $proses->status ===
                                'sedang_diperiksa'
                            ) {

                                $hasil =
                                    'Sedang Diperiksa';

                                $hasilClass =
                                    'pending';

                                $hasilIcon =
                                    'pending';

                            } else {

                                $hasil =
                                    ucfirst(
                                        str_replace(
                                            '_',
                                            ' ',
                                            $proses->status
                                        )
                                    );

                                $hasilClass =
                                    'pending';

                                $hasilIcon =
                                    'schedule';

                            }


                            /*
                            |--------------------------------------------------------------------------
                            | KETERANGAN
                            |--------------------------------------------------------------------------
                            */

                            if ($proses) {

                                $keterangan =
                                    $proses->catatan
                                    ?: $proses->alasan_pending
                                    ?: '-';

                            } else {

                                $keterangan =
                                    '-';

                            }


                            /*
                            |--------------------------------------------------------------------------
                            | TANGGAL
                            |--------------------------------------------------------------------------
                            */

                            $tanggal = null;

                            if (
                                $proses &&
                                $proses->tanggal_proses
                            ) {

                                $tanggal =
                                    \Carbon\Carbon::parse(
                                        $proses->tanggal_proses
                                    )->format('Y-m-d');

                            } elseif (
                                $item->created_at
                            ) {

                                $tanggal =
                                    $item->created_at
                                        ->format('Y-m-d');

                            }

                        @endphp


                        <tr
                            data-nama="{{ strtolower($nama) }}"
                            data-nik="{{ strtolower($nik) }}"
                            data-ppks="{{ strtolower($jenisPpks) }}"
                            data-tahapan="{{ strtolower($tahapan) }}"
                            data-hasil="{{ strtolower($hasil) }}"
                            data-tanggal="{{ $tanggal ?? '' }}"
                        >

                            <td class="row-number">
                                {{ $ppks->firstItem() + $index }}
                            </td>

                            <td>
                                {{ $nama }}
                            </td>

                            <td>
                                {{ $nik }}
                            </td>

                            <td>
                                {{ $umur }}
                            </td>

                            <td>
                                {{ $jenisPpks }}
                            </td>

                            <td>
                                {{ $jurusan }}
                            </td>

                            {{-- =====================================================
                            HASIL
                            ====================================================== --}}
                            <td>

                                @if ($item->status === 'diterima')

                                    <a href="{{ route('ppks.normal') }}"
                                        class="result-badge result-accepted">

                                        <span class="material-symbols-outlined result-icon">
                                            task_alt
                                        </span>

                                        <span class="result-title">
                                            Diterima
                                        </span>

                                        <span class="result-arrow">
                                            ›
                                        </span>

                                    </a>


                                @elseif ($item->status === 'tidak_diterima')

                                    <a href="{{ route('ppks.normal') }}"
                                        class="result-badge result-rejected">

                                        <span class="material-symbols-outlined result-icon">
                                            cancel
                                        </span>

                                        <span class="result-title">
                                            Tidak Diterima
                                        </span>

                                        <span class="result-arrow">
                                            ›
                                        </span>

                                    </a>


                                @elseif (!$proses)

                                    {{-- BELUM DIMULAI --}}
                                    <a href="{{ route('ppks.normal.asesmen-instruktur.data-detail', $item->id) }}"
                                        class="result-badge result-not-done">

                                        <span class="material-symbols-outlined result-icon">
                                            progress_activity
                                        </span>

                                        <div class="result-content">

                                            <span class="result-title">
                                                Belum Dilakukan
                                            </span>

                                            <span class="result-status pending">

                                                <span class="status-dot pending"></span>

                                                Belum Dimulai

                                            </span>

                                        </div>

                                        <span class="result-arrow">
                                            ›
                                        </span>

                                    </a>


                                @elseif ($proses->tahap === 'instruktur')

                                    {{-- ASESMEN INSTRUKTUR --}}
                                    <a href="{{ route('ppks.normal.asesmen-instruktur.detail', $item->id) }}"
                                        class="result-badge result-instructor">

                                        <span class="material-symbols-outlined result-icon">
                                            assignment
                                        </span>

                                        <div class="result-content">

                                            <span class="result-title">
                                                Asesmen Instruktur
                                            </span>

                                            <span class="result-status {{ $proses->status }}">

                                                <span class="status-dot {{ $proses->status }}"></span>

                                                {{ ucfirst(
                                                    str_replace(
                                                        '_',
                                                        ' ',
                                                        $proses->status
                                                    )
                                                ) }}

                                            </span>

                                        </div>

                                        <span class="result-arrow">
                                            ›
                                        </span>

                                    </a>


                                @elseif ($proses->tahap === 'kesehatan_awal')

                                    {{-- ASESMEN KESEHATAN --}}
                                    <a href="{{ route('ppks.normal') }}"
                                        class="result-badge result-health">

                                        <span class="material-symbols-outlined result-icon">
                                            medical_services
                                        </span>

                                        <div class="result-content">

                                            <span class="result-title">
                                                Asesmen Kesehatan
                                            </span>

                                            <span class="result-status {{ $proses->status }}">

                                                <span class="status-dot {{ $proses->status }}"></span>

                                                {{ ucfirst(
                                                    str_replace(
                                                        '_',
                                                        ' ',
                                                        $proses->status
                                                    )
                                                ) }}

                                            </span>

                                        </div>

                                        <span class="result-arrow">
                                            ›
                                        </span>

                                    </a>


                                @elseif ($proses->tahap === 'case_conference')

                                    {{-- CASE CONFERENCE --}}
                                    <a href="{{ route('ppks.normal') }}"
                                        class="result-badge result-health">

                                        <span class="material-symbols-outlined result-icon">
                                            groups
                                        </span>

                                        <div class="result-content">

                                            <span class="result-title">
                                                Case Conference
                                            </span>

                                            <span class="result-status {{ $proses->status }}">

                                                <span class="status-dot {{ $proses->status }}"></span>

                                                {{ ucfirst(
                                                    str_replace(
                                                        '_',
                                                        ' ',
                                                        $proses->status
                                                    )
                                                ) }}

                                            </span>

                                        </div>

                                        <span class="result-arrow">
                                            ›
                                        </span>

                                    </a>

                                @endif

                            </td>



                            {{-- =====================================================
                            KETERANGAN
                            ====================================================== --}}
                            <td>
                                {{ $keterangan }}
                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td colspan="8"
                                style="
                                    text-align:center;
                                    padding:40px;
                                    color:#6b7280;
                                ">

                                Data tidak ditemukan.

                            </td>

                        </tr>

                    @endforelse


                    {{-- EMPTY FILTER --}}
                    <tr id="emptyRow"
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

            <div style="margin-top:20px;">
                {{ $ppks->links() }}
            </div>

        @endif

    </div>


    {{-- =====================================================
    JAVASCRIPT
    ====================================================== --}}
    <script>

        document.addEventListener(
            'DOMContentLoaded',
            function () {

                const searchInput =
                    document.getElementById(
                        'searchInput'
                    );

                const ppksFilter =
                    document.getElementById(
                        'ppksFilter'
                    );

                const tahapanFilter =
                    document.getElementById(
                        'tahapanFilter'
                    );

                const hasilFilter =
                    document.getElementById(
                        'hasilFilter'
                    );

                const tableRows =
                    document.querySelectorAll(
                        '.table tbody tr:not(#emptyRow)'
                    );

                const emptyRow =
                    document.getElementById(
                        'emptyRow'
                    );


                const dateFilterButton =
                    document.getElementById(
                        'dateFilterButton'
                    );

                const datePicker =
                    document.getElementById(
                        'datePicker'
                    );

                const dateFilterText =
                    document.getElementById(
                        'dateFilterText'
                    );

                const startDate =
                    document.getElementById(
                        'startDate'
                    );

                const endDate =
                    document.getElementById(
                        'endDate'
                    );

                const applyDate =
                    document.getElementById(
                        'applyDate'
                    );

                const resetDate =
                    document.getElementById(
                        'resetDate'
                    );


                /*
                |--------------------------------------------------------------------------
                | FILTER
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


                    let visibleNumber = {{ $ppks->firstItem() ?? 1 }};
                    let found = false;


                    tableRows.forEach(
                        function (row) {

                            const nama =
                                row.dataset.nama ||
                                '';

                            const nik =
                                row.dataset.nik ||
                                '';

                            const ppks =
                                row.dataset.ppks ||
                                '';

                            const tahapan =
                                row.dataset.tahapan ||
                                '';

                            const hasil =
                                row.dataset.hasil ||
                                '';

                            const tanggal =
                                row.dataset.tanggal ||
                                '';


                            const matchSearch =
                                searchValue === '' ||
                                nama.includes(
                                    searchValue
                                ) ||
                                nik.includes(
                                    searchValue
                                );


                            const matchPpks =
                                ppksValue === '' ||
                                ppks === ppksValue;


                            const matchTahapan =
                                tahapanValue === '' ||
                                tahapan === tahapanValue;


                            const matchHasil =
                                hasilValue === '' ||
                                hasil === hasilValue;


                            let matchDate =
                                true;


                            if (selectedStart) {

                                matchDate =
                                    tanggal !== '' &&
                                    tanggal >=
                                    selectedStart;

                            }


                            if (
                                selectedEnd &&
                                matchDate
                            ) {

                                matchDate =
                                    tanggal !== '' &&
                                    tanggal <=
                                    selectedEnd;

                            }


                            const shouldShow =
                                matchSearch &&
                                matchPpks &&
                                matchTahapan &&
                                matchHasil &&
                                matchDate;


                            if (shouldShow) {

                                row.style.display =
                                    '';

                                const numberCell =
                                    row.querySelector(
                                        '.row-number'
                                    );

                                if (numberCell) {

                                    numberCell.textContent =
                                        visibleNumber;

                                }

                                visibleNumber++;

                                found = true;

                            } else {

                                row.style.display =
                                    'none';

                            }

                        }
                    );


                    if (emptyRow) {

                        emptyRow.style.display =
                            found
                                ? 'none'
                                : 'table-row';

                    }

                }


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


                function formatDate(
                    dateString
                ) {

                    const date =
                        new Date(
                            dateString +
                            'T00:00:00'
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
                | INITIAL FILTER
                |--------------------------------------------------------------------------
                */

                filterTable();

            }
        );

    </script>
    <style>

    /* =========================================================
       HALAMAN DATA CALON PPKS
    ========================================================= */

    .case-conference-page {
        width: 100%;
        min-height: calc(100vh - 80px);

        padding: 18px 14px 30px;

        background: #ffffff;

        box-sizing: border-box;

        border-radius: 0 0 12px 12px;
    }


    /* =========================================================
       HEADER
    ========================================================= */

    .case-conference-header {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 20px;

        margin-bottom: 18px;
    }

    .case-conference-header h1 {
        margin: 0;

        color: #202124;

        font-size: 22x;
        font-weight: 700;

        line-height: 1.3;
    }

    .case-conference-header p {
        margin: 6px 0 0;
        color: #777777;
        font-size: 12px;
        font-weight: 400;
        line-height: 1.5;
    }


    /* =========================================================
       FILTER TANGGAL
    ========================================================= */

    .date-filter-wrapper {
        position: relative;

        flex-shrink: 0;
    }

    .date-filter {
        display: flex;
        align-items: center;
        gap: 9px;

        height: 38px;

        padding: 0 8px;

        border: none;
        background: transparent;

        color: #303030;

        font-size: 14;
        font-weight: 500;

        cursor: pointer;
    }

    .date-filter svg {
        flex-shrink: 0;
    }

    .date-filter svg:first-child {
        color: #333333;
    }

    .date-filter svg:last-child {
        color: #555555;
    }


    /* =========================================================
       DATE PICKER
    ========================================================= */

    .date-picker {
        position: absolute;

        top: calc(100% + 5px);
        right: 0;

        z-index: 100;

        width: 300px;

        padding: 16px;

        background: #ffffff;

        border: 1px solid #d9e0e5;

        border-radius: 10px;

        box-shadow:
            0 8px 25px rgba(0, 0, 0, 0.12);

        display: none;
    }

    .date-picker.active {
        display: block;
    }

    .date-picker-header {
        margin-bottom: 14px;
    }

    .date-picker-header strong {
        color: #303030;

        font-size: 13px;
        font-weight: 600;
    }

    .date-input-group {
        display: grid;

        grid-template-columns: 1fr 1fr;

        gap: 10px;
    }

    .date-input-group label {
        display: block;

        margin-bottom: 5px;

        color: #666666;

        font-size: 11px;
    }

    .date-input-group input {
        width: 100%;
        height: 35px;

        padding: 0 8px;

        border: 1px solid #cbd5dc;

        border-radius: 6px;

        font-size: 11px;

        outline: none;

        box-sizing: border-box;
    }

    .date-input-group input:focus {
        border-color: #286693;
    }

    .date-picker-actions {
        display: flex;
        justify-content: flex-end;

        gap: 7px;

        margin-top: 14px;
    }

    .date-reset,
    .date-apply {
        height: 32px;

        padding: 0 13px;

        border-radius: 6px;

        font-size: 11px;

        cursor: pointer;
    }

    .date-reset {
        border: 1px solid #d1d5db;

        background: #ffffff;

        color: #555555;
    }

    .date-apply {
        border: 1px solid #286693;

        background: #286693;

        color: #ffffff;
    }


    /* =========================================================
       FILTER BAR
    ========================================================= */

    .case-filter-wrapper {
        display: flex;
        align-items: center;

        gap: 8px;

        margin-bottom: 15px;
    }


    /* =========================================================
       SEARCH
    ========================================================= */

    .case-search {
        position: relative;

        width: 243px;

        flex-shrink: 0;
    }

    .case-search svg {
        position: absolute;

        left: 12px;
        top: 50%;

        transform: translateY(-50%);

        color: #a2adb5;

        pointer-events: none;
    }

    .case-search input {
        width: 100%;
        height: 35px;

        padding: 0 12px 0 36px;

        border: 1px solid #82a6be;

        border-radius: 18px;

        background: #ffffff;

        color: #333333;

        font-size: 12x;

        outline: none;

        box-sizing: border-box;
    }

    .case-search input::placeholder {
        color: #9da5ab;
    }

    .case-search input:focus {
        border-color: #286693;

        box-shadow:
            0 0 0 2px rgba(40, 102, 147, 0.08);
    }


    /* =========================================================
       DROPDOWN FILTER
    ========================================================= */

    .select-wrapper {
        position: relative;

        width: 178px;

        flex-shrink: 0;
    }

    .case-filter-button {
        width: 100%;
        height: 35px;

        padding: 0 35px 0 13px;

        appearance: none;
        -webkit-appearance: none;

        border: 1px solid #82a6be;

        border-radius: 18px;

        background: #ffffff;

        color: #555555;

        font-size: 12x;

        outline: none;

        cursor: pointer;

        box-sizing: border-box;
    }

    .case-filter-button:hover,
    .case-filter-button:focus {
        border-color: #286693;
    }

    .select-arrow {
        position: absolute;

        right: 12px;
        top: 50%;

        transform: translateY(-50%);

        color: #555555;

        font-size: 17px;

        pointer-events: none;
    }


    /* =========================================================
       TABLE
    ========================================================= */

    .table-wrapper {
        width: 100%;

        overflow-x: auto;

        border: 1px solid #dce2e6;

        border-radius: 9px 9px 0 0;

        background: #ffffff;
    }

    .table {
        width: 100%;

        min-width: 1000px;

        border-collapse: separate;

        border-spacing: 0;

        table-layout: auto;
    }


    /* =========================================================
       TABLE HEADER
    ========================================================= */

    .table thead {
        background: #286693;
    }

    .table thead tr {
        height: 49px;
    }

    .table th {
        padding: 0 14px;

        border: none;

        color: #ffffff;

        font-size: 12x;

        font-weight: 600;

        text-align: left;

        white-space: nowrap;
    }

    .table th:first-child {
        width: 45px;

        text-align: center;

        border-radius: 8px 0 0 0;
    }

    .table th:nth-child(2) {
        width: 140px;
    }

    .table th:nth-child(3) {
        width: 110px;
    }

    .table th:nth-child(4) {
        width: 70px;
    }

    .table th:nth-child(5) {
        width: 190px;
    }

    .table th:nth-child(6) {
        width: 160px;
    }

    .table th:nth-child(7) {
        width: 190px;
    }

    .table th:last-child {
        width: 150px;

        border-radius: 0 8px 0 0;
    }


    /* =========================================================
       TABLE BODY
    ========================================================= */

    .table tbody tr {
        height: 53px;

        background: #ffffff;
    }

    .table tbody tr:hover {
        background: #fafcfd;
    }

    .table td {
        padding: 9px 14px;

        border-bottom: 1px solid #e8ecef;

        color: #555555;

        font-size: 12x;

        vertical-align: middle;

        white-space: nowrap;
    }

    .table tbody tr:last-child td {
        border-bottom: none;
    }

    .table td:first-child {
        text-align: center;

        color: #555555;
    }

    .row-number {
        font-size: 12x !important;
    }


    /* =========================================================
       HASIL / RESULT BADGE
    ========================================================= */

    .result-badge {
        display: flex;
        align-items: center;

        width: 166px;
        min-height: 35px;

        padding: 5px 8px;

        border-radius: 18px;

        text-decoration: none;

        box-sizing: border-box;

        transition: 0.15s ease;
    }

    .result-badge:hover {
        transform: translateY(-1px);
    }

    .result-icon {
        flex-shrink: 0;

        margin-right: 7px;

        font-size: 16px;
    }

    .result-content {
        display: flex;
        flex-direction: column;

        gap: 1px;

        min-width: 0;
    }

    .result-title {
        color: #444444;

        font-size: 11x;

        font-weight: 500;

        line-height: 1.2;
    }

    .result-status {
        display: flex;
        align-items: center;

        gap: 4px;

        color: #999999;

        font-size: 9px;

        line-height: 1.2;
    }

    .result-arrow {
        margin-left: auto;

        color: #777777;

        font-size: 15px;

        line-height: 1;
    }


    /* =========================================================
       RESULT BACKGROUND
    ========================================================= */

    .result-not-done {
        background: #f1f3f4;

        color: #666666;
    }

    .result-instructor {
        background: #eef4f8;

        color: #286693;
    }

    .result-health {
        background: #eef7f5;

        color: #317c72;
    }

    .result-accepted {
        background: #edf8f2;

        color: #218653;
    }

    .result-rejected {
        background: #fceeee;

        color: #c74747;
    }


    /* =========================================================
       STATUS DOT
    ========================================================= */

    .status-dot {
        width: 4px;
        height: 4px;

        border-radius: 50%;

        display: inline-block;
    }

    .status-dot.pending {
        background: #d99a28;
    }

    .status-dot.lulus {
        background: #36a269;
    }

    .status-dot.tidak_lulus {
        background: #d84d4d;
    }

    .status-dot.sedang_diperiksa {
        background: #8a67bd;
    }


    /* =========================================================
       EMPTY ROW
    ========================================================= */

    #emptyRow td {
        padding: 35px !important;

        color: #8a8f94 !important;

        font-size: 12px !important;
    }


    /* =========================================================
       PAGINATION
    ========================================================= */

    .case-conference-page nav {
        margin-top: 15px;
    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 900px) {

        .case-conference-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .date-filter-wrapper {
            align-self: flex-end;
        }

        .case-filter-wrapper {
            flex-wrap: wrap;
        }

        .case-search {
            width: 243px;
        }
    }


    @media (max-width: 600px) {

        .case-conference-page {
            padding: 15px 10px 25px;
        }

        .case-conference-header h1 {
            font-size: 18px;
        }

        .case-filter-wrapper {
            align-items: stretch;
            flex-direction: column;
        }

        .case-search,
        .select-wrapper {
            width: 100%;
        }

        .date-filter-wrapper {
            width: 100%;
        }

        .date-filter {
            padding-left: 0;
        }

        .date-picker {
            left: 0;
            right: auto;
            width: 100%;
            box-sizing: border-box;
        }
    }

</style>

</x-app-layout>
