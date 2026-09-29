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

        </div>


        {{-- =====================================================
        FILTER
        ====================================================== --}}
        <div class="filter-wrapper">

            <div class="filter-group">

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

            </div>


            {{-- RESET --}}
            <button
                type="button"
                id="resetAllFilters"
                class="filter-reset"
            >

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
                        <th>Jurusan Peminatan</th>
                        <th>Hasil</th>

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

                            @endphp


                            <tr
                                data-nama="{{ strtolower($nama) }}"
                                data-nik="{{ strtolower($nik) }}"
                                data-ppks="{{ strtolower($jenisPpks) }}"
                            >

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

                                        <a
                                            href="{{ route('ppks.normal') }}"
                                            class="result-badge result-accepted"
                                        >

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

                                        <a
                                            href="{{ route('ppks.normal') }}"
                                            class="result-badge result-rejected"
                                        >

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

                                        <a
                                            href="{{ route('ppks.normal.asesmen-instruktur.data-detail', $item->id) }}"
                                            class="result-badge result-not-done"
                                        >

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

                                        <a
                                            href="{{ route('ppks.normal.asesmen-instruktur.detail', $item->id) }}"
                                            class="result-badge result-instructor"
                                        >

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

                                        <a
                                            href="{{ route('ppks.normal') }}"
                                            class="result-badge result-health"
                                        >

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

                                        <a
                                            href="{{ route('ppks.normal') }}"
                                            class="result-badge result-case-conference"
                                        >

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

                            </tr>

                        @endforeach


                    @else

                        <tr>

                            <td
                                colspan="7"
                                style="text-align: center; padding: 40px;"
                            >

                                <div class="empty-state">

                                    <span class="material-symbols-outlined">
                                        folder_open
                                    </span>

                                    <p>
                                        Belum ada data yang dapat diolah
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endif

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

                const ppksFilter =
                    document.getElementById('ppksFilter');

                const resetAllFilters =
                    document.getElementById('resetAllFilters');

                const tableRows =
                    document.querySelectorAll(
                        '.table tbody tr[data-nama]'
                    );


                /*
                |--------------------------------------------------------------------------
                | FILTER JENIS PPKS
                |--------------------------------------------------------------------------
                */

                function filterTable() {

                    const ppksValue =
                        ppksFilter
                            ? ppksFilter.value
                                .toLowerCase()
                                .trim()
                            : '';


                    let visibleNumber =
                        {{ $ppks->firstItem() ?? 1 }};


                    tableRows.forEach(
                        function (row) {

                            const jenisPpks =
                                (
                                    row.dataset.ppks || ''
                                ).toLowerCase();


                            const matchPpks =
                                ppksValue === '' ||
                                jenisPpks.includes(
                                    ppksValue
                                );


                            if (matchPpks) {

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

                            } else {

                                row.style.display =
                                    'none';

                            }

                        }
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | ACTIVE STATE FILTER
                    |--------------------------------------------------------------------------
                    */

                    if (ppksFilter) {

                        ppksFilter.classList.toggle(
                            'active',
                            ppksFilter.value !== ''
                        );

                    }

                }


                /*
                |--------------------------------------------------------------------------
                | EVENT FILTER PPKS
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
                | RESET SEMUA FILTER
                |--------------------------------------------------------------------------
                */

                if (resetAllFilters) {

                    resetAllFilters.addEventListener(
                        'click',
                        function () {

                            window.location.href =
                                window.location.pathname;

                        }
                    );

                }


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