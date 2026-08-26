<x-app-layout>

    <div class="p-6">

        {{-- HEADER --}}
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">
                Data PPKS
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Daftar data PPKS yang telah diimport.
            </p>
        </div>


        {{-- FILTER --}}
        <div class="mb-5 bg-white border border-gray-200 rounded-xl shadow-sm p-5">

            <form method="GET" action="{{ route('ppks.index') }}">

                <div class="flex flex-col md:flex-row gap-3">

                    {{-- SEARCH --}}
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari berdasarkan Sheet Row..."
                        class="w-full md:w-64 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                    >


                    {{-- FILTER STATUS --}}
                    <select
                        name="status"
                        class="w-full md:w-56 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                    >

                        <option value="">
                            Semua Status
                        </option>

                        <option
                            value="normal"
                            {{ request('status') === 'normal' ? 'selected' : '' }}
                        >
                            Normal
                        </option>

                        <option
                            value="perlu_diperiksa"
                            {{ request('status') === 'perlu_diperiksa' ? 'selected' : '' }}
                        >
                            Perlu Diperiksa
                        </option>

                        <option
                            value="duplikat"
                            {{ request('status') === 'duplikat' ? 'selected' : '' }}
                        >
                            Duplikat
                        </option>

                    </select>


                    {{-- CARI --}}
                    <button
                        type="submit"
                        class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg"
                    >
                        Cari
                    </button>


                    {{-- RESET --}}
                    @if(request('search') || request('status'))

                        <a
                            href="{{ route('ppks.index') }}"
                            class="px-5 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg text-center"
                        >
                            Reset
                        </a>

                    @endif

                </div>

            </form>

        </div>


        {{-- TABLE --}}
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">

            <div class="overflow-x-auto">

                <table class="w-full">

                    {{-- HEADER TABLE --}}
                    <thead class="bg-gray-50 border-b border-gray-200">

                        <tr>

                            {{-- SHEET ROW --}}
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">
                                Sheet Row
                            </th>

                            {{-- NAMA --}}
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">
                                Nama
                            </th>

                            {{-- NIK --}}
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">
                                NIK
                            </th>

                            {{-- STATUS --}}
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">
                                Status
                            </th>

                            {{-- AKSI --}}
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    {{-- BODY --}}
                    <tbody class="divide-y divide-gray-100">

                        @forelse ($ppks as $item)

                            @php
                                $data = $item->data ?? [];
                            @endphp

                            <tr class="hover:bg-gray-50">


                                {{-- SHEET ROW --}}
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $item->sheet_row ?? '-' }}
                                </td>


                                {{-- NAMA --}}
                                <td class="px-6 py-4 text-sm font-medium text-gray-800">
                                    {{ $data[1] ?? '-' }}
                                </td>


                                {{-- NIK --}}
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $data[2] ?? '-' }}
                                </td>


                                {{-- STATUS --}}
                                <td class="px-6 py-4">

                                    @if ($item->status === 'normal')

                                        <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700">
                                            Normal
                                        </span>

                                    @elseif ($item->status === 'perlu_diperiksa')

                                        <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-50 text-yellow-700">
                                            Perlu Diperiksa
                                        </span>

                                    @elseif ($item->status === 'duplikat')

                                        <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium bg-red-50 text-red-700">
                                            Duplikat
                                        </span>

                                    @else

                                        <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium bg-gray-50 text-gray-600">
                                            {{ $item->status ?? '-' }}
                                        </span>

                                    @endif

                                </td>


                                {{-- AKSI --}}
                                <td class="px-6 py-4 text-center">

                                    @if ($item->status === 'perlu_diperiksa')

                                        <form
                                            method="POST"
                                            action="{{ route('ppks.pilih', $item) }}"
                                            class="inline"
                                        >

                                            @csrf
                                            @method('PATCH')

                                            <button
                                                type="submit"
                                                onclick="return confirm('Yakin data ini benar dan ingin dimasukkan ke Data Normal?')"
                                                class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-xs font-medium rounded-lg transition"
                                            >
                                                Pilih
                                            </button>

                                        </form>

                                    @elseif ($item->status === 'normal')

                                        <span class="text-xs text-gray-400">
                                            Sudah Normal
                                        </span>

                                    @else

                                        <span class="text-xs text-gray-400">
                                            -
                                        </span>

                                    @endif

                                </td>

                            </tr>


                        @empty

                            <tr>

                                <td
                                    colspan="5"
                                    class="px-6 py-12 text-center text-gray-400"
                                >
                                    Tidak ada data PPKS yang ditemukan.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        {{-- PAGINATION --}}
        <div class="mt-5">
            {{ $ppks->links() }}
        </div>

    </div>

</x-app-layout>
