<x-app-layout>

    <div class="case-conference-page">

        {{-- =====================================================
        HEADER
        ====================================================== --}}
        <div class="case-conference-header">

            <div>
                <h1>Data Pendaftar Vokasional</h1>

                <p>
                    Data calon PPKS yang telah diverifikasi dan siap diproses ke tahap selanjutnya.
                </p>
            </div>

            {{-- =====================================================
            DATE FILTER
            ====================================================== --}}
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
        <div class="case-filter-wrapper">

            {{-- =====================================================
            SEARCH
            ====================================================== --}}
            <div class="case-search">

                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2">

                    <circle cx="11" cy="11" r="7" />
                    <path d="m20 20-3.5-3.5" />

                </svg>

                <input type="text" id="searchInput" placeholder="Cari Nama atau NIK" autocomplete="off">

            </div>


            {{-- =====================================================
            FILTER JENIS PPKS
            ====================================================== --}}
            <div class="select-wrapper">

                <select id="ppksFilter" class="case-filter-button">

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


            {{-- =====================================================
            FILTER TAHAPAN
            ====================================================== --}}
            <div class="select-wrapper">

                <select id="tahapanFilter" class="case-filter-button">

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


            {{-- =====================================================
            FILTER HASIL
            ====================================================== --}}
            <div class="select-wrapper">

                <select id="hasilFilter" class="case-filter-button">

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

                    <option value="Asesmen Kesehatan">
                        Asesmen Kesehatan
                    </option>

                    <option value="Asesmen Instruktur">
                        Asesmen Instruktur
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

                    @php

                        $students = [

                            [
                                'nama' => 'Siti Rahmawati',
                                'nik' => '012345678',
                                'umur' => '18',
                                'ppks' => 'Disabilitas Fisik',
                                'jurusan' => 'Contact Center',
                                'tahapan' => 'Asesmen Kesehatan Awal',
                                'tanggal' => '2023-10-12',
                                'hasil' => 'Diterima',
                                'status' => 'accepted',
                                'keterangan' => '-',
                            ],

                            [
                                'nama' => 'Andi Saputra',
                                'nik' => '012345679',
                                'umur' => '20',
                                'ppks' => 'Disabilitas Rungu Wicara',
                                'jurusan' => 'Komputer',
                                'tahapan' => 'Asesmen Kesehatan Lanjutan',
                                'tanggal' => '2023-10-13',
                                'hasil' => 'Tidak Diterima',
                                'status' => 'rejected',
                                'keterangan' => 'Tidak memenuhi syarat',
                            ],

                            [
                                'nama' => 'Budi Santoso',
                                'nik' => '012345680',
                                'umur' => '19',
                                'ppks' => 'Disabilitas Netra',
                                'jurusan' => 'Desain Grafis',
                                'tahapan' => 'Asesmen Instruktur',
                                'tanggal' => '2023-10-14',
                                'hasil' => 'Asesmen Instruktur',
                                'status' => 'instructor',
                                'keterangan' => '-',
                            ],

                            [
                                'nama' => 'Citra Lestari',
                                'nik' => '012345681',
                                'umur' => '23',
                                'ppks' => 'Disabilitas Mental',
                                'jurusan' => 'Menjahit',
                                'tahapan' => 'Asesmen Kesehatan Awal',
                                'tanggal' => '2023-10-15',
                                'hasil' => 'Asesmen Kesehatan',
                                'status' => 'health',
                                'keterangan' => '-',
                            ],

                            [
                                'nama' => 'Dewi Anggraini',
                                'nik' => '012345682',
                                'umur' => '27',
                                'ppks' => 'Disabilitas Intelektual',
                                'jurusan' => 'Teknik Elektro',
                                'tahapan' => 'Case Conference',
                                'tanggal' => '2023-10-16',
                                'hasil' => 'Asesmen Kesehatan',
                                'status' => 'health',
                                'keterangan' => '-',
                            ],

                            [
                                'nama' => 'Rizky Maulana',
                                'nik' => '012345683',
                                'umur' => '30',
                                'ppks' => 'Kelompok Rentan',
                                'jurusan' => 'Teknik Mesin',
                                'tahapan' => 'Asesmen Instruktur',
                                'tanggal' => '2023-10-17',
                                'hasil' => 'Asesmen Kesehatan',
                                'status' => 'health',
                                'keterangan' => '-',
                            ],

                            [
                                'nama' => 'Fajar Nugraha',
                                'nik' => '012345684',
                                'umur' => '21',
                                'ppks' => 'Other',
                                'jurusan' => 'Komputer',
                                'tahapan' => 'Case Conference',
                                'tanggal' => '2023-10-18',
                                'hasil' => 'Diterima',
                                'status' => 'accepted',
                                'keterangan' => '-',
                            ],

                        ];

                    @endphp


                    {{-- =====================================================
                    LOOP DATA
                    ====================================================== --}}
                    @foreach ($students as $index => $student)

                        <tr data-nama="{{ strtolower($student['nama']) }}" data-nik="{{ strtolower($student['nik']) }}"
                            data-ppks="{{ strtolower($student['ppks']) }}"
                            data-tahapan="{{ strtolower($student['tahapan']) }}"
                            data-hasil="{{ strtolower($student['hasil']) }}" data-tanggal="{{ $student['tanggal'] }}">

                            {{-- NO --}}
                            <td class="row-number">
                                {{ $index + 1 }}
                            </td>


                            {{-- NAMA --}}
                            <td>
                                {{ $student['nama'] }}
                            </td>


                            {{-- NIK --}}
                            <td>
                                {{ $student['nik'] }}
                            </td>


                            {{-- UMUR --}}
                            <td>
                                {{ $student['umur'] }}
                            </td>


                            {{-- PPKS --}}
                            <td>
                                {{ $student['ppks'] }}
                            </td>


                            {{-- JURUSAN --}}
                            <td>
                                {{ $student['jurusan'] }}
                            </td>


                            {{-- =====================================================
                            HASIL
                            ====================================================== --}}
                            <td>

                                {{-- =============================================
                                DITERIMA
                                → CASE CONFERENCE DETAIL
                                ============================================== --}}
                                @if ($student['status'] === 'accepted')

                                    <a href="{{ route('case-conference-detail') }}" class="result-badge result-accepted">

                                        <span class="material-symbols-outlined result-icon">
                                            task_alt
                                        </span>

                                        <span>
                                            Diterima
                                        </span>

                                        <span class="result-arrow">
                                            ›
                                        </span>

                                    </a>


                                    {{-- =============================================
                                    TIDAK DITERIMA
                                    → CASE CONFERENCE DETAIL
                                    ============================================== --}}
                                @elseif ($student['status'] === 'rejected')

                                    <a href="{{ route('case-conference-detail') }}" class="result-badge result-rejected">

                                        <span class="material-symbols-outlined result-icon">
                                            cancel
                                        </span>

                                        <span>
                                            Tidak Diterima
                                        </span>

                                        <span class="result-arrow">
                                            ›
                                        </span>

                                    </a>


                                    {{-- =============================================
                                    BELUM DILAKUKAN
                                    → DATA DETAIL
                                    ============================================== --}}
                                @elseif ($student['status'] === 'not-done')

                                    <a href="{{ route('data-detail') }}" class="result-badge result-not-done">

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


                                    {{-- =============================================
                                    ASESMEN INSTRUKTUR
                                    → ASESMEN INSTRUKTUR DETAIL
                                    ============================================== --}}
                                @elseif ($student['status'] === 'instructor')

                                    <a href="{{ route('asesmen-instruktur-detail') }}" class="result-badge result-instructor">

                                        <span class="material-symbols-outlined result-icon">
                                            assignment
                                        </span>

                                        <div class="result-content">

                                            <span class="result-title result-instructor">
                                                Asesmen Instruktur
                                            </span>

                                            <span class="result-status pending">

                                                <span class="status-dot pending"></span>

                                                Pending

                                            </span>

                                        </div>

                                        <span class="result-arrow">
                                            ›
                                        </span>

                                    </a>


                                    {{-- =============================================
                                    ASESMEN KESEHATAN
                                    → ASESMEN KESEHATAN LANJUTAN DETAIL
                                    ============================================== --}}
                                @elseif ($student['status'] === 'health')

                                    <a href="{{ route('asesmen-kesehatan-lanjutan-detail') }}"
                                        class="result-badge result-health">

                                        <span class="material-symbols-outlined result-icon">
                                            medical_services
                                        </span>

                                        <div class="result-content">

                                            <span class="result-title result-health">
                                                Asesmen Kesehatan
                                            </span>

                                            <span class="result-status lolos">

                                                <span class="status-dot lolos"></span>

                                                Lolos

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
                                {{ $student['keterangan'] }}
                            </td>

                        </tr>

                    @endforeach


                    {{-- =====================================================
                    DATA TIDAK DITEMUKAN
                    ====================================================== --}}
                    <tr id="emptyRow" style="display: none;">

                        <td colspan="8" style="
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

    </div>


    {{-- =====================================================
    JAVASCRIPT
    ====================================================== --}}
    <script>

        document.addEventListener('DOMContentLoaded', function () {

            // =====================================================
            // ELEMENT SEARCH & FILTER
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

                    const selectedStart =
                        startDate.value;

                    const selectedEnd =
                        endDate.value;


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

                        row.querySelector(
                            '.row-number'
                        ).textContent = visibleNumber;

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

                    emptyRow.style.display = 'none';

                } else {

                    emptyRow.style.display = 'table-row';

                }

            }


            // =====================================================
            // SEARCH EVENT
            // =====================================================

            searchInput.addEventListener(
                'input',
                filterTable
            );


            // =====================================================
            // FILTER EVENT
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
            // DATE PICKER OPEN / CLOSE
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


                    // Tidak ada tanggal
                    if (!start || !end) {

                        alert(
                            'Silakan pilih tanggal awal dan tanggal akhir.'
                        );

                        return;

                    }


                    // Start > End
                    if (start > end) {

                        alert(
                            'Tanggal awal tidak boleh lebih besar dari tanggal akhir.'
                        );

                        return;

                    }


                    // Format tanggal
                    const startFormatted =
                        formatDate(start);

                    const endFormatted =
                        formatDate(end);


                    dateFilterText.textContent =
                        startFormatted +
                        ' - ' +
                        endFormatted;


                    datePicker.classList.remove(
                        'active'
                    );


                    // Jalankan filter
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


                    // Reset filter tabel
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

        });

    </script>

</x-app-layout>