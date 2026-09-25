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
            class="btn-primary"
        >

            <span class="material-symbols-outlined">
                add_box
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
                    <th>Jurusan Peminatan</th>
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

                            <div style="display: inline-flex; align-items: center; gap: 6px; flex-wrap: nowrap;">

                                {{-- EDIT --}}
                                <a
                                    href="{{ route('ppks.normal.edit', $peserta->id) }}"
                                    class="action-btn action-btn-edit"
                                    title="Edit"
                                >

                                    <span class="material-symbols-outlined">
                                        edit
                                    </span>
                                    <span>
                                        Edit
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
                                        class="action-btn action-btn-delete"
                                        title="Hapus"
                                    >

                                        <span class="material-symbols-outlined">
                                            delete
                                        </span>

                                        <span> Hapus</span>

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

</x-app-layout>
