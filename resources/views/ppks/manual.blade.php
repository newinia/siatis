<x-app-layout>

    <x-slot name="header">

        <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Data Manual
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Kelola data PPKS yang dimasukkan secara manual.
            </p>
        </div>

    </x-slot>


    <div class="py-6">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- SUCCESS --}}
            @if (session('success'))

                <div class="mb-4 rounded-lg bg-green-50 border border-green-200 px-4 py-3 text-green-700">
                    {{ session('success') }}
                </div>

            @endif


            {{-- ERROR --}}
            @if (session('error'))

                <div class="mb-4 rounded-lg bg-red-50 border border-red-200 px-4 py-3 text-red-700">
                    {{ session('error') }}
                </div>

            @endif


            <div class="bg-white shadow-sm sm:rounded-lg">


                {{-- =====================================================
                HEADER CARD
                ====================================================== --}}

                <div class="p-6 border-b border-gray-200">

                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                        <div>

                            <h3 class="text-lg font-semibold text-gray-800">
                                Daftar Data Manual
                            </h3>

                            <p class="text-sm text-gray-500 mt-1">
                                Data yang ditambahkan langsung oleh admin.
                            </p>

                        </div>


                        {{-- SATU-SATUNYA TOMBOL TAMBAH DATA --}}

                        <a
                            href="{{ route('ppks.normal.create') }}"
                            class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
                        >

                            <span class="material-symbols-outlined text-[20px]">
                                person_add
                            </span>

                            Tambah Data

                        </a>

                    </div>

                </div>


                {{-- =====================================================
                SEARCH
                ====================================================== --}}

                <div class="p-6 border-b border-gray-200">

                    <form
                        method="GET"
                        action="{{ route('ppks.manual') }}"
                        class="flex flex-col md:flex-row gap-3"
                    >

                        <div class="flex-1">

                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Cari nama, NIK, atau jenis PPKS..."
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                            >

                        </div>


                        <button
                            type="submit"
                            class="inline-flex items-center justify-center gap-2 px-5 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-900 transition"
                        >

                            <span class="material-symbols-outlined text-[20px]">
                                search
                            </span>

                            Cari

                        </button>


                        @if(request()->filled('search'))

                            <a
                                href="{{ route('ppks.manual') }}"
                                class="inline-flex items-center justify-center px-5 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition"
                            >
                                Reset
                            </a>

                        @endif

                    </form>

                </div>


                {{-- =====================================================
                TABLE
                ====================================================== --}}

                <div class="overflow-x-auto">

                    <table class="min-w-full divide-y divide-gray-200">

                        <thead class="bg-gray-50">

                            <tr>

                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    No
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Nama
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    NIK
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Jenis Kelamin
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Jenis PPKS
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Dimasukkan Oleh
                                </th>

                                <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>

                            </tr>

                        </thead>


                        <tbody class="bg-white divide-y divide-gray-200">


                            {{-- =================================================
                            DATA
                            ================================================== --}}

                            @forelse($ppks as $index => $item)

                                @php
                                    $data = $item->data ?? [];
                                @endphp


                                <tr class="hover:bg-gray-50">


                                    {{-- NO --}}

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">

                                        {{ $ppks->firstItem() + $index }}

                                    </td>


                                    {{-- NAMA --}}

                                    <td class="px-6 py-4 whitespace-nowrap">

                                        <div class="text-sm font-medium text-gray-900">

                                            {{ $data['nama_lengkap'] ?? '-' }}

                                        </div>

                                    </td>


                                    {{-- NIK --}}

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">

                                        {{ $data['nik'] ?? '-' }}

                                    </td>


                                    {{-- JENIS KELAMIN --}}

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">

                                        {{ $data['jenis_kelamin'] ?? '-' }}

                                    </td>


                                    {{-- JENIS PPKS --}}

                                    <td class="px-6 py-4 text-sm text-gray-700">

                                        {{ $data['jenis_ppks'] ?? '-' }}

                                    </td>


                                    {{-- DIMASUKKAN OLEH --}}

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">

                                        {{ $data['dimasukkan_oleh'] ?? $item->createdBy?->name ?? '-' }}

                                    </td>


                                    {{-- =================================================
                                    AKSI
                                    ================================================== --}}

                                    <td class="px-6 py-4 whitespace-nowrap">

                                        <div class="flex items-center justify-center gap-2">


                                            {{-- EDIT --}}

                                            <a
                                                href="{{ route('ppks.normal.edit', $item->id) }}"
                                                class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-yellow-50 text-yellow-600 hover:bg-yellow-100"
                                                title="Edit"
                                            >

                                                <span class="material-symbols-outlined text-[20px]">
                                                    edit
                                                </span>

                                            </a>


                                            {{-- HAPUS --}}

                                            <form
                                                method="POST"
                                                action="{{ route('ppks.normal.destroy', $item->id) }}"
                                                onsubmit="return confirm('Yakin ingin menghapus data ini?')"
                                            >

                                                @csrf

                                                @method('DELETE')


                                                <button
                                                    type="submit"
                                                    class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-red-50 text-red-600 hover:bg-red-100"
                                                    title="Hapus"
                                                >

                                                    <span class="material-symbols-outlined text-[20px]">
                                                        delete
                                                    </span>

                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>


                            {{-- =================================================
                            DATA KOSONG
                            ================================================== --}}

                            @empty

                                <tr>

                                    <td
                                        colspan="7"
                                        class="px-6 py-12 text-center"
                                    >

                                        <div class="flex flex-col items-center justify-center">

                                            <span class="material-symbols-outlined text-gray-400 text-5xl mb-3">
                                                person_off
                                            </span>


                                            <p class="text-gray-500 font-medium">
                                                Belum ada data manual.
                                            </p>


                                            <p class="text-sm text-gray-400 mt-1">
                                                Silakan tambahkan data PPKS secara manual.
                                            </p>

                                        </div>

                                    </td>

                                </tr>

                            @endforelse


                        </tbody>

                    </table>

                </div>


                {{-- =====================================================
                PAGINATION
                ====================================================== --}}

                @if($ppks->hasPages())

                    <div class="p-6 border-t border-gray-200">

                        {{ $ppks->links() }}

                    </div>

                @endif


            </div>

        </div>

    </div>

</x-app-layout>
