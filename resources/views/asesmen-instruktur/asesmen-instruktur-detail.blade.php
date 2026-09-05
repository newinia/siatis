<x-app-layout>

    <style>
        /* =========================================================
           PARTICIPANT DETAIL PAGE
        ========================================================= */
        .participant-detail-page {
            padding: 10px 0 40px;
        }

        .participant-detail-container {
            width: 100%;
            max-width: 1180px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* =========================================================
           PROGRESS TAHAPAN
        ========================================================= */
        .participant-progress {
            width: 100%;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            margin-bottom: 28px;
            overflow-x: auto;
            padding: 8px 0 12px;
        }

        .progress-step {
            position: relative;
            flex: 1;
            min-width: 145px;
            text-align: center;
        }

        .progress-step:not(:last-child)::after {
            content: "";
            position: absolute;
            top: 15px;
            left: 50%;
            width: 100%;
            height: 3px;
            background: #e5e7eb;
            z-index: 0;
        }

        .progress-step.completed:not(:last-child)::after {
            background: #63ae00;
        }

        .progress-circle {
            position: relative;
            z-index: 2;
            width: 32px;
            height: 32px;
            margin: 0 auto 8px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ffffff;
            border: 3px solid #d1d5db;
            font-size: 13px;
            font-weight: 700;
            color: #6b7280;
        }

        .progress-step.completed .progress-circle {
            background: #63ae00;
            border-color: #63ae00;
            color: #ffffff;
        }

        .progress-step.active .progress-circle {
            background: #328300;
            border-color: #328300;
            color: #ffffff;
            box-shadow: 0 0 0 5px rgba(50, 131, 0, 0.12);
        }

        .progress-label {
            font-size: 12px;
            line-height: 1.4;
            font-weight: 600;
            color: #6b7280;
            padding: 0 8px;
        }

        .progress-step.active .progress-label {
            color: #328300;
            font-weight: 700;
        }

        .progress-step.completed .progress-label {
            color: #63ae00;
        }

        /* =========================================================
           MAIN CARD
        ========================================================= */
        .participant-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            box-shadow:
                0 4px 12px rgba(0, 0, 0, 0.04),
                0 12px 30px rgba(0, 0, 0, 0.03);
            padding: 28px;
        }

        /* =========================================================
           HEADER
        ========================================================= */
        .detail-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 28px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e5e7eb;
        }

        .detail-header-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .back-button {
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            background: #f3f4f6;
            color: #374151;
            text-decoration: none;
            font-size: 18px;
            font-weight: 700;
            transition: all 0.2s ease;
        }

        .back-button:hover {
            background: #e5e7eb;
            transform: translateX(-2px);
        }

        .detail-title {
            margin: 0;
            font-size: 20px;
            line-height: 1.3;
            font-weight: 700;
            color: #111827;
        }

        .detail-subtitle {
            margin: 5px 0 0;
            font-size: 12px;
            line-height: 1.5;
            color: #6b7280;
        }

        /* =========================================================
           VIEW ONLY BADGE
        ========================================================= */
        .view-only-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 8px 12px;
            border-radius: 999px;
            background: #f3f4f6;
            color: #4b5563;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
        }

        .view-only-badge .badge-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #6b7280;
        }

        /* =========================================================
           INFO ROLE
        ========================================================= */
        .role-info {
            margin-bottom: 24px;
            padding: 13px 16px;
            border: 1px solid #dbeafe;
            border-radius: 10px;
            background: #eff6ff;
            color: #1e40af;
            font-size: 12px;
            line-height: 1.6;
        }

        .role-info strong {
            font-weight: 700;
        }

        /* =========================================================
           SECTION
        ========================================================= */
        .form-section {
            margin-bottom: 30px;
        }

        .form-section:last-child {
            margin-bottom: 0;
        }

        .section-heading {
            margin-bottom: 18px;
        }

        .section-title {
            margin: 0;
            font-size: 16px;
            line-height: 1.4;
            font-weight: 700;
            color: #111827;
        }

        .section-description {
            margin: 5px 0 0;
            font-size: 12px;
            line-height: 1.5;
            color: #6b7280;
        }

        /* =========================================================
           FORM GRID
        ========================================================= */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group.full {
            grid-column: 1 / -1;
        }

        /* =========================================================
           LABEL
        ========================================================= */
        .form-label {
            margin-bottom: 7px;
            font-size: 13px;
            line-height: 1.4;
            font-weight: 600;
            color: #374151;
        }

        .required {
            color: #dc2626;
            margin-left: 2px;
        }

        /* =========================================================
           INPUT / SELECT / TEXTAREA
        ========================================================= */
        .form-control {
            width: 100%;
            min-height: 42px;
            padding: 9px 12px;
            border: 1px solid #d1d5db;
            border-radius: 9px;
            background: #ffffff;
            color: #111827;
            font-size: 13px;
            line-height: 1.4;
            outline: none;
            transition:
                border-color 0.2s ease,
                box-shadow 0.2s ease,
                background 0.2s ease;
        }

        .form-control::placeholder {
            color: #9ca3af;
        }

        .form-control:focus {
            border-color: #63ae00;
            box-shadow: 0 0 0 3px rgba(99, 174, 0, 0.12);
        }

        select.form-control {
            cursor: pointer;
        }

        textarea.form-control {
            min-height: 110px;
            resize: vertical;
            line-height: 1.6;
        }

        /* =========================================================
           VIEW ONLY CONTROL
        ========================================================= */
        .form-control.view-only {
            background: #f8fafc;
            border-color: #e2e8f0;
            color: #374151;
            cursor: not-allowed;
        }

        .form-control.view-only:disabled {
            opacity: 1;
            -webkit-text-fill-color: #374151;
        }

        textarea.form-control.view-only {
            resize: none;
        }

        /* =========================================================
           INLINE FIELDS
        ========================================================= */
        .inline-fields {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        /* =========================================================
           OFFLINE ASSESSMENT
        ========================================================= */
        .offline-card {
            border: 1px solid #d1d5db;
            border-radius: 14px;
            background: #fafafa;
            padding: 22px;
            transition: all 0.25s ease;
        }

        .offline-card.active {
            border-color: #63ae00;
            background: #ffffff;
            box-shadow: 0 4px 14px rgba(99, 174, 0, 0.08);
        }

        .offline-card.view-only {
            background: #f8fafc;
            border-color: #e2e8f0;
        }

        .offline-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .offline-title-wrapper {
            min-width: 0;
        }

        .offline-title {
            margin: 0;
            font-size: 16px;
            line-height: 1.4;
            font-weight: 700;
            color: #111827;
        }

        .offline-subtitle {
            margin: 5px 0 0;
            font-size: 12px;
            line-height: 1.5;
            color: #6b7280;
        }

        /* =========================================================
           TOGGLE
        ========================================================= */
        .toggle-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }

        .toggle-text {
            font-size: 12px;
            font-weight: 600;
            color: #4b5563;
        }

        .toggle {
            position: relative;
            width: 48px;
            height: 26px;
            cursor: pointer;
        }

        .toggle input {
            display: none;
        }

        .toggle-slider {
            position: absolute;
            inset: 0;
            background: #d1d5db;
            border-radius: 999px;
            transition: all 0.2s ease;
        }

        .toggle-slider::before {
            content: "";
            position: absolute;
            width: 20px;
            height: 20px;
            left: 3px;
            top: 3px;
            background: #ffffff;
            border-radius: 50%;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.2);
            transition: all 0.2s ease;
        }

        .toggle input:checked + .toggle-slider {
            background: #63ae00;
        }

        .toggle input:checked + .toggle-slider::before {
            transform: translateX(22px);
        }

        .toggle.disabled {
            cursor: not-allowed;
            opacity: 0.75;
        }

        /* =========================================================
           OFFLINE FORM
        ========================================================= */
        .offline-form {
            display: none;
            margin-top: 22px;
            padding-top: 22px;
            border-top: 1px solid #e5e7eb;
        }

        .offline-form.show {
            display: block;
        }

        /* =========================================================
           BUTTON AREA
        ========================================================= */
        .action-buttons {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid #e5e7eb;
        }

        .btn {
            min-height: 42px;
            padding: 9px 18px;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border: 1px solid transparent;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background: #328300;
            color: #ffffff;
        }

        .btn-primary:hover {
            background: #286900;
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: #ffffff;
            color: #374151;
            border-color: #d1d5db;
        }

        .btn-secondary:hover {
            background: #f9fafb;
        }

        .btn-success {
            background: #63ae00;
            color: #ffffff;
        }

        .btn-success:hover {
            background: #4f8d00;
            transform: translateY(-1px);
        }

        /* =========================================================
           MODAL
        ========================================================= */
        .modal-overlay {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: rgba(17, 24, 39, 0.55);
            backdrop-filter: blur(3px);
        }

        .modal-card {
            width: 100%;
            max-width: 420px;
            background: #ffffff;
            border-radius: 16px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.18);
        }

        .modal-icon {
            width: 58px;
            height: 58px;
            margin: 0 auto 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #ecfdf5;
            color: #328300;
            font-size: 26px;
            font-weight: 700;
        }

        .modal-title {
            margin: 0;
            font-size: 18px;
            font-weight: 700;
            color: #111827;
        }

        .modal-description {
            margin: 8px 0 22px;
            font-size: 13px;
            line-height: 1.6;
            color: #6b7280;
        }

        /* =========================================================
           ERROR
        ========================================================= */
        .input-error {
            margin-top: 5px;
            font-size: 11px;
            line-height: 1.4;
            color: #dc2626;
        }

        .has-error {
            border-color: #dc2626 !important;
        }

        /* =========================================================
           RESPONSIVE
        ========================================================= */
        @media (max-width: 900px) {
            .participant-detail-container {
                padding: 0 16px;
            }

            .participant-card {
                padding: 22px;
            }

            .progress-step {
                min-width: 130px;
            }

            .progress-label {
                font-size: 11px;
            }
        }

        @media (max-width: 700px) {
            .participant-detail-page {
                padding-top: 5px;
            }

            .participant-card {
                padding: 18px;
                border-radius: 12px;
            }

            .detail-header {
                align-items: flex-start;
            }

            .detail-title {
                font-size: 18px;
            }

            .detail-subtitle {
                font-size: 11px;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .form-group.full {
                grid-column: auto;
            }

            .inline-fields {
                grid-template-columns: 1fr;
            }

            .offline-header {
                align-items: flex-start;
            }

            .toggle-wrapper {
                flex-direction: column;
                gap: 5px;
            }

            .action-buttons {
                flex-direction: column-reverse;
                align-items: stretch;
            }

            .btn {
                width: 100%;
            }

            .view-only-badge {
                font-size: 10px;
                padding: 7px 10px;
            }
        }

        @media (max-width: 520px) {
            .participant-progress {
                justify-content: flex-start;
                padding-left: 4px;
                padding-right: 4px;
            }

            .progress-step {
                min-width: 115px;
            }

            .progress-circle {
                width: 29px;
                height: 29px;
                font-size: 11px;
            }

            .progress-step:not(:last-child)::after {
                top: 13px;
            }

            .progress-label {
                font-size: 10px;
            }

            .back-button {
                width: 38px;
                height: 38px;
            }

            .detail-title {
                font-size: 17px;
            }

            .section-title {
                font-size: 15px;
            }

            .form-label {
                font-size: 12px;
            }

            .form-control {
                min-height: 42px;
                font-size: 13px;
            }

            .offline-card {
                padding: 17px;
            }

            .offline-title {
                font-size: 15px;
            }

            .offline-subtitle {
                font-size: 11px;
            }
        }
    </style>

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
