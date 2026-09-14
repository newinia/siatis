<x-app-layout>

    <div class="main-page">

        {{-- =========================================================
        HEADER
        ========================================================== --}}
        <div class="main-page-header">

            <div>
                <h1>Tambah Data PPKS Manual</h1>

                <p>
                    Tambahkan data PPKS yang diperoleh secara langsung
                    dan tidak melalui Google Form.
                </p>
            </div>

            <a href="{{ route('ppks.normal') }}" class="back-button">
                <span class="material-symbols-outlined">
                    arrow_back
                </span>
                Kembali
            </a>

        </div>


        {{-- =========================================================
        ERROR VALIDATION
        ========================================================== --}}
        @if ($errors->any())

            <div class="alert-error">

                <div class="alert-icon">
                    <span class="material-symbols-outlined">
                        error
                    </span>
                </div>

                <div>
                    <strong>Data belum dapat disimpan.</strong>

                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>

            </div>

        @endif


        {{-- =========================================================
        SUCCESS MESSAGE
        ========================================================== --}}
        @if (session('success'))

            <div class="alert-success">

                <div class="alert-icon">
                    <span class="material-symbols-outlined">
                        check_circle
                    </span>
                </div>

                <div>
                    {{ session('success') }}
                </div>

            </div>

        @endif


        {{-- =========================================================
        FORM
        ========================================================== --}}
        <form
            method="POST"
            action="{{ route('ppks.normal.store') }}"
            class="manual-form"
            enctype="multipart/form-data"
        >

            @csrf


            {{-- =====================================================
            INFORMASI PENGINPUT
            ====================================================== --}}
            <div class="form-section">

                <div class="section-title">

                    <span class="material-symbols-outlined">
                        person_add
                    </span>

                    <div>
                        <h2>Informasi Penginput</h2>

                        <p>
                            Pilih admin yang memasukkan data PPKS.
                        </p>
                    </div>

                </div>


                <div class="form-grid">

                    <div class="form-group full">

                        <label>
                            Diinput oleh <span>*</span>
                        </label>

                        <select
                            name="diinput_oleh"
                            required
                        >

                            <option value="">
                                Pilih admin
                            </option>

                            @foreach ($admins as $admin)

                                <option
                                    value="{{ $admin->id }}"
                                    @selected(old('diinput_oleh') == $admin->id)
                                >
                                    {{ $admin->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                </div>

            </div>


            {{-- =====================================================
            IDENTITAS
            ====================================================== --}}
            <div class="form-section">

                <div class="section-title">

                    <span class="material-symbols-outlined">
                        person
                    </span>

                    <div>
                        <h2>Identitas PPKS</h2>

                        <p>
                            Informasi dasar calon PPKS.
                        </p>
                    </div>

                </div>


                <div class="form-grid">

                    <div class="form-group full">

                        <label>
                            Nama Lengkap <span>*</span>
                        </label>

                        <input
                            type="text"
                            name="nama_lengkap"
                            value="{{ old('nama_lengkap') }}"
                            placeholder="Masukkan nama lengkap"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label>
                            Nomor Induk Kependudukan (NIK) <span>*</span>
                        </label>

                        <input
                            type="text"
                            name="nik"
                            value="{{ old('nik') }}"
                            placeholder="Masukkan NIK"
                            maxlength="16"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label>
                            Jenis Kelamin <span>*</span>
                        </label>

                        <select
                            name="jenis_kelamin"
                            required
                        >

                            <option value="">
                                Pilih jenis kelamin
                            </option>

                            <option
                                value="Laki-laki"
                                @selected(old('jenis_kelamin') === 'Laki-laki')
                            >
                                Laki-laki
                            </option>

                            <option
                                value="Perempuan"
                                @selected(old('jenis_kelamin') === 'Perempuan')
                            >
                                Perempuan
                            </option>

                        </select>

                    </div>


                    <div class="form-group">

                        <label>
                            Tempat Lahir
                        </label>

                        <input
                            type="text"
                            name="tempat_lahir"
                            value="{{ old('tempat_lahir') }}"
                            placeholder="Contoh: Bogor"
                        >

                    </div>


                    <div class="form-group">

                        <label>
                            Tanggal Lahir
                        </label>

                        <input
                            type="date"
                            name="tanggal_lahir"
                            value="{{ old('tanggal_lahir') }}"
                        >

                    </div>


                    <div class="form-group">

                        <label>
                            Usia
                        </label>

                        <input
                            type="number"
                            name="usia"
                            value="{{ old('usia') }}"
                            min="0"
                            max="150"
                            placeholder="Isi angka saja"
                        >

                    </div>

                </div>

            </div>


            {{-- =====================================================
            ALAMAT
            ====================================================== --}}
            <div class="form-section">

                <div class="section-title">

                    <span class="material-symbols-outlined">
                        location_on
                    </span>

                    <div>
                        <h2>Alamat Domisili</h2>

                        <p>
                            Alamat lengkap sesuai domisili tempat tinggal.
                        </p>
                    </div>

                </div>


                <div class="form-grid">

                    <div class="form-group full">

                        <label>
                            Alamat Lengkap sesuai domisili tempat tinggal
                        </label>

                        <textarea
                            name="alamat_lengkap"
                            rows="3"
                            placeholder="Masukkan alamat lengkap sesuai domisili"
                        >{{ old('alamat_lengkap') }}</textarea>

                    </div>


                    <div class="form-group">

                        <label>
                            Provinsi
                        </label>

                        <input
                            type="text"
                            name="provinsi"
                            value="{{ old('provinsi') }}"
                            placeholder="Contoh: Jawa Barat"
                        >

                    </div>


                    <div class="form-group">

                        <label>
                            Kota/Kabupaten
                        </label>

                        <input
                            type="text"
                            name="kabupaten"
                            value="{{ old('kabupaten') }}"
                            placeholder="Contoh: Kabupaten Bogor"
                        >

                    </div>


                    <div class="form-group">

                        <label>
                            Kecamatan
                        </label>

                        <input
                            type="text"
                            name="kecamatan"
                            value="{{ old('kecamatan') }}"
                            placeholder="Kecamatan"
                        >

                    </div>


                    <div class="form-group">

                        <label>
                            Kelurahan
                        </label>

                        <input
                            type="text"
                            name="kelurahan"
                            value="{{ old('kelurahan') }}"
                            placeholder="Kelurahan/Desa"
                        >

                    </div>

                </div>

            </div>


            {{-- =====================================================
            PENDIDIKAN
            ====================================================== --}}
            <div class="form-section">

                <div class="section-title">

                    <span class="material-symbols-outlined">
                        school
                    </span>

                    <div>
                        <h2>Pendidikan</h2>

                        <p>
                            Informasi pendidikan terakhir PPKS.
                        </p>
                    </div>

                </div>


                <div class="form-grid">

                    <div class="form-group">

                        <label>
                            Pendidikan Terakhir
                        </label>

                        <input
                            type="text"
                            name="pendidikan_terakhir"
                            value="{{ old('pendidikan_terakhir') }}"
                            placeholder="Contoh: SMA"
                        >

                    </div>


                    <div class="form-group">

                        <label>
                            Keterangan pendidikan
                        </label>

                        <input
                            type="text"
                            name="keterangan_pendidikan"
                            value="{{ old('keterangan_pendidikan') }}"
                            placeholder="Contoh: Lulus tahun 2024"
                        >

                    </div>

                </div>

            </div>


            {{-- =====================================================
            INFORMASI PPKS
            ====================================================== --}}
            <div class="form-section">

                <div class="section-title">

                    <span class="material-symbols-outlined">
                        accessibility_new
                    </span>

                    <div>
                        <h2>Informasi PPKS</h2>

                        <p>
                            Informasi terkait jenis dan kebutuhan PPKS.
                        </p>
                    </div>

                </div>


                <div class="form-grid">

                    <div class="form-group full">

                        <label>
                            Jenis Pemerlu Pelayanan Kesejahteraan Sosial (PPKS)
                            <span>*</span>
                        </label>

                        <input
                            type="text"
                            name="jenis_ppks"
                            value="{{ old('jenis_ppks') }}"
                            placeholder="Masukkan jenis PPKS"
                            required
                        >

                    </div>


                    <div class="form-group full">

                        <label>
                            Keterangan Disabilitas
                        </label>

                        <textarea
                            name="keterangan_disabilitas"
                            rows="3"
                            placeholder="Jelaskan kondisi atau jenis disabilitas jika ada"
                        >{{ old('keterangan_disabilitas') }}</textarea>

                    </div>


                    <div class="form-group">

                        <label>
                            Jurusan Yang Diminati
                        </label>

                        <input
                            type="text"
                            name="jurusan_yang_diminati"
                            value="{{ old('jurusan_yang_diminati') }}"
                            placeholder="Jurusan yang diminati"
                        >

                    </div>


                    <div class="form-group">

                        <label>
                            Peminatan
                        </label>

                        <input
                            type="text"
                            name="peminatan"
                            value="{{ old('peminatan') }}"
                            placeholder="Peminatan"
                        >

                    </div>


                    <div class="form-group">

                        <label>
                            Alumni STIS
                        </label>

                        <select name="alumni_stis">

                            <option value="">
                                Pilih
                            </option>

                            <option
                                value="Ya"
                                @selected(old('alumni_stis') === 'Ya')
                            >
                                Ya
                            </option>

                            <option
                                value="Tidak"
                                @selected(old('alumni_stis') === 'Tidak')
                            >
                                Tidak
                            </option>

                        </select>

                    </div>

                </div>

            </div>


            {{-- =====================================================
            KONTAK
            ====================================================== --}}
            <div class="form-section">

                <div class="section-title">

                    <span class="material-symbols-outlined">
                        contact_phone
                    </span>

                    <div>
                        <h2>Kontak</h2>

                        <p>
                            Informasi kontak PPKS yang dapat dihubungi.
                        </p>
                    </div>

                </div>


                <div class="form-grid">

                    <div class="form-group">

                        <label>
                            Nomor HP yang bisa dihubungi 1
                            <span>*</span>
                        </label>

                        <input
                            type="text"
                            name="no_hp_1"
                            value="{{ old('no_hp_1') }}"
                            placeholder="Contoh: 081234567890"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label>
                            Nomor HP yang bisa dihubungi 2
                        </label>

                        <input
                            type="text"
                            name="no_hp_2"
                            value="{{ old('no_hp_2') }}"
                            placeholder="Nomor HP alternatif"
                        >

                    </div>


                    <div class="form-group full">

                        <label>
                            Email Address
                        </label>

                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="contoh@email.com"
                        >

                    </div>


                    <div class="form-group full">

                        <label>
                            Nomor Kartu Keluarga
                        </label>

                        <input
                            type="text"
                            name="nomor_kk"
                            value="{{ old('nomor_kk') }}"
                            placeholder="Masukkan nomor kartu keluarga"
                            maxlength="16"
                        >

                    </div>

                </div>

            </div>


            {{-- =====================================================
            INFORMASI TAMBAHAN
            ====================================================== --}}
            <div class="form-section">

                <div class="section-title">

                    <span class="material-symbols-outlined">
                        info
                    </span>

                    <div>
                        <h2>Informasi Tambahan</h2>

                        <p>
                            Informasi pendukung mengenai PPKS.
                        </p>
                    </div>

                </div>


                <div class="form-grid">

                    <div class="form-group full">

                        <label>
                            Pelatihan/Kursus yang pernah diikuti
                        </label>

                        <textarea
                            name="pelatihan_kursus"
                            rows="3"
                            placeholder="Jika tidak ada, beri tanda -"
                        >{{ old('pelatihan_kursus') }}</textarea>

                    </div>


                    <div class="form-group full">

                        <label>
                            Kemampuan dalam membaca dan menulis
                        </label>

                        <textarea
                            name="kemampuan_membaca_menulis"
                            rows="3"
                            placeholder="Jelaskan kemampuan membaca dan menulis"
                        >{{ old('kemampuan_membaca_menulis') }}</textarea>

                    </div>


                    <div class="form-group full">

                        <label>
                            Aktivitas kehidupan sehari-hari yang secara rutin dilakukan
                        </label>

                        <textarea
                            name="aktivitas_sehari_hari"
                            rows="3"
                            placeholder="Jelaskan aktivitas sehari-hari"
                        >{{ old('aktivitas_sehari_hari') }}</textarea>

                    </div>


                    <div class="form-group">

                        <label>
                            Bersedia mengikuti Pelatihan Vokasional di STIS
                        </label>

                        <select name="bersedia_pelatihan_vokasional">

                            <option value="">
                                Pilih
                            </option>

                            <option
                                value="Ya"
                                @selected(old('bersedia_pelatihan_vokasional') === 'Ya')
                            >
                                Ya
                            </option>

                            <option
                                value="Tidak"
                                @selected(old('bersedia_pelatihan_vokasional') === 'Tidak')
                            >
                                Tidak
                            </option>

                        </select>

                    </div>


                    <div class="form-group">

                        <label>
                            Kondisi kesehatan saat ini
                        </label>

                        <textarea
                            name="kondisi_kesehatan"
                            rows="3"
                            placeholder="Jelaskan kondisi kesehatan saat ini"
                        >{{ old('kondisi_kesehatan') }}</textarea>

                    </div>

                </div>

            </div>


            {{-- =====================================================
            DOKUMEN
            ====================================================== --}}
            <div class="form-section">

                <div class="section-title">

                    <span class="material-symbols-outlined">
                        upload_file
                    </span>

                    <div>
                        <h2>Dokumen Pendukung</h2>

                        <p>
                            Upload dokumen pendukung PPKS.
                        </p>
                    </div>

                </div>


                <div class="upload-info">

                    <span class="material-symbols-outlined">
                        info
                    </span>

                    <span>
                        Format yang disarankan: PDF, JPG, JPEG, PNG.
                        Video dapat menggunakan MP4, MOV, atau format video
                        lain yang sesuai.
                    </span>

                </div>


                <div class="form-grid">

                    <div class="form-group">

                        <label>
                            Upload KTP
                        </label>

                        <input
                            type="file"
                            name="upload_ktp"
                            accept=".pdf,.jpg,.jpeg,.png"
                        >

                    </div>


                    <div class="form-group">

                        <label>
                            Upload KK
                        </label>

                        <input
                            type="file"
                            name="upload_kk"
                            accept=".pdf,.jpg,.jpeg,.png"
                        >

                    </div>


                    <div class="form-group">

                        <label>
                            Upload Ijazah Terakhir
                        </label>

                        <input
                            type="file"
                            name="upload_ijazah_terakhir"
                            accept=".pdf,.jpg,.jpeg,.png"
                        >

                    </div>


                    <div class="form-group">

                        <label>
                            Upload Foto Full Badan
                        </label>

                        <input
                            type="file"
                            name="upload_foto_full_badan"
                            accept=".jpg,.jpeg,.png"
                        >

                    </div>


                    <div class="form-group full">

                        <label>
                            Upload Video
                        </label>

                        <input
                            type="file"
                            name="upload_video"
                            accept="video/*"
                        >

                        <small class="field-help">
                            Terutama bagi PPKS yang menggunakan alat bantu.
                        </small>

                    </div>


                    <div class="form-group full">

                        <label>
                            Upload Transkrip/Daftar Nilai Pendidikan Terakhir
                        </label>

                        <input
                            type="file"
                            name="upload_transkrip"
                            accept=".pdf,.jpg,.jpeg,.png"
                        >

                    </div>

                </div>

            </div>


            {{-- =====================================================
            FOOTER
            ====================================================== --}}
            <div class="form-footer">

                <a
                    href="{{ route('ppks.normal') }}"
                    class="cancel-button"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="save-button"
                    onclick="return confirm('Simpan data PPKS manual ini?')"
                >

                    <span class="material-symbols-outlined">
                        save
                    </span>

                    Simpan Data

                </button>

            </div>

        </form>

    </div>


    {{-- =============================================================
    STYLE TAMBAHAN
    Hanya untuk elemen form yang belum punya style global
    ============================================================= --}}
    <style>

        /* =========================================================
           FORM
        ========================================================= */

        .manual-form {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }


        /* =========================================================
           SECTION
        ========================================================= */

        .form-section {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 22px 24px;
        }


        /* =========================================================
           SECTION TITLE
        ========================================================= */

        .section-title {
            display: flex;
            align-items: center;
            gap: 11px;

            margin-bottom: 20px;
            padding-bottom: 14px;

            border-bottom: 1px solid var(--border);
        }

        .section-title > .material-symbols-outlined {
            display: flex;
            align-items: center;
            justify-content: center;

            width: 36px;
            height: 36px;

            border-radius: 10px;

            background: var(--blue-light);
            color: var(--blue);

            font-size: 19px;
        }

        .section-title h2 {
            margin: 0;

            color: var(--text);
            font-size: 14px;
            font-weight: 600;
        }

        .section-title p {
            margin: 3px 0 0;

            color: var(--muted);
            font-size: 10px;
        }


        /* =========================================================
           FORM GRID
        ========================================================= */

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 15px 18px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;

            min-width: 0;
        }

        .form-group.full {
            grid-column: 1 / -1;
        }


        /* =========================================================
           LABEL
        ========================================================= */

        .form-group label {
            color: var(--text-secondary);

            font-size: 10px;
            font-weight: 500;
            line-height: 1.5;
        }

        .form-group label span {
            color: var(--red);
        }


        /* =========================================================
           INPUT / SELECT / TEXTAREA
        ========================================================= */

        .form-group input,
        .form-group select,
        .form-group textarea {

            width: 100%;
            box-sizing: border-box;

            border: 1px solid var(--border);
            border-radius: 10px;

            background: var(--white);
            color: var(--text);

            font-family: inherit;
            font-size: 10px;

            outline: none;

            transition: .15s ease;
        }

        .form-group input,
        .form-group select {
            height: 36px;
            padding: 0 11px;
        }

        .form-group textarea {
            min-height: 82px;
            padding: 9px 11px;

            resize: vertical;
            line-height: 1.5;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px var(--blue-light);
        }

        .form-group input::placeholder,
        .form-group textarea::placeholder {
            color: var(--muted);
        }


        /* =========================================================
           FILE
        ========================================================= */

        .form-group input[type="file"] {
            height: auto;
            min-height: 38px;

            padding: 7px;

            background: var(--blue-light);

            cursor: pointer;
        }

        .field-help {
            color: var(--muted);
            font-size: 9px;
        }


        /* =========================================================
           UPLOAD INFO
        ========================================================= */

        .upload-info {
            display: flex;
            align-items: flex-start;
            gap: 8px;

            margin-bottom: 17px;
            padding: 10px 12px;

            border: 1px solid var(--blue-light);
            border-radius: 10px;

            background: var(--blue-light);
            color: var(--text-secondary);

            font-size: 9px;
            line-height: 1.5;
        }

        .upload-info .material-symbols-outlined {
            color: var(--blue);
            font-size: 16px;
            flex-shrink: 0;
        }


        /* =========================================================
           ALERT
        ========================================================= */

        .alert-error,
        .alert-success {
            display: flex;
            align-items: flex-start;
            gap: 10px;

            margin-bottom: 16px;
            padding: 11px 13px;

            border-radius: 10px;

            font-size: 10px;
            line-height: 1.5;
        }

        .alert-error {
            border: 1px solid var(--light-red);
            background: var(--light-red);
            color: var(--red);
        }

        .alert-success {
            border: 1px solid var(--light-green);
            background: var(--light-green);
            color: var(--green);
        }

        .alert-icon .material-symbols-outlined {
            font-size: 18px;
        }

        .alert-error strong {
            font-size: 10px;
        }

        .alert-error ul {
            margin: 4px 0 0;
            padding-left: 16px;

            font-size: 9px;
        }


        /* =========================================================
           BUTTON
        ========================================================= */

        .back-button,
        .cancel-button,
        .save-button {

            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;

            height: 34px;
            padding: 0 13px;

            border-radius: 11px;

            font-family: inherit;
            font-size: 10px;
            font-weight: 500;

            text-decoration: none;
            white-space: nowrap;

            cursor: pointer;

            transition: .15s ease;
        }

        .back-button {
            border: 1px solid var(--border);
            background: var(--white);
            color: var(--text-secondary);
        }

        .back-button:hover {
            background: var(--blue-light);
            color: var(--blue);
            border-color: var(--blue);
        }

        .cancel-button {
            border: 1px solid var(--border);
            background: var(--white);
            color: var(--text-secondary);
        }

        .cancel-button:hover {
            background: var(--blue-light);
            color: var(--blue);
        }

        .save-button {
            border: 1px solid var(--blue);
            background: var(--blue);
            color: var(--white);
        }

        .save-button:hover {
            opacity: .9;
        }

        .back-button .material-symbols-outlined,
        .save-button .material-symbols-outlined {
            font-size: 16px;
        }


        /* =========================================================
           FOOTER
        ========================================================= */

        .form-footer {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 8px;

            padding-top: 2px;
        }


        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media (max-width: 768px) {

            .main-page {
                padding-left: 18px;
                padding-right: 18px;
            }

            .main-page-header {
                align-items: flex-start;
            }

            .manual-header {
                flex-direction: column;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-group.full {
                grid-column: auto;
            }

            .form-section {
                padding: 18px;
            }

            .form-footer {
                justify-content: stretch;
            }

            .cancel-button,
            .save-button {
                flex: 1;
            }

        }


        @media (max-width: 520px) {

            .main-page-header {
                flex-direction: column;
            }

            .back-button {
                align-self: flex-start;
            }

            .form-footer {
                flex-direction: column;
                align-items: stretch;
            }

            .cancel-button,
            .save-button {
                width: 100%;
            }

        }

    </style>

</x-app-layout>