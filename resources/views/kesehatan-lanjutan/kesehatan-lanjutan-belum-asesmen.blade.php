<x-app-layout>

    <div class="main-page">

        {{-- =====================================================
            HEADER
        ====================================================== --}}
        <div class="main-page-header">

            <div>
                <h1>Data Kesehatan Lanjutan</h1>

                <p>
                    Data peserta yang telah datang dan siap mengikuti asesmen kesehatan lanjutan.
                </p>
            </div>


            {{-- =================================================
                DATE FILTER
            ================================================== --}}
            <div class="date-filter-wrapper">

                <button
                    type="button"
                    class="date-filter"
                    id="dateFilterButton"
                >
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


                <div
                    class="date-picker"
                    id="datePicker"
                >

                    <div class="date-picker-header">
                        <strong>Pilih Rentang Tanggal</strong>
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


            {{-- HASIL --}}
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

                    <option value="Belum Dilakukan">
                        Belum Dilakukan
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

                            $data = is_array($peserta->data)
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
                            | TANGGAL PEMANGGILAN
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
                            | PROSES PESERTA
                            |--------------------------------------------------------------------------
                            */

                            $proses =
                                $peserta->prosesPesertas
                                ?? collect();


                            $prosesTerakhir = null;

                            $tahapTerakhir = null;


                            /*
                            |--------------------------------------------------------------------------
                            | CARI TAHAPAN TERAKHIR
                            |--------------------------------------------------------------------------
                            */

                            foreach ($proses as $item) {

                                $tahap =
                                    strtolower(
                                        trim(
                                            (string) (
                                                $item->tahap
                                                ?? ''
                                            )
                                        )
                                    );


                                /*
                                |--------------------------------------------------------------------------
                                | KESEHATAN LANJUTAN
                                |--------------------------------------------------------------------------
                                */

                                if (
                                    in_array(
                                        $tahap,
                                        [
                                            'kesehatan_lanjutan',
                                            'kesehatan lanjutan',
                                            'asesmen_kesehatan_lanjutan',
                                            'asesmen kesehatan lanjutan'
                                        ],
                                        true
                                    )
                                ) {

                                    $tahapKey =
                                        'kesehatan_lanjutan';

                                }


                                /*
                                |--------------------------------------------------------------------------
                                | CASE CONFERENCE
                                |--------------------------------------------------------------------------
                                */

                                elseif (
                                    in_array(
                                        $tahap,
                                        [
                                            'case_conference',
                                            'case-conference',
                                            'case conference',
                                            'cc'
                                        ],
                                        true
                                    )
                                ) {

                                    $tahapKey =
                                        'case_conference';

                                }


                                /*
                                |--------------------------------------------------------------------------
                                | KESEHATAN AWAL
                                |--------------------------------------------------------------------------
                                */

                                elseif (
                                    in_array(
                                        $tahap,
                                        [
                                            'kesehatan',
                                            'kesehatan_awal',
                                            'asesmen_kesehatan_awal',
                                            'asesmen kesehatan awal'
                                        ],
                                        true
                                    )
                                ) {

                                    $tahapKey =
                                        'kesehatan_awal';

                                }


                                /*
                                |--------------------------------------------------------------------------
                                | INSTRUKTUR
                                |--------------------------------------------------------------------------
                                */

                                elseif (
                                    in_array(
                                        $tahap,
                                        [
                                            'instruktur',
                                            'asesmen_instruktur',
                                            'asesmen instruktur'
                                        ],
                                        true
                                    )
                                ) {

                                    $tahapKey =
                                        'instruktur';

                                }


                                else {

                                    continue;

                                }


                                /*
                                |--------------------------------------------------------------------------
                                | URUTAN TAHAPAN
                                |--------------------------------------------------------------------------
                                */

                                $urutan = [

                                    'instruktur' =>
                                        1,

                                    'kesehatan_awal' =>
                                        2,

                                    'case_conference' =>
                                        3,

                                    'kesehatan_lanjutan' =>
                                        4,

                                ];


                                /*
                                |--------------------------------------------------------------------------
                                | SIMPAN TAHAPAN PALING AKHIR
                                |--------------------------------------------------------------------------
                                */

                                if (
                                    !$tahapTerakhir
                                    ||
                                    $urutan[$tahapKey]
                                    >
                                    $urutan[$tahapTerakhir]
                                ) {

                                    $tahapTerakhir =
                                        $tahapKey;

                                    $prosesTerakhir =
                                        $item;

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
                            | LABEL TAHAPAN
                            |--------------------------------------------------------------------------
                            |
                            | Halaman ini selalu merupakan halaman
                            | Asesmen Kesehatan Lanjutan.
                            |
                            */

                            $labelTahapan =
                                'Asesmen Kesehatan Lanjutan';


                            /*
                            |--------------------------------------------------------------------------
                            | DEFAULT STATUS
                            |--------------------------------------------------------------------------
                            |
                            | Kalau peserta baru sampai Case Conference
                            | dan belum punya proses Kesehatan Lanjutan,
                            | maka status di halaman ini tetap:
                            |
                            | Belum Dilakukan
                            |
                            */

                            $hasil =
                                'Belum Dilakukan';

                            $keterangan =
                                'Peserta belum melakukan asesmen kesehatan lanjutan.';

                            $statusClass =
                                'belum-dimulai';


                            /*
                            |--------------------------------------------------------------------------
                            | ICON BADGE
                            |--------------------------------------------------------------------------
                            */

                            $hasilIcon =
                                'medical_services';


                            /*
                            |--------------------------------------------------------------------------
                            | CARI PROSES KESEHATAN LANJUTAN
                            |--------------------------------------------------------------------------
                            |
                            | Jangan menggunakan Case Conference /
                            | Kesehatan Awal sebagai hasil halaman ini.
                            |
                            */

                            $prosesKesehatanLanjutan = null;


                            foreach ($proses as $item) {

                                $tahap =
                                    strtolower(
                                        trim(
                                            (string) (
                                                $item->tahap
                                                ?? ''
                                            )
                                        )
                                    );


                                if (
                                    in_array(
                                        $tahap,
                                        [
                                            'kesehatan_lanjutan',
                                            'kesehatan lanjutan',
                                            'asesmen_kesehatan_lanjutan',
                                            'asesmen kesehatan lanjutan'
                                        ],
                                        true
                                    )
                                ) {

                                    $prosesKesehatanLanjutan =
                                        $item;

                                }

                            }


                            /*
                            |--------------------------------------------------------------------------
                            | STATUS KESEHATAN LANJUTAN
                            |--------------------------------------------------------------------------
                            */

                            if ($prosesKesehatanLanjutan) {

                                $status =
                                    strtolower(
                                        trim(
                                            (string) (
                                                $prosesKesehatanLanjutan->status
                                                ?? ''
                                            )
                                        )
                                    );


                                /*
                                |--------------------------------------------------------------------------
                                | LULUS
                                |--------------------------------------------------------------------------
                                */

                                if ($status === 'lulus') {

                                    $hasil =
                                        'Lulus';

                                    $keterangan =
                                        $prosesKesehatanLanjutan->catatan
                                        ??
                                        'Peserta dinyatakan lulus pada tahap ini.';

                                    $statusClass =
                                        'lulus';

                                }


                                /*
                                |--------------------------------------------------------------------------
                                | TIDAK LULUS
                                |--------------------------------------------------------------------------
                                */

                                elseif ($status === 'tidak_lulus') {

                                    $hasil =
                                        'Tidak Lulus';

                                    $keterangan =
                                        $prosesKesehatanLanjutan->catatan
                                        ??
                                        'Peserta dinyatakan tidak lulus pada tahap ini.';

                                    $statusClass =
                                        'tidak-lulus';

                                }


                                /*
                                |--------------------------------------------------------------------------
                                | PENDING
                                |--------------------------------------------------------------------------
                                */

                                elseif ($status === 'pending') {

                                    $hasil =
                                        'Pending';

                                    $keterangan =
                                        $prosesKesehatanLanjutan->catatan
                                        ??
                                        'Proses asesmen masih menunggu.';

                                    $statusClass =
                                        'pending';

                                }


                                /*
                                |--------------------------------------------------------------------------
                                | SEDANG DIPERIKSA
                                |--------------------------------------------------------------------------
                                */

                                elseif (
                                    in_array(
                                        $status,
                                        [
                                            'sedang_diperiksa',
                                            'sedang-diperiksa',
                                            'sedang diperiksa'
                                        ],
                                        true
                                    )
                                ) {

                                    $hasil =
                                        'Sedang Pengecekan';

                                    $keterangan =
                                        $prosesKesehatanLanjutan->catatan
                                        ??
                                        'Peserta sedang dalam proses pemeriksaan.';

                                    $statusClass =
                                        'pending';

                                }


                                /*
                                |--------------------------------------------------------------------------
                                | STATUS LAIN
                                |--------------------------------------------------------------------------
                                */

                                else {

                                    $hasil =
                                        'Belum Asesmen';

                                    $keterangan =
                                        $prosesKesehatanLanjutan->catatan
                                        ??
                                        'Peserta belum mengikuti asesmen pada tahap ini.';

                                    $statusClass =
                                        'belum-dimulai';

                                }

                            }


                            /*
                            |--------------------------------------------------------------------------
                            | VALUE UNTUK FILTER
                            |--------------------------------------------------------------------------
                            */

                            $tahapanFilterValue =
                                strtolower(
                                    $labelTahapan
                                );


                            $hasilFilterValue =
                                strtolower(
                                    $hasil
                                );

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


                            {{-- =================================================
                                RESULT BADGE
                            ================================================== --}}
                            <td>

                                <a
                                    href="{{ $route }}"
                                    class="result-badge result-health-advanced"
                                >

                                    {{-- ICON TAHAPAN --}}
                                    <span class="material-symbols-outlined result-icon">
                                        medical_services
                                    </span>


                                    <div class="result-content">

                                        {{-- NAMA TAHAPAN --}}
                                        <span class="result-title">
                                            Asesmen Kesehatan Lanjutan
                                        </span>


                                        {{-- STATUS --}}
                                        <span class="result-status {{ $statusClass }}">

                                            <span
                                                class="status-dot {{ $statusClass }}"
                                            ></span>

                                            {{ $hasil }}

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

                                @php

                                    $keteranganClass =
                                        match (strtolower($hasil)) {

                                            'lulus',
                                            'diterima' =>
                                                'keterangan-lolos',

                                            'tidak lulus',
                                            'tidak diterima' =>
                                                'keterangan-tidak-lolos',

                                            'pending' =>
                                                'keterangan-pending',

                                            'sedang pengecekan' =>
                                                'keterangan-processing',

                                            default =>
                                                'keterangan-belum',

                                        };

                                @endphp


                                <span class="{{ $keteranganClass }}">
                                    {{ $keterangan }}
                                </span>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="8"
                                class="empty-state"
                            >
                                Belum ada peserta yang menunggu
                                Kesehatan Lanjutan.
                            </td>

                        </tr>

                    @endforelse


                    {{-- =================================================
                        EMPTY FILTER
                    ================================================== --}}
                    <tr
                        id="emptyRow"
                        style="display: none;"
                    >

                        <td
                            colspan="8"
                            class="empty-state"
                        >
                            Data tidak ditemukan.
                        </td>

                    </tr>

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
                    | HASIL FILTER
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


                    row.style.display =
                        visible
                            ? ''
                            : 'none';


                    if (visible) {

                        visibleCount++;

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
