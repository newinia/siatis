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

        /*
        |--------------------------------------------------------------------------
        | HAK AKSES
        |--------------------------------------------------------------------------
        |
        | SUPER ADMIN = INPUT + EDIT + LIHAT
        | INSTRUKTUR  = INPUT + EDIT + LIHAT
        | MEDIS       = LIHAT SAJA
        |
        */

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
        | DATA ASESMEN
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
    @endphp

    <div class="participant-detail-page">
        <div class="participant-detail-container">

            {{-- =====================================================
                 PROGRESS TAHAPAN
            ====================================================== --}}

            <div class="participant-progress">

                {{-- STEP 1 --}}
                <div class="progress-step completed">
                    <div class="progress-circle">
                        ✓
                    </div>

                    <div class="progress-label">
                        Data Calon PPKS
                    </div>
                </div>

                {{-- STEP 2 --}}
                <div class="progress-step active">
                    <div class="progress-circle">
                        2
                    </div>

                    <div class="progress-label">
                        Asesmen Instruktur
                    </div>
                </div>

                {{-- STEP 3 --}}
                <div class="progress-step">
                    <div class="progress-circle">
                        3
                    </div>

                    <div class="progress-label">
                        Asesmen Kesehatan Awal
                    </div>
                </div>

                {{-- STEP 4 --}}
                <div class="progress-step">
                    <div class="progress-circle">
                        4
                    </div>

                    <div class="progress-label">
                        Case Conference
                    </div>
                </div>

                {{-- STEP 5 --}}
                <div class="progress-step">
                    <div class="progress-circle">
                        5
                    </div>

                    <div class="progress-label">
                        Kesehatan Lanjutan
                    </div>
                </div>

            </div>

            {{-- =====================================================
                 MAIN CARD
            ====================================================== --}}

            <div class="participant-card">

                {{-- HEADER --}}

                <div class="detail-header">

                    <div class="detail-header-left">

                        <a
                            href="{{ route('ppks.normal.asesmen-instruktur.data-detail', $ppks->id) }}"
                            class="back-button"
                            title="Kembali"
                        >
                            ←
                        </a>

                        <div>

                            <h1 class="detail-title">
                                Asesmen Instruktur
                            </h1>

                            <p class="detail-subtitle">

                                @if($canEdit)
                                    Lengkapi dan perbarui data asesmen instruktur calon PPKS.
                                @else
                                    Lihat data asesmen instruktur calon PPKS.
                                @endif

                            </p>

                        </div>

                    </div>

                    {{-- BADGE VIEW ONLY --}}

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
                     FORM
                ================================================== --}}

                <form
                    method="POST"
                    action="{{ route('ppks.normal.asesmen-instruktur.simpan', $ppks->id) }}"
                    id="asesmenForm"
                >

                    @csrf

                    {{-- =================================================
                         INFORMASI ASESMEN
                    ================================================== --}}

                    <div class="form-section">

                        <div class="section-heading">

                            <h2 class="section-title">
                                Informasi Asesmen
                            </h2>

                            <p class="section-description">
                                Masukkan informasi utama pelaksanaan asesmen instruktur.
                            </p>

                        </div>

                        <div class="form-grid">

                            {{-- STATUS ASESMEN --}}

                            <div class="form-group">

                                <label class="form-label">

                                    Status Asesmen

                                    @if($canEdit)
                                        <span class="required">*</span>
                                    @endif

                                </label>

                                <select
                                    name="status_asesmen"
                                    class="form-control {{ !$canEdit ? 'view-only' : '' }} @error('status_asesmen') has-error @enderror"
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
                                    <div class="input-error">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                            {{-- BAZNAS --}}

                            <div class="form-group">

                                <label class="form-label">

                                    Baznas / Non Baznas

                                    @if($canEdit)
                                        <span class="required">*</span>
                                    @endif

                                </label>

                                <select
                                    name="baznas"
                                    class="form-control {{ !$canEdit ? 'view-only' : '' }} @error('baznas') has-error @enderror"
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
                                    <div class="input-error">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                            {{-- GELOMBANG + TAHUN --}}

                            <div class="form-group">

                                <label class="form-label">

                                    Gelombang & Tahun

                                    @if($canEdit)
                                        <span class="required">*</span>
                                    @endif

                                </label>

                                <div class="inline-fields">

                                    {{-- GELOMBANG --}}

                                    <select
                                        name="gelombang"
                                        class="form-control {{ !$canEdit ? 'view-only' : '' }} @error('gelombang') has-error @enderror"
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
                                        name="tahun"
                                        class="form-control {{ !$canEdit ? 'view-only' : '' }} @error('tahun') has-error @enderror"
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

                            </div>

                            {{-- TANGGAL ASESMEN DARING --}}

                            <div class="form-group">

                                <label class="form-label">

                                    Tanggal Asesmen Daring

                                    @if($canEdit)
                                        <span class="required">*</span>
                                    @endif

                                </label>

                                <input
                                    type="date"
                                    name="tanggal_asesmen_daring"
                                    value="{{ $tanggalAsesmenDaring }}"
                                    class="form-control {{ !$canEdit ? 'view-only' : '' }} @error('tanggal_asesmen_daring') has-error @enderror"
                                    @if(!$canEdit) disabled @endif
                                    @if($canEdit) required @endif
                                >

                                @error('tanggal_asesmen_daring')
                                    <div class="input-error">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                            {{-- PETUGAS INSTRUKTUR --}}

                            <div class="form-group">

                                <label class="form-label">

                                    Petugas Asesmen Instruktur

                                    @if($canEdit)
                                        <span class="required">*</span>
                                    @endif

                                </label>

                                <select
                                    name="petugas_asesmen_instruktur"
                                    class="form-control {{ !$canEdit ? 'view-only' : '' }} @error('petugas_asesmen_instruktur') has-error @enderror"
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
                                    <div class="input-error">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                            {{-- HASIL ASESMEN --}}

                            <div class="form-group">

                                <label class="form-label">

                                    Hasil Asesmen Instruktur

                                    @if($canEdit)
                                        <span class="required">*</span>
                                    @endif

                                </label>

                                <select
                                    name="hasil_asesmen_instruktur"
                                    class="form-control {{ !$canEdit ? 'view-only' : '' }} @error('hasil_asesmen_instruktur') has-error @enderror"
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
                                    <div class="input-error">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                            {{-- CATATAN INSTRUKTUR --}}

                            <div class="form-group full">

                                <label class="form-label">
                                    Catatan
                                </label>

                                <textarea
                                    name="catatan_asesmen_instruktur"
                                    class="form-control {{ !$canEdit ? 'view-only' : '' }} @error('catatan_asesmen_instruktur') has-error @enderror"
                                    placeholder="Masukkan catatan atau keterangan tambahan..."
                                    @if(!$canEdit) disabled @endif
                                >{{ $catatanAsesmenInstruktur }}</textarea>

                                @error('catatan_asesmen_instruktur')
                                    <div class="input-error">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                        </div>

                    </div>

                    {{-- =================================================
                         ASESMEN LURING
                    ================================================== --}}

                    <div class="form-section">

                        <div
                            class="offline-card
                                {{ $asesmenLuring ? 'active' : '' }}
                                {{ !$canEdit ? 'view-only' : '' }}"
                            id="offlineCard"
                        >

                            <div class="offline-header">

                                <div class="offline-title-wrapper">

                                    <h2 class="offline-title">
                                        Asesmen Luring
                                    </h2>

                                    <p class="offline-subtitle">
                                        Aktifkan jika asesmen dilakukan secara langsung di lokasi.
                                    </p>

                                </div>

                                <div class="toggle-wrapper">

                                    <span
                                        class="toggle-text"
                                        id="toggleText"
                                    >
                                        {{ $asesmenLuring ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>

                                    <label class="toggle {{ !$canEdit ? 'disabled' : '' }}">

                                        <input
                                            type="checkbox"
                                            id="offlineToggle"
                                            name="asesmen_luring"
                                            value="1"
                                            {{ $asesmenLuring ? 'checked' : '' }}
                                            @if(!$canEdit) disabled @endif
                                        >

                                        <span class="toggle-slider"></span>

                                    </label>

                                </div>

                            </div>

                            {{-- FORM LURING --}}

                            <div
                                class="offline-form {{ $asesmenLuring ? 'show' : '' }}"
                                id="offlineForm"
                            >

                                <div class="form-grid">

                                    {{-- LOKASI --}}

                                    <div class="form-group full">

                                        <label class="form-label">
                                            Lokasi Asesmen Luring
                                        </label>

                                        <input
                                            type="text"
                                            name="lokasi_asesmen_luring"
                                            value="{{ $lokasiAsesmenLuring }}"
                                            class="form-control {{ !$canEdit ? 'view-only' : '' }} @error('lokasi_asesmen_luring') has-error @enderror"
                                            placeholder="Masukkan lokasi asesmen"
                                            @if(!$canEdit) disabled @endif
                                        >

                                        @error('lokasi_asesmen_luring')
                                            <div class="input-error">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>

                                    {{-- TANGGAL LURING --}}

                                    <div class="form-group">

                                        <label class="form-label">
                                            Tanggal Asesmen Luring
                                        </label>

                                        <input
                                            type="date"
                                            name="tanggal_asesmen_luring"
                                            value="{{ $tanggalAsesmenLuring }}"
                                            class="form-control {{ !$canEdit ? 'view-only' : '' }} @error('tanggal_asesmen_luring') has-error @enderror"
                                            @if(!$canEdit) disabled @endif
                                        >

                                        @error('tanggal_asesmen_luring')
                                            <div class="input-error">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>

                                    {{-- PETUGAS LURING --}}

                                    <div class="form-group">

                                        <label class="form-label">
                                            Petugas Asesmen Luring
                                        </label>

                                        <select
                                            name="petugas_asesmen_luring"
                                            class="form-control {{ !$canEdit ? 'view-only' : '' }} @error('petugas_asesmen_luring') has-error @enderror"
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

                                            @endif

                                        </select>

                                        @error('petugas_asesmen_luring')
                                            <div class="input-error">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>

                                    {{-- HASIL LURING --}}

                                    <div class="form-group">

                                        <label class="form-label">
                                            Hasil Asesmen Luring
                                        </label>

                                        <select
                                            name="hasil_asesmen_luring"
                                            class="form-control {{ !$canEdit ? 'view-only' : '' }} @error('hasil_asesmen_luring') has-error @enderror"
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
                                            <div class="input-error">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>

                                    {{-- CATATAN LURING --}}

                                    <div class="form-group full">

                                        <label class="form-label">
                                            Catatan Asesmen Luring
                                        </label>

                                        <textarea
                                            name="catatan_asesmen_luring"
                                            class="form-control {{ !$canEdit ? 'view-only' : '' }} @error('catatan_asesmen_luring') has-error @enderror"
                                            placeholder="Masukkan catatan asesmen luring..."
                                            @if(!$canEdit) disabled @endif
                                        >{{ $catatanAsesmenLuring }}</textarea>

                                        @error('catatan_asesmen_luring')
                                            <div class="input-error">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- =================================================
                         BUTTON
                    ================================================== --}}

                    <div class="action-buttons">

                        {{-- INSTRUKTUR + SUPER ADMIN BISA SIMPAN --}}

                        @if($canEdit)

                            <button
                                type="submit"
                                class="btn btn-primary"
                                id="submitButton"
                            >
                                Simpan
                            </button>

                        @endif

                        {{-- SEMUA ROLE BISA LANJUT MELIHAT --}}

@if($lulusInstruktur ?? false)
    <a
        href="{{ route('ppks.normal.asesmen-kesehatan.awal', $ppks->id) }}"
        class="btn btn-success"
    >
        Selanjutnya
    </a>
@else
    <button
        type="button"
        class="btn btn-success"
        onclick="showSessionErrorModal()"
    >
        Selanjutnya
    </button>
@endif

                    </div>

                </form>

            </div>

        </div>
    </div>

    {{-- =============================================================
         SUCCESS MODAL
    ============================================================== --}}
{{-- =============================================================
     SESSION ERROR MODAL
============================================================= --}}

<div
    class="modal-overlay"
    id="sessionErrorModal"
    style="display:none;"
>
    <div class="modal-card">

        <div
            class="modal-icon"
            style="background:#fef2f2;color:#dc2626;"
        >
            !
        </div>

        <h3 class="modal-title">
            Tidak Dapat Melanjutkan
        </h3>

        <p class="modal-description">
            Peserta belum dapat melanjutkan ke Asesmen Kesehatan Awal
            karena belum lulus Asesmen Instruktur.
        </p>

        <button
            type="button"
            class="btn btn-primary"
            onclick="history.back()"
            style="width:100%;"
        >
            OK
        </button>

    </div>
</div>

    {{-- =============================================================
         ERROR MODAL
    ============================================================== --}}

    @if($errors->any())

        <div
            class="modal-overlay"
            id="errorModal"
        >

            <div class="modal-card">

                <div
                    class="modal-icon"
                    style="background:#fef2f2;color:#dc2626;"
                >
                    !
                </div>

                <h3 class="modal-title">
                    Data Belum Lengkap
                </h3>

                <p class="modal-description">

                    Silakan periksa kembali data asesmen yang wajib diisi.

                    <br>
                    <br>

                    @foreach($errors->all() as $error)

                        <span style="display:block;">
                            • {{ $error }}
                        </span>

                    @endforeach

                </p>

                <button
                    type="button"
                    class="btn btn-primary"
                    onclick="closeErrorModal()"
                    style="width:100%;"
                >
                    OK
                </button>

            </div>

        </div>

    @endif

    {{-- =============================================================
         JAVASCRIPT
    ============================================================== --}}

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const offlineToggle =
                document.getElementById('offlineToggle');

            const offlineForm =
                document.getElementById('offlineForm');

            const offlineCard =
                document.getElementById('offlineCard');

            const toggleText =
                document.getElementById('toggleText');

            /*
            |--------------------------------------------------------------------------
            | UPDATE STATUS ASESMEN LURING
            |--------------------------------------------------------------------------
            */

            function updateOfflineState() {

                if (
                    !offlineToggle ||
                    !offlineForm ||
                    !offlineCard ||
                    !toggleText
                ) {
                    return;
                }

                if (offlineToggle.checked) {

                    offlineForm.classList.add('show');
                    offlineCard.classList.add('active');
                    toggleText.textContent = 'Aktif';

                } else {

                    offlineForm.classList.remove('show');
                    offlineCard.classList.remove('active');
                    toggleText.textContent = 'Tidak Aktif';

                }
            }

            /*
            |--------------------------------------------------------------------------
            | JALANKAN SAAT HALAMAN DIBUKA
            |--------------------------------------------------------------------------
            */

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

                    form.addEventListener('submit', function () {

                        const submitButton =
                            form.querySelector(
                                'button[type="submit"]'
                            );

                        if (submitButton) {

                            submitButton.disabled = true;

                            submitButton.textContent =
                                'Menyimpan...';

                        }

                    });

                }

            @endif

        });

        /*
        |--------------------------------------------------------------------------
        | SUCCESS MODAL
        |--------------------------------------------------------------------------
        */

        function closeSuccessModal() {

            const modal =
                document.getElementById('successModal');

            if (modal) {
                modal.style.display = 'none';
            }
        }

        /*
        |--------------------------------------------------------------------------
        | ERROR MODAL
        |--------------------------------------------------------------------------
        */

        function closeErrorModal() {

            const modal =
                document.getElementById('errorModal');

            if (modal) {
                modal.style.display = 'none';
            }
        }
        function showSessionErrorModal() {
                const modal = document.getElementById('sessionErrorModal');

                if (modal) {
                    modal.style.display = 'flex';
                }
            }


        /*
        |--------------------------------------------------------------------------
        | CLOSE MODAL KETIKA KLIK AREA LUAR
        |--------------------------------------------------------------------------
        */

        document.addEventListener('click', function (event) {

            const successModal =
                document.getElementById('successModal');

            const errorModal =
                document.getElementById('errorModal');

            if (
                successModal &&
                event.target === successModal
            ) {
                closeSuccessModal();
            }

            if (
                errorModal &&
                event.target === errorModal
            ) {
                closeErrorModal();
            }
            const sessionErrorModal =
                document.getElementById('sessionErrorModal');

            if (
                sessionErrorModal &&
                event.target === sessionErrorModal
            ) {
                closeSessionErrorModal();
            }
                    });

    </script>

</x-app-layout>
