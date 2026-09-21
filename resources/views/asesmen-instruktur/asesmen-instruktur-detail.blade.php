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
        $isInstruktur = $userRole === 'instruktur';
        $isMedis = $userRole === 'medis';

        $canEdit = $isInstruktur || $isSuperAdmin;
        $isViewOnly = $isMedis;


        /*
        |--------------------------------------------------------------------------
        | DATA PPKS
        |--------------------------------------------------------------------------
        */

        $data = $ppks->data ?? [];

        if (!is_array($data)) {
            $data = json_decode($data, true) ?? [];
        }


        /*
        |--------------------------------------------------------------------------
        | DATA ASESMEN INSTRUKTUR
        |--------------------------------------------------------------------------
        */

        $statusAsesmen = old(
            'status_asesmen',
            data_get($data, 'status_asesmen', '')
        );

        $baznas = old(
            'baznas',
            data_get($data, 'baznas', '')
        );

        $gelombang = old(
            'gelombang',
            data_get($data, 'gelombang', '')
        );

        $tahun = old(
            'tahun',
            data_get($data, 'tahun', '')
        );

        $tanggalAsesmenDaring = old(
            'tanggal_asesmen_daring',
            data_get($data, 'tanggal_asesmen_daring', '')
        );

        $petugasAsesmenInstruktur = old(
            'petugas_asesmen_instruktur',
            data_get($data, 'petugas_asesmen_instruktur', '')
        );

        $hasilAsesmenInstruktur = old(
            'hasil_asesmen_instruktur',
            data_get($data, 'hasil_asesmen_instruktur', '')
        );

        $catatanAsesmenInstruktur = old(
            'catatan_asesmen_instruktur',
            data_get($data, 'catatan_asesmen_instruktur', '')
        );


        /*
        |--------------------------------------------------------------------------
        | ASESMEN LURING
        |--------------------------------------------------------------------------
        */

        $asesmenLuring = old(
            'asesmen_luring',
            data_get($data, 'asesmen_luring', false)
        );

        $lokasiAsesmenLuring = old(
            'lokasi_asesmen_luring',
            data_get($data, 'lokasi_asesmen_luring', '')
        );

        $tanggalAsesmenLuring = old(
            'tanggal_asesmen_luring',
            data_get($data, 'tanggal_asesmen_luring', '')
        );

        $petugasAsesmenLuring = old(
            'petugas_asesmen_luring',
            data_get($data, 'petugas_asesmen_luring', '')
        );

        $hasilAsesmenLuring = old(
            'hasil_asesmen_luring',
            data_get($data, 'hasil_asesmen_luring', '')
        );

        $catatanAsesmenLuring = old(
            'catatan_asesmen_luring',
            data_get($data, 'catatan_asesmen_luring', '')
        );


        /*
        |--------------------------------------------------------------------------
        | STATUS PROGRESS
        |--------------------------------------------------------------------------
        */

        $instrukturProgressStatus = match ($hasilAsesmenInstruktur) {
            'direkomendasikan' => 'completed',
            'perlu_ditinjau' => 'pending',
            'tidak_direkomendasikan' => 'failed',
            default => 'current',
        };
    @endphp


    {{-- =====================================================
        PROGRESS PESERTA
    ====================================================== --}}

    <x-participant-progress
        :active-step="2"
        :stage-statuses="[
            1 => 'completed',
            2 => $instrukturProgressStatus,
            3 => 'waiting',
            4 => 'waiting',
            5 => 'waiting',
        ]"
        final-status="waiting"
    />


    <div
        class="participant-detail-page"
        x-data="{ showSavePopup: false }"
    >


        {{-- =====================================================
            FORM CARD
        ====================================================== --}}

        <form
            class="participant-detail-card"
            method="POST"
            action="{{ route('ppks.normal.asesmen-instruktur.simpan', $ppks->id) }}"
            id="asesmenForm"
        >

            @csrf


            {{-- =================================================
                KEMBALI
            ================================================== --}}

            <a
                href="{{ route('ppks.normal.asesmen-instruktur.data-detail', $ppks->id) }}"
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
                HEADER ASESMEN
            ================================================== --}}

            <div class="detail-section">

                <div class="detail-section-header">

                    <div>

                        <div class="detail-section-title">
                            Asesmen Instruktur
                        </div>

                        <div class="detail-subtitle">

                            @if($canEdit)

                                <p>
                                    Lengkapi dan perbarui data asesmen instruktur calon PPKS
                                </p>

                            @else

                                Lihat data asesmen instruktur calon PPKS.

                            @endif

                        </div>

                    </div>


                    @if($isViewOnly)

                        <div class="view-only-badge">

                            <span class="badge-dot"></span>

                            Mode Lihat Saja

                        </div>

                    @endif

                </div>


                {{-- =================================================
                    INFORMASI ROLE
                ================================================== --}}

                @if($isViewOnly)

                    <div class="role-info">

                        <strong>Akses Terbatas:</strong>

                        Anda login sebagai
                        <strong>Medis</strong>.

                        Data Asesmen Instruktur hanya dapat dilihat.

                        Pengisian dan perubahan data hanya dapat dilakukan oleh role

                        <strong>Instruktur atau Super Admin</strong>.

                    </div>

                @endif


                {{-- =================================================
                    DATA ASESMEN
                ================================================== --}}

                <div class="assessment-grid">


                    {{-- =================================================
                        STATUS ASESMEN
                    ================================================== --}}

                    <div class="detail-field">

                        <label for="status_asesmen">

                            Status Asesmen

                            @if($canEdit)
                                <span class="required">*</span>
                            @endif

                        </label>


                        <select
                            id="status_asesmen"
                            name="status_asesmen"
                            class="{{ !$canEdit ? 'view-only' : '' }} @error('status_asesmen') has-error @enderror"
                            @if(!$canEdit) disabled @endif
                            @if($canEdit) required @endif
                        >

                            <option value="">
                                Pilih status asesmen
                            </option>

                            <option
                                value="belum"
                                {{ $statusAsesmen == 'belum' ? 'selected' : '' }}
                            >
                                Tahap 1
                            </option>

                            <option
                                value="proses"
                                {{ $statusAsesmen == 'proses' ? 'selected' : '' }}
                            >
                                Tahap 2
                            </option>

                            <option
                                value="selesai"
                                {{ $statusAsesmen == 'selesai' ? 'selected' : '' }}
                            >
                                Tahap 3
                            </option>

                        </select>


                        @error('status_asesmen')

                            <div class="form-error">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- =================================================
                        BAZNAS
                    ================================================== --}}

                    <div class="detail-field">

                        <label for="baznas">

                            Baznas / Non Baznas

                            @if($canEdit)
                                <span class="required">*</span>
                            @endif

                        </label>


                        <select
                            id="baznas"
                            name="baznas"
                            class="{{ !$canEdit ? 'view-only' : '' }} @error('baznas') has-error @enderror"
                            @if(!$canEdit) disabled @endif
                            @if($canEdit) required @endif
                        >

                            <option value="">
                                Pilih kategori
                            </option>

                            <option
                                value="Baznas"
                                {{ $baznas == 'Baznas' ? 'selected' : '' }}
                            >
                                Baznas
                            </option>

                            <option
                                value="Non Baznas"
                                {{ $baznas == 'Non Baznas' ? 'selected' : '' }}
                            >
                                Non Baznas
                            </option>

                        </select>


                        @error('baznas')

                            <div class="form-error">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- =================================================
                        GELOMBANG & TAHUN
                    ================================================== --}}

                    <div class="detail-field">

                        <label>

                            Gelombang & Tahun

                            @if($canEdit)
                                <span class="required">*</span>
                            @endif

                        </label>


                        <div class="wave-year-group">


                            {{-- GELOMBANG --}}

                            <select
                                id="gelombang"
                                name="gelombang"
                                class="{{ !$canEdit ? 'view-only' : '' }} @error('gelombang') has-error @enderror"
                                @if(!$canEdit) disabled @endif
                                @if($canEdit) required @endif
                            >

                                <option value="">
                                    Gelombang
                                </option>

                                @for($i = 1; $i <= 10; $i++)

                                    <option
                                        value="{{ $i }}"
                                        {{ (string) $gelombang == (string) $i ? 'selected' : '' }}
                                    >
                                        Gelombang {{ $i }}
                                    </option>

                                @endfor

                            </select>


                            {{-- TAHUN --}}

                            <select
                                id="tahun"
                                name="tahun"
                                class="{{ !$canEdit ? 'view-only' : '' }} @error('tahun') has-error @enderror"
                                @if(!$canEdit) disabled @endif
                                @if($canEdit) required @endif
                            >

                                <option value="">
                                    Tahun
                                </option>

                                @for(
                                    $tahunOption = date('Y') - 5;
                                    $tahunOption <= date('Y') + 1;
                                    $tahunOption++
                                )

                                    <option
                                        value="{{ $tahunOption }}"
                                        {{ (string) $tahun == (string) $tahunOption ? 'selected' : '' }}
                                    >
                                        {{ $tahunOption }}
                                    </option>

                                @endfor

                            </select>

                        </div>


                        {{-- ERROR GELOMBANG --}}

                        @error('gelombang')

                            <div class="form-error">
                                {{ $message }}
                            </div>

                        @enderror


                        {{-- ERROR TAHUN --}}

                        @error('tahun')

                            <div class="form-error">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- =================================================
                        TANGGAL ASESMEN DARING
                    ================================================== --}}

                    <div class="detail-field">

                        <label for="tanggal_asesmen_daring">

                            Tanggal Asesmen Daring

                            @if($canEdit)
                                <span class="required">*</span>
                            @endif

                        </label>


                        <input
                            type="date"
                            id="tanggal_asesmen_daring"
                            name="tanggal_asesmen_daring"
                            value="{{ $tanggalAsesmenDaring }}"
                            class="{{ !$canEdit ? 'view-only' : '' }} @error('tanggal_asesmen_daring') has-error @enderror"
                            @if(!$canEdit) disabled @endif
                            @if($canEdit) required @endif
                        >


                        @error('tanggal_asesmen_daring')

                            <div class="form-error">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- =================================================
                        PETUGAS INSTRUKTUR
                    ================================================== --}}

                    <div class="detail-field">

                        <label for="petugas_asesmen_instruktur">

                            Petugas Asesmen Instruktur

                            @if($canEdit)
                                <span class="required">*</span>
                            @endif

                        </label>


                        <select
                            id="petugas_asesmen_instruktur"
                            name="petugas_asesmen_instruktur"
                            class="{{ !$canEdit ? 'view-only' : '' }} @error('petugas_asesmen_instruktur') has-error @enderror"
                            @if(!$canEdit) disabled @endif
                            @if($canEdit) required @endif
                        >

                            <option value="">
                                Pilih petugas
                            </option>


                            @if(isset($petugas) && $petugas->count() > 0)

                                @foreach($petugas as $item)

                                    <option
                                        value="{{ $item->id }}"
                                        {{ (string) $petugasAsesmenInstruktur == (string) $item->id ? 'selected' : '' }}
                                    >
                                        {{ $item->name }}
                                    </option>

                                @endforeach

                            @else

                                <option value="" disabled>
                                    Belum ada petugas instruktur
                                </option>

                            @endif

                        </select>


                        @error('petugas_asesmen_instruktur')

                            <div class="form-error">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- =================================================
                        HASIL ASESMEN
                    ================================================== --}}

                    <div class="detail-field">

                        <label for="hasil_asesmen_instruktur">

                            Hasil Asesmen Instruktur

                            @if($canEdit)
                                <span class="required">*</span>
                            @endif

                        </label>


                        <select
                            id="hasil_asesmen_instruktur"
                            name="hasil_asesmen_instruktur"
                            class="{{ !$canEdit ? 'view-only' : '' }} @error('hasil_asesmen_instruktur') has-error @enderror"
                            @if(!$canEdit) disabled @endif
                            @if($canEdit) required @endif
                        >

                            <option value="">
                                Pilih hasil asesmen
                            </option>

                            <option
                                value="direkomendasikan"
                                {{ $hasilAsesmenInstruktur == 'direkomendasikan' ? 'selected' : '' }}
                            >
                                Lulus
                            </option>

                            <option
                                value="perlu_ditinjau"
                                {{ $hasilAsesmenInstruktur == 'perlu_ditinjau' ? 'selected' : '' }}
                            >
                                Pending
                            </option>

                            <option
                                value="tidak_direkomendasikan"
                                {{ $hasilAsesmenInstruktur == 'tidak_direkomendasikan' ? 'selected' : '' }}
                            >
                                Tidak Lulus
                            </option>

                        </select>


                        @error('hasil_asesmen_instruktur')

                            <div class="form-error">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>

                </div>


                {{-- =================================================
                    CATATAN
                ================================================== --}}

                <div class="detail-field assessment-note">

                    <label for="catatan_asesmen_instruktur">
                        Catatan
                    </label>


                    <textarea
                        id="catatan_asesmen_instruktur"
                        name="catatan_asesmen_instruktur"
                        class="{{ !$canEdit ? 'view-only' : '' }} @error('catatan_asesmen_instruktur') has-error @enderror"
                        placeholder="Masukkan catatan atau keterangan tambahan..."
                        @if(!$canEdit) disabled @endif
                    >{{ $catatanAsesmenInstruktur }}</textarea>


                    @error('catatan_asesmen_instruktur')

                        <div class="form-error">
                            {{ $message }}
                        </div>

                    @enderror

                </div>

            </div>


            {{-- =====================================================
                ASESMEN LURING
            ====================================================== --}}

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

                    <div class="offline-toggle">

                        <span
                            class="toggle-text"
                            id="offlineToggleText"
                        >
                            {{ $asesmenLuring ? 'Aktif' : 'Tidak Aktif' }}
                        </span>


                        <label class="offline-switch">

                            <input
                                type="checkbox"
                                id="offlineAssessment"
                                name="asesmen_luring"
                                value="1"
                                {{ $asesmenLuring ? 'checked' : '' }}
                                @if(!$canEdit) disabled @endif
                            >

                            <span class="toggle-slider"></span>

                        </label>

                    </div>

                </div>


                {{-- =================================================
                    FORM LURING
                ================================================== --}}

                <div
                    class="offline-form {{ $asesmenLuring ? 'show' : '' }}"
                    id="offlineForm"
                >

                    <div class="offline-fields">


                        {{-- LOKASI --}}

                        <div class="detail-field">

                            <label for="lokasi_asesmen_luring">
                                Lokasi Asesmen Luring
                            </label>


                            <input
                                type="text"
                                id="lokasi_asesmen_luring"
                                name="lokasi_asesmen_luring"
                                value="{{ $lokasiAsesmenLuring }}"
                                placeholder="Masukkan lokasi asesmen luring"
                                class="{{ !$canEdit ? 'view-only' : '' }} @error('lokasi_asesmen_luring') has-error @enderror"
                                @if(!$canEdit) disabled @endif
                            >


                            @error('lokasi_asesmen_luring')

                                <div class="form-error">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- TANGGAL --}}

                        <div class="detail-field">

                            <label for="tanggal_asesmen_luring">
                                Tanggal Asesmen Luring
                            </label>


                            <input
                                type="date"
                                id="tanggal_asesmen_luring"
                                name="tanggal_asesmen_luring"
                                value="{{ $tanggalAsesmenLuring }}"
                                class="{{ !$canEdit ? 'view-only' : '' }} @error('tanggal_asesmen_luring') has-error @enderror"
                                @if(!$canEdit) disabled @endif
                            >


                            @error('tanggal_asesmen_luring')

                                <div class="form-error">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- PETUGAS --}}

                        <div class="detail-field">

                            <label for="petugas_asesmen_luring">
                                Petugas Asesmen Instruktur
                            </label>


                            <select
                                id="petugas_asesmen_luring"
                                name="petugas_asesmen_luring"
                                class="{{ !$canEdit ? 'view-only' : '' }} @error('petugas_asesmen_luring') has-error @enderror"
                                @if(!$canEdit) disabled @endif
                            >

                                <option value="">
                                    Pilih petugas
                                </option>


                                @if(isset($petugas) && $petugas->count() > 0)

                                    @foreach($petugas as $item)

                                        <option
                                            value="{{ $item->id }}"
                                            {{ (string) $petugasAsesmenLuring == (string) $item->id ? 'selected' : '' }}
                                        >
                                            {{ $item->name }}
                                        </option>

                                    @endforeach

                                @else

                                    <option value="" disabled>
                                        Belum ada petugas instruktur
                                    </option>

                                @endif

                            </select>


                            @error('petugas_asesmen_luring')

                                <div class="form-error">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- HASIL --}}

                        <div class="detail-field">

                            <label for="hasil_asesmen_luring">
                                Hasil Asesmen Instruktur (Luring)
                            </label>


                            <select
                                id="hasil_asesmen_luring"
                                name="hasil_asesmen_luring"
                                class="{{ !$canEdit ? 'view-only' : '' }} @error('hasil_asesmen_luring') has-error @enderror"
                                @if(!$canEdit) disabled @endif
                            >

                                <option value="">
                                    Pilih hasil asesmen
                                </option>

                                <option
                                    value="direkomendasikan"
                                    {{ $hasilAsesmenLuring == 'direkomendasikan' ? 'selected' : '' }}
                                >
                                    Lulus
                                </option>

                                <option
                                    value="perlu_ditinjau"
                                    {{ $hasilAsesmenLuring == 'perlu_ditinjau' ? 'selected' : '' }}
                                >
                                    Pending
                                </option>

                                <option
                                    value="tidak_direkomendasikan"
                                    {{ $hasilAsesmenLuring == 'tidak_direkomendasikan' ? 'selected' : '' }}
                                >
                                    Tidak Lulus
                                </option>

                            </select>


                            @error('hasil_asesmen_luring')

                                <div class="form-error">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                    </div>


                    {{-- CATATAN LURING --}}

                    <div class="detail-field offline-note">

                        <label for="catatan_asesmen_luring">
                            Catatan
                        </label>


                        <textarea
                            id="catatan_asesmen_luring"
                            name="catatan_asesmen_luring"
                            placeholder="Masukkan catatan tambahan (opsional)"
                            class="{{ !$canEdit ? 'view-only' : '' }} @error('catatan_asesmen_luring') has-error @enderror"
                            @if(!$canEdit) disabled @endif
                        >{{ $catatanAsesmenLuring }}</textarea>


                        @error('catatan_asesmen_luring')

                            <div class="form-error">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>

                </div>

            </div>


            {{-- =====================================================
                BUTTON
            ====================================================== --}}

            <div class="form-action">


                {{-- SIMPAN --}}

                @if($canEdit)

                    <button
                        type="button"
                        class="btn-save"
                        id="submitButton"
                        onclick="validateAndShowSavePopup()"
                    >
                        Simpan
                    </button>

                @endif


                {{-- SELANJUTNYA --}}

                @if($lulusInstruktur ?? false)

                    <a
                        href="{{ route('ppks.normal.asesmen-kesehatan.awal', $ppks->id) }}"
                        class="btn-next btn-success"
                    >
                        Selanjutnya
                    </a>

                @else

                    <button
                        type="button"
                        class="btn-next btn-success"
                        onclick="showSessionErrorModal()"
                    >
                        Selanjutnya
                    </button>

                @endif

            </div>

        </form>


        {{-- =====================================================
            POPUP BERHASIL
        ====================================================== --}}

        @if($canEdit)

            <template x-if="showSavePopup">

                <div
                    class="global-popup success show"
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
                            Hasil Asesmen Instruktur Berhasil di Input
                        </p>


                        <div class="global-popup-actions">

                            <button
                                type="button"
                                class="global-popup-btn primary"
                                @click="
                                    document.getElementById('asesmenForm').submit();
                                "
                            >
                                OK
                            </button>

                        </div>

                    </div>

                </div>

            </template>

        @endif

    </div>


    {{-- =====================================================
        SESSION ERROR POPUP
    ====================================================== --}}

    <div
        class="global-popup warning"
        id="sessionErrorModal"
        aria-hidden="true"
    >

        <div class="global-popup-box">


            <div class="global-popup-icon">

                <span class="material-symbols-outlined">
                    warning
                </span>

            </div>


            <h3 class="global-popup-title">
                Tidak Dapat Melanjutkan
            </h3>


            <p class="global-popup-message">
                Peserta belum dapat melanjutkan ke Asesmen Kesehatan Awal
                karena belum lulus Asesmen Instruktur.
            </p>


            <div class="global-popup-actions">

                <button
                    type="button"
                    class="global-popup-btn primary"
                    onclick="closeSessionErrorModal()"
                >
                    OK
                </button>

            </div>

        </div>

    </div>


    {{-- =====================================================
        ERROR POPUP
    ====================================================== --}}

    <div
        class="global-popup error"
        id="errorModal"
        aria-hidden="true"
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

                <div>
                    Silakan periksa kembali data asesmen yang wajib diisi.
                </div>

                <ul
                    class="global-popup-error-list"
                    id="errorModalList"
                >
                </ul>

            </div>


            <div class="global-popup-actions">

                <button
                    type="button"
                    class="global-popup-btn primary"
                    onclick="closeErrorModal()"
                >
                    OK
                </button>

            </div>

        </div>

    </div>


    {{-- =====================================================
        JAVASCRIPT
    ====================================================== --}}

    <script>

        document.addEventListener('DOMContentLoaded', function () {


            /*
            |--------------------------------------------------------------------------
            | ASESMEN LURING
            |--------------------------------------------------------------------------
            */

            const offlineToggle =
                document.getElementById('offlineAssessment');

            const offlineForm =
                document.getElementById('offlineForm');

            const offlineToggleText =
                document.getElementById('offlineToggleText');


            function updateOfflineState() {

                if (
                    !offlineToggle ||
                    !offlineForm ||
                    !offlineToggleText
                ) {
                    return;
                }


                if (offlineToggle.checked) {

                    offlineForm.classList.add('show');

                    offlineToggleText.textContent =
                        'Aktif';

                } else {

                    offlineForm.classList.remove('show');

                    offlineToggleText.textContent =
                        'Tidak Aktif';

                }

            }


            if (offlineToggle) {

                @if($canEdit)

                    offlineToggle.addEventListener(
                        'change',
                        updateOfflineState
                    );

                @endif

                updateOfflineState();

            }


            /*
            |--------------------------------------------------------------------------
            | PREVENT DOUBLE SUBMIT
            |--------------------------------------------------------------------------
            */

            const form =
                document.getElementById('asesmenForm');


            @if($canEdit)

                if (form) {

                    form.addEventListener(
                        'submit',
                        function () {

                            const submitButton =
                                document.getElementById(
                                    'submitButton'
                                );


                            if (submitButton) {

                                submitButton.disabled =
                                    true;

                                submitButton.textContent =
                                    'Menyimpan...';

                            }

                        }
                    );

                }

            @endif


            /*
            |--------------------------------------------------------------------------
            | HAPUS ERROR INLINE SAAT USER MULAI MENGISI
            |--------------------------------------------------------------------------
            */

            if (form) {

                const validationFields = [
                    'status_asesmen',
                    'baznas',
                    'gelombang',
                    'tahun',
                    'tanggal_asesmen_daring',
                    'petugas_asesmen_instruktur',
                    'hasil_asesmen_instruktur'
                ];


                validationFields.forEach(function (id) {

                    const field =
                        document.getElementById(id);


                    if (!field) {
                        return;
                    }


                    field.addEventListener(
                        'change',
                        function () {

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


                                const parent =
                                    field.parentNode;


                                const error =
                                    parent.querySelector(
                                        '.js-form-error'
                                    );


                                if (error) {
                                    error.remove();
                                }

                            }

                        }
                    );


                    field.addEventListener(
                        'input',
                        function () {

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


                                const parent =
                                    field.parentNode;


                                const error =
                                    parent.querySelector(
                                        '.js-form-error'
                                    );


                                if (error) {
                                    error.remove();
                                }

                            }

                        }
                    );

                });

            }

        });


        /*
        |--------------------------------------------------------------------------
        | VALIDASI SEBELUM POPUP BERHASIL
        |--------------------------------------------------------------------------
        */

        function validateAndShowSavePopup() {

            const form =
                document.getElementById('asesmenForm');


            if (!form) {
                return;
            }


            /*
            |--------------------------------------------------------------------------
            | FIELD WAJIB
            |--------------------------------------------------------------------------
            */

            const requiredFields = [

                {
                    id: 'status_asesmen',
                    message: 'Status asesmen wajib diisi.'
                },

                {
                    id: 'baznas',
                    message: 'Baznas / Non Baznas wajib diisi.'
                },

                {
                    id: 'gelombang',
                    message: 'Gelombang wajib diisi.'
                },

                {
                    id: 'tahun',
                    message: 'Tahun wajib diisi.'
                },

                {
                    id: 'tanggal_asesmen_daring',
                    message: 'Tanggal asesmen daring wajib diisi.'
                },

                {
                    id: 'petugas_asesmen_instruktur',
                    message: 'Petugas asesmen instruktur wajib diisi.'
                },

                {
                    id: 'hasil_asesmen_instruktur',
                    message: 'Hasil asesmen instruktur wajib diisi.'
                }

            ];


            let hasError = false;

            let firstErrorField = null;

            let errorMessages = [];


            /*
            |--------------------------------------------------------------------------
            | HAPUS ERROR VALIDASI JS SEBELUMNYA
            |--------------------------------------------------------------------------
            */

            form
                .querySelectorAll('.js-form-error')
                .forEach(function (error) {

                    error.remove();

                });


            form
                .querySelectorAll('.js-validation-error')
                .forEach(function (field) {

                    field.classList.remove(
                        'has-error'
                    );

                    field.classList.remove(
                        'js-validation-error'
                    );

                });


            /*
            |--------------------------------------------------------------------------
            | CEK FIELD WAJIB
            |--------------------------------------------------------------------------
            */

            requiredFields.forEach(function (item) {

                const field =
                    document.getElementById(item.id);


                if (!field || field.disabled) {
                    return;
                }


                const value =
                    field.value
                        ? field.value.trim()
                        : '';


                if (!value) {

                    hasError = true;


                    /*
                    |--------------------------------------------------------------------------
                    | TAMBAHKAN ERROR KE INPUT
                    |--------------------------------------------------------------------------
                    */

                    field.classList.add(
                        'has-error',
                        'js-validation-error'
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | BUAT PESAN ERROR DI BAWAH INPUT
                    |--------------------------------------------------------------------------
                    */

                    const error =
                        document.createElement('div');

                    error.className =
                        'form-error js-form-error';

                    error.textContent =
                        item.message;


                    /*
                    | Untuk gelombang dan tahun,
                    | error ditempatkan setelah group.
                    */

                    if (
                        item.id === 'gelombang' ||
                        item.id === 'tahun'
                    ) {

                        const group =
                            document.querySelector(
                                '.wave-year-group'
                            );


                        if (
                            group &&
                            !group.parentNode.querySelector(
                                '.js-form-error'
                            )
                        ) {

                            group.parentNode.appendChild(
                                error
                            );

                        }

                    } else {

                        field.parentNode.appendChild(
                            error
                        );

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | SIMPAN FIELD ERROR PERTAMA
                    |--------------------------------------------------------------------------
                    */

                    if (!firstErrorField) {

                        firstErrorField =
                            field;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | SIMPAN PESAN UNTUK POPUP
                    |--------------------------------------------------------------------------
                    */

                    errorMessages.push(
                        item.message
                    );

                }

            });


            /*
            |--------------------------------------------------------------------------
            | JIKA ADA ERROR
            |--------------------------------------------------------------------------
            */

            if (hasError) {


                /*
                |--------------------------------------------------------------------------
                | TAMPILKAN POPUP ERROR
                |--------------------------------------------------------------------------
                */

                showErrorModal(
                    errorMessages
                );


                /*
                |--------------------------------------------------------------------------
                | FOKUS KE FIELD ERROR PERTAMA
                |--------------------------------------------------------------------------
                */

                if (firstErrorField) {

                    firstErrorField.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });


                    setTimeout(function () {

                        firstErrorField.focus();

                    }, 300);

                }


                /*
                |--------------------------------------------------------------------------
                | JANGAN TAMPILKAN POPUP BERHASIL
                |--------------------------------------------------------------------------
                */

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | SEMUA VALID
            | TAMPILKAN POPUP BERHASIL
            |--------------------------------------------------------------------------
            */

            const page =
                document.querySelector(
                    '.participant-detail-page'
                );


            if (
                page &&
                page._x_dataStack
            ) {

                const alpineData =
                    page._x_dataStack[0];


                alpineData.showSavePopup =
                    true;

            }

        }


        /*
        |--------------------------------------------------------------------------
        | TAMPILKAN ERROR POPUP
        |--------------------------------------------------------------------------
        */

        function showErrorModal(messages) {

            const modal =
                document.getElementById(
                    'errorModal'
                );


            const errorList =
                document.getElementById(
                    'errorModalList'
                );


            if (!modal) {
                return;
            }


            /*
            |--------------------------------------------------------------------------
            | BERSIHKAN LIST ERROR
            |--------------------------------------------------------------------------
            */

            if (errorList) {

                errorList.innerHTML = '';


                messages.forEach(function (message) {

                    const li =
                        document.createElement('li');

                    li.textContent =
                        message;


                    errorList.appendChild(
                        li
                    );

                });

            }


            /*
            |--------------------------------------------------------------------------
            | TAMPILKAN POPUP
            |--------------------------------------------------------------------------
            */

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
        | TUTUP ERROR POPUP
        |--------------------------------------------------------------------------
        */

        function closeErrorModal() {

            const modal =
                document.getElementById(
                    'errorModal'
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
        | SESSION ERROR POPUP
        |--------------------------------------------------------------------------
        */

        function showSessionErrorModal() {

            const modal =
                document.getElementById(
                    'sessionErrorModal'
                );


            if (modal) {

                modal.classList.add(
                    'show'
                );

                modal.setAttribute(
                    'aria-hidden',
                    'false'
                );

            }

        }


        function closeSessionErrorModal() {

            const modal =
                document.getElementById(
                    'sessionErrorModal'
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
        | CLOSE POPUP KETIKA KLIK AREA LUAR
        |--------------------------------------------------------------------------
        */

        document.addEventListener(
            'click',
            function (event) {

                const errorModal =
                    document.getElementById(
                        'errorModal'
                    );

                const sessionErrorModal =
                    document.getElementById(
                        'sessionErrorModal'
                    );


                if (
                    errorModal &&
                    event.target === errorModal
                ) {

                    closeErrorModal();

                }


                if (
                    sessionErrorModal &&
                    event.target === sessionErrorModal
                ) {

                    closeSessionErrorModal();

                }

            }
        );

    </script>

</x-app-layout>