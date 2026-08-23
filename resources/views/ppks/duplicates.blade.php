<x-app-layout>

    <div class="p-6">

        {{-- HEADER --}}
        <div class="flex items-center justify-between mb-6">

            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    Perlu Pemeriksaan
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Periksa data yang terindikasi memiliki kemungkinan duplikat.
                </p>
            </div>

            <div class="px-4 py-2 bg-yellow-50 border border-yellow-200 rounded-lg">
                <span class="text-sm text-yellow-700">
                    Perlu diperiksa
                </span>

                <span class="ml-2 font-bold text-yellow-800">
                    {{ $cases->count() }}
                </span>
            </div>

        </div>


        {{-- NOTIFICATION --}}
        @if (session('success'))

            <div class="mb-5 px-4 py-3 bg-green-50 border border-green-200 rounded-lg text-sm text-green-700">
                {{ session('success') }}
            </div>

        @endif


        {{-- TABLE --}}
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">

            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-gray-50 border-b border-gray-200">

                        <tr>

                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">
                                No
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">
                                Data
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">
                                Pembanding
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">
                                Kondisi
                            </th>

                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-gray-100">

                        @forelse ($cases as $index => $case)

                            @php

                                $ppks = $case['data'];

                                $data = $ppks->data ?? [];

                                $comparison = $case['comparison'];

                                $comparisonData =
                                    $comparison?->data ?? [];

                                $type = $case['type'];

                            @endphp


                            <tr class="hover:bg-gray-50 transition">

                                {{-- NO --}}
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $index + 1 }}
                                </td>


                                {{-- DATA --}}
                                <td class="px-6 py-4">

                                    <div class="font-medium text-gray-800">
                                        {{ $data[1] ?? '-' }}
                                    </div>

                                    <div class="text-xs text-gray-500 mt-1">
                                        NIK:
                                        {{ $data[2] ?? '-' }}
                                    </div>

                                </td>


                                {{-- PEMBANDING --}}
                                <td class="px-6 py-4">

                                    @if ($comparison)

                                        <div class="font-medium text-gray-700">
                                            {{ $comparisonData[1] ?? '-' }}
                                        </div>

                                        <div class="text-xs text-gray-500 mt-1">
                                            NIK:
                                            {{ $comparisonData[2] ?? '-' }}
                                        </div>

                                    @else

                                        <span class="text-sm text-gray-400">
                                            Tidak ditemukan
                                        </span>

                                    @endif

                                </td>


                                {{-- KONDISI --}}
                                <td class="px-6 py-4">

                                    @if ($type === 'NIK berbeda')

                                        <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium bg-orange-50 text-orange-700">
                                            NIK berbeda
                                        </span>

                                    @elseif ($type === 'NIK sama')

                                        <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium bg-red-50 text-red-700">
                                            NIK sama
                                        </span>

                                    @else

                                        <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-50 text-yellow-700">
                                            Perlu dicek
                                        </span>

                                    @endif

                                </td>


                                {{-- AKSI --}}
                                <td class="px-6 py-4 text-center">

                                    <button
                                        type="button"
                                        onclick="openDetail({{ $ppks->id }})"
                                        class="px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">

                                        Detail

                                    </button>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="5"
                                    class="px-6 py-12 text-center">

                                    <div class="text-gray-400 text-sm">
                                        Tidak ada data yang perlu diperiksa.
                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- MODAL DETAIL --}}
    {{-- ========================================================= --}}

    @foreach ($cases as $case)

        @php

            $ppks = $case['data'];

            $data = $ppks->data ?? [];

            $comparison = $case['comparison'];

            $comparisonData =
                $comparison?->data ?? [];

        @endphp


        <div
            id="detailModal{{ $ppks->id }}"
            class="hidden fixed inset-0 z-50 overflow-y-auto">

            {{-- BACKDROP --}}
            <div
                class="fixed inset-0 bg-black/50"
                onclick="closeDetail({{ $ppks->id }})">
            </div>


            {{-- MODAL --}}
            <div class="relative min-h-screen flex items-center justify-center p-4">

                <div class="relative bg-white w-full max-w-4xl rounded-2xl shadow-2xl overflow-hidden">


                    {{-- HEADER --}}
                    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">

                        <div>

                            <h2 class="text-lg font-bold text-gray-800">
                                Detail Pemeriksaan
                            </h2>

                            <p class="text-xs text-gray-500 mt-1">
                                Data ID #{{ $ppks->id }}
                                · Sheet Row {{ $ppks->sheet_row }}
                            </p>

                        </div>


                        <button
                            type="button"
                            onclick="closeDetail({{ $ppks->id }})"
                            class="w-9 h-9 flex items-center justify-center rounded-lg text-gray-400 hover:text-gray-700 hover:bg-gray-100 text-2xl">

                            &times;

                        </button>

                    </div>


                    {{-- BODY --}}
                    <div class="p-6">


                        {{-- ALASAN --}}
                        <div class="mb-6 px-4 py-3 bg-yellow-50 border border-yellow-200 rounded-lg">

                            <p class="text-xs font-semibold text-yellow-700 uppercase">
                                Alasan Pemeriksaan
                            </p>

                            <p class="mt-1 text-sm text-yellow-800">
                                {{ $ppks->duplicate_note ?? '-' }}
                            </p>

                        </div>


                        {{-- DATA COMPARISON --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">


                            {{-- DATA A --}}
                            <div class="border border-blue-200 rounded-xl overflow-hidden">

                                <div class="px-5 py-3 bg-blue-50">

                                    <h3 class="font-semibold text-blue-800">
                                        Data A
                                    </h3>

                                </div>


                                <div class="p-5 space-y-4">

                                    <div>
                                        <p class="text-xs text-gray-400">
                                            Nama
                                        </p>

                                        <p class="text-sm font-medium text-gray-800">
                                            {{ $data[1] ?? '-' }}
                                        </p>
                                    </div>


                                    <div>
                                        <p class="text-xs text-gray-400">
                                            NIK
                                        </p>

                                        <p class="text-sm font-medium text-gray-800">
                                            {{ $data[2] ?? '-' }}
                                        </p>
                                    </div>


                                    <div>
                                        <p class="text-xs text-gray-400">
                                            Jenis Kelamin
                                        </p>

                                        <p class="text-sm font-medium text-gray-800">
                                            {{ $data[3] ?? '-' }}
                                        </p>
                                    </div>


                                    <div>
                                        <p class="text-xs text-gray-400">
                                            Tempat Lahir
                                        </p>

                                        <p class="text-sm font-medium text-gray-800">
                                            {{ $data[4] ?? '-' }}
                                        </p>
                                    </div>


                                    <div>
                                        <p class="text-xs text-gray-400">
                                            Tanggal Lahir
                                        </p>

                                        <p class="text-sm font-medium text-gray-800">
                                            {{ $data[5] ?? '-' }}
                                        </p>
                                    </div>

                                </div>

                            </div>


                            {{-- DATA B --}}
                            <div class="border border-gray-200 rounded-xl overflow-hidden">

                                <div class="px-5 py-3 bg-gray-50">

                                    <h3 class="font-semibold text-gray-700">
                                        Data Pembanding
                                    </h3>

                                </div>


                                @if ($comparison)

                                    <div class="p-5 space-y-4">

                                        <div>
                                            <p class="text-xs text-gray-400">
                                                Nama
                                            </p>

                                            <p class="text-sm font-medium text-gray-800">
                                                {{ $comparisonData[1] ?? '-' }}
                                            </p>
                                        </div>


                                        <div>
                                            <p class="text-xs text-gray-400">
                                                NIK
                                            </p>

                                            <p class="text-sm font-medium text-gray-800">
                                                {{ $comparisonData[2] ?? '-' }}
                                            </p>
                                        </div>


                                        <div>
                                            <p class="text-xs text-gray-400">
                                                Jenis Kelamin
                                            </p>

                                            <p class="text-sm font-medium text-gray-800">
                                                {{ $comparisonData[3] ?? '-' }}
                                            </p>
                                        </div>


                                        <div>
                                            <p class="text-xs text-gray-400">
                                                Tempat Lahir
                                            </p>

                                            <p class="text-sm font-medium text-gray-800">
                                                {{ $comparisonData[4] ?? '-' }}
                                            </p>
                                        </div>


                                        <div>
                                            <p class="text-xs text-gray-400">
                                                Tanggal Lahir
                                            </p>

                                            <p class="text-sm font-medium text-gray-800">
                                                {{ $comparisonData[5] ?? '-' }}
                                            </p>
                                        </div>

                                    </div>

                                @else

                                    <div class="p-8 text-center text-gray-400 text-sm">
                                        Data pembanding tidak ditemukan.
                                    </div>

                                @endif

                            </div>

                        </div>

                    </div>


                    {{-- FOOTER --}}
                    <div class="flex items-center justify-between px-6 py-4 border-t border-gray-200 bg-gray-50">


                        {{-- TUTUP --}}
                        <button
                            type="button"
                            onclick="closeDetail({{ $ppks->id }})"
                            class="px-4 py-2 bg-white border border-gray-300 hover:bg-gray-100 text-gray-700 text-sm font-medium rounded-lg transition">

                            Tutup

                        </button>


                        {{-- KEPUTUSAN ADMIN --}}
                        <div class="flex gap-3">


                            {{-- BUKAN DUPLIKAT --}}
                            <form
                                method="POST"
                                action="{{ route('ppks.duplicate-decision', $ppks->id) }}">

                                @csrf
                                @method('PATCH')

                                <input
                                    type="hidden"
                                    name="decision"
                                    value="bukan_duplikat">

                                <button
                                    type="submit"
                                    onclick="return confirm('Yakin data ini bukan duplikat?')"
                                    class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition">

                                    Bukan Duplikat

                                </button>

                            </form>


                            {{-- DUPLIKAT --}}
                            <form
                                method="POST"
                                action="{{ route('ppks.duplicate-decision', $ppks->id) }}">

                                @csrf
                                @method('PATCH')

                                <input
                                    type="hidden"
                                    name="decision"
                                    value="duplikat">

                                <button
                                    type="submit"
                                    onclick="return confirm('Yakin data ini adalah duplikat?')"
                                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition">

                                    Tandai Duplikat

                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    @endforeach


    {{-- JAVASCRIPT --}}
    <script>

        function openDetail(id) {

            const modal =
                document.getElementById(
                    'detailModal' + id
                );

            if (!modal) return;

            modal.classList.remove('hidden');

            document.body.classList.add(
                'overflow-hidden'
            );
        }


        function closeDetail(id) {

            const modal =
                document.getElementById(
                    'detailModal' + id
                );

            if (!modal) return;

            modal.classList.add('hidden');

            document.body.classList.remove(
                'overflow-hidden'
            );
        }


        document.addEventListener(
            'keydown',
            function (event) {

                if (event.key === 'Escape') {

                    document
                        .querySelectorAll(
                            '[id^="detailModal"]'
                        )
                        .forEach(
                            function (modal) {

                                modal.classList.add(
                                    'hidden'
                                );

                            }
                        );

                    document.body.classList.remove(
                        'overflow-hidden'
                    );
                }

            }
        );

    </script>

</x-app-layout>
