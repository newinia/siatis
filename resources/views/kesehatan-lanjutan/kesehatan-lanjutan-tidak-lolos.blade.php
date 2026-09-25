
<x-app-layout>

    <div class="main-page">

        {{-- =====================================================
        HEADER
        ====================================================== --}}
        <div class="main-page-header">

            <div>
                <h1>Data Kesehatan Lanjutan Tidak Lulus</h1>

                <p>
                    Data peserta yang tidak lulus asesmen kesehatan lanjutan dan tidak dapat melanjutkan ke tahap berikutnya.
                </p>
            </div>


            {{-- =================================================
            DATE FILTER
            ================================================== --}}
            <div class="date-filter-wrapper">

                <button type="button" class="date-filter" id="dateFilterButton">

                    <span class="material-symbols-outlined">
                        calendar_month
                    </span>

                    <span id="dateFilterText">
                        Pilih Tanggal
                    </span>

                    <span class="material-symbols-outlined">
                        keyboard_arrow_down
                    </span>

                </button>


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
        ====================================================== --}}
        <div class="filter-wrapper">

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


            {{-- JENIS PPKS --}}
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


            {{-- TAHAPAN --}}
            <div class="select-wrapper">

                <select
                    id="tahapanFilter"
                    class="filter-button"
                >

                    <option value="">
                        Semua Jenis Tahapan
                    </option>

                    <option value="Asesmen Kesehatan Lanjutan">
                        Asesmen Kesehatan Lanjutan
                    </option>

                </select>

                <span class="material-symbols-outlined select-arrow">
                    keyboard_arrow_down
                </span>

            </div>


            {{-- HASIL --}}
            <div class="select-wrapper">

                <select
                    id="hasilFilter"
                    class="filter-button"
                >

                    <option value="">
                        Semua Hasil
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

                    @forelse ($ppks as $index => $peserta)

                        @php

                            /*
                            |--------------------------------------------------------------------------
                            | DATA PPKS
                            |--------------------------------------------------------------------------
                            */

                            $data =
                                is_array($peserta->data)
                                ? $peserta->data
                                : [];


                            /*
                            |--------------------------------------------------------------------------
                            | IDENTITAS
                            |--------------------------------------------------------------------------
                            */

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


                            /*
                            |--------------------------------------------------------------------------
                            | CASE CONFERENCE
                            |--------------------------------------------------------------------------
                            */

                            $caseConference =
                                $caseConferences[$peserta->id]
                                ?? null;


                            $jurusan =
                                $caseConference?->jurusan_diterima
                                ?? '-';


                            /*
                            |--------------------------------------------------------------------------
                            | KESEHATAN LANJUTAN
                            |--------------------------------------------------------------------------
                            */

                            $kesehatanLanjutan =
                                $peserta->kesehatanLanjutan
                                ?? null;


                            /*
                            |--------------------------------------------------------------------------
                            | TAHAPAN
                            |--------------------------------------------------------------------------
                            */

                            $tahapan =
                                'Asesmen Kesehatan Lanjutan';


                            /*
                            |--------------------------------------------------------------------------
                            | HASIL
                            |--------------------------------------------------------------------------
                            */

                            $hasil =
                                'Tidak Lulus';


                            /*
                            |--------------------------------------------------------------------------
                            | KETERANGAN
                            |--------------------------------------------------------------------------
                            */

                            $keterangan =
                                $kesehatanLanjutan?->catatan_asesmen
                                ?? '-';


                            /*
                            |--------------------------------------------------------------------------
                            | TANGGAL ASESMEN
                            |--------------------------------------------------------------------------
                            */

                            $tanggal = '';

                            if ($kesehatanLanjutan) {

                                $tanggal =
                                    $kesehatanLanjutan->tanggal_asesmen
                                    ? \Carbon\Carbon::parse(
                                        $kesehatanLanjutan->tanggal_asesmen
                                    )->format('Y-m-d')
                                    : '';

                            }


                            /*
                            |--------------------------------------------------------------------------
                            | DETAIL ROUTE
                            |--------------------------------------------------------------------------
                            */

                            $detailRoute =
                                route(
                                    'ppks.normal.kesehatan-lanjutan.detail',
                                    $peserta
                                );

                        @endphp


                        <tr
                            data-nama="{{ strtolower($nama) }}"
                            data-nik="{{ strtolower($nik) }}"
                            data-ppks="{{ strtolower($jenisPpks) }}"
                            data-tahapan="{{ strtolower($tahapan) }}"
                            data-hasil="{{ strtolower($hasil) }}"
                            data-tanggal="{{ $tanggal }}"
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


                            {{-- =================================================
                            HASIL
                            ================================================== --}}
                            <td>

                                <a
                                    href="{{ $detailRoute }}"
                                     class="result-badge result-health-advanced"
                                >

                                    {{-- ICON TAHAPAN --}}
                                    <span class="material-symbols-outlined result-icon">
                                        medical_services
                                    </span>


                                    <div class="result-content">

                                        {{-- NAMA TAHAPAN --}}
                                        <span class="result-title healt">
                                            Asesmen Kesehatan Lanjutan
                                        </span>


                                        {{-- STATUS --}}
                                        <span class="result-status tidak-lulus">

                                            <span class="status-dot tidak-lulus"></span>

                                            Tidak Lulus

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

                                <span class="keterangan-tidak-lolos">
                                    {{ $keterangan }}
                                </span>

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
                                        Belum ada data PPKS yang tidka lulus Asesmen Kesehatan Lanjutan
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse


                </tbody>

            </table>

        </div>

    </div>



    {{-- =========================================================
    JAVASCRIPT
    ========================================================== --}}
    <script>

        document.addEventListener('DOMContentLoaded', function () {

            /*
            |--------------------------------------------------------------------------
            | ELEMENT
            |--------------------------------------------------------------------------
            */

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



            /*
            |--------------------------------------------------------------------------
            | DATE ELEMENT
            |--------------------------------------------------------------------------
            */

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
            | FILTER TABLE
            |--------------------------------------------------------------------------
            */

            function filterTable() {




                const ppks =
                    ppksFilter.value
                        .toLowerCase()
                        .trim();


                const tahapan =
                    tahapanFilter.value
                        .toLowerCase()
                        .trim();


                const hasil =
                    hasilFilter.value
                        .toLowerCase()
                        .trim();


                const start =
                    startDate.value;


                const end =
                    endDate.value;


                let visibleCount = 0;


                tableRows.forEach(function (row) {

                    const nama =
                        row.dataset.nama
                        || '';


                    const nik =
                        row.dataset.nik
                        || '';


                    const jenisPpks =
                        row.dataset.ppks
                        || '';


                    const tahap =
                        row.dataset.tahapan
                        || '';


                    const hasilData =
                        row.dataset.hasil
                        || '';


                    const tanggal =
                        row.dataset.tanggal
                        || '';







                    /*
                    |--------------------------------------------------------------------------
                    | PPKS
                    |--------------------------------------------------------------------------
                    */

                    const matchPpks =
                        !ppks
                        ||
                        jenisPpks === ppks;



                    /*
                    |--------------------------------------------------------------------------
                    | TAHAPAN
                    |--------------------------------------------------------------------------
                    */

                    const matchTahapan =
                        !tahapan
                        ||
                        tahap === tahapan;



                    /*
                    |--------------------------------------------------------------------------
                    | HASIL
                    |--------------------------------------------------------------------------
                    */

                    const matchHasil =
                        !hasil
                        ||
                        hasilData === hasil;



                    /*
                    |--------------------------------------------------------------------------
                    | TANGGAL
                    |--------------------------------------------------------------------------
                    */

                    let matchDate = true;


                    if (start || end) {

                        if (!tanggal) {

                            matchDate = false;

                        }

                        else {

                            if (
                                start
                                &&
                                tanggal < start
                            ) {

                                matchDate = false;

                            }


                            if (
                                end
                                &&
                                tanggal > end
                            ) {

                                matchDate = false;

                            }

                        }

                    }



                    /*
                    |--------------------------------------------------------------------------
                    | FINAL RESULT
                    |--------------------------------------------------------------------------
                    */

                    const visible =
                        matchPpks
                        &&
                        matchTahapan
                        &&
                        matchHasil
                        &&
                        matchDate;



                    /*
                    |--------------------------------------------------------------------------
                    | SHOW / HIDE
                    |--------------------------------------------------------------------------
                    */

                    row.style.display =
                        visible
                            ? ''
                            : 'none';


                    if (visible) {

                        visibleCount++;


                        row.querySelector(
                            '.row-number'
                        ).textContent =
                            visibleCount;

                    }

                });



                /*
                |--------------------------------------------------------------------------
                | EMPTY ROW
                |--------------------------------------------------------------------------
                */

                emptyRow.style.display =
                    visibleCount === 0
                        ? 'table-row'
                        : 'none';

            }







            /*
            |--------------------------------------------------------------------------
            | FILTER
            |--------------------------------------------------------------------------
            */

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
            | FORMAT DATE
            |--------------------------------------------------------------------------
            */

            function formatDate(dateString) {

                if (!dateString) {

                    return '';

                }


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



                    if (
                        start
                        &&
                        end
                        &&
                        start > end
                    ) {

                        alert(
                            'Tanggal mulai tidak boleh lebih besar dari tanggal akhir.'
                        );

                        return;

                    }



                    if (start && end) {

                        dateFilterText.textContent =
                            `${formatDate(start)} - ${formatDate(end)}`;

                    }

                    else if (start) {

                        dateFilterText.textContent =
                            `Mulai ${formatDate(start)}`;

                    }

                    else if (end) {

                        dateFilterText.textContent =
                            `Sampai ${formatDate(end)}`;

                    }

                    else {

                        dateFilterText.textContent =
                            'Pilih Tanggal';

                    }



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

                    startDate.value =
                        '';


                    endDate.value =
                        '';


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
            | CLOSE DATE PICKER
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
            | INITIAL FILTER
            |--------------------------------------------------------------------------
            */

            filterTable();

        });

    </script>

</x-app-layout>

