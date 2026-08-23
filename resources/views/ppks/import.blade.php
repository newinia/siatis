<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Import Data PPKS - SIATIS</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen">

    <div class="max-w-5xl mx-auto px-6 py-10">

        <div class="bg-white rounded-2xl shadow-sm p-8">

            <h1 class="text-2xl font-bold text-gray-800">
                Import Data PPKS
            </h1>

            <p class="text-gray-500 mt-2">
                Ambil data baru dari Google Sheets ke database SIATIS.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-8">

                {{-- Jumlah data di database --}}
                <div class="bg-blue-50 rounded-xl p-5">
                    <p class="text-sm text-gray-500">
                        Data di Database
                    </p>

                    <p class="text-3xl font-bold text-blue-600 mt-2">
                        {{ $totalImported }}
                    </p>
                </div>

                {{-- Sistem import --}}
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

                {{-- Status --}}
                <div class="bg-yellow-50 rounded-xl p-5">
                    <p class="text-sm text-gray-500">
                        Status
                    </p>

                    <p class="text-lg font-bold text-yellow-600 mt-3">
                        Siap Import
                    </p>
                </div>

            </div>

            <div class="mt-8 border-t pt-6">

                <h2 class="text-lg font-semibold text-gray-800">
                    Import Data Baru
                </h2>

                <p class="text-gray-500 mt-2">
                    Sistem akan mencari dan mengambil semua data yang belum ada di database.
                </p>

                <a
                    href="{{ url('/ppks/import') }}"
                    class="inline-block mt-5 px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700"
                >
                    Import Data Baru
                </a>

            </div>

        </div>

    </div>

</body>
</html>
