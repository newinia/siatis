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

            {{-- SEARCH --}}
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
                        <th>Peminatan</th>
                        <th>Jenis Keberangkatan</th>
                        <th>No HP</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>

                <tbody>

                    @php

                        $students = [

                            [
                                'nama' => 'Siti Rahmawati',
                                'nik' => '0123456678',
                                'peminatan' => 'Baznas',
                                'keberangkatan' => 'Baznas',
                                'no_hp' => '0897654321',
                                'status' => 'Belum dipanggil',
                                'tanggal' => '-',
                                'tanggal_filter' => '',
                            ],

                            [
                                'nama' => 'Siti Rahmawati',
                                'nik' => '012345678',
                                'peminatan' => 'Baznas',
                                'keberangkatan' => 'Baznas',
                                'no_hp' => '0897654321',
                                'status' => 'Belum Datang',
                                'tanggal' => '-',
                                'tanggal_filter' => '',
                            ],

                            [
                                'nama' => 'Siti Rahmawati',
                                'nik' => '012345678',
                                'peminatan' => 'Baznas',
                                'keberangkatan' => 'Baznas',
                                'no_hp' => '0897654321',
                                'status' => 'Sudah Datang',
                                'tanggal' => '12 Juni 2026',
                                'tanggal_filter' => '2026-06-12',
                            ],

                            [
                                'nama' => 'Siti Rahmawati',
                                'nik' => '012345678',
                                'peminatan' => 'Non Baznas',
                                'keberangkatan' => 'Non Baznas',
                                'no_hp' => '0897654321',
                                'status' => 'Sudah Datang',
                                'tanggal' => '12 Juni 2026',
                                'tanggal_filter' => '2026-06-12',
                            ],

                            [
                                'nama' => 'Siti Rahmawati',
                                'nik' => '012345678',
                                'peminatan' => 'Non Baznas',
                                'keberangkatan' => 'Non Baznas',
                                'no_hp' => '0897654321',
                                'status' => 'Sudah Datang',
                                'tanggal' => '12 Juni 2026',
                                'tanggal_filter' => '2026-06-12',
                            ],

                            [
                                'nama' => 'Siti Rahmawati',
                                'nik' => '012345678',
                                'peminatan' => 'Non Baznas',
                                'keberangkatan' => 'Non Baznas',
                                'no_hp' => '0897654321',
                                'status' => 'Sudah Datang',
                                'tanggal' => '12 Juni 2026',
                                'tanggal_filter' => '2026-06-12',
                            ],

                        ];

                    @endphp


                    @foreach ($students as $index => $student)

                        <tr data-nama="{{ strtolower($student['nama']) }}" data-nik="{{ strtolower($student['nik']) }}"
                            data-peminatan="{{ strtolower($student['peminatan']) }}"
                            data-keberangkatan="{{ strtolower($student['keberangkatan']) }}"
                            data-status="{{ strtolower($student['status']) }}"
                            data-tanggal="{{ $student['tanggal_filter'] }}">

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


                            {{-- PEMINATAN --}}
                            <td>
                                {{ $student['peminatan'] }}
                            </td>


                            {{-- JENIS KEBERANGKATAN --}}
                            <td>
                                {{ $student['keberangkatan'] }}
                            </td>


                            {{-- NO HP --}}
                            <td>
                                {{ $student['no_hp'] }}
                            </td>


                            {{-- STATUS --}}
                            <td>

                                @if ($student['status'] === 'Belum dipanggil')

                                    <div class="status-select status-belum-dipanggil">

                                        <span>
                                            Belum dipanggil
                                        </span>

                                        <span class="material-symbols-outlined">
                                            keyboard_arrow_down
                                        </span>

                                    </div>

                                @elseif ($student['status'] === 'Belum Datang')

                                    <div class="status-select status-belum-datang">

                                        <span>
                                            Belum Datang
                                        </span>

                                        <span class="material-symbols-outlined">
                                            keyboard_arrow_down
                                        </span>

                                    </div>

                                @elseif ($student['status'] === 'Sudah Datang')

                                    <div class="status-select status-sudah-datang">

                                        <span>
                                            Sudah Datang
                                        </span>

                                        <span class="material-symbols-outlined">
                                            keyboard_arrow_down
                                        </span>

                                    </div>

                                @endif

                            </td>


                            {{-- TANGGAL --}}
                            <td>
                                {{ $student['tanggal'] }}
                            </td>

                        </tr>

                    @endforeach


                    {{-- EMPTY ROW --}}
                    <tr id="emptyRow" style="display: none;">

                        <td colspan="8" style="text-align: center; padding: 30px;">
                            Data tidak ditemukan.
                        </td>

                    </tr>

                </tbody>

            </table>

        </div>


        {{-- =====================================================
        JAVASCRIPT
        ====================================================== --}}
        <script>

            document.addEventListener('DOMContentLoaded', function () {

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
                        // FINAL
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

                            const number =
                                row.querySelector('.row-number');

                            if (number) {
                                number.textContent =
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

                        emptyRow.style.display = 'none';

                    } else {

                        emptyRow.style.display = 'table-row';

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
                // DATE PICKER OPEN / CLOSE
                // =====================================================

                dateFilterButton.addEventListener(
                    'click',
                    function (event) {

                        event.stopPropagation();

                        datePicker.classList.toggle('active');

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


                        const startFormatted =
                            formatDate(start);

                        const endFormatted =
                            formatDate(end);


                        dateFilterText.textContent =
                            startFormatted +
                            ' - ' +
                            endFormatted;


                        datePicker.classList.remove('active');


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

                        datePicker.classList.remove('active');

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

                        datePicker.classList.remove('active');

                    }
                );


                // =====================================================
                // INITIAL FILTER
                // =====================================================

                filterTable();

            });

        </script>

</x-app-layout>