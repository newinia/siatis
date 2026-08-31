<x-app-layout>

    <div class="manual-page">

        {{-- =========================================================
        HEADER
        ========================================================== --}}
        <div class="manual-header">
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
            ADMIN YANG MEMASUKKAN DATA
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

                    {{-- Nama --}}
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


                    {{-- NIK --}}
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


                    {{-- Jenis Kelamin --}}
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


                    {{-- Tempat Lahir --}}
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


                    {{-- Tanggal Lahir --}}
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


                    {{-- Usia --}}
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

                    {{-- Alamat --}}
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


                    {{-- Provinsi --}}
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


                    {{-- Kota/Kabupaten --}}
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


                    {{-- Kecamatan --}}
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


                    {{-- Kelurahan --}}
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

                    {{-- Jenis PPKS --}}
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


                    {{-- Keterangan Disabilitas --}}
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


                    {{-- Jurusan --}}
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


                    {{-- Peminatan --}}
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


                    {{-- Alumni STIS --}}
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

                    {{-- HP 1 --}}
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


                    {{-- HP 2 --}}
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


                    {{-- Email --}}
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


                    {{-- Nomor KK --}}
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

                    {{-- Pelatihan --}}
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


                    {{-- Membaca Menulis --}}
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


                    {{-- Aktivitas --}}
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


                    {{-- Bersedia --}}
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


                    {{-- Kondisi kesehatan --}}
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

                    {{-- KTP --}}
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


                    {{-- KK --}}
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


                    {{-- Ijazah --}}
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


                    {{-- Foto --}}
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


                    {{-- Video --}}
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


                    {{-- Transkrip --}}
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
    STYLE
    ============================================================= --}}
    <style>

        .manual-page {
            width: 100%;
            max-width: 1120px;
            margin: 0 auto;
            padding: 30px 32px 60px;
            box-sizing: border-box;
        }

        .manual-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 25px;
        }

        .manual-header h1 {
            margin: 0;
            color: #111827;
            font-size: 25px;
            font-weight: 700;
            line-height: 1.3;
        }

        .manual-header p {
            margin: 7px 0 0;
            color: #6b7280;
            font-size: 14px;
            line-height: 1.6;
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 14px;
            border: 1px solid #dbe3ec;
            border-radius: 8px;
            background: #ffffff;
            color: #374151;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            white-space: nowrap;
            transition: .15s ease;
        }

        .back-button:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
        }

        .manual-form {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .form-section {
            padding: 25px;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            background: #ffffff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .03);
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 23px;
            padding-bottom: 16px;
            border-bottom: 1px solid #eef2f7;
        }

        .section-title > .material-symbols-outlined {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            flex: 0 0 40px;
            border-radius: 9px;
            background: #eff6ff;
            color: #2563eb;
            font-size: 21px;
        }

        .section-title h2 {
            margin: 0;
            color: #1f2937;
            font-size: 16px;
            font-weight: 700;
        }

        .section-title p {
            margin: 3px 0 0;
            color: #94a3b8;
            font-size: 12px;
            line-height: 1.5;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 7px;
            min-width: 0;
        }

        .form-group.full {
            grid-column: 1 / -1;
        }

        .form-group label {
            color: #374151;
            font-size: 13px;
            font-weight: 600;
            line-height: 1.5;
        }

        .form-group label span {
            color: #dc2626;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            box-sizing: border-box;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: #ffffff;
            color: #1f2937;
            font-family: inherit;
            font-size: 13px;
            outline: none;
            transition: border .15s ease, box-shadow .15s ease;
        }

        .form-group input,
        .form-group select {
            height: 42px;
            padding: 9px 12px;
        }

        .form-group textarea {
            min-height: 90px;
            padding: 10px 12px;
            resize: vertical;
            line-height: 1.5;
        }

        .form-group input[type="file"] {
            height: auto;
            min-height: 44px;
            padding: 8px;
            cursor: pointer;
            background: #f8fafc;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: #60a5fa;
            box-shadow: 0 0 0 3px rgba(96, 165, 250, .12);
        }

        .form-group input::placeholder,
        .form-group textarea::placeholder {
            color: #9ca3af;
        }

        .field-help {
            color: #94a3b8;
            font-size: 11px;
        }

        .upload-info {
            display: flex;
            align-items: flex-start;
            gap: 9px;
            margin-bottom: 20px;
            padding: 11px 13px;
            border: 1px solid #dbeafe;
            border-radius: 8px;
            background: #eff6ff;
            color: #475569;
            font-size: 12px;
            line-height: 1.5;
        }

        .upload-info .material-symbols-outlined {
            color: #2563eb;
            font-size: 18px;
            flex: 0 0 auto;
        }

        .alert-error,
        .alert-success {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 18px;
            padding: 14px 16px;
            border-radius: 10px;
        }

        .alert-error {
            border: 1px solid #fecaca;
            background: #fef2f2;
            color: #991b1b;
        }

        .alert-success {
            border: 1px solid #bbf7d0;
            background: #f0fdf4;
            color: #166534;
        }

        .alert-error .alert-icon .material-symbols-outlined {
            color: #dc2626;
            font-size: 21px;
        }

        .alert-success .alert-icon .material-symbols-outlined {
            color: #16a34a;
            font-size: 21px;
        }

        .alert-error strong {
            font-size: 13px;
        }

        .alert-error ul {
            margin: 6px 0 0;
            padding-left: 18px;
            font-size: 12px;
            line-height: 1.6;
        }

        .form-footer {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
            padding-top: 5px;
        }

        .cancel-button,
        .save-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            min-height: 42px;
            padding: 9px 18px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            box-sizing: border-box;
        }

        .cancel-button {
            border: 1px solid #d1d5db;
            background: #ffffff;
            color: #4b5563;
        }

        .cancel-button:hover {
            background: #f8fafc;
        }

        .save-button {
            border: 1px solid #1d4ed8;
            background: #2563eb;
            color: #ffffff;
        }

        .save-button:hover {
            background: #1d4ed8;
        }

        .save-button .material-symbols-outlined,
        .back-button .material-symbols-outlined {
            font-size: 17px;
        }

        @media (max-width: 700px) {

            .manual-page {
                padding: 22px 18px 35px;
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

            .form-footer {
                flex-direction: column-reverse;
                align-items: stretch;
            }

            .cancel-button,
            .save-button {
                width: 100%;
            }

        }

    </style>

</x-app-layout>
