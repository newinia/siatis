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
        | FOTO PPKS
        |--------------------------------------------------------------------------
        */

        $foto = $data['upload_foto_full_badan'] ?? null;


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

                $tanggalMasukFormatted =
                    '-';
            }
        }

    @endphp


    {{-- =====================================================
    PROGRESS PESERTA
    ====================================================== --}}

    <x-participant-progress :active-step="4" :stage-statuses="[
            1 => 'completed',
            2 => 'completed',
            3 => 'completed',
            4 => 'current',
            5 => 'waiting',
        ]" final-status="waiting" />


    <div class="participant-detail-page" x-data="{ showSavePopup: false }">


        {{-- =====================================================
        CONTAINER
        ====================================================== --}}

        <div class="participant-detail-container">


            {{-- =================================================
            FORM UTAMA
            ================================================== --}}

            <form class="participant-detail-card" method="POST" action="{{ route(
    'ppks.normal.case-conference.update',
    ['ppks' => $ppks->id]
) }}">

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

                <a href="{{ route(
    'ppks.normal.asesmen-kesehatan.awal',
    ['ppks' => $ppks->id]
) }}" class="btn-back">

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

                                @if (!empty($foto))

                                    <img src="{{ asset('storage/' . ltrim($foto, '/')) }}" alt="Foto {{ $nama }}"
                                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">

                                    <div class="photo-placeholder" style="display:none;">

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

                                <input type="text" value="{{ $nama }}" readonly>

                            </div>


                            {{-- NIK --}}

                            <div class="detail-field">

                                <label>
                                    NIK
                                </label>

                                <input type="text" value="{{ $nik }}" readonly>

                            </div>


                            {{-- USIA --}}

                            <div class="detail-field">

                                <label>
                                    Usia
                                </label>

                                <input type="text" value="{{ $usia }}" readonly>

                            </div>


                            {{-- JENIS KELAMIN --}}

                            <div class="detail-field">

                                <label>
                                    Jenis Kelamin
                                </label>

                                <input type="text" value="{{ $jenisKelamin }}" readonly>

                            </div>


                            {{-- TANGGAL LAHIR --}}

                            <div class="detail-field">

                                <label>
                                    Tanggal Lahir
                                </label>

                                <input type="text" value="{{ $tanggalLahirFormatted }}" readonly>

                            </div>


                            {{-- TEMPAT LAHIR --}}

                            <div class="detail-field">

                                <label>
                                    Tempat Lahir
                                </label>

                                <input type="text" value="{{ $tempatLahir }}" readonly>

                            </div>


                            {{-- JENIS PPKS --}}

                            <div class="detail-field">

                                <label>
                                    Jenis PPKS
                                </label>

                                <input type="text" value="{{ $jenisPpks }}" readonly>

                            </div>


                            {{-- JURUSAN DIMINATI --}}

                            <div class="detail-field">

                                <label>
                                    Jurusan yang Diminati
                                </label>

                                <input type="text" value="{{ $jurusanDiminati }}" readonly>

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

                        <textarea id="catatan_instruktur" name="catatan_instruktur"
                            readonly>{{ $catatanInstruktur }}</textarea>

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

                        <textarea id="catatan_kesehatan" name="catatan_kesehatan"
                            readonly>{{ $catatanKesehatan }}</textarea>

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

                            <select id="hasil_case_conference" name="hasil_case_conference" required>

                                <option value="">
                                    Pilih hasil Case Conference
                                </option>

                                <option value="diterima" @selected(
                                    $formHasilCaseConference === 'diterima'
                                )>
                                    Diterima
                                </option>

                                <option value="tidak_diterima" @selected(
                                    $formHasilCaseConference === 'tidak_diterima'
                                )>
                                    Tidak Diterima
                                </option>

                                <option value="pending" @selected(
                                    $formHasilCaseConference === 'pending'
                                )>
                                    Pending
                                </option>

                            </select>

                        </div>


                        {{-- JURUSAN PELATIHAN --}}

                        <div class="detail-field">

                            <label for="jurusan_diterima">
                                Jurusan Pelatihan
                            </label>

                            <select id="jurusan_diterima" name="jurusan_diterima">

                                <option value="">
                                    Pilih jurusan
                                </option>

                                <option value="desain_grafis" @selected(
                                    $formJurusanDiterima === 'desain_grafis'
                                )>
                                    Desain Grafis
                                </option>

                                <option value="komputer" @selected(
                                    $formJurusanDiterima === 'komputer'
                                )>
                                    Komputer
                                </option>

                                <option value="menjahit" @selected(
                                    $formJurusanDiterima === 'menjahit'
                                )>
                                    Menjahit
                                </option>

                                <option value="barista" @selected(
                                    $formJurusanDiterima === 'barista'
                                )>
                                    Barista
                                </option>

                                <option value="kuliner" @selected(
                                    $formJurusanDiterima === 'kuliner'
                                )>
                                    Kuliner
                                </option>

                            </select>

                        </div>


                        {{-- TANGGAL CASE CONFERENCE --}}

                        <div class="detail-field">

                            <label for="tanggal_case_conference">
                                Tanggal Case Conference
                            </label>

                            <input type="date" id="tanggal_case_conference" name="tanggal_case_conference"
                                value="{{ $formTanggalCaseConference }}">

                        </div>


                        {{-- GELOMBANG & TAHUN --}}

                        <div class="detail-field">

                            <label>
                                Gelombang dan Tahun Pelatihan
                            </label>


                            <div class="wave-year-group">


                                {{-- GELOMBANG --}}

                                <select id="gelombang_pelatihan" name="gelombang_pelatihan">

                                    <option value="">
                                        Pilih gelombang
                                    </option>

                                    <option value="1" @selected(
                                        (string) $formGelombangPelatihan === '1'
                                    )>
                                        Gelombang 1
                                    </option>

                                    <option value="2" @selected(
                                        (string) $formGelombangPelatihan === '2'
                                    )>
                                        Gelombang 2
                                    </option>

                                </select>


                                {{-- TAHUN --}}

                                <select id="tahun_pelatihan" name="tahun_pelatihan">

                                    <option value="">
                                        Pilih tahun
                                    </option>

                                    <option value="2026" @selected(
                                        (string) $formTahunPelatihan === '2026'
                                    )>
                                        2026
                                    </option>

                                    <option value="2027" @selected(
                                        (string) $formTahunPelatihan === '2027'
                                    )>
                                        2027
                                    </option>

                                    <option value="2028" @selected(
                                        (string) $formTahunPelatihan === '2028'
                                    )>
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

                        <textarea id="catatan_case_conference" name="catatan_case_conference"
                            placeholder="Tambahkan catatan jika diperlukan">{{ $formCatatanCaseConference }}</textarea>

                    </div>

                </div>


                {{-- =================================================
                BUTTON
                ================================================== --}}

                <div class="form-action detail-actions">


                    {{-- SIMPAN --}}

                    <button type="submit" class="btn-save">
                        Simpan
                    </button>


                    {{-- SELANJUTNYA --}}

                    <a href="{{ route(
                        'ppks.normal.kesehatan-lanjutan.detail',
                        ['ppks' => $ppks->id]
                    ) }}" class="btn-next btn-success">
                    Selanjutnya
                    </a>

                </div>

            </form>

        </div>


        {{-- =====================================================
        POPUP BERHASIL
        ====================================================== --}}

        @if (session('success'))

            <div x-data="{ show: true }" x-show="show" class="save-modal-overlay">

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


                    <button type="button" class="save-modal-button" @click="show = false">
                        OK
                    </button>

                </div>

            </div>

        @endif

    </div>

</x-app-layout>
