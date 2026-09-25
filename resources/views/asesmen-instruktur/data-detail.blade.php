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