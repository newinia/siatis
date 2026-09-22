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


            {{-- =================================================
            PDF ACTION
            ================================================== --}}
            <div class="pdf-filter-wrapper">

                <button
                    type="button"
                    class="pdf-button"
                    id="pdfButton"
                >

                    <span class="material-symbols-outlined">
                        picture_as_pdf
                    </span>

                    PDF

                </button>


                {{-- =================================================
                PDF FILTER POPUP
                ================================================== --}}
                <div
                    class="pdf-filter"
                    id="pdfFilter"
                >

                    <div class="pdf-filter-title">
                        Cetak Data Case Conference
                    </div>


                    {{-- GELOMBANG --}}
                    <div class="pdf-filter-group">

                        <label for="pdfGelombang">
                            Gelombang
                        </label>

                        <select id="pdfGelombang">

                            <option value="">
                                Semua Gelombang
                            </option>

                            @for ($i = 1; $i <= 10; $i++)

                                <option value="{{ $i }}">
                                    Gelombang {{ $i }}
                                </option>

                            @endfor

                        </select>

                    </div>


                    {{-- TAHUN --}}
                    <div class="pdf-filter-group">

                        <label for="pdfTahun">
                            Tahun
                        </label>

                        <select id="pdfTahun">

                            <option value="">
                                Semua Tahun
                            </option>

                            @for ($tahun = 2026; $tahun <= 2036; $tahun++)

                                <option value="{{ $tahun }}">
                                    {{ $tahun }}
                                </option>

                            @endfor

                        </select>

                    </div>


                    {{-- ACTION --}}
                    <div class="pdf-filter-actions">

                        <button
                            type="button"
                            class="pdf-reset"
                            id="pdfReset"
                        >
                            Reset
                        </button>

                        <button
                            type="button"
                            class="pdf-generate"
                            id="pdfGenerate"
                        >
                            Buat PDF
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

                {{-- =================================================
                FILTER JENIS PPKS
                ================================================== --}}
                <div class="select-wrapper">

                    <select
                        id="ppksFilter"
                        class="filter-button"
                    >

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

                    <select
                        id="hasilFilter"
                        class="filter-button"
                    >

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
                            Alamat
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


                <tbody id="dataTable">

                    @forelse ($data as $index => $ppks)

                        @php

                            /*
                            |--------------------------------------------------------------------------
                            | DATA PPKS
                            |--------------------------------------------------------------------------
                            */

                            $item = is_array($ppks->data ?? null)
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
                                ?? $item['nama peserta']
                                ?? $item['Nama Peserta']
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
                            | ALAMAT
                            |--------------------------------------------------------------------------
                            */

                            $alamat =
                                $item['alamat']
                                ?? $item['Alamat']
                                ?? $item['alamat_lengkap']
                                ?? $item['Alamat Lengkap']
                                ?? $item['alamat_domisili']
                                ?? $item['Alamat Domisili']
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
                                        !empty($item['usia'])
                                            ? $item['usia'] . ' tahun'
                                            : '-';

                                }

                            } elseif (!empty($item['usia'])) {

                                $umur =
                                    $item['usia'] . ' tahun';

                            } elseif (!empty($item['umur'])) {

                                $umur =
                                    $item['umur'];

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
                            | CASE CONFERENCE TERBARU
                            |--------------------------------------------------------------------------
                            */

                            $caseConference = $ppks->prosesPesertas
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
                                $caseConference->status
                                ?? 'pending';


                            /*
                            |--------------------------------------------------------------------------
                            | NORMALISASI STATUS
                            |--------------------------------------------------------------------------
                            */

                            $statusLower =
                                strtolower(
                                    trim(
                                        str_replace(
                                            ['-', ' '],
                                            '_',
                                            (string) $status
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
                                    ],
                                    true
                                )
                            ) {

                                $hasilText =
                                    'Diterima';

                                $statusClass =
                                    'diterima';

                                $icon =
                                    'task_alt';

                                $keteranganClass =
                                    'keterangan-lolos';

                            } elseif (
                                in_array(
                                    $statusLower,
                                    [
                                        'tidak_diterima',
                                        'tidak_lulus',
                                        'ditolak',
                                        'rejected'
                                    ],
                                    true
                                )
                            ) {

                                $hasilText =
                                    'Tidak Diterima';

                                $statusClass =
                                    'tidak-diterima';

                                $icon =
                                    'cancel';

                                $keteranganClass =
                                    'keterangan-tidak-lolos';

                            } else {

                                $hasilText =
                                    'Pending';

                                $statusClass =
                                    'pending';

                                $icon =
                                    'pending';

                                $keteranganClass =
                                    'keterangan-pending';

                            }


                            /*
                            |--------------------------------------------------------------------------
                            | KETERANGAN
                            |--------------------------------------------------------------------------
                            */

                            $keterangan =
                                $caseConference?->catatan
                                ?? '-';

                        @endphp


                        <tr
                            class="case-row"
                            data-nama="{{ strtolower((string) $nama) }}"
                            data-nik="{{ strtolower((string) $nik) }}"
                            data-ppks="{{ strtolower((string) $jenisPpks) }}"
                            data-hasil="{{ strtolower((string) $hasilText) }}"
                        >


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
                            ALAMAT
                            ================================================== --}}
                            <td class="address-cell">

                                {{ $alamat }}

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
                            <td class="ppks-cell">

                                {{ $jenisPpks }}

                            </td>


                            {{-- =================================================
                            JURUSAN
                            ================================================== --}}
                            <td class="jurusan-cell">

                                {{ $jurusan }}

                            </td>


                            {{-- =================================================
                            HASIL
                            ================================================== --}}
                            <td>

                                <a
                                    href="{{ route(
                                        'ppks.normal.case-conference.detail',
                                        $ppks->id
                                    ) }}"
                                    class="result-badge result-case-conference"
                                >

                                    {{-- RESULT ICON --}}
                                    <span class="material-symbols-outlined result-icon">
                                        groups
                                    </span>


                                    {{-- RESULT CONTENT --}}
                                    <div class="result-content">

                                        <span class="result-title">
                                            Case Conference
                                        </span>


                                        <span class="result-status {{ $statusClass }}">

                                            <span class="status-dot {{ $statusClass }}"></span>

                                            {{ $hasilText }}

                                        </span>

                                    </div>


                                    {{-- RESULT ARROW --}}
                                    <span class="material-symbols-outlined result-arrow">
                                        chevron_right
                                    </span>

                                </a>

                            </td>


                            {{-- =================================================
                            KETERANGAN
                            ================================================== --}}
                            <td class="keterangan-cell">

                                <span class="{{ $keteranganClass }}">

                                    {{ $keterangan }}

                                </span>

                            </td>

                        </tr>


                    @empty

                        <tr id="emptyRow">

                            <td
                                colspan="9"
                                class="empty-state"
                            >

                                <span class="material-symbols-outlined">
                                    event_busy
                                </span>

                                <p>
                                    Belum ada peserta yang telah
                                    melakukan Case Conference.
                                </p>

                            </td>

                        </tr>

                    @endforelse


                    {{-- =================================================
                    EMPTY HASIL FILTER
                    ================================================== --}}

                    @if ($data->count())

                        <tr
                            id="filterEmptyRow"
                            style="display: none;"
                        >

                            <td
                                colspan="9"
                                class="empty-state"
                            >

                                <span class="material-symbols-outlined">
                                    search_off
                                </span>

                                <p>
                                    Data tidak ditemukan.
                                </p>

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


    {{-- =====================================================
    JAVASCRIPT
    ====================================================== --}}

    <script>

        document.addEventListener(
            'DOMContentLoaded',
            function () {

                /*
                |--------------------------------------------------------------------------
                | ELEMENT FILTER
                |--------------------------------------------------------------------------
                */

                const searchInput =
                    document.getElementById(
                        'searchInput'
                    );

                const ppksFilter =
                    document.getElementById(
                        'ppksFilter'
                    );

                const hasilFilter =
                    document.getElementById(
                        'hasilFilter'
                    );

                const tableRows =
                    document.querySelectorAll(
                        '#dataTable tr.case-row'
                    );

                const filterEmptyRow =
                    document.getElementById(
                        'filterEmptyRow'
                    );


                /*
                |--------------------------------------------------------------------------
                | PDF ELEMENT
                |--------------------------------------------------------------------------
                */

                const pdfButton =
                    document.getElementById(
                        'pdfButton'
                    );

                const pdfFilter =
                    document.getElementById(
                        'pdfFilter'
                    );

                const pdfGelombang =
                    document.getElementById(
                        'pdfGelombang'
                    );

                const pdfTahun =
                    document.getElementById(
                        'pdfTahun'
                    );

                const pdfGenerate =
                    document.getElementById(
                        'pdfGenerate'
                    );

                const pdfReset =
                    document.getElementById(
                        'pdfReset'
                    );


                /*
                |--------------------------------------------------------------------------
                | BUKA / TUTUP PDF FILTER
                |--------------------------------------------------------------------------
                */

                if (pdfButton && pdfFilter) {

                    pdfButton.addEventListener(
                        'click',
                        function (event) {

                            event.stopPropagation();

                            pdfFilter.classList.toggle(
                                'active'
                            );

                        }
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | KLIK DI DALAM POPUP
                |--------------------------------------------------------------------------
                */

                if (pdfFilter) {

                    pdfFilter.addEventListener(
                        'click',
                        function (event) {

                            event.stopPropagation();

                        }
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | RESET PDF
                |--------------------------------------------------------------------------
                */

                if (pdfReset) {

                    pdfReset.addEventListener(
                        'click',
                        function () {

                            if (pdfGelombang) {

                                pdfGelombang.value =
                                    '';

                            }

                            if (pdfTahun) {

                                pdfTahun.value =
                                    '';

                            }

                        }
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | BUAT PDF
                |--------------------------------------------------------------------------
                */

                if (pdfGenerate) {

                    pdfGenerate.addEventListener(
                        'click',
                        function () {

                            const gelombang =
                                pdfGelombang
                                    ? pdfGelombang.value
                                    : '';

                            const tahun =
                                pdfTahun
                                    ? pdfTahun.value
                                    : '';


                            const url =
                                new URL(
                                    "{{ route('ppks.normal.case-conference.pdf') }}",
                                    window.location.origin
                                );


                            if (gelombang) {

                                url.searchParams.set(
                                    'gelombang',
                                    gelombang
                                );

                            }


                            if (tahun) {

                                url.searchParams.set(
                                    'tahun',
                                    tahun
                                );

                            }


                            window.open(
                                url.toString(),
                                '_blank'
                            );


                            if (pdfFilter) {

                                pdfFilter.classList.remove(
                                    'active'
                                );

                            }

                        }
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | FILTER TABLE
                |--------------------------------------------------------------------------
                */

                function filterTable() {


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


                    let found =
                        false;


                    let visibleNumber =
                        1;


                    tableRows.forEach(
                        function (row) {




                            const ppks =
                                row.dataset.ppks
                                || '';


                            const hasil =
                                row.dataset.hasil
                                || '';



                            /*
                            |--------------------------------------------------------------------------
                            | FILTER JENIS PPKS
                            |--------------------------------------------------------------------------
                            */

                            const matchPpks =
                                ppksValue === ''
                                ||
                                ppks === ppksValue;


                            /*
                            |--------------------------------------------------------------------------
                            | FILTER HASIL
                            |--------------------------------------------------------------------------
                            */

                            const matchHasil =
                                hasilValue === ''
                                ||
                                hasil === hasilValue;


                            /*
                            |--------------------------------------------------------------------------
                            | FINAL
                            |--------------------------------------------------------------------------
                            */

                            const shouldShow =
                                matchPpks
                                &&
                                matchHasil;


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

                                found =
                                    true;

                            } else {

                                row.style.display =
                                    'none';

                            }

                        }
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | EMPTY FILTER
                    |--------------------------------------------------------------------------
                    */

                    if (filterEmptyRow) {

                        filterEmptyRow.style.display =
                            found
                                ? 'none'
                                : 'table-row';

                    }

                }





                /*
                |--------------------------------------------------------------------------
                | PPKS FILTER EVENT
                |--------------------------------------------------------------------------
                */

                if (ppksFilter) {

                    ppksFilter.addEventListener(
                        'change',
                        filterTable
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | HASIL FILTER EVENT
                |--------------------------------------------------------------------------
                */

                if (hasilFilter) {

                    hasilFilter.addEventListener(
                        'change',
                        filterTable
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | CLICK OUTSIDE PDF
                |--------------------------------------------------------------------------
                */

                document.addEventListener(
                    'click',
                    function () {

                        if (pdfFilter) {

                            pdfFilter.classList.remove(
                                'active'
                            );

                        }

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


</x-app-layout>
