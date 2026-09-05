
<x-app-layout>

@php

    $data = $ppks->data ?? [];

    /* =========================================================
       HELPER DATA
    ========================================================= */

    $getData = function ($key, $default = '-') use ($data) {

        $value = $data[$key] ?? null;

        if (is_array($value)) {
            $value = implode(', ', $value);
        }

        if ($value === null || trim((string) $value) === '') {
            return $default;
        }

        return $value;
    };

    $getAnyData = function (
        array $keys,
        $default = '-'
    ) use ($data, $getData) {

        foreach ($keys as $key) {

            if (!array_key_exists($key, $data)) {
                continue;
            }

            $rawValue = $data[$key];

            if (is_array($rawValue)) {

                if (count($rawValue) === 0) {
                    continue;
                }

                $rawValue = implode(', ', $rawValue);
            }

            if (
                $rawValue !== null &&
                trim((string) $rawValue) !== ''
            ) {
                return $getData($key, $default);
            }
        }

        return $default;
    };


    /* =========================================================
       GOOGLE DRIVE FILE ID
    ========================================================= */

    $getDriveFileId = function ($file) {

        if (empty($file)) {
            return null;
        }

        $file = trim((string) $file);

        if (
            preg_match(
                '/drive\.google\.com\/file\/d\/([^\/\?]+)/i',
                $file,
                $matches
            )
        ) {
            return $matches[1];
        }

        if (
            preg_match(
                '/drive\.google\.com\/open\?id=([^&]+)/i',
                $file,
                $matches
            )
        ) {
            return $matches[1];
        }

        if (
            preg_match(
                '/drive\.google\.com\/uc\?(?:[^&]*&)*id=([^&]+)/i',
                $file,
                $matches
            )
        ) {
            return $matches[1];
        }

        if (
            preg_match(
                '/drive\.usercontent\.google\.com\/[^?]+\?(?:[^&]*&)*id=([^&]+)/i',
                $file,
                $matches
            )
        ) {
            return $matches[1];
        }

        if (
            !str_contains($file, '/') &&
            !str_contains($file, ':') &&
            strlen($file) > 10
        ) {
            return $file;
        }

        return null;
    };


    /* =========================================================
       FILE URL
    ========================================================= */

    $getFileUrl = function ($file) use ($getDriveFileId) {

        if (empty($file)) {
            return null;
        }

        $file = trim((string) $file);


        /* =====================================================
           GOOGLE DRIVE
        ===================================================== */

        $fileId = $getDriveFileId($file);

        if ($fileId) {

            return route('ppks.file', [
                'fileId' => $fileId,
            ]);
        }


        /* =====================================================
           URL LANGSUNG
        ===================================================== */

        if (
            str_starts_with($file, 'http://') ||
            str_starts_with($file, 'https://')
        ) {
            return $file;
        }


        /* =====================================================
           FILE UPLOAD WEBSITE
        ===================================================== */

        return asset(
            'storage/' . ltrim($file, '/')
        );
    };


    /* =========================================================
       FOTO FULL BADAN
    ========================================================= */

    $foto =
        $data['upload_foto_full_badan']
        ?? null;

    $fotoUrl =
        $getFileUrl($foto);


    /* =========================================================
       DOKUMEN
    ========================================================= */

    $kk =
        $data['upload_kk']
        ?? null;

    $ktp =
        $data['upload_ktp']
        ?? null;

    $ijazah =
        $data['upload_ijazah_terakhir']
        ?? $data['upload_ijazah']
        ?? null;

    $kkUrl =
        $getFileUrl($kk);

    $ktpUrl =
        $getFileUrl($ktp);

    $ijazahUrl =
        $getFileUrl($ijazah);


    /* =========================================================
       IDENTITAS
    ========================================================= */

    $nama = $getAnyData([
        'nama_lengkap',
        'nama'
    ]);

    $nik = $getAnyData([
        'nik',
        'NIK'
    ]);

    $usia = $getAnyData([
        'usia'
    ]);

    if ($usia === '-') {

        $tanggalLahirUntukUsia =
            $getAnyData([
                'tanggal_lahir',
                'tgl_lahir'
            ], null);

        if ($tanggalLahirUntukUsia) {

            try {

                $usia =
                    \Carbon\Carbon::parse(
                        $tanggalLahirUntukUsia
                    )->age;

            } catch (\Throwable $e) {

                $usia = '-';
            }
        }
    }


    /* =========================================================
       KONTAK
    ========================================================= */

    $hp1 = $getAnyData([
        'no_hp_1',
        'nomor_hp_1',
        'no_telepon',
        'nomor_telepon'
    ]);

    $hp2 = $getAnyData([
        'no_hp_2',
        'nomor_hp_2'
    ]);

    $email = $getAnyData([
        'email'
    ]);

@endphp


<div class="participant-detail-page">

    <div class="participant-detail-container">


        {{-- =====================================================
             JOURNEY
        ====================================================== --}}

        <section class="journey-card">

            <div class="journey-progress">

                <div class="journey-step active">

                    <div class="journey-node">
                        1
                    </div>

                    <div class="journey-step-title">
                        Data Calon<br>
                        PPKS
                    </div>

                </div>


                <div class="journey-step">

                    <div class="journey-node">
                        2
                    </div>

                    <div class="journey-step-title">
                        Asesmen<br>
                        Instruktur
                    </div>

                </div>


                <div class="journey-step">

                    <div class="journey-node">
                        3
                    </div>

                    <div class="journey-step-title">
                        Asesmen Kesehatan<br>
                        Awal
                    </div>

                </div>


                <div class="journey-step">

                    <div class="journey-node">
                        4
                    </div>

                    <div class="journey-step-title">
                        Case<br>
                        Conference
                    </div>

                </div>


                <div class="journey-step">

                    <div class="journey-node">
                        5
                    </div>

                    <div class="journey-step-title">
                        Kesehatan<br>
                        Lanjutan
                    </div>

                </div>

            </div>

        </section>



        {{-- =====================================================
             MAIN CARD
        ====================================================== --}}

        <section class="participant-detail-card">


            {{-- HEADER --}}

            <div class="detail-header">

                <a
                    href="{{ route('ppks.normal.instruktur') }}"
                    class="detail-back-button"
                    title="Kembali ke Asesmen Instruktur"
                >

                    <span class="material-symbols-outlined">
                        arrow_back
                    </span>

                </a>


                <div class="detail-header-text">

                    <h1>
                        Data Calon PPKS
                    </h1>

                    <p>
                        Informasi lengkap calon PPKS yang telah
                        terdaftar dalam sistem.
                    </p>

                </div>

            </div>



            {{-- =================================================
                 A. DATA PPKS
            ================================================== --}}

            <div class="detail-section">

                <div class="detail-section-title">
                    A. Data PPKS
                </div>


                <div class="participant-profile-layout">


                    {{-- FOTO --}}

                    <div class="participant-photo-wrapper">

                        <div class="participant-photo">

                            @if (!empty($fotoUrl))

                                <img
                                    src="{{ $fotoUrl }}"
                                    alt="Foto {{ $nama }}"
                                    onerror="
                                        this.style.display='none';
                                        this.nextElementSibling.style.display='flex';
                                    "
                                >

                                <div
                                    class="photo-placeholder"
                                    style="display:none;"
                                >

                                    <span class="material-symbols-outlined">
                                        broken_image
                                    </span>

                                    <span>
                                        Foto tidak dapat ditampilkan
                                    </span>

                                </div>

                            @else

                                <div class="photo-placeholder">

                                    <span class="material-symbols-outlined">
                                        person
                                    </span>

                                    <span>
                                        Foto tidak tersedia
                                    </span>

                                </div>

                            @endif

                        </div>


                        <div class="participant-import-info">

                            <span>
                                Data masuk :
                            </span>

                            <strong>
                                {{ $ppks->created_at?->format('d-m-Y H:i') ?? '-' }}
                            </strong>

                        </div>

                    </div>



                    {{-- DATA --}}

                    <div class="participant-data-grid">


                        <div class="detail-field">

                            <label>
                                Nama Lengkap
                            </label>

                            <input
                                type="text"
                                value="{{ $nama }}"
                                readonly
                            >

                        </div>


                        <div class="detail-field">

                            <label>
                                NIK
                            </label>

                            <input
                                type="text"
                                value="{{ $nik }}"
                                readonly
                            >

                        </div>


                        <div class="detail-field">

                            <label>
                                Usia
                            </label>

                            <input
                                type="text"
                                value="{{ $usia !== '-' ? $usia . ' Tahun' : '-' }}"
                                readonly
                            >

                        </div>


                        <div class="detail-field">

                            <label>
                                Jenis Kelamin
                            </label>

                            <input
                                type="text"
                                value="{{ $getAnyData(['jenis_kelamin', 'jk']) }}"
                                readonly
                            >

                        </div>


                        <div class="detail-field">

                            <label>
                                Tanggal Lahir
                            </label>

                            <input
                                type="text"
                                value="{{ $getAnyData(['tanggal_lahir', 'tgl_lahir']) }}"
                                readonly
                            >

                        </div>


                        <div class="detail-field">

                            <label>
                                Tempat Lahir
                            </label>

                            <input
                                type="text"
                                value="{{ $getAnyData(['tempat_lahir']) }}"
                                readonly
                            >

                        </div>


                        <div class="detail-field">

                            <label>
                                No. KK
                            </label>

                            <input
                                type="text"
                                value="{{ $getAnyData(['no_kk', 'nomor_kk']) }}"
                                readonly
                            >

                        </div>


                        <div class="detail-field">

                            <label>
                                Status Perkawinan
                            </label>

                            <input
                                type="text"
                                value="{{ $getAnyData(['status_perkawinan']) }}"
                                readonly
                            >

                        </div>


                        <div class="detail-field">

                            <label>
                                Agama
                            </label>

                            <input
                                type="text"
                                value="{{ $getAnyData(['agama']) }}"
                                readonly
                            >

                        </div>

                    </div>

                </div>

            </div>



            {{-- =================================================
                 B. DATA ALAMAT
            ================================================== --}}

            <div class="detail-section">

                <div class="detail-section-title">
                    B. Data Alamat
                </div>


                <div class="detail-address-grid">


                    <div class="detail-field field-full">

                        <label>
                            Alamat Lengkap
                        </label>

                        <input
                            type="text"
                            value="{{ $getAnyData(['alamat_lengkap', 'alamat']) }}"
                            readonly
                        >

                    </div>


                    <div class="detail-field">

                        <label>
                            Provinsi
                        </label>

                        <input
                            type="text"
                            value="{{ $getAnyData(['provinsi']) }}"
                            readonly
                        >

                    </div>


                    <div class="detail-field">

                        <label>
                            Kabupaten
                        </label>

                        <input
                            type="text"
                            value="{{ $getAnyData(['kabupaten', 'kabupaten_kota']) }}"
                            readonly
                        >

                    </div>


                    <div class="detail-field">

                        <label>
                            Kecamatan
                        </label>

                        <input
                            type="text"
                            value="{{ $getAnyData(['kecamatan']) }}"
                            readonly
                        >

                    </div>


                    <div class="detail-field">

                        <label>
                            Kelurahan
                        </label>

                        <input
                            type="text"
                            value="{{ $getAnyData(['kelurahan', 'desa_kelurahan']) }}"
                            readonly
                        >

                    </div>

                </div>

            </div>



            {{-- =================================================
                 C. KONTAK
            ================================================== --}}

            <div class="detail-section">

                <div class="detail-section-title">
                    C. Kontak
                </div>


                <div class="detail-contact-grid">


                    <div class="detail-field">

                        <label>
                            Nomor HP 1
                        </label>

                        <input
                            type="text"
                            value="{{ $hp1 }}"
                            readonly
                        >

                    </div>


                    <div class="detail-field">

                        <label>
                            Nomor HP 2
                        </label>

                        <input
                            type="text"
                            value="{{ $hp2 }}"
                            readonly
                        >

                    </div>


                    <div class="detail-field">

                        <label>
                            Email
                        </label>

                        <input
                            type="text"
                            value="{{ $email }}"
                            readonly
                        >

                    </div>

                </div>

            </div>



            {{-- =================================================
                 D. PENDIDIKAN & PELATIHAN
            ================================================== --}}

            <div class="detail-section">

                <div class="detail-section-title">
                    D. Pendidikan & Pelatihan
                </div>


                <div class="detail-address-grid">


                    <div class="detail-field">

                        <label>
                            Pendidikan Terakhir
                        </label>

                        <input
                            type="text"
                            value="{{ $getAnyData(['pendidikan_terakhir']) }}"
                            readonly
                        >

                    </div>


                    <div class="detail-field">

                        <label>
                            Keterangan Pendidikan
                        </label>

                        <input
                            type="text"
                            value="{{ $getAnyData(['keterangan_pendidikan']) }}"
                            readonly
                        >

                    </div>


                    <div class="detail-field">

                        <label>
                            Jurusan Yang Diminati
                        </label>

                        <input
                            type="text"
                            value="{{ $getAnyData(['jurusan_yang_diminati']) }}"
                            readonly
                        >

                    </div>


                    <div class="detail-field">

                        <label>
                            Kursus yang Pernah Diikuti
                        </label>

                        <input
                            type="text"
                            value="{{ $getAnyData([
                                'pelatihan_kursus',
                                'kursus_yang_pernah_diikuti'
                            ]) }}"
                            readonly
                        >

                    </div>


                    <div class="detail-field">

                        <label>
                            Peminatan
                        </label>

                        <input
                            type="text"
                            value="{{ $getAnyData(['peminatan']) }}"
                            readonly
                        >

                    </div>


                    <div class="detail-field">

                        <label>
                            Alumni STIS
                        </label>

                        <input
                            type="text"
                            value="{{ $getAnyData(['alumni_stis']) }}"
                            readonly
                        >

                    </div>

                </div>

            </div>



            {{-- =================================================
                 E. DISABILITAS & AKTIVITAS
            ================================================== --}}

            <div class="detail-section">

                <div class="detail-section-title">
                    E. Data Disabilitas & Aktivitas
                </div>


                <div class="detail-address-grid">


                    <div class="detail-field">

                        <label>
                            Jenis PPKS
                        </label>

                        <input
                            type="text"
                            value="{{ $getAnyData(['jenis_ppks']) }}"
                            readonly
                        >

                    </div>


                    <div class="detail-field">

                        <label>
                            Keterangan Disabilitas
                        </label>

                        <input
                            type="text"
                            value="{{ $getAnyData(['keterangan_disabilitas']) }}"
                            readonly
                        >

                    </div>


                    <div class="detail-field">

                        <label>
                            Kemampuan Membaca & Menulis
                        </label>

                        <input
                            type="text"
                            value="{{ $getAnyData(['kemampuan_membaca_menulis']) }}"
                            readonly
                        >

                    </div>


                    <div class="detail-field">

                        <label>
                            Aktivitas Kehidupan Sehari-hari
                        </label>

                        <input
                            type="text"
                            value="{{ $getAnyData([
                                'aktivitas_sehari_hari',
                                'aktivitas_kehidupan_sehari_hari'
                            ]) }}"
                            readonly
                        >

                    </div>


                    <div class="detail-field">

                        <label>
                            Kondisi Saat Ini
                        </label>

                        <input
                            type="text"
                            value="{{ $getAnyData([
                                'kondisi_kesehatan',
                                'kondisi_saat_ini'
                            ]) }}"
                            readonly
                        >

                    </div>


                    <div class="detail-field">

                        <label>
                            Bersedia Mengikuti Pelatihan STIS
                        </label>

                        <input
                            type="text"
                            value="{{ $getAnyData([
                                'bersedia_pelatihan_vokasional',
                                'bersedia_mengikuti_pelatihan_stis'
                            ]) }}"
                            readonly
                        >

                    </div>

                </div>

            </div>



            {{-- =================================================
                 F. BERKAS DOKUMEN
            ================================================== --}}

            <div class="detail-section">

                <div class="detail-section-title">
                    F. Berkas Dokumen
                </div>


                <div class="document-grid">


                    {{-- KK --}}

                    <div class="document-item">

                        <div class="document-label">
                            Kartu Keluarga (KK)
                        </div>


                        @if (!empty($kkUrl))

                            <button
                                type="button"
                                class="document-preview document-preview-button"
                                onclick="openDocumentPreview(
                                    @js($kkUrl),
                                    'Kartu Keluarga (KK)',
                                )"
                            >

                                <span class="material-symbols-outlined document-icon">
                                    description
                                </span>

                                <span class="document-status">
                                    Berkas tersedia
                                </span>

                                <span class="document-open-text">
                                    Klik untuk melihat
                                </span>

                            </button>

                        @else

                            <div class="document-preview document-unavailable">

                                <span class="material-symbols-outlined document-icon">
                                    description
                                </span>

                                <span>
                                    Berkas tidak tersedia
                                </span>

                            </div>

                        @endif

                    </div>



                    {{-- KTP --}}

                    <div class="document-item">

                        <div class="document-label">
                            Kartu Tanda Penduduk (KTP)
                        </div>


                        @if (!empty($ktpUrl))

                            <button
                                type="button"
                                class="document-preview document-preview-button"
                                onclick="openDocumentPreview(
                                @js($ktpUrl),
                                'Kartu Tanda Penduduk (KTP)'
                            )"
                            >

                                <span class="material-symbols-outlined document-icon">
                                    badge
                                </span>

                                <span class="document-status">
                                    Berkas tersedia
                                </span>

                                <span class="document-open-text">
                                    Klik untuk melihat
                                </span>

                            </button>

                        @else

                            <div class="document-preview document-unavailable">

                                <span class="material-symbols-outlined document-icon">
                                    badge
                                </span>

                                <span>
                                    Berkas tidak tersedia
                                </span>

                            </div>

                        @endif

                    </div>



                    {{-- FOTO FULL BADAN --}}

                    <div class="document-item">

                        <div class="document-label">
                            Foto Full Badan
                        </div>


                        @if (!empty($fotoUrl))

                            <button
                                type="button"
                                class="document-preview document-preview-button"
                                onclick="openDocumentPreview(
                                    @js($fotoUrl),
                                    'Foto Full Badan',
                                )"
                            >

                                <span class="material-symbols-outlined document-icon">
                                    person
                                </span>

                                <span class="document-status">
                                    Berkas tersedia
                                </span>

                                <span class="document-open-text">
                                    Klik untuk melihat
                                </span>

                            </button>

                        @else

                            <div class="document-preview document-unavailable">

                                <span class="material-symbols-outlined document-icon">
                                    person
                                </span>

                                <span>
                                    Foto tidak tersedia
                                </span>

                            </div>

                        @endif

                    </div>



                    {{-- IJAZAH --}}

                    <div class="document-item">

                        <div class="document-label">
                            Ijazah
                        </div>


                        @if (!empty($ijazahUrl))

                            <button
                                type="button"
                                class="document-preview document-preview-button"
                                onclick="openDocumentPreview(
                                    @js($ijazahUrl),
                                    'Ijazah'
                                )"
                            >

                                <span class="material-symbols-outlined document-icon">
                                    school
                                </span>

                                <span class="document-status">
                                    Berkas tersedia
                                </span>

                                <span class="document-open-text">
                                    Klik untuk melihat
                                </span>

                            </button>

                        @else

                            <div class="document-preview document-unavailable">

                                <span class="material-symbols-outlined document-icon">
                                    school
                                </span>

                                <span>
                                    Berkas tidak tersedia
                                </span>

                            </div>

                        @endif

                    </div>

                </div>

            </div>



            {{-- =================================================
                 BUTTON LANJUT
            ================================================== --}}

            <div class="detail-actions">

                <a
                    href="{{ route(
                        'ppks.normal.asesmen-instruktur.detail',
                        $ppks
                    ) }}"
                    class="participant-next-button"
                >

                    <span>
                        Selanjutnya
                    </span>

                </a>

            </div>


        </section>

    </div>

</div>



{{-- =============================================================
     MODAL PREVIEW DOKUMEN
============================================================== --}}

<div
    class="document-modal"
    id="documentModal"
    aria-hidden="true"
>

    <div
        class="document-modal-card"
        role="dialog"
        aria-modal="true"
        aria-labelledby="documentModalTitle"
    >

        <div class="document-modal-header">

            <div class="document-modal-info">

                <div
                    class="document-modal-title"
                    id="documentModalTitle"
                >
                    Preview Dokumen
                </div>

                <div
                    class="document-modal-name"
                    id="documentModalName"
                ></div>

            </div>


            <button
                type="button"
                class="document-close"
                onclick="closeDocumentPreview()"
                aria-label="Tutup"
            >

                <span class="material-symbols-outlined">
                    close
                </span>

            </button>

        </div>


        <div class="document-preview-container">

            <iframe
                id="documentPreviewFrame"
                class="document-preview-frame"
                src="about:blank"
                title="Preview Dokumen"
            ></iframe>


            <img
                id="documentPreviewImage"
                class="document-preview-image"
                src=""
                alt="Preview Dokumen"
            >


            <div
                id="documentPreviewLoading"
                class="document-preview-loading"
            >

                <span class="material-symbols-outlined">
                    description
                </span>

                <span>
                    Memuat dokumen...
                </span>

            </div>

        </div>

    </div>

</div>



<style>

/* =========================================================
   PAGE
========================================================= */

.participant-detail-page {
    width: 100%;
    padding: 10px 0 40px;
    box-sizing: border-box;
}

.participant-detail-container {
    width: 100%;
    max-width: 1180px;
    margin: 0 auto;
    padding: 0 20px;
    box-sizing: border-box;
}


/* =========================================================
   JOURNEY
========================================================= */

.journey-card {
    width: 100%;
    margin-bottom: 24px;
    padding: 8px 0 10px;
    box-sizing: border-box;
    background: transparent;
    border: none;
    box-shadow: none;
}

.journey-progress {
    position: relative;
    width: 100%;
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    align-items: start;
    padding: 5px 0 0;
    box-sizing: border-box;
}

.journey-progress::before {
    content: "";
    position: absolute;
    left: 10%;
    right: 10%;
    top: 25px;
    height: 3px;
    background: #dfe3e7;
    border-radius: 999px;
    z-index: 1;
}

.journey-step {
    position: relative;
    min-width: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    z-index: 2;
}

.journey-node {
    position: relative;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 9px;
    box-sizing: border-box;
    border: 2px solid #d7dbe0;
    border-radius: 50%;
    background: #ffffff;
    color: #a0a6ad;
    font-size: 12px;
    font-weight: 700;
    z-index: 3;
}

.journey-step.active .journey-node {
    width: 46px;
    height: 46px;
    margin-top: -3px;
    margin-bottom: 6px;
    border-color: #328300;
    background: #328300;
    color: #ffffff;
    box-shadow:
        0 0 0 5px rgba(50, 131, 0, 0.09),
        0 6px 15px rgba(50, 131, 0, 0.20);
}

.journey-step-title {
    min-height: 31px;
    padding: 0 5px;
    color: #6b7280;
    font-size: 10.5px;
    line-height: 1.4;
    font-weight: 600;
    text-align: center;
}

.journey-step.active .journey-step-title {
    color: #328300;
    font-weight: 700;
}

.journey-step-status {
    display: none !important;
}


/* =========================================================
   MAIN CARD
========================================================= */

.participant-detail-card {
    width: 100%;
    padding: 28px;
    box-sizing: border-box;
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    box-shadow:
        0 10px 30px rgba(0, 0, 0, 0.05);
}


/* =========================================================
   HEADER
========================================================= */

.detail-header {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 30px;
}

.detail-back-button {
    width: 42px;
    height: 42px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    background: #ffffff;
    color: #374151;
    text-decoration: none;
    transition:
        border-color 0.2s ease,
        background 0.2s ease,
        box-shadow 0.2s ease,
        transform 0.2s ease;
}

.detail-back-button:hover {
    border-color: #63AE00;
    background: #f7fcef;
    color: #328300;
}

.detail-header-text h1 {
    margin: 0;
    color: #111827;
    font-size: 20px;
    line-height: 1.3;
    font-weight: 700;
}

.detail-header-text p {
    margin: 4px 0 0;
    color: #6b7280;
    font-size: 12px;
    line-height: 1.5;
}


/* =========================================================
   SECTION
========================================================= */

.detail-section {
    margin-bottom: 28px;
}

.detail-section:last-of-type {
    margin-bottom: 0;
}

.detail-section-title {
    margin-bottom: 12px;
    color: #111827;
    font-size: 16px;
    line-height: 1.4;
    font-weight: 700;
}


/* =========================================================
   PROFILE
========================================================= */

.participant-profile-layout {
    width: 100%;
    display: grid;
    grid-template-columns: 110px minmax(0, 1fr);
    gap: 24px;
    align-items: start;
}

.participant-photo-wrapper {
    width: 110px;
    text-align: center;
}

.participant-photo {
    width: 100px;
    height: 130px;
    margin: 0 auto;
    overflow: hidden;
    border: 1px solid #d1d5db;
    border-radius: 10px;
    background: #f9fafb;
}

.participant-photo img {
    width: 100%;
    height: 100%;
    display: block;
    object-fit: cover;
}

.photo-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 5px;
    padding: 8px;
    box-sizing: border-box;
    color: #9ca3af;
    font-size: 9px;
    text-align: center;
}

.photo-placeholder .material-symbols-outlined {
    font-size: 34px;
}

.participant-import-info {
    margin-top: 7px;
    color: #6b7280;
    font-size: 9px;
    line-height: 1.4;
}

.participant-import-info strong {
    color: #63AE00;
    font-weight: 600;
}


/* =========================================================
   FORM GRID
========================================================= */

.participant-data-grid {
    width: 100%;
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 20px;
}

.detail-address-grid {
    width: 100%;
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 20px;
}

.detail-contact-grid {
    width: 100%;
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 20px;
}

.detail-field {
    width: 100%;
    min-width: 0;
    display: flex;
    flex-direction: column;
}

.detail-field.field-full {
    grid-column: span 3;
}

.detail-field label {
    margin-bottom: 6px;
    padding-left: 2px;
    color: #374151;
    font-size: 11px;
    line-height: 1.4;
    font-weight: 600;
}

.detail-field input {
    width: 100%;
    min-height: 42px;
    padding: 9px 12px;
    box-sizing: border-box;
    border: 1px solid #d1d5db;
    border-radius: 9px;
    background: #ffffff;
    color: #374151;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 11px;
    outline: none;
}


/* =========================================================
   DOCUMENT
========================================================= */

.document-grid {
    width: 100%;
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 20px;
}

.document-item {
    width: 100%;
    min-width: 0;
}

.document-label {
    margin-bottom: 7px;
    color: #374151;
    font-size: 11px;
    line-height: 1.4;
    font-weight: 600;
}

.document-preview {
    width: 100%;
    min-height: 145px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 3px;
    padding: 15px;
    box-sizing: border-box;
    border: 1px dashed #c7cbd1;
    border-radius: 10px;
    background: #fafafa;
    color: #6b7280;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 10px;
    text-align: center;
}

.document-preview-button {
    cursor: pointer;
    transition:
        border-color 0.2s ease,
        background 0.2s ease,
        box-shadow 0.2s ease,
        transform 0.2s ease;
}

.document-preview-button:hover {
    border-color: #63AE00;
    background: #f8fcf2;
    box-shadow:
        0 6px 18px rgba(99, 174, 0, 0.10);
    transform: translateY(-2px);
}

.document-icon {
    margin-bottom: 6px;
    font-size: 30px;
    color: #63AE00;
}

.document-status {
    color: #374151;
    font-size: 10px;
    font-weight: 600;
}

.document-open-text {
    margin-top: 5px;
    color: #63AE00;
    font-size: 9px;
    font-weight: 600;
}

.document-unavailable {
    cursor: default;
    background: #f9fafb;
    color: #9ca3af;
}

.document-unavailable .document-icon {
    color: #9ca3af;
}


/* =========================================================
   BUTTON
========================================================= */

.detail-actions {
    width: 100%;
    display: flex;
    justify-content: flex-end;
    margin-top: 30px;
}

.participant-next-button {
    min-height: 42px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 10px 40px;
    border: none;
    border-radius: 9px;
    background: #63ae00;
    color: #ffffff;
    text-decoration: none;
    font-size: 12px;
    font-weight: 700;
    box-shadow:
        0 4px 10px rgba(50, 131, 0, 0.16);
    transition:
        background 0.2s ease,
        transform 0.2s ease,
        box-shadow 0.2s ease;
}

.participant-next-button:hover {
    background: #276900;
    color: #ffffff;
    transform: translateY(-1px);
    box-shadow:
        0 7px 16px rgba(50, 131, 0, 0.20);
}

.participant-next-button .material-symbols-outlined {
    font-size: 18px;
}


/* =========================================================
   MODAL
========================================================= */

.document-modal {
    position: fixed;
    inset: 0;
    z-index: 99999;

    display: none;

    align-items: center;
    justify-content: center;

    width: 100%;
    height: 100%;

    padding: 20px;
    box-sizing: border-box;

    background: rgba(17, 24, 39, 0.78);

    backdrop-filter: blur(5px);
}

.document-modal.show {
    display: flex;
}


/* =========================================================
   MODAL CARD
========================================================= */

.document-modal-card {
    position: relative;

    width: min(1200px, 96vw);
    height: min(850px, 92vh);

    display: flex;
    flex-direction: column;

    overflow: hidden;

    background: #ffffff;

    border-radius: 14px;

    box-shadow:
        0 25px 70px rgba(0, 0, 0, 0.35);
}


/* =========================================================
   MODAL HEADER
========================================================= */

.document-modal-header {
    min-height: 68px;

    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 15px;

    padding: 12px 18px;

    box-sizing: border-box;

    border-bottom: 1px solid #e5e7eb;

    background: #ffffff;

    flex-shrink: 0;
}

.document-modal-info {
    min-width: 0;
}

.document-modal-title {
    color: #111827;
    font-size: 14px;
    font-weight: 700;
}

.document-modal-name {
    margin-top: 3px;
    color: #6b7280;
    font-size: 10px;
}

.document-close {
    width: 38px;
    height: 38px;

    display: flex;
    align-items: center;
    justify-content: center;

    flex-shrink: 0;

    padding: 0;

    border: none;
    border-radius: 9px;

    background: #f3f4f6;

    color: #4b5563;

    cursor: pointer;

    transition:
        background 0.2s ease,
        color 0.2s ease;
}

.document-close:hover {
    background: #ef4444;
    color: #ffffff;
}


/* =========================================================
   PREVIEW CONTAINER
========================================================= */

.document-preview-container {
    position: relative;

    flex: 1;

    min-height: 0;

    width: 100%;

    display: flex;
    align-items: center;
    justify-content: center;

    overflow: hidden;

    padding: 20px;

    box-sizing: border-box;

    background: #f3f4f6;
}


/* =========================================================
   PDF / FILE FRAME
========================================================= */

.document-preview-frame {
    width: 100%;
    height: 100%;

    display: none;

    border: none;

    background: #ffffff;
}


/* =========================================================
   IMAGE PREVIEW
========================================================= */

.document-preview-image {
    display: none;

    /*
     * Kotak gambar memenuhi area preview,
     * tetapi isi gambar TIDAK akan dipotong.
     */
    width: 100%;
    height: 100%;

    max-width: 100%;
    max-height: 100%;

    object-fit: contain;
    object-position: center;

    padding: 15px;

    box-sizing: border-box;

    margin: 0;

    transform: none !important;
    zoom: 1 !important;
}


/* =========================================================
   LOADING
========================================================= */

.document-preview-loading {
    position: absolute;

    inset: 0;

    display: flex;

    flex-direction: column;

    align-items: center;
    justify-content: center;

    gap: 8px;

    color: #6b7280;

    font-size: 11px;

    background: #f3f4f6;

    z-index: 5;
}

.document-preview-loading .material-symbols-outlined {
    font-size: 34px;
    color: #9ca3af;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 1000px) {

    .journey-progress {
        overflow-x: auto;
        scrollbar-width: none;
    }

    .journey-progress::-webkit-scrollbar {
        display: none;
    }

    .journey-progress {
        grid-template-columns: repeat(5, 125px);
        min-width: 625px;
    }

    .journey-progress::before {
        left: 62px;
        right: 62px;
    }
}


@media (max-width: 900px) {

    .participant-detail-container {
        padding: 0 15px;
    }

    .participant-profile-layout {
        grid-template-columns: 100px minmax(0, 1fr);
        gap: 18px;
    }

    .detail-address-grid,
    .detail-contact-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .detail-field.field-full {
        grid-column: span 2;
    }

    .document-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}


@media (max-width: 700px) {

    .journey-card {
        padding: 5px 0;
    }

    .journey-progress {
        grid-template-columns: repeat(5, 115px);
        min-width: 575px;
    }

    .journey-progress::before {
        top: 21px;
        left: 57px;
        right: 57px;
        height: 3px;
    }

    .journey-node {
        width: 36px;
        height: 36px;
        font-size: 11px;
    }

    .journey-step.active .journey-node {
        width: 40px;
        height: 40px;
        margin-top: -2px;
        margin-bottom: 7px;
    }

    .journey-step-title {
        font-size: 9.5px;
    }

    .participant-detail-card {
        padding: 22px 18px;
        border-radius: 13px;
    }

    .participant-profile-layout {
        grid-template-columns: 1fr;
    }

    .participant-photo-wrapper {
        margin: 0 auto;
    }

    .participant-data-grid,
    .detail-address-grid,
    .detail-contact-grid {
        grid-template-columns: 1fr;
    }

    .detail-field.field-full {
        grid-column: span 1;
    }

    .document-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .detail-header {
        align-items: flex-start;
    }

    .detail-header-text h1 {
        font-size: 18px;
    }
}


@media (max-width: 520px) {

    .participant-detail-page {
        padding: 5px 0 25px;
    }

    .participant-detail-container {
        padding: 0 10px;
    }

    .journey-card {
        padding: 4px 0;
    }

    .journey-progress {
        grid-template-columns: repeat(5, 105px);
        min-width: 525px;
    }

    .journey-progress::before {
        left: 52px;
        right: 52px;
    }

    .journey-step-title {
        font-size: 9px;
    }

    .participant-detail-card {
        padding: 18px 14px;
    }

    .document-grid {
        grid-template-columns: 1fr;
    }

    .detail-actions {
        margin-top: 24px;
    }

    .participant-next-button {
        width: 100%;
    }

    .document-modal {
        padding: 8px;
    }

    .document-modal-card {
        width: 100%;
        height: 94vh;
        border-radius: 10px;
    }

    .document-preview-container {
        padding: 10px;
    }

    .document-preview-image {
        padding: 5px;
    }
}

</style>


<script>

/* =========================================================
   OPEN DOCUMENT PREVIEW
========================================================= */
function openDocumentPreview(url, fileName = '') {

    const modal = document.getElementById('documentModal');
    const frame = document.getElementById('documentPreviewFrame');
    const image = document.getElementById('documentPreviewImage');
    const loading = document.getElementById('documentPreviewLoading');
    const title = document.getElementById('documentModalTitle');
    const name = document.getElementById('documentModalName');

    if (!url) {
        alert('File tidak tersedia.');
        return;
    }

    if (!modal || !frame || !image || !loading) {
        console.error('Elemen preview dokumen tidak ditemukan.');
        return;
    }

    const finalUrl = String(url).trim();

    /*
    |--------------------------------------------------------------------------
    | SET JUDUL
    |--------------------------------------------------------------------------
    */

    if (title) {
        title.textContent = 'Preview Dokumen';
    }

    if (name) {
        name.textContent = fileName || '';
    }

    /*
    |--------------------------------------------------------------------------
    | RESET
    |--------------------------------------------------------------------------
    */

    frame.onload = null;
    frame.onerror = null;

    image.onload = null;
    image.onerror = null;

    frame.src = 'about:blank';
    image.src = '';

    frame.style.display = 'none';
    image.style.display = 'none';

    loading.style.display = 'flex';

    modal.classList.add('show');
    modal.setAttribute('aria-hidden', 'false');

    document.body.style.overflow = 'hidden';


    /*
    |--------------------------------------------------------------------------
    | DETEKSI BERDASARKAN NAMA FILE / URL
    |--------------------------------------------------------------------------
    */

    const cleanUrl =
        finalUrl
            .split('#')[0]
            .split('?')[0]
            .toLowerCase();

    const cleanFileName =
        String(fileName || '').toLowerCase();


    const isPdf =
        cleanUrl.endsWith('.pdf') ||
        cleanFileName.endsWith('.pdf');


    const isImage =
        /\.(jpg|jpeg|png|gif|webp|bmp|svg)$/i.test(cleanUrl) ||
        /\.(jpg|jpeg|png|gif|webp|bmp|svg)$/i.test(cleanFileName);


    /*
    |--------------------------------------------------------------------------
    | GAMBAR
    |--------------------------------------------------------------------------
    */

    if (isImage) {

        image.onload = function () {

            loading.style.display = 'none';
            image.style.display = 'block';

        };

        image.onerror = function () {

            loading.style.display = 'none';

            /*
             * Kalau gagal dianggap gambar,
             * coba iframe sebagai fallback.
             */

            frame.onload = function () {

                loading.style.display = 'none';
                frame.style.display = 'block';

            };

            frame.src = finalUrl;
        };

        image.src = finalUrl;

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | PDF
    |--------------------------------------------------------------------------
    */

    if (isPdf) {

        frame.onload = function () {

            loading.style.display = 'none';
            frame.style.display = 'block';

        };

        frame.src = finalUrl;

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | GOOGLE DRIVE / URL TANPA EXTENSION
    |--------------------------------------------------------------------------
    |
    | URL /ppks/file/{fileId} tidak mempunyai .jpg / .pdf.
    |
    | Untuk kondisi ini kita coba gambar terlebih dahulu.
    | Kalau bukan gambar, otomatis pindah ke iframe.
    |--------------------------------------------------------------------------
    */

    image.onload = function () {

        loading.style.display = 'none';
        image.style.display = 'block';

    };

    image.onerror = function () {

        image.onload = null;
        image.onerror = null;

        frame.onload = function () {

            loading.style.display = 'none';
            frame.style.display = 'block';

        };

        frame.onerror = function () {

            loading.style.display = 'none';

            alert('File tidak dapat ditampilkan.');

        };

        frame.src = finalUrl;
    };

    image.src = finalUrl;
}

/* =========================================================
   CLOSE DOCUMENT PREVIEW
========================================================= */

function closeDocumentPreview(event) {

    const modal =
        document.getElementById('documentModal');

    const frame =
        document.getElementById('documentPreviewFrame');

    const image =
        document.getElementById('documentPreviewImage');

    const loading =
        document.getElementById('documentPreviewLoading');


    /*
     * Kalau event berasal dari klik,
     * hanya tutup jika yang diklik adalah
     * background modal.
     */
    if (
        event &&
        event.target !== modal
    ) {
        return;
    }


    if (frame) {

        frame.onload = null;
        frame.onerror = null;

        frame.src = 'about:blank';

        frame.style.display = 'none';
    }


    if (image) {

        image.onload = null;
        image.onerror = null;

        image.src = '';

        image.style.display = 'none';
    }


    if (loading) {
        loading.style.display = 'none';
    }


    if (modal) {

        modal.classList.remove('show');

        modal.setAttribute(
            'aria-hidden',
            'true'
        );
    }


    /*
     * WAJIB dikembalikan supaya
     * sidebar, logout, tombol, dll
     * bisa diklik lagi.
     */
    document.body.style.overflow = '';
}


/* =========================================================
   KLIK BACKGROUND MODAL
========================================================= */

document
    .getElementById('documentModal')
    ?.addEventListener(
        'click',
        function (event) {

            if (
                event.target === this
            ) {
                closeDocumentPreview(event);
            }
        }
    );


/* =========================================================
   ESCAPE
========================================================= */

document.addEventListener(
    'keydown',
    function (event) {

        if (
            event.key === 'Escape'
        ) {

            const modal =
                document.getElementById(
                    'documentModal'
                );

            if (
                modal &&
                modal.classList.contains('show')
            ) {
                closeDocumentPreview();
            }
        }
    }
);

</script>


</x-app-layout>

