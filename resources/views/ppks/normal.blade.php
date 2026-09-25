<x-app-layout>

    <div class="main-page">

        {{-- =====================================================
        HEADER
        ======================================================= --}}
        <div class="main-page-header">

            <div>

                <h1>Data Normal</h1>

                <p>
                    Data peserta yang telah tervalidasi dan menjadi data normal yang siap diolah.
                </p>

            </div>


            {{-- =====================================================
            DATE FILTER
            ======================================================= --}}
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
        ======================================================= --}}
        <div class="filter-wrapper">

            <div class="filter-group">


                {{-- SEARCH --}}
                <form method="GET" action="{{ request()->url() }}" class="search" id="searchWrapper">

                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2">

                        <circle cx="11" cy="11" r="7" />
                        <path d="m20 20-3.5-3.5" />

                    </svg>

                    <input type="text" name="search" id="searchInput" value="{{ request('search') }}"
                        placeholder="Cari Nama atau NIK" autocomplete="off">

                </form>


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

                        <option value="Belum Dilakukan">
                            Belum Dilakukan
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

                        <option value="Jadi Siswa">
                            Jadi Siswa
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


            {{-- RESET SEMUA FILTER --}}
            <button type="button" id="resetAllFilters" class="filter-reset">

                <span class="material-symbols-outlined">
                    restart_alt
                </span>

                Reset

            </button>

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
                        <th>No HP</th>
                        <th>Hasil</th>

                    </tr>

                </thead>


                <tbody>

                    @forelse ($ppks as $index => $peserta)

                        @php

                            /* =====================================================
                            DATA PPKS
                            ===================================================== */

                            $data = is_array($peserta->data)
                                ? $peserta->data
                                : [];


                            /* =====================================================
                            DATA DASAR
                            ===================================================== */

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


                            /* =====================================================
                            NO HP
                            ===================================================== */

                            $noHp =
                                $data['no_hp_1']
                                ?? '-';

                            if (is_array($noHp)) {
                                $noHp = implode(', ', $noHp);
                            }

                            if (trim((string) $noHp) === '') {
                                $noHp = '-';
                            }


                            /* =====================================================
                            TANGGAL KEDATANGAN
                            ===================================================== */

                            $tanggal =
                                $peserta->pemanggilanPeserta?->tanggal_kedatangan;


                            /* =====================================================
                            ROUTE DETAIL
                            ===================================================== */

                            $route =
                                $route = route(
                                    'ppks.normal.asesmen-instruktur.data-detail',
                                    $peserta->id
                                );


                            /* =====================================================
                            AMBIL SEMUA PROSES
                            ===================================================== */

                            $proses =
                                $peserta->prosesPesertas ?? collect();


                            /* =====================================================
                            URUTAN TAHAPAN
                            ===================================================== */

                            $urutanTahap = [
                                'instruktur' => 1,
                                'kesehatan_awal' => 2,
                                'case_conference' => 3,
                                'kesehatan_lanjutan' => 4,
                                'jadi_siswa' => 5,
                            ];


                            /* =====================================================
                            SIAPKAN DATA SETIAP TAHAP
                            ===================================================== */

                            $tahapanData = [
                                'instruktur' => null,
                                'kesehatan_awal' => null,
                                'case_conference' => null,
                                'kesehatan_lanjutan' => null,
                                'jadi_siswa' => null,
                            ];


                            /* =====================================================
                            NORMALISASI DAN AMBIL PROSES TERBARU
                            ===================================================== */

                            foreach ($proses as $item) {

                                $tahap = strtolower(
                                    trim(
                                        (string) ($item->tahap ?? '')
                                    )
                                );


                                if (
                                    in_array($tahap, [
                                        'instruktur',
                                        'asesmen_instruktur',
                                        'asesmen instruktur',
                                    ], true)
                                ) {

                                    $tahapKey = 'instruktur';

                                } elseif (
                                    in_array($tahap, [
                                        'kesehatan',
                                        'kesehatan_awal',
                                        'kesehatan awal',
                                        'asesmen_kesehatan_awal',
                                        'asesmen kesehatan awal',
                                    ], true)
                                ) {

                                    $tahapKey = 'kesehatan_awal';

                                } elseif (
                                    in_array($tahap, [
                                        'case_conference',
                                        'case-conference',
                                        'case conference',
                                        'cc',
                                    ], true)
                                ) {

                                    $tahapKey = 'case_conference';

                                } elseif (
                                    in_array($tahap, [
                                        'kesehatan_lanjutan',
                                        'kesehatan-lanjutan',
                                        'kesehatan lanjutan',
                                        'asesmen_kesehatan_lanjutan',
                                        'asesmen kesehatan lanjutan',
                                    ], true)
                                ) {

                                    $tahapKey = 'kesehatan_lanjutan';

                                } elseif (
                                    in_array($tahap, [
                                        'jadi_siswa',
                                        'jadi-siswa',
                                        'jadi siswa',
                                        'siswa',
                                    ], true)
                                ) {

                                    $tahapKey = 'jadi_siswa';

                                } else {

                                    continue;

                                }


                                if (
                                    !$tahapanData[$tahapKey] ||
                                    (
                                        $item->created_at &&
                                        $tahapanData[$tahapKey]->created_at &&
                                        $item->created_at >
                                        $tahapanData[$tahapKey]->created_at
                                    )
                                ) {

                                    $tahapanData[$tahapKey] =
                                        $item;

                                }

                            }


                            /* =====================================================
                            TENTUKAN TAHAPAN TERAKHIR
                            ===================================================== */

                            $tahapTerakhir = null;
                            $prosesTerakhir = null;


                            foreach ($urutanTahap as $key => $urutan) {

                                if ($tahapanData[$key]) {

                                    $tahapTerakhir =
                                        $key;

                                    $prosesTerakhir =
                                        $tahapanData[$key];

                                }

                            }


                            /* =====================================================
                            DEFAULT: BELUM DILAKUKAN
                            ===================================================== */

                            if (!$tahapTerakhir) {

                                $tahapTerakhir =
                                    'belum_dilakukan';

                                $labelTahapan =
                                    'Belum Dilakukan';

                                $hasil =
                                    'Belum Dimulai';

                                $hasilClass =
                                    'belum-dimulai';

                                $hasilDotClass =
                                    'belum-dimulai';

                                $hasilIcon =
                                    'progress_activity';

                                $badgeClass =
                                    'result-not-done';

                            } else {

                                /* =====================================================
                                LABEL TAHAP
                                ===================================================== */

                                $labelTahapan = match ($tahapTerakhir) {

                                    'instruktur' =>
                                        'Asesmen Instruktur',

                                    'kesehatan_awal' =>
                                        'Asesmen Kesehatan Awal',

                                    'case_conference' =>
                                        'Case Conference',

                                    'kesehatan_lanjutan' =>
                                        'Asesmen Kesehatan Lanjutan',

                                    'jadi_siswa' =>
                                        'Jadi Siswa',

                                    default =>
                                        'Belum Dilakukan',

                                };


                                /* =====================================================
                                WARNA BADGE
                                ===================================================== */

                                $badgeClass = match ($tahapTerakhir) {

                                    'instruktur' =>
                                        'result-instructor',

                                    'kesehatan_awal' =>
                                        'result-health',

                                    'case_conference' =>
                                        'result-case-conference',

                                    'kesehatan_lanjutan' =>
                                        'result-health-advanced',

                                    'jadi_siswa' =>
                                        'result-student',

                                    default =>
                                        'result-not-done',

                                };


                                /* =====================================================
                                ICON
                                ===================================================== */

                                $hasilIcon = match ($tahapTerakhir) {

                                    'instruktur' =>
                                        'assignment',

                                    'kesehatan_awal' =>
                                        'medical_services',

                                    'case_conference' =>
                                        'groups',

                                    'kesehatan_lanjutan' =>
                                        'medical_services',

                                    'jadi_siswa' =>
                                        'school',

                                    default =>
                                        'progress_activity',

                                };


                                /* =====================================================
                                STATUS
                                ===================================================== */

                                $status =
                                    strtolower(
                                        trim(
                                            (string) (
                                                $prosesTerakhir->status
                                                ?? ''
                                            )
                                        )
                                    );


                                /* =====================================================
                                NORMALISASI STATUS
                                ===================================================== */

                                if (
                                    in_array($status, [
                                        'pending',
                                        'menunggu',
                                        'belum',
                                    ], true)
                                ) {

                                    $hasil =
                                        'Pending';

                                    $hasilClass =
                                        'pending';

                                    $hasilDotClass =
                                        'pending';


                                } elseif (
                                    in_array($status, [
                                        'lulus',
                                        'lolos',
                                        'accepted',
                                        'diterima',
                                    ], true)
                                ) {

                                    if (
                                        $tahapTerakhir ===
                                        'case_conference'
                                    ) {

                                        $hasil =
                                            'lulus';

                                        $hasilClass =
                                            'lulus';

                                        $hasilDotClass =
                                            'lulus';

                                    } elseif (
                                        $tahapTerakhir ===
                                        'jadi_siswa'
                                    ) {

                                        $hasil =
                                            'Diterima';

                                        $hasilClass =
                                            'diterima';

                                        $hasilDotClass =
                                            'diterima';

                                    } else {

                                        $hasil =
                                            'Lulus';

                                        $hasilClass =
                                            'lulus';

                                        $hasilDotClass =
                                            'lulus';

                                    }


                                } elseif (
                                    in_array($status, [
                                        'tidak_lulus',
                                        'tidak-lulus',
                                        'tidak lulus',
                                        'tidak_lolos',
                                        'tidak-lolos',
                                        'tidak lolos',
                                        'rejected',
                                        'tidak diterima',
                                    ], true)
                                ) {

                                    if (
                                        $tahapTerakhir ===
                                        'case_conference'
                                    ) {

                                        $hasil =
                                            'tidak-lulus';

                                        $hasilClass =
                                            'tidak-lulus';

                                        $hasilDotClass =
                                            'tidak-lulus';

                                    } else {

                                        $hasil =
                                            'Tidak Lulus';

                                        $hasilClass =
                                            'tidak-lulus';

                                        $hasilDotClass =
                                            'tidak-lulus';

                                    }


                                } else {

                                    $hasil =
                                        'Pending';

                                    $hasilClass =
                                        'pending';

                                    $hasilDotClass =
                                        'pending';

                                }

                            }


                            /* =====================================================
                            FILTER VALUE
                            ===================================================== */

                            $tahapanFilterValue =
                                strtolower(
                                    $labelTahapan
                                );

                            $hasilFilterValue =
                                strtolower(
                                    $hasil
                                );

                        @endphp


                        <tr data-nama="{{ strtolower($nama) }}" data-nik="{{ strtolower($nik) }}"
                            data-ppks="{{ strtolower($jenisPpks) }}" data-tahapan="{{ $tahapanFilterValue }}"
                            data-hasil="{{ $hasilFilterValue }}" data-tanggal="{{ $tanggal ?? '' }}">

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


                            {{-- NO HP --}}
                            <td>
                                {{ $noHp }}
                            </td>

                    {{-- HASIL / TAHAPAN --}}
                    <td class="hasil-cell">

                        <div class="hasil-wrapper">
                            <x-result-badge
                                :route="$route"
                                :badge-class="$badgeClass"
                                :hasil-icon="$hasilIcon"
                                :label-tahapan="$labelTahapan"
                                :hasil-class="$hasilClass"
                                :hasil-dot-class="$hasilDotClass"
                                :hasil="$hasil"
                            />
                        </div>

                                <x-result-badge :route="$route" :badge-class="$badgeClass" :hasil-icon="$hasilIcon"
                                    :label-tahapan="$labelTahapan" :hasil-class="$hasilClass"
                                    :hasil-dot-class="$hasilDotClass" :hasil="$hasil" />

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
                                        Belum ada data PPKS yang masuk 
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse


                    {{-- DATA TIDAK DITEMUKAN --}}
                    <tr id="emptyRow" style="display: none;">

                        <td colspan="7" style="
                                text-align: center;
                                padding: 40px;
                                color: #6b7280;
                            ">

                            Data tidak ditemukan.

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>


        {{-- =====================================================
        PAGINATION
        ======================================================= --}}
        @if ($ppks instanceof \Illuminate\Pagination\LengthAwarePaginator)

            <div class="pagination-wrapper">

                {{ $ppks->links() }}

            </div>

        @endif

    </div>


    {{-- =====================================================
    JAVASCRIPT
    ======================================================= --}}
    <script>

        document.addEventListener(
            'DOMContentLoaded',
            function () {

                const searchInput =
                    document.getElementById(
                        'searchInput'
                    );

                const searchWrapper =
                    document.getElementById(
                        'searchWrapper'
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

                const resetAllFilters =
                    document.getElementById(
                        'resetAllFilters'
                    );


                const tableRows =
                    document.querySelectorAll(
                        '.table tbody tr:not(#emptyRow)'
                    );


                const emptyRow =
                    document.getElementById(
                        'emptyRow'
                    );


                // =====================================================
                // DATE
                // =====================================================

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


                // =====================================================
                // UPDATE STATUS FILTER
                // =====================================================

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


                // =====================================================
                // FILTER TABLE
                // =====================================================

                function filterTable() {

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


                    tableRows.forEach(
                        function (row) {

                            const ppks =
                                row.dataset.ppks || '';

                            const tahapan =
                                row.dataset.tahapan || '';

                            const hasil =
                                row.dataset.hasil || '';

                            const tanggal =
                                row.dataset.tanggal || '';


                            // =================================================
                            // PPKS
                            // =================================================

                            const matchPpks =
                                ppksValue === '' ||
                                ppks.includes(
                                    ppksValue
                                );


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
                            // FINAL
                            // =================================================

                            const shouldShow =
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

                                row.style.display =
                                    'none';

                            }

                        }
                    );


                    emptyRow.style.display =
                        found
                            ? 'none'
                            : 'table-row';


                    updateFilterState();

                }


                // =====================================================
                // EVENTS
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
                // RESET SEMUA FILTER
                // =====================================================

                resetAllFilters.addEventListener(
                    'click',
                    function () {

                        /*
                         * Search sekarang merupakan
                         * server-side search.
                         *
                         * Jadi reset search harus
                         * menghapus parameter URL.
                         */

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


                        /*
                         * Jika ada search di URL,
                         * reload halaman tanpa search.
                         */

                        const url =
                            new URL(
                                window.location.href
                            );

                        url.searchParams.delete(
                            'search'
                        );

                        url.searchParams.delete(
                            'page'
                        );


                        window.history.replaceState(
                            {},
                            '',
                            url
                        );


                        filterTable();

                    }
                );


                // =====================================================
                // DATE PICKER
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


                // =====================================================
                // CLICK OUTSIDE
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
