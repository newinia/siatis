<x-app-layout>

    <div class="main-page">

        {{-- =====================================================
        HEADER
        ====================================================== --}}
        <div class="main-page-header">

            <div>
                <h1>Data Calon PPKS Belum Asesmen Instruktur</h1>

                <p>
                    Data calon PPKS yang telah diverifikasi dan siap diproses ke tahap asesmen instruktur.
                </p>
            </div>

            {{-- DATE FILTER --}}
            <div class="date-filter-wrapper">

                <button type="button" class="date-filter" id="dateFilterButton">

                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.8">
                        <rect x="3" y="4" width="18" height="18" rx="2" />
                        <path d="M16 2v4" />
                        <path d="M8 2v4" />
                        <path d="M3 10h18" />
                    </svg>

                    <span id="dateFilterText">
                        Pilih Tanggal
                    </span>

                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2">
                        <path d="m6 9 6 6 6-6" />
                    </svg>

                </button>

                {{-- DATE PICKER --}}
                <div class="date-picker" id="datePicker">

                    <div class="date-picker-header">
                        <strong>Pilih Rentang Tanggal</strong>
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

                        <button type="button" id="resetDate" class="date-reset">
                            Reset
                        </button>

                        <button type="button" id="applyDate" class="date-apply">
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

            <div class="filter-group">

                {{-- SEARCH --}}
                <div class="search" id="searchWrapper">

                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="7" />
                        <path d="m20 20-3.5-3.5" />
                    </svg>

                    <input type="text" id="searchInput" placeholder="Cari Nama atau NIK" autocomplete="off">

                </div>


                {{-- FILTER PPKS --}}
                <div class="select-wrapper">

                    <select id="ppksFilter" class="filter-button">

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

                    <select id="tahapanFilter" class="filter-button">

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

                    <select id="hasilFilter" class="filter-button">

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


            {{-- RESET --}}
            <button type="button" id="resetAllFilters" class="filter-reset">

                <span class="material-symbols-outlined">
                    restart_alt
                </span>

                Reset

            </button>

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

                    @if ($ppks->count() > 0)

                        @foreach ($ppks as $index => $item)

                            @php

                                        /*
                                        |--------------------------------------------------------------------------
                                        | DATA PPKS
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
                                        |--------------------------------------------------------------------------
                                        */

                                        if (isset($data['nama_lengkap'])) {
                                            $nama = $data['nama_lengkap'];
                                        } else {
                                            $nama = $data[1] ?? '-';
                                        }


                                        /*
                                        |--------------------------------------------------------------------------
                                        | NIK
                                        |--------------------------------------------------------------------------
                                        */

                                        if (isset($data['nik'])) {
                                            $nik = $data['nik'];
                                        } else {
                                            $nik = $data[2] ?? '-';
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
                                            $umur = $data['usia'];
                                        } else {
                                            $umur = $data[6] ?? '-';
                                        }


                                        /*
                                        |--------------------------------------------------------------------------
                                        | JENIS PPKS
                                        |--------------------------------------------------------------------------
                                        */

                                        if (isset($data['jenis_ppks'])) {
                                            $jenisPpks = $data['jenis_ppks'];
                                        } else {
                                            $jenisPpks = $data[12] ?? '-';
                                        }


                                        /*
                                        |--------------------------------------------------------------------------
                                        | JURUSAN
                                        |--------------------------------------------------------------------------
                                        */

                                        if (isset($data['jurusan_yang_diminati'])) {
                                            $jurusan = $data['jurusan_yang_diminati'];
                                        } else {
                                            $jurusan = $data[14] ?? '-';
                                        }


                                        /*
                                        |--------------------------------------------------------------------------
                                        | PROSES TERBARU
                                        |--------------------------------------------------------------------------
                                        */

                                        $proses = $item->prosesPesertas
                                            ->sortByDesc(function ($p) {
                                                return $p->tanggal_proses ?? $p->created_at;
                                            })
                                            ->first();


                                        /*
                                        |--------------------------------------------------------------------------
                                        | TAHAPAN
                                        |--------------------------------------------------------------------------
                                        */

                                        if (!$proses) {

                                            $tahapan = 'Belum Dimulai';

                                        } elseif ($proses->tahap === 'instruktur') {

                                            $tahapan = 'Asesmen Instruktur';

                                        } elseif ($proses->tahap === 'kesehatan_awal') {

                                            $tahapan = 'Asesmen Kesehatan Awal';

                                        } elseif ($proses->tahap === 'case_conference') {

                                            $tahapan = 'Case Conference';

                                        } else {

                                            $tahapan = 'Belum Dimulai';

                                        }


                                        /*
                                        |--------------------------------------------------------------------------
                                        | HASIL
                                        |--------------------------------------------------------------------------
                                        */

                                        if ($item->status === 'diterima') {

                                            $hasil = 'Diterima';
                                            $hasilClass = 'diterima';
                                            $hasilIcon = 'task_alt';

                                        } elseif ($item->status === 'tidak_diterima') {

                                            $hasil = 'Tidak Diterima';
                                            $hasilClass = 'tidak-diterima';
                                            $hasilIcon = 'cancel';

                                        } elseif (!$proses) {

                                            $hasil = 'Belum Dimulai';
                                            $hasilClass = 'pending';
                                            $hasilIcon = 'progress_activity';

                                        } elseif ($proses->status === 'pending') {

                                            $hasil = 'Pending';
                                            $hasilClass = 'pending';
                                            $hasilIcon = 'schedule';

                                        } elseif ($proses->status === 'lulus') {

                                            $hasil = 'Lulus';
                                            $hasilClass = 'lolos';
                                            $hasilIcon = 'check_circle';

                                        } elseif ($proses->status === 'tidak_lulus') {

                                            $hasil = 'Tidak Lulus';
                                            $hasilClass = 'tidak-lolos';
                                            $hasilIcon = 'cancel';

                                        } elseif ($proses->status === 'sedang_diperiksa') {

                                            $hasil = 'Sedang Diperiksa';
                                            $hasilClass = 'pending';
                                            $hasilIcon = 'pending';

                                        } else {

                                            $hasil = ucfirst(
                                                str_replace(
                                                    '_',
                                                    ' ',
                                                    $proses->status
                                                )
                                            );

                                            $hasilClass = 'pending';
                                            $hasilIcon = 'schedule';

                                        }


                                        /*
                                        |--------------------------------------------------------------------------
                                        | KETERANGAN
                                        |--------------------------------------------------------------------------
                                        */

                                        if (!$proses) {

                                            $keterangan = 'Menunggu asesmen instruktur';

                                        } else {

                                            $keterangan = $proses->catatan
                                                ?: $proses->alasan_pending
                                                ?: '-';

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

                                            $tanggal = \Carbon\Carbon::parse(
                                                $proses->tanggal_proses
                                            )->format('Y-m-d');

                                        } elseif ($item->created_at) {

                                            $tanggal = $item->created_at->format('Y-m-d');

                                        }

                            @endphp


                            <tr data-nama="{{ strtolower($nama) }}" data-nik="{{ strtolower($nik) }}"
                                data-ppks="{{ strtolower($jenisPpks) }}" data-tahapan="{{ strtolower($tahapan) }}"
                                data-hasil="{{ strtolower($hasil) }}" data-tanggal="{{ $tanggal ?? '' }}">

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

                                    @if ($item->status === 'diterima')

                                        <a href="{{ route('ppks.normal') }}" class="result-badge result-accepted">

                                            <span class="material-symbols-outlined result-icon">
                                                task_alt
                                            </span>

                                            <div class="result-content">

                                                <span class="result-title">
                                                    Diterima
                                                </span>

                                            </div>

                                            <span class="result-arrow">
                                                ›
                                            </span>

                                        </a>

                                    @elseif ($item->status === 'tidak_diterima')

                                        <a href="{{ route('ppks.normal') }}" class="result-badge result-rejected">

                                            <span class="material-symbols-outlined result-icon">
                                                cancel
                                            </span>

                                            <div class="result-content">

                                                <span class="result-title">
                                                    Tidak Diterima
                                                </span>

                                            </div>

                                            <span class="result-arrow">
                                                ›
                                            </span>

                                        </a>

                                    @elseif (!$proses)

                                        <a href="{{ route('ppks.normal.asesmen-instruktur.data-detail', $item->id) }}"
                                            class="result-badge result-not-done">

                                            <span class="material-symbols-outlined result-icon">
                                                progress_activity
                                            </span>

                                            <div class="result-content">

                                                <span class="result-title">
                                                    Belum Dilakukan
                                                </span>

                                                <span class="result-status belum-dimulai">

                                                    <span class="status-dot belum-dimulai"></span>

                                                    Belum Dimulai

                                                </span>

                                            </div>

                                            <span class="result-arrow">
                                                ›
                                            </span>

                                        </a>

                                    @elseif ($proses->tahap === 'instruktur')

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

                                                    {{ ucfirst(str_replace('_', ' ', $proses->status)) }}

                                                </span>

                                            </div>

                                            <span class="result-arrow">
                                                ›
                                            </span>

                                        </a>

                                    @elseif ($proses->tahap === 'kesehatan_awal')

                                        <a href="{{ route('ppks.normal') }}" class="result-badge result-health">

                                            <span class="material-symbols-outlined result-icon">
                                                medical_services
                                            </span>

                                            <div class="result-content">

                                                <span class="result-title">
                                                    Asesmen Kesehatan Awal
                                                </span>

                                                <span class="result-status {{ $proses->status }}">

                                                    <span class="status-dot {{ $proses->status }}"></span>

                                                    {{ ucfirst(str_replace('_', ' ', $proses->status)) }}

                                                </span>

                                            </div>

                                            <span class="result-arrow">
                                                ›
                                            </span>

                                        </a>

                                    @elseif ($proses->tahap === 'case_conference')

                                        <a href="{{ route('ppks.normal') }}" class="result-badge result-case-conference">

                                            <span class="material-symbols-outlined result-icon">
                                                groups
                                            </span>

                                            <div class="result-content">

                                                <span class="result-title">
                                                    Case Conference
                                                </span>

                                                <span class="result-status {{ $proses->status }}">

                                                    <span class="status-dot {{ $proses->status }}"></span>

                                                    {{ ucfirst(str_replace('_', ' ', $proses->status)) }}

                                                </span>

                                            </div>

                                            <span class="result-arrow">
                                                ›
                                            </span>

                                        </a>

                                    @endif

                                </td>


                                {{-- KETERANGAN --}}
                                <td>
                                    {{ $keterangan }}
                                </td>

                            </tr>

                        @endforeach

                    @else

                        <tr>

                            <td colspan="8" style="
                                        text-align:center;
                                        padding:40px;
                                        color:#6b7280;
                                    ">
                                Data tidak ditemukan.
                            </td>

                        </tr>

                    @endif


                    {{-- EMPTY FILTER --}}
                    <tr id="emptyRow" style="display:none;">

                        <td colspan="8" style="
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
        @if ($ppks instanceof \Illuminate\Pagination\LengthAwarePaginator)

            <div class="pagination-wrapper">
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
                    document.getElementById('searchInput');

                const searchWrapper =
                    document.getElementById('searchWrapper');

                const ppksFilter =
                    document.getElementById('ppksFilter');

                const tahapanFilter =
                    document.getElementById('tahapanFilter');

                const hasilFilter =
                    document.getElementById('hasilFilter');

                const resetAllFilters =
                    document.getElementById('resetAllFilters');

                const tableRows =
                    document.querySelectorAll(
                        '.table tbody tr:not(#emptyRow)'
                    );

                const emptyRow =
                    document.getElementById('emptyRow');


                /* =====================================================
                   DATE
                ====================================================== */

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


                /* =====================================================
                   FILTER STATE
                ====================================================== */

                function updateFilterState() {

                    searchWrapper.classList.toggle(
                        'active',
                        searchInput.value.trim() !== ''
                    );

                    ppksFilter.classList.toggle(
                        'active',
                        ppksFilter.value !== ''
                    );

                    tahapanFilter.classList.toggle(
                        'active',
                        tahapanFilter.value !== ''
                    );

                    hasilFilter.classList.toggle(
                        'active',
                        hasilFilter.value !== ''
                    );

                }


                /* =====================================================
                   FILTER TABLE
                ====================================================== */

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


                    let visibleNumber =
                        {{ $ppks->firstItem() ?? 1 }};

                    let found = false;


                    tableRows.forEach(
                        function (row) {

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


                            /* SEARCH */

                            const matchSearch =
                                searchValue === '' ||
                                nama.includes(searchValue) ||
                                nik.includes(searchValue);


                            /* PPKS */

                            const matchPpks =
                                ppksValue === '' ||
                                ppks.includes(ppksValue);


                            /* TAHAPAN */

                            const matchTahapan =
                                tahapanValue === '' ||
                                tahapan === tahapanValue;


                            /* HASIL */

                            const matchHasil =
                                hasilValue === '' ||
                                hasil === hasilValue;


                            /* DATE */

                            let matchDate = true;

                            if (selectedStart) {

                                matchDate =
                                    tanggal !== '' &&
                                    tanggal >= selectedStart;

                            }

                            if (
                                selectedEnd &&
                                matchDate
                            ) {

                                matchDate =
                                    tanggal !== '' &&
                                    tanggal <= selectedEnd;

                            }


                            /* FINAL */

                            const shouldShow =
                                matchSearch &&
                                matchPpks &&
                                matchTahapan &&
                                matchHasil &&
                                matchDate;


                            if (shouldShow) {

                                row.style.display = '';

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

                                row.style.display = 'none';

                            }

                        }
                    );


                    if (emptyRow) {

                        emptyRow.style.display =
                            found
                                ? 'none'
                                : 'table-row';

                    }


                    updateFilterState();

                }


                /* =====================================================
                   EVENTS
                ====================================================== */

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


                /* =====================================================
                   RESET ALL
                ====================================================== */

                resetAllFilters.addEventListener(
                    'click',
                    function () {

                        searchInput.value = '';

                        ppksFilter.value = '';

                        tahapanFilter.value = '';

                        hasilFilter.value = '';

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


                /* =====================================================
                   DATE PICKER
                ====================================================== */

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


                /* =====================================================
                   APPLY DATE
                ====================================================== */

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


                /* =====================================================
                   RESET DATE
                ====================================================== */

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


                /* =====================================================
                   FORMAT DATE
                ====================================================== */

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


                /* =====================================================
                   CLICK OUTSIDE
                ====================================================== */

                document.addEventListener(
                    'click',
                    function () {

                        datePicker.classList.remove(
                            'active'
                        );

                    }
                );


                /* =====================================================
                   INITIAL
                ====================================================== */

                filterTable();

            }
        );

    </script>

</x-app-layout>