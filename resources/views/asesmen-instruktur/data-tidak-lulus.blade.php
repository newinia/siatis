<x-app-layout>

    <div class="main-page">

        {{-- =====================================================
        HEADER
        ======================================================= --}}

        <div class="main-page-header">

            <div>

                <h1>
                    Data Tidak Lulus Instruktur
                </h1>

                <p>
                    Data PPKS yang tidak lulus Asesmen Instruktur
                    dan tidak dapat melanjutkan ke tahap berikutnya.
                </p>

            </div>

        </div>


        {{-- =====================================================
        FILTER
        ======================================================= --}}

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


                {{-- FILTER JENIS PPKS --}}

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


                {{-- RESET FILTER --}}

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
                            | DATA
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
                            | Google Sheet:
                            | Kolom B = index 1
                            |--------------------------------------------------------------------------
                            */

                            $nama = null;

                            if (
                                array_key_exists(1, $data)
                                && $data[1] !== null
                                && trim((string) $data[1]) !== ''
                            ) {

                                $nama = $data[1];

                            } elseif (
                                array_key_exists('B', $data)
                                && $data['B'] !== null
                                && trim((string) $data['B']) !== ''
                            ) {

                                $nama = $data['B'];

                            } elseif (
                                array_key_exists('nama_lengkap', $data)
                                && $data['nama_lengkap'] !== null
                                && trim((string) $data['nama_lengkap']) !== ''
                            ) {

                                $nama = $data['nama_lengkap'];

                            } elseif (
                                array_key_exists('nama', $data)
                                && $data['nama'] !== null
                                && trim((string) $data['nama']) !== ''
                            ) {

                                $nama = $data['nama'];

                            }

                            $nama = $nama ?: '-';


                            /*
                            |--------------------------------------------------------------------------
                            | NIK
                            | Google Sheet:
                            | Kolom C = index 2
                            |--------------------------------------------------------------------------
                            */

                            $nik = null;

                            if (
                                array_key_exists(2, $data)
                                && $data[2] !== null
                                && trim((string) $data[2]) !== ''
                            ) {

                                $nik = $data[2];

                            } elseif (
                                array_key_exists('C', $data)
                                && $data['C'] !== null
                                && trim((string) $data['C']) !== ''
                            ) {

                                $nik = $data['C'];

                            } elseif (
                                array_key_exists('nik', $data)
                                && $data['nik'] !== null
                                && trim((string) $data['nik']) !== ''
                            ) {

                                $nik = $data['nik'];

                            } elseif ($item->nik) {

                                $nik = $item->nik;

                            }

                            $nik = $nik ?: '-';


                            /*
                            |--------------------------------------------------------------------------
                            | UMUR
                            | Google Sheet:
                            | Kolom G = index 6
                            |--------------------------------------------------------------------------
                            */

                            $umur = null;

                            if (
                                array_key_exists(6, $data)
                                && $data[6] !== null
                                && trim((string) $data[6]) !== ''
                            ) {

                                $umur = $data[6];

                            } elseif (
                                array_key_exists('G', $data)
                                && $data['G'] !== null
                                && trim((string) $data['G']) !== ''
                            ) {

                                $umur = $data['G'];

                            } elseif (
                                array_key_exists('umur', $data)
                                && $data['umur'] !== null
                                && trim((string) $data['umur']) !== ''
                            ) {

                                $umur = $data['umur'];

                            } elseif (
                                array_key_exists('usia', $data)
                                && $data['usia'] !== null
                                && trim((string) $data['usia']) !== ''
                            ) {

                                $umur = $data['usia'];

                            }

                            $umur = $umur ?: '-';
                            $umur = trim((string) $umur);


                            /*
                            |--------------------------------------------------------------------------
                            | JENIS PPKS
                            | Google Sheet:
                            | Kolom M = index 12
                            |--------------------------------------------------------------------------
                            */

                            $jenisPpks = null;

                            if (
                                array_key_exists(12, $data)
                                && $data[12] !== null
                                && trim((string) $data[12]) !== ''
                            ) {

                                $jenisPpks = $data[12];

                            } elseif (
                                array_key_exists('M', $data)
                                && $data['M'] !== null
                                && trim((string) $data['M']) !== ''
                            ) {

                                $jenisPpks = $data['M'];

                            } elseif (
                                array_key_exists('jenis_ppks', $data)
                                && $data['jenis_ppks'] !== null
                                && trim((string) $data['jenis_ppks']) !== ''
                            ) {

                                $jenisPpks = $data['jenis_ppks'];

                            }

                            $jenisPpks = $jenisPpks ?: '-';


                            /*
                            |--------------------------------------------------------------------------
                            | JURUSAN
                            | Google Sheet:
                            | Kolom O = index 14
                            |--------------------------------------------------------------------------
                            */

                            $jurusan = null;

                            if (
                                array_key_exists(14, $data)
                                && $data[14] !== null
                                && trim((string) $data[14]) !== ''
                            ) {

                                $jurusan = $data[14];

                            } elseif (
                                array_key_exists('O', $data)
                                && $data['O'] !== null
                                && trim((string) $data['O']) !== ''
                            ) {

                                $jurusan = $data['O'];

                            } elseif (
                                array_key_exists('jurusan_yang_diminati', $data)
                                && $data['jurusan_yang_diminati'] !== null
                                && trim((string) $data['jurusan_yang_diminati']) !== ''
                            ) {

                                $jurusan =
                                    $data['jurusan_yang_diminati'];

                            } elseif (
                                array_key_exists('jurusan', $data)
                                && $data['jurusan'] !== null
                                && trim((string) $data['jurusan']) !== ''
                            ) {

                                $jurusan =
                                    $data['jurusan'];

                            } elseif (
                                array_key_exists('jurusan_pelatihan', $data)
                                && $data['jurusan_pelatihan'] !== null
                                && trim((string) $data['jurusan_pelatihan']) !== ''
                            ) {

                                $jurusan =
                                    $data['jurusan_pelatihan'];

                            }

                            $jurusan = $jurusan ?: '-';


                            /*
                            |--------------------------------------------------------------------------
                            | PROSES INSTRUKTUR
                            |--------------------------------------------------------------------------
                            */

                            $prosesInstruktur = $item->prosesPesertas
                                ->where('tahap', 'instruktur')
                                ->sortByDesc(function ($p) {

                                    return $p->tanggal_proses
                                        ?? $p->created_at;

                                })
                                ->first();


                            /*
                            |--------------------------------------------------------------------------
                            | KETERANGAN
                            |--------------------------------------------------------------------------
                            */

                            $keterangan =
                                $data['catatan_asesmen_instruktur']
                                ?? null;

                            if (
                                !$keterangan &&
                                $prosesInstruktur
                            ) {

                                $keterangan =
                                    $prosesInstruktur->catatan
                                    ?: $prosesInstruktur->alasan_pending
                                    ?: null;

                            }

                            $keterangan =
                                $keterangan ?: '-';


                            /*
                            |--------------------------------------------------------------------------
                            | RESULT BADGE
                            |--------------------------------------------------------------------------
                            */

                            $route = route(
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
                                'Tidak Lulus';

                            $hasilClass =
                                'tidak-lulus';

                            $hasilDotClass =
                                'tidak-lulus';

                        @endphp


                        <tr
                            data-nama="{{ strtolower((string) $nama) }}"
                            data-nik="{{ strtolower((string) $nik) }}"
                            data-ppks="{{ strtolower((string) $jenisPpks) }}"
                        >

                            {{-- =================================================
                            NOMOR
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

                            <td class="keterangan-cell">

                                @if (
                                    $keterangan !== '-' &&
                                    trim((string) $keterangan) !== ''
                                )

                                    <span class="keterangan-text">
                                        {{ $keterangan }}
                                    </span>

                                @else

                                    <span class="keterangan-empty">
                                        -
                                    </span>

                                @endif

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
                                        Belum ada data PPKS yang tidak lulus
                                        Asesmen Instruktur
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse


                    {{-- =================================================
                    EMPTY HASIL FILTER
                    ================================================== --}}

                    @if ($ppks->count() > 0)

                        <tr
                            id="filterEmptyRow"
                            class="filter-empty-row"
                            style="display:none;"
                        >

                            <td colspan="8">

                                <div class="empty-state-icon">

                                    <span class="material-symbols-outlined">
                                        search_off
                                    </span>

                                </div>

                                <p class="empty-state-title">
                                    Data tidak ditemukan
                                </p>

                                <p class="empty-state-text">
                                    Tidak ada data yang sesuai
                                    dengan filter yang dipilih.
                                </p>

                            </td>

                        </tr>

                    @endif

                </tbody>

            </table>

        </div>


        {{-- =====================================================
        PAGINATION
        ======================================================= --}}

        @if ($ppks->hasPages())

            <div class="pagination-wrapper">

                {{ $ppks->withQueryString()->links() }}

            </div>

        @endif

    </div>


    {{-- =========================================================
    JAVASCRIPT
    ========================================================== --}}

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const ppksFilter =
                document.getElementById('ppksFilter');

            const resetAllFilters =
                document.getElementById('resetAllFilters');

            const rows =
                document.querySelectorAll(
                    '.table tbody tr[data-nama]'
                );

            const filterEmptyRow =
                document.getElementById('filterEmptyRow');


            /*
            =====================================================
            SIMPAN NOMOR AWAL
            =====================================================
            */

            rows.forEach(function (row) {

                const numberCell =
                    row.querySelector('.row-number');

                if (numberCell) {

                    row.dataset.originalNumber =
                        numberCell.textContent.trim();

                }

            });


            /*
            =====================================================
            FILTER TABLE
            =====================================================
            */

            function filterTable() {

                const ppks =
                    ppksFilter
                        ? ppksFilter.value
                            .toLowerCase()
                            .trim()
                        : '';

                let visibleNumber = 1;
                let visibleCount = 0;


                rows.forEach(function (row) {

                    const jenis =
                        (
                            row.dataset.ppks || ''
                        ).toLowerCase();


                    const ppksMatch =
                        !ppks ||
                        jenis === ppks;


                    row.style.display =
                        ppksMatch
                            ? ''
                            : 'none';


                    if (ppksMatch) {

                        visibleCount++;

                        const numberCell =
                            row.querySelector(
                                '.row-number'
                            );

                        if (numberCell) {

                            if (ppks !== '') {

                                numberCell.textContent =
                                    visibleNumber++;

                            } else {

                                numberCell.textContent =
                                    row.dataset.originalNumber;

                            }

                        }

                    }

                });


                /*
                =================================================
                EMPTY FILTER
                =================================================
                */

                if (filterEmptyRow) {

                    filterEmptyRow.style.display =
                        visibleCount === 0
                            ? 'table-row'
                            : 'none';

                }

            }


            /*
            =====================================================
            FILTER JENIS PPKS
            =====================================================
            */

            if (ppksFilter) {

                ppksFilter.addEventListener(
                    'change',
                    filterTable
                );

            }


            /*
            =====================================================
            RESET
            =====================================================
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
            =====================================================
            FILTER AWAL
            =====================================================
            */

            filterTable();

        });

    </script>

</x-app-layout>