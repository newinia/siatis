<x-app-layout>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900">

                    {{-- HEADER --}}
                    <div class="flex items-center justify-between mb-4">

                        <div>
                            <h2 class="text-xl font-semibold">
                                Data Normal
                            </h2>

                            <p class="mt-1 text-sm text-gray-500">
                                Data PPKS yang telah dipilih dan dinyatakan normal.
                            </p>
                        </div>

                    </div>


                    {{-- NOTIFIKASI --}}
                    @if (session('success'))

                        <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-lg">
                            {{ session('success') }}
                        </div>

                    @endif


                    @if ($ppks->count() > 0)

                        <div class="overflow-x-auto">

                            <table class="min-w-full border border-gray-200">

                                <thead class="bg-gray-100">

                                    <tr>

                                        <th class="px-4 py-3 text-left">
                                            No. Sheet
                                        </th>

                                        <th class="px-4 py-3 text-left">
                                            NIK
                                        </th>

                                        <th class="px-4 py-3 text-left">
                                            Nama
                                        </th>

                                        <th class="px-4 py-3 text-left">
                                            Status
                                        </th>

                                        <th class="px-4 py-3 text-center">
                                            Aksi
                                        </th>

                                    </tr>

                                </thead>


                                <tbody>

                                    @foreach ($ppks as $data)

                                        @php
                                            $row = $data->data ?? [];
                                        @endphp

                                        <tr class="border-t hover:bg-gray-50">

                                            {{-- Nomor baris Google Sheet --}}
                                            <td class="px-4 py-3">
                                                {{ $data->sheet_row }}
                                            </td>


                                            {{-- NIK --}}
                                            <td class="px-4 py-3">
                                                {{ $row[2] ?? '-' }}
                                            </td>


                                            {{-- Nama --}}
                                            <td class="px-4 py-3 font-medium">
                                                {{ $row[1] ?? '-' }}
                                            </td>


                                            {{-- Status --}}
                                            <td class="px-4 py-3">

                                                <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700">
                                                    Normal
                                                </span>

                                            </td>


                                            {{-- AKSI --}}
                                            <td class="px-4 py-3 text-center">

                                                <form
                                                    method="POST"
                                                    action="{{ route('ppks.kembalikan', $data) }}"
                                                    class="inline"
                                                >

                                                    @csrf
                                                    @method('PATCH')

                                                    <button
                                                        type="submit"
                                                        onclick="return confirm('Yakin ingin mengembalikan data ini ke Data Pemeriksaan?')"
                                                        class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium rounded-lg"
                                                    >
                                                        Kembalikan
                                                    </button>

                                                </form>

                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>


                        {{-- PAGINATION --}}
                        <div class="mt-4">
                            {{ $ppks->links() }}
                        </div>


                    @else

                        <div class="text-gray-500">
                            Belum ada data normal.
                        </div>

                    @endif

                </div>

            </div>

        </div>
    </div>

</x-app-layout>
