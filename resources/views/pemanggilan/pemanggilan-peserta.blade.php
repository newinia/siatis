<x-app-layout>

    <div class="main-page">

        {{-- =====================================================
        HEADER
        ====================================================== --}}
        <div class="main-page-header">

            <div>
                <h1>Data Pemanggilan Peserta</h1>

                <p>
                    Data PPKS yang telah diterima pada Case Conference
                </p>
            </div>


            {{-- =================================================
            PDF ACTION
            ================================================== --}}
            <div class="pdf-filter-wrapper">

                <button type="button" class="pdf-button" id="pdfButton">
                    <span class="material-symbols-outlined">
                        picture_as_pdf
                    </span>

                    PDF
                </button>


                {{-- =================================================
                PDF FILTER POPUP
                ================================================== --}}
                <div class="pdf-filter" id="pdfFilter">

                    <div class="pdf-filter-title">
                        Download PDF
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

                        <button type="button" class="pdf-reset" id="pdfReset">
                            Reset
                        </button>

                        <button type="button" class="pdf-generate" id="pdfGenerate">
                            Buat PDF
                        </button>

                    </div>

                </div>

            </div>

        </div>


        {{-- =====================================================
        FILTER
        ====================================================== --}}
        <form method="GET" action="{{ url()->current() }}" class="filter-wrapper" id="filterForm">

            {{-- SEARCH --}}
            <div class="search">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2">

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

            </div>


            {{-- FILTER STATUS --}}
            <div class="select-wrapper">

                <select
                    name="status"
                    id="statusFilter"
                    class="filter-button"
                    onchange="this.form.submit()"
                >

                    <option value="">Semua Status</option>

                    <option
                        value="belum_dipanggil"
                        @selected(request('status') === 'belum_dipanggil')
                    >
                        Belum Dipanggil
                    </option>

                    <option
                        value="sudah_dipanggil"
                        @selected(request('status') === 'sudah_dipanggil')
                    >
                        Sudah Dipanggil
                    </option>

                    <option
                        value="belum_datang"
                        @selected(request('status') === 'belum_datang')
                    >
                        Belum Datang
                    </option>

                    <option
                        value="sudah_datang"
                        @selected(request('status') === 'sudah_datang')
                    >
                        Sudah Datang
                    </option>

                </select>

                <span class="material-symbols-outlined select-arrow">
                    keyboard_arrow_down
                </span>

            </div>


            {{-- FILTER GELOMBANG --}}
            <div class="select-wrapper">

                <select
                    name="gelombang"
                    id="gelombangFilter"
                    class="filter-button"
                    onchange="this.form.submit()"
                >

                    <option value="">Semua Gelombang</option>

                    @foreach ($gelombangOptions as $gelombangOption)

                        <option
                            value="{{ $gelombangOption }}"
                            @selected((string) request('gelombang') === (string) $gelombangOption)
                        >
                            Gelombang {{ $gelombangOption }}
                        </option>

                    @endforeach

                </select>

                <span class="material-symbols-outlined select-arrow">
                    keyboard_arrow_down
                </span>

            </div>


            {{-- FILTER TAHUN --}}
            <div class="select-wrapper">

                <select
                    name="tahun"
                    id="tahunFilter"
                    class="filter-button"
                    onchange="this.form.submit()"
                >

                    <option value="">Semua Tahun</option>

                    @foreach ($tahunOptions as $tahunOption)

                        <option
                            value="{{ $tahunOption }}"
                            @selected((string) request('tahun') === (string) $tahunOption)
                        >
                            {{ $tahunOption }}
                        </option>

                    @endforeach

                </select>

                <span class="material-symbols-outlined select-arrow">
                    keyboard_arrow_down
                </span>

            </div>


            {{-- RESET --}}
            @if (
                request()->filled('search') ||
                request()->filled('status') ||
                request()->filled('gelombang') ||
                request()->filled('tahun')
            )

                <a href="{{ url()->current() }}" class="filter-reset">
                    <span class="material-symbols-outlined">
                    restart_alt
                </span>
                    Reset
                </a>

            @endif

        </form>


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

                        <th>Gelombang / Tahun</th>

                        <th>Status Pemanggilan</th>

                        <th>Tanggal Pemanggilan</th>

                        <th>Tanggal Kedatangan</th>

                        <th>Aksi</th>

                    </tr>

                </thead>


                <tbody>

                    @forelse ($pesertas as $index => $ppks)

                                        @php

                                            /*
                                            |--------------------------------------------------------------------------
                                            | DATA PPKS
                                            |--------------------------------------------------------------------------
                                            */

                                            $data = $ppks->data ?? [];

                                            if (!is_array($data)) {

                                                $data = json_decode(
                                                    $data,
                                                    true
                                                ) ?? [];

                                            }


                                            /*
                                            |--------------------------------------------------------------------------
                                            | DATA PEMANGGILAN
                                            |--------------------------------------------------------------------------
                                            */

                                            $pemanggilan =
                                                $ppks->pemanggilanPeserta;


                                            /*
                                            |--------------------------------------------------------------------------
                                            | DATA CASE CONFERENCE
                                            |--------------------------------------------------------------------------
                                            */

                                            $caseConference =
                                                $caseConferences->get(
                                                    $ppks->id
                                                );


                                            /*
                                            |--------------------------------------------------------------------------
                                            | DATA ASESMEN INSTRUKTUR
                                            |--------------------------------------------------------------------------
                                            */

                                            $asesmenInstruktur =
                                                $ppks->asesmenInstruktur;


                                            /*
                                            |--------------------------------------------------------------------------
                                            | IDENTITAS
                                            |--------------------------------------------------------------------------
                                            */

                                            $nama =
                                                $data['nama_lengkap']
                                                ?? '-';

                                            $nik =
                                                $data['nik']
                                                ?? '-';


                                            /*
                                            |--------------------------------------------------------------------------
                                            | DATA UNTUK POPUP
                                            |--------------------------------------------------------------------------
                                            */

                                            $jenisPpks =
                                                $data['jenis_ppks']
                                                ?? '-';

                                            $noHp1 =
                                                $data['no_hp_1']
                                                ?? $data['nomor_hp_1']
                                                ?? $data['no_telepon']
                                                ?? $data['nomor_telepon']
                                                ?? '-';

                                            $jurusan =
                                                $caseConference?->jurusan_diterima
                                                ?? '-';


                                            /*
                                            |--------------------------------------------------------------------------
                                            | BAZNAS
                                            |--------------------------------------------------------------------------
                                            */

                                            $baznas =
                                                $asesmenInstruktur?->baznas
                                                ?? '';


                                            /*
                                            |--------------------------------------------------------------------------
                                            | GELOMBANG DAN TAHUN
                                            |--------------------------------------------------------------------------
                                            */

                                            $gelombang =
                                                'Gelombang ' .
                                                ($caseConference?->gelombang_pelatihan ?? '-');

                                            $tahun =
                                                $caseConference?->tahun_pelatihan
                                                ?? '-';


                                            /*
                                            |--------------------------------------------------------------------------
                                            | ALAMAT
                                            |--------------------------------------------------------------------------
                                            */

                                            $alamat =
                                                $data['alamat_lengkap']
                                                ?? $data['alamat']
                                                ?? '-';


                                            /*
                                            |--------------------------------------------------------------------------
                                            | STATUS PEMANGGILAN
                                            |--------------------------------------------------------------------------
                                            */

                                            $status =
                                                $pemanggilan?->status_pemanggilan
                                                ?? 'belum_dipanggil';


                                            /*
                                            |--------------------------------------------------------------------------
                                            | TANGGAL PEMANGGILAN
                                            |--------------------------------------------------------------------------
                                            */

                                            $tanggalPemanggilan =
                                                $pemanggilan?->tanggal_pemanggilan;

                                            $tanggalPemanggilanValue =
                                                $tanggalPemanggilan
                                                ? $tanggalPemanggilan->format('Y-m-d')
                                                : '';

                                            $tanggalPemanggilanTampil =
                                                $tanggalPemanggilan
                                                ? $tanggalPemanggilan->format('d-m-Y')
                                                : '-';


                                            /*
                                            |--------------------------------------------------------------------------
                                            | TANGGAL KEDATANGAN
                                            |--------------------------------------------------------------------------
                                            */

                                            $tanggalKedatangan =
                                                $pemanggilan?->tanggal_kedatangan;

                                            $tanggalKedatanganValue =
                                                $tanggalKedatangan
                                                ? $tanggalKedatangan->format('Y-m-d')
                                                : '';

                                            $tanggalKedatanganTampil =
                                                $tanggalKedatangan
                                                ? $tanggalKedatangan->format('d-m-Y')
                                                : '-';


                                            /*
                                            |--------------------------------------------------------------------------
                                            | LABEL STATUS
                                            |--------------------------------------------------------------------------
                                            */

                                            $statusLabel = match ($status) {

                                                'sudah_dipanggil' =>
                                                    'Sudah Dipanggil',

                                                'belum_datang' =>
                                                    'Belum Datang',

                                                'sudah_datang' =>
                                                    'Sudah Datang',

                                                default =>
                                                    'Belum Dipanggil',

                                            };


                                            /*
                                            |--------------------------------------------------------------------------
                                            | CLASS STATUS
                                            |--------------------------------------------------------------------------
                                            */

                                            $statusClass =
                                                str_replace(
                                                    '_',
                                                    '-',
                                                    $status
                                                );

                                        @endphp


                                        <tr data-nama="{{ strtolower($nama) }}" data-nik="{{ strtolower($nik) }}"
                                            data-status="{{ $status }}" data-tanggal="{{ $tanggalPemanggilanValue }}">

                                            {{-- NO --}}
                                            <td class="row-number">
                                                {{ $pesertas->firstItem() + $index }}
                                            </td>


                                            {{-- NAMA --}}
                                            <td>
                                                {{ $nama }}
                                            </td>


                                            {{-- NIK --}}
                                            <td>
                                                {{ $nik }}
                                            </td>


                                            {{-- GELOMBANG / TAHUN --}}
                                            <td>
                                                {{ $gelombang }} / {{ $tahun }}
                                            </td>


                                            {{-- STATUS --}}
                                            <td>

                                                <span class="pemanggilan-status-badge {{ $statusClass }}">

                                                    <span class="pemanggilan-status-dot"></span>

                                                    {{ $statusLabel }}

                                                </span>

                                            </td>


                                            {{-- TANGGAL PEMANGGILAN --}}
                                            <td>
                                                {{ $tanggalPemanggilanTampil }}
                                            </td>


                                            {{-- TANGGAL KEDATANGAN --}}
                                            <td>
                                                {{ $tanggalKedatanganTampil }}
                                            </td>


                                            {{-- AKSI --}}
                                            <td>

                                                <button type="button" class="action-btn action-btn-edit" data-action="{{ route(
                            'ppks.normal.pemanggilan.proses',
                            $ppks
                        ) }}" data-id="{{ $ppks->id }}" data-nama="{{ $nama }}" data-nik="{{ $nik }}"
                                                    data-jenis-ppks="{{ $jenisPpks }}" data-jurusan="{{ $jurusan }}"
                                                    data-gelombang="{{ $gelombang }}" data-tahun="{{ $tahun }}" data-baznas="{{ $baznas }}"
                                                    data-no-hp-1="{{ $noHp1 }}" data-alamat="{{ $alamat }}" data-status="{{ $status }}"
                                                    data-tanggal-pemanggilan="{{ $tanggalPemanggilanValue }}"
                                                    data-tanggal-kedatangan="{{ $tanggalKedatanganValue }}">

                                                    <span class="material-symbols-outlined">
                                                        edit
                                                    </span>

                                                    Ubah

                                                </button>

                                            </td>

                                        </tr>

                    @empty

                        <tr>

                            <td colspan="8" style="text-align:center; padding:40px;">

                                <div class="empty-state">

                                    <span class="material-symbols-outlined">
                                        assignment_late
                                    </span>

                                    <p>
                                        Belum ada data PPKS yang bisa dipanggil
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
        @if ($pesertas->hasPages())

            <div class="pagination-wrapper">
                {{ $pesertas->withQueryString()->links() }}
            </div>

        @endif

    </div>



    {{-- =====================================================
    GLOBAL POPUP PEMANGGILAN
    ====================================================== --}}

    <div class="global-popup info" id="pemanggilanPopup">

        <div class="global-popup-box pemanggilan-popup-box" style="position: relative;">

            <button type="button" class="global-popup-close" onclick="closePemanggilanPopup()">

                <span class="material-symbols-outlined">
                    close
                </span>

            </button>


            <div class="global-popup-icon">

                <span class="material-symbols-outlined">
                    campaign
                </span>

            </div>


            {{-- =================================================
            INFORMASI PESERTA
            ================================================== --}}

            <div class="global-popup-identity">

                <p class="global-popup-name" id="popupNama">
                    -
                </p>

                <p class="global-popup-nik" id="popupNik">
                    NIK: -
                </p>

            </div>


            {{-- =================================================
            DETAIL PESERTA
            ================================================== --}}

            <div class="global-popup-detail">

                {{-- JENIS PPKS --}}
                <div class="global-popup-detail-item">

                    <span class="global-popup-detail-label">
                        Jenis PPKS
                    </span>

                    <strong class="global-popup-view" id="popupJenisPpks">
                        -
                    </strong>

                </div>


                {{-- JURUSAN --}}
                <div class="global-popup-detail-item">

                    <span class="global-popup-detail-label">
                        Jurusan
                    </span>

                    <strong class="global-popup-view" id="popupJurusan">
                        -
                    </strong>

                </div>


                {{-- GELOMBANG --}}
                <div class="global-popup-detail-item">

                    <span class="global-popup-detail-label">
                        Gelombang Pelatihan
                    </span>

                    <strong class="global-popup-view" id="popupGelombang">
                        -
                    </strong>

                </div>


                {{-- TAHUN --}}
                <div class="global-popup-detail-item">

                    <span class="global-popup-detail-label">
                        Tahun Pelatihan
                    </span>

                    <strong class="global-popup-view" id="popupTahun">
                        -
                    </strong>

                </div>


                {{-- NOMOR HP --}}
                <div class="global-popup-detail-item">

                    <span class="global-popup-detail-label">
                        Nomor HP
                    </span>

                    <strong class="global-popup-view" id="popupNoHp1">
                        -
                    </strong>

                </div>


                {{-- ALAMAT --}}
                <div class="global-popup-detail-item full">

                    <span class="global-popup-detail-label">
                        Alamat Lengkap
                    </span>

                    <strong class="global-popup-view" id="popupAlamat">
                        -
                    </strong>

                </div>

            </div>


            {{-- =================================================
            FORM PEMANGGILAN
            ================================================== --}}

            <form method="POST" id="pemanggilanPopupForm" class="global-popup-form">

                @csrf


                {{-- BAZNAS --}}
                <div class="global-popup-field">

                    <label for="popupBaznas">
                        Pembiayaan / BAZNAS
                    </label>

                    <select name="baznas" id="popupBaznas" class="global-popup-input">

                        <option value="">
                            Pilih Pembiayaan
                        </option>

                        <option value="Baznas">
                            Baznas
                        </option>

                        <option value="Non Baznas">
                            Non Baznas
                        </option>

                    </select>

                </div>


                {{-- STATUS --}}
                <div class="global-popup-field">

                    <label for="popupStatus">
                        Status Pemanggilan
                    </label>

                    <select name="status_pemanggilan" id="popupStatus" class="global-popup-input" required>

                        <option value="belum_dipanggil">
                            Belum Dipanggil
                        </option>

                        <option value="sudah_dipanggil">
                            Sudah Dipanggil
                        </option>

                        <option value="belum_datang">
                            Belum Datang
                        </option>

                        <option value="sudah_datang">
                            Sudah Datang
                        </option>

                    </select>

                </div>


                {{-- TANGGAL PEMANGGILAN --}}
                <div class="global-popup-field">

                    <label for="popupTanggalPemanggilan">
                        Tanggal Pemanggilan
                    </label>

                    <input type="date" name="tanggal_pemanggilan" id="popupTanggalPemanggilan"
                        class="global-popup-input">

                </div>


                {{-- TANGGAL KEDATANGAN --}}
                <div class="global-popup-field">

                    <label for="popupTanggalKedatangan">
                        Tanggal Kedatangan
                    </label>

                    <input type="date" name="tanggal_kedatangan" id="popupTanggalKedatangan" class="global-popup-input">

                </div>


                {{-- ACTION --}}
                <div class="global-popup-actions">

                    <button type="button" class="global-popup-btn cancel" onclick="closePemanggilanPopup()">
                        Batal
                    </button>

                    <button type="submit" class="global-popup-btn primary">
                        Simpan
                    </button>

                </div>

            </form>

        </div>

    </div>



    {{-- =====================================================
    JAVASCRIPT
    ====================================================== --}}

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            /*
            |--------------------------------------------------------------------------
            | ==============================================================
            | ELEMENT UTAMA
            | ==============================================================
            |--------------------------------------------------------------------------
            */

            /*
            |--------------------------------------------------------------------------
            | ==============================================================
            | PDF ELEMENT
            | ==============================================================
            |--------------------------------------------------------------------------
            */

            const pdfButton =
                document.getElementById('pdfButton');

            const pdfFilter =
                document.getElementById('pdfFilter');

            const pdfGelombang =
                document.getElementById('pdfGelombang');

            const pdfTahun =
                document.getElementById('pdfTahun');

            const pdfReset =
                document.getElementById('pdfReset');

            const pdfGenerate =
                document.getElementById('pdfGenerate');


            /*
            |--------------------------------------------------------------------------
            | OPEN PDF FILTER
            | ==============================================================
            |--------------------------------------------------------------------------
            */

            if (pdfButton && pdfFilter) {

                pdfButton.addEventListener(
                    'click',
                    function (event) {

                        event.preventDefault();
                        event.stopPropagation();

                        pdfFilter.classList.toggle('active');

                    }
                );

            }


            /*
            |--------------------------------------------------------------------------
            | CLOSE PDF FILTER
            | ==============================================================
            |--------------------------------------------------------------------------
            */

            document.addEventListener(
                'click',
                function (event) {

                    if (
                        pdfFilter &&
                        pdfButton &&
                        !pdfFilter.contains(event.target) &&
                        !pdfButton.contains(event.target)
                    ) {

                        pdfFilter.classList.remove('active');

                    }

                }
            );


            /*
            |--------------------------------------------------------------------------
            | RESET PDF FILTER
            | ==============================================================
            |--------------------------------------------------------------------------
            */

            if (pdfReset) {

                pdfReset.addEventListener(
                    'click',
                    function () {

                        if (pdfGelombang) {

                            pdfGelombang.value = '';

                        }

                        if (pdfTahun) {

                            pdfTahun.value = '';

                        }

                    }
                );

            }


            /*
            |--------------------------------------------------------------------------
            | GENERATE PDF
            | ==============================================================
            |--------------------------------------------------------------------------
            */

            if (pdfGenerate) {

                pdfGenerate.addEventListener(
                    'click',
                    function () {

                        const gelombang =
                            pdfGelombang?.value || '';

                        const tahun =
                            pdfTahun?.value || '';


                        const params =
                            new URLSearchParams();


                        if (gelombang) {

                            params.set(
                                'gelombang',
                                gelombang
                            );

                        }


                        if (tahun) {

                            params.set(
                                'tahun',
                                tahun
                            );

                        }


                        const baseUrl =
                            @json(
                                route(
                                    'ppks.normal.pemanggilan.pdf'
                                )
                            );


                        const url =
                            params.toString()
                                ? `${baseUrl}?${params.toString()}`
                                : baseUrl;


                        window.open(
                            url,
                            '_blank'
                        );


                        pdfFilter?.classList.remove(
                            'show'
                        );

                    }
                );

            }


            /*
            |--------------------------------------------------------------------------
            | ==============================================================
            | POPUP PEMANGGILAN
            | ==============================================================
            |--------------------------------------------------------------------------
            */

            const pemanggilanPopup =
                document.getElementById(
                    'pemanggilanPopup'
                );

            const pemanggilanPopupForm =
                document.getElementById(
                    'pemanggilanPopupForm'
                );

            const popupNama =
                document.getElementById(
                    'popupNama'
                );

            const popupNik =
                document.getElementById(
                    'popupNik'
                );

            const popupJenisPpks =
                document.getElementById(
                    'popupJenisPpks'
                );

            const popupJurusan =
                document.getElementById(
                    'popupJurusan'
                );

            const popupGelombang =
                document.getElementById(
                    'popupGelombang'
                );

            const popupTahun =
                document.getElementById(
                    'popupTahun'
                );

            const popupBaznas =
                document.getElementById(
                    'popupBaznas'
                );

            const popupNoHp1 =
                document.getElementById(
                    'popupNoHp1'
                );

            const popupAlamat =
                document.getElementById(
                    'popupAlamat'
                );

            const popupStatus =
                document.getElementById(
                    'popupStatus'
                );

            const popupTanggalPemanggilan =
                document.getElementById(
                    'popupTanggalPemanggilan'
                );

            const popupTanggalKedatangan =
                document.getElementById(
                    'popupTanggalKedatangan'
                );


            /*
            |--------------------------------------------------------------------------
            | ==============================================================
            | OPEN POPUP PEMANGGILAN
            | ==============================================================
            |--------------------------------------------------------------------------
            */

            document
                .querySelectorAll(
                    '.action-btn-edit'
                )
                .forEach(
                    function (button) {

                        button.addEventListener(
                            'click',
                            function () {

                                if (
                                    !pemanggilanPopup ||
                                    !pemanggilanPopupForm
                                ) {

                                    return;

                                }


                                pemanggilanPopupForm.action =
                                    button.dataset.action;


                                popupNama.textContent =
                                    button.dataset.nama ||
                                    '-';


                                popupNik.textContent =
                                    `NIK: ${button.dataset.nik ||
                                    '-'
                                    }`;


                                popupJenisPpks.textContent =
                                    button.dataset.jenisPpks ||
                                    '-';


                                popupJurusan.textContent =
                                    button.dataset.jurusan ||
                                    '-';


                                popupGelombang.textContent =
                                    button.dataset.gelombang ||
                                    '-';


                                popupTahun.textContent =
                                    button.dataset.tahun ||
                                    '-';


                                if (popupBaznas) {

                                    popupBaznas.value =
                                        button.dataset.baznas ||
                                        '';

                                }


                                popupNoHp1.textContent =
                                    button.dataset.noHp1 ||
                                    '-';


                                popupAlamat.textContent =
                                    button.dataset.alamat ||
                                    '-';


                                popupStatus.value =
                                    button.dataset.status ||
                                    'belum_dipanggil';


                                popupTanggalPemanggilan.value =
                                    button.dataset.tanggalPemanggilan ||
                                    '';


                                popupTanggalKedatangan.value =
                                    button.dataset.tanggalKedatangan ||
                                    '';


                                updatePopupTanggalKedatangan();


                                pemanggilanPopup.classList.add(
                                    'show'
                                );


                                document.body.style.overflow =
                                    'hidden';

                            }
                        );

                    }
                );


            /*
            |--------------------------------------------------------------------------
            | CLOSE POPUP
            |--------------------------------------------------------------------------
            */

            window.closePemanggilanPopup =
                function () {

                    if (!pemanggilanPopup) {

                        return;

                    }


                    pemanggilanPopup.classList.remove(
                        'show'
                    );


                    document.body.style.overflow =
                        '';

                };


            /*
            |--------------------------------------------------------------------------
            | UPDATE TANGGAL KEDATANGAN
            |--------------------------------------------------------------------------
            */

            function updatePopupTanggalKedatangan() {

                if (
                    !popupStatus ||
                    !popupTanggalKedatangan
                ) {

                    return;

                }


                if (
                    popupStatus.value ===
                    'sudah_datang'
                ) {

                    popupTanggalKedatangan.disabled =
                        false;

                } else {

                    popupTanggalKedatangan.disabled =
                        true;

                    popupTanggalKedatangan.value =
                        '';

                }

            }


            if (popupStatus) {

                popupStatus.addEventListener(
                    'change',
                    updatePopupTanggalKedatangan
                );

            }


            /*
            |--------------------------------------------------------------------------
            | CLOSE OVERLAY
            |--------------------------------------------------------------------------
            */

            if (pemanggilanPopup) {

                pemanggilanPopup.addEventListener(
                    'click',
                    function (event) {

                        if (
                            event.target ===
                            pemanggilanPopup
                        ) {

                            closePemanggilanPopup();

                        }

                    }
                );

            }


            /*
            |--------------------------------------------------------------------------
            | ESC CLOSE
            |--------------------------------------------------------------------------
            */

            document.addEventListener(
                'keydown',
                function (event) {

                    if (
                        event.key === 'Escape' &&
                        pemanggilanPopup?.classList.contains(
                            'show'
                        )
                    ) {

                        closePemanggilanPopup();

                    }

                }
            );


            /*
            |--------------------------------------------------------------------------
            | VALIDASI FORM
            |--------------------------------------------------------------------------
            */

            if (pemanggilanPopupForm) {

                pemanggilanPopupForm.addEventListener(
                    'submit',
                    function (event) {

                        const status =
                            popupStatus?.value ||
                            '';

                        const tanggalPemanggilan =
                            popupTanggalPemanggilan?.value ||
                            '';

                        const tanggalKedatangan =
                            popupTanggalKedatangan?.value ||
                            '';


                        if (
                            (
                                status ===
                                'sudah_dipanggil' ||
                                status ===
                                'sudah_datang'
                            ) &&
                            !tanggalPemanggilan
                        ) {

                            event.preventDefault();

                            alert(
                                'Tanggal pemanggilan wajib diisi.'
                            );

                            return;

                        }


                        if (
                            status ===
                            'sudah_datang'
                        ) {

                            if (
                                !tanggalKedatangan
                            ) {

                                event.preventDefault();

                                alert(
                                    'Tanggal kedatangan wajib diisi.'
                                );

                                return;

                            }


                            if (
                                tanggalKedatangan <
                                tanggalPemanggilan
                            ) {

                                event.preventDefault();

                                alert(
                                    'Tanggal kedatangan tidak boleh lebih awal dari tanggal pemanggilan.'
                                );

                                return;

                            }

                        }

                    }
                );

            }


            /*
            |--------------------------------------------------------------------------
            | INITIAL
            |--------------------------------------------------------------------------
            */

        });

    </script>

</x-app-layout>