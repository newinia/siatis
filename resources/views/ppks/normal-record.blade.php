<x-app-layout>

    <x-slot name="header">

        <div>

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Record Data Manual
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Daftar seluruh data PPKS yang ditambahkan secara manual.
            </p>

        </div>

    </x-slot>


    <div class="py-6">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- =====================================================
            ALERT
            ====================================================== --}}

            @if(session('success'))

                <div class="mb-5 rounded-lg bg-green-50 border border-green-200 px-4 py-3 text-green-700">

                    {{ session('success') }}

                </div>

            @endif


            @if(session('error'))

                <div class="mb-5 rounded-lg bg-red-50 border border-red-200 px-4 py-3 text-red-700">

                    {{ session('error') }}

                </div>

            @endif


            {{-- =====================================================
            CARD
            ====================================================== --}}

            <div class="bg-white shadow-sm sm:rounded-lg">

                <div class="p-6">

                    {{-- HEADER --}}

                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

                        <div>

                            <h3 class="text-lg font-semibold text-gray-800">
                                Data Manual
                            </h3>

                            <p class="text-sm text-gray-500 mt-1">
                                Data yang ditambahkan melalui menu Tambah Data.
                            </p>

                        </div>


                        <a
                            href="{{ route('ppks.normal.create') }}"
                            class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition"
                        >

                            <span class="material-symbols-outlined text-[20px]">
                                person_add
                            </span>

                            Tambah Data

                        </a>

                    </div>


                    {{-- SEARCH --}}

                    <form
                        method="GET"
                        action="{{ route('ppks.normal.record') }}"
                        class="mb-6"
                    >

                        <div class="flex gap-2">

                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Cari nama, NIK, atau admin..."
                                class="w-full rounded-lg border-gray-300 focus:border-gray-500 focus:ring-gray-500"
                            >

                            <button
                                type="submit"
                                class="px-5 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700"
                            >
                                Cari
                            </button>

                        </div>

                    </form>


                    {{-- =================================================
                    TABLE
                    ================================================== --}}

                    <div class="overflow-x-auto">

                        <table class="min-w-full text-sm">

                            <thead>

                                <tr class="border-b bg-gray-50">

                                    <th class="px-4 py-3 text-left font-semibold text-gray-600">
                                        No
                                    </th>

                                    <th class="px-4 py-3 text-left font-semibold text-gray-600">
                                        Nama
                                    </th>

                                    <th class="px-4 py-3 text-left font-semibold text-gray-600">
                                        NIK
                                    </th>

                                    <th class="px-4 py-3 text-left font-semibold text-gray-600">
                                        Jenis PPKS
                                    </th>

                                    <th class="px-4 py-3 text-left font-semibold text-gray-600">
                                        Ditambahkan Oleh
                                    </th>

                                    <th class="px-4 py-3 text-left font-semibold text-gray-600">
                                        Tanggal
                                    </th>

                                    <th class="px-4 py-3 text-center font-semibold text-gray-600">
                                        Aksi
                                    </th>

                                </tr>

                            </thead>


                            <tbody class="divide-y">

                                @forelse($records as $index => $ppks)

                                    <tr class="hover:bg-gray-50">

                                        <td class="px-4 py-4">

                                            {{
                                                $records->firstItem() + $index
                                            }}

                                        </td>


                                        <td class="px-4 py-4 font-medium text-gray-800">

                                            {{
                                                $ppks->data['nama_lengkap']
                                                ?? '-'
                                            }}

                                        </td>


                                        <td class="px-4 py-4 text-gray-600">

                                            {{
                                                $ppks->data['nik']
                                                ?? '-'
                                            }}

                                        </td>


                                        <td class="px-4 py-4 text-gray-600">

                                            {{
                                                $ppks->data['jenis_ppks']
                                                ?? '-'
                                            }}

                                        </td>


                                        <td class="px-4 py-4">

                                            <div class="font-medium text-gray-800">

                                                {{
                                                    $ppks->createdBy?->name
                                                    ?? $ppks->data['dimasukkan_oleh']
                                                    ?? '-'
                                                }}

                                            </div>

                                        </td>


                                        <td class="px-4 py-4 text-gray-600">

                                            {{
                                                optional(
                                                    $ppks->created_at
                                                )->format('d/m/Y H:i')
                                            }}

                                        </td>


                                        <td class="px-4 py-4">

                                            <div class="flex justify-center items-center gap-2">


                                                {{-- EDIT --}}

                                                <a
                                                    href="{{ route('ppks.normal.edit', $ppks) }}"
                                                    class="inline-flex items-center gap-1 px-3 py-2 rounded-lg bg-blue-50 text-blue-700 hover:bg-blue-100"
                                                >

                                                    <span class="material-symbols-outlined text-[18px]">
                                                        edit
                                                    </span>

                                                    Edit

                                                </a>


                                                {{-- DELETE --}}

                                                <form
                                                    method="POST"
                                                    action="{{ route('ppks.normal.destroy', $ppks) }}"
                                                    onsubmit="return confirm('Yakin ingin menghapus data ini? Data yang dihapus tidak dapat dikembalikan.')"
                                                >

                                                    @csrf

                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="inline-flex items-center gap-1 px-3 py-2 rounded-lg bg-red-50 text-red-700 hover:bg-red-100"
                                                    >

                                                        <span class="material-symbols-outlined text-[18px]">
                                                            delete
                                                        </span>

                                                        Hapus

                                                    </button>

                                                </form>

                                            </div>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td
                                            colspan="7"
                                            class="px-4 py-10 text-center text-gray-500"
                                        >

                                            <div class="flex flex-col items-center">

                                                <span class="material-symbols-outlined text-5xl text-gray-300">
                                                    person_search
                                                </span>

                                                <p class="mt-2">
                                                    Belum ada data manual.
                                                </p>

                                            </div>

                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>


                    {{-- PAGINATION --}}

                    @if($records->hasPages())

                        <div class="mt-6">

                            {{ $records->links() }}

                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

</x-app-layout>
