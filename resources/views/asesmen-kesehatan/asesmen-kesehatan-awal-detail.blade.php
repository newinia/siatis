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

        /*
        |--------------------------------------------------------------------------
        | HAK AKSES
        |--------------------------------------------------------------------------
        |
        | Super Admin + Medis:
        |   - Bisa input
        |   - Bisa edit
        |   - Bisa simpan
        |
        | Instruktur:
        |   - Hanya melihat data
        |
        */

        $canEdit = $isMedis || $isSuperAdmin;
        $isViewOnly = $isInstruktur;


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
        | DATA ASESMEN KESEHATAN AWAL
        |--------------------------------------------------------------------------
        */

        $tanggalDaring = old(
            'tanggal_daring',
            data_get($data, 'tanggal_daring', '')
        );

        $gelombang = old(
            'gelombang',
            data_get($data, 'gelombang', '')
        );

        $tahunValue = old(
            'tahun',
            data_get($data, 'tahun', '')
        );

        $petugasKesehatan = old(
            'petugas_kesehatan',
            data_get($data, 'petugas_kesehatan', '')
        );

        $hasilAsesmenKesehatan = old(
            'hasil_asesmen_kesehatan',
            data_get($data, 'hasil_asesmen_kesehatan', '')
        );

        $catatanAsesmenKesehatan = old(
            'catatan_asesmen_kesehatan',
            data_get($data, 'catatan_asesmen_kesehatan', '')
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

        $kesehatanProgressStatus = match ($hasilAsesmenKesehatan) {

            'lulus' => 'completed',

            'pending' => 'pending',

            'tidak_lulus' => 'failed',

            default => 'current',

        };


        /*
        |--------------------------------------------------------------------------
        | STATUS LANJUT KE CASE CONFERENCE
        |--------------------------------------------------------------------------
        */

        $lulusKesehatanAwal =
            ($hasilAsesmenKesehatan === 'lulus');

    @endphp


    {{-- =====================================================
        PROGRESS PESERTA
    ====================================================== --}}

    <x-participant-progress
        :active-step="3"
        :stage-statuses="[
            1 => 'completed',
            2 => 'completed',
            3 => $kesehatanProgressStatus,
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
            action="{{ route('ppks.normal.asesmen-kesehatan.awal.simpan', $ppks->id) }}"
            id="asesmenKesehatanForm"
        >

            @csrf


            {{-- =================================================
                KEMBALI
            ================================================== --}}

            <a
                href="{{ route('ppks.normal.asesmen-instruktur.detail', $ppks->id) }}"
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
                            Asesmen Kesehatan Awal
                        </div>

                        <div class="detail-subtitle">

                            @if($canEdit)

                                <p>
                                    Lengkapi dan perbarui data asesmen kesehatan awal calon PPKS.
                                </p>

                            @else

                                Lihat data asesmen kesehatan awal calon PPKS.

                            @endif

                        </div>

                    </div>


                    {{-- MODE VIEW ONLY --}}

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
                        <strong>Instruktur</strong>.

                        Data Asesmen Kesehatan Awal hanya dapat dilihat.

                        Pengisian dan perubahan data hanya dapat dilakukan oleh role

<<<<<<< HEAD
                        <strong>Medis atau Super Admin</strong>.
=======
                            <p class="section-description">

                                @if($isInstruktur)

                                    Informasi asesmen kesehatan awal calon PPKS.

                                @else

                                    Masukkan informasi utama pelaksanaan asesmen kesehatan awal.

                                @endif

                            </p>

                        </div>


                        <div class="form-grid">


                            {{-- =================================================
                                 TANGGAL DARING
                            ================================================== --}}

                            <div class="form-group">

                                <label class="form-label">

                                    Tanggal Asesmen Daring

                                    @if($canEditKesehatan)
                                        <span class="required">*</span>
                                    @endif

                                </label>

                        <input
                            type="date"
                            name="tanggal_daring"
                            class="form-control @error('tanggal_daring') has-error @enderror"
                            value="{{ old('tanggal_daring', optional($kesehatanAwal)->tanggal_daring ? \Carbon\Carbon::parse($kesehatanAwal->tanggal_daring)->format('Y-m-d') : '') }}"
                            @if(!$canEditKesehatan)
                                readonly
                            @else
                                required
                            @endif
                        >

                                @if($isInstruktur)

                                    <div class="readonly-info">
                                        Data hanya dapat diubah oleh role Medis atau Super Admin.
                                    </div>

                                @endif

                                @error('tanggal_daring')

                                    <div class="input-error">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>


                            {{-- =================================================
                                 GELOMBANG & TAHUN
                            ================================================== --}}

                            <div class="form-group">

                                <label class="form-label">

                                    Gelombang & Tahun

                                    @if($canEditKesehatan)
                                        <span class="required">*</span>
                                    @endif

                                </label>


                                <div class="inline-fields">


                                    {{-- GELOMBANG --}}

                                    <select
                                        name="gelombang"
                                        class="form-control @error('gelombang') has-error @enderror"

                                        @if(!$canEditKesehatan)
                                            disabled
                                        @else
                                            required
                                        @endif
                                    >

                                        <option value="">
                                            Gelombang
                                        </option>

                                        @for($i = 1; $i <= 10; $i++)

                                            <option
                                                value="{{ $i }}"
                                                {{ (string)($gelombang ?? '') === (string)$i ? 'selected' : '' }}
                                            >
                                                Gelombang {{ $i }}
                                            </option>

                                        @endfor

                                    </select>


                                    {{-- TAHUN --}}

                                    <select
                                        name="tahun"
                                        class="form-control @error('tahun') has-error @enderror"

                                        @if(!$canEditKesehatan)
                                            disabled
                                        @else
                                            required
                                        @endif
                                    >

                                        <option value="">
                                            Tahun
                                        </option>

                                        @for(
                                            $tahun = date('Y') - 5;
                                            $tahun <= date('Y') + 1;
                                            $tahun++
                                        )

                                            <option
                                                value="{{ $tahun }}"
                                                {{ (string)($tahunValue ?? '') === (string)$tahun ? 'selected' : '' }}
                                            >
                                                {{ $tahun }}
                                            </option>

                                        @endfor

                                    </select>

                                </div>


                                @if($isInstruktur)

                                    <div class="readonly-info">
                                        Data hanya dapat diubah oleh role Medis atau Super Admin.
                                    </div>

                                @endif

                            </div>


                            {{-- =================================================
                                 PETUGAS
                            ================================================== --}}

                            <div class="form-group">

                                <label class="form-label">

                                    Petugas Asesmen Kesehatan

                                    @if($canEditKesehatan)
                                        <span class="required">*</span>
                                    @endif

                                </label>


                                <select
                                    name="petugas_kesehatan"
                                    class="form-control @error('petugas_kesehatan') has-error @enderror"

                                    @if(!$canEditKesehatan)
                                        disabled
                                    @else
                                        required
                                    @endif
                                >

                                    <option value="">
                                        Pilih petugas
                                    </option>

                                    @if(isset($petugas) && count($petugas) > 0)

                                        @foreach($petugas as $item)

                                            <option
                                                value="{{ $item->id }}"
                                                {{ (string)($petugasKesehatan ?? '') === (string)$item->id ? 'selected' : '' }}
                                            >
                                                {{ $item->name }}
                                            </option>

                                        @endforeach

                                    @endif

                                </select>


                                @if($isInstruktur)

                                    <div class="readonly-info">
                                        Data hanya dapat diubah oleh role Medis atau Super Admin.
                                    </div>

                                @endif


                                @error('petugas_kesehatan')

                                    <div class="input-error">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>


                            {{-- =================================================
                                 HASIL
                            ================================================== --}}

                            <div class="form-group">

                                <label class="form-label">

                                    Hasil Asesmen Kesehatan

                                    @if($canEditKesehatan)
                                        <span class="required">*</span>
                                    @endif

                                </label>


                                <select
                                    name="hasil_asesmen_kesehatan"
                                    class="form-control @error('hasil_asesmen_kesehatan') has-error @enderror"

                                    @if(!$canEditKesehatan)
                                        disabled
                                    @else
                                        required
                                    @endif
                                >

                                    <option value="">
                                        Pilih hasil asesmen
                                    </option>

                                    <option
                                        value="lulus"
                                        {{ ($hasilAsesmenKesehatan ?? '') === 'lulus' ? 'selected' : '' }}
                                    >
                                        Lulus
                                    </option>

                                    <option
                                        value="tidak_lulus"
                                        {{ ($hasilAsesmenKesehatan ?? '') === 'tidak_lulus' ? 'selected' : '' }}
                                    >
                                        Tidak Lulus
                                    </option>

                                    <option
                                        value="pending"
                                        {{ ($hasilAsesmenKesehatan ?? '') === 'pending' ? 'selected' : '' }}
                                    >
                                        Pending
                                    </option>

                                </select>


                                @if($isInstruktur)

                                    <div class="readonly-info">
                                        Data hanya dapat diubah oleh role Medis atau Super Admin.
                                    </div>

                                @endif


                                @error('hasil_asesmen_kesehatan')

                                    <div class="input-error">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>


                            {{-- =================================================
                                 CATATAN
                            ================================================== --}}

                            <div class="form-group full">

                                <label class="form-label">
                                    Catatan
                                </label>


                                <textarea
                                    name="catatan_asesmen_kesehatan"
                                    class="form-control @error('catatan_asesmen_kesehatan') has-error @enderror"
                                    placeholder="Masukkan catatan atau keterangan tambahan..."

                                    @if(!$canEditKesehatan)
                                        readonly
                                    @endif
                                >{{ $catatanAsesmenKesehatan ?? '' }}</textarea>


                                @if($isInstruktur)

                                    <div class="readonly-info">
                                        Data hanya dapat diubah oleh role Medis atau Super Admin.
                                    </div>

                                @endif


                                @error('catatan_asesmen_kesehatan')

                                    <div class="input-error">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>

                        </div>
>>>>>>> origin/development

                    </div>

                @endif


                {{-- =================================================
                    DATA ASESMEN
                ================================================== --}}

                <div class="assessment-grid">


                    {{-- =================================================
                        TANGGAL ASESMEN DARING
                    ================================================== --}}

                    <div class="detail-field">

                        <label for="tanggal_daring">

                            Tanggal Asesmen Daring

                            @if($canEdit)
                                <span class="required">*</span>
                            @endif

                        </label>


                        <input
                            type="date"
                            id="tanggal_daring"
                            name="tanggal_daring"
                            value="{{ $tanggalDaring }}"
                            class="{{ !$canEdit ? 'view-only' : '' }} @error('tanggal_daring') has-error @enderror"

                            @if(!$canEdit)
                                readonly
                            @else
                                required
                            @endif
                        >


                        @if($isViewOnly)

                            <div class="readonly-info">
                                Data hanya dapat diubah oleh role Medis atau Super Admin.
                            </div>

                        @endif


                        @error('tanggal_daring')

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

                                @if(!$canEdit)
                                    disabled
                                @else
                                    required
                                @endif
                            >

                                <option value="">
                                    Gelombang
                                </option>

                                @for($i = 1; $i <= 10; $i++)

                                    <option
                                        value="{{ $i }}"
                                        {{ (string) $gelombang === (string) $i ? 'selected' : '' }}
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

                                @if(!$canEdit)
                                    disabled
                                @else
                                    required
                                @endif
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
                                        {{ (string) $tahunValue === (string) $tahunOption ? 'selected' : '' }}
                                    >
                                        {{ $tahunOption }}
                                    </option>

                                @endfor

                            </select>

                        </div>


                        @if($isViewOnly)

                            <div class="readonly-info">
                                Data hanya dapat diubah oleh role Medis atau Super Admin.
                            </div>

                        @endif


                        @error('gelombang')

                            <div class="form-error">
                                {{ $message }}
                            </div>

                        @enderror


                        @error('tahun')

                            <div class="form-error">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- =================================================
                        PETUGAS KESEHATAN
                    ================================================== --}}

                    <div class="detail-field">

                        <label for="petugas_kesehatan">

                            Petugas Asesmen Kesehatan

                            @if($canEdit)
                                <span class="required">*</span>
                            @endif

                        </label>


                        <select
                            id="petugas_kesehatan"
                            name="petugas_kesehatan"
                            class="{{ !$canEdit ? 'view-only' : '' }} @error('petugas_kesehatan') has-error @enderror"

                            @if(!$canEdit)
                                disabled
                            @else
                                required
                            @endif
                        >

                            <option value="">
                                Pilih petugas
                            </option>


                            @if(isset($petugas) && $petugas->count() > 0)

                                @foreach($petugas as $item)

                                    <option
                                        value="{{ $item->id }}"
                                        {{ (string) $petugasKesehatan === (string) $item->id ? 'selected' : '' }}
                                    >
                                        {{ $item->name }}
                                    </option>

                                @endforeach

                            @else

                                <option
                                    value=""
                                    disabled
                                >
                                    Belum ada petugas medis
                                </option>

                            @endif

                        </select>


                        @if($isViewOnly)

                            <div class="readonly-info">
                                Data hanya dapat diubah oleh role Medis atau Super Admin.
                            </div>

                        @endif


                        @error('petugas_kesehatan')

                            <div class="form-error">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- =================================================
                        HASIL ASESMEN
                    ================================================== --}}

                    <div class="detail-field">

                        <label for="hasil_asesmen_kesehatan">

                            Hasil Asesmen Kesehatan

                            @if($canEdit)
                                <span class="required">*</span>
                            @endif

                        </label>


                        <select
                            id="hasil_asesmen_kesehatan"
                            name="hasil_asesmen_kesehatan"
                            class="{{ !$canEdit ? 'view-only' : '' }} @error('hasil_asesmen_kesehatan') has-error @enderror"

                            @if(!$canEdit)
                                disabled
                            @else
                                required
                            @endif
                        >

                            <option value="">
                                Pilih hasil asesmen
                            </option>

                            <option
                                value="lulus"
                                {{ $hasilAsesmenKesehatan === 'lulus' ? 'selected' : '' }}
                            >
                                Lulus
                            </option>

                            <option
                                value="tidak_lulus"
                                {{ $hasilAsesmenKesehatan === 'tidak_lulus' ? 'selected' : '' }}
                            >
                                Tidak Lulus
                            </option>

                            <option
                                value="pending"
                                {{ $hasilAsesmenKesehatan === 'pending' ? 'selected' : '' }}
                            >
                                Pending
                            </option>

                        </select>


                        @if($isViewOnly)

                            <div class="readonly-info">
                                Data hanya dapat diubah oleh role Medis atau Super Admin.
                            </div>

                        @endif


                        @error('hasil_asesmen_kesehatan')

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

                    <label for="catatan_asesmen_kesehatan">
                        Catatan
                    </label>


                    <textarea
                        id="catatan_asesmen_kesehatan"
                        name="catatan_asesmen_kesehatan"
                        placeholder="Masukkan catatan atau keterangan tambahan..."
                        class="{{ !$canEdit ? 'view-only' : '' }} @error('catatan_asesmen_kesehatan') has-error @enderror"

                        @if(!$canEdit)
                            readonly
                        @endif
                    >{{ $catatanAsesmenKesehatan }}</textarea>


                    @if($isViewOnly)

                        <div class="readonly-info">
                            Data hanya dapat diubah oleh role Medis atau Super Admin.
                        </div>

                    @endif


                    @error('catatan_asesmen_kesehatan')

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


                    {{-- ICON + TITLE --}}

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

                                @if($isViewOnly)

                                    Informasi asesmen yang dilakukan secara langsung di lokasi.

                                @else

                                    Aktifkan jika asesmen dilakukan secara luring.

                                @endif

                            </div>

                        </div>

                    </div>


                    {{-- SWITCH --}}

                    <div class="offline-toggle">

                        <span
                            class="toggle-text"
                            id="offlineToggleText"
                        >
                            {{ !empty($asesmenLuring) ? 'Aktif' : 'Tidak Aktif' }}
                        </span>


                        <label class="offline-switch">

                            <input
                                type="checkbox"
                                id="offlineAssessment"
                                name="asesmen_luring"
                                value="1"
                                {{ !empty($asesmenLuring) ? 'checked' : '' }}

                                @if(!$canEdit)
                                    disabled
                                @endif
                            >

                            <span class="toggle-slider"></span>

                        </label>

                    </div>

                </div>


                {{-- =================================================
                    FORM LURING
                ================================================== --}}

                <div
                    class="offline-form {{ !empty($asesmenLuring) ? 'show' : '' }}"
                    id="offlineForm"
                >

                    <div class="offline-fields">


                        {{-- =================================================
                            LOKASI
                        ================================================== --}}

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

                                @if(!$canEdit)
                                    readonly
                                @endif
                            >


                            @error('lokasi_asesmen_luring')

                                <div class="form-error">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- =================================================
                            TANGGAL
                        ================================================== --}}

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

                                @if(!$canEdit)
                                    readonly
                                @endif
                            >


                            @error('tanggal_asesmen_luring')

                                <div class="form-error">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- =================================================
                            PETUGAS
                        ================================================== --}}

                        <div class="detail-field">

                            <label for="petugas_asesmen_luring">
                                Petugas Asesmen Luring
                            </label>


                            <select
                                id="petugas_asesmen_luring"
                                name="petugas_asesmen_luring"
                                class="{{ !$canEdit ? 'view-only' : '' }} @error('petugas_asesmen_luring') has-error @enderror"

                                @if(!$canEdit)
                                    disabled
                                @endif
                            >

                                <option value="">
                                    Pilih petugas
                                </option>


                                @if(isset($petugas) && $petugas->count() > 0)

                                    @foreach($petugas as $item)

                                        <option
                                            value="{{ $item->id }}"
                                            {{ (string) $petugasAsesmenLuring === (string) $item->id ? 'selected' : '' }}
                                        >
                                            {{ $item->name }}
                                        </option>

                                    @endforeach

                                @else

                                    <option
                                        value=""
                                        disabled
                                    >
                                        Belum ada petugas medis
                                    </option>

                                @endif

                            </select>


                            @error('petugas_asesmen_luring')

                                <div class="form-error">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- =================================================
                            HASIL LURING
                        ================================================== --}}

                        <div class="detail-field">

                            <label for="hasil_asesmen_luring">
                                Hasil Asesmen Luring
                            </label>


                            <select
                                id="hasil_asesmen_luring"
                                name="hasil_asesmen_luring"
                                class="{{ !$canEdit ? 'view-only' : '' }} @error('hasil_asesmen_luring') has-error @enderror"

                                @if(!$canEdit)
                                    disabled
                                @endif
                            >

                                <option value="">
                                    Pilih hasil asesmen
                                </option>

                                <option
                                    value="lulus"
                                    {{ $hasilAsesmenLuring === 'lulus' ? 'selected' : '' }}
                                >
                                    Lulus
                                </option>

                                <option
                                    value="tidak_lulus"
                                    {{ $hasilAsesmenLuring === 'tidak_lulus' ? 'selected' : '' }}
                                >
                                    Tidak Lulus
                                </option>

                                <option
                                    value="pending"
                                    {{ $hasilAsesmenLuring === 'pending' ? 'selected' : '' }}
                                >
                                    Pending
                                </option>

                            </select>


                            @error('hasil_asesmen_luring')

                                <div class="form-error">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                    </div>


                    {{-- =================================================
                        CATATAN LURING
                    ================================================== --}}

                    <div class="detail-field offline-note">

                        <label for="catatan_asesmen_luring">
                            Catatan
                        </label>


                        <textarea
                            id="catatan_asesmen_luring"
                            name="catatan_asesmen_luring"
                            placeholder="Masukkan catatan tambahan (opsional)"
                            class="{{ !$canEdit ? 'view-only' : '' }} @error('catatan_asesmen_luring') has-error @enderror"

                            @if(!$canEdit)
                                readonly
                            @endif
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

                @if($lulusKesehatanAwal)

                    <a
                        href="{{ route('ppks.normal.case-conference.detail', $ppks->id) }}"
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
                            Hasil Asesmen Kesehatan Awal Berhasil di Input
                        </p>


                        <div class="global-popup-actions">

                            <button
                                type="button"
                                class="global-popup-btn primary"

                                @click="
                                    document
                                        .getElementById('asesmenKesehatanForm')
                                        .submit();
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
                Peserta belum dapat melanjutkan ke Case Conference
                karena belum lulus Asesmen Kesehatan Awal.
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


            /* =====================================================
               ASESMEN LURING
            ===================================================== */

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


            /* =====================================================
               PREVENT DOUBLE SUBMIT
            ===================================================== */

            const form =
                document.getElementById(
                    'asesmenKesehatanForm'
                );


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


            /* =====================================================
               HAPUS ERROR INLINE SAAT USER MULAI MENGISI
            ===================================================== */

            if (form) {

                const validationFields = [

                    'tanggal_daring',
                    'gelombang',
                    'tahun',
                    'petugas_kesehatan',
                    'hasil_asesmen_kesehatan'

                ];


                validationFields.forEach(function (id) {

                    const field =
                        document.getElementById(id);


                    if (!field) {
                        return;
                    }


                    function removeValidationError() {

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


                    field.addEventListener(
                        'change',
                        removeValidationError
                    );


                    field.addEventListener(
                        'input',
                        removeValidationError
                    );

                });

            }

        });


        /* =====================================================
           VALIDASI SEBELUM POPUP BERHASIL
        ===================================================== */

        function validateAndShowSavePopup() {

            const form =
                document.getElementById(
                    'asesmenKesehatanForm'
                );


            if (!form) {
                return;
            }


            /* =====================================================
               FIELD WAJIB
            ===================================================== */

            const requiredFields = [

                {
                    id: 'tanggal_daring',
                    message: 'Tanggal asesmen daring wajib diisi.'
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
                    id: 'petugas_kesehatan',
                    message: 'Petugas asesmen kesehatan wajib diisi.'
                },

                {
                    id: 'hasil_asesmen_kesehatan',
                    message: 'Hasil asesmen kesehatan wajib diisi.'
                }

            ];


            let hasError = false;

            let firstErrorField = null;

            let errorMessages = [];


            /* =====================================================
               HAPUS ERROR JS SEBELUMNYA
            ===================================================== */

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


            /* =====================================================
               CEK FIELD WAJIB
            ===================================================== */

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


                    field.classList.add(
                        'has-error',
                        'js-validation-error'
                    );


                    const error =
                        document.createElement('div');


                    error.className =
                        'form-error js-form-error';


                    error.textContent =
                        item.message;


                    /*
                    |--------------------------------------------------------------------------
                    | GELOMBANG & TAHUN
                    |--------------------------------------------------------------------------
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


                    if (!firstErrorField) {

                        firstErrorField =
                            field;

                    }


                    errorMessages.push(
                        item.message
                    );

                }

            });


            /* =====================================================
               JIKA ADA ERROR
            ===================================================== */

            if (hasError) {

                showErrorModal(
                    errorMessages
                );


                if (firstErrorField) {

                    firstErrorField.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });


                    setTimeout(function () {

                        firstErrorField.focus();

                    }, 300);

                }


                return;

            }


            /* =====================================================
               SEMUA VALID
            ===================================================== */

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


        /* =====================================================
           TAMPILKAN ERROR POPUP
        ===================================================== */

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


            modal.classList.add(
                'show'
            );


            modal.setAttribute(
                'aria-hidden',
                'false'
            );

        }


        /* =====================================================
           TUTUP ERROR POPUP
        ===================================================== */

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


        /* =====================================================
           SESSION ERROR POPUP
        ===================================================== */

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


        /* =====================================================
           CLICK AREA LUAR POPUP
        ===================================================== */

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