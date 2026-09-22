<x-app-layout>

<div class="main-page">

    {{-- =====================================================
    HEADER
    ======================================================= --}}
    <div class="main-page-header">

        <div>

            <h1>Data Manual</h1>

            <p>
                Data peserta yang ditambahkan secara manual ke dalam sistem.
            </p>

        </div>


        {{-- =====================================================
        BUTTON TAMBAH DATA
        ======================================================= --}}
        <a
            href="{{ route('ppks.normal.create') }}"
            class="add-data-button"
        >

            <span class="material-symbols-outlined">
                add
            </span>

            Tambah Data

        </a>

    </div>


    {{-- =====================================================
    FILTER / SEARCH
    ======================================================= --}}
    <div class="filter-wrapper">

        <div class="filter-group">

            {{-- SEARCH --}}
            <form
                method="GET"
                action="{{ route('ppks.manual') }}"
                class="manual-search-form"
            >

                <div class="search">

                    <span class="material-symbols-outlined">
                        search
                    </span>

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari Nama, NIK, atau Jenis PPKS"
                        autocomplete="off"
                    >

                </div>


                <button
                    type="submit"
                    class="manual-search-button"
                >
                    Cari
                </button>

            </form>

        </div>


        {{-- RESET --}}
        @if(request()->filled('search'))

            <a
                href="{{ route('ppks.manual') }}"
                class="filter-reset"
            >

                <span class="material-symbols-outlined">
                    restart_alt
                </span>

                Reset

            </a>

        @endif

    </div>


    {{-- =====================================================
    TABLE
    ======================================================= --}}
    <div class="table-wrapper">

        <table class="table">

            <thead>

                <tr>

                    <th>No</th>
                    <th>Nama</th>
                    <th>NIK</th>
                    <th>Umur</th>
                    <th>Jenis PPKS</th>
                    <th>Jurusan</th>
                    <th>Aksi</th>

                </tr>

            </thead>


            <tbody>

                @forelse ($ppks as $index => $peserta)

                    @php

                        /*
                        |--------------------------------------------------------------------------
                        | DATA PPKS
                        |--------------------------------------------------------------------------
                        */

                        $data = is_array($peserta->data)
                            ? $peserta->data
                            : [];


                        /*
                        |--------------------------------------------------------------------------
                        | NAMA
                        |--------------------------------------------------------------------------
                        */

                        $nama =
                            $data['nama_lengkap']
                            ?? $data['nama']
                            ?? $data['Nama Lengkap']
                            ?? '-';


                        /*
                        |--------------------------------------------------------------------------
                        | NIK
                        |--------------------------------------------------------------------------
                        */

                        $nik =
                            $data['nik']
                            ?? $data['NIK']
                            ?? '-';


                        /*
                        |--------------------------------------------------------------------------
                        | UMUR
                        |--------------------------------------------------------------------------
                        */

                        $umur =
                            $data['usia']
                            ?? $data['umur']
                            ?? '-';


                        /*
                        |--------------------------------------------------------------------------
                        | JENIS PPKS
                        |--------------------------------------------------------------------------
                        */

                        $jenisPpks =
                            $data['jenis_ppks']
                            ?? $data['jenis PPKS']
                            ?? $data['Jenis PPKS']
                            ?? '-';


                        /*
                        |--------------------------------------------------------------------------
                        | JURUSAN
                        |--------------------------------------------------------------------------
                        */

                        $jurusan =
                            $data['jurusan']
                            ?? $data['Jurusan']
                            ?? '-';

                    @endphp


                    <tr>

                        {{-- NO --}}
                        <td>
                            {{ $ppks->firstItem() + $index }}
                        </td>


                        {{-- NAMA --}}
                        <td>
                            {{ $nama }}
                        </td>


                        {{-- NIK --}}
                        <td>
                            {{ $nik }}
                        </td>


                        {{-- UMUR --}}
                        <td>
                            {{ $umur }}
                        </td>


                        {{-- JENIS PPKS --}}
                        <td>
                            {{ $jenisPpks }}
                        </td>


                        {{-- JURUSAN --}}
                        <td>
                            {{ $jurusan }}
                        </td>


                        {{-- AKSI --}}
                        <td>

                            <div class="action-buttons">

                                {{-- EDIT --}}
                                <a
                                    href="{{ route('ppks.normal.edit', $peserta->id) }}"
                                    class="action-button edit"
                                    title="Edit"
                                >

                                    <span class="material-symbols-outlined">
                                        edit
                                    </span>

                                </a>


                                {{-- HAPUS --}}
                                <form
                                    action="{{ route('ppks.normal.destroy', $peserta->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');"
                                >

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="action-button delete"
                                        title="Hapus"
                                    >

                                        <span class="material-symbols-outlined">
                                            delete
                                        </span>

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>


                @empty

                    <tr>

                        <td
                            colspan="7"
                            style="
                                text-align: center;
                                padding: 40px;
                                color: var(--muted);
                            "
                        >

                            @if(request()->filled('search'))

                                Data tidak ditemukan.

                            @else

                                Belum ada data manual.

                            @endif

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    {{-- =====================================================
    PAGINATION
    ======================================================= --}}
    @if ($ppks instanceof \Illuminate\Pagination\LengthAwarePaginator)

        <div class="pagination-wrapper">

            {{ $ppks->links() }}

        </div>

    @endif

</div>


{{-- =====================================================
STYLE KHUSUS DATA MANUAL
HANYA UNTUK ELEMEN YANG BELUM ADA DI CSS UTAMA
======================================================= --}}
<style>

    /* =====================================================
       BUTTON TAMBAH DATA
    ======================================================= */

    .add-data-button {

        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;

        height: 35px;

        padding: 0 14px;

        background: var(--blue);
        color: var(--white);

        border: 1px solid var(--blue);
        border-radius: 16px;

        text-decoration: none;

        font-family: inherit;
        font-size: 10px;
        font-weight: 500;

        white-space: nowrap;

        transition: 0.15s ease;

    }


    .add-data-button:hover {

        opacity: 0.9;

    }


    .add-data-button .material-symbols-outlined {

        font-size: 16px;

    }


    /* =====================================================
       SEARCH FORM
    ======================================================= */

    .manual-search-form {

        display: flex;
        align-items: center;
        gap: 8px;

        margin: 0;

        flex: 1;

    }


    .manual-search-form .search {

        flex: 1;
        width: auto;

    }


    /* =====================================================
       BUTTON CARI
    ======================================================= */

    .manual-search-button {

        height: 35px;

        padding: 0 14px;

        background: var(--blue);
        color: var(--white);

        border: 1px solid var(--blue);
        border-radius: 16px;

        font-family: inherit;
        font-size: 9px;
        font-weight: 500;

        cursor: pointer;

        white-space: nowrap;

        transition: 0.15s ease;

    }


    .manual-search-button:hover {

        opacity: 0.9;

    }


    /* =====================================================
       ACTION
    ======================================================= */

    .action-buttons {

        display: flex;
        align-items: center;
        gap: 6px;

    }


    .action-buttons form {

        margin: 0;

        padding: 0;

    }


    .action-button {

        width: 30px;
        height: 30px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 10px;

        border: 1px solid transparent;

        cursor: pointer;

        text-decoration: none;

        transition: 0.15s ease;

    }


    .action-button .material-symbols-outlined {

        font-size: 16px;

    }


    /* EDIT */

    .action-button.edit {

        background: var(--light-green);
        color: var(--green);
        border-color: var(--light-green);

    }


    .action-button.edit:hover {

        opacity: 0.85;

    }


    /* DELETE */

    .action-button.delete {

        background: var(--light-red);
        color: var(--red);
        border-color: var(--light-red);

    }


    .action-button.delete:hover {

        opacity: 0.85;

    }


    /* =====================================================
       RESPONSIVE
    ======================================================= */

    @media (max-width: 768px) {

        .main-page-header {

            align-items: flex-start;

        }


        .add-data-button {

            flex-shrink: 0;

        }


        .manual-search-form {

            width: 100%;

        }


        .manual-search-form .search {

            min-width: 0;

        }

    }

</style>

</x-app-layout>
