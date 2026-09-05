<x-app-layout>

    @php
        /*
        |--------------------------------------------------------------------------
        | ROLE USER
        |--------------------------------------------------------------------------
        */

        $role = strtolower(trim((string) (auth()->user()->role ?? '')));

        $isSuperAdmin = $role === 'super_admin';
        $isMedis = $role === 'medis';
        $isInstruktur = $role === 'instruktur';

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

        $canEditKesehatan = $isMedis || $isSuperAdmin;
        $isViewOnly = $isInstruktur;
    @endphp


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
            margin-top: 10px;
            padding: 7px 12px;
            border-radius: 999px;
            background: #f3f4f6;
            color: #4b5563;
            font-size: 11px;
            font-weight: 700;
        }

        .view-only-badge::before {
            content: "👁";
            font-size: 12px;
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
            box-shadow:
                0 0 0 3px rgba(99, 174, 0, 0.12);
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
           READ ONLY
        ========================================================= */

        .form-control[readonly],
        .form-control:disabled {
            background: #f9fafb;
            color: #374151;
            border-color: #e5e7eb;
            cursor: not-allowed;
            opacity: 1;
        }

        select.form-control:disabled {
            appearance: auto;
            -webkit-appearance: auto;
        }

        .readonly-info {
            margin-top: 5px;
            font-size: 10px;
            color: #9ca3af;
        }


        /* =========================================================
           GELOMBANG & TAHUN
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
            box-shadow:
                0 4px 14px rgba(99, 174, 0, 0.08);
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
            box-shadow:
                0 20px 50px rgba(0, 0, 0, 0.18);
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
                <div class="progress-step completed">

                    <div class="progress-circle">
                        ✓
                    </div>

                    <div class="progress-label">
                        Asesmen Instruktur
                    </div>

                </div>


                {{-- STEP 3 --}}
                <div class="progress-step active">

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


                {{-- =================================================
                     HEADER
                ================================================== --}}

                <div class="detail-header">

                    <div class="detail-header-left">

                        <a
                            href="{{ route('ppks.normal.asesmen-instruktur.detail', $ppks->id) }}"
                            class="back-button"
                            title="Kembali"
                        >
                            ←
                        </a>

                        <div>

                            <h1 class="detail-title">
                                Asesmen Kesehatan Awal
                            </h1>

                            <p class="detail-subtitle">

                                @if($isInstruktur)

                                    Lihat data asesmen kesehatan awal calon PPKS.

                                @else

                                    Lengkapi data asesmen kesehatan awal calon PPKS.

                                @endif

                            </p>


                            {{-- KHUSUS INSTRUKTUR --}}

                            @if($isInstruktur)

                                <div class="view-only-badge">
                                    Mode Lihat Saja
                                </div>

                            @endif

                        </div>

                    </div>

                </div>


                {{-- =================================================
                     FORM
                ================================================== --}}

        <form
            method="POST"
            action="{{ route('ppks.normal.asesmen-kesehatan.awal.simpan', $ppks->id) }}"
            id="asesmenKesehatanForm"
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
                                    value="{{ old('tanggal_daring', $tanggalDaring ?? '') }}"

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

                    </div>


                    {{-- =================================================
                         ASESMEN LURING
                    ================================================== --}}

                    <div class="form-section">

                        <div
                            class="offline-card"
                            id="offlineCard"
                        >

                            <div class="offline-header">

                                <div class="offline-title-wrapper">

                                    <h2 class="offline-title">
                                        Asesmen Luring
                                    </h2>

                                    <p class="offline-subtitle">

                                        @if($isInstruktur)

                                            Informasi asesmen yang dilakukan secara langsung di lokasi.

                                        @else

                                            Aktifkan jika asesmen dilakukan secara langsung di lokasi.

                                        @endif

                                    </p>

                                </div>


                                {{-- =================================================
                                     TOGGLE
                                ================================================== --}}

                                <div class="toggle-wrapper">

                                    <span
                                        class="toggle-text"
                                        id="toggleText"
                                    >
                                        {{ !empty($asesmenLuring) ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>


                                    @if($isInstruktur)

                                        {{-- VIEW ONLY TOGGLE --}}

                                        <label
                                            class="toggle"
                                            style="cursor:not-allowed;"
                                        >

                                            <input
                                                type="checkbox"
                                                id="offlineToggle"
                                                disabled
                                                {{ !empty($asesmenLuring) ? 'checked' : '' }}
                                            >

                                            <span class="toggle-slider"></span>

                                        </label>

                                    @else

                                        {{-- EDITABLE TOGGLE --}}

                                        <label class="toggle">

                                            <input
                                                type="checkbox"
                                                id="offlineToggle"
                                                name="asesmen_luring"
                                                value="1"
                                                {{ !empty($asesmenLuring) ? 'checked' : '' }}
                                            >

                                            <span class="toggle-slider"></span>

                                        </label>

                                    @endif

                                </div>

                            </div>


                            {{-- =================================================
                                 FORM LURING
                            ================================================== --}}

                            <div
                                class="offline-form"
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
                                            value="{{ $lokasiAsesmenLuring ?? '' }}"
                                            class="form-control @error('lokasi_asesmen_luring') has-error @enderror"
                                            placeholder="Masukkan lokasi asesmen"

                                            @if(!$canEditKesehatan)
                                                readonly
                                            @endif
                                        >

                                        @error('lokasi_asesmen_luring')

                                            <div class="input-error">
                                                {{ $message }}
                                            </div>

                                        @enderror

                                    </div>


                                    {{-- TANGGAL --}}

                                    <div class="form-group">

                                        <label class="form-label">
                                            Tanggal Asesmen Luring
                                        </label>

                                        <input
                                            type="date"
                                            name="tanggal_asesmen_luring"
                                            value="{{ $tanggalAsesmenLuring ?? '' }}"
                                            class="form-control @error('tanggal_asesmen_luring') has-error @enderror"

                                            @if(!$canEditKesehatan)
                                                readonly
                                            @endif
                                        >

                                        @error('tanggal_asesmen_luring')

                                            <div class="input-error">
                                                {{ $message }}
                                            </div>

                                        @enderror

                                    </div>


                                    {{-- PETUGAS --}}

                                    <div class="form-group">

                                        <label class="form-label">
                                            Petugas Asesmen Luring
                                        </label>

                                        <select
                                            name="petugas_asesmen_luring"
                                            class="form-control @error('petugas_asesmen_luring') has-error @enderror"

                                            @if(!$canEditKesehatan)
                                                disabled
                                            @endif
                                        >

                                            <option value="">
                                                Pilih petugas
                                            </option>

                                            @if(isset($petugas) && count($petugas) > 0)

                                                @foreach($petugas as $item)

                                                    <option
                                                        value="{{ $item->id }}"
                                                        {{ (string)($petugasAsesmenLuring ?? '') === (string)$item->id ? 'selected' : '' }}
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
                                            class="form-control @error('hasil_asesmen_luring') has-error @enderror"

                                            @if(!$canEditKesehatan)
                                                disabled
                                            @endif
                                        >

                                            <option value="">
                                                Pilih hasil asesmen
                                            </option>

                                            <option
                                                value="lulus"
                                                {{ ($hasilAsesmenLuring ?? '') === 'lulus' ? 'selected' : '' }}
                                            >
                                                Lulus
                                            </option>

                                            <option
                                                value="tidak_lulus"
                                                {{ ($hasilAsesmenLuring ?? '') === 'tidak_lulus' ? 'selected' : '' }}
                                            >
                                                Tidak Lulus
                                            </option>

                                            <option
                                                value="pending"
                                                {{ ($hasilAsesmenLuring ?? '') === 'pending' ? 'selected' : '' }}
                                            >
                                                Pending
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
                                            class="form-control @error('catatan_asesmen_luring') has-error @enderror"
                                            placeholder="Masukkan catatan asesmen luring..."

                                            @if(!$canEditKesehatan)
                                                readonly
                                            @endif
                                        >{{ $catatanAsesmenLuring ?? '' }}</textarea>


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


                        {{-- SIMPAN UNTUK MEDIS + SUPER ADMIN --}}

                        @if($canEditKesehatan)

                            <button
                                type="submit"
                                class="btn btn-primary"
                                id="submitButton"
                            >
                                Simpan
                            </button>

                        @endif
                    {{-- SELANJUTNYA --}}
@if($lulusKesehatanAwal ?? false)

    <a
        href="{{ route('ppks.normal.case-conference.detail', $ppks->id) }}"
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

    @if(session('success'))

        <div
            class="modal-overlay"
            id="successModal"
        >

            <div class="modal-card">

                <div class="modal-icon">
                    ✓
                </div>

                <h3 class="modal-title">
                    Berhasil
                </h3>

                <p class="modal-description">
                    {{ session('success') }}
                </p>

                <button
                    type="button"
                    class="btn btn-primary"
                    onclick="closeSuccessModal()"
                    style="width:100%;"
                >
                    OK
                </button>

            </div>

        </div>

    @endif

    {{-- =============================================================
     SESSION ERROR MODAL
============================================================= --}}
<div
    class="modal-overlay"
    id="sessionErrorModal"
    style="display:none;"
>
    <div class="modal-card">
        <div class="modal-icon">
            !
        </div>

        <h3 class="modal-title">
            Belum Bisa Melanjutkan
        </h3>

        <p class="modal-description">
            Peserta belum lulus Asesmen Kesehatan Awal.
            Silakan selesaikan asesmen terlebih dahulu untuk melanjutkan ke Case Conference.
        </p>

        <button
            type="button"
            class="btn btn-primary"
            onclick="closeSessionErrorModal()"
            style="width:100%;"
        >
            OK
        </button>
    </div>
</div>


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


            function updateOfflineState() {

                if (
                    !offlineToggle ||
                    !offlineForm ||
                    !offlineCard
                ) {
                    return;
                }


                if (offlineToggle.checked) {

                    offlineForm.classList.add('show');

                    offlineCard.classList.add('active');

                    if (toggleText) {
                        toggleText.textContent = 'Aktif';
                    }

                } else {

                    offlineForm.classList.remove('show');

                    offlineCard.classList.remove('active');

                    if (toggleText) {
                        toggleText.textContent = 'Tidak Aktif';
                    }

                }

            }


            if (offlineToggle) {

                offlineToggle.addEventListener(
                    'change',
                    updateOfflineState
                );

                updateOfflineState();

            }


            /* =====================================================
               PREVENT DOUBLE SUBMIT
            ===================================================== */

            const form =
                document.getElementById('asesmenKesehatanForm');

            const submitButton =
                document.getElementById('submitButton');


            if (form && submitButton) {

                form.addEventListener('submit', function () {

                    submitButton.disabled = true;

                    submitButton.textContent = 'Menyimpan...';

                    submitButton.style.opacity = '0.7';

                    submitButton.style.cursor = 'not-allowed';

                });

            }

        });


        /* =========================================================
           CLOSE SUCCESS MODAL
        ========================================================= */

        function closeSuccessModal() {

            const modal =
                document.getElementById('successModal');

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

function closeSessionErrorModal() {
    const modal = document.getElementById('sessionErrorModal');

    if (modal) {
        modal.style.display = 'none';
    }
}


        /* =========================================================
           CLICK OUTSIDE MODAL
        ========================================================= */

        document.addEventListener('click', function (event) {

            const modal =
                document.getElementById('successModal');

            if (
                modal &&
                event.target === modal
            ) {
                closeSuccessModal();
            }

        });

    </script>

</x-app-layout>
