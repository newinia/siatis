<x-app-layout>

    <div class="main-page">

        {{-- =====================================================
        HEADER
        ====================================================== --}}

        <div class="main-page-header">

            <div>

                <h1>
                    Case Conference
                </h1>

                <p>
                    Data peserta yang telah melaksanakan Case Conference.
                </p>

            </div>


            {{-- =====================================================
            DATE FILTER
            ====================================================== --}}

            <div class="date-filter-wrapper">

                <button type="button" class="date-filter" id="dateFilterButton">

                    <span class="material-symbols-outlined">
                        calendar_month
                    </span>

                    <span id="dateFilterText">
                        Pilih Tanggal
                    </span>

                    <span class="material-symbols-outlined">
                        expand_more
                    </span>

                </button>


                <div class="date-picker" id="datePicker">

                    <div class="date-picker-header">

                        <span class="material-symbols-outlined">
                            calendar_month
                        </span>

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


                {{-- =================================================
                SEARCH
                ================================================== --}}

                <div class="search">

                    <span class="material-symbols-outlined">
                        search
                    </span>

                    <input type="text" id="searchInput" placeholder="Cari Nama atau NIK" autocomplete="off">

                </div>


                {{-- =================================================
                FILTER JENIS PPKS
                ================================================== --}}

                <div class="select-wrapper">

                    <select id="ppksFilter" class="filter-button">

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

                        <option value="other">
                            Other
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

                    <select id="hasilFilter" class="filter-button">

                        <option value="">
                            Semua Hasil
                        </option>

                        <option value="diterima">
                            Diterima
                        </option>

                        <option value="tidak diterima">
                            Tidak Diterima
                        </option>

                        <option value="pending">
                            Pending
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


                <tbody id="caseTableBody">

                    @forelse ($data as $index => $ppks)

                                        @php

                                                /*
                                                |--------------------------------------------------------------------------
                                                | DATA PESERTA
                                                |--------------------------------------------------------------------------
                                                */

                                                $item = is_array($ppks->data)
                                                    ? $ppks->data
                                                    : [];


                                                /*
                                                |--------------------------------------------------------------------------
                                                | NAMA
                                                |--------------------------------------------------------------------------
                                                */

                                                $nama =
                                                    $item['nama_lengkap']
                                                    ?? $item['nama']
                                                    ?? $item['Nama']
                                                    ?? $item['NAMA']
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

                                                $umur = '-';

                                                if (!empty($item['tanggal_lahir'])) {

                                                    try {

                                                        $umur =
                                                            \Carbon\Carbon::parse(
                                                                $item['tanggal_lahir']
                                                            )->age . ' tahun';

                                                    } catch (\Exception $e) {

                                                        $umur =
                                                            $item['usia']
                                                            ?? '-';

                                                    }

                                                } elseif (!empty($item['usia'])) {

                                                    $umur =
                                                        $item['usia'] . ' tahun';

                                                }


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
                                                    $item['jurusan_diterima']
                                                    ?? $item['jurusan']
                                                    ?? $item['Jurusan']
                                                    ?? $item['JURUSAN']
                                                    ?? $item['jurusan_yang_diminati']
                                                    ?? '-';


                                                /*
                                            |--------------------------------------------------------------------------
                                            | CASE CONFERENCE
                                            |--------------------------------------------------------------------------
                                            */

                                                $caseConference =
                                                    $ppks->prosesPesertas
                                                        ->where('tahap', 'case_conference')
                                                        ->sortByDesc(function ($proses) {

                                                            return $proses->tanggal_proses
                                                                ?? $proses->created_at;

                                                        })
                                                        ->first();


                                                /*
                                                |--------------------------------------------------------------------------
                                                | STATUS CASE CONFERENCE
                                                |--------------------------------------------------------------------------
                                                */

                                                $status =
                                                    $caseConference?->status
                                                    ?? 'pending';


                                                $statusLower =
                                                    strtolower(
                                                        trim(
                                                            str_replace(
                                                                '-',
                                                                '_',
                                                                $status
                                                            )
                                                        )
                                                    );


                                                /*
                                                |--------------------------------------------------------------------------
                                                | HASIL CASE CONFERENCE
                                                |--------------------------------------------------------------------------
                                                */

                                                if (
                                                    in_array(
                                                        $statusLower,
                                                        [
                                                            'diterima',
                                                            'lulus',
                                                            'accepted'
                                                        ]
                                                    )
                                                ) {

                                                    $hasilText = 'Diterima';

                                                    $statusClass = 'diterima';

                                                    $icon = 'groups';

                                                } elseif (
                                                    in_array(
                                                        $statusLower,
                                                        [
                                                            'tidak_diterima',
                                                            'tidak_lulus',
                                                            'ditolak',
                                                            'tidak lulus',
                                                            'rejected'
                                                        ]
                                                    )
                                                ) {

                                                    $hasilText = 'Tidak Diterima';

                                                    $statusClass = 'tidak-diterima';

                                                    $icon = 'groups';

                                                } else {

                                                    $hasilText = 'Pending';

                                                    $statusClass = 'pending';

                                                    $icon = 'groups';

                                                }


                                                /*
                                                |--------------------------------------------------------------------------
                                                | TANGGAL CASE CONFERENCE
                                                |--------------------------------------------------------------------------
                                                */

                                                $tanggal =
                                                    $caseConference?->tanggal_proses
                                                    ?? $caseConference?->created_at
                                                    ?? null;


                                                $tanggalFilter =
                                                    $tanggal
                                                    ? \Carbon\Carbon::parse($tanggal)->format('Y-m-d')
                                                    : '';


                                                /*
                                                |--------------------------------------------------------------------------
                                                | KETERANGAN
                                                |--------------------------------------------------------------------------
                                                |
                                                | Diambil langsung dari field "catatan"
                                                | pada proses Case Conference terbaru.
                                                |
                                                */

                                                $keterangan =
                                                    $caseConference?->catatan
                                                    ?? '-';

                                        @endphp


                                        <tr class="case-row" data-nama="{{ strtolower($nama) }}" data-nik="{{ strtolower($nik) }}"
                                            data-ppks="{{ strtolower($jenisPpks) }}" data-hasil="{{ strtolower($hasilText) }}"
                                            data-tanggal="{{ $tanggalFilter }}">


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

                                                <a href="{{ route(
                            'ppks.normal.case-conference.detail',
                            $ppks->id
                        ) }}" class="result-badge result-case-conference">

                                                    {{-- ICON CASE CONFERENCE --}}

                                                    <span class="material-symbols-outlined result-icon">
                                                        {{ $icon }}
                                                    </span>


                                                    {{-- CONTENT --}}

                                                    <div class="result-content">

                                                        <span class="result-title">
                                                            Case Conference
                                                        </span>


                                                        <span class="result-status {{ $statusClass }}">

                                                            <span class="status-dot {{ $statusClass }}"></span>

                                                            {{ $hasilText }}

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

                                                @if ($statusClass === 'diterima')

                                                    <span class="keterangan-lolos">
                                                        {{ $keterangan }}
                                                    </span>

                                                @elseif ($statusClass === 'tidak-diterima')

                                                    <span class="keterangan-tidak-lolos">
                                                        {{ $keterangan }}
                                                    </span>

                                                @else

                                                    <span class="keterangan-pending">
                                                        {{ $keterangan }}
                                                    </span>

                                                @endif

                                            </td>

                                        </tr>


                    @empty

                        <tr id="emptyRow">

                            <td colspan="8" style="text-align:center; padding:40px;">

                                <div class="empty-state">

                                    <span class="material-symbols-outlined">
                                        event_busy
                                    </span>

                                    <p>
                                        Belum ada peserta yang telah melakukan Case Conference.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse


                    {{-- =================================================
                    EMPTY HASIL FILTER
                    ================================================== --}}

                    @if ($data->count())

                        <tr id="filterEmptyRow" style="display:none;">

                            <td colspan="8" style="text-align:center; padding:40px;">

                                <div class="empty-state">

                                    <span class="material-symbols-outlined">
                                        search_off
                                    </span>

                                    <p>
                                        Data tidak ditemukan.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endif

                </tbody>

            </table>


            {{-- =================================================
            PAGINATION
            ================================================== --}}

            @if ($data->hasPages())

                <div class="pagination-wrapper">

                    {{ $data->links() }}

                </div>

            @endif

        </div>

    </div>

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const searchInput =
                document.getElementById('searchInput');

            const ppksFilter =
                document.getElementById('ppksFilter');

            const hasilFilter =
                document.getElementById('hasilFilter');

            const tableRows =
                document.querySelectorAll('.case-row');

            const filterEmptyRow =
                document.getElementById('filterEmptyRow');


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


            /* =================================================
               FILTER TABLE
            ================================================== */

            function filterTable() {

                const searchValue =
                    searchInput
                        ? searchInput.value
                            .toLowerCase()
                            .trim()
                        : '';


                const ppksValue =
                    ppksFilter
                        ? ppksFilter.value
                            .toLowerCase()
                            .trim()
                        : '';


                const hasilValue =
                    hasilFilter
                        ? hasilFilter.value
                            .toLowerCase()
                            .trim()
                        : '';


                const selectedStart =
                    startDate
                        ? startDate.value
                        : '';


                const selectedEnd =
                    endDate
                        ? endDate.value
                        : '';


                let found = false;


                tableRows.forEach(function (row) {

                    const nama =
                        row.dataset.nama || '';

                    const nik =
                        row.dataset.nik || '';

                    const ppks =
                        row.dataset.ppks || '';

                    const hasil =
                        row.dataset.hasil || '';

                    const tanggal =
                        row.dataset.tanggal || '';


                    /* =========================================
                       SEARCH
                    ========================================== */

                    const matchSearch =
                        searchValue === '' ||
                        nama.includes(searchValue) ||
                        nik.includes(searchValue);


                    /* =========================================
                       JENIS PPKS
                    ========================================== */

                    const matchPpks =
                        ppksValue === '' ||
                        ppks.includes(ppksValue);


                    /* =========================================
                       HASIL
                    ========================================== */

                    const matchHasil =
                        hasilValue === '' ||
                        hasil === hasilValue;


                    /* =========================================
                       DATE
                    ========================================== */

                    let matchDate = true;


                    if (selectedStart) {

                        matchDate =
                            tanggal !== '' &&
                            tanggal >= selectedStart;

                    }


                    if (selectedEnd && matchDate) {

                        matchDate =
                            tanggal !== '' &&
                            tanggal <= selectedEnd;

                    }


                    /* =========================================
                       FINAL
                    ========================================== */

                    const shouldShow =
                        matchSearch &&
                        matchPpks &&
                        matchHasil &&
                        matchDate;


                    if (shouldShow) {

                        row.style.display = '';

                        found = true;

                    } else {

                        row.style.display = 'none';

                    }

                });


                /* =============================================
                   EMPTY FILTER
                ============================================== */

                if (filterEmptyRow) {

                    filterEmptyRow.style.display =
                        found
                            ? 'none'
                            : 'table-row';

                }

            }


            /* =================================================
               SEARCH
            ================================================== */

            if (searchInput) {

                searchInput.addEventListener(
                    'input',
                    filterTable
                );

            }


            /* =================================================
               FILTER PPKS
            ================================================== */

            if (ppksFilter) {

                ppksFilter.addEventListener(
                    'change',
                    filterTable
                );

            }


            /* =================================================
               FILTER HASIL
            ================================================== */

            if (hasilFilter) {

                hasilFilter.addEventListener(
                    'change',
                    filterTable
                );

            }


            /* =================================================
               DATE PICKER
            ================================================== */

            if (dateFilterButton && datePicker) {

                dateFilterButton.addEventListener(
                    'click',
                    function (event) {

                        event.stopPropagation();

                        datePicker.classList.toggle(
                            'active'
                        );

                    }
                );

            }


            if (datePicker) {

                datePicker.addEventListener(
                    'click',
                    function (event) {

                        event.stopPropagation();

                    }
                );

            }


            /* =================================================
               APPLY DATE
            ================================================== */

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

            }


            /* =================================================
               RESET DATE
            ================================================== */

            if (resetDate) {

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

            }


            /* =================================================
               FORMAT DATE
            ================================================== */

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


            /* =================================================
               CLICK OUTSIDE DATE PICKER
            ================================================== */

            document.addEventListener(
                'click',
                function () {

                    if (datePicker) {

                        datePicker.classList.remove(
                            'active'
                        );

                    }

                }
            );


            /* =================================================
               INITIAL FILTER
            ================================================== */

            filterTable();

        });

    </script>

</x-app-layout>