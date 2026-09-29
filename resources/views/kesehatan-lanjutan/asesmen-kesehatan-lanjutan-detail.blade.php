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
            showValidationPopup: false,
            submitting: false,
            validationErrors: [],

            canEdit: {{ $canEdit ? 'true' : 'false' }},

            hasChanges: {{ $kesehatanLanjutan ? 'false' : 'true' }},

            originalData: {
                tanggal_asesmen: @js(
                    old(
                        'tanggal_asesmen',
                        $kesehatanLanjutan?->tanggal_asesmen?->format('Y-m-d')
                    )
                ),

                gelombang: @js(
                    old(
                        'gelombang',
                        $kesehatanLanjutan?->gelombang
                    )
                ),

                tahun: @js(
                    old(
                        'tahun',
                        $kesehatanLanjutan?->tahun
                    )
                ),

                petugas_kesehatan: @js(
                    old(
                        'petugas_kesehatan',
                        $kesehatanLanjutan?->petugas_kesehatan
                    )
                ),

                hasil_asesmen: @js(
                    old(
                        'hasil_asesmen',
                        $kesehatanLanjutan?->hasil_asesmen
                    )
                ),

                status_asesmen_psikologi: @js(
                    old(
                        'status_asesmen_psikologi',
                        $kesehatanLanjutan?->status_asesmen_psikologi
                    )
                ),

                status_asesmen_fisioterapis: @js(
                    old(
                        'status_asesmen_fisioterapis',
                        $kesehatanLanjutan?->status_asesmen_fisioterapis
                    )
                ),

                catatan_asesmen: @js(
                    old(
                        'catatan_asesmen',
                        $kesehatanLanjutan?->catatan_asesmen
                    )
                ),

                hasil_akhir: @js(
                    old(
                        'hasil_akhir',
                        $kesehatanLanjutan?->hasil_akhir
                    )
                )
            },


            /*
            |--------------------------------------------------------------------------
            | CEK PERUBAHAN DATA
            |--------------------------------------------------------------------------
            */

            checkChanges() {

                if (!this.canEdit) {
                    this.hasChanges = false;
                    return;
                }

                const currentData = {

                    tanggal_asesmen:
                        document.getElementById('tanggal_asesmen')?.value ?? '',

                    gelombang:
                        document.getElementById('gelombang')?.value ?? '',

                    tahun:
                        document.getElementById('tahun')?.value ?? '',

                    petugas_kesehatan:
                        document.getElementById('petugas_kesehatan')?.value ?? '',

                    hasil_asesmen:
                        document.getElementById('hasil_asesmen')?.value ?? '',

                    status_asesmen_psikologi:
                        document.getElementById('status_asesmen_psikologi')?.value ?? '',

                    status_asesmen_fisioterapis:
                        document.getElementById('status_asesmen_fisioterapis')?.value ?? '',

                    catatan_asesmen:
                        document.getElementById('catatan_asesmen')?.value ?? '',

                    hasil_akhir:
                        document.getElementById('hasil_akhir')?.value ?? ''
                };


                this.hasChanges =
                    currentData.tanggal_asesmen !==
                        String(this.originalData.tanggal_asesmen ?? '') ||

                    currentData.gelombang !==
                        String(this.originalData.gelombang ?? '') ||

                    currentData.tahun !==
                        String(this.originalData.tahun ?? '') ||

                    currentData.petugas_kesehatan !==
                        String(this.originalData.petugas_kesehatan ?? '') ||

                    currentData.hasil_asesmen !==
                        String(this.originalData.hasil_asesmen ?? '') ||

                    currentData.status_asesmen_psikologi !==
                        String(this.originalData.status_asesmen_psikologi ?? '') ||

                    currentData.status_asesmen_fisioterapis !==
                        String(this.originalData.status_asesmen_fisioterapis ?? '') ||

                    currentData.catatan_asesmen !==
                        String(this.originalData.catatan_asesmen ?? '') ||

                    currentData.hasil_akhir !==
                        String(this.originalData.hasil_akhir ?? '');
            },


            /*
            |--------------------------------------------------------------------------
            | HAPUS ERROR VALIDASI
            |--------------------------------------------------------------------------
            */

            clearValidationErrors() {

                this.validationErrors = [];

                document
                    .querySelectorAll('.js-validation-error')
                    .forEach(element => {

                        element.classList.remove(
                            'js-validation-error'
                        );

                        element.classList.remove(
                            'has-error'
                        );

                    });


                document
                    .querySelectorAll('.js-form-error')
                    .forEach(element => {

                        element.remove();

                    });
            },


            /*
            |--------------------------------------------------------------------------
            | VALIDASI SEBELUM POPUP KONFIRMASI
            |--------------------------------------------------------------------------
            */

            validateBeforeSave() {

                /*
                |--------------------------------------------------------------------------
                | PASTIKAN USER BOLEH EDIT
                |--------------------------------------------------------------------------
                */

                if (!this.canEdit) {
                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | CEK APAKAH ADA PERUBAHAN
                |--------------------------------------------------------------------------
                */

                this.checkChanges();


                if (!this.hasChanges) {
                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | RESET ERROR
                |--------------------------------------------------------------------------
                */

                this.clearValidationErrors();


                /*
                |--------------------------------------------------------------------------
                | FIELD WAJIB
                |--------------------------------------------------------------------------
                */

                const requiredFields = [

                    {
                        id: 'tanggal_asesmen',
                        message: 'Tanggal Asesmen wajib diisi.'
                    },

                    {
                        id: 'gelombang',
                        message: 'Gelombang wajib dipilih.'
                    },

                    {
                        id: 'tahun',
                        message: 'Tahun wajib dipilih.'
                    },

                    {
                        id: 'petugas_kesehatan',
                        message: 'Petugas Asesmen Kesehatan wajib dipilih.'
                    },

                    {
                        id: 'hasil_asesmen',
                        message: 'Asesmen Kesehatan wajib dipilih.'
                    },

                    {
                        id: 'status_asesmen_psikologi',
                        message: 'Asesmen Psikologi wajib dipilih.'
                    },

                    {
                        id: 'status_asesmen_fisioterapis',
                        message: 'Asesmen Fisioterapis wajib dipilih.'
                    },

                    {
                        id: 'hasil_akhir',
                        message: 'Hasil Akhir wajib dipilih.'
                    }

                ];


                /*
                |--------------------------------------------------------------------------
                | CEK FIELD WAJIB
                |--------------------------------------------------------------------------
                */

                requiredFields.forEach(field => {

                    const element =
                        document.getElementById(field.id);


                    if (!element) {
                        return;
                    }


                    const value =
                        element.value.trim();


                    if (!value) {

                        this.validationErrors.push(
                            field.message
                        );


                        element.classList.add(
                            'has-error'
                        );


                        element.classList.add(
                            'js-validation-error'
                        );


                        const errorElement =
                            document.createElement('div');


                        errorElement.className =
                            'form-error js-form-error';


                        errorElement.textContent =
                            field.message;


                        element.parentNode.appendChild(
                            errorElement
                        );

                    }

                });


                /*
                |--------------------------------------------------------------------------
                | ERROR GELOMBANG & TAHUN
                |--------------------------------------------------------------------------
                */

                const gelombang =
                    document.getElementById('gelombang');

                const tahun =
                    document.getElementById('tahun');


                if (
                    gelombang &&
                    tahun &&
                    (!gelombang.value || !tahun.value)
                ) {

                    const group =
                        gelombang.closest(
                            '.wave-year-group'
                        );


                    if (group) {

                        group
                            .querySelectorAll('select')
                            .forEach(select => {

                                if (!select.value) {

                                    select.classList.add(
                                        'has-error'
                                    );

                                    select.classList.add(
                                        'js-validation-error'
                                    );

                                }

                            });

                    }

                }


                /*
                |--------------------------------------------------------------------------
                | JIKA ADA ERROR
                |--------------------------------------------------------------------------
                */

                if (
                    this.validationErrors.length > 0
                ) {

                    this.showValidationPopup = true;


                    this.$nextTick(() => {

                        const firstError =
                            document.querySelector(
                                '.js-validation-error'
                            );


                        if (firstError) {

                            firstError.scrollIntoView({
                                behavior: 'smooth',
                                block: 'center'
                            });


                            setTimeout(() => {

                                try {
                                    firstError.focus();
                                } catch (error) {
                                    // abaikan
                                }

                            }, 300);

                        }

                    });


                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | SEMUA LENGKAP
                |--------------------------------------------------------------------------
                |
                | TAMPILKAN POPUP KONFIRMASI
                |--------------------------------------------------------------------------
                */

                this.showSavePopup = true;
            }
        }"

        x-init="
            $nextTick(() => {
                checkChanges();
            });
        "
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
                            @change="checkChanges()"
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
                                @change="checkChanges()"
                            >

                                <option value="">
                                    Pilih Gelombang
                                </option>


                                @for ($gelombang = 1; $gelombang <= 4; $gelombang++)

                                    <option
                                        value="{{ $gelombang }}"
                                        {{ old(
                                            'gelombang',
                                            $kesehatanLanjutan?->gelombang
                                        ) == $gelombang
                                            ? 'selected'
                                            : '' }}
                                    >
                                        Gelombang {{ $gelombang }}
                                    </option>

                                @endfor

                            </select>


                            {{-- TAHUN --}}

                            <select
                                id="tahun"
                                name="tahun"
                                {{ $canEdit ? '' : 'disabled' }}
                                @change="checkChanges()"
                            >

                                <option value="">
                                    Tahun
                                </option>


                                @for (
                                    $tahun = now()->year - 5;
                                    $tahun <= now()->year + 1;
                                    $tahun++
                                )

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
                            @change="checkChanges()"
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
                            @change="checkChanges()"
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
                            @change="checkChanges()"
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
                            @change="checkChanges()"
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
                        @input="checkChanges()"
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
                            @change="checkChanges()"
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
            ERROR VALIDASI DARI LARAVEL
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
                        id="submitButton"
                        @click="validateBeforeSave()"
                        x-bind:disabled="submitting || !canEdit || !hasChanges"
                    >

                        <span x-show="!submitting">
                            Simpan
                        </span>

                        <span x-show="submitting">
                            Menyimpan...
                        </span>

                    </button>

                </div>

            @endif

        </form>


        {{-- =====================================================
        POPUP VALIDASI DATA BELUM LENGKAP
        ====================================================== --}}

        <template x-if="showValidationPopup">

            <div
                class="global-popup error show"
                @click.self="showValidationPopup = false"
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

                            <template
                                x-for="error in validationErrors"
                                :key="error"
                            >

                                <li x-text="error"></li>

                            </template>

                        </ul>

                    </div>


                    <div class="global-popup-actions">

                        <button
                            type="button"
                            class="global-popup-btn primary"
                            @click="showValidationPopup = false"
                        >
                            Mengerti
                        </button>

                    </div>

                </div>

            </div>

        </template>


        {{-- =====================================================
        POPUP KONFIRMASI PERUBAHAN
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
                            :disabled="submitting"
                            @click="
                                submitting = true;
                                showSavePopup = false;
                                $refs.assessmentForm.requestSubmit();
                            "
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

            <div
                class="global-popup success show"
                x-data
                x-init="
                    setTimeout(() => {
                        $el.remove();
                    }, 2500);
                "
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


                    <div class="global-popup-actions">

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

            </div>

        @endif


    </div>

</x-app-layout>