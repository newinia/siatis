<x-app-layout>
    <div
        class="participant-detail-page"
        x-data="{ showSavePopup: false }"
    >

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
                    Data calon<br>PPKS
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
                    Asesmen<br>Instruktur
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
        <form
            x-ref="assessmentForm"
            class="participant-detail-card"
            method="POST"
            action="{{ route(
                'ppks.normal.kesehatan-lanjutan.update',
                $ppks
            ) }}"
        >

            @csrf


            {{-- =================================================
            KEMBALI
            ================================================== --}}
            <a
                href="{{ route(
                    'ppks.normal.kesehatan-lanjutan'
                ) }}"
                class="btn-back"
            >

                <span class="material-symbols-outlined">
                    chevron_left
                </span>

                <span class="btn-back-text">
                    Kembali
                </span>

            </a>



            {{-- =================================================
            HEADER PESERTA
            ================================================== --}}
            @php

                $data = is_array($ppks->data)
                    ? $ppks->data
                    : [];

                $nama = $data['nama_lengkap']
                    ?? $data['nama']
                    ?? '-';

                $nik = $data['nik']
                    ?? '-';

                $umur = $data['usia']
                    ?? '-';

                $jenisPpks = $data['jenis_ppks']
                    ?? '-';

                $jurusan = $caseConference->jurusan_diterima
                    ?? '-';

            @endphp



            {{-- =================================================
            DATA PESERTA
            ================================================== --}}
            <div class="detail-section participant-info-section">

                <div class="detail-section-title">
                    Data Peserta
                </div>


                <div class="assessment-grid">

                    {{-- NAMA --}}
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


                    {{-- NIK --}}
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


                    {{-- UMUR --}}
                    <div class="detail-field">

                        <label>
                            Umur
                        </label>

                        <input
                            type="text"
                            value="{{ $umur }}"
                            readonly
                        >

                    </div>


                    {{-- JENIS PPKS --}}
                    <div class="detail-field">

                        <label>
                            Jenis PPKS
                        </label>

                        <input
                            type="text"
                            value="{{ $jenisPpks }}"
                            readonly
                        >

                    </div>


                    {{-- JURUSAN --}}
                    <div class="detail-field">

                        <label>
                            Jurusan Diterima
                        </label>

                        <input
                            type="text"
                            value="{{ $jurusan }}"
                            readonly
                        >

                    </div>

                </div>

            </div>



            {{-- =================================================
            ASESMEN KESEHATAN LANJUTAN
            ================================================== --}}
            <div class="detail-section">

                <div class="detail-section-title">
                    Asesmen Kesehatan Lanjutan
                </div>


                <div class="assessment-grid">


                    {{-- =================================================
                    TANGGAL ASESMEN
                    ================================================== --}}
                    <div class="detail-field">

                        <label for="tanggal_asesmen">
                            Tanggal Asesmen
                        </label>

                        <input
                            type="date"
                            id="tanggal_asesmen"
                            name="tanggal_asesmen"
                            value="{{ old(
                                'tanggal_asesmen',
                                $kesehatanLanjutan?->tanggal_asesmen?->format('Y-m-d')
                            ) }}"
                            required
                        >

                    </div>



                    {{-- =================================================
                    GELOMBANG & TAHUN
                    ================================================== --}}
                    <div class="detail-field">

                        <label>
                            Gelombang & Tahun
                        </label>

                        <div class="wave-year-group">

                            {{-- GELOMBANG --}}
                            <select
                                id="gelombang"
                                name="gelombang"
                            >

                                <option value="">
                                    Pilih Gelombang
                                </option>

                                <option
                                    value="1"
                                    {{ old(
                                        'gelombang',
                                        $kesehatanLanjutan?->gelombang
                                    ) == '1'
                                        ? 'selected'
                                        : '' }}
                                >
                                    Gelombang 1
                                </option>

                                <option
                                    value="2"
                                    {{ old(
                                        'gelombang',
                                        $kesehatanLanjutan?->gelombang
                                    ) == '2'
                                        ? 'selected'
                                        : '' }}
                                >
                                    Gelombang 2
                                </option>

                            </select>


                            {{-- TAHUN --}}
                            <select
                                id="tahun"
                                name="tahun"
                            >

                                <option value="">
                                    Tahun
                                </option>

                                @for ($tahun = 2026; $tahun <= 2028; $tahun++)

                                    <option
                                        value="{{ $tahun }}"
                                        {{ old(
                                            'tahun',
                                            $kesehatanLanjutan?->tahun
                                        ) == $tahun
                                            ? 'selected'
                                            : '' }}
                                    >
                                        {{ $tahun }}
                                    </option>

                                @endfor

                            </select>

                        </div>

                    </div>



                    {{-- =================================================
                    PETUGAS KESEHATAN
                    ================================================== --}}
                    <div class="detail-field">

                        <label for="petugas_kesehatan">
                            Petugas Asesmen Kesehatan Lanjutan
                        </label>

                        <select
                            id="petugas_kesehatan"
                            name="petugas_kesehatan"
                        >

                            <option value="">
                                Pilih Petugas Asesmen Kesehatan
                            </option>

                            @foreach ($petugas as $user)

                                <option
                                    value="{{ $user->name }}"
                                    {{ old(
                                        'petugas_kesehatan',
                                        $kesehatanLanjutan?->petugas_kesehatan
                                    ) == $user->name
                                        ? 'selected'
                                        : '' }}
                                >
                                    {{ $user->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>



                    {{-- =================================================
                    ASESMEN KESEHATAN
                    ================================================== --}}
                    <div class="detail-field">

                        <label for="hasil_asesmen">
                            Asesmen Kesehatan
                        </label>

                        <select
                            id="hasil_asesmen"
                            name="hasil_asesmen"
                        >

                            <option value="">
                                Pilih Status
                            </option>

                            <option
                                value="sudah"
                                {{ old(
                                    'hasil_asesmen',
                                    $kesehatanLanjutan?->hasil_asesmen
                                ) == 'sudah'
                                    ? 'selected'
                                    : '' }}
                            >
                                Sudah
                            </option>

                            <option
                                value="belum"
                                {{ old(
                                    'hasil_asesmen',
                                    $kesehatanLanjutan?->hasil_asesmen
                                ) == 'belum'
                                    ? 'selected'
                                    : '' }}
                            >
                                Belum
                            </option>

                            <option
                                value="proses"
                                {{ old(
                                    'hasil_asesmen',
                                    $kesehatanLanjutan?->hasil_asesmen
                                ) == 'proses'
                                    ? 'selected'
                                    : '' }}
                            >
                                Proses
                            </option>

                        </select>

                    </div>



                    {{-- =================================================
                    ASESMEN PSIKOLOGI
                    ================================================== --}}
                    <div class="detail-field">

                        <label for="status_asesmen_psikologi">
                            Asesmen Psikologi
                        </label>

                        <select
                            id="status_asesmen_psikologi"
                            name="status_asesmen_psikologi"
                        >

                            <option value="">
                                Pilih Status
                            </option>

                            <option
                                value="sudah"
                                {{ old(
                                    'status_asesmen_psikologi',
                                    $kesehatanLanjutan?->status_asesmen_psikologi
                                ) == 'sudah'
                                    ? 'selected'
                                    : '' }}
                            >
                                Sudah
                            </option>

                            <option
                                value="belum"
                                {{ old(
                                    'status_asesmen_psikologi',
                                    $kesehatanLanjutan?->status_asesmen_psikologi
                                ) == 'belum'
                                    ? 'selected'
                                    : '' }}
                            >
                                Belum
                            </option>

                            <option
                                value="proses"
                                {{ old(
                                    'status_asesmen_psikologi',
                                    $kesehatanLanjutan?->status_asesmen_psikologi
                                ) == 'proses'
                                    ? 'selected'
                                    : '' }}
                            >
                                Proses
                            </option>

                        </select>

                    </div>



                    {{-- =================================================
                    ASESMEN FISIOTERAPIS
                    ================================================== --}}
                    <div class="detail-field">

                        <label for="status_asesmen_fisioterapis">
                            Asesmen Fisioterapis
                        </label>

                        <select
                            id="status_asesmen_fisioterapis"
                            name="status_asesmen_fisioterapis"
                        >

                            <option value="">
                                Pilih Status
                            </option>

                            <option
                                value="sudah"
                                {{ old(
                                    'status_asesmen_fisioterapis',
                                    $kesehatanLanjutan?->status_asesmen_fisioterapis
                                ) == 'sudah'
                                    ? 'selected'
                                    : '' }}
                            >
                                Sudah
                            </option>

                            <option
                                value="belum"
                                {{ old(
                                    'status_asesmen_fisioterapis',
                                    $kesehatanLanjutan?->status_asesmen_fisioterapis
                                ) == 'belum'
                                    ? 'selected'
                                    : '' }}
                            >
                                Belum
                            </option>

                            <option
                                value="proses"
                                {{ old(
                                    'status_asesmen_fisioterapis',
                                    $kesehatanLanjutan?->status_asesmen_fisioterapis
                                ) == 'proses'
                                    ? 'selected'
                                    : '' }}
                            >
                                Proses
                            </option>

                        </select>

                    </div>

                </div>



                {{-- =================================================
                CATATAN
                ================================================== --}}
                <div class="detail-field assessment-note">

                    <label for="catatan_asesmen">
                        Catatan
                    </label>

                    <textarea
                        id="catatan_asesmen"
                        name="catatan_asesmen"
                        placeholder="Masukkan catatan tambahan (opsional)"
                    >{{ old(
                        'catatan_asesmen',
                        $kesehatanLanjutan?->catatan_asesmen
                    ) }}</textarea>

                </div>

            </div>



            {{-- =================================================
            HASIL AKHIR
            ================================================== --}}
            <div class="detail-section">

                <div class="detail-section-title">
                    Hasil Akhir Kesehatan Lanjutan
                </div>


                <div class="assessment-grid">

                    <div class="detail-field">

                        <label for="hasil_akhir">
                            Hasil Akhir
                        </label>

                        <select
                            id="hasil_akhir"
                            name="hasil_akhir"
                            required
                        >

                            <option value="">
                                Pilih Hasil
                            </option>

                            <option
                                value="lulus"
                                {{ old(
                                    'hasil_akhir',
                                    $kesehatanLanjutan?->hasil_akhir
                                ) == 'lulus'
                                    ? 'selected'
                                    : '' }}
                            >
                                Lulus
                            </option>

                            <option
                                value="tidak_lulus"
                                {{ old(
                                    'hasil_akhir',
                                    $kesehatanLanjutan?->hasil_akhir
                                ) == 'tidak_lulus'
                                    ? 'selected'
                                    : '' }}
                            >
                                Tidak Lulus
                            </option>

                        </select>

                    </div>

                </div>

            </div>



            {{-- =================================================
            ERROR VALIDASI
            ================================================== --}}
            @if ($errors->any())

                <div class="form-error-message">

                    <ul>

                        @foreach ($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif



            {{-- =================================================
            BUTTON SIMPAN
            ================================================== --}}
            <div class="form-action">

                <button
                    type="button"
                    class="btn-save"
                    @click="showSavePopup = true"
                >
                    Simpan
                </button>

            </div>

        </form>



        {{-- =====================================================
        POPUP KONFIRMASI SIMPAN
        ====================================================== --}}
        <template x-if="showSavePopup">

            <div class="save-modal-overlay">

                <div class="save-modal">

                    <div class="save-modal-icon">

                        <span class="material-symbols-outlined">
                            save
                        </span>

                    </div>


                    <h3 class="save-modal-title">
                        Simpan Data?
                    </h3>


                    <p class="save-modal-message">
                        Pastikan data Asesmen Kesehatan Lanjutan
                        sudah sesuai sebelum disimpan.
                    </p>


                    <div class="save-modal-actions">

                        {{-- BATAL --}}
                        <button
                            type="button"
                            class="save-modal-cancel"
                            @click="showSavePopup = false"
                        >
                            Batal
                        </button>


                        {{-- SIMPAN --}}
                        <button
                            type="button"
                            class="save-modal-button"
                            @click="$refs.assessmentForm.requestSubmit()"
                        >
                            Simpan
                        </button>

                    </div>

                </div>

            </div>

        </template>



        {{-- =====================================================
        POPUP BERHASIL
        ====================================================== --}}
        @if (session('success'))

            <div class="save-modal-overlay">

                <div class="save-modal">

                    <div class="save-modal-icon">

                        <span class="material-symbols-outlined">
                            check_circle
                        </span>

                    </div>


                    <h3 class="save-modal-title">
                        Berhasil
                    </h3>


                    <p class="save-modal-message">
                        {{ session('success') }}
                    </p>


                    <button
                        type="button"
                        class="save-modal-button"
                        @click="window.location.href = '{{ route(
                            'ppks.normal.kesehatan-lanjutan.detail',
                            $ppks
                        ) }}'"
                    >
                        OK
                    </button>

                </div>

            </div>

        @endif

    </div>

</x-app-layout>