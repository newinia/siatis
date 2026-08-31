<x-app-layout>

    {{-- =========================================================
    HEADER
    ========================================================== --}}

    <x-slot name="header">

        <div>

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Persetujuan Akun
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Kelola request dan akun admin yang telah disetujui.
            </p>

        </div>

    </x-slot>


    {{-- =========================================================
    MAIN
    ========================================================== --}}

    <div
        x-data="{
            editOpen: false,
            editUser: null,
            editName: '',
            editEmail: '',
            editRole: ''
        }"
        class="pb-8 bg-[#f5f6fa] min-h-screen"
    >

        <div class="w-full px-6 lg:px-8">


            {{-- =====================================================
            NOTIFIKASI SUCCESS
            ====================================================== --}}

            @if (session('success'))

                <div
                    class="mb-5 rounded-xl bg-green-50 border border-green-200 px-5 py-4 text-green-700 text-sm"
                >

                    {{ session('success') }}

                </div>

            @endif


            {{-- =====================================================
            NOTIFIKASI ERROR
            ====================================================== --}}

            @if (session('error'))

                <div
                    class="mb-5 rounded-xl bg-red-50 border border-red-200 px-5 py-4 text-red-700 text-sm"
                >

                    {{ session('error') }}

                </div>

            @endif


            {{-- =====================================================
            VALIDATION ERROR
            ====================================================== --}}

            @if ($errors->any())

                <div
                    class="mb-5 rounded-xl bg-red-50 border border-red-200 px-5 py-4 text-red-700 text-sm"
                >

                    @foreach ($errors->all() as $error)

                        <div>
                            {{ $error }}
                        </div>

                    @endforeach

                </div>

            @endif



            {{-- =====================================================
            ========================================================
            REQUEST ADMIN
            ========================================================
            ====================================================== --}}

            <div
                class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden mb-8"
            >


                {{-- =================================================
                HEADER REQUEST
                ================================================== --}}

                <div class="px-6 py-5 border-b border-gray-200">

                    <div class="flex items-center justify-between gap-6">

                        <div>

                            <h3 class="text-lg font-semibold text-gray-800">
                                Request Admin
                            </h3>

                            <p class="text-sm text-gray-500 mt-1">
                                Daftar akun yang menunggu persetujuan Super Admin.
                            </p>

                        </div>


                        {{-- JUMLAH REQUEST --}}

                        <div
                            class="min-w-[130px] px-4 py-3 rounded-xl bg-yellow-50 border border-yellow-200"
                        >

                            <p class="text-xs text-yellow-700 font-medium">
                                Menunggu ACC
                            </p>

                            <p class="text-xl font-bold text-yellow-700 mt-1">
                                {{ $requestAdmins->count() }}
                            </p>

                        </div>

                    </div>

                </div>



                {{-- =================================================
                ISI REQUEST
                ================================================== --}}

                @if ($requestAdmins->isEmpty())

                    <div class="py-14 text-center">

                        <div class="text-gray-300 text-4xl mb-3">
                            ✓
                        </div>

                        <p class="text-gray-500 text-sm">
                            Tidak ada request admin yang menunggu persetujuan.
                        </p>

                    </div>

                @else

                    <div class="overflow-x-auto">

                        <table class="w-full">


                            {{-- =================================================
                            HEADER TABLE
                            ================================================== --}}

                            <thead class="bg-gray-50 border-b border-gray-200">

                                <tr>

                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase"
                                    >
                                        No
                                    </th>

                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase"
                                    >
                                        Nama
                                    </th>

                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase"
                                    >
                                        Email
                                    </th>

                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase"
                                    >
                                        Role
                                    </th>

                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase"
                                    >
                                        Tanggal Daftar
                                    </th>

                                    <th
                                        class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase"
                                    >
                                        Aksi
                                    </th>

                                </tr>

                            </thead>



                            {{-- =================================================
                            BODY TABLE
                            ================================================== --}}

                            <tbody class="divide-y divide-gray-100">

                                @foreach ($requestAdmins as $index => $user)

                                    <tr class="hover:bg-gray-50 transition">


                                        {{-- NO --}}

                                        <td class="px-6 py-5 text-sm text-gray-600">
                                            {{ $index + 1 }}
                                        </td>


                                        {{-- NAMA --}}

                                        <td class="px-6 py-5">

                                            <span
                                                class="text-sm font-semibold text-gray-800"
                                            >
                                                {{ $user->name }}
                                            </span>

                                        </td>


                                        {{-- EMAIL --}}

                                        <td class="px-6 py-5">

                                            <span class="text-sm text-gray-600">
                                                {{ $user->email }}
                                            </span>

                                        </td>


                                        {{-- ROLE --}}

                                        <td class="px-6 py-5">

                                            @if ($user->role === 'medis')

                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-700"
                                                >
                                                    Medis
                                                </span>

                                            @elseif ($user->role === 'instruktur')

                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700"
                                                >
                                                    Instruktur
                                                </span>

                                            @else

                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700"
                                                >
                                                    {{ ucfirst($user->role) }}
                                                </span>

                                            @endif

                                        </td>


                                        {{-- TANGGAL DAFTAR --}}

                                        <td class="px-6 py-5 whitespace-nowrap">

                                            @if ($user->created_at)

                                                <div class="text-sm text-gray-700">

                                                    {{ $user->created_at
                                                        ->timezone('Asia/Jakarta')
                                                        ->format('d M Y') }}

                                                </div>

                                                <div class="text-xs text-gray-400 mt-1">

                                                    {{ $user->created_at
                                                        ->timezone('Asia/Jakarta')
                                                        ->format('H:i') }}

                                                    WIB

                                                </div>

                                            @else

                                                <span class="text-gray-400">
                                                    -
                                                </span>

                                            @endif

                                        </td>


                                        {{-- =================================================
                                        AKSI
                                        ================================================== --}}

                                        <td class="px-6 py-5">

                                            <div class="flex items-center justify-center gap-2">


                                                {{-- SETUJUI --}}

                                                <form
                                                    method="POST"
                                                    action="{{ route('super-admin.users.approve', $user) }}"
                                                >

                                                    @csrf

                                                    @method('PATCH')


                                                    <button
                                                        type="submit"
                                                        class="inline-flex items-center gap-2 h-9 px-3 rounded-lg bg-green-600 hover:bg-green-700 text-white text-xs font-semibold transition"
                                                    >

                                                        {{-- CHECK ICON --}}

                                                        <svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            viewBox="0 0 24 24"
                                                            fill="none"
                                                            stroke="currentColor"
                                                            stroke-width="2"
                                                            class="w-4 h-4"
                                                        >

                                                            <path
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                d="M5 13l4 4L19 7"
                                                            />

                                                        </svg>

                                                        <span>
                                                            Setujui
                                                        </span>

                                                    </button>

                                                </form>



                                                {{-- TOLAK --}}

                                                <form
                                                    method="POST"
                                                    action="{{ route('super-admin.users.reject', $user) }}"
                                                >

                                                    @csrf

                                                    @method('PATCH')


                                                    <button
                                                        type="submit"
                                                        class="inline-flex items-center gap-2 h-9 px-3 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 text-xs font-semibold transition"
                                                    >

                                                        {{-- X ICON --}}

                                                        <svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            viewBox="0 0 24 24"
                                                            fill="none"
                                                            stroke="currentColor"
                                                            stroke-width="2"
                                                            class="w-4 h-4"
                                                        >

                                                            <path
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                d="M6 6l12 12M6 18L18 6"
                                                            />

                                                        </svg>

                                                        <span>
                                                            Tolak
                                                        </span>

                                                    </button>

                                                </form>

                                            </div>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @endif

            </div>



            {{-- =====================================================
            ========================================================
            DAFTAR ADMIN
            ========================================================
            ====================================================== --}}

            <div
                class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden"
            >


                {{-- =================================================
                HEADER DAFTAR ADMIN
                ================================================== --}}

                <div class="px-6 py-5 border-b border-gray-200">

                    <div class="flex items-center justify-between gap-6">

                        <div>

                            <h3 class="text-lg font-semibold text-gray-800">
                                Daftar Admin
                            </h3>

                            <p class="text-sm text-gray-500 mt-1">
                                Daftar admin yang telah disetujui dan dapat mengakses sistem.
                            </p>

                        </div>


                        {{-- JUMLAH ADMIN --}}

                        <div
                            class="min-w-[130px] px-4 py-3 rounded-xl bg-green-50 border border-green-200"
                        >

                            <p class="text-xs text-green-700 font-medium">
                                Admin Aktif
                            </p>

                            <p class="text-xl font-bold text-green-700 mt-1">
                                {{ $admins->count() }}
                            </p>

                        </div>

                    </div>

                </div>



                {{-- =================================================
                ISI DAFTAR ADMIN
                ================================================== --}}

                @if ($admins->isEmpty())

                    <div class="py-14 text-center">

                        <div class="text-gray-300 text-4xl mb-3">
                            👤
                        </div>

                        <p class="text-gray-500 text-sm">
                            Belum ada admin yang disetujui.
                        </p>

                    </div>

                @else

                    <div class="overflow-x-auto">

                        <table class="w-full">


                            {{-- =================================================
                            HEADER TABLE
                            ================================================== --}}

                            <thead class="bg-gray-50 border-b border-gray-200">

                                <tr>

                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase"
                                    >
                                        No
                                    </th>

                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase"
                                    >
                                        Nama
                                    </th>

                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase"
                                    >
                                        Email
                                    </th>

                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase"
                                    >
                                        Role
                                    </th>

                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase"
                                    >
                                        Status
                                    </th>

                                    <th
                                        class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase"
                                    >
                                        Aksi
                                    </th>

                                </tr>

                            </thead>



                            {{-- =================================================
                            BODY TABLE
                            ================================================== --}}

                            <tbody class="divide-y divide-gray-100">

                                @foreach ($admins as $index => $user)

                                    <tr class="hover:bg-gray-50 transition">


                                        {{-- NO --}}

                                        <td class="px-6 py-5 text-sm text-gray-600">
                                            {{ $index + 1 }}
                                        </td>


                                        {{-- NAMA --}}

                                        <td class="px-6 py-5">

                                            <span
                                                class="text-sm font-semibold text-gray-800"
                                            >
                                                {{ $user->name }}
                                            </span>

                                        </td>


                                        {{-- EMAIL --}}

                                        <td class="px-6 py-5">

                                            <span class="text-sm text-gray-600">
                                                {{ $user->email }}
                                            </span>

                                        </td>


                                        {{-- ROLE --}}

                                        <td class="px-6 py-5">

                                            @if ($user->role === 'medis')

                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-700"
                                                >
                                                    Medis
                                                </span>

                                            @elseif ($user->role === 'instruktur')

                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700"
                                                >
                                                    Instruktur
                                                </span>

                                            @else

                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700"
                                                >
                                                    {{ ucfirst($user->role) }}
                                                </span>

                                            @endif

                                        </td>


                                        {{-- STATUS --}}

                                        <td class="px-6 py-5">

                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700"
                                            >
                                                Disetujui
                                            </span>

                                        </td>


                                        {{-- =================================================
                                        AKSI
                                        ================================================== --}}

                                        <td class="px-6 py-5">

                                            <div class="flex items-center justify-center gap-2">


                                                {{-- =================================================
                                                EDIT
                                                ================================================== --}}

                                                <button
                                                    type="button"
                                                    title="Edit admin"
                                                    @click="
                                                        editUser = {{ $user->id }};
                                                        editName = @js($user->name);
                                                        editEmail = @js($user->email);
                                                        editRole = @js($user->role);
                                                        editOpen = true;
                                                    "
                                                    class="inline-flex items-center gap-2 h-9 px-3 rounded-lg bg-indigo-50 text-indigo-600 hover:bg-indigo-100 hover:text-indigo-700 transition text-xs font-semibold"
                                                >

                                                    {{-- PENCIL ICON --}}

                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 24 24"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        stroke-width="2"
                                                        class="w-4 h-4"
                                                    >

                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            d="M16.862 3.487a2.25 2.25 0 013.182 3.182L8.25 18.463 3.75 19.75l1.287-4.5L16.862 3.487z"
                                                        />

                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            d="M14.5 5.5l4 4"
                                                        />

                                                    </svg>

                                                    <span>
                                                        Edit
                                                    </span>

                                                </button>



                                                {{-- =================================================
                                                HAPUS
                                                ================================================== --}}

                                                <form
                                                    method="POST"
                                                    action="{{ route('super-admin.users.destroy', $user) }}"
                                                    onsubmit="return confirm('Yakin ingin menghapus akun {{ addslashes($user->name) }}?')"
                                                >

                                                    @csrf

                                                    @method('DELETE')


                                                    <button
                                                        type="submit"
                                                        title="Hapus akun"
                                                        class="inline-flex items-center gap-2 h-9 px-3 rounded-lg bg-red-50 text-red-500 hover:bg-red-100 hover:text-red-600 transition text-xs font-semibold"
                                                    >

                                                        {{-- TRASH ICON --}}

                                                        <svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            viewBox="0 0 24 24"
                                                            fill="none"
                                                            stroke="currentColor"
                                                            stroke-width="2"
                                                            class="w-4 h-4"
                                                        >

                                                            <path
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                d="M3 6h18"
                                                            />

                                                            <path
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                d="M8 6V4.5A1.5 1.5 0 019.5 3h5A1.5 1.5 0 0116 4.5V6"
                                                            />

                                                            <path
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                d="M19 6l-1 14.5a1.5 1.5 0 01-1.497 1.397H7.497A1.5 1.5 0 016 20.5L5 6"
                                                            />

                                                            <path
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                d="M10 10v7"
                                                            />

                                                            <path
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                d="M14 10v7"
                                                            />

                                                        </svg>

                                                        <span>
                                                            Hapus
                                                        </span>

                                                    </button>

                                                </form>

                                            </div>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @endif

            </div>

        </div>



        {{-- =========================================================
        MODAL EDIT ADMIN
        ========================================================== --}}

        <div
            x-show="editOpen"
            x-cloak
            x-transition.opacity
            class="fixed inset-0 z-50 flex items-center justify-center px-4"
        >


            {{-- BACKDROP --}}

            <div
                class="absolute inset-0 bg-black/40"
                @click="editOpen = false"
            ></div>



            {{-- =====================================================
            MODAL
            ====================================================== --}}

            <div
                x-show="editOpen"
                x-transition
                @click.stop
                class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl overflow-hidden"
            >


                {{-- =================================================
                HEADER MODAL
                ================================================== --}}

                <div class="px-6 py-5 border-b border-gray-200">

                    <div class="flex items-center justify-between">

                        <div>

                            <h3 class="text-lg font-semibold text-gray-800">
                                Edit Admin
                            </h3>

                            <p class="text-sm text-gray-500 mt-1">
                                Ubah role admin.
                            </p>

                        </div>


                        {{-- CLOSE --}}

                        <button
                            type="button"
                            @click="editOpen = false"
                            class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:bg-gray-100 hover:text-gray-600 text-xl"
                        >
                            &times;
                        </button>

                    </div>

                </div>



                {{-- =================================================
                BODY MODAL
                ================================================== --}}

                <div class="px-6 py-6">

                    <template x-if="editUser">

                        <form
                            method="POST"
                            :action="'{{ url('/super-admin/users') }}/' + editUser + '/role'"
                        >

                            @csrf

                            @method('PATCH')



                            {{-- =================================================
                            NAMA
                            ================================================== --}}

                            <div class="mb-5">

                                <label
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                >
                                    Nama
                                </label>

                                <input
                                    type="text"
                                    x-model="editName"
                                    readonly
                                    class="w-full h-11 px-4 rounded-lg border border-gray-300 bg-gray-50 text-gray-700 cursor-not-allowed focus:outline-none"
                                >

                            </div>



                            {{-- =================================================
                            EMAIL
                            ================================================== --}}

                            <div class="mb-5">

                                <label
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                >
                                    Email
                                </label>

                                <input
                                    type="email"
                                    x-model="editEmail"
                                    readonly
                                    class="w-full h-11 px-4 rounded-lg border border-gray-300 bg-gray-50 text-gray-700 cursor-not-allowed focus:outline-none"
                                >

                            </div>



                            {{-- =================================================
                            ROLE
                            ================================================== --}}

                            <div class="mb-6">

                                <label
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                >
                                    Role
                                </label>

                                <select
                                    name="role"
                                    x-model="editRole"
                                    required
                                    class="w-full h-11 px-4 rounded-lg border border-gray-300 bg-white text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500"
                                >

                                    <option value="medis">
                                        Medis
                                    </option>

                                    <option value="instruktur">
                                        Instruktur
                                    </option>

                                </select>

                            </div>



                            {{-- =================================================
                            BUTTON MODAL
                            ================================================== --}}

                            <div class="flex justify-end gap-3">

                                <button
                                    type="button"
                                    @click="editOpen = false"
                                    class="px-5 py-2.5 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium transition"
                                >
                                    Batal
                                </button>


                                <button
                                    type="submit"
                                    class="px-5 py-2.5 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold transition"
                                >
                                    Simpan
                                </button>

                            </div>

                        </form>

                    </template>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>
