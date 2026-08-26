<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Import Data PPKS - SIATIS</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen">

    {{-- =====================================================
        PESAN HASIL
    ====================================================== --}}

    @if (session('success'))
        <div class="max-w-5xl mx-auto px-6 pt-6">
            <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="max-w-5xl mx-auto px-6 pt-6">
            <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg">
                {{ session('error') }}
            </div>
        </div>
    @endif


    {{-- =====================================================
        CONTAINER
    ====================================================== --}}

    <div class="max-w-5xl mx-auto px-6 py-10">

        <div class="bg-white rounded-2xl shadow-sm p-8">


            {{-- =====================================================
                HEADER
            ====================================================== --}}

            <h1 class="text-2xl font-bold text-gray-800">
                Import Data PPKS
            </h1>

            <p class="text-gray-500 mt-2">
                Ambil data dari Google Sheets ke database SIATIS.
            </p>


            {{-- =====================================================
                STATISTIK
            ====================================================== --}}

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-8">


                {{-- DATA DI DATABASE --}}

                <div class="bg-blue-50 rounded-xl p-5">

                    <p class="text-sm text-gray-500">
                        Data di Database
                    </p>

                    <p class="text-3xl font-bold text-blue-600 mt-2">
                        {{ number_format($totalImported ?? 0) }}
                    </p>

                </div>


                {{-- SISTEM IMPORT --}}

                <div class="bg-green-50 rounded-xl p-5">

                    <p class="text-sm text-gray-500">
                        Sistem Import
                    </p>

                    <p class="text-lg font-bold text-green-600 mt-3">
                        Data Baru
                    </p>

                    <p class="text-sm text-gray-500 mt-1">
                        Tidak dibatasi jumlah
                    </p>

                </div>


                {{-- STATUS --}}

                <div class="bg-yellow-50 rounded-xl p-5">

                    <p class="text-sm text-gray-500">
                        Status
                    </p>

                    <p class="text-lg font-bold text-yellow-600 mt-3">
                        Siap Import
                    </p>

                </div>

            </div>


            {{-- =====================================================
                IMPORT DATA
            ====================================================== --}}

            <div class="mt-8 border-t pt-6">

                <h2 class="text-lg font-semibold text-gray-800">
                    Import Data
                </h2>

                <p class="text-gray-500 mt-2">
                    Pilih proses yang ingin dilakukan pada data PPKS.
                </p>


                {{-- =================================================
                    TOMBOL
                ================================================== --}}

                <div class="mt-5 flex flex-wrap gap-3">


                    {{-- =============================================
                        IMPORT DATA BARU
                    ============================================== --}}

                    <form
                        action="{{ route('ppks.import.process') }}"
                        method="POST"
                    >

                        @csrf

                        <button
                            type="submit"
                            class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition"
                        >
                            Import Data Baru
                        </button>

                    </form>


                    {{-- =============================================
                        CEK ULANG SEMUA DATA
                    ============================================== --}}

                    <form
                        action="{{ route('ppks.import.recheck') }}"
                        method="POST"
                    >

                        @csrf

                        <button
                            type="submit"
                            class="px-6 py-3 bg-yellow-500 text-white font-semibold rounded-lg hover:bg-yellow-600 transition"
                        >
                            Cek Ulang Semua Data
                        </button>

                    </form>

                </div>


                {{-- =================================================
                    KETERANGAN
                ================================================== --}}

                <div class="mt-4 space-y-2 text-sm">

                    <p class="text-gray-500">
                        <span class="font-semibold text-blue-600">
                            Import Data Baru:
                        </span>
                        hanya mengambil data yang belum ada di database.
                    </p>

                    <p class="text-gray-500">
                        <span class="font-semibold text-yellow-600">
                            Cek Ulang Semua Data:
                        </span>
                        memeriksa kembali seluruh data yang sudah ada
                        dengan data di Google Sheets.
                    </p>

                </div>

            </div>


            {{-- =====================================================
                RIWAYAT IMPORT
            ====================================================== --}}

            <div class="mt-8 border-t pt-6">

                <h2 class="text-lg font-semibold text-gray-800">
                    Riwayat Import
                </h2>

                <p class="text-gray-500 mt-2">
                    Riwayat proses import dan pengecekan data PPKS dari Google Sheets.
                </p>


                {{-- =================================================
                    TABLE
                ================================================== --}}

                <div class="mt-5 overflow-x-auto">

                    <table class="w-full text-sm text-left border-collapse">


                        {{-- =================================================
                            HEADER TABLE
                        ================================================== --}}

                        <thead>

                            <tr class="bg-gray-50 border-b">

                                <th class="px-4 py-3 font-semibold text-gray-700">
                                    Tanggal & Waktu
                                </th>

                                <th class="px-4 py-3 font-semibold text-gray-700 text-center">
                                    Data
                                </th>

                                <th class="px-4 py-3 font-semibold text-gray-700 text-center">
                                    Normal
                                </th>

                                <th class="px-4 py-3 font-semibold text-gray-700 text-center">
                                    Perlu Diperiksa
                                </th>

                                <th class="px-4 py-3 font-semibold text-gray-700 text-center">
                                    Update
                                </th>

                                <th class="px-4 py-3 font-semibold text-gray-700 text-center">
                                    Status
                                </th>

                            </tr>

                        </thead>


                        {{-- =================================================
                            BODY TABLE
                        ================================================== --}}

                        <tbody>

                            @forelse (($importLogs ?? collect()) as $log)

                                <tr class="border-b hover:bg-gray-50">


                                    {{-- TANGGAL --}}

                                    <td class="px-4 py-3 text-gray-700 whitespace-nowrap">

                                        {{ $log->started_at?->format('d-m-Y H:i:s') ?? '-' }}

                                    </td>


                                    {{-- DATA DITEMUKAN --}}

                                    <td class="px-4 py-3 text-center">

                                        {{ number_format($log->data_ditemukan ?? 0) }}

                                    </td>


                                    {{-- NORMAL --}}

                                    <td class="px-4 py-3 text-center">

                                        <span class="font-semibold text-green-600">

                                            {{ number_format($log->data_normal ?? 0) }}

                                        </span>

                                    </td>


                                    {{-- PERLU DIPERIKSA --}}

                                    <td class="px-4 py-3 text-center">

                                        <span class="font-semibold text-yellow-600">

                                            {{ number_format($log->data_perlu_diperiksa ?? 0) }}

                                        </span>

                                    </td>


                                    {{-- UPDATE --}}

                                    <td class="px-4 py-3 text-center">

                                        {{ number_format($log->data_diupdate ?? 0) }}

                                    </td>


                                    {{-- STATUS --}}

                                    <td class="px-4 py-3 text-center">

                                        @if ($log->status === 'berhasil')

                                            <span
                                                class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700"
                                            >
                                                Berhasil
                                            </span>

                                        @elseif ($log->status === 'gagal')

                                            <span
                                                class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700"
                                            >
                                                Gagal
                                            </span>

                                        @else

                                            <span
                                                class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700"
                                            >
                                                Proses
                                            </span>

                                        @endif

                                    </td>

                                </tr>


                            @empty

                                {{-- =================================================
                                    BELUM ADA LOG
                                ================================================== --}}

                                <tr>

                                    <td
                                        colspan="6"
                                        class="px-4 py-8 text-center text-gray-500"
                                    >
                                        Belum ada riwayat import.
                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>


        </div>

    </div>

</body>

</html>
