<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Data PPKS
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Perbarui seluruh data PPKS yang sebelumnya ditambahkan secara manual.
            </p>
        </div>
    </x-slot>

    <div class="py-6">

        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            {{-- ERROR --}}
            @if($errors->any())
                <div class="mb-5 rounded-lg bg-red-50 border border-red-200 px-4 py-3">
                    <ul class="list-disc list-inside text-red-700 text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg">

                <div class="p-6">

                    <form
                        method="POST"
                        action="{{ route('ppks.normal.update', $ppks) }}"
                        enctype="multipart/form-data"
                    >

                        @csrf
                        @method('PUT')


                        {{-- =====================================================
                        IDENTITAS
                        ====================================================== --}}

                        <div class="mb-8">

                            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                                Identitas
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Nama Lengkap
                                    </label>

                                    <input
                                        type="text"
                                        name="nama_lengkap"
                                        value="{{ old('nama_lengkap', $ppks->data['nama_lengkap'] ?? '') }}"
                                        required
                                        class="w-full rounded-lg border-gray-300"
                                    >
                                </div>


                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        NIK
                                    </label>

                                    <input
                                        type="text"
                                        name="nik"
                                        value="{{ old('nik', $ppks->data['nik'] ?? '') }}"
                                        required
                                        class="w-full rounded-lg border-gray-300"
                                    >
                                </div>


                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Jenis Kelamin
                                    </label>

                                    <input
                                        type="text"
                                        name="jenis_kelamin"
                                        value="{{ old('jenis_kelamin', $ppks->data['jenis_kelamin'] ?? '') }}"
                                        required
                                        class="w-full rounded-lg border-gray-300"
                                    >
                                </div>


                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Tempat Lahir
                                    </label>

                                    <input
                                        type="text"
                                        name="tempat_lahir"
                                        value="{{ old('tempat_lahir', $ppks->data['tempat_lahir'] ?? '') }}"
                                        class="w-full rounded-lg border-gray-300"
                                    >
                                </div>


                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Tanggal Lahir
                                    </label>

                                    <input
                                        type="date"
                                        name="tanggal_lahir"
                                        value="{{ old('tanggal_lahir', $ppks->data['tanggal_lahir'] ?? '') }}"
                                        class="w-full rounded-lg border-gray-300"
                                    >
                                </div>


                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Usia
                                    </label>

                                    <input
                                        type="number"
                                        name="usia"
                                        value="{{ old('usia', $ppks->data['usia'] ?? '') }}"
                                        min="0"
                                        max="150"
                                        class="w-full rounded-lg border-gray-300"
                                    >
                                </div>

                            </div>

                        </div>


                        {{-- =====================================================
                        ALAMAT
                        ====================================================== --}}

                        <div class="mb-8">

                            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                                Alamat
                            </h3>

                            <div class="space-y-5">

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Alamat Lengkap sesuai domisili
                                    </label>

                                    <textarea
                                        name="alamat_lengkap"
                                        rows="3"
                                        class="w-full rounded-lg border-gray-300"
                                    >{{ old('alamat_lengkap', $ppks->data['alamat_lengkap'] ?? '') }}</textarea>
                                </div>


                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Provinsi
                                        </label>

                                        <input
                                            type="text"
                                            name="provinsi"
                                            value="{{ old('provinsi', $ppks->data['provinsi'] ?? '') }}"
                                            class="w-full rounded-lg border-gray-300"
                                        >
                                    </div>


                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Kota/Kabupaten
                                        </label>

                                        <input
                                            type="text"
                                            name="kabupaten"
                                            value="{{ old('kabupaten', $ppks->data['kabupaten'] ?? '') }}"
                                            class="w-full rounded-lg border-gray-300"
                                        >
                                    </div>


                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Kecamatan
                                        </label>

                                        <input
                                            type="text"
                                            name="kecamatan"
                                            value="{{ old('kecamatan', $ppks->data['kecamatan'] ?? '') }}"
                                            class="w-full rounded-lg border-gray-300"
                                        >
                                    </div>


                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Kelurahan
                                        </label>

                                        <input
                                            type="text"
                                            name="kelurahan"
                                            value="{{ old('kelurahan', $ppks->data['kelurahan'] ?? '') }}"
                                            class="w-full rounded-lg border-gray-300"
                                        >
                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- =====================================================
                        PENDIDIKAN & PPKS
                        ====================================================== --}}

                        <div class="mb-8">

                            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                                Pendidikan & PPKS
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Pendidikan Terakhir
                                    </label>

                                    <input
                                        type="text"
                                        name="pendidikan_terakhir"
                                        value="{{ old('pendidikan_terakhir', $ppks->data['pendidikan_terakhir'] ?? '') }}"
                                        class="w-full rounded-lg border-gray-300"
                                    >
                                </div>


                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Jenis PPKS
                                    </label>

                                    <input
                                        type="text"
                                        name="jenis_ppks"
                                        value="{{ old('jenis_ppks', $ppks->data['jenis_ppks'] ?? '') }}"
                                        required
                                        class="w-full rounded-lg border-gray-300"
                                    >
                                </div>


                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Jurusan yang Diminati
                                    </label>

                                    <input
                                        type="text"
                                        name="jurusan_yang_diminati"
                                        value="{{ old('jurusan_yang_diminati', $ppks->data['jurusan_yang_diminati'] ?? '') }}"
                                        class="w-full rounded-lg border-gray-300"
                                    >
                                </div>


                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Peminatan
                                    </label>

                                    <input
                                        type="text"
                                        name="peminatan"
                                        value="{{ old('peminatan', $ppks->data['peminatan'] ?? '') }}"
                                        class="w-full rounded-lg border-gray-300"
                                    >
                                </div>


                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Alumni STIS
                                    </label>

                                    <input
                                        type="text"
                                        name="alumni_stis"
                                        value="{{ old('alumni_stis', $ppks->data['alumni_stis'] ?? '') }}"
                                        class="w-full rounded-lg border-gray-300"
                                    >
                                </div>

                            </div>

                        </div>


                        {{-- =====================================================
                        KONTAK
                        ====================================================== --}}

                        <div class="mb-8">

                            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                                Kontak
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Nomor HP 1
                                    </label>

                                    <input
                                        type="text"
                                        name="no_hp_1"
                                        value="{{ old('no_hp_1', $ppks->data['no_hp_1'] ?? '') }}"
                                        required
                                        class="w-full rounded-lg border-gray-300"
                                    >
                                </div>


                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Nomor HP 2
                                    </label>

                                    <input
                                        type="text"
                                        name="no_hp_2"
                                        value="{{ old('no_hp_2', $ppks->data['no_hp_2'] ?? '') }}"
                                        class="w-full rounded-lg border-gray-300"
                                    >
                                </div>


                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Email
                                    </label>

                                    <input
                                        type="email"
                                        name="email"
                                        value="{{ old('email', $ppks->data['email'] ?? '') }}"
                                        class="w-full rounded-lg border-gray-300"
                                    >
                                </div>


                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Nomor Kartu Keluarga
                                    </label>

                                    <input
                                        type="text"
                                        name="nomor_kartu_keluarga"
                                        value="{{ old('nomor_kartu_keluarga', $ppks->data['nomor_kartu_keluarga'] ?? '') }}"
                                        class="w-full rounded-lg border-gray-300"
                                    >
                                </div>

                            </div>

                        </div>


                        {{-- =====================================================
                        INFORMASI TAMBAHAN
                        ====================================================== --}}

                        <div class="mb-8">

                            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                                Informasi Tambahan
                            </h3>

                            <div class="space-y-5">

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Keterangan Pendidikan
                                    </label>

                                    <textarea
                                        name="keterangan_pendidikan"
                                        rows="3"
                                        class="w-full rounded-lg border-gray-300"
                                    >{{ old('keterangan_pendidikan', $ppks->data['keterangan_pendidikan'] ?? '') }}</textarea>
                                </div>


                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Keterangan Disabilitas
                                    </label>

                                    <textarea
                                        name="keterangan_disabilitas"
                                        rows="3"
                                        class="w-full rounded-lg border-gray-300"
                                    >{{ old('keterangan_disabilitas', $ppks->data['keterangan_disabilitas'] ?? '') }}</textarea>
                                </div>


                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Pelatihan / Kursus
                                    </label>

                                    <textarea
                                        name="pelatihan_kursus"
                                        rows="3"
                                        class="w-full rounded-lg border-gray-300"
                                    >{{ old('pelatihan_kursus', $ppks->data['pelatihan_kursus'] ?? '') }}</textarea>
                                </div>


                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Kemampuan Membaca dan Menulis
                                    </label>

                                    <textarea
                                        name="kemampuan_membaca_menulis"
                                        rows="3"
                                        class="w-full rounded-lg border-gray-300"
                                    >{{ old('kemampuan_membaca_menulis', $ppks->data['kemampuan_membaca_menulis'] ?? '') }}</textarea>
                                </div>


                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Aktivitas Kehidupan Sehari-hari
                                    </label>

                                    <textarea
                                        name="aktivitas_sehari_hari"
                                        rows="3"
                                        class="w-full rounded-lg border-gray-300"
                                    >{{ old('aktivitas_sehari_hari', $ppks->data['aktivitas_sehari_hari'] ?? '') }}</textarea>
                                </div>


                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Bersedia Mengikuti Pelatihan Vokasional
                                    </label>

                                    <input
                                        type="text"
                                        name="bersedia_pelatihan_vokasional"
                                        value="{{ old('bersedia_pelatihan_vokasional', $ppks->data['bersedia_pelatihan_vokasional'] ?? '') }}"
                                        class="w-full rounded-lg border-gray-300"
                                    >
                                </div>


                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Kondisi Kesehatan Saat Ini
                                    </label>

                                    <textarea
                                        name="kondisi_kesehatan"
                                        rows="3"
                                        class="w-full rounded-lg border-gray-300"
                                    >{{ old('kondisi_kesehatan', $ppks->data['kondisi_kesehatan'] ?? '') }}</textarea>
                                </div>

                            </div>

                        </div>


                        {{-- =====================================================
                        DOKUMEN / FILE
                        ====================================================== --}}

                        <div class="mb-8">

                            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                                Dokumen & File
                            </h3>

                            <div class="space-y-5">


                                {{-- KTP --}}
                                <div>

                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Upload KTP
                                    </label>

                                    @if(!empty($ppks->data['upload_ktp']))

                                        <div class="mb-2 text-sm text-gray-500">
                                            File saat ini:
                                            <span class="font-medium text-gray-700">
                                                {{ basename($ppks->data['upload_ktp']) }}
                                            </span>
                                        </div>

                                    @endif

                                    <input
                                        type="file"
                                        name="upload_ktp"
                                        accept=".jpg,.jpeg,.png,.pdf"
                                        class="w-full rounded-lg border border-gray-300 p-2"
                                    >

                                    <p class="text-xs text-gray-500 mt-1">
                                        Kosongkan jika tidak ingin mengganti file.
                                    </p>

                                </div>


                                {{-- KK --}}
                                <div>

                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Upload KK
                                    </label>

                                    @if(!empty($ppks->data['upload_kk']))

                                        <div class="mb-2 text-sm text-gray-500">
                                            File saat ini:
                                            <span class="font-medium text-gray-700">
                                                {{ basename($ppks->data['upload_kk']) }}
                                            </span>
                                        </div>

                                    @endif

                                    <input
                                        type="file"
                                        name="upload_kk"
                                        accept=".jpg,.jpeg,.png,.pdf"
                                        class="w-full rounded-lg border border-gray-300 p-2"
                                    >

                                    <p class="text-xs text-gray-500 mt-1">
                                        Kosongkan jika tidak ingin mengganti file.
                                    </p>

                                </div>


                                {{-- IJAZAH --}}
                                <div>

                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Upload Ijazah Terakhir
                                    </label>

                                    @if(!empty($ppks->data['upload_ijazah_terakhir']))

                                        <div class="mb-2 text-sm text-gray-500">
                                            File saat ini:
                                            <span class="font-medium text-gray-700">
                                                {{ basename($ppks->data['upload_ijazah_terakhir']) }}
                                            </span>
                                        </div>

                                    @endif

                                    <input
                                        type="file"
                                        name="upload_ijazah_terakhir"
                                        accept=".jpg,.jpeg,.png,.pdf"
                                        class="w-full rounded-lg border border-gray-300 p-2"
                                    >

                                    <p class="text-xs text-gray-500 mt-1">
                                        Kosongkan jika tidak ingin mengganti file.
                                    </p>

                                </div>


                                {{-- FOTO FULL BADAN --}}
                                <div>

                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Upload Foto Full Badan
                                    </label>

                                    @if(!empty($ppks->data['upload_foto_full_badan']))

                                        <div class="mb-2 text-sm text-gray-500">
                                            File saat ini:
                                            <span class="font-medium text-gray-700">
                                                {{ basename($ppks->data['upload_foto_full_badan']) }}
                                            </span>
                                        </div>

                                    @endif

                                    <input
                                        type="file"
                                        name="upload_foto_full_badan"
                                        accept=".jpg,.jpeg,.png"
                                        class="w-full rounded-lg border border-gray-300 p-2"
                                    >

                                    <p class="text-xs text-gray-500 mt-1">
                                        Kosongkan jika tidak ingin mengganti file.
                                    </p>

                                </div>


                                {{-- VIDEO --}}
                                <div>

                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Upload Video
                                    </label>

                                    @if(!empty($ppks->data['upload_video']))

                                        <div class="mb-2 text-sm text-gray-500">
                                            File saat ini:
                                            <span class="font-medium text-gray-700">
                                                {{ basename($ppks->data['upload_video']) }}
                                            </span>
                                        </div>

                                    @endif

                                    <input
                                        type="file"
                                        name="upload_video"
                                        accept=".mp4,.mov,.avi,.mkv"
                                        class="w-full rounded-lg border border-gray-300 p-2"
                                    >

                                    <p class="text-xs text-gray-500 mt-1">
                                        Kosongkan jika tidak ingin mengganti file.
                                    </p>

                                </div>


                                {{-- TRANSKRIP --}}
                                <div>

                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Upload Transkrip / Daftar Nilai Pendidikan Terakhir
                                    </label>

                                    @if(!empty($ppks->data['upload_transkrip']))

                                        <div class="mb-2 text-sm text-gray-500">
                                            File saat ini:
                                            <span class="font-medium text-gray-700">
                                                {{ basename($ppks->data['upload_transkrip']) }}
                                            </span>
                                        </div>

                                    @endif

                                    <input
                                        type="file"
                                        name="upload_transkrip"
                                        accept=".jpg,.jpeg,.png,.pdf"
                                        class="w-full rounded-lg border border-gray-300 p-2"
                                    >

                                    <p class="text-xs text-gray-500 mt-1">
                                        Kosongkan jika tidak ingin mengganti file.
                                    </p>

                                </div>

                            </div>

                        </div>


                        {{-- =====================================================
                        TOMBOL
                        ====================================================== --}}

                        <div class="flex justify-end gap-3">

                            <a
                                href="{{ route('ppks.manual') }}"
                                class="px-5 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50"
                            >
                                Batal
                            </a>

                            <button
                                type="submit"
                                class="px-5 py-2 rounded-lg bg-gray-900 text-white hover:bg-gray-800"
                            >
                                Simpan Perubahan
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>
