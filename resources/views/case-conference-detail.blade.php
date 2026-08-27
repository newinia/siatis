<x-app-layout>

    <div class="participant-detail-page" x-data="{ showSavePopup: false }">

        {{-- =====================================================
        PROGRESS TAHAPAN
        ====================================================== --}}
        <section class="participant-progress">

            {{-- DATA CALON PPKS --}}
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

            <div class="progress-line completed"></div>


            {{-- ASESMEN INSTRUKTUR --}}
            <div class="progress-step completed">

                <div class="progress-circle">
                    <span class="material-symbols-outlined">
                        check
                    </span>
                </div>

                <span class="progress-label">
                    Asesmen<br>
                    Instruktur
                </span>

            </div>

            <div class="progress-line completed"></div>


            {{-- ASESMEN KESEHATAN AWAL --}}
            <div class="progress-step completed">

                <div class="progress-circle">
                    <span class="material-symbols-outlined">
                        check
                    </span>
                </div>

                <span class="progress-label">
                    Asesmen Kesehatan<br>
                    Awal
                </span>

            </div>

            <div class="progress-line completed"></div>


            {{-- CASE CONFERENCE --}}
            <div class="progress-step current">

                <div class="progress-circle"></div>

                <span class="progress-label">
                    Case<br>
                    Conference
                </span>

            </div>

            <div class="progress-line"></div>


            {{-- KESEHATAN LANJUTAN --}}
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
        <form class="participant-detail-card" method="POST">

            @csrf


            {{-- =================================================
            KEMBALI
            ================================================== --}}
            <a href="{{ route('asesmen-kesehatan-awal-detail') }}" class="btn-back">

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
            <div class="detail-section">

                <div class="detail-section-title">
                    Data Calon PPKS
                </div>


                <div class="participant-profile-layout">


                    {{-- FOTO --}}
                    <div class="participant-photo-wrapper">

                        <div class="participant-photo">

                            <img src="https://via.placeholder.com/300x400.png?text=Foto+Peserta" alt="Foto Peserta">

                        </div>


                        <div class="participant-import-info">

                            <span>
                                Data masuk :
                            </span>

                            <strong>
                                23-08-2025
                            </strong>

                        </div>

                    </div>



                    {{-- DATA PESERTA --}}
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



            {{-- =================================================
            CATATAN INSTRUKTUR
            ================================================== --}}
            <div class="detail-section">

                <div class="detail-field">

                    <label for="catatan_instruktur">
                        Catatan Instruktur
                    </label>

                    <textarea id="catatan_instruktur" name="catatan_instruktur"
                        placeholder="Masukkan catatan tambahan (opsional)"></textarea>

                </div>

            </div>



            {{-- =================================================
            CATATAN KESEHATAN
            ================================================== --}}
            <div class="detail-section">

                <div class="detail-field">

                    <label for="catatan_kesehatan">
                        Catatan Kesehatan
                    </label>

                    <textarea id="catatan_kesehatan" name="catatan_kesehatan"
                        placeholder="Masukkan catatan tambahan (opsional)"></textarea>

                </div>

            </div>



            {{-- =================================================
            HASIL CASE CONFERENCE
            ================================================== --}}
            <div class="detail-section">


                <div class="assessment-grid">


                    {{-- HASIL CASE CONFERENCE --}}
                    <div class="detail-field">

                        <label for="hasil_case_conference">
                            Hasil Case Conference
                        </label>

                        <select id="hasil_case_conference" name="hasil_case_conference">

                            <option value="">
                                Pilih Hasil Case Conference
                            </option>

                            <option value="diterima">
                                Diterima
                            </option>

                            <option value="tidak_diterima">
                                Tidak Diterima
                            </option>

                            <option value="pending">
                                Pending
                            </option>

                        </select>

                    </div>



                    {{-- JURUSAN DITERIMA --}}
                    <div class="detail-field">

                        <label for="jurusan_diterima">
                            Jurusan Diterima
                        </label>

                        <select id="jurusan_diterima" name="jurusan_diterima">

                            <option value="">
                                Pilih Jurusan
                            </option>

                            <option value="desain_grafis">
                                Desain Grafis
                            </option>

                            <option value="komputer">
                                Komputer
                            </option>

                            <option value="menjahit">
                                Menjahit
                            </option>

                            <option value="barista">
                                Barista
                            </option>

                            <option value="kuliner">
                                Kuliner
                            </option>

                        </select>

                    </div>



                    {{-- TANGGAL CASE CONFERENCE --}}
                    <div class="detail-field">

                        <label for="tanggal_case_conference">
                            Tanggal Case Conference
                        </label>

                        <input type="date" id="tanggal_case_conference" name="tanggal_case_conference">

                    </div>



                    {{-- GELOMBANG & TAHUN PELATIHAN --}}
                    <div class="detail-field">

                        <label>
                            Gelombang & Tahun Pelatihan
                        </label>


                        <div class="wave-year-group">


                            {{-- GELOMBANG --}}
                            <select id="gelombang_pelatihan" name="gelombang_pelatihan">

                                <option value="">
                                    Pilih Gelombang
                                </option>

                                <option value="1">
                                    Gelombang 1
                                </option>

                                <option value="2">
                                    Gelombang 2
                                </option>

                            </select>



                            {{-- TAHUN --}}
                            <select id="tahun_pelatihan" name="tahun_pelatihan">

                                <option value="">
                                    Tahun
                                </option>

                                <option value="2026">
                                    2026
                                </option>

                                <option value="2027">
                                    2027
                                </option>

                                <option value="2028">
                                    2028
                                </option>

                            </select>


                        </div>

                    </div>


                </div>

            </div>



            {{-- =================================================
            CATATAN CASE CONFERENCE
            ================================================== --}}
            <div class="detail-section">

                <div class="detail-field">

                    <label for="catatan_case_conference">
                        Catatan Case Conference
                    </label>

                    <textarea id="catatan_case_conference" name="catatan_case_conference"
                        placeholder="Masukkan catatan tambahan (opsional)"></textarea>

                </div>

            </div>



            {{-- =================================================
            BUTTON
            ================================================== --}}
            <div class="form-action">


                {{-- SIMPAN --}}
                <button type="button" class="btn-save" @click="showSavePopup = true">
                    Simpan
                </button>



                {{-- SELANJUTNYA --}}
                <a href="{{ route('asesmen-kesehatan-lanjutan-detail') }}" class="btn">
                    Selanjutnya
                </a>


            </div>


        </form>



        {{-- =====================================================
        POPUP BERHASIL
        ====================================================== --}}
        <template x-if="showSavePopup">

            <div class="save-modal-overlay">

                <div class="save-modal">


                    {{-- ICON --}}
                    <div class="save-modal-icon">

                        <span class="material-symbols-outlined">
                            check_circle
                        </span>

                    </div>



                    {{-- JUDUL --}}
                    <h3 class="save-modal-title">
                        Berhasil
                    </h3>



                    {{-- PESAN --}}
                    <p class="save-modal-message">
                        Hasil Case Conference berhasil diinput
                    </p>



                    {{-- OK --}}
                    <button type="button" class="save-modal-button" @click="
                            window.location.href =
                            '{{ route('case-conference-detail') }}'
                        ">
                        OK
                    </button>


                </div>

            </div>

        </template>


    </div>

</x-app-layout>