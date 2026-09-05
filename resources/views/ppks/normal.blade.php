<x-app-layout>

```
<div class="data-normal-page">

    {{-- =========================================================
    HEADER
    ========================================================== --}}
    <div class="data-normal-header">

        <div class="header-title-wrapper">

            <div class="header-icon">
                <span class="material-symbols-outlined">
                    verified
                </span>
            </div>

            <div class="header-text">

                <h1>Data Normal</h1>

                <p>
                    Data PPKS yang telah dipilih dan dinyatakan normal.
                </p>

            </div>

        </div>

    </div>


    {{-- =========================================================
    NOTIFIKASI
    ========================================================== --}}
    @if (session('success'))

        <div class="success-alert">

            <span class="material-symbols-outlined">
                check_circle
            </span>

            <span>
                {{ session('success') }}
            </span>

        </div>

    @endif


    @if (session('error'))

        <div class="error-alert">

            <span class="material-symbols-outlined">
                error
            </span>

            <span>
                {{ session('error') }}
            </span>

        </div>

    @endif


    {{-- =========================================================
    SEARCH
    ========================================================== --}}
    <div class="data-normal-toolbar">

        <form
            method="GET"
            action="{{ request()->url() }}"
            class="data-normal-search"
        >

            <span class="material-symbols-outlined search-icon">
                search
            </span>

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari nama, NIK, jenis PPKS, atau no HP..."
                autocomplete="off"
            >

            @if (request('search'))

                <a
                    href="{{ request()->url() }}"
                    class="clear-search"
                    title="Hapus pencarian"
                >
                    <span class="material-symbols-outlined">
                        close
                    </span>
                </a>

            @endif

            <button
                type="submit"
                class="search-button"
            >
                Cari
            </button>

        </form>

    </div>


    {{-- =========================================================
    TABLE
    ========================================================== --}}
    <div class="data-normal-table-wrapper">

        @if ($ppks->count() > 0)

            <div class="table-scroll">

                <table class="data-normal-table">

                    {{-- =================================================
                    TABLE HEADER
                    ================================================== --}}
                    <thead>

                        <tr>

                            <th class="no-column">
                                No
                            </th>

                            <th>
                                Nama
                            </th>

                            <th>
                                NIK
                            </th>

                            <th>
                                Jenis Kelamin
                            </th>

                            <th>
                                Jenis PPKS
                            </th>

                            <th>
                                No HP
                            </th>

                            <th class="tahapan-column">
                                Tahapan
                            </th>

{{--
<th class="action-column">
    Aksi
</th>
--}}

                        </tr>

                    </thead>


                    {{-- =================================================
                    TABLE BODY
                    ================================================== --}}
                    <tbody>

                        @foreach ($ppks as $index => $data)

                            @php

                                /*
                                |--------------------------------------------------------------------------
                                | DATA PPKS
                                |--------------------------------------------------------------------------
                                */

                                $row = is_array($data->data ?? null)
                                    ? $data->data
                                    : [];


                                /*
                                |--------------------------------------------------------------------------
                                | NAMA
                                |--------------------------------------------------------------------------
                                */

                                $nama =
                                    $row['nama_lengkap']
                                    ?? $row['Nama Lengkap']
                                    ?? $row[1]
                                    ?? '-';


                                /*
                                |--------------------------------------------------------------------------
                                | NIK
                                |--------------------------------------------------------------------------
                                */

                                $nik =
                                    $row['nik']
                                    ?? $row['NIK']
                                    ?? $row[2]
                                    ?? '-';


                                /*
                                |--------------------------------------------------------------------------
                                | JENIS KELAMIN
                                |--------------------------------------------------------------------------
                                */

                                $jenisKelamin =
                                    $row['jenis_kelamin']
                                    ?? $row['Jenis Kelamin']
                                    ?? $row['jenis kelamin']
                                    ?? $row[3]
                                    ?? '-';


                                /*
                                |--------------------------------------------------------------------------
                                | JENIS PPKS
                                |--------------------------------------------------------------------------
                                */

                                $jenisPpks =
                                    $row['jenis_ppks']
                                    ?? $row['Jenis PPKS']
                                    ?? $row[12]
                                    ?? '-';


                                /*
                                |--------------------------------------------------------------------------
                                | NO HP
                                |--------------------------------------------------------------------------
                                */

                                $noHp =
                                    $row['no_hp_1']
                                    ?? $row['No HP 1']
                                    ?? $row['No Telepon']
                                    ?? $row['No Telepon 1']
                                    ?? $row[20]
                                    ?? '-';

/*
|--------------------------------------------------------------------------
| PROSES PPKS
|--------------------------------------------------------------------------
*/

$proses = $data->prosesPesertas ?? collect();

/*
|--------------------------------------------------------------------------
| PISAHKAN PROSES BERDASARKAN TAHAP
|--------------------------------------------------------------------------
*/

$prosesPerTahap = [
    'instruktur' => null,
    'kesehatan_awal' => null,
    'case_conference' => null,
];

foreach ($proses as $item) {

    $tahap = strtolower(
        trim((string) ($item->tahap ?? ''))
    );

    if (in_array($tahap, [
        'instruktur',
        'asesmen_instruktur',
        'asesmen instruktur',
    ], true)) {

        $key = 'instruktur';

    } elseif (in_array($tahap, [
        'kesehatan',
        'kesehatan_awal',
        'asesmen_kesehatan_awal',
        'asesmen kesehatan awal',
    ], true)) {

        $key = 'kesehatan_awal';

    } elseif (in_array($tahap, [
        'case_conference',
        'case-conference',
        'case conference',
        'cc',
    ], true)) {

        $key = 'case_conference';

    } else {
        continue;
    }

    /*
    | Ambil record terbaru kalau ada lebih dari satu
    | record pada tahap yang sama.
    */
    if (
        ! $prosesPerTahap[$key] ||
        (
            $item->created_at &&
            $prosesPerTahap[$key]->created_at &&
            $item->created_at > $prosesPerTahap[$key]->created_at
        )
    ) {
        $prosesPerTahap[$key] = $item;
    }
}
@endphp




                            <tr>

                                {{-- =====================================================
                                NO
                                ====================================================== --}}
                                <td class="no-column">

                                    {{ $ppks->firstItem() + $index }}

                                </td>


                                {{-- =====================================================
                                NAMA
                                ====================================================== --}}
                                <td>

                                    <div class="person-name">

                                        {{ $nama }}

                                    </div>

                                </td>


                                {{-- =====================================================
                                NIK
                                ====================================================== --}}
                                <td>

                                    <span class="nik-text">

                                        {{ $nik }}

                                    </span>

                                </td>


                                {{-- =====================================================
                                JENIS KELAMIN
                                ====================================================== --}}
                                <td>

                                    <span class="gender-text">

                                        {{ $jenisKelamin }}

                                    </span>

                                </td>


                                {{-- =====================================================
                                JENIS PPKS
                                ====================================================== --}}
                                <td>

                                    <span class="ppks-type">

                                        {{ $jenisPpks }}

                                    </span>

                                </td>


                                {{-- =====================================================
                                NO HP
                                ====================================================== --}}
                                <td>

                                    <span class="phone-text">

                                        {{ $noHp }}

                                    </span>

                                </td>


{{-- =====================================================
TAHAPAN
====================================================== --}}
<td class="tahapan-column">

    <div class="tahapan-wrapper">

        @php
            $adaTahapan = false;
        @endphp

        {{-- =================================================
        ASESMEN INSTRUKTUR
        ================================================== --}}

        @if ($prosesPerTahap['instruktur'])

            @php
                $adaTahapan = true;
                $status = strtolower(
                    trim((string) ($prosesPerTahap['instruktur']->status ?? ''))
                );

                if ($status === 'lulus') {
                    $statusLabel = 'Lulus';
                    $statusClass = 'passed';
                } elseif ($status === 'tidak_lulus') {
                    $statusLabel = 'Tidak Lulus';
                    $statusClass = 'failed';
                } elseif ($status === 'pending') {
                    $statusLabel = 'Pending';
                    $statusClass = 'pending';
                } elseif (in_array($status, [
                    'sedang_diperiksa',
                    'sedang-diperiksa',
                    'sedang diperiksa',
                ])) {
                    $statusLabel = 'Sedang Pengecekan';
                    $statusClass = 'checking';
                } else {
                    $statusLabel = 'Belum Dilakukan';
                    $statusClass = 'not-assessed';
                }
            @endphp

            <div class="tahapan-card tahapan-instructor">

                <div class="tahapan-icon">
                    <span class="material-symbols-outlined">
                        person_search
                    </span>
                </div>

                <div class="tahapan-content">

                    <span class="tahapan-title">
                        Asesmen Instruktur
                    </span>

                    <span class="tahapan-status {{ $statusClass }}">

                        <span class="status-dot"></span>

                        {{ $statusLabel }}

                    </span>

                </div>

                @if (
                    $prosesPerTahap['kesehatan_awal'] ||
                    $prosesPerTahap['case_conference']
                )
                    <span class="tahapan-arrow">›</span>
                @endif

            </div>

        @endif


        {{-- =================================================
        ASESMEN KESEHATAN AWAL
        ================================================== --}}

        @if ($prosesPerTahap['kesehatan_awal'])

            @php
                $adaTahapan = true;
                $status = strtolower(
                    trim((string) ($prosesPerTahap['kesehatan_awal']->status ?? ''))
                );

                if ($status === 'lulus') {
                    $statusLabel = 'Lulus';
                    $statusClass = 'passed';
                } elseif ($status === 'tidak_lulus') {
                    $statusLabel = 'Tidak Lulus';
                    $statusClass = 'failed';
                } elseif ($status === 'pending') {
                    $statusLabel = 'Pending';
                    $statusClass = 'pending';
                } elseif (in_array($status, [
                    'sedang_diperiksa',
                    'sedang-diperiksa',
                    'sedang diperiksa',
                ])) {
                    $statusLabel = 'Sedang Pengecekan';
                    $statusClass = 'checking';
                } else {
                    $statusLabel = 'Belum Dilakukan';
                    $statusClass = 'not-assessed';
                }
            @endphp

            <div class="tahapan-card tahapan-health">

                <div class="tahapan-icon">
                    <span class="material-symbols-outlined">
                        medical_services
                    </span>
                </div>

                <div class="tahapan-content">

                    <span class="tahapan-title">
                        Asesmen Kesehatan Awal
                    </span>

                    <span class="tahapan-status {{ $statusClass }}">

                        <span class="status-dot"></span>

                        {{ $statusLabel }}

                    </span>

                </div>

                @if ($prosesPerTahap['case_conference'])
                    <span class="tahapan-arrow">›</span>
                @endif

            </div>

        @endif


        {{-- =================================================
        CASE CONFERENCE
        ================================================== --}}

        @if ($prosesPerTahap['case_conference'])

            @php
                $adaTahapan = true;
                $status = strtolower(
                    trim((string) ($prosesPerTahap['case_conference']->status ?? ''))
                );

                if ($status === 'lulus') {
                    $statusLabel = 'Diterima';
                    $statusClass = 'passed';
                } elseif ($status === 'tidak_lulus') {
                    $statusLabel = 'Tidak Diterima';
                    $statusClass = 'failed';
                } elseif ($status === 'pending') {
                    $statusLabel = 'Pending';
                    $statusClass = 'pending';
                } elseif (in_array($status, [
                    'sedang_diperiksa',
                    'sedang-diperiksa',
                    'sedang diperiksa',
                ])) {
                    $statusLabel = 'Sedang Pengecekan';
                    $statusClass = 'checking';
                } else {
                    $statusLabel = 'Belum Dilakukan';
                    $statusClass = 'not-assessed';
                }
            @endphp

            <div class="tahapan-card tahapan-cc">

                <div class="tahapan-icon">
                    <span class="material-symbols-outlined">
                        groups
                    </span>
                </div>

                <div class="tahapan-content">

                    <span class="tahapan-title">
                        Case Conference
                    </span>

                    <span class="tahapan-status {{ $statusClass }}">

                        <span class="status-dot"></span>

                        {{ $statusLabel }}

                    </span>

                </div>

            </div>

        @endif


        {{-- =================================================
        BELUM ADA PROSES
        ================================================== --}}

        @if (!$adaTahapan)

            <div class="tahapan-card tahapan-not-started">

                <div class="tahapan-icon">

                    <span class="material-symbols-outlined">
                        schedule
                    </span>

                </div>

                <div class="tahapan-content">

                    <span class="tahapan-title">
                        Belum Dimulai
                    </span>

                    <span class="tahapan-status not-started">

                        <span class="status-dot"></span>

                        Belum Dimulai

                    </span>

                </div>

            </div>

        @endif

    </div>

</td>
{{-- =====================================================
AKSI DISEMBUNYIKAN SEMENTARA
======================================================

<td class="action-column">

    <form
        method="POST"
        action="{{ route('ppks.kembalikan', $data) }}"
    >

        @csrf

        @method('PATCH')

        <button
            type="submit"
            class="return-data-button"
            onclick="return confirm('Yakin ingin mengembalikan data ini ke Data Pemeriksaan?')"
        >

            <span class="material-symbols-outlined">
                undo
            </span>

            Kembalikan

        </button>

    </form>

</td>

====================================================== --}}

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>


            {{-- =========================================================
            PAGINATION
            ========================================================== --}}
            <div class="data-normal-pagination">

                {{ $ppks->links() }}

            </div>


        @else

            {{-- =========================================================
            EMPTY
            ========================================================== --}}

            <div class="empty-data-normal">

                <div class="empty-icon">

                    <span class="material-symbols-outlined">
                        @if(request('search'))
                            search_off
                        @else
                            inbox
                        @endif
                    </span>

                </div>


                @if(request('search'))

                    <h3>
                        Data tidak ditemukan
                    </h3>

                    <p>
                        Tidak ada data PPKS yang cocok dengan
                        pencarian "{{ request('search') }}".
                    </p>

                    <a
                        href="{{ request()->url() }}"
                        class="reset-search-button"
                    >
                        <span class="material-symbols-outlined">
                            close
                        </span>

                        Hapus Pencarian
                    </a>

                @else

                    <h3>
                        Belum ada data normal
                    </h3>

                    <p>
                        Data PPKS yang telah dinyatakan normal akan muncul di sini.
                    </p>

                @endif

            </div>

        @endif

    </div>

</div>


{{-- =============================================================
STYLE
============================================================= --}}
<style>

    /* =========================================================
    PAGE
    ========================================================== */

    .data-normal-page {
        width: 100%;
        max-width: 1500px;
        margin: 0 auto;
        padding: 28px 32px 40px;
    }


    /* =========================================================
    HEADER
    ========================================================== */

    .data-normal-header {
        display: flex;
        align-items: center;
        width: 100%;
        margin-bottom: 22px;
        padding: 20px 24px;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        background: #ffffff;
        box-shadow:
            0 1px 2px rgba(15, 23, 42, .03);
    }


    .header-title-wrapper {
        display: flex;
        align-items: center;
        gap: 15px;
        min-width: 0;
    }


    .header-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 48px;
        height: 48px;
        flex-shrink: 0;
        border-radius: 12px;
        background: #eff6ff;
        color: #2563eb;
    }


    .header-icon .material-symbols-outlined {
        font-size: 25px;
    }


    .header-text {
        min-width: 0;
    }


    .data-normal-header h1 {
        margin: 0;
        color: #0f172a;
        font-size: 24px;
        font-weight: 700;
        line-height: 1.25;
    }


    .data-normal-header p {
        margin: 5px 0 0;
        color: #64748b;
        font-size: 13px;
        line-height: 1.5;
    }


    /* =========================================================
    ALERT
    ========================================================== */

    .success-alert,
    .error-alert {
        display: flex;
        align-items: center;
        gap: 9px;
        margin-bottom: 18px;
        padding: 12px 15px;
        border-radius: 9px;
        font-size: 13px;
    }


    .success-alert {
        border: 1px solid #bbf7d0;
        background: #f0fdf4;
        color: #15803d;
    }


    .error-alert {
        border: 1px solid #fecaca;
        background: #fef2f2;
        color: #dc2626;
    }


    .success-alert .material-symbols-outlined,
    .error-alert .material-symbols-outlined {
        font-size: 19px;
    }


    /* =========================================================
    SEARCH TOOLBAR
    ========================================================== */

    .data-normal-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        margin-bottom: 14px;
    }


    .data-normal-search {
        position: relative;
        display: flex;
        align-items: center;
        width: 100%;
        max-width: 520px;
        height: 42px;
    }


    .data-normal-search input {
        width: 100%;
        height: 42px;
        padding: 0 82px 0 40px;
        border: 1px solid #dbe3ec;
        border-radius: 9px;
        outline: none;
        background: #ffffff;
        color: #334155;
        font-family: inherit;
        font-size: 12px;
        transition:
            border-color .15s ease,
            box-shadow .15s ease;
    }


    .data-normal-search input::placeholder {
        color: #94a3b8;
    }


    .data-normal-search input:focus {
        border-color: #60a5fa;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .08);
    }


    .search-icon {
        position: absolute;
        left: 13px;
        z-index: 2;
        color: #94a3b8;
        font-size: 19px;
        pointer-events: none;
    }


    .search-button {
        position: absolute;
        right: 5px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 58px;
        height: 32px;
        border: none;
        border-radius: 6px;
        background: #215b8f;
        color: #ffffff;
        font-family: inherit;
        font-size: 10px;
        font-weight: 600;
        cursor: pointer;
        transition:
            background .15s ease,
            transform .15s ease;
    }


    .search-button:hover {
        background: #194b78;
        transform: translateY(-1px);
    }


    .clear-search {
        position: absolute;
        right: 69px;
        z-index: 3;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 25px;
        height: 25px;
        border-radius: 50%;
        color: #94a3b8;
        text-decoration: none;
    }


    .clear-search:hover {
        background: #f1f5f9;
        color: #475569;
    }


    .clear-search .material-symbols-outlined {
        font-size: 16px;
    }


    /* =========================================================
    TABLE WRAPPER
    ========================================================== */

    .data-normal-table-wrapper {
        width: 100%;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        background: #ffffff;
        box-shadow:
            0 1px 3px rgba(15, 23, 42, .04);
    }


    .table-scroll {
        width: 100%;
        overflow-x: auto;
    }


    .data-normal-table {
        width: 100%;
        min-width: 1280px;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 13px;
    }


    /* =========================================================
    TABLE HEADER
    ========================================================== */

    .data-normal-table thead {
        background: #215b8f;
    }


    .data-normal-table th {
        height: 54px;
        padding: 0 14px;
        border-right: 1px dotted rgba(147, 197, 253, .65);
        color: #ffffff;
        font-size: 12px;
        font-weight: 600;
        text-align: left;
        white-space: nowrap;
        letter-spacing: .01em;
    }


    .data-normal-table th:last-child {
        border-right: none;
    }


    .data-normal-table th:first-child {
        border-top-left-radius: 11px;
    }


    .data-normal-table th:last-child {
        border-top-right-radius: 11px;
    }


    /* =========================================================
    TABLE BODY
    ========================================================== */

    .data-normal-table td {
        height: 64px;
        padding: 9px 14px;
        border-right: 1px dotted #bfdbfe;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        vertical-align: middle;
    }


    .data-normal-table td:last-child {
        border-right: none;
    }


    .data-normal-table tbody tr {
        background: #ffffff;
        transition: background .15s ease;
    }


    .data-normal-table tbody tr:hover {
        background: #f8fbff;
    }


    .data-normal-table tbody tr:last-child td {
        border-bottom: none;
    }


    /* =========================================================
    COLUMN
    ========================================================== */

    .no-column {
        width: 60px;
        min-width: 60px;
        text-align: center !important;
    }


    .person-name {
        min-width: 150px;
        color: #0f172a;
        font-weight: 600;
    }


    .nik-text,
    .gender-text,
    .ppks-type,
    .phone-text {
        color: #475569;
        white-space: nowrap;
    }


    .tahapan-column {
        width: 330px;
        min-width: 330px;
    }


    .action-column {
        width: 145px;
        min-width: 145px;
        text-align: center !important;
    }


    /* =========================================================
    TAHAPAN
    ========================================================== */

    .tahapan-wrapper {
        display: flex;
        flex-direction: column;
        gap: 6px;
        width: 100%;
    }


    .tahapan-card {
        display: flex;
        align-items: center;
        gap: 10px;
        width: 100%;
        min-height: 48px;
        padding: 7px 10px;
        border: 1px solid transparent;
        border-radius: 10px;
    }


    .tahapan-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        flex-shrink: 0;
        border-radius: 8px;
    }


    .tahapan-icon .material-symbols-outlined {
        font-size: 21px;
    }


    .tahapan-content {
        display: flex;
        flex-direction: column;
        flex: 1;
        min-width: 0;
    }


    .tahapan-title {
        overflow: hidden;
        color: #1e293b;
        font-size: 12px;
        font-weight: 600;
        line-height: 1.3;
        text-overflow: ellipsis;
        white-space: nowrap;
    }


    .tahapan-status {
        display: flex;
        align-items: center;
        gap: 5px;
        margin-top: 3px;
        font-size: 10px;
        font-weight: 500;
    }


    .status-dot {
        width: 6px;
        height: 6px;
        flex-shrink: 0;
        border-radius: 50%;
    }


    /* =========================================================
    STATUS
    ========================================================== */

    .tahapan-status.not-started {
        color: #94a3b8;
    }


    .tahapan-status.not-started .status-dot {
        background: #cbd5e1;
    }


    .tahapan-status.not-assessed {
        color: #64748b;
    }


    .tahapan-status.not-assessed .status-dot {
        background: #64748b;
    }


    .tahapan-status.checking {
        color: #2563eb;
    }


    .tahapan-status.checking .status-dot {
        background: #3b82f6;
    }


    .tahapan-status.pending {
        color: #d97706;
    }


    .tahapan-status.pending .status-dot {
        background: #f59e0b;
    }


    .tahapan-status.passed {
        color: #16a34a;
    }


    .tahapan-status.passed .status-dot {
        background: #16a34a;
    }


    .tahapan-status.failed {
        color: #dc2626;
    }


    .tahapan-status.failed .status-dot {
        background: #dc2626;
    }


    /* =========================================================
    WARNA TAHAPAN
    ========================================================== */

    .tahapan-instructor {
        background: #fffbeb;
        border-color: #fef3c7;
    }


    .tahapan-instructor .tahapan-icon {
        background: #fef3c7;
        color: #d97706;
    }


    .tahapan-health {
        background: #eff6ff;
        border-color: #dbeafe;
    }


    .tahapan-health .tahapan-icon {
        background: #dbeafe;
        color: #2563eb;
    }


    .tahapan-cc {
        background: #f5f3ff;
        border-color: #ede9fe;
    }


    .tahapan-cc .tahapan-icon {
        background: #ede9fe;
        color: #7c3aed;
    }


    .tahapan-not-started {
        background: #f8fafc;
        border-color: #e2e8f0;
    }


    .tahapan-not-started .tahapan-icon {
        background: #e2e8f0;
        color: #94a3b8;
    }


    .tahapan-accepted {
        background: #f0fdf4;
        border-color: #dcfce7;
    }


    .tahapan-accepted .tahapan-icon {
        background: #dcfce7;
        color: #16a34a;
    }


    .tahapan-rejected {
        background: #fef2f2;
        border-color: #fee2e2;
    }


    .tahapan-rejected .tahapan-icon {
        background: #fee2e2;
        color: #dc2626;
    }


    /* =========================================================
    ARROW
    ========================================================== */

    .tahapan-arrow {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 24px;
        height: 24px;
        flex-shrink: 0;
        color: #94a3b8;
        font-size: 25px;
        font-weight: 300;
        line-height: 1;
    }




    /* =========================================================
    KEMBALIKAN
    ========================================================== */

    .return-data-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        width: 100%;
        min-height: 34px;
        padding: 0 9px;
        border: 1px solid #fde68a;
        border-radius: 7px;
        background: #fffbeb;
        color: #b45309;
        font-size: 10px;
        font-weight: 600;
        cursor: pointer;
        transition:
            background .15s ease,
            border-color .15s ease,
            transform .15s ease;
    }


    .return-data-button:hover {
        background: #fef3c7;
        border-color: #fcd34d;
        transform: translateY(-1px);
    }


    .return-data-button .material-symbols-outlined {
        font-size: 16px;
    }


    /* =========================================================
    PAGINATION
    ========================================================== */

    .data-normal-pagination {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        padding: 14px 18px;
        border-top: 1px solid #f1f5f9;
        background: #ffffff;
    }


    /* =========================================================
    EMPTY
    ========================================================== */

    .empty-data-normal {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 330px;
        padding: 50px 20px;
        text-align: center;
    }


    .empty-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 64px;
        height: 64px;
        margin-bottom: 15px;
        border-radius: 16px;
        background: #f1f5f9;
        color: #94a3b8;
    }


    .empty-icon .material-symbols-outlined {
        font-size: 32px;
    }


    .empty-data-normal h3 {
        margin: 0;
        color: #475569;
        font-size: 15px;
        font-weight: 600;
    }


    .empty-data-normal p {
        max-width: 420px;
        margin: 7px 0 0;
        color: #94a3b8;
        font-size: 12px;
        line-height: 1.5;
    }


    /* =========================================================
    RESET SEARCH BUTTON
    ========================================================== */

    .reset-search-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        margin-top: 16px;
        padding: 8px 12px;
        border: 1px solid #dbe3ec;
        border-radius: 7px;
        background: #ffffff;
        color: #475569;
        font-size: 11px;
        font-weight: 600;
        text-decoration: none;
        transition:
            background .15s ease,
            border-color .15s ease;
    }


    .reset-search-button:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }


    .reset-search-button .material-symbols-outlined {
        font-size: 16px;
    }


    /* =========================================================
    RESPONSIVE
    ========================================================== */

    @media (max-width: 900px) {

        .data-normal-page {
            padding: 20px 16px 30px;
        }


        .data-normal-header {
            padding: 18px;
        }


        .data-normal-table {
            min-width: 1280px;
        }

    }


    @media (max-width: 600px) {

        .data-normal-page {
            padding: 16px 12px 25px;
        }


        .data-normal-header {
            margin-bottom: 16px;
            padding: 16px;
            border-radius: 11px;
        }


        .header-title-wrapper {
            align-items: flex-start;
        }


        .header-icon {
            width: 42px;
            height: 42px;
        }


        .header-icon .material-symbols-outlined {
            font-size: 22px;
        }


        .data-normal-header h1 {
            font-size: 20px;
        }


        .data-normal-header p {
            font-size: 12px;
        }


        .data-normal-search {
            max-width: none;
        }


        .data-normal-search input {
            font-size: 11px;
        }

    }

</style>
```

</x-app-layout>
