<x-app-layout>

    <div class="main-page">

        {{-- =====================================================
        HEADER
        ====================================================== --}}

        <div class="main-page-header">

            <div>
                <h1>Data Pending Instruktur</h1>

                <p>
                    Data PPKS yang masih berstatus pending setelah Asesmen Instruktur.
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
                            |--------------------------------------------------------------------------
                            */

                            $nama = '-';

                            if (
                                array_key_exists(1, $data) &&
                                trim((string) $data[1]) !== ''
                            ) {

                                $nama = $data[1];

                            } elseif (
                                array_key_exists('B', $data) &&
                                trim((string) $data['B']) !== ''
                            ) {

                                $nama = $data['B'];

                            } elseif (
                                !empty($data['nama_lengkap'])
                            ) {

                                $nama = $data['nama_lengkap'];

                            } elseif (
                                !empty($data['nama'])
                            ) {

                                $nama = $data['nama'];

                            }


                            /*
                            |--------------------------------------------------------------------------
                            | NIK
                            |--------------------------------------------------------------------------
                            */

                            $nik = '-';

                            if (
                                array_key_exists(2, $data) &&
                                trim((string) $data[2]) !== ''
                            ) {

                                $nik = $data[2];

                            } elseif (
                                array_key_exists('C', $data) &&
                                trim((string) $data['C']) !== ''
                            ) {

                                $nik = $data['C'];

                            } elseif (
                                !empty($data['nik'])
                            ) {

                                $nik = $data['nik'];

                            } elseif (
                                !empty($item->nik)
                            ) {

                                $nik = $item->nik;

                            }


                            /*
                            |--------------------------------------------------------------------------
                            | UMUR
                            |--------------------------------------------------------------------------
                            */

                            $umur = null;

                            if (
                                array_key_exists(6, $data) &&
                                $data[6] !== null &&
                                trim((string) $data[6]) !== ''
                            ) {

                                $umur = $data[6];

                            } elseif (
                                array_key_exists('G', $data) &&
                                $data['G'] !== null &&
                                trim((string) $data['G']) !== ''
                            ) {

                                $umur = $data['G'];

                            } elseif (
                                array_key_exists('umur', $data) &&
                                $data['umur'] !== null &&
                                trim((string) $data['umur']) !== ''
                            ) {

                                $umur = $data['umur'];

                            } elseif (
                                array_key_exists('usia', $data) &&
                                $data['usia'] !== null &&
                                trim((string) $data['usia']) !== ''
                            ) {

                                $umur = $data['usia'];

                            }

                            if (
                                $umur === null ||
                                trim((string) $umur) === ''
                            ) {

                                $umur = '-';

                            }

                            $umur = trim((string) $umur);


                            /*
                            |--------------------------------------------------------------------------
                            | JENIS PPKS
                            |--------------------------------------------------------------------------
                            */

                            $jenisPpks = '-';

                            if (
                                array_key_exists(12, $data) &&
                                trim((string) $data[12]) !== ''
                            ) {

                                $jenisPpks = $data[12];

                            } elseif (
                                array_key_exists('M', $data) &&
                                trim((string) $data['M']) !== ''
                            ) {

                                $jenisPpks = $data['M'];

                            } elseif (
                                !empty($data['jenis_ppks'])
                            ) {

                                $jenisPpks = $data['jenis_ppks'];

                            }


                            /*
                            |--------------------------------------------------------------------------
                            | JURUSAN
                            |--------------------------------------------------------------------------
                            */

                            $jurusan = '-';

                            if (
                                array_key_exists(14, $data) &&
                                trim((string) $data[14]) !== ''
                            ) {

                                $jurusan = $data[14];

                            } elseif (
                                array_key_exists('O', $data) &&
                                trim((string) $data['O']) !== ''
                            ) {

                                $jurusan = $data['O'];

                            } elseif (
                                !empty($data['jurusan_yang_diminati'])
                            ) {

                                $jurusan =
                                    $data['jurusan_yang_diminati'];

                            } elseif (
                                !empty($data['jurusan'])
                            ) {

                                $jurusan =
                                    $data['jurusan'];

                            } elseif (
                                !empty($data['jurusan_pelatihan'])
                            ) {

                                $jurusan =
                                    $data['jurusan_pelatihan'];

                            }


                            /*
                            |--------------------------------------------------------------------------
                            | PROSES INSTRUKTUR
                            |--------------------------------------------------------------------------
                            */

                            $prosesInstruktur = $item->prosesPesertas
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

                            $keterangan = null;

                            if (
                                isset($data['catatan_asesmen_instruktur']) &&
                                trim((string) $data['catatan_asesmen_instruktur']) !== ''
                            ) {

                                $keterangan =
                                    $data['catatan_asesmen_instruktur'];

                            }


                            if (
                                (!$keterangan ||
                                    trim((string) $keterangan) === '') &&
                                $prosesInstruktur
                            ) {

                                if (
                                    isset($prosesInstruktur->catatan) &&
                                    trim((string) $prosesInstruktur->catatan) !== ''
                                ) {

                                    $keterangan =
                                        $prosesInstruktur->catatan;

                                }

                            }


                            if (
                                (!$keterangan ||
                                    trim((string) $keterangan) === '') &&
                                $prosesInstruktur
                            ) {

                                if (
                                    isset($prosesInstruktur->alasan_pending) &&
                                    trim((string) $prosesInstruktur->alasan_pending) !== ''
                                ) {

                                    $keterangan =
                                        $prosesInstruktur->alasan_pending;

                                }

                            }


                            if (
                                !$keterangan ||
                                trim((string) $keterangan) === ''
                            ) {

                                $keterangan = '-';

                            }


                            /*
                            |--------------------------------------------------------------------------
                            | STATUS
                            |--------------------------------------------------------------------------
                            */

                            $statusProses =
                                $prosesInstruktur?->status
                                ?? 'pending';


                            /*
                            |--------------------------------------------------------------------------
                            | BADGE
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
                                'Pending';

                            $hasilClass =
                                'pending';

                            $hasilDotClass =
                                'pending';

                        @endphp


                        <tr
                            data-nama="{{ strtolower((string) $nama) }}"
                            data-nik="{{ strtolower((string) $nik) }}"
                            data-ppks="{{ strtolower((string) $jenisPpks) }}"
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

                                @if ($keterangan !== '-')

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
                                        Belum ada data PPKS yang pending
                                        setelah Asesmen Instruktur
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
                            style="display: none;"
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
        ====================================================== --}}

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
            SIMPAN NOMOR ASLI
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
            FILTER PERTAMA KALI
            =====================================================
            */

            filterTable();

        });

    </script>

</x-app-layout>