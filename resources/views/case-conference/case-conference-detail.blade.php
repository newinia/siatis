<x-app-layout>

    @php

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
        | FOTO
        |--------------------------------------------------------------------------
        */

        $foto =
            $data['foto']
            ?? $data['foto_ppks']
            ?? $data['pas_foto']
            ?? null;


        /*
        |--------------------------------------------------------------------------
        | PROSES INSTRUKTUR
        |--------------------------------------------------------------------------
        */

        $prosesInstruktur = $ppks->prosesPesertas
            ->where('tahap', 'instruktur')
            ->sortByDesc(function ($item) {

                return $item->tanggal_proses
                    ?? $item->created_at;

            })
            ->first();

        $catatanInstruktur =
            $prosesInstruktur?->catatan ?? '-';


        /*
        |--------------------------------------------------------------------------
        | PROSES KESEHATAN AWAL
        |--------------------------------------------------------------------------
        */

        $prosesKesehatan = $ppks->prosesPesertas
            ->where('tahap', 'kesehatan_awal')
            ->sortByDesc(function ($item) {

                return $item->tanggal_proses
                    ?? $item->created_at;

            })
            ->first();

        $catatanKesehatan =
            $prosesKesehatan?->catatan ?? '-';


        /*
        |--------------------------------------------------------------------------
        | PROSES CASE CONFERENCE
        |--------------------------------------------------------------------------
        */

        $prosesCaseConference = $ppks->prosesPesertas
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
        |
        | Database:
        | lulus       -> Form: diterima
        | tidak_lulus -> Form: tidak_diterima
        | pending     -> Form: pending
        |
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
        |
        | Prioritas:
        | 1. Data yang disimpan di ppks.data
        | 2. tanggal_proses dari record Case Conference
        |
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

                $tanggalCaseConference =
                    '';
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
        | OLD VALUE
        |--------------------------------------------------------------------------
        |
        | Jika validasi gagal, nilai yang baru dimasukkan user
        | tetap muncul di form.
        |
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
            $ppks->imported_at ?? null;

        $tanggalMasukFormatted = '-';

        if ($tanggalMasuk) {

            try {

                $tanggalMasukFormatted =
                    \Carbon\Carbon::parse(
                        $tanggalMasuk
                    )->format('d-m-Y');

            } catch (\Throwable $e) {

                $tanggalMasukFormatted =
                    '-';
            }
        }

    @endphp


    <style>

        /* =========================================================
           PAGE
        ========================================================= */

        .participant-detail-page {
            width: 100%;
            padding: 25px 30px 50px;
            color: #172018;
        }


        /* =========================================================
           PROGRESS
        ========================================================= */

        .participant-progress {
            width: 100%;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            margin-bottom: 35px;
        }

        .progress-step {
            display: flex;
            flex-direction: column;
            align-items: center;
            min-width: 125px;
        }

        .progress-circle {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            border: 2px solid #cbd5ce;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
        }

        .progress-step.completed .progress-circle {
            background: #2f6f45;
            border-color: #2f6f45;
        }

        .progress-step.current .progress-circle {
            background: #ffffff;
            border: 7px solid #2f6f45;
        }

        .progress-label {
            margin-top: 9px;
            text-align: center;
            font-size: 13px;
            line-height: 1.35;
            color: #647067;
            font-weight: 500;
        }

        .progress-step.completed .progress-label,
        .progress-step.current .progress-label {
            color: #1d2b21;
            font-weight: 600;
        }

        .progress-line {
            width: 90px;
            height: 3px;
            background: #d9e0db;
            margin-top: 16px;
        }

        .progress-line.completed {
            background: #2f6f45;
        }


        /* =========================================================
           CARD
        ========================================================= */

        .participant-detail-card {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 18px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, .06);
            border: 1px solid #edf1ed;
            box-sizing: border-box;
        }


        /* =========================================================
           BACK BUTTON
        ========================================================= */

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            color: #496052;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 25px;
        }

        .btn-back:hover {
            color: #2f6f45;
        }

        .btn-back .material-symbols-outlined {
            font-size: 21px;
        }


        /* =========================================================
           SECTION
        ========================================================= */

        .detail-section {
            padding: 25px 0;
            border-bottom: 1px solid #edf0ed;
        }

        .detail-section:first-of-type {
            padding-top: 0;
        }

        .detail-section:last-of-type {
            border-bottom: none;
        }

        .detail-section-title {
            font-size: 18px;
            font-weight: 700;
            color: #233228;
            margin-bottom: 22px;
        }


        /* =========================================================
           PROFILE
        ========================================================= */

        .participant-profile-layout {
            display: grid;
            grid-template-columns: 180px 1fr;
            gap: 30px;
        }

        .participant-photo-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .participant-photo {
            width: 150px;
            height: 190px;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #dce4de;
            background: #f4f7f4;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .participant-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .participant-photo-placeholder {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #9aa69e;
            text-align: center;
            padding: 15px;
        }

        .participant-photo-placeholder .material-symbols-outlined {
            font-size: 48px;
            margin-bottom: 5px;
        }

        .participant-photo-placeholder span:last-child {
            font-size: 12px;
        }

        .participant-import-info {
            margin-top: 10px;
            text-align: center;
            font-size: 11px;
            color: #7b877f;
        }

        .participant-import-info strong {
            display: block;
            color: #4b5c50;
            margin-top: 3px;
        }


        /* =========================================================
           DATA GRID
        ========================================================= */

        .participant-data-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px 22px;
        }

        .detail-field {
            display: flex;
            flex-direction: column;
            gap: 7px;
        }

        .detail-field label {
            font-size: 13px;
            font-weight: 600;
            color: #536158;
        }

        .detail-field input,
        .detail-field select,
        .detail-field textarea {
            width: 100%;
            border: 1px solid #d8e0da;
            border-radius: 9px;
            background: #ffffff;
            padding: 11px 13px;
            font-family: inherit;
            font-size: 14px;
            color: #27352c;
            outline: none;
            box-sizing: border-box;
        }

        .detail-field input:focus,
        .detail-field select:focus,
        .detail-field textarea:focus {
            border-color: #6f9d7c;
            box-shadow: 0 0 0 3px rgba(79, 125, 91, .08);
        }

        .detail-field input[readonly],
        .detail-field textarea[readonly] {
            background: #f7f9f7;
            color: #4f5c53;
        }

        .detail-field textarea {
            min-height: 120px;
            resize: vertical;
        }


        /* =========================================================
           ASSESSMENT GRID
        ========================================================= */

        .assessment-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px 25px;
        }

        .wave-year-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }


        /* =========================================================
           BUTTON
        ========================================================= */

        .form-action {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 12px;
            margin-top: 25px;
        }

        .btn-save,
        .btn {
            min-width: 120px;
            padding: 11px 20px;
            border-radius: 9px;
            font-family: inherit;
            font-size: 14px;
            font-weight: 600;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            transition: .2s ease;
        }

        .btn-save {
            border: 1px solid #2f6f45;
            background: #2f6f45;
            color: #ffffff;
        }

        .btn-save:hover {
            background: #255a37;
        }

        .btn {
            border: 1px solid #d5ddd7;
            background: #ffffff;
            color: #2f6f45;
        }

        .btn:hover {
            background: #f3f7f3;
        }


        /* =========================================================
           ERROR
        ========================================================= */

        .validation-error {
            margin-bottom: 20px;
            padding: 13px 16px;
            border-radius: 9px;
            background: #fff3f3;
            border: 1px solid #f1cccc;
            color: #a33a3a;
            font-size: 13px;
        }

        .validation-error ul {
            margin: 6px 0 0 18px;
            padding: 0;
        }


        /* =========================================================
           MODAL
        ========================================================= */

        .save-modal-overlay {
            position: fixed;
            inset: 0;
            z-index: 9999;
            background: rgba(20, 30, 23, .45);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .save-modal {
            width: 100%;
            max-width: 400px;
            background: #ffffff;
            border-radius: 18px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 15px 50px rgba(0, 0, 0, .18);
        }

        .save-modal-icon {
            width: 65px;
            height: 65px;
            margin: 0 auto 15px;
            border-radius: 50%;
            background: #eaf5ed;
            color: #2f6f45;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .save-modal-icon .material-symbols-outlined {
            font-size: 38px;
        }

        .save-modal-title {
            margin: 0 0 8px;
            font-size: 21px;
            color: #26352b;
        }

        .save-modal-message {
            margin: 0 0 22px;
            font-size: 14px;
            color: #667169;
            line-height: 1.5;
        }

        .save-modal-button {
            min-width: 100px;
            border: none;
            border-radius: 8px;
            background: #2f6f45;
            color: #ffffff;
            padding: 10px 20px;
            font-family: inherit;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
        }

        .save-modal-button:hover {
            background: #255a37;
        }


        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media (max-width: 900px) {

            .participant-profile-layout {
                grid-template-columns: 1fr;
            }

            .participant-photo-wrapper {
                align-items: flex-start;
            }

            .participant-data-grid,
            .assessment-grid {
                grid-template-columns: 1fr;
            }

            .progress-line {
                width: 45px;
            }

            .progress-step {
                min-width: 95px;
            }
        }


        @media (max-width: 650px) {

            .participant-detail-page {
                padding: 15px;
            }

            .participant-detail-card {
                padding: 20px;
            }

            .participant-progress {
                justify-content: flex-start;
                overflow-x: auto;
                padding-bottom: 10px;
            }

            .progress-step {
                min-width: 85px;
            }

            .progress-label {
                font-size: 11px;
            }

            .progress-line {
                width: 25px;
            }

            .wave-year-group {
                grid-template-columns: 1fr;
            }

            .form-action {
                flex-direction: column-reverse;
                align-items: stretch;
            }

            .btn-save,
            .btn {
                width: 100%;
            }
        }

    </style>


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
                    Data Calon<br>
                    PPKS
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
                    Asesmen<br>
                    Instruktur
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
                    Asesmen Kesehatan<br>
                    Awal
                </span>

            </div>


            <div class="progress-line completed"></div>


            {{-- CASE CONFERENCE --}}

            <div class="progress-step current">

                <div class="progress-circle"></div>

                <span class="progress-label">
                    Case<br>
                    Conference
                </span>

            </div>


            <div class="progress-line"></div>


            {{-- KESEHATAN LANJUTAN --}}

            <div class="progress-step">

                <div class="progress-circle"></div>

                <span class="progress-label">
                    Kesehatan<br>
                    Lanjutan
                </span>

            </div>

        </section>


        {{-- =====================================================
        FORM UTAMA
        ====================================================== --}}

        <form
            class="participant-detail-card"
            method="POST"
            action="{{ route(
                'ppks.normal.case-conference.update',
                ['ppks' => $ppks->id]
            ) }}"
        >

            @csrf


            {{-- =================================================
            ERROR VALIDASI
            ================================================== --}}

            @if ($errors->any())

                <div class="validation-error">

                    <strong>
                        Data belum dapat disimpan.
                    </strong>

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

                            @if ($foto)

                                <img
                                    src="{{ $foto }}"
                                    alt="Foto {{ $nama }}"
                                >

                            @else

                                <div class="participant-photo-placeholder">

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
                                Data masuk :
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
            CATATAN KESEHATAN
            ================================================== --}}

            <div class="detail-section">

                <div class="detail-field">

                    <label for="catatan_kesehatan">
                        Catatan Kesehatan
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
                        </label>

                        <select
                            id="hasil_case_conference"
                            name="hasil_case_conference"
                            required
                        >

                            <option value="">
                                Pilih Hasil Case Conference
                            </option>


                            <option
                                value="diterima"
                                @selected(
                                    $formHasilCaseConference === 'diterima'
                                )
                            >
                                Diterima
                            </option>


                            <option
                                value="tidak_diterima"
                                @selected(
                                    $formHasilCaseConference === 'tidak_diterima'
                                )
                            >
                                Tidak Diterima
                            </option>


                            <option
                                value="pending"
                                @selected(
                                    $formHasilCaseConference === 'pending'
                                )
                            >
                                Pending
                            </option>

                        </select>

                    </div>


                    {{-- JURUSAN DITERIMA --}}

                    <div class="detail-field">

                        <label for="jurusan_diterima">
                            Jurusan Diterima
                        </label>

                        <select
                            id="jurusan_diterima"
                            name="jurusan_diterima"
                        >

                            <option value="">
                                Pilih Jurusan
                            </option>


                            <option
                                value="desain_grafis"
                                @selected(
                                    $formJurusanDiterima === 'desain_grafis'
                                )
                            >
                                Desain Grafis
                            </option>


                            <option
                                value="komputer"
                                @selected(
                                    $formJurusanDiterima === 'komputer'
                                )
                            >
                                Komputer
                            </option>


                            <option
                                value="menjahit"
                                @selected(
                                    $formJurusanDiterima === 'menjahit'
                                )
                            >
                                Menjahit
                            </option>


                            <option
                                value="barista"
                                @selected(
                                    $formJurusanDiterima === 'barista'
                                )
                            >
                                Barista
                            </option>


                            <option
                                value="kuliner"
                                @selected(
                                    $formJurusanDiterima === 'kuliner'
                                )
                            >
                                Kuliner
                            </option>

                        </select>

                    </div>


                    {{-- TANGGAL CASE CONFERENCE --}}

                    <div class="detail-field">

                        <label for="tanggal_case_conference">
                            Tanggal Case Conference
                        </label>

                        <input
                            type="date"
                            id="tanggal_case_conference"
                            name="tanggal_case_conference"
                            value="{{ $formTanggalCaseConference }}"
                        >

                    </div>


                    {{-- GELOMBANG & TAHUN --}}

                    <div class="detail-field">

                        <label>
                            Gelombang & Tahun Pelatihan
                        </label>


                        <div class="wave-year-group">


                            {{-- GELOMBANG --}}

                            <select
                                id="gelombang_pelatihan"
                                name="gelombang_pelatihan"
                            >

                                <option value="">
                                    Pilih Gelombang
                                </option>


                                <option
                                    value="1"
                                    @selected(
                                        (string) $formGelombangPelatihan === '1'
                                    )
                                >
                                    Gelombang 1
                                </option>


                                <option
                                    value="2"
                                    @selected(
                                        (string) $formGelombangPelatihan === '2'
                                    )
                                >
                                    Gelombang 2
                                </option>

                            </select>


                            {{-- TAHUN --}}

                            <select
                                id="tahun_pelatihan"
                                name="tahun_pelatihan"
                            >

                                <option value="">
                                    Tahun
                                </option>


                                <option
                                    value="2026"
                                    @selected(
                                        (string) $formTahunPelatihan === '2026'
                                    )
                                >
                                    2026
                                </option>


                                <option
                                    value="2027"
                                    @selected(
                                        (string) $formTahunPelatihan === '2027'
                                    )
                                >
                                    2027
                                </option>


                                <option
                                    value="2028"
                                    @selected(
                                        (string) $formTahunPelatihan === '2028'
                                    )
                                >
                                    2028
                                </option>

                            </select>

                        </div>

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
                        placeholder="Masukkan catatan tambahan (opsional)"
                    >{{ $formCatatanCaseConference }}</textarea>

                </div>

            </div>


            {{-- =================================================
            BUTTON
            ================================================== --}}

            <div class="form-action">

                <button
                    type="submit"
                    class="btn-save"
                >
                    Simpan
                </button>


                <a
                    href="{{ route(
                        'ppks.normal.asesmen-kesehatan.lanjutan-detail',
                        ['ppks' => $ppks->id]
                    ) }}"
                    class="btn"
                >
                    Selanjutnya
                </a>

            </div>

        </form>


        {{-- =====================================================
        POPUP BERHASIL
        ====================================================== --}}

        @if (session('success'))

            <div
                x-data="{ show: true }"
                x-show="show"
                class="save-modal-overlay"
            >

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
                        @click="show = false"
                    >
                        OK
                    </button>

                </div>

            </div>

        @endif

    </div>

</x-app-layout>
