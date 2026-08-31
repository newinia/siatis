<x-app-layout>

    {{-- =====================================================
    HALAMAN
    ====================================================== --}}
    <div class="participant-detail-page" x-data="{ showSavePopup: false }">

        {{-- =====================================================
        PROGRESS TAHAPAN
        ====================================================== --}}
        <section class="participant-progress">

            {{-- DATA CALON PPKS - SELESAI --}}
            <div class="progress-step completed">

                <div class="progress-circle">
                    <span class="material-symbols-outlined">
                        check
                    </span>
                </div>

                <span class="progress-label">
                    Data calon<br>PPKS
                </span>

            </div>

            <div class="progress-line completed"></div>


            {{-- ASESMEN kesehatan - SAAT INI --}}
            <div class="progress-step completed">

                <div class="progress-circle">
                    <span class="material-symbols-outlined">
                        check
                    </span>
                </div>


                <span class="progress-label">
                    Asesmen<br>kesehatan
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
                    Asesmen Kesehatan<br>Awal
                </span>

            </div>

            <div class="progress-line completed"></div>


            {{-- CASE CONFERENCE --}}
            <div class="progress-step completed">

                <div class="progress-circle">
                    <span class="material-symbols-outlined">
                        check
                    </span>
                </div>

                <span class="progress-label">
                    Case<br>Conference
                </span>

            </div>

            <div class="progress-line completed"></div>


            {{-- KESEHATAN LANJUTAN --}}
            <div class="progress-step current">

                <div class="progress-circle"></div>

                <span class="progress-label">
                    Kesehatan<br>Lanjutan
                </span>

            </div>

        </section>



        {{-- =====================================================
        FORM
        ====================================================== --}}
        <form class="participant-detail-card" method="POST">

            @csrf


            {{-- =================================================
            KEMBALI
            ================================================== --}}
            <a href="{{ route('case-conference-detail') }}" class="btn-back">

                <span class="material-symbols-outlined">
                    chevron_left
                </span>

                <span class="btn-back-text">
                    Kembali
                </span>

            </a>



            {{-- =================================================
            ASESMEN kesehatan
            ================================================== --}}
            <div class="detail-section">

                <div class="detail-section-title">
                    Asesmen Kesehatan Lanjutan
                </div>


                <div class="assessment-grid">
                    {{-- TANGGAL ASESMEN DARING --}}
                    <div class="detail-field">

                        <label for="tanggal_daring">
                            Tanggal Asesmen
                        </label>

                        <input type="date" id="tanggal_daring" name="tanggal_daring">

                    </div>

                    {{-- GELOMBANG & TAHUN --}}
                    <div class="detail-field">

                        <label>
                            Gelombang & Tahun
                        </label>

                        <div class="wave-year-group">

                            <select id="gelombang" name="gelombang">

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


                            <select id="tahun" name="tahun">

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




                    {{-- PETUGAS --}}
                    <div class="detail-field">

                        <label for="petugas_kesehatan">
                            Petugas Asesmen Kesehatan Lanjutan
                        </label>

                        <select id="petugas_kesehatan" name="petugas_kesehatan">

                            <option value="">
                                Pilih Petugas Asesmen Kesehatan
                            </option>

                            <option value="1">
                                Nama Petugas 1
                            </option>

                            <option value="2">
                                Nama Petugas 2
                            </option>

                        </select>

                    </div>



                    {{-- HASIL ASESMEN --}}
                    <div class="detail-field">

                        <label for="hasil_asesmen">
                            Asesmen Kesehatan
                        </label>

                        <select id="hasil_asesmen" name="hasil_asesmen">

                            <option value="">
                                Pilih status
                            </option>

                            <option value="Sudah">
                                Sudah
                            </option>

                            <option value="Belum">
                                Belum
                            </option>

                            <option value="proses">
                                Proses
                            </option>

                        </select>

                    </div>
                    {{-- Asesmen Fisiotrapis --}}
                    <div class="detail-field">

                        <label for="asesmen_psikologi">
                            Asesmen Psikologi
                        </label>

                        <select id="status_asesmen" name="status_asesmen">

                            <option value="">
                                Pilih Status
                            </option>

                            <option value="Sudah">
                                Sudah
                            </option>

                            <option value="Belum">
                                Belum
                            </option>

                            <option value="proses">
                                Proses
                            </option>

                        </select>

                    </div>
                    {{-- Asesmen Fisiotrapis --}}
                    <div class="detail-field">

                        <label for="asesmen_fisiotrapis">
                            Asesmen Fisiotrapis
                        </label>

                        <select id="hasil_asesmen" name="hasil_asesmen">

                            <option value="">
                                Pilih Status
                            </option>

                            <option value="Sudah">
                                Sudah
                            </option>

                            <option value="Belum">
                                Belum
                            </option>

                            <option value="proses">
                                Proses
                            </option>

                        </select>

                    </div>

                </div>



                {{-- CATATAN --}}
                <div class="detail-field assessment-note">

                    <label for="catatan_asesmen">
                        Catatan
                    </label>

                    <textarea id="catatan_asesmen" name="catatan_asesmen"
                        placeholder="Masukkan catatan tambahan (opsional)"></textarea>

                </div>

            </div>



            {{-- =================================================
            ASESMEN LURING
            ================================================== --}}
            <div class="offline-assessment-card">

                <div class="offline-header">


                    <div class="offline-title-group">

                        <div class="offline-icon">

                            <span class="material-symbols-outlined">
                                event
                            </span>

                        </div>

                        <div>

                            <div class="offline-title">
                                Asesmen Luring
                            </div>

                            <div class="offline-subtitle">
                                Aktifkan jika asesmen dilakukan secara luring
                            </div>

                        </div>

                    </div>



                    {{-- SWITCH --}}
                    <label class="offline-toggle">

                        <input type="checkbox" id="offlineAssessment" name="is_offline" value="1">

                        <span class="toggle-slider"></span>

                        <span class="toggle-text" id="offlineToggleText">
                            Tidak dilakukan secara luring
                        </span>

                    </label>

                </div>



                {{-- FORM LURING --}}
                <div class="offline-form" id="offlineForm">

                    <div class="offline-fields">


                        {{-- LOKASI --}}
                        <div class="detail-field">

                            <label for="lokasi_luring">
                                Lokasi Asesmen Luring
                            </label>

                            <input type="text" id="lokasi_luring" name="lokasi_luring"
                                placeholder="Masukkan lokasi asesmen luring">

                        </div>



                        {{-- TANGGAL --}}
                        <div class="detail-field">

                            <label for="tanggal_luring">
                                Tanggal Asesmen Luring
                            </label>

                            <input type="date" id="tanggal_luring" name="tanggal_luring">

                        </div>



                        {{-- PETUGAS --}}
                        <div class="detail-field">

                            <label for="petugas_luring">
                                Petugas Asesmen Kesehatan
                            </label>

                            <select id="petugas_luring" name="petugas_luring">

                                <option value="">
                                    Pilih Petugas Asesmen Kesehatan
                                </option>

                                <option value="1">
                                    Nama Petugas 1
                                </option>

                                <option value="2">
                                    Nama Petugas 2
                                </option>

                            </select>

                        </div>



                        {{-- HASIL --}}
                        <div class="detail-field">

                            <label for="hasil_luring">
                                Hasil Asesmen Kesehatan (Luring)
                            </label>

                            <select id="hasil_luring" name="hasil_luring">

                                <option value="">
                                    Pilih Hasil Asesmen kesehatan
                                </option>

                                <option value="lulus">
                                    Lulus
                                </option>

                                <option value="tidak_lulus">
                                    Tidak Lulus
                                </option>

                                <option value="pending">
                                    Pending
                                </option>

                            </select>

                        </div>

                    </div>



                    {{-- CATATAN LURING --}}
                    <div class="detail-field offline-note">

                        <label for="catatan_luring">
                            Catatan
                        </label>

                        <textarea id="catatan_luring" name="catatan_luring"
                            placeholder="Masukkan catatan tambahan (opsional)"></textarea>

                    </div>

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
                        Hasil Asesmen kesehatan Berhasil di Input
                    </p>


                    {{-- OK --}}
                    <button type="button" class="save-modal-button"
                        @click="window.location.href = '{{ route('asesmen-kesehatan-lanjutan-detail') }}'">
                        OK
                    </button>

                </div>

            </div>

        </template>

    </div>



    {{-- =====================================================
    JAVASCRIPT TOGGLE ASESMEN LURING
    ====================================================== --}}
    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const offlineToggle =
                document.getElementById('offlineAssessment');

            const offlineForm =
                document.getElementById('offlineForm');

            const offlineToggleText =
                document.getElementById('offlineToggleText');


            if (
                offlineToggle &&
                offlineForm &&
                offlineToggleText
            ) {

                offlineToggle.addEventListener('change', function () {

                    if (this.checked) {

                        offlineForm.classList.add('show');

                        offlineToggleText.textContent =
                            'Dilakukan secara luring';

                    } else {

                        offlineForm.classList.remove('show');

                        offlineToggleText.textContent =
                            'Tidak dilakukan secara luring';

                    }

                });

            }

        });

    </script>


</x-app-layout>