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


        $getAnyData = function (array $keys, $default = '-') use ($data, $getData) {

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
            PROGRESS TAHAPAN
            ====================================================== --}}

            <x-participant-progress :active-step="1" :detail="true" />


            {{-- =====================================================
            MAIN CARD
            ====================================================== --}}

            <section class="participant-detail-card">

                {{-- =================================================
                KEMBALI
                ================================================== --}}
                <a href="{{ route('ppks.normal.instruktur') }}" class="btn-back">

                    <span class="material-symbols-outlined">
                        chevron_left
                    </span>

                    <span class="btn-back-text">
                        Kembali
                    </span>

                </a>




                {{-- =================================================
                A. DATA PPKS
                ================================================== --}}

                <div class="detail-section mt-4">

                    <div class="detail-section-title">
                        A. Data PPKS
                    </div>


                    <div class="participant-profile-layout">


                        {{-- FOTO --}}

                        <div class="participant-photo-wrapper">

                            <div class="participant-photo">

                                @if (!empty($fotoUrl))

                                    <img src="{{ $fotoUrl }}" alt="Foto {{ $nama }}" onerror="
                                                    this.style.display='none';
                                                    this.nextElementSibling.style.display='flex';
                                                ">

                                    <div class="photo-placeholder" style="display:none;">

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

                                <input type="text" value="{{ $nama }}" readonly>

                            </div>


                            <div class="detail-field">

                                <label>
                                    NIK
                                </label>

                                <input type="text" value="{{ $nik }}" readonly>

                            </div>


                            <div class="detail-field">

                                <label>
                                    Usia
                                </label>

                                <input type="text" value="{{ $usia !== '-' ? $usia . ' Tahun' : '-' }}" readonly>

                            </div>


                            <div class="detail-field">

                                <label>
                                    Jenis Kelamin
                                </label>

                                <input type="text" value="{{ $getAnyData(['jenis_kelamin', 'jk']) }}" readonly>

                            </div>


                            <div class="detail-field">

                                <label>
                                    Tanggal Lahir
                                </label>

                                <input type="text" value="{{ $getAnyData(['tanggal_lahir', 'tgl_lahir']) }}" readonly>

                            </div>


                            <div class="detail-field">

                                <label>
                                    Tempat Lahir
                                </label>

                                <input type="text" value="{{ $getAnyData(['tempat_lahir']) }}" readonly>

                            </div>


                            <div class="detail-field">

                                <label>
                                    No. KK
                                </label>

                                <input type="text" value="{{ $getAnyData(['no_kk', 'nomor_kk']) }}" readonly>

                            </div>


                            <div class="detail-field">

                                <label>
                                    Status Perkawinan
                                </label>

                                <input type="text" value="{{ $getAnyData(['status_perkawinan']) }}" readonly>

                            </div>


                            <div class="detail-field">

                                <label>
                                    Agama
                                </label>

                                <input type="text" value="{{ $getAnyData(['agama']) }}" readonly>

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

                            <input type="text" value="{{ $getAnyData(['alamat_lengkap', 'alamat']) }}" readonly>

                        </div>


                        <div class="detail-field">

                            <label>
                                Provinsi
                            </label>

                            <input type="text" value="{{ $getAnyData(['provinsi']) }}" readonly>

                        </div>


                        <div class="detail-field">

                            <label>
                                Kabupaten
                            </label>

                            <input type="text" value="{{ $getAnyData(['kabupaten', 'kabupaten_kota']) }}" readonly>

                        </div>


                        <div class="detail-field">

                            <label>
                                Kecamatan
                            </label>

                            <input type="text" value="{{ $getAnyData(['kecamatan']) }}" readonly>

                        </div>


                        <div class="detail-field">

                            <label>
                                Kelurahan
                            </label>

                            <input type="text" value="{{ $getAnyData(['kelurahan', 'desa_kelurahan']) }}" readonly>

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

                            <input type="text" value="{{ $hp1 }}" readonly>

                        </div>


                        <div class="detail-field">

                            <label>
                                Nomor HP 2
                            </label>

                            <input type="text" value="{{ $hp2 }}" readonly>

                        </div>


                        <div class="detail-field">

                            <label>
                                Email
                            </label>

                            <input type="text" value="{{ $email }}" readonly>

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

                            <input type="text" value="{{ $getAnyData(['pendidikan_terakhir']) }}" readonly>

                        </div>


                        <div class="detail-field">

                            <label>
                                Keterangan Pendidikan
                            </label>

                            <input type="text" value="{{ $getAnyData(['keterangan_pendidikan']) }}" readonly>

                        </div>


                        <div class="detail-field">

                            <label>
                                Jurusan Yang Diminati
                            </label>

                            <input type="text" value="{{ $getAnyData(['jurusan_yang_diminati']) }}" readonly>

                        </div>


                        <div class="detail-field">

                            <label>
                                Kursus yang Pernah Diikuti
                            </label>

                            <input type="text" value="{{ $getAnyData([
    'pelatihan_kursus',
    'kursus_yang_pernah_diikuti'
]) }}" readonly>

                        </div>


                        <div class="detail-field">

                            <label>
                                Peminatan
                            </label>

                            <input type="text" value="{{ $getAnyData(['peminatan']) }}" readonly>

                        </div>


                        <div class="detail-field">

                            <label>
                                Alumni STIS
                            </label>

                            <input type="text" value="{{ $getAnyData(['alumni_stis']) }}" readonly>

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

                            <input type="text" value="{{ $getAnyData(['jenis_ppks']) }}" readonly>

                        </div>


                        <div class="detail-field">

                            <label>
                                Keterangan Disabilitas
                            </label>

                            <input type="text" value="{{ $getAnyData(['keterangan_disabilitas']) }}" readonly>

                        </div>


                        <div class="detail-field">

                            <label>
                                Kemampuan Membaca & Menulis
                            </label>

                            <input type="text" value="{{ $getAnyData(['kemampuan_membaca_menulis']) }}" readonly>

                        </div>


                        <div class="detail-field">

                            <label>
                                Aktivitas Kehidupan Sehari-hari
                            </label>

                            <input type="text" value="{{ $getAnyData([
    'aktivitas_sehari_hari',
    'aktivitas_kehidupan_sehari_hari'
]) }}" readonly>

                        </div>


                        <div class="detail-field">

                            <label>
                                Kondisi Saat Ini
                            </label>

                            <input type="text" value="{{ $getAnyData([
    'kondisi_kesehatan',
    'kondisi_saat_ini'
]) }}" readonly>

                        </div>


                        <div class="detail-field">

                            <label>
                                Bersedia Mengikuti Pelatihan STIS
                            </label>

                            <input type="text" value="{{ $getAnyData([
    'bersedia_pelatihan_vokasional',
    'bersedia_mengikuti_pelatihan_stis'
]) }}" readonly>

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

                                <button type="button" class="document-preview document-preview-button" onclick="openDocumentPreview(
                                                @js($kkUrl),
                                                'Kartu Keluarga (KK)'
                                            )">

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

                                <button type="button" class="document-preview document-preview-button" onclick="openDocumentPreview(
                                                @js($ktpUrl),
                                                'Kartu Tanda Penduduk (KTP)'
                                            )">

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

                                <button type="button" class="document-preview document-preview-button" onclick="openDocumentPreview(
                                                @js($fotoUrl),
                                                'Foto Full Badan'
                                            )">

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

                                <button type="button" class="document-preview document-preview-button" onclick="openDocumentPreview(
                                                @js($ijazahUrl),
                                                'Ijazah'
                                            )">

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

                    <a href="{{ route(
                            'ppks.normal.asesmen-instruktur.detail',
                            $ppks
                        ) }}" class="btn-next">

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

    <div class="document-modal" id="documentModal" aria-hidden="true">

        <div class="document-modal-card" role="dialog" aria-modal="true" aria-labelledby="documentModalTitle">

            <div class="document-modal-header">

                <div class="document-modal-info">

                    <div class="document-modal-title" id="documentModalTitle">
                        Preview Dokumen
                    </div>

                    <div class="document-modal-name" id="documentModalName"></div>

                </div>


                <button type="button" class="document-close" onclick="closeDocumentPreview()" aria-label="Tutup">

                    <span class="material-symbols-outlined">
                        close
                    </span>

                </button>

            </div>


            <div class="document-preview-container">

                <iframe id="documentPreviewFrame" class="document-preview-frame" src="about:blank"
                    title="Preview Dokumen"></iframe>


                <img id="documentPreviewImage" class="document-preview-image" src="" alt="Preview Dokumen">


                <div id="documentPreviewLoading" class="document-preview-loading">

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

<<<<<<< HEAD
=======
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
    grid-template-columns: 160px minmax(0, 1fr);
    gap: 24px;
    align-items: start;
}  

.participant-photo-wrapper {
    width: 180px;
    text-align: center;
}
.participant-photo {
    width: 150px;
    height: 200px;
    margin: 0 auto;
    overflow: hidden;
    border: 1px solid #d1d5db;
    border-radius: 10px;
    background: #f9fafb;

    display: flex;
    align-items: center;
    justify-content: center;
}

.participant-photo img {
    width: 100%;
    height: 100%;
    display: block;

    object-fit: contain;
    object-position: center;
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
>>>>>>> origin/development


    <script>

        /* =========================================================
           OPEN DOCUMENT PREVIEW
        ========================================================= */

        function openDocumentPreview(url, fileName = '') {

            const modal =
                document.getElementById('documentModal');

            const frame =
                document.getElementById('documentPreviewFrame');

            const image =
                document.getElementById('documentPreviewImage');

            const loading =
                document.getElementById('documentPreviewLoading');

            const title =
                document.getElementById('documentModalTitle');

            const name =
                document.getElementById('documentModalName');


            if (!url) {

                alert('File tidak tersedia.');

                return;
            }


            if (
                !modal ||
                !frame ||
                !image ||
                !loading
            ) {

                console.error(
                    'Elemen preview dokumen tidak ditemukan.'
                );

                return;
            }


            const finalUrl =
                String(url).trim();


            /* =====================================================
               SET JUDUL
            ===================================================== */

            if (title) {

                title.textContent =
                    'Preview Dokumen';
            }


            if (name) {

                name.textContent =
                    fileName || '';
            }


            /* =====================================================
               RESET
            ===================================================== */

            frame.onload = null;
            frame.onerror = null;

            image.onload = null;
            image.onerror = null;

            frame.src =
                'about:blank';

            image.src =
                '';

            frame.style.display =
                'none';

            image.style.display =
                'none';

            loading.style.display =
                'flex';


            modal.classList.add('show');

            modal.setAttribute(
                'aria-hidden',
                'false'
            );

            document.body.style.overflow =
                'hidden';


            /* =====================================================
               DETEKSI FILE
            ===================================================== */

            const cleanUrl =
                finalUrl
                    .split('#')[0]
                    .split('?')[0]
                    .toLowerCase();

            const cleanFileName =
                String(fileName || '')
                    .toLowerCase();


            const isPdf =
                cleanUrl.endsWith('.pdf') ||
                cleanFileName.endsWith('.pdf');


            const isImage =
                /\.(jpg|jpeg|png|gif|webp|bmp|svg)$/i.test(cleanUrl) ||
                /\.(jpg|jpeg|png|gif|webp|bmp|svg)$/i.test(cleanFileName);


            /* =====================================================
               GAMBAR
            ===================================================== */

            if (isImage) {

                image.onload = function () {

                    loading.style.display =
                        'none';

                    image.style.display =
                        'block';

                };


                image.onerror = function () {

                    loading.style.display =
                        'none';


                    frame.onload = function () {

                        loading.style.display =
                            'none';

                        frame.style.display =
                            'block';

                    };


                    frame.src =
                        finalUrl;
                };


                image.src =
                    finalUrl;

                return;
            }


            /* =====================================================
               PDF
            ===================================================== */

            if (isPdf) {

                frame.onload = function () {

                    loading.style.display =
                        'none';

                    frame.style.display =
                        'block';

                };


                frame.src =
                    finalUrl;

                return;
            }


            /* =====================================================
               GOOGLE DRIVE / URL TANPA EXTENSION
            ===================================================== */

            image.onload = function () {

                loading.style.display =
                    'none';

                image.style.display =
                    'block';

            };


            image.onerror = function () {

                image.onload = null;
                image.onerror = null;


                frame.onload = function () {

                    loading.style.display =
                        'none';

                    frame.style.display =
                        'block';

                };


                frame.onerror = function () {

                    loading.style.display =
                        'none';

                    alert(
                        'File tidak dapat ditampilkan.'
                    );
                };


                frame.src =
                    finalUrl;
            };


            image.src =
                finalUrl;
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
             * Hanya tutup jika klik background modal.
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

                frame.src =
                    'about:blank';

                frame.style.display =
                    'none';
            }


            if (image) {

                image.onload = null;
                image.onerror = null;

                image.src =
                    '';

                image.style.display =
                    'none';
            }


            if (loading) {

                loading.style.display =
                    'none';
            }


            if (modal) {

                modal.classList.remove(
                    'show'
                );

                modal.setAttribute(
                    'aria-hidden',
                    'true'
                );
            }


            document.body.style.overflow =
                '';
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

                        closeDocumentPreview(
                            event
                        );
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
                        modal.classList.contains(
                            'show'
                        )
                    ) {

                        closeDocumentPreview();
                    }

                }

            }
        );

    </script>


</x-app-layout>