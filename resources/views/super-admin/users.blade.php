<x-app-layout>


<div
    class="main-page"
    x-data="{
        editOpen: false,
        editUser: null,
        editName: '',
        editEmail: '',
        editRole: ''
    }"
>

    {{-- =====================================================
    HEADER
    ======================================================= --}}
    <div class="main-page-header">

        <div>

            <h1>Persetujuan Akun</h1>

            <p>
                Kelola permintaan akun dan pengguna yang telah disetujui.
            </p>

        </div>

    </div>


    {{-- =====================================================
    NOTIFIKASI
    ======================================================= --}}
    @if (session('success'))

        <div
            style="
                margin-bottom: 14px;
                padding: 10px 14px;
                border-radius: 10px;
                background: var(--green-light);
                border: 1px solid var(--green);
                color: var(--green);
                font-size: 10px;
            "
        >
            {{ session('success') }}
        </div>

    @endif


    @if (session('error'))

        <div
            style="
                margin-bottom: 14px;
                padding: 10px 14px;
                border-radius: 10px;
                background: var(--red-light);
                border: 1px solid var(--red);
                color: var(--red);
                font-size: 10px;
            "
        >
            {{ session('error') }}
        </div>

    @endif


    @if ($errors->any())

        <div
            style="
                margin-bottom: 14px;
                padding: 10px 14px;
                border-radius: 10px;
                background: var(--red-light);
                border: 1px solid var(--red);
                color: var(--red);
                font-size: 10px;
            "
        >

            @foreach ($errors->all() as $error)

                <div>
                    {{ $error }}
                </div>

            @endforeach

        </div>

    @endif


    {{-- =====================================================
    REQUEST PENGGUNA
    ======================================================= --}}
    <div style="margin-bottom: 28px;">

        <div
            style="
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 20px;
                margin-bottom: 12px;
            "
        >

            <div>

                <h2
                    style="
                        margin: 0;
                        color: var(--text);
                        font-size: 15px;
                        font-weight: 600;
                    "
                >
                    Request Pengguna
                </h2>

                <p
                    style="
                        margin: 4px 0 0;
                        color: var(--text-secondary);
                        font-size: 9px;
                    "
                >
                    Akun yang masih menunggu persetujuan.
                </p>

            </div>


            <div
                style="
                    display: inline-flex;
                    align-items: center;
                    gap: 6px;
                    padding: 6px 10px;
                    border-radius: 12px;
                    background: var(--orange-light);
                    color: var(--orange);
                    font-size: 9px;
                    font-weight: 500;
                    white-space: nowrap;
                "
            >

                <span
                    class="material-symbols-outlined"
                    style="font-size: 14px;"
                >
                    pending_actions
                </span>

                {{ $requestAdmins->count() }} Menunggu

            </div>

        </div>


        @if ($requestAdmins->isEmpty())

            <div
                style="
                    padding: 35px 20px;
                    text-align: center;
                    background: var(--white);
                    border: 1px solid var(--border);
                    border-radius: var(--radius);
                "
            >

                <span
                    class="material-symbols-outlined"
                    style="
                        display: block;
                        font-size: 30px;
                        color: var(--muted);
                        margin-bottom: 6px;
                    "
                >
                    task_alt
                </span>

                <p
                    style="
                        margin: 0;
                        color: var(--muted);
                        font-size: 10px;
                    "
                >
                    Tidak ada request pengguna yang menunggu persetujuan.
                </p>

            </div>

        @else

            <div class="table-wrapper">

                <table class="table">

                    <thead>

                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Tanggal Daftar</th>
                            <th>Aksi</th>
                        </tr>

                    </thead>


                    <tbody>

                        @foreach ($requestAdmins as $index => $user)

                            <tr>

                                <td>
                                    {{ $index + 1 }}
                                </td>


                                <td>
                                    {{ $user->name }}
                                </td>


                                <td>
                                    {{ $user->email }}
                                </td>


                                <td>

                                    @if ($user->role === 'medis')

                                        <span
                                            style="
                                                display: inline-flex;
                                                align-items: center;
                                                padding: 4px 9px;
                                                border-radius: 12px;
                                                background: var(--purple-light);
                                                color: var(--purple);
                                                font-size: 8px;
                                                font-weight: 500;
                                            "
                                        >
                                            Medis
                                        </span>

                                    @elseif ($user->role === 'instruktur')

                                        <span
                                            style="
                                                display: inline-flex;
                                                align-items: center;
                                                padding: 4px 9px;
                                                border-radius: 12px;
                                                background: var(--blue-light);
                                                color: var(--blue);
                                                font-size: 8px;
                                                font-weight: 500;
                                            "
                                        >
                                            Instruktur
                                        </span>

                                    @else

                                        {{ ucfirst($user->role) }}

                                    @endif

                                </td>


                                <td>

                                    @if ($user->created_at)

                                        {{ $user->created_at
                                            ->timezone('Asia/Jakarta')
                                            ->format('d M Y') }}

                                        <span
                                            style="
                                                color: var(--muted);
                                                font-size: 8px;
                                            "
                                        >
                                            ·
                                            {{ $user->created_at
                                                ->timezone('Asia/Jakarta')
                                                ->format('H:i') }}
                                            WIB
                                        </span>

                                    @else

                                        -

                                    @endif

                                </td>


                                <td>

                                    <div
                                        style="
                                            display: flex;
                                            align-items: center;
                                            gap: 6px;
                                        "
                                    >

                                        {{-- SETUJUI --}}
                                        <form
                                            method="POST"
                                            action="{{ route('super-admin.users.approve', $user) }}"
                                            style="margin: 0;"
                                        >

                                            @csrf
                                            @method('PATCH')

                                            <button
                                                type="submit"
                                                style="
                                                    height: 28px;
                                                    padding: 0 10px;
                                                    display: inline-flex;
                                                    align-items: center;
                                                    gap: 4px;
                                                    border: none;
                                                    border-radius: 8px;
                                                    background: var(--green);
                                                    color: var(--white);
                                                    font-family: inherit;
                                                    font-size: 8px;
                                                    font-weight: 500;
                                                    cursor: pointer;
                                                "
                                            >

                                                <span
                                                    class="material-symbols-outlined"
                                                    style="font-size: 14px;"
                                                >
                                                    check
                                                </span>

                                                Setujui

                                            </button>

                                        </form>


                                        {{-- TOLAK --}}
                                        <form
                                            method="POST"
                                            action="{{ route('super-admin.users.reject', $user) }}"
                                            style="margin: 0;"
                                        >

                                            @csrf
                                            @method('PATCH')

                                            <button
                                                type="submit"
                                                style="
                                                    height: 28px;
                                                    padding: 0 10px;
                                                    display: inline-flex;
                                                    align-items: center;
                                                    gap: 4px;
                                                    border: none;
                                                    border-radius: 8px;
                                                    background: var(--red-light);
                                                    color: var(--red);
                                                    font-family: inherit;
                                                    font-size: 8px;
                                                    font-weight: 500;
                                                    cursor: pointer;
                                                "
                                            >

                                                <span
                                                    class="material-symbols-outlined"
                                                    style="font-size: 14px;"
                                                >
                                                    close
                                                </span>

                                                Tolak

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
    DAFTAR PENGGUNA
    ======================================================= --}}
    <div>

        <div
            style="
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 20px;
                margin-bottom: 12px;
            "
        >

            <div>

                <h2
                    style="
                        margin: 0;
                        color: var(--text);
                        font-size: 15px;
                        font-weight: 600;
                    "
                >
                    Daftar Pengguna
                </h2>

                <p
                    style="
                        margin: 4px 0 0;
                        color: var(--text-secondary);
                        font-size: 9px;
                    "
                >
                    Pengguna yang telah disetujui dan dapat mengakses sistem.
                </p>

            </div>


            <div
                style="
                    display: inline-flex;
                    align-items: center;
                    gap: 6px;
                    padding: 6px 10px;
                    border-radius: 12px;
                    background: var(--green-light);
                    color: var(--green);
                    font-size: 9px;
                    font-weight: 500;
                    white-space: nowrap;
                "
            >

                <span
                    class="material-symbols-outlined"
                    style="font-size: 14px;"
                >
                    group
                </span>

                {{ $admins->count() }} Pengguna Aktif

            </div>

        </div>


        @if ($admins->isEmpty())

            <div
                style="
                    padding: 35px 20px;
                    text-align: center;
                    background: var(--white);
                    border: 1px solid var(--border);
                    border-radius: var(--radius);
                "
            >

                <span
                    class="material-symbols-outlined"
                    style="
                        display: block;
                        font-size: 30px;
                        color: var(--muted);
                        margin-bottom: 6px;
                    "
                >
                    group
                </span>

                <p
                    style="
                        margin: 0;
                        color: var(--muted);
                        font-size: 10px;
                    "
                >
                    Belum ada pengguna yang disetujui.
                </p>

            </div>

        @else

            <div class="table-wrapper">

                <table class="table">

                    <thead>

                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>

                    </thead>


                    <tbody>

                        @foreach ($admins as $index => $user)

                            <tr>

                                <td>
                                    {{ $index + 1 }}
                                </td>


                                <td>
                                    {{ $user->name }}
                                </td>


                                <td>
                                    {{ $user->email }}
                                </td>


                                <td>

                                    @if ($user->role === 'medis')

                                        <span
                                            style="
                                                display: inline-flex;
                                                align-items: center;
                                                padding: 4px 9px;
                                                border-radius: 12px;
                                                background: var(--purple-light);
                                                color: var(--purple);
                                                font-size: 8px;
                                                font-weight: 500;
                                            "
                                        >
                                            Medis
                                        </span>

                                    @elseif ($user->role === 'instruktur')

                                        <span
                                            style="
                                                display: inline-flex;
                                                align-items: center;
                                                padding: 4px 9px;
                                                border-radius: 12px;
                                                background: var(--blue-light);
                                                color: var(--blue);
                                                font-size: 8px;
                                                font-weight: 500;
                                            "
                                        >
                                            Instruktur
                                        </span>

                                    @else

                                        {{ ucfirst($user->role) }}

                                    @endif

                                </td>


                                <td>

                                    <span
                                        style="
                                            display: inline-flex;
                                            align-items: center;
                                            gap: 5px;
                                            padding: 4px 9px;
                                            border-radius: 12px;
                                            background: var(--green-light);
                                            color: var(--green);
                                            font-size: 8px;
                                            font-weight: 500;
                                        "
                                    >

                                        <span
                                            style="
                                                width: 6px;
                                                height: 6px;
                                                border-radius: 50%;
                                                background: var(--green);
                                            "
                                        ></span>

                                        Disetujui

                                    </span>

                                </td>


                                <td>

                                    <div
                                        style="
                                            display: flex;
                                            align-items: center;
                                            gap: 6px;
                                        "
                                    >

                                        {{-- EDIT --}}
                                        <button
                                            type="button"
                                            @click="
                                                editUser = {{ $user->id }};
                                                editName = @js($user->name);
                                                editEmail = @js($user->email);
                                                editRole = @js($user->role);
                                                editOpen = true;
                                            "
                                            class="action-btn action-btn-edit"
                                            "
                                        >

                                            <span
                                                class="material-symbols-outlined"
                                                style="font-size: 14px;"
                                            >
                                                edit
                                            </span>

                                            Edit

                                        </button>


                                        {{-- HAPUS --}}
                                        <form
                                            method="POST"
                                            action="{{ route('super-admin.users.destroy', $user) }}"
                                            onsubmit="return confirm('Yakin ingin menghapus akun {{ addslashes($user->name) }}?')"
                                            style="margin: 0;"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="action-btn action-btn-delete"
                                            >

                                                <span
                                                    class="material-symbols-outlined"
                                                    style="font-size: 14px;"
                                                >
                                                    delete
                                                </span>

                                                Hapus

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
    MODAL EDIT PENGGUNA
    ======================================================= --}}
    <div
        x-show="editOpen"
        x-cloak
        x-transition.opacity
        style="
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        "
    >

        {{-- BACKDROP --}}
        <div
            @click="editOpen = false"
            style="
                position: absolute;
                inset: 0;
                background: rgba(0,0,0,.4);
            "
        ></div>


        {{-- MODAL BOX --}}
        <div
            x-show="editOpen"
            x-transition
            @click.stop
            style="
                position: relative;
                width: 100%;
                max-width: 400px;
                background: var(--white);
                border-radius: 16px;
                overflow: hidden;
                box-shadow: 0 12px 35px rgba(0,0,0,.15);
            "
        >

            {{-- MODAL HEADER --}}
            <div
                style="
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    gap: 15px;
                    padding: 18px 20px;
                    border-bottom: 1px solid var(--border);
                "
            >

                <div>

                    <h3
                        style="
                            margin: 0;
                            color: var(--text);
                            font-size: 15px;
                            font-weight: 600;
                        "
                    >
                        Edit Pengguna
                    </h3>

                    <p
                        style="
                            margin: 3px 0 0;
                            color: var(--text-secondary);
                            font-size: 9px;
                        "
                    >
                        Ubah role pengguna.
                    </p>

                </div>


                <button
                    type="button"
                    @click="editOpen = false"
                    style="
                        width: 30px;
                        height: 30px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        border: none;
                        border-radius: 8px;
                        background: transparent;
                        color: var(--muted);
                        cursor: pointer;
                    "
                >

                    <span class="material-symbols-outlined">
                        close
                    </span>

                </button>

            </div>


            {{-- MODAL BODY --}}
            <div style="padding: 20px;">

                <template x-if="editUser">

                    <form
                        method="POST"
                        :action="'{{ url('/super-admin/users') }}/' + editUser + '/role'"
                    >

                        @csrf
                        @method('PATCH')


                        {{-- NAMA --}}
                        <div style="margin-bottom: 15px;">

                            <label
                                style="
                                    display: block;
                                    margin-bottom: 6px;
                                    color: var(--text-secondary);
                                    font-size: 9px;
                                    font-weight: 500;
                                "
                            >
                                Nama
                            </label>

                            <input
                                type="text"
                                x-model="editName"
                                readonly
                                style="
                                    width: 100%;
                                    height: 36px;
                                    padding: 0 11px;
                                    border: 1px solid var(--border);
                                    border-radius: 8px;
                                    background: var(--gray);
                                    color: var(--text-secondary);
                                    font-family: inherit;
                                    font-size: 10px;
                                    outline: none;
                                    box-sizing: border-box;
                                "
                            >

                        </div>


                        {{-- EMAIL --}}
                        <div style="margin-bottom: 15px;">

                            <label
                                style="
                                    display: block;
                                    margin-bottom: 6px;
                                    color: var(--text-secondary);
                                    font-size: 9px;
                                    font-weight: 500;
                                "
                            >
                                Email
                            </label>

                            <input
                                type="email"
                                x-model="editEmail"
                                readonly
                                style="
                                    width: 100%;
                                    height: 36px;
                                    padding: 0 11px;
                                    border: 1px solid var(--border);
                                    border-radius: 8px;
                                    background: var(--gray);
                                    color: var(--text-secondary);
                                    font-family: inherit;
                                    font-size: 10px;
                                    outline: none;
                                    box-sizing: border-box;
                                "
                            >

                        </div>


                        {{-- ROLE --}}
                        <div style="margin-bottom: 20px;">

                            <label
                                style="
                                    display: block;
                                    margin-bottom: 6px;
                                    color: var(--text-secondary);
                                    font-size: 9px;
                                    font-weight: 500;
                                "
                            >
                                Role
                            </label>

                            <div style="position: relative;">

                                <select
                                    name="role"
                                    x-model="editRole"
                                    required
                                    style="
                                        width: 100%;
                                        height: 36px;
                                        padding: 0 35px 0 11px;
                                        border: 1px solid var(--border);
                                        border-radius: 8px;
                                        background: var(--white);
                                        color: var(--text);
                                        font-family: inherit;
                                        font-size: 10px;
                                        outline: none;
                                        appearance: none;
                                        cursor: pointer;
                                        box-sizing: border-box;
                                    "
                                >

                                    <option value="medis">
                                        Medis
                                    </option>

                                    <option value="instruktur">
                                        Instruktur
                                    </option>

                                </select>

                                <span
                                    class="material-symbols-outlined"
                                    style="
                                        position: absolute;
                                        right: 10px;
                                        top: 50%;
                                        transform: translateY(-50%);
                                        pointer-events: none;
                                        color: var(--muted);
                                        font-size: 17px;
                                    "
                                >
                                    keyboard_arrow_down
                                </span>

                            </div>

                        </div>


                        {{-- MODAL ACTION --}}
                        <div
                            style="
                                display: flex;
                                justify-content: flex-end;
                                gap: 8px;
                            "
                        >

                            <button
                                type="button"
                                @click="editOpen = false"
                                style="
                                    height: 32px;
                                    padding: 0 15px;
                                    border: none;
                                    border-radius: 8px;
                                    background: var(--gray);
                                    color: var(--text-secondary);
                                    font-family: inherit;
                                    font-size: 9px;
                                    font-weight: 500;
                                    cursor: pointer;
                                "
                            >
                                Batal
                            </button>


                            <button
                                type="submit"
                                style="
                                    height: 32px;
                                    padding: 0 15px;
                                    border: none;
                                    border-radius: 8px;
                                    background: var(--blue);
                                    color: var(--white);
                                    font-family: inherit;
                                    font-size: 9px;
                                    font-weight: 500;
                                    cursor: pointer;
                                "
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
