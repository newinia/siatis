<x-app-layout>
@php

    /*
    |--------------------------------------------------------------------------
    | ROLE USER
    |--------------------------------------------------------------------------
    */

    $userRole = strtolower(trim((string) (auth()->user()->role ?? '')));

    $isSuperAdmin = $userRole === 'super_admin';
    $isInstruktur = $userRole === 'instruktur';

    $canEdit = $isSuperAdmin || $isInstruktur;


    /*
    |--------------------------------------------------------------------------
    | DATA PPKS
    |--------------------------------------------------------------------------
    */

    $data = $ppks->data ?? [];

    if (!is_array($data)) {
        $data = [];
    }


    /*
    |--------------------------------------------------------------------------
    | IDENTITAS
    |--------------------------------------------------------------------------
    */

    $nama = $data['nama_lengkap']
        ?? $data['nama']
        ?? '-';

    $nik = $data['nik']
        ?? '-';

    $jenisKelamin = $data['jenis_kelamin']
        ?? $data['jenis_kelamin_ppks']
        ?? '-';

    $tempatLahir = $data['tempat_lahir']
        ?? '-';

    $tanggalLahir = $data['tanggal_lahir']
        ?? null;

    $tanggalLahirFormatted = '-';
    $usia = '-';

    if (!empty($tanggalLahir)) {

        try {

            $tanggalLahirCarbon =
                \Carbon\Carbon::parse($tanggalLahir);

            $tanggalLahirFormatted =
                $tanggalLahirCarbon->translatedFormat('d F Y');

            $usia =
                $tanggalLahirCarbon->age . ' Tahun';

        } catch (\Throwable $e) {

            $tanggalLahirFormatted =
                $tanggalLahir;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | JENIS PPKS
    |--------------------------------------------------------------------------
    */

    $jenisPpks =
        $data['jenis_ppks']
        ?? '-';


    /*
    |--------------------------------------------------------------------------
    | JURUSAN YANG DIMINATI
    |--------------------------------------------------------------------------
    */

    $jurusanDiminati =
        $data['jurusan_yang_diminati']
        ?? $data['jurusan']
        ?? $data['jurusan_pelatihan']
        ?? $data['program_keahlian']
        ?? '-';


    /*
    |--------------------------------------------------------------------------
    | FOTO PPKS
    |--------------------------------------------------------------------------
    */

    $foto = $data['upload_foto_full_badan'] ?? null;

    $fotoUrl = null;

    if (!empty($foto)) {

        if (($data['sumber_data'] ?? null) === 'manual') {

            $fotoUrl = asset(
                'storage/' . ltrim($foto, '/')
            );

        } else {

            if (
                preg_match(
                    '/[?&]id=([^&]+)/',
                    $foto,
                    $matches
                )
            ) {

                $fileId = $matches[1];

                $fotoUrl = route(
                    'ppks.file',
                    [
                        'fileId' => $fileId
                    ]
                );

            } else {

                $fotoUrl = $foto;
            }
        }
    }


    /*
    |--------------------------------------------------------------------------
    | PROSES INSTRUKTUR
    |--------------------------------------------------------------------------
    */

    $prosesInstruktur =
        $ppks->prosesPesertas
            ->where('tahap', 'instruktur')
            ->sortByDesc(function ($item) {

                return $item->tanggal_proses
                    ?? $item->created_at;

            })
            ->first();

    $catatanInstruktur =
        $prosesInstruktur?->catatan
        ?? '-';


    /*
    |--------------------------------------------------------------------------
    | PROSES KESEHATAN AWAL
    |--------------------------------------------------------------------------
    */

    $prosesKesehatan =
        $ppks->prosesPesertas
            ->where('tahap', 'kesehatan_awal')
            ->sortByDesc(function ($item) {

                return $item->tanggal_proses
                    ?? $item->created_at;

            })
            ->first();

    $catatanKesehatan =
        $prosesKesehatan?->catatan
        ?? '-';


    /*
    |--------------------------------------------------------------------------
    | PROSES CASE CONFERENCE
    |--------------------------------------------------------------------------
    */

    $prosesCaseConference =
        $ppks->prosesPesertas
            ->where('tahap', 'case_conference')
            ->sortByDesc(function ($item) {

                return $item->tanggal_proses
                    ?? $item->created_at;

            })
            ->first();


    /*
    |--------------------------------------------------------------------------
    | HASIL CASE CONFERENCE
    |--------------------------------------------------------------------------
    */

    $hasilCaseConference = match (
        $prosesCaseConference?->status
    ) {

        'lulus' =>
            'diterima',

        'tidak_lulus' =>
            'tidak_diterima',

        'pending' =>
            'pending',

        default =>
            '',
    };


    /*
    |--------------------------------------------------------------------------
    | HASIL CASE CONFERENCE SUDAH TERSIMPAN
    |--------------------------------------------------------------------------
    */

    $hasSavedCaseConferenceResult =
        !empty($hasilCaseConference);


    /*
    |--------------------------------------------------------------------------
    | CATATAN CASE CONFERENCE
    |--------------------------------------------------------------------------
    */

    $catatanCaseConference =
        $prosesCaseConference?->catatan
        ?? '';


    /*
    |--------------------------------------------------------------------------
    | TANGGAL CASE CONFERENCE
    |--------------------------------------------------------------------------
    */

    $tanggalCaseConference =
        $data['tanggal_case_conference']
        ?? '';

    if (
        empty($tanggalCaseConference)
        &&
        $prosesCaseConference?->tanggal_proses
    ) {

        try {

            $tanggalCaseConference =
                \Carbon\Carbon::parse(
                    $prosesCaseConference->tanggal_proses
                )->format('Y-m-d');

        } catch (\Throwable $e) {

            $tanggalCaseConference = '';
        }
    }


    /*
    |--------------------------------------------------------------------------
    | JURUSAN DITERIMA
    |--------------------------------------------------------------------------
    */

    $jurusanDiterima =
        $data['jurusan_diterima']
        ?? '';


    /*
    |--------------------------------------------------------------------------
    | GELOMBANG
    |--------------------------------------------------------------------------
    */

    $gelombangPelatihan =
        $data['gelombang_pelatihan']
        ?? $data['gelombang']
        ?? '';


    /*
    |--------------------------------------------------------------------------
    | TAHUN PELATIHAN
    |--------------------------------------------------------------------------
    */

    $tahunPelatihan =
        $data['tahun_pelatihan']
        ?? $data['tahun']
        ?? '';


    /*
    |--------------------------------------------------------------------------
    | STATUS PEMANGGILAN PESERTA
    |--------------------------------------------------------------------------
    |
    | Status yang digunakan:
    |
    | belum_dipanggil
    | sudah_dipanggil
    | belum_datang
    | sudah_datang
    |
    */

    $statusPemanggilan =
        strtolower(
            trim(
                (string) (
                    $data['status_pemanggilan']
                    ?? 'belum_dipanggil'
                )
            )
        );


    /*
    |--------------------------------------------------------------------------
    | NILAI FORM
    |--------------------------------------------------------------------------
    */

    $formHasilCaseConference =
        old(
            'hasil_case_conference',
            $hasilCaseConference
        );

    $formJurusanDiterima =
        old(
            'jurusan_diterima',
            $jurusanDiterima
        );

    $formTanggalCaseConference =
        old(
            'tanggal_case_conference',
            $tanggalCaseConference
        );

    $formGelombangPelatihan =
        old(
            'gelombang_pelatihan',
            $gelombangPelatihan
        );

    $formTahunPelatihan =
        old(
            'tahun_pelatihan',
            $tahunPelatihan
        );

    $formCatatanCaseConference =
        old(
            'catatan_case_conference',
            $catatanCaseConference
        );


    /*
    |--------------------------------------------------------------------------
    | TANGGAL DATA MASUK
    |--------------------------------------------------------------------------
    */

    $tanggalMasuk =
        $ppks->imported_at
        ?? null;

    $tanggalMasukFormatted = '-';

    if ($tanggalMasuk) {

        try {

            $tanggalMasukFormatted =
                \Carbon\Carbon::parse(
                    $tanggalMasuk
                )->format('d-m-Y');

        } catch (\Throwable $e) {

            $tanggalMasukFormatted = '-';
        }
    }

@endphp


{{-- =====================================================
PROGRESS PESERTA
====================================================== --}}

<x-participant-progress
    :active-step="4"
    :stage-statuses="[
        1 => 'completed',
        2 => 'completed',
        3 => 'completed',
        4 => 'current',
        5 => 'waiting',
    ]"
    final-status="waiting"
/>


<div
    class="participant-detail-page"
    x-data="{
        showSavePopup: false,
        submitting: false,

        originalData: {
            hasil_case_conference: @js($hasilCaseConference),
            jurusan_diterima: @js($jurusanDiterima),
            tanggal_case_conference: @js($tanggalCaseConference),
            gelombang_pelatihan: @js($gelombangPelatihan),
            tahun_pelatihan: @js($tahunPelatihan),
            catatan_case_conference: @js($catatanCaseConference)
        },

        hasChanges: {{ $prosesCaseConference ? 'false' : 'true' }},

        normalize(value) {
            return String(value ?? '').trim();
        },

        checkChanges() {

            const currentData = {

                hasil_case_conference:
                    document.getElementById(
                        'hasil_case_conference'
                    )?.value ?? '',

                jurusan_diterima:
                    document.getElementById(
                        'jurusan_diterima'
                    )?.value ?? '',

                tanggal_case_conference:
                    document.getElementById(
                        'tanggal_case_conference'
                    )?.value ?? '',

                gelombang_pelatihan:
                    document.getElementById(
                        'gelombang_pelatihan'
                    )?.value ?? '',

                tahun_pelatihan:
                    document.getElementById(
                        'tahun_pelatihan'
                    )?.value ?? '',

                catatan_case_conference:
                    document.getElementById(
                        'catatan_case_conference'
                    )?.value ?? ''
            };

            this.hasChanges =
                Object.keys(this.originalData).some((key) => {

                    return this.normalize(
                        currentData[key]
                    ) !== this.normalize(
                        this.originalData[key]
                    );

                });
        }
    }"
>


    {{-- =====================================================
    CONTAINER
    ====================================================== --}}

    <div class="participant-detail-container">


        {{-- =================================================
        FORM UTAMA
        ================================================== --}}

        <form
            class="participant-detail-card"
            method="POST"
            action="{{ route(
                'ppks.normal.case-conference.update',
                ['ppks' => $ppks->id]
            ) }}"
            id="caseConferenceForm"
        >

            @csrf


            {{-- =================================================
            KEMBALI
            ================================================== --}}

            <a
                href="{{ route(
                    'ppks.normal.asesmen-kesehatan.awal',
                    ['ppks' => $ppks->id]
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

                            @if (!empty($fotoUrl))

                                <img
                                    src="{{ $fotoUrl }}"
                                    alt="Foto {{ $nama }}"
                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                >

                                <div
                                    class="photo-placeholder"
                                    style="display:none;"
                                >

                                    <span class="material-symbols-outlined">
                                        person
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
                                Data masuk:
                            </span>

                            <strong>
                                {{ $tanggalMasukFormatted }}
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


                        {{-- USIA --}}

                        <div class="detail-field">

                            <label>
                                Usia
                            </label>

                            <input
                                type="text"
                                value="{{ $usia }}"
                                readonly
                            >

                        </div>


                        {{-- JENIS KELAMIN --}}

                        <div class="detail-field">

                            <label>
                                Jenis Kelamin
                            </label>

                            <input
                                type="text"
                                value="{{ $jenisKelamin }}"
                                readonly
                            >

                        </div>


                        {{-- TANGGAL LAHIR --}}

                        <div class="detail-field">

                            <label>
                                Tanggal Lahir
                            </label>

                            <input
                                type="text"
                                value="{{ $tanggalLahirFormatted }}"
                                readonly
                            >

                        </div>


                        {{-- TEMPAT LAHIR --}}

                        <div class="detail-field">

                            <label>
                                Tempat Lahir
                            </label>

                            <input
                                type="text"
                                value="{{ $tempatLahir }}"
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


                        {{-- JURUSAN DIMINATI --}}

                        <div class="detail-field">

                            <label>
                                Jurusan yang Diminati
                            </label>

                            <input
                                type="text"
                                value="{{ $jurusanDiminati }}"
                                readonly
                            >

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

                    <textarea
                        id="catatan_instruktur"
                        name="catatan_instruktur"
                        readonly
                    >{{ $catatanInstruktur }}</textarea>

                </div>

            </div>


            {{-- =================================================
            CATATAN KESEHATAN AWAL
            ================================================== --}}

            <div class="detail-section">

                <div class="detail-field">

                    <label for="catatan_kesehatan">
                        Catatan Kesehatan Awal
                    </label>

                    <textarea
                        id="catatan_kesehatan"
                        name="catatan_kesehatan"
                        readonly
                    >{{ $catatanKesehatan }}</textarea>

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
                            <span class="required">*</span>
                        </label>

                        <select
                            id="hasil_case_conference"
                            name="hasil_case_conference"
                            class="@error('hasil_case_conference') form-input-error @enderror"
                            required
                            {{ $canEdit ? '' : 'disabled' }}
                            onchange="clearFieldValidationError(this)"
                        >

                            <option value="">
                                Pilih hasil Case Conference
                            </option>

                            <option
                                value="diterima"
                                @selected($formHasilCaseConference === 'diterima')
                            >
                                Diterima
                            </option>

                            <option
                                value="tidak_diterima"
                                @selected($formHasilCaseConference === 'tidak_diterima')
                            >
                                Tidak Diterima
                            </option>

                            <option
                                value="pending"
                                @selected($formHasilCaseConference === 'pending')
                            >
                                Pending
                            </option>

                        </select>

                        @error('hasil_case_conference')

                            <div class="form-error">
                                <span>{{ $message }}</span>
                            </div>

                        @enderror

                    </div>


                    {{-- JURUSAN PELATIHAN --}}

                    <div class="detail-field">

                        <label for="jurusan_diterima">
                            Jurusan Pelatihan
                            <span class="required">*</span>
                        </label>

                        <select
                            id="jurusan_diterima"
                            name="jurusan_diterima"
                            class="@error('jurusan_diterima') form-input-error @enderror"
                            required
                            {{ $canEdit ? '' : 'disabled' }}
                            onchange="clearFieldValidationError(this)"
                        >

                            <option value="">
                                Pilih jurusan
                            </option>

                            <option value="Komputer" @selected($formJurusanDiterima === 'Komputer')>
                                Komputer
                            </option>

                            <option value="Desain Grafis" @selected($formJurusanDiterima === 'Desain Grafis')>
                                Desain Grafis
                            </option>

                            <option value="Penjahitan" @selected($formJurusanDiterima === 'Penjahitan')>
                                Penjahitan
                            </option>

                            <option value="Elektro" @selected($formJurusanDiterima === 'Elektro')>
                                Elektro
                            </option>

                            <option value="Las" @selected($formJurusanDiterima === 'Las')>
                                Las
                            </option>

                            <option value="Contact Center" @selected($formJurusanDiterima === 'Contact Center')>
                                Contact Center
                            </option>

                            <option value="Otomotif" @selected($formJurusanDiterima === 'Otomotif')>
                                Otomotif
                            </option>

                        </select>

                        @error('jurusan_diterima')

                            <div class="form-error">
                                <span>{{ $message }}</span>
                            </div>

                        @enderror

                    </div>


                    {{-- TANGGAL CASE CONFERENCE --}}

                    <div class="detail-field">

                        <label for="tanggal_case_conference">
                            Tanggal Case Conference
                            <span class="required">*</span>
                        </label>

                        <input
                            type="date"
                            id="tanggal_case_conference"
                            name="tanggal_case_conference"
                            value="{{ $formTanggalCaseConference }}"
                            class="@error('tanggal_case_conference') form-input-error @enderror"
                            required
                            {{ $canEdit ? '' : 'disabled' }}
                            onchange="clearFieldValidationError(this)"
                        >

                        @error('tanggal_case_conference')

                            <div class="form-error">
                                <span>{{ $message }}</span>
                            </div>

                        @enderror

                    </div>


                    {{-- GELOMBANG & TAHUN --}}

                    <div class="detail-field">

                        <label>
                            Gelombang dan Tahun Pelatihan
                            <span class="required">*</span>
                        </label>


                        <div class="wave-year-group">

                            <select
                                id="gelombang_pelatihan"
                                name="gelombang_pelatihan"
                                class="@error('gelombang_pelatihan') form-input-error @enderror"
                                required
                                {{ $canEdit ? '' : 'disabled' }}
                                onchange="clearFieldValidationError(this)"
                            >

                                <option value="">
                                    Pilih gelombang
                                </option>

                                @for ($i = 1; $i <= 4; $i++)

                                    <option
                                        value="{{ $i }}"
                                        @selected((string) $formGelombangPelatihan === (string) $i)
                                    >
                                        Gelombang {{ $i }}
                                    </option>

                                @endfor

                            </select>


                            @error('gelombang_pelatihan')

                                <div class="form-error">
                                    <span>{{ $message }}</span>
                                </div>

                            @enderror


                            <select
                                id="tahun_pelatihan"
                                name="tahun_pelatihan"
                                class="@error('tahun_pelatihan') form-input-error @enderror"
                                required
                                {{ $canEdit ? '' : 'disabled' }}
                                onchange="clearFieldValidationError(this)"
                            >

                                <option value="">
                                    Pilih tahun
                                </option>

                                @for (
                                    $tahun = now()->year - 5;
                                    $tahun <= now()->year + 1;
                                    $tahun++
                                )

                                    <option
                                        value="{{ $tahun }}"
                                        @selected((string) $formTahunPelatihan === (string) $tahun)
                                    >
                                        {{ $tahun }}
                                    </option>

                                @endfor

                            </select>


                            @error('tahun_pelatihan')

                                <div class="form-error">
                                    <span>{{ $message }}</span>
                                </div>

                            @enderror

                        </div>


                        <div
                            id="waveYearValidationError"
                            class="wave-year-validation-error"
                        ></div>

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

                    <textarea
                        id="catatan_case_conference"
                        name="catatan_case_conference"
                        placeholder="Tambahkan catatan jika diperlukan"
                        {{ $canEdit ? '' : 'disabled' }}
                    >{{ $formCatatanCaseConference }}</textarea>

                </div>

            </div>


            {{-- =================================================
            BUTTON
            ================================================== --}}

            <div class="form-action detail-actions">


                {{-- SIMPAN --}}

                <button
                    type="button"
                    class="btn-save"
                    id="submitButton"
                    onclick="validateAndShowSavePopup()"
                    @disabled(!$canEdit)
                    x-bind:disabled="
                        submitting ||
                        !hasChanges ||
                        {{ $canEdit ? 'false' : 'true' }}
                    "
                >
                    Simpan
                </button>


                {{-- SELANJUTNYA --}}

                <button
                    type="button"
                    class="btn-next btn-success"
                    onclick="handleKesehatanLanjutanNext(event)"
                >
                    Selanjutnya
                </button>

            </div>

        </form>

    </div>


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
                    Menyimpan Data
                </h3>

                <p class="global-popup-message">
                    Pastikan data sudah sesuai
                </p>

                <div class="global-popup-actions">

                    <button
                        type="button"
                        class="global-popup-btn cancel"
                        @click="showSavePopup = false"
                    >
                        Batal
                    </button>

                    <button
                        type="button"
                        class="global-popup-btn primary"
                        @click="
                            submitting = true;
                            showSavePopup = false;
                            document
                                .getElementById('caseConferenceForm')
                                .requestSubmit();
                        "
                    >
                        Simpan
                    </button>

                </div>

            </div>

        </div>

    </template>


    {{-- =====================================================
    POPUP SUCCESS
    ====================================================== --}}

    @if (session('success'))

        <div
            class="global-popup success show"
            x-data
            x-init="
                setTimeout(() => {
                    $el.remove();
                }, 2500);
            "
            aria-hidden="false"
        >

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

            </div>

        </div>

    @endif


    {{-- =====================================================
    POPUP ERROR LARAVEL
    ====================================================== --}}

    @if ($errors->any())

        <div
            class="global-popup error show"
            x-data="{ show: true }"
            x-show="show"
            x-transition
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

                <p class="global-popup-message">
                    Silakan lengkapi data yang masih kosong atau perbaiki
                    data yang ditandai.
                </p>

                <ul class="global-popup-error-list">

                    @foreach ($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

                <div class="global-popup-actions">

                    <button
                        type="button"
                        class="global-popup-btn danger"
                        @click="show = false"
                    >
                        Mengerti
                    </button>

                </div>

            </div>

        </div>

    @endif

</div>


{{-- =====================================================
JAVASCRIPT
====================================================== --}}

<script>

    /*
    |--------------------------------------------------------------------------
    | CEK PERUBAHAN FIELD
    |--------------------------------------------------------------------------
    */

    function triggerCaseConferenceChangeCheck() {

        const page =
            document.querySelector(
                '.participant-detail-page'
            );

        if (
            page &&
            page._x_dataStack &&
            page._x_dataStack[0]
        ) {

            page._x_dataStack[0].checkChanges();

        }
    }


    /*
    |--------------------------------------------------------------------------
    | HAPUS ERROR FIELD
    |--------------------------------------------------------------------------
    */

    function clearFieldValidationError(field) {

        if (!field) {
            return;
        }

        if (
            field.value &&
            field.value.trim()
        ) {

            field.classList.remove(
                'js-validation-error'
            );

            field.classList.remove(
                'has-error'
            );

            field.classList.remove(
                'form-input-error'
            );


            const parent =
                field.parentNode;

            if (parent) {

                const error =
                    parent.querySelector(
                        '.js-form-error'
                    );

                if (error) {
                    error.remove();
                }
            }


            if (
                field.id === 'gelombang_pelatihan' ||
                field.id === 'tahun_pelatihan'
            ) {

                const waveYearError =
                    document.getElementById(
                        'waveYearValidationError'
                    );

                if (waveYearError) {
                    waveYearError.innerHTML = '';
                }
            }
        }


        triggerCaseConferenceChangeCheck();
    }


    /*
    |--------------------------------------------------------------------------
    | DOM READY
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'DOMContentLoaded',
        function () {

            const form =
                document.getElementById(
                    'caseConferenceForm'
                );

            if (!form) {
                return;
            }


            const validationFields = [

                'hasil_case_conference',
                'jurusan_diterima',
                'tanggal_case_conference',
                'gelombang_pelatihan',
                'tahun_pelatihan'

            ];


            validationFields.forEach(
                function (id) {

                    const field =
                        document.getElementById(id);

                    if (!field) {
                        return;
                    }


                    field.addEventListener(
                        'change',
                        function () {

                            clearFieldValidationError(
                                field
                            );

                            triggerCaseConferenceChangeCheck();

                        }
                    );


                    field.addEventListener(
                        'input',
                        function () {

                            clearFieldValidationError(
                                field
                            );

                            triggerCaseConferenceChangeCheck();

                        }
                    );

                }
            );


            const catatan =
                document.getElementById(
                    'catatan_case_conference'
                );

            if (catatan) {

                catatan.addEventListener(
                    'input',
                    function () {

                        triggerCaseConferenceChangeCheck();

                    }
                );

            }


            /*
            |--------------------------------------------------------------------------
            | PREVENT DOUBLE SUBMIT
            |--------------------------------------------------------------------------
            */

            form.addEventListener(
                'submit',
                function () {

                    const submitButton =
                        document.getElementById(
                            'submitButton'
                        );

                    if (submitButton) {

                        submitButton.disabled = true;

                        submitButton.textContent =
                            'Menyimpan...';

                    }

                }
            );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | VALIDASI SIMPAN
    |--------------------------------------------------------------------------
    */

    function validateAndShowSavePopup() {

        const form =
            document.getElementById(
                'caseConferenceForm'
            );

        if (!form) {
            return;
        }


        const canEdit =
            @json($canEdit);

        if (!canEdit) {
            return;
        }


        const page =
            document.querySelector(
                '.participant-detail-page'
            );


        if (
            page &&
            page._x_dataStack &&
            page._x_dataStack[0]
        ) {

            const alpineData =
                page._x_dataStack[0];

            alpineData.checkChanges();

            if (!alpineData.hasChanges) {
                return;
            }

        }


        /*
        |--------------------------------------------------------------------------
        | FIELD WAJIB
        |--------------------------------------------------------------------------
        */

        const requiredFields = [

            {
                id: 'hasil_case_conference',
                message:
                    'Hasil Case Conference wajib diisi.'
            },

            {
                id: 'jurusan_diterima',
                message:
                    'Jurusan pelatihan wajib diisi.'
            },

            {
                id: 'tanggal_case_conference',
                message:
                    'Tanggal Case Conference wajib diisi.'
            },

            {
                id: 'gelombang_pelatihan',
                message:
                    'Gelombang pelatihan wajib diisi.'
            },

            {
                id: 'tahun_pelatihan',
                message:
                    'Tahun pelatihan wajib diisi.'
            }

        ];


        let hasError = false;
        let firstErrorField = null;
        let errorMessages = [];


        form
            .querySelectorAll(
                '.js-form-error'
            )
            .forEach(
                function (error) {
                    error.remove();
                }
            );


        form
            .querySelectorAll(
                '.js-validation-error'
            )
            .forEach(
                function (field) {

                    field.classList.remove(
                        'has-error'
                    );

                    field.classList.remove(
                        'js-validation-error'
                    );

                }
            );


        const waveYearValidationError =
            document.getElementById(
                'waveYearValidationError'
            );

        if (waveYearValidationError) {

            waveYearValidationError.innerHTML =
                '';

        }


        requiredFields.forEach(
            function (item) {

                const field =
                    document.getElementById(
                        item.id
                    );

                if (
                    !field ||
                    field.disabled
                ) {
                    return;
                }


                const value =
                    field.value
                        ? field.value.trim()
                        : '';


                if (!value) {

                    hasError = true;


                    field.classList.add(
                        'has-error',
                        'js-validation-error'
                    );


                    const error =
                        document.createElement(
                            'div'
                        );

                    error.className =
                        'form-error js-form-error';

                    error.innerHTML = `

                        <span>
                            ${item.message}
                        </span>

                    `;


                    if (
                        item.id ===
                        'gelombang_pelatihan' ||
                        item.id ===
                        'tahun_pelatihan'
                    ) {

                        if (
                            waveYearValidationError &&
                            !waveYearValidationError
                                .querySelector(
                                    '.js-form-error'
                                )
                        ) {

                            waveYearValidationError
                                .appendChild(
                                    error
                                );

                        }

                    } else {

                        field.parentNode.appendChild(
                            error
                        );

                    }


                    if (!firstErrorField) {

                        firstErrorField =
                            field;

                    }


                    errorMessages.push(
                        item.message
                    );

                }

            }
        );


        if (hasError) {

            showErrorModal(
                errorMessages
            );


            if (firstErrorField) {

                firstErrorField.scrollIntoView({

                    behavior: 'smooth',

                    block: 'center'

                });


                setTimeout(
                    function () {

                        firstErrorField.focus();

                    },
                    300
                );

            }

            return;
        }


        if (
            page &&
            page._x_dataStack &&
            page._x_dataStack[0]
        ) {

            page._x_dataStack[0].showSavePopup =
                true;

        }

    }


    /*
    |--------------------------------------------------------------------------
    | SELANJUTNYA KE KESEHATAN LANJUTAN
    |--------------------------------------------------------------------------
    |
    | URUTAN PENGECEKAN:
    |
    | 1. Case Conference harus sudah tersimpan.
    | | 2. Peserta harus sudah datang.
    | | 3. Baru redirect ke Kesehatan Lanjutan.
    |
    */

    function handleKesehatanLanjutanNext(event) {

        if (event) {
            event.preventDefault();
        }


        /*
        |--------------------------------------------------------------------------
        | CEK CASE CONFERENCE
        |--------------------------------------------------------------------------
        */

        const hasSavedResult =
            @json($hasSavedCaseConferenceResult);


        if (!hasSavedResult) {

            showNextValidationModal(
                'Data Case Conference Belum Tersimpan',
                'Silakan isi dan simpan hasil Case Conference terlebih dahulu.'
            );

            return false;
        }


        /*
        |--------------------------------------------------------------------------
        | CEK STATUS PEMANGGILAN
        |--------------------------------------------------------------------------
        */

        const statusPemanggilan =
            @json($statusPemanggilan);


        /*
        |--------------------------------------------------------------------------
        | SUDAH DATANG
        |--------------------------------------------------------------------------
        */

        if (
            statusPemanggilan ===
            'sudah_datang'
        ) {

            window.location.href =
                @json(
                    route(
                        'ppks.normal.kesehatan-lanjutan.detail',
                        ['ppks' => $ppks->id]
                    )
                );

            return true;
        }


        /*
        |--------------------------------------------------------------------------
        | BELUM DATANG
        |--------------------------------------------------------------------------
        */

        if (
            statusPemanggilan ===
            'belum_datang'
        ) {

            showNextValidationModal(
                'Peserta Belum Datang',
                'Peserta belum datang. Silakan pastikan peserta sudah hadir terlebih dahulu.'
            );

            return false;
        }


        /*
        |--------------------------------------------------------------------------
        | BELUM DIPANGGIL
        |--------------------------------------------------------------------------
        */

        showNextValidationModal(
            'Peserta Belum Dipanggil',
            'Peserta belum dipanggil. Silakan lakukan pemanggilan peserta terlebih dahulu.'
        );

        return false;
    }


    /*
    |--------------------------------------------------------------------------
    | POPUP SELANJUTNYA
    |--------------------------------------------------------------------------
    */

    function showNextValidationModal(
        title,
        message
    ) {

        let modal =
            document.getElementById(
                'caseConferenceNextModal'
            );


        if (!modal) {

            modal =
                document.createElement(
                    'div'
                );

            modal.id =
                'caseConferenceNextModal';

            modal.className =
                'global-popup error show';

            modal.setAttribute(
                'aria-hidden',
                'false'
            );


            modal.innerHTML = `

                <div class="global-popup-box">

                    <div class="global-popup-icon">

                        <span class="material-symbols-outlined">
                            error
                        </span>

                    </div>

                    <h3
                        class="global-popup-title"
                        id="caseConferenceNextModalTitle"
                    ></h3>

                    <p
                        class="global-popup-message"
                        id="caseConferenceNextModalMessage"
                    ></p>

                    <div class="global-popup-actions">

                        <button
                            type="button"
                            class="global-popup-btn primary"
                            onclick="closeNextValidationModal()"
                        >
                            Mengerti
                        </button>

                    </div>

                </div>

            `;

            document.body.appendChild(
                modal
            );

        }


        const titleElement =
            document.getElementById(
                'caseConferenceNextModalTitle'
            );

        const messageElement =
            document.getElementById(
                'caseConferenceNextModalMessage'
            );


        if (titleElement) {

            titleElement.textContent =
                title;

        }


        if (messageElement) {

            messageElement.textContent =
                message;

        }


        modal.classList.add(
            'show'
        );

        modal.setAttribute(
            'aria-hidden',
            'false'
        );

    }


    /*
    |--------------------------------------------------------------------------
    | TUTUP POPUP SELANJUTNYA
    |--------------------------------------------------------------------------
    */

    function closeNextValidationModal() {

        const modal =
            document.getElementById(
                'caseConferenceNextModal'
            );


        if (modal) {

            modal.classList.remove(
                'show'
            );

            modal.setAttribute(
                'aria-hidden',
                'true'
            );

        }

    }


    /*
    |--------------------------------------------------------------------------
    | TAMPILKAN ERROR POPUP SIMPAN
    |--------------------------------------------------------------------------
    */

    function showErrorModal(messages) {

        let modal =
            document.getElementById(
                'caseConferenceErrorModal'
            );


        if (!modal) {

            modal =
                document.createElement(
                    'div'
                );

            modal.id =
                'caseConferenceErrorModal';

            modal.className =
                'global-popup error show';

            modal.setAttribute(
                'aria-hidden',
                'false'
            );


            modal.innerHTML = `

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

                        <div>
                            Silakan periksa kembali data Case Conference yang wajib diisi.
                        </div>

                        <ul
                            class="global-popup-error-list"
                            id="caseConferenceErrorList"
                        >
                        </ul>

                    </div>

                    <div class="global-popup-actions">

                        <button
                            type="button"
                            class="global-popup-btn primary"
                            onclick="closeCaseConferenceErrorModal()"
                        >
                            OK
                        </button>

                    </div>

                </div>

            `;

            document.body.appendChild(
                modal
            );

        }


        const errorList =
            document.getElementById(
                'caseConferenceErrorList'
            );


        if (errorList) {

            errorList.innerHTML =
                '';

            messages.forEach(
                function (message) {

                    const li =
                        document.createElement(
                            'li'
                        );

                    li.textContent =
                        message;

                    errorList.appendChild(
                        li
                    );

                }
            );

        }


        modal.classList.add(
            'show'
        );

        modal.setAttribute(
            'aria-hidden',
            'false'
        );

    }


    /*
    |--------------------------------------------------------------------------
    | TUTUP ERROR POPUP SIMPAN
    |--------------------------------------------------------------------------
    */

    function closeCaseConferenceErrorModal() {

        const modal =
            document.getElementById(
                'caseConferenceErrorModal'
            );


        if (modal) {

            modal.classList.remove(
                'show'
            );

            modal.setAttribute(
                'aria-hidden',
                'true'
            );

        }

    }


    /*
    |--------------------------------------------------------------------------
    | CLICK AREA LUAR POPUP
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'click',
        function (event) {

            const errorModal =
                document.getElementById(
                    'caseConferenceErrorModal'
                );


            if (
                errorModal &&
                event.target === errorModal
            ) {

                closeCaseConferenceErrorModal();

            }


            const nextModal =
                document.getElementById(
                    'caseConferenceNextModal'
                );


            if (
                nextModal &&
                event.target === nextModal
            ) {

                closeNextValidationModal();

            }

        }
    );

</script>

</x-app-layout>
