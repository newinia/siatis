<x-app-layout>

    <div class="main-page">

        {{-- =====================================================
        HEADER
        ======================================================= --}}
        <div class="main-page-header">

            <div>

                <h1>Data Kesehatan Lanjutan</h1>

                <p>
                    Data peserta yang telah datang dan siap mengikuti asesmen kesehatan lanjutan.
                </p>

            </div>


            {{-- =====================================================
            DATE FILTER
            ======================================================= --}}
            <div class="date-filter-wrapper">

                <button
                    type="button"
                    class="date-filter"
                    id="dateFilterButton"
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
                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                        <path d="M16 2v4"/>
                        <path d="M8 2v4"/>
                        <path d="M3 10h18"/>
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
                        <path d="m6 9 6 6 6-6"/>
                    </svg>

                </button>


                {{-- DATE PICKER --}}
                <div
                    class="date-picker"
                    id="datePicker"
                >

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

                            <input
                                type="date"
                                id="startDate"
                            >

                        </div>


                        <div>

                            <label for="endDate">
                                Sampai
                            </label>

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
        FILTER
        ======================================================= --}}
        <div class="filter-wrapper">


            {{-- SEARCH --}}
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
                    <circle cx="11" cy="11" r="7"/>
                    <path d="m20 20-3.5-3.5"/>
                </svg>

                <input
                    type="text"
                    id="searchInput"
                    placeholder="Cari Nama atau NIK"
                    autocomplete="off"
                >

            </div>


            {{-- FILTER PPKS --}}
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


            {{-- FILTER TAHAPAN --}}
            <div class="select-wrapper">

                <select
                    id="tahapanFilter"
                    class="filter-button"
                >

                    <option value="">
                        Semua Jenis Tahapan
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

                    <option value="Asesmen Kesehatan Lanjutan">
                        Asesmen Kesehatan Lanjutan
                    </option>

                </select>

                <span class="material-symbols-outlined select-arrow">
                    keyboard_arrow_down
                </span>

            </div>


            {{-- FILTER HASIL --}}
            <div class="select-wrapper">

                <select
                    id="hasilFilter"
                    class="filter-button"
                >

                    <option value="">
                        Semua Hasil
                    </option>

                    <option value="Belum Dimulai">
                        Belum Dimulai
                    </option>

                    <option value="Belum Asesmen">
                        Belum Asesmen
                    </option>

                    <option value="Lulus">
                        Lulus
                    </option>

                    <option value="Tidak Lulus">
                        Tidak Lulus
                    </option>

                    <option value="Pending">
                        Pending
                    </option>

                    <option value="Diterima">
                        Diterima
                    </option>

                    <option value="Tidak Diterima">
                        Tidak Diterima
                    </option>

                </select>

                <span class="material-symbols-outlined select-arrow">
                    keyboard_arrow_down
                </span>

            </div>

        </div>


        {{-- =====================================================
        TABLE
        ======================================================= --}}
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
                            | DATA JSON PPKS
                            |--------------------------------------------------------------------------
                            */

                            $data = is_array($peserta->data)
                                ? $peserta->data
                                : [];


                            /*
                            |--------------------------------------------------------------------------
                            | NAMA
                            |--------------------------------------------------------------------------
                            */

                            $nama =
                                $data['nama_lengkap']
                                ?? $data['nama']
                                ?? $data['Nama Lengkap']
                                ?? '-';


                            /*
                            |--------------------------------------------------------------------------
                            | NIK
                            |--------------------------------------------------------------------------
                            */

                            $nik =
                                $data['nik']
                                ?? $data['NIK']
                                ?? '-';


                            /*
                            |--------------------------------------------------------------------------
                            | UMUR
                            |--------------------------------------------------------------------------
                            */

                            $umur =
                                $data['usia']
                                ?? $data['umur']
                                ?? '-';


                            /*
                            |--------------------------------------------------------------------------
                            | JENIS PPKS
                            |--------------------------------------------------------------------------
                            */

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


                            /*
                            |--------------------------------------------------------------------------
                            | JURUSAN
                            |--------------------------------------------------------------------------
                            */

                            $jurusan =
                                $caseConference?->jurusan_diterima
                                ?? '-';


                            /*
                            |--------------------------------------------------------------------------
                            | TANGGAL KEDATANGAN
                            |--------------------------------------------------------------------------
                            */

                            $tanggal =
                                $peserta->pemanggilanPeserta?->tanggal_kedatangan;


                            /*
                            |--------------------------------------------------------------------------
                            | ROUTE DETAIL
                            |--------------------------------------------------------------------------
                            */

                            $route =
                                route(
                                    'ppks.normal.kesehatan-lanjutan.detail',
                                    $peserta
                                );


                            /*
                            |--------------------------------------------------------------------------
                            | AMBIL PROSES PESERTA
                            |--------------------------------------------------------------------------
                            */

                            $proses =
                                $peserta->prosesPesertas ?? collect();


                            /*
                            |--------------------------------------------------------------------------
                            | CARI TAHAPAN TERAKHIR
                            |--------------------------------------------------------------------------
                            |
                            | Urutan prioritas:
                            |
                            | 1. Asesmen Kesehatan Lanjutan
                            | 2. Case Conference
                            | 3. Asesmen Kesehatan Awal
                            | 4. Asesmen Instruktur
                            |
                            | Jadi yang ditampilkan hanya tahapan terakhir.
                            |
                            */

                            $prosesTerakhir = null;
                            $tahapTerakhir = null;


                            foreach ($proses as $item) {

                                $tahap =
                                    strtolower(
                                        trim(
                                            (string) ($item->tahap ?? '')
                                        )
                                    );


                                if (in_array($tahap, [
                                    'kesehatan_lanjutan',
                                    'kesehatan lanjutan',
                                    'asesmen_kesehatan_lanjutan',
                                    'asesmen kesehatan lanjutan',
                                ], true)) {

                                    $tahapKey = 'kesehatan_lanjutan';

                                } elseif (in_array($tahap, [
                                    'case_conference',
                                    'case-conference',
                                    'case conference',
                                    'cc',
                                ], true)) {

                                    $tahapKey = 'case_conference';

                                } elseif (in_array($tahap, [
                                    'kesehatan',
                                    'kesehatan_awal',
                                    'asesmen_kesehatan_awal',
                                    'asesmen kesehatan awal',
                                ], true)) {

                                    $tahapKey = 'kesehatan_awal';

                                } elseif (in_array($tahap, [
                                    'instruktur',
                                    'asesmen_instruktur',
                                    'asesmen instruktur',
                                ], true)) {

                                    $tahapKey = 'instruktur';

                                } else {

                                    continue;

                                }


                                /*
                                | Tentukan tahapan berdasarkan urutan.
                                */

                                $urutan = [
                                    'instruktur' => 1,
                                    'kesehatan_awal' => 2,
                                    'case_conference' => 3,
                                    'kesehatan_lanjutan' => 4,
                                ];


                                /*
                                | Kalau tahap ini lebih tinggi dari
                                | tahap sebelumnya, jadikan tahap terakhir.
                                */

                                if (
                                    !$tahapTerakhir ||
                                    $urutan[$tahapKey] >
                                    $urutan[$tahapTerakhir]
                                ) {

                                    $tahapTerakhir = $tahapKey;

                                    $prosesTerakhir = $item;

                                }

                            }


                            /*
                            |--------------------------------------------------------------------------
                            | DEFAULT TAHAPAN
                            |--------------------------------------------------------------------------
                            */

                            if (!$tahapTerakhir) {

                                $tahapTerakhir =
                                    'kesehatan_lanjutan';

                            }


                            /*
                            |--------------------------------------------------------------------------
                            | TENTUKAN LABEL TAHAPAN
                            |--------------------------------------------------------------------------
                            */

                            $labelTahapan = match ($tahapTerakhir) {

                                'instruktur' =>
                                    'Asesmen Instruktur',

                                'kesehatan_awal' =>
                                    'Asesmen Kesehatan Awal',

                                'case_conference' =>
                                    'Case Conference',

                                'kesehatan_lanjutan' =>
                                    'Asesmen Kesehatan Lanjutan',

                                default =>
                                    'Asesmen Kesehatan Lanjutan',

                            };


                            /*
                            |--------------------------------------------------------------------------
                            | HASIL & KETERANGAN
                            |--------------------------------------------------------------------------
                            */

                            if (!$prosesTerakhir) {

                                $hasil = 'Belum Dimulai';

                                $keterangan =
                                    'Peserta belum memulai proses asesmen.';

                                $hasilClass = 'pending';
                                $hasilIcon = 'schedule';

                            } else {

                                $status =
                                    strtolower(
                                        trim(
                                            (string) ($prosesTerakhir->status ?? '')
                                        )
                                    );


                                if ($status === 'lulus') {

                                    $hasil = 'Lulus';
                                    $keterangan =
                                        $prosesTerakhir->catatan
                                        ?? 'Peserta dinyatakan lulus pada tahap ini.';

                                    $hasilClass = 'accepted';
                                    $hasilIcon = 'check_circle';

                                } elseif ($status === 'tidak_lulus') {

                                    $hasil = 'Tidak Lulus';
                                    $keterangan =
                                        $prosesTerakhir->catatan
                                        ?? 'Peserta dinyatakan tidak lulus pada tahap ini.';

                                    $hasilClass = 'rejected';
                                    $hasilIcon = 'cancel';

                                } elseif ($status === 'pending') {

                                    $hasil = 'Pending';
                                    $keterangan =
                                        $prosesTerakhir->catatan
                                        ?? 'Proses asesmen masih menunggu.';

                                    $hasilClass = 'pending';
                                    $hasilIcon = 'schedule';

                                } elseif (in_array($status, [
                                    'sedang_diperiksa',
                                    'sedang-diperiksa',
                                    'sedang diperiksa',
                                ], true)) {

                                    $hasil = 'Sedang Pengecekan';
                                    $keterangan =
                                        $prosesTerakhir->catatan
                                        ?? 'Peserta sedang dalam proses pemeriksaan.';

                                    $hasilClass = 'instructor';
                                    $hasilIcon = 'progress_activity';

                                } else {

                                    $hasil = 'Belum Asesmen';
                                    $keterangan =
                                        $prosesTerakhir->catatan
                                        ?? 'Peserta belum mengikuti asesmen pada tahap ini.';

                                    $hasilClass = 'pending';
                                    $hasilIcon = 'progress_activity';

                                }

                            }


                            /*
                            |--------------------------------------------------------------------------
                            | DATA ATTRIBUTE FILTER
                            |--------------------------------------------------------------------------
                            */

                            $tahapanFilterValue =
                                strtolower($labelTahapan);

                            $hasilFilterValue =
                                strtolower($hasil);

                        @endphp


                        <tr
                            data-nama="{{ strtolower($nama) }}"
                            data-nik="{{ strtolower($nik) }}"
                            data-ppks="{{ strtolower($jenisPpks) }}"
                            data-tahapan="{{ $tahapanFilterValue }}"
                            data-hasil="{{ $hasilFilterValue }}"
                            data-tanggal="{{ $tanggal ?? '' }}"
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


                            {{-- =====================================================
                            HASIL
                            ======================================================= --}}
                            <td>

                                <a
                                    href="{{ $route }}"
                                    class="result-badge result-{{ $hasilClass }}"
                                >

                                    <span class="material-symbols-outlined result-icon">
                                        {{ $hasilIcon }}
                                    </span>

                                    <div class="result-content">

                                        <span class="result-title">
                                            {{ $labelTahapan }}
                                        </span>

                                        <span class="result-status {{ $hasilClass }}">

                                            <span class="status-dot {{ $hasilClass }}"></span>

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
                                {{ $keterangan }}
                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td
                                colspan="8"
                                style="
                                    text-align: center;
                                    padding: 40px;
                                    color: #6b7280;
                                "
                            >
                                Belum ada peserta yang menunggu
                                Kesehatan Lanjutan.
                            </td>

                        </tr>

                    @endforelse


                    {{-- =====================================================
                    DATA TIDAK DITEMUKAN
                    ======================================================= --}}
                    <tr
                        id="emptyRow"
                        style="display: none;"
                    >

                        <td
                            colspan="8"
                            style="
                                text-align: center;
                                padding: 40px;
                                color: #6b7280;
                            "
                        >
                            Data tidak ditemukan.
                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>


    {{-- =====================================================
    JAVASCRIPT
    ======================================================= --}}
    <script>

        document.addEventListener(
            'DOMContentLoaded',
            function () {

                // =====================================================
                // ELEMENT FILTER
                // =====================================================

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
                        '.table tbody tr:not(#emptyRow)'
                    );

                const emptyRow =
                    document.getElementById('emptyRow');


                // =====================================================
                // DATE ELEMENT
                // =====================================================

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


                // =====================================================
                // FILTER TABLE
                // =====================================================

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


                        // =================================================
                        // SEARCH
                        // =================================================

                        const matchSearch =
                            nama.includes(searchValue) ||
                            nik.includes(searchValue);


                        // =================================================
                        // PPKS
                        // =================================================

                        const matchPpks =
                            ppksValue === '' ||
                            ppks === ppksValue;


                        // =================================================
                        // TAHAPAN
                        // =================================================

                        const matchTahapan =
                            tahapanValue === '' ||
                            tahapan === tahapanValue;


                        // =================================================
                        // HASIL
                        // =================================================

                        const matchHasil =
                            hasilValue === '' ||
                            hasil === hasilValue;


                        // =================================================
                        // DATE
                        // =================================================

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


                        // =================================================
                        // FINAL RESULT
                        // =================================================

                        const shouldShow =
                            matchSearch &&
                            matchPpks &&
                            matchTahapan &&
                            matchHasil &&
                            matchDate;


                        // =================================================
                        // SHOW / HIDE
                        // =================================================

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

                    });


                    // =====================================================
                    // EMPTY DATA
                    // =====================================================

                    if (found) {

                        emptyRow.style.display =
                            'none';

                    } else {

                        emptyRow.style.display =
                            'table-row';

                    }

                }


                // =====================================================
                // SEARCH
                // =====================================================

                searchInput.addEventListener(
                    'input',
                    filterTable
                );


                // =====================================================
                // FILTER
                // =====================================================

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


                // =====================================================
                // DATE PICKER OPEN
                // =====================================================

                dateFilterButton.addEventListener(
                    'click',
                    function (event) {

                        event.stopPropagation();

                        datePicker.classList.toggle(
                            'active'
                        );

                    }
                );


                // =====================================================
                // CLICK INSIDE DATE PICKER
                // =====================================================

                datePicker.addEventListener(
                    'click',
                    function (event) {

                        event.stopPropagation();

                    }
                );


                // =====================================================
                // APPLY DATE
                // =====================================================

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


                // =====================================================
                // RESET DATE
                // =====================================================

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


                // =====================================================
                // FORMAT DATE
                // =====================================================

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


                // =====================================================
                // CLICK OUTSIDE DATE PICKER
                // =====================================================

                document.addEventListener(
                    'click',
                    function () {

                        datePicker.classList.remove(
                            'active'
                        );

                    }
                );


                // =====================================================
                // INITIAL FILTER
                // =====================================================

                filterTable();

            }
        );

    </script>

</x-app-layout>

