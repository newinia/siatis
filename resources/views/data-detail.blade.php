<x-app-layout>

    <div class="participant-detail-page">

        {{-- =====================================================
        PROGRESS TAHAPAN
        ====================================================== --}}
        <section class="participant-progress">

            {{-- STEP 1 --}}
            <div class="progress-step completed">
                <div class="progress-circle">
                    <span class="material-symbols-outlined">
                        check
                    </span>
                </div>

                <span class="progress-label">
                    Data Calon<br>
                    PPKS
                </span>
            </div>


            <div class="progress-line"></div>


            {{-- STEP 2 --}}
            <div class="progress-step">
                <div class="progress-circle"></div>

                <span class="progress-label">
                    Asesmen<br>
                    Instruktur
                </span>
            </div>


            <div class="progress-line"></div>


            {{-- STEP 3 --}}
            <div class="progress-step">
                <div class="progress-circle"></div>

                <span class="progress-label">
                    Asesmen Kesehatan<br>
                    Awal
                </span>
            </div>


            <div class="progress-line"></div>


            {{-- STEP 4 --}}
            <div class="progress-step">
                <div class="progress-circle"></div>

                <span class="progress-label">
                    Case<br>
                    Conference
                </span>
            </div>


            <div class="progress-line"></div>


            {{-- STEP 5 --}}
            <div class="progress-step">
                <div class="progress-circle"></div>

                <span class="progress-label">
                    Kesehatan<br>
                    Lanjutan
                </span>
            </div>

        </section>



        {{-- =====================================================
        CARD UTAMA
        ====================================================== --}}
        <section class="participant-detail-card">


            {{-- ============================================
            A. DATA PPKS
            ============================================= --}}
            <div class="detail-section">

                <div class="detail-section-title">
                    A. Data PPKS
                </div>


                <div class="participant-profile-layout">


                    {{-- FOTO --}}
                    <div class="participant-photo-wrapper">

                        <div class="participant-photo">

                            {{-- GANTI src NANTI SESUAI DATA FOTO --}}
                            <img src="https://via.placeholder.com/300x400.png?text=Foto+Peserta" alt="Foto Peserta">

                        </div>


                        <div class="participant-import-info">

                            <span>Data masuk :</span>

                            <strong>
                                23-08-2025
                            </strong>

                        </div>

                    </div>



                    {{-- FORM DATA --}}
                    <div class="participant-data-grid">


                        {{-- NAMA --}}
                        <div class="detail-field">

                            <label>
                                Nama Lengkap
                            </label>

                            <input type="text" value="Siti Rahmawati" readonly>

                        </div>



                        {{-- NIK --}}
                        <div class="detail-field">

                            <label>
                                NIK
                            </label>

                            <input type="text" value="327XXXXXXXXXXXXX" readonly>

                        </div>



                        {{-- USIA --}}
                        <div class="detail-field">

                            <label>
                                Usia
                            </label>

                            <input type="text" value="22 Tahun" readonly>

                        </div>



                        {{-- JENIS KELAMIN --}}
                        <div class="detail-field">

                            <label>
                                Jenis Kelamin
                            </label>

                            <input type="text" value="Perempuan" readonly>

                        </div>



                        {{-- TANGGAL LAHIR --}}
                        <div class="detail-field">

                            <label>
                                Tanggal Lahir
                            </label>

                            <input type="text" value="12 Januari 2004" readonly>

                        </div>



                        {{-- TEMPAT LAHIR --}}
                        <div class="detail-field">

                            <label>
                                Tempat Lahir
                            </label>

                            <input type="text" value="Depok" readonly>

                        </div>


                    </div>

                </div>

            </div>



            {{-- ============================================
            B. DATA ALAMAT
            ============================================= --}}
            <div class="detail-section">

                <div class="detail-section-title">
                    B. Data Alamat
                </div>


                <div class="detail-address-grid">


                    {{-- ALAMAT --}}
                    <div class="detail-field field-address">

                        <label>
                            Alamat Lengkap
                        </label>

                        <input type="text" value="Jl. Contoh No. 10" readonly>

                    </div>



                    {{-- PROVINSI --}}
                    <div class="detail-field">

                        <label>
                            Provinsi
                        </label>

                        <input type="text" value="Jawa Barat" readonly>

                    </div>



                    {{-- KABUPATEN --}}
                    <div class="detail-field">

                        <label>
                            Kabupaten
                        </label>

                        <input type="text" value="Bogor" readonly>

                    </div>



                    {{-- KECAMATAN --}}
                    <div class="detail-field">

                        <label>
                            Kecamatan
                        </label>

                        <input type="text" value="Cibinong" readonly>

                    </div>



                    {{-- KELURAHAN --}}
                    <div class="detail-field">

                        <label>
                            Kelurahan
                        </label>

                        <input type="text" value="Pakansari" readonly>

                    </div>


                </div>

            </div>



            {{-- ============================================
            C. KONTAK
            ============================================= --}}
            <div class="detail-section">

                <div class="detail-section-title">
                    C. Kontak
                </div>


                <div class="detail-contact-grid">


                    {{-- HP 1 --}}
                    <div class="detail-field">

                        <label>
                            Nomor HP 1
                        </label>

                        <input type="text" value="081234567890" readonly>

                    </div>



                    {{-- HP 2 --}}
                    <div class="detail-field">

                        <label>
                            Nomor HP 2
                        </label>

                        <input type="text" value="-" readonly>

                    </div>



                    {{-- EMAIL --}}
                    <div class="detail-field">

                        <label>
                            Email
                        </label>

                        <input type="text" value="siti@email.com" readonly>

                    </div>


                </div>

            </div>
            {{-- ============================================
            D. PENDIDIKAN & PELATIHAN
            ============================================ --}}
            <div class="detail-section">

                <div class="detail-section-title">
                    D. Pendidikan & Pelatihan
                </div>


                <div class="detail-address-grid">

                    {{-- PENDIDIKAN TERAKHIR --}}
                    <div class="detail-field">

                        <label>
                            Pendidikan Terakhir
                        </label>

                        <input type="text" value="SMA / Sederajat" readonly>

                    </div>


                    {{-- KETERANGAN PENDIDIKAN --}}
                    <div class="detail-field">

                        <label>
                            Keterangan Pendidikan
                        </label>

                        <input type="text" value="-" readonly>

                    </div>


                    {{-- JURUSAN YANG DIMINATI --}}
                    <div class="detail-field">

                        <label>
                            Jurusan Yang Diminati
                        </label>

                        <input type="text" value="Desain Grafis" readonly>

                    </div>


                    {{-- KURSUS --}}
                    <div class="detail-field">

                        <label>
                            Kursus yang Pernah Diikuti
                        </label>

                        <input type="text" value="-" readonly>

                    </div>


                    {{-- PEMINATAN --}}
                    <div class="detail-field">

                        <label>
                            Peminatan
                        </label>

                        <input type="text" value="-" readonly>

                    </div>


                    {{-- ALUMNI STIS --}}
                    <div class="detail-field">

                        <label>
                            Alumni STIS
                        </label>

                        <input type="text" value="Belum Pernah" readonly>

                    </div>

                </div>

            </div>



            {{-- ============================================
            E. DATA DISABILITAS & AKTIVITAS
            ============================================ --}}
            <div class="detail-section">

                <div class="detail-section-title">
                    E. Data Disabilitas & Aktivitas
                </div>


                <div class="detail-address-grid">

                    {{-- JENIS PPKS --}}
                    <div class="detail-field">

                        <label>
                            Jenis PPKS
                        </label>

                        <input type="text" value="Disabilitas Fisik" readonly>

                    </div>


                    {{-- KETERANGAN DISABILITAS --}}
                    <div class="detail-field">

                        <label>
                            Keterangan Disabilitas
                        </label>

                        <input type="text" value="-" readonly>

                    </div>


                    {{-- KEMAMPUAN --}}
                    <div class="detail-field">

                        <label>
                            Kemampuan Membaca & Menulis
                        </label>

                        <input type="text" value="Mampu" readonly>

                    </div>


                    {{-- AKTIVITAS --}}
                    <div class="detail-field">

                        <label>
                            Aktivitas Kehidupan Sehari-hari
                        </label>

                        <input type="text" value="Mandiri" readonly>

                    </div>


                    {{-- KONDISI SAAT INI --}}
                    <div class="detail-field">

                        <label>
                            Kondisi Saat Ini
                        </label>

                        <input type="text" value="Baik" readonly>

                    </div>


                    {{-- BERSEDIA --}}
                    <div class="detail-field">

                        <label>
                            Bersedia Mengikuti Pelatihan STIS
                        </label>

                        <input type="text" value="Bersedia" readonly>

                    </div>

                </div>

            </div>



            {{-- ============================================
            F. BERKAS DOKUMEN
            ============================================ --}}
            <div class="detail-section">

                <div class="detail-section-title">
                    F. Berkas Dokumen
                </div>


                <div class="document-grid">


                    {{-- KARTU KELUARGA --}}
                    <div class="document-item">

                        <div class="document-label">
                            Kartu Keluarga (KK)
                        </div>

                        <div class="document-preview">

                            {{-- NANTI ISI DENGAN IMAGE / PDF --}}
                            <span class="material-symbols-outlined document-icon">
                                description
                            </span>

                            <span>
                                Berkas KK
                            </span>

                        </div>

                    </div>



                    {{-- KTP --}}
                    <div class="document-item">

                        <div class="document-label">
                            Kartu Tanda Penduduk (KTP)
                        </div>

                        <div class="document-preview">

                            <span class="material-symbols-outlined document-icon">
                                badge
                            </span>

                            <span>
                                Berkas KTP
                            </span>

                        </div>

                    </div>



                    {{-- AKTE --}}
                    <div class="document-item">

                        <div class="document-label">
                            Akte Kelahiran
                        </div>

                        <div class="document-preview">

                            <span class="material-symbols-outlined document-icon">
                                article
                            </span>

                            <span>
                                Berkas Akte
                            </span>

                        </div>

                    </div>



                    {{-- IJAZAH --}}
                    <div class="document-item">

                        <div class="document-label">
                            Ijazah
                        </div>

                        <div class="document-preview">

                            <span class="material-symbols-outlined document-icon">
                                school
                            </span>

                            <span>
                                Berkas Ijazah
                            </span>

                        </div>

                    </div>


                </div>

            </div>
            <a href="{{ route('asesmen-instruktur-detail') }}" class="btn" style="margin-left: auto;">
                Lanjut
            </a>



        </section>


    </div>

</x-app-layout>