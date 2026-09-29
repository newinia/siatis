<x-app-layout>

    <div class="main-page">

        {{-- =====================================================
        HEADER
        ====================================================== --}}

        <div class="main-page-header">

            <div>

                <h1>Data Lulus Instruktur</h1>

                <p>
                    Data PPKS yang telah lulus Asesmen Instruktur
                    dan dapat melanjutkan ke Asesmen Kesehatan Awal.
                </p>

            </div>

        </div>


        {{-- =====================================================
        FILTER
        ====================================================== --}}

        <div class="filter-wrapper">

            <div class="filter-group">

                {{-- =================================================
                SEARCH NAMA / NIK
                SEARCH DIPROSES OLEH CONTROLLER
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
                        <circle
                            cx="11"
                            cy="11"
                            r="7"
                        />

                        <path
                            d="m20 20-3.5-3.5"
                        />
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


                {{-- =================================================
                RESET FILTER
                ================================================== --}}

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
                        <th>Keterangan</th>

                    </tr>

                </thead>


                <tbody>

                    @forelse ($ppks as $index => $item)

                        @php

                            /*
                            |--------------------------------------------------------------------------
                            | DATA PPKS
                            |--------------------------------------------------------------------------
                            */

                            $data = is_array($item->data)
                                ? $item->data
                                : (
                                    json_decode(
                                        $item->data ?? '{}',
                                        true
                                    ) ?? []
                                );


                            /*
                            |--------------------------------------------------------------------------
                            | NAMA
                            |--------------------------------------------------------------------------
                            */

                            $nama =
                                $data['nama_lengkap']
                                ?? $data['nama']
                                ?? '-';


                            /*
                            |--------------------------------------------------------------------------
                            | NIK
                            |--------------------------------------------------------------------------
                            */

                            $nik =
                                $data['nik']
                                ?? $item->nik
                                ?? '-';


                            /*
                            |--------------------------------------------------------------------------
                            | UMUR
                            |--------------------------------------------------------------------------
                            */

                            $umur =
                                $data['umur']
                                ?? '-';


                            /*
                            |--------------------------------------------------------------------------
                            | JENIS PPKS
                            |--------------------------------------------------------------------------
                            */

                            $jenisPpks =
                                $data['jenis_ppks']
                                ?? '-';


                            /*
                            |--------------------------------------------------------------------------
                            | JURUSAN
                            |--------------------------------------------------------------------------
                            */

                            $jurusan =
                                $data['jurusan_yang_diminati']
                                ?? $data['jurusan']
                                ?? $data['jurusan_pelatihan']
                                ?? '-';


                            /*
                            |--------------------------------------------------------------------------
                            | PROSES INSTRUKTUR TERAKHIR
                            |--------------------------------------------------------------------------
                            */

                            $prosesInstruktur =
                                $item->prosesPesertas
                                    ->where('tahap', 'instruktur')
                                    ->sortByDesc(function ($proses) {

                                        return $proses->tanggal_proses
                                            ?? $proses->created_at;

                                    })
                                    ->first();


                            /*
                            |--------------------------------------------------------------------------
                            | KETERANGAN
                            |--------------------------------------------------------------------------
                            */

                            $keterangan =
                                $data['catatan_asesmen_instruktur']
                                ?? $prosesInstruktur?->catatan
                                ?? '-';


                            /*
                            |--------------------------------------------------------------------------
                            | BADGE
                            |--------------------------------------------------------------------------
                            */

                            $route =
                                route(
                                    'ppks.normal.asesmen-instruktur.detail',
                                    $item->id
                                );

                            $badgeClass =
                                'result-instructor';

                            $hasilIcon =
                                'assignment';

                            $labelTahapan =
                                'Asesmen Instruktur';

                            $hasil =
                                'Lulus';

                            $hasilClass =
                                'lulus';

                            $hasilDotClass =
                                'lulus';

                        @endphp


                        <tr
                            data-nama="{{ strtolower($nama) }}"
                            data-nik="{{ strtolower($nik) }}"
                            data-ppks="{{ strtolower($jenisPpks) }}"
                        >

                            {{-- =================================================
                            NO
                            ================================================== --}}

                            <td class="row-number">

                                {{ $ppks->firstItem() + $index }}

                            </td>


                            {{-- =================================================
                            NAMA
                            ================================================== --}}

                            <td>

                                {{ $nama }}

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
                            KHUSUS LULUS INSTRUKTUR
                            ================================================== --}}

                            <td>

                                <x-result-badge
                                    :route="$route"
                                    :badge-class="$badgeClass"
                                    :hasil-icon="$hasilIcon"
                                    :label-tahapan="$labelTahapan"
                                    :hasil-class="$hasilClass"
                                    :hasil-dot-class="$hasilDotClass"
                                    :hasil="$hasil"
                                />

                            </td>


                            {{-- =================================================
                            KETERANGAN
                            ================================================== --}}

                            <td>

                                <span class="keterangan-text">

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
                                        Belum ada data PPKS yang lulus Asesmen Instruktur
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- =====================================================
        PAGINATION
        ====================================================== --}}

        @if ($ppks instanceof \Illuminate\Pagination\LengthAwarePaginator)

            <div class="pagination-wrapper">

                {{ $ppks->withQueryString()->links() }}

            </div>

        @endif

    </div>


    {{-- =========================================================
    JAVASCRIPT FILTER JENIS PPKS
    ========================================================= --}}

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


                /* =====================================================
                FILTER TABLE
                ===================================================== */

                function filterTable() {

                    const ppksValue =
                        ppksFilter
                            ? ppksFilter.value
                                .toLowerCase()
                                .trim()
                            : '';


                    let number =
                        1;


                    tableRows.forEach(
                        function (row) {

                            const jenisPpks =
                                (
                                    row.dataset.ppks || ''
                                ).toLowerCase();


                            const matchPpks =
                                ppksValue === '' ||
                                jenisPpks === ppksValue;


                            row.style.display =
                                matchPpks
                                    ? ''
                                    : 'none';


                            /* =================================================
                            NOMOR URUT
                            ================================================== */

                            if (matchPpks) {

                                const numberCell =
                                    row.querySelector(
                                        '.row-number'
                                    );


                                if (numberCell) {

                                    numberCell.textContent =
                                        number;

                                }


                                number++;

                            }

                        }
                    );


                    /* =================================================
                    ACTIVE STATE FILTER
                    ================================================== */

                    if (ppksFilter) {

                        ppksFilter.classList.toggle(
                            'active',
                            ppksFilter.value !== ''
                        );

                    }

                }


                /* =====================================================
                EVENT FILTER JENIS PPKS
                ===================================================== */

                if (ppksFilter) {

                    ppksFilter.addEventListener(
                        'change',
                        filterTable
                    );

                }


                /* =====================================================
                RESET SEMUA FILTER
                ===================================================== */

                if (resetAllFilters) {

                    resetAllFilters.addEventListener(
                        'click',
                        function () {

                            /*
                            Search Nama/NIK menggunakan GET.
                            Reset menghapus parameter search
                            dari URL dan mengembalikan halaman
                            ke kondisi awal.
                            */

                            window.location.href =
                                window.location.pathname;

                        }
                    );

                }


                /* =====================================================
                INITIAL FILTER
                ===================================================== */

                filterTable();

            }
        );

    </script>

</x-app-layout>