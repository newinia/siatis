<x-app-layout>

    @php

        /*
        |--------------------------------------------------------------------------
        | ROLE USER
        |--------------------------------------------------------------------------
        */

        $userRole = strtolower(
            trim((string) (auth()->user()->role ?? ''))
        );

        $isSuperAdmin = $userRole === 'super_admin';
        $isMedis = $userRole === 'medis';
        $isInstruktur = $userRole === 'instruktur';

        $canEdit = $isMedis || $isSuperAdmin;
        $isViewOnly = $isInstruktur;


        /*
        |--------------------------------------------------------------------------
        | DATA PPKS
        |--------------------------------------------------------------------------
        */

        $data = is_array($ppks->data)
            ? $ppks->data
            : [];


        /*
        |--------------------------------------------------------------------------
        | IDENTITAS PESERTA
        |--------------------------------------------------------------------------
        */

        $nama = $data['nama_lengkap']
            ?? $data['nama']
            ?? $data['Nama Lengkap']
            ?? '-';

        $nik = $data['nik']
            ?? $data['NIK']
            ?? '-';

        $umur = $data['usia']
            ?? $data['umur']
            ?? '-';

        $jenisPpks = $data['jenis_ppks']
            ?? $data['jenis PPKS']
            ?? $data['Jenis PPKS']
            ?? '-';


        /*
        |--------------------------------------------------------------------------
        | CASE CONFERENCE
        |--------------------------------------------------------------------------
        */

        $jurusan = $caseConference?->jurusan_diterima
            ?? '-';


        /*
        |--------------------------------------------------------------------------
        | DATA KESEHATAN LANJUTAN
        |--------------------------------------------------------------------------
        */

        $hasilAkhir = $kesehatanLanjutan?->hasil_akhir;

        $kesehatanProgressStatus = match ($hasilAkhir) {
            'lulus' => 'completed',
            'tidak_lulus' => 'failed',
            'pending' => 'pending',
            default => 'current',
        };

        $lulusKesehatanLanjutan = (
            $hasilAkhir === 'lulus'
        );

    @endphp


    <div
        class="participant-detail-page"
        x-data="{
            showSavePopup: false,
            submitting: false
        }"
    >


        {{-- =====================================================
        PROGRESS TAHAPAN
        ====================================================== --}}

        <x-participant-progress
            :active-step="5"
            :stage-statuses="[
                1 => 'completed',
                2 => 'completed',
                3 => 'completed',
                4 => 'completed',
                5 => $kesehatanProgressStatus
            ]"
        />


        {{-- =====================================================
        FORM UTAMA
        ====================================================== --}}

        <form
            x-ref="assessmentForm"
            class="participant-detail-card"
            method="POST"
            action="{{ route(
                'ppks.normal.kesehatan-lanjutan.update',
                $ppks
            ) }}"
            @submit="submitting = true"
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
                            {{ $canEdit ? 'required' : 'disabled' }}
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
                                {{ $canEdit ? '' : 'disabled' }}
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
                                {{ $canEdit ? '' : 'disabled' }}
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
                            {{ $canEdit ? '' : 'disabled' }}
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
                            {{ $canEdit ? '' : 'disabled' }}
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
                            {{ $canEdit ? '' : 'disabled' }}
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
                            {{ $canEdit ? '' : 'disabled' }}
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
                        {{ $canEdit ? '' : 'disabled' }}
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
                            {{ $canEdit ? 'required' : 'disabled' }}
                        >

                            <option value="">
                                Pilih Hasil
                            </option>


                            {{-- LULUS --}}

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


                            {{-- TIDAK LULUS --}}

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


                            {{-- PENDING --}}

                            <option
                                value="pending"
                                {{ old(
                                    'hasil_akhir',
                                    $kesehatanLanjutan?->hasil_akhir
                                ) == 'pending'
                                    ? 'selected'
                                    : '' }}
                            >
                                Pending
                            </option>

                        </select>

                    </div>

                </div>

            </div>


            {{-- =================================================
            ERROR VALIDASI
            ================================================== --}}

            @if ($errors->any())

                <div
                    class="global-popup error show"
                    x-data
                >

                    <div class="global-popup-box">

                        <div class="global-popup-icon">

                            <span class="material-symbols-outlined">
                                error
                            </span>

                        </div>


                        <h3 class="global-popup-title">
                            Data Belum Lengkap
                        </h3>


                        <div class="global-popup-message">

                            <ul class="global-popup-error-list">

                                @foreach ($errors->all() as $error)

                                    <li>
                                        {{ $error }}
                                    </li>

                                @endforeach

                            </ul>

                        </div>

                    </div>

                </div>

            @endif


            {{-- =================================================
            BUTTON SIMPAN
            ================================================== --}}

            @if ($canEdit)

                <div class="form-action">

                    <button
                        type="button"
                        class="btn-save"
                        :disabled="submitting"
                        @click="showSavePopup = true"
                    >

                        <span
                            x-show="!submitting"
                        >
                            Simpan
                        </span>

                        <span
                            x-show="submitting"
                        >
                            Menyimpan...
                        </span>

                    </button>

                </div>

            @endif

        </form>


        {{-- =====================================================
        POPUP KONFIRMASI SIMPAN
        ====================================================== --}}

        <template x-if="showSavePopup">

            <div
                class="global-popup confirm show"
                @click.self="showSavePopup = false"
            >

                <div class="global-popup-box">

                    <div class="global-popup-icon">

                        <span class="material-symbols-outlined">
                            save
                        </span>

                    </div>


                    <h3 class="global-popup-title">
                        Simpan Data?
                    </h3>


                    <p class="global-popup-message">
                        Pastikan data Asesmen Kesehatan Lanjutan
                        sudah sesuai sebelum disimpan.
                    </p>


                    <div
                        class="global-popup-actions "
                        style="margin-top: 20px;"
                    >

                        {{-- BATAL --}}

                        <button
                            type="button"
                            class="global-popup-btn cancel"
                            @click="showSavePopup = false"
                        >
                            Batal
                        </button>


                        {{-- SIMPAN --}}

                        <button
                            type="button"
                            class="global-popup-btn primary"
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

            <div class="global-popup success show">

                <div class="global-popup-box">

                    <div class="global-popup-icon">

                        <span class="material-symbols-outlined">
                            check_circle
                        </span>

                    </div>


                    <h3 class="global-popup-title">
                        Berhasil
                    </h3>


                    <p class="global-popup-message">
                        {{ session('success') }}
                    </p>


                    <button
                        type="button"
                        class="global-popup-btn primary"
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


        {{-- =====================================================
        POPUP ERROR SESSION
        ====================================================== --}}

        @if (session('error'))

            <div class="global-popup error show">

                <div class="global-popup-box">

                    <div class="global-popup-icon">

                        <span class="material-symbols-outlined">
                            error
                        </span>

                    </div>


                    <h3 class="global-popup-title">
                        Tidak Dapat Disimpan
                    </h3>


                    <p class="global-popup-message">
                        {{ session('error') }}
                    </p>


                    <button
                        type="button"
                        class="save-modal-button"
                        style="margin-top: 20px;"
                        @click="window.location.href = '{{ route(
                            'ppks.normal.kesehatan-lanjutan'
                        ) }}'"
                    >
                        OK
                    </button>

                </div>

            </div>

        @endif


    </div>

</x-app-layout>
