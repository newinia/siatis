<x-app-layout>


<div class="main-page">

    {{-- =========================================================
         HEADER
    ========================================================== --}}
    <div class="main-page-header">

        <div>
            <h1>Perlu Pemeriksaan</h1>

            <p>
                Periksa data yang terindikasi memiliki kesamaan identitas.
            </p>
        </div>

        <div class="check-summary">

            <div class="summary-number">
                {{ $duplicates->count() }}
            </div>

            <div class="summary-text">
                <strong>Kasus</strong>

                <span>
                    Menunggu pemeriksaan
                </span>
            </div>

        </div>

    </div>


    {{-- =========================================================
         PERLU PEMERIKSAAN
    ========================================================== --}}
    <div class="section-heading">

        <div class="section-heading-left">

            <h2>
                Data Perlu Diperiksa
            </h2>

            <span>
                {{ $duplicates->count() }}
            </span>

        </div>

    </div>


    @if ($duplicates->count())

        <div class="check-list">

            @foreach ($duplicates as $index => $ppks)

                @php

                    $data = is_array($ppks->data)
                        ? $ppks->data
                        : [];

                    $nama = $data['nama_lengkap'] ?? '-';

                    $nik = $data['nik'] ?? '-';

                    $comparison = null;

                    if ($ppks->possible_duplicate_of) {

                        $comparison = \App\Models\Ppks::find(
                            $ppks->possible_duplicate_of
                        );

                    }

                    $comparisonData =
                        $comparison && is_array($comparison->data)
                            ? $comparison->data
                            : [];

                    $comparisonNama =
                        $comparisonData['nama_lengkap'] ?? '-';

                    $comparisonNik =
                        $comparisonData['nik'] ?? '-';

                    $note = strtolower(
                        $ppks->duplicate_note ?? ''
                    );

                    if (str_contains($note, 'nik berbeda')) {

                        $kondisi = 'NIK berbeda';

                    } elseif (str_contains($note, 'nik sama')) {

                        $kondisi = 'NIK sama';

                    } else {

                        $kondisi = 'Perlu diperiksa';

                    }

                @endphp


                <div class="check-card">

                    <div class="check-card-main">

                        {{-- NOMOR --}}
                        <div class="case-no">
                            {{ $index + 1 }}
                        </div>


                        {{-- DATA PPKS --}}
                        <div class="person-block">

                            <div class="person-label">
                                Data PPKS
                            </div>

                            <div class="person-name">
                                {{ $nama }}
                            </div>

                            <div class="person-nik">
                                NIK {{ $nik }}
                            </div>

                        </div>


                        {{-- VS --}}
                        <div class="vs">
                            VS
                        </div>


                        {{-- DATA PEMBANDING --}}
                        <div class="person-block">

                            <div class="person-label">
                                Data Pembanding
                            </div>

                            @if ($comparison)

                                <div class="person-name">
                                    {{ $comparisonNama }}
                                </div>

                                <div class="person-nik">
                                    NIK {{ $comparisonNik }}
                                </div>

                            @else

                                <div class="person-name">
                                    Tidak ditemukan
                                </div>

                                <div class="person-nik">
                                    -
                                </div>

                            @endif

                        </div>


                        {{-- AKSI --}}
                        <div class="case-actions">

                            <span class="condition-badge">
                                {{ $kondisi }}
                            </span>

                            <button
                                type="button"
                                class="detail-btn"
                                onclick="openDetail({{ $ppks->id }})"
                            >
                                Detail
                            </button>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    @else

        <div class="empty-box">

            <div class="empty-check">
                ✓
            </div>

            <h3>
                Tidak ada data yang perlu diperiksa
            </h3>

            <p>
                Semua data sudah diperiksa.
            </p>

        </div>

    @endif


    {{-- =========================================================
         RIWAYAT
    ========================================================== --}}
    <div class="history-section">

        <div class="history-header">

            <div>

                <h2>
                    Riwayat Pemeriksaan
                </h2>

                <p>
                    Daftar keputusan pemeriksaan yang telah dilakukan.
                </p>

            </div>

            <div class="history-count">
                {{ $histories->count() }} riwayat
            </div>

        </div>


        @if ($histories->count())

    <div class="table-wrapper">

        <table class="table">

            {{-- HEADER --}}
            <thead>

                <tr>

                    <th>
                        Data yang diperiksa
                    </th>

                    <th>
                        Data pembanding
                    </th>

                    <th>
                        Keputusan
                    </th>

                    <th>
                        Pemeriksa
                    </th>

                    <th>
                        Aksi
                    </th>

                </tr>

            </thead>


            {{-- DATA --}}
            <tbody>

                @foreach ($histories as $history)

                    @php

                        $beforeData =
                            is_array($history->ppks_before)
                                ? ($history->ppks_before['data'] ?? [])
                                : [];

                        $comparisonBefore =
                            is_array($history->comparison_before)
                                ? ($history->comparison_before['data'] ?? [])
                                : [];

                        $decisionLabels = [

                            'pilih_data_ini' =>
                                'Pilih Data Ini',

                            'pilih_data_pembanding' =>
                                'Pilih Pembanding',

                            'bukan_duplikat' =>
                                'Bukan Duplikat',

                            'dikembalikan' =>
                                'Dikembalikan',

                        ];

                        $decisionLabel =
                            $decisionLabels[$history->decision]
                            ?? ucfirst(
                                str_replace(
                                    '_',
                                    ' ',
                                    $history->decision
                                )
                            );

                        $badgeClass = match (
                            $history->decision
                        ) {

                            'pilih_data_ini' =>
                                'pilih-ini',

                            'pilih_data_pembanding' =>
                                'pilih-pembanding',

                            'bukan_duplikat' =>
                                'bukan-duplikat',

                            'dikembalikan' =>
                                'dikembalikan',

                            default =>
                                'pilih-ini',

                        };

                    @endphp


                    <tr>

                        {{-- DATA --}}
                        <td>

                            <div class="history-person">

                                <div class="history-person-name">
                                    {{ $beforeData['nama_lengkap'] ?? '-' }}
                                </div>

                                <div class="history-person-nik">
                                    NIK {{ $beforeData['nik'] ?? '-' }}
                                </div>

                            </div>

                        </td>


                        {{-- PEMBANDING --}}
                        <td>

                            <div class="history-comparison">

                                <span>
                                    Pembanding
                                </span>

                                {{ $comparisonBefore['nama_lengkap'] ?? '-' }}

                            </div>

                        </td>


                        {{-- KEPUTUSAN --}}
                        <td>

                            <div>

                                <span class="history-badge {{ $badgeClass }}">
                                    {{ $decisionLabel }}
                                </span>

                            </div>

                        </td>


                        {{-- PEMERIKSA --}}
                        <td>

                            <div>

                                <div class="history-user">
                                    {{ $history->user?->name ?? 'Tidak diketahui' }}
                                </div>

                                <div class="history-date">
                                    {{ $history->created_at?->format('d M Y, H:i') }}
                                </div>

                            </div>

                        </td>


                        {{-- AKSI --}}
                        <td>

                            <div class="history-restore">

                                <form
                                    method="POST"
                                    action="{{ route('ppks.duplicate-restore', $history->id) }}"
                                    onsubmit="return confirm('Yakin ingin mengembalikan data ke kondisi sebelum keputusan ini?')"
                                >

                                    @csrf

                                    @method('PATCH')

                                    <button type="submit">
                                        Kembalikan
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

@else

    <div class="history-empty">
        Belum ada riwayat pemeriksaan.
    </div>

@endif

</div>


{{-- =========================================================
     MODAL DETAIL
========================================================== --}}
@foreach ($duplicates as $ppks)

    @php

        $data = is_array($ppks->data)
            ? $ppks->data
            : [];

        $comparison = null;

        if ($ppks->possible_duplicate_of) {

            $comparison = \App\Models\Ppks::find(
                $ppks->possible_duplicate_of
            );

        }

        $comparisonData =
            $comparison && is_array($comparison->data)
                ? $comparison->data
                : [];


        /*
        |--------------------------------------------------------------------------
        | HELPER GOOGLE DRIVE
        |--------------------------------------------------------------------------
        */

        $getDriveFileId = function ($file) {

            if (!$file) {
                return null;
            }

            $file = trim((string) $file);


            // Format:
            // https://drive.google.com/file/d/FILE_ID/view
            if (
                preg_match(
                    '#drive\.google\.com/file/d/([^/?]+)#',
                    $file,
                    $matches
                )
            ) {
                return $matches[1];
            }


            // Format:
            // https://drive.google.com/open?id=FILE_ID
            if (
                preg_match(
                    '#drive\.google\.com/open\?id=([^&]+)#',
                    $file,
                    $matches
                )
            ) {
                return $matches[1];
            }


            // Format:
            // https://drive.google.com/uc?id=FILE_ID
            if (
                preg_match(
                    '#drive\.google\.com/uc\?.*id=([^&]+)#',
                    $file,
                    $matches
                )
            ) {
                return $matches[1];
            }


            // Format:
            // https://drive.usercontent.google.com/download?id=FILE_ID
            if (
                preg_match(
                    '#drive\.usercontent\.google\.com/.*[?&]id=([^&]+)#',
                    $file,
                    $matches
                )
            ) {
                return $matches[1];
            }


            // Raw Google Drive File ID
            if (
                !str_contains($file, '/')
                && !str_contains($file, ':')
                && strlen($file) > 10
            ) {
                return $file;
            }

            return null;
        };


        /*
        |--------------------------------------------------------------------------
        | HELPER URL FILE
        |--------------------------------------------------------------------------
        */

        $getFileUrl = function ($file) use ($getDriveFileId) {

            if (!$file) {
                return null;
            }

            $file = trim((string) $file);

            $driveId = $getDriveFileId($file);


            // Google Drive
            if ($driveId) {

                return route(
                    'ppks.file',
                    [
                        'fileId' => $driveId
                    ]
                );

            }


            // URL biasa
            if (
                str_starts_with($file, 'http://')
                || str_starts_with($file, 'https://')
            ) {
                return $file;
            }


            // File lokal
            return asset(
                'storage/' . ltrim($file, '/')
            );

        };


        /*
        |--------------------------------------------------------------------------
        | KTP DATA YANG DIPERIKSA
        |--------------------------------------------------------------------------
        */

        $ktp = $data['upload_ktp'] ?? null;

        $ktpUrl = $getFileUrl($ktp);


        /*
        |--------------------------------------------------------------------------
        | KTP DATA PEMBANDING
        |--------------------------------------------------------------------------
        */

        $comparisonKtp =
            $comparisonData['upload_ktp'] ?? null;

        $comparisonKtpUrl =
            $getFileUrl($comparisonKtp);

    @endphp


    <div
        id="detailModal{{ $ppks->id }}"
        class="detail-modal"
        role="dialog"
        aria-modal="true"
        aria-labelledby="detailTitle{{ $ppks->id }}"
    >

        <div class="modal-box">

            {{-- HEADER --}}
            <div class="modal-header">

                <div>

                    <h2 id="detailTitle{{ $ppks->id }}">
                        Detail Pemeriksaan
                    </h2>

                    <p>
                        Perbandingan data PPKS
                    </p>

                </div>


                <button
                    type="button"
                    class="close-btn"
                    onclick="closeDetail({{ $ppks->id }})"
                    aria-label="Tutup detail"
                >
                    ×
                </button>

            </div>


            {{-- BODY --}}
            <div class="modal-body">

                <div class="comparison-title">
                    Perbandingan Data
                </div>


                <div class="comparison-grid">

                    {{-- =================================================
                         DATA YANG DIPERIKSA
                    ================================================== --}}
                    <div class="info-card main-data">

                        <div class="info-card-label">
                            Data yang diperiksa
                        </div>

                        <div class="info-card-name">
                            {{ $data['nama_lengkap'] ?? '-' }}
                        </div>


                        <div class="info-row">

                            <span class="info-label">
                                NIK
                            </span>

                            <span class="info-value">
                                {{ $data['nik'] ?? '-' }}
                            </span>

                        </div>


                        <div class="info-row">

                            <span class="info-label">
                                Jenis Kelamin
                            </span>

                            <span class="info-value">
                                {{ $data['jenis_kelamin'] ?? '-' }}
                            </span>

                        </div>


                        <div class="info-row">

                            <span class="info-label">
                                Tempat Lahir
                            </span>

                            <span class="info-value">
                                {{ $data['tempat_lahir'] ?? '-' }}
                            </span>

                        </div>


                        <div class="info-row">

                            <span class="info-label">
                                Tanggal Lahir
                            </span>

                            <span class="info-value">
                                {{ $data['tanggal_lahir'] ?? '-' }}
                            </span>

                        </div>


                        <div class="info-row">

                            <span class="info-label">
                                Timestamp
                            </span>

                            <span class="info-value">
                                {{ $data['timestamp'] ?? '-' }}
                            </span>

                        </div>


                        {{-- =================================================
                             KTP DATA YANG DIPERIKSA
                        ================================================== --}}
                        <div class="ktp-preview-wrapper">

                            <div class="ktp-preview-label">
                                Kartu Tanda Penduduk (KTP)
                            </div>


                            @if ($ktpUrl)

                                <button
                                    type="button"
                                    class="ktp-preview-button"
                                    onclick="openKtpPreview(
                                        @js($ktpUrl),
                                        @js('KTP - ' . ($data['nama_lengkap'] ?? 'Data yang diperiksa'))
                                    )"
                                    title="Lihat KTP"
                                >

                                    <img
                                        src="{{ $ktpUrl }}"
                                        alt="KTP {{ $data['nama_lengkap'] ?? '' }}"
                                        class="ktp-preview-image"
                                        loading="lazy"
                                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                    >

                                    <div
                                        class="ktp-unavailable"
                                        style="display:none;"
                                    >
                                        KTP tidak dapat ditampilkan.
                                        Klik tombol untuk membuka file.
                                    </div>

                                    <div class="ktp-preview-caption">
                                        Lihat KTP
                                    </div>

                                </button>

                            @else

                                <div class="ktp-unavailable">
                                    Foto KTP tidak tersedia
                                </div>

                            @endif

                        </div>

                    </div>


                    {{-- =================================================
                         DATA PEMBANDING
                    ================================================== --}}
                    <div class="info-card compare-data">

                        <div class="info-card-label">
                            Data Pembanding
                        </div>


                        @if ($comparison)

                            <div class="info-card-name">
                                {{ $comparisonData['nama_lengkap'] ?? '-' }}
                            </div>


                            <div class="info-row">

                                <span class="info-label">
                                    NIK
                                </span>

                                <span class="info-value">
                                    {{ $comparisonData['nik'] ?? '-' }}
                                </span>

                            </div>


                            <div class="info-row">

                                <span class="info-label">
                                    Jenis Kelamin
                                </span>

                                <span class="info-value">
                                    {{ $comparisonData['jenis_kelamin'] ?? '-' }}
                                </span>

                            </div>


                            <div class="info-row">

                                <span class="info-label">
                                    Tempat Lahir
                                </span>

                                <span class="info-value">
                                    {{ $comparisonData['tempat_lahir'] ?? '-' }}
                                </span>

                            </div>


                            <div class="info-row">

                                <span class="info-label">
                                    Tanggal Lahir
                                </span>

                                <span class="info-value">
                                    {{ $comparisonData['tanggal_lahir'] ?? '-' }}
                                </span>

                            </div>


                            <div class="info-row">

                                <span class="info-label">
                                    Timestamp
                                </span>

                                <span class="info-value">
                                    {{ $comparisonData['timestamp'] ?? '-' }}
                                </span>

                            </div>


                            {{-- =================================================
                                 KTP DATA PEMBANDING
                            ================================================== --}}
                            <div class="ktp-preview-wrapper">

                                <div class="ktp-preview-label">
                                    Kartu Tanda Penduduk (KTP)
                                </div>


                                @if ($comparisonKtpUrl)

                                    <button
                                        type="button"
                                        class="ktp-preview-button"
                                        onclick="openKtpPreview(
                                            @js($comparisonKtpUrl),
                                            @js('KTP - ' . ($comparisonData['nama_lengkap'] ?? 'Data Pembanding'))
                                        )"
                                        title="Lihat KTP Pembanding"
                                    >

                                        <img
                                            src="{{ $comparisonKtpUrl }}"
                                            alt="KTP {{ $comparisonData['nama_lengkap'] ?? '' }}"
                                            class="ktp-preview-image"
                                            loading="lazy"
                                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                        >

                                        <div
                                            class="ktp-unavailable"
                                            style="display:none;"
                                        >
                                            KTP tidak dapat ditampilkan.
                                            Klik tombol untuk membuka file.
                                        </div>

                                        <div class="ktp-preview-caption">
                                            Lihat KTP Pembanding
                                        </div>

                                    </button>

                                @else

                                    <div class="ktp-unavailable">
                                        Foto KTP tidak tersedia
                                    </div>

                                @endif

                            </div>


                        @else

                            <div class="info-card-name">
                                Tidak ditemukan
                            </div>

                            <div class="ktp-unavailable">
                                Data pembanding tidak tersedia
                            </div>

                        @endif

                    </div>

                </div>

            </div>


            {{-- =========================================================
                 DECISION
            ========================================================== --}}
            <div class="decision-footer">

                {{-- PILIH DATA INI --}}
                <form
                    method="POST"
                    action="{{ route('ppks.duplicate-decision', $ppks->id) }}"
                >

                    @csrf

                    @method('PATCH')

                    <input
                        type="hidden"
                        name="decision"
                        value="pilih_data_ini"
                    >

                    <button
                        type="submit"
                        class="decision-btn choose-main"
                    >
                        Pilih Data Ini
                    </button>

                </form>


                {{-- PILIH PEMBANDING --}}
                @if ($comparison)

                    <form
                        method="POST"
                        action="{{ route('ppks.duplicate-decision', $ppks->id) }}"
                    >

                        @csrf

                        @method('PATCH')

                        <input
                            type="hidden"
                            name="decision"
                            value="pilih_data_pembanding"
                        >

                        <button
                            type="submit"
                            class="decision-btn choose-compare"
                        >
                            Pilih Data Pembanding
                        </button>

                    </form>

                @endif


                {{-- BUKAN DUPLIKAT --}}
                <form
                    method="POST"
                    action="{{ route('ppks.duplicate-decision', $ppks->id) }}"
                >

                    @csrf

                    @method('PATCH')

                    <input
                        type="hidden"
                        name="decision"
                        value="bukan_duplikat"
                    >

                    <button
                        type="submit"
                        class="decision-btn not-duplicate"
                    >
                        Bukan Duplikat
                    </button>

                </form>

            </div>

        </div>

    </div>

@endforeach


<script>
    /**
     * =========================================================
     * DETAIL MODAL
     * =========================================================
     */

    function openDetail(id) {

        const modal =
            document.getElementById('detailModal' + id);

        if (!modal) {
            return;
        }

        modal.classList.add('active');

        document.body.style.overflow = 'hidden';


        const closeButton =
            modal.querySelector('.close-btn');

        if (closeButton) {

            setTimeout(function () {
                closeButton.focus();
            }, 50);

        }

    }


    function closeDetail(id) {

        const modal =
            document.getElementById('detailModal' + id);

        if (!modal) {
            return;
        }

        modal.classList.remove('active');


        const activeModal =
            document.querySelector('.detail-modal.active');

        if (!activeModal) {
            document.body.style.overflow = '';
        }

    }


    /**
     * =========================================================
     * PREVIEW KTP
     * =========================================================
     */

    function openKtpPreview(url, title) {

        if (!url) {
            return;
        }


        const width = 1000;
        const height = 750;


        const left =
            Math.max(
                0,
                (window.screen.width - width) / 2
            );


        const top =
            Math.max(
                0,
                (window.screen.height - height) / 2
            );


        const previewWindow =
            window.open(
                '',
                '_blank',
                'width=' + width +
                ',height=' + height +
                ',left=' + left +
                ',top=' + top +
                ',resizable=yes,scrollbars=yes'
            );


        /*
         * Jika browser memblokir popup,
         * buka URL langsung.
         */
        if (!previewWindow) {

            window.open(
                url,
                '_blank'
            );

            return;
        }


        previewWindow.document.write(`
            <!DOCTYPE html>

            <html lang="id">

            <head>

                <meta charset="UTF-8">

                <title>${escapeHtml(title)}</title>

                <style>

                    * {
                        box-sizing: border-box;
                    }

                    body {
                        margin: 0;
                        min-height: 100vh;
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        justify-content: center;
                        padding: 25px;
                        background: #111827;
                        font-family: Arial, sans-serif;
                    }

                    .preview-title {
                        margin-bottom: 15px;
                        color: #ffffff;
                        font-size: 15px;
                        font-weight: 700;
                        text-align: center;
                    }

                    .preview-image {
                        display: block;
                        max-width: 95vw;
                        max-height: 82vh;
                        object-fit: contain;
                        border-radius: 8px;
                        background: #ffffff;
                        box-shadow:
                            0 15px 45px rgba(0,0,0,.35);
                    }

                    .preview-note {
                        margin-top: 12px;
                        color: #cbd5e1;
                        font-size: 11px;
                        text-align: center;
                    }

                    .preview-note a {
                        color: #93c5fd;
                    }

                </style>

            </head>


            <body>

                <div class="preview-title">
                    ${escapeHtml(title)}
                </div>


                <img
                    src="${escapeAttribute(url)}"
                    class="preview-image"
                    alt="${escapeAttribute(title)}"
                    onerror="this.style.display='none'; document.getElementById('error').style.display='block';"
                >


                <div
                    id="error"
                    class="preview-note"
                    style="display:none;"
                >

                    KTP tidak dapat ditampilkan sebagai gambar.

                    <br>

                    Silakan buka file secara langsung.

                    <br><br>

                    <a
                        href="${escapeAttribute(url)}"
                        target="_blank"
                    >
                        Buka file
                    </a>

                </div>

            </body>

            </html>
        `);


        previewWindow.document.close();

    }


    /**
     * =========================================================
     * ESCAPE HTML
     * =========================================================
     */

    function escapeHtml(value) {

        return String(value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');

    }


    /**
     * =========================================================
     * ESCAPE ATTRIBUTE
     * =========================================================
     */

    function escapeAttribute(value) {

        return String(value)
            .replace(/&/g, '&amp;')
            .replace(/"/g, '&quot;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');

    }


    /**
     * =========================================================
     * KLIK BACKGROUND MODAL
     * =========================================================
     */

    document.addEventListener(
        'click',
        function (event) {

            if (
                event.target.classList.contains(
                    'detail-modal'
                )
            ) {

                event.target.classList.remove(
                    'active'
                );


                const activeModal =
                    document.querySelector(
                        '.detail-modal.active'
                    );


                if (!activeModal) {
                    document.body.style.overflow = '';
                }

            }

        }
    );


    /**
     * =========================================================
     * ESC UNTUK MENUTUP MODAL
     * =========================================================
     */

    document.addEventListener(
        'keydown',
        function (event) {

            if (event.key !== 'Escape') {
                return;
            }


            const activeModals =
                document.querySelectorAll(
                    '.detail-modal.active'
                );


            activeModals.forEach(
                function (modal) {

                    modal.classList.remove(
                        'active'
                    );

                }
            );


            document.body.style.overflow = '';

        }
    );


    /**
     * =========================================================
     * MENCEGAH KLIK DALAM MODAL
     * =========================================================
     */

    document
        .querySelectorAll('.modal-box')
        .forEach(
            function (box) {

                box.addEventListener(
                    'click',
                    function (event) {

                        event.stopPropagation();

                    }
                );

            }
        );

</script>

</x-app-layout>
