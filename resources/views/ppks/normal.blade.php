<x-app-layout>


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

                            <th class="action-column">
                                Aksi
                            </th>

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
                                | PROSES TERAKHIR
                                |--------------------------------------------------------------------------
                                */

                                $prosesTerakhir = $proses
                                    ->sortByDesc(function ($item) {

                                        return $item->tanggal_proses
                                            ?? $item->created_at
                                            ?? 0;

                                    })
                                    ->first();


                                /*
                                |--------------------------------------------------------------------------
                                | DEFAULT
                                |--------------------------------------------------------------------------
                                */

                                $tahapAktif = 'belum_dimulai';

                                $statusAktif = 'belum_dimulai';


                                /*
                                |--------------------------------------------------------------------------
                                | JIKA SUDAH ADA PROSES
                                |--------------------------------------------------------------------------
                                */

                                if ($prosesTerakhir) {

                                    $tahapAktif =
                                        $prosesTerakhir->tahap
                                        ?? 'belum_dimulai';

                                    $statusAktif =
                                        $prosesTerakhir->status
                                        ?? 'belum_dinilai';

                                }


                                /*
                                |--------------------------------------------------------------------------
                                | NORMALISASI TAHAP
                                |--------------------------------------------------------------------------
                                */

                                $tahapAktif = strtolower(
                                    trim((string) $tahapAktif)
                                );


                                switch ($tahapAktif) {

                                    case 'instruktur':

                                    case 'asesmen_instruktur':

                                    case 'asesmen instruktur':

                                        $tahapAktif = 'instruktur';

                                        break;


                                    case 'kesehatan':

                                    case 'kesehatan_awal':

                                    case 'asesmen_kesehatan_awal':

                                    case 'asesmen kesehatan awal':

                                        $tahapAktif = 'kesehatan';

                                        break;


                                    case 'case_conference':

                                    case 'case-conference':

                                    case 'case conference':

                                    case 'cc':

                                        $tahapAktif = 'cc';

                                        break;


                                    case 'diterima':

                                        $tahapAktif = 'diterima';

                                        break;


                                    case 'tidak_diterima':

                                    case 'tidak-diterima':

                                    case 'tidak diterima':

                                        $tahapAktif = 'tidak_diterima';

                                        break;


                                    default:

                                        $tahapAktif = 'belum_dimulai';

                                        break;

                                }


                                /*
                                |--------------------------------------------------------------------------
                                | NORMALISASI STATUS
                                |--------------------------------------------------------------------------
                                */

                                $statusAktif = strtolower(
                                    trim((string) $statusAktif)
                                );


                                /*
                                |--------------------------------------------------------------------------
                                | DEFAULT STATUS
                                |--------------------------------------------------------------------------
                                */

                                $statusLabel = 'Belum Dimulai';

                                $statusClass = 'not-started';


                                /*
                                |--------------------------------------------------------------------------
                                | STATUS PROSES
                                |--------------------------------------------------------------------------
                                */

                                switch ($statusAktif) {

                                    case 'sedang_diperiksa':

                                    case 'sedang-diperiksa':

                                    case 'sedang diperiksa':

                                        $statusLabel = 'Sedang Pengecekan';

                                        $statusClass = 'checking';

                                        break;


                                    case 'belum_dinilai':

                                    case 'belum-dinilai':

                                    case 'belum dinilai':

                                        $statusLabel = 'Belum Dinilai';

                                        $statusClass = 'not-assessed';

                                        break;


                                    case 'pending':

                                        $statusLabel = 'Pending';

                                        $statusClass = 'pending';

                                        break;


                                    case 'lulus':

                                    case 'lulus_asesmen':

                                    case 'lulus-asesmen':

                                    case 'passed':

                                    case 'selesai':

                                        $statusLabel = 'Lulus';

                                        $statusClass = 'passed';

                                        break;


                                    case 'tidak_lulus':

                                    case 'tidak-lulus':

                                    case 'tidak lulus':

                                    case 'failed':

                                        $statusLabel = 'Tidak Lulus';

                                        $statusClass = 'failed';

                                        break;


                                    case 'diterima':

                                        $statusLabel = 'Diterima';

                                        $statusClass = 'passed';

                                        break;


                                    case 'tidak_diterima':

                                    case 'tidak-diterima':

                                    case 'tidak diterima':

                                        $statusLabel = 'Tidak Diterima';

                                        $statusClass = 'failed';

                                        break;


                                    default:

                                        if ($prosesTerakhir) {

                                            $statusLabel = ucfirst(
                                                str_replace(
                                                    ['_', '-'],
                                                    ' ',
                                                    $statusAktif
                                                )
                                            );

                                            $statusClass = 'pending';

                                        }

                                        break;

                                }


                                /*
                                |--------------------------------------------------------------------------
                                | JIKA BELUM ADA PROSES
                                |--------------------------------------------------------------------------
                                */

                                if (!$prosesTerakhir) {

                                    $tahapAktif = 'belum_dimulai';

                                    $statusLabel = 'Belum Dimulai';

                                    $statusClass = 'not-started';

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


                                        {{-- =================================================
                                        BELUM DIMULAI
                                        ================================================== --}}
                                        @if ($tahapAktif === 'belum_dimulai')

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


                                                {{-- MULAI ASESMEN --}}
                                                <form
                                                    method="POST"
                                                    action="{{ route('ppks.mulai-asesmen', $data) }}"
                                                    onsubmit="return confirm('Mulai Asesmen Instruktur untuk data ini?')"
                                                >

                                                    @csrf

                                                    <button
                                                        type="submit"
                                                        class="start-assessment-button"
                                                    >
                                                        Mulai
                                                    </button>

                                                </form>

                                            </div>


                                        {{-- =================================================
                                        ASESMEN INSTRUKTUR
                                        ================================================== --}}
                                        @elseif ($tahapAktif === 'instruktur')

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


                                                <span class="tahapan-arrow">
                                                    ›
                                                </span>

                                            </div>


                                        {{-- =================================================
                                        ASESMEN KESEHATAN AWAL
                                        ================================================== --}}
                                        @elseif ($tahapAktif === 'kesehatan')

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


                                                <span class="tahapan-arrow">
                                                    ›
                                                </span>

                                            </div>


                                        {{-- =================================================
                                        CASE CONFERENCE
                                        ================================================== --}}
                                        @elseif ($tahapAktif === 'cc')

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


                                                <span class="tahapan-arrow">
                                                    ›
                                                </span>

                                            </div>


                                        {{-- =================================================
                                        DITERIMA
                                        ================================================== --}}
                                        @elseif ($tahapAktif === 'diterima')

                                            <div class="tahapan-card tahapan-accepted">

                                                <div class="tahapan-icon">

                                                    <span class="material-symbols-outlined">
                                                        check_circle
                                                    </span>

                                                </div>


                                                <div class="tahapan-content">

                                                    <span class="tahapan-title">
                                                        Diterima
                                                    </span>

                                                    <span class="tahapan-status passed">

                                                        <span class="status-dot"></span>

                                                        Diterima

                                                    </span>

                                                </div>

                                            </div>


                                        {{-- =================================================
                                        TIDAK DITERIMA
                                        ================================================== --}}
                                        @elseif ($tahapAktif === 'tidak_diterima')

                                            <div class="tahapan-card tahapan-rejected">

                                                <div class="tahapan-icon">

                                                    <span class="material-symbols-outlined">
                                                        cancel
                                                    </span>

                                                </div>


                                                <div class="tahapan-content">

                                                    <span class="tahapan-title">
                                                        Tidak Diterima
                                                    </span>

                                                    <span class="tahapan-status failed">

                                                        <span class="status-dot"></span>

                                                        Tidak Diterima

                                                    </span>

                                                </div>

                                            </div>

                                        @endif

                                    </div>

                                </td>


                                {{-- =====================================================
                                AKSI
                                ====================================================== --}}
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
                        inbox
                    </span>

                </div>


                <h3>
                    Belum ada data normal
                </h3>


                <p>
                    Data PPKS yang telah dinyatakan normal akan muncul di sini.
                </p>

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
    TOMBOL MULAI
    ========================================================== */

    .start-assessment-button {

        display: inline-flex;

        align-items: center;
        justify-content: center;

        min-width: 55px;

        height: 30px;

        padding: 0 11px;

        border: 1px solid #93c5fd;

        border-radius: 7px;

        background: #ffffff;

        color: #2563eb;

        font-size: 10px;

        font-weight: 700;

        cursor: pointer;

        transition:
            background .15s ease,
            border-color .15s ease,
            transform .15s ease;

    }


    .start-assessment-button:hover {

        background: #eff6ff;

        border-color: #60a5fa;

        transform: translateY(-1px);

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

    }

</style>


</x-app-layout>
