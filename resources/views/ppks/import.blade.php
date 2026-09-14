<x-app-layout>

    {{-- =========================================================
    PESAN HASIL
    ========================================================== --}}

    @if (session('success'))
        <div class="main-page">
            <div class="approval-alert approval-alert-success">
                <span class="material-symbols-outlined">
                    check_circle
                </span>

                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="main-page">
            <div class="approval-alert approval-alert-error">
                <span class="material-symbols-outlined">
                    error
                </span>

                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif


    {{-- =========================================================
    MAIN CONTENT
    ========================================================== --}}

    <div class="main-page">

        {{-- =====================================================
        HEADER
        ====================================================== --}}

        <div class="main-page-header">

            <div>

                <h1>
                    Import Data PPKS
                </h1>

                <p>
                    Ambil data peserta dari Google Sheets dan kelola pembaruannya di SIATIS.
                </p>

            </div>

        </div>


        {{-- =====================================================
        IMPORT DATA
        ====================================================== --}}

        <section class="content-card import-main-card">

            {{-- =================================================
            SUMBER DATA
            ================================================== --}}

            <div class="import-source-header">

                <div class="import-source">

                    <div class="import-source-icon">

                        <span class="material-symbols-outlined">
                            table_chart
                        </span>

                    </div>

                    <div>

                        <span class="import-source-label">
                            SUMBER DATA
                        </span>

                        <h2>
                            Google Sheets
                        </h2>

                        <p>
                            Data peserta yang digunakan untuk proses import SIATIS.
                        </p>

                    </div>

                </div>


                <div class="import-connected">

                    <span class="import-connected-dot"></span>

                    Terhubung

                </div>

            </div>


            {{-- =================================================
            AKSI
            ================================================== --}}

            <div class="import-action-grid">

                {{-- =================================================
                IMPORT BARU
                ================================================== --}}

                <div class="import-action-card">

                    <div class="import-action-top">

                        <div class="import-action-icon blue">

                            <span class="material-symbols-outlined">
                                cloud_download
                            </span>

                        </div>

                        <span class="import-action-number">
                            01
                        </span>

                    </div>


                    <div class="import-action-content">

                        <h3>
                            Import Data Baru
                        </h3>

                        <p>
                            Menambahkan peserta dari Google Sheets yang belum
                            tersedia di SIATIS.
                        </p>

                    </div>


                    <form
                        action="{{ route('ppks.import.process') }}"
                        method="POST"
                    >

                        @csrf

                        <button
                            type="submit"
                            class="import-action-button primary"
                            onclick="return confirm('Import data peserta baru dari Google Sheets sekarang?')"
                        >

                            <span>
                                Import Data Baru
                            </span>

                            <span class="material-symbols-outlined">
                                arrow_forward
                            </span>

                        </button>

                    </form>

                </div>


                {{-- =================================================
                SINKRONISASI
                ================================================== --}}

                <div class="import-action-card">

                    <div class="import-action-top">

                        <div class="import-action-icon orange">

                            <span class="material-symbols-outlined">
                                sync
                            </span>

                        </div>

                        <span class="import-action-number">
                            02
                        </span>

                    </div>


                    <div class="import-action-content">

                        <h3>
                            Sinkronkan Data
                        </h3>

                        <p>
                            Memeriksa dan memperbarui data peserta yang sudah
                            tersimpan berdasarkan data terbaru.
                        </p>

                    </div>


                    <form
                        action="{{ route('ppks.import.recheck') }}"
                        method="POST"
                    >

                        @csrf

                        <button
                            type="submit"
                            class="import-action-button warning"
                            onclick="return confirm('Sinkronkan data peserta dengan Google Sheets sekarang?')"
                        >

                            <span>
                                Sinkronkan Data
                            </span>

                            <span class="material-symbols-outlined">
                                arrow_forward
                            </span>

                        </button>

                    </form>

                </div>

            </div>

        </section>


        {{-- =====================================================
        RINGKASAN DATA
        ====================================================== --}}

        <section class="content-card import-overview">

            <div class="import-section-header">

                <div>

                    <h2>
                        Ringkasan Data
                    </h2>

                    <p>
                        Informasi singkat mengenai data yang tersedia saat ini.
                    </p>

                </div>

            </div>


            <div class="import-overview-grid">

                {{-- TOTAL DATA --}}
                <div class="import-overview-item">

                    <div class="import-overview-icon blue">

                        <span class="material-symbols-outlined">
                            database
                        </span>

                    </div>

                    <div>

                        <span>
                            Data Peserta
                        </span>

                        <strong>
                            {{ number_format($totalImported ?? 0) }}
                        </strong>

                    </div>

                </div>


                {{-- SUMBER --}}
                <div class="import-overview-item">

                    <div class="import-overview-icon green">

                        <span class="material-symbols-outlined">
                            table_chart
                        </span>

                    </div>

                    <div>

                        <span>
                            Sumber Data
                        </span>

                        <strong>
                            Google Sheets
                        </strong>

                    </div>

                </div>

            </div>

        </section>


        {{-- =====================================================
        RIWAYAT IMPORT
        ====================================================== --}}

        <section class="content-card import-history">

            <div class="import-section-header">

                <div>

                    <h2>
                        Riwayat Import
                    </h2>

                    <p>
                        Hasil proses import dan sinkronisasi data peserta.
                    </p>

                </div>

            </div>


            <div class="table-wrapper">

                <table class="table">

                    <thead>

                        <tr>

                            <th>
                                Tanggal & Waktu
                            </th>

                            <th class="text-center">
                                Data Ditemukan
                            </th>

                            <th class="text-center">
                                Data Normal
                            </th>

                            <th class="text-center">
                                Perlu Diperiksa
                            </th>

                            <th class="text-center">
                                Data Diperbarui
                            </th>

                            <th class="text-center">
                                Status
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse (($importLogs ?? collect()) as $log)

                            <tr>

                                {{-- TANGGAL --}}
                                <td>

                                    <div class="import-date">
                                        {{ $log->started_at?->format('d M Y') ?? '-' }}
                                    </div>

                                    @if ($log->started_at)

                                        <small class="import-time">
                                            {{ $log->started_at->format('H:i:s') }}
                                        </small>

                                    @endif

                                </td>


                                {{-- DATA DITEMUKAN --}}
                                <td class="text-center">

                                    {{ number_format($log->data_ditemukan ?? 0) }}

                                </td>


                                {{-- DATA NORMAL --}}
                                <td class="text-center">

                                    <span class="import-number import-number-green">
                                        {{ number_format($log->data_normal ?? 0) }}
                                    </span>

                                </td>


                                {{-- PERLU DIPERIKSA --}}
                                <td class="text-center">

                                    <span class="import-number import-number-orange">
                                        {{ number_format($log->data_perlu_diperiksa ?? 0) }}
                                    </span>

                                </td>


                                {{-- DATA DIPERBARUI --}}
                                <td class="text-center">

                                    {{ number_format($log->data_diupdate ?? 0) }}

                                </td>


                                {{-- STATUS --}}
                                <td class="text-center">

                                    @if ($log->status === 'berhasil')

                                        <span class="result-badge result-accepted">

                                            <span class="result-icon">

                                                <span class="material-symbols-outlined">
                                                    check_circle
                                                </span>

                                            </span>

                                            <span class="result-content">

                                                <span class="result-title">
                                                    Berhasil
                                                </span>

                                            </span>

                                        </span>

                                    @elseif ($log->status === 'gagal')

                                        <span class="result-badge result-rejected">

                                            <span class="result-icon">

                                                <span class="material-symbols-outlined">
                                                    error
                                                </span>

                                            </span>

                                            <span class="result-content">

                                                <span class="result-title">
                                                    Gagal
                                                </span>

                                            </span>

                                        </span>

                                    @else

                                        <span class="result-badge result-instructor">

                                            <span class="result-icon">

                                                <span class="material-symbols-outlined">
                                                    sync
                                                </span>

                                            </span>

                                            <span class="result-content">

                                                <span class="result-title">
                                                    Sedang Diproses
                                                </span>

                                            </span>

                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="6"
                                    style="text-align: center;"
                                >

                                    <div class="import-empty">

                                        <span class="material-symbols-outlined">
                                            history
                                        </span>

                                        <strong>
                                            Belum ada riwayat import
                                        </strong>

                                        <p>
                                            Riwayat proses import akan muncul setelah data diproses.
                                        </p>

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </section>

    </div>


    {{-- =========================================================
    CSS TAMBAHAN
    ========================================================== --}}

    <style>

        /* =====================================================
           IMPORT MAIN
        ====================================================== */

        .import-main-card {
            margin-bottom: 20px;
        }

        .import-source-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .import-source {
            display: flex;
            align-items: center;
            gap: 13px;
        }

        .import-source-icon {
            width: 44px;
            height: 44px;
            flex-shrink: 0;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 11px;

            background: var(--green-light);
            color: var(--green);
        }

        .import-source-icon .material-symbols-outlined {
            font-size: 22px;
        }

        .import-source-label {
            display: block;

            margin-bottom: 2px;

            font-size: 9px;
            font-weight: 600;
            letter-spacing: .6px;

            color: var(--muted);
        }

        .import-source h2 {
            margin: 0;

            font-size: 15px;
            font-weight: 700;

            color: var(--text);
        }

        .import-source p {
            margin: 2px 0 0;

            font-size: 10px;

            color: var(--text-secondary);
        }

        .import-connected {
            display: inline-flex;
            align-items: center;
            gap: 6px;

            padding: 6px 10px;

            border-radius: 8px;

            background: var(--green-light);
            color: var(--green);

            font-size: 10px;
            font-weight: 600;
        }

        .import-connected-dot {
            width: 6px;
            height: 6px;

            border-radius: 50%;

            background: var(--green);
        }


        /* =====================================================
           ACTION CARDS
        ====================================================== */

        .import-action-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));

            gap: 14px;

            margin-top: 22px;
        }

        .import-action-card {
            display: flex;
            flex-direction: column;

            min-width: 0;

            padding: 17px;

            border: 1px solid var(--border);
            border-radius: var(--radius);

            background: var(--white);

            transition:
                border-color .2s ease,
                box-shadow .2s ease,
                transform .2s ease;
        }

        .import-action-card:hover {
            border-color: var(--border);

            box-shadow: 0 6px 18px rgba(0, 0, 0, .05);

            transform: translateY(-1px);
        }

        .import-action-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .import-action-icon {
            width: 40px;
            height: 40px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 10px;
        }

        .import-action-icon.blue {
            background: var(--blue-light);
            color: var(--blue);
        }

        .import-action-icon.orange {
            background: var(--orange-light);
            color: var(--orange);
        }

        .import-action-icon .material-symbols-outlined {
            font-size: 20px;
        }

        .import-action-number {
            font-size: 10px;
            font-weight: 600;

            color: var(--muted);
        }

        .import-action-content {
            flex: 1;

            margin: 15px 0 17px;
        }

        .import-action-content h3 {
            margin: 0 0 5px;

            font-size: 14px;
            font-weight: 700;

            color: var(--text);
        }

        .import-action-content p {
            max-width: 430px;

            margin: 0;

            font-size: 11px;
            line-height: 1.55;

            color: var(--text-secondary);
        }


        /* =====================================================
           ACTION BUTTON
        ====================================================== */

        .import-action-card form {
            width: 100%;
        }

        .import-action-button {
            width: 100%;
            height: 37px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 0 12px;

            border: 0;
            border-radius: 8px;

            font-family: inherit;
            font-size: 11px;
            font-weight: 600;

            cursor: pointer;

            transition:
                filter .2s ease,
                transform .2s ease,
                box-shadow .2s ease;
        }

        .import-action-button .material-symbols-outlined {
            font-size: 17px;
        }

        .import-action-button.primary {
            background: var(--blue);
            color: var(--white);

            box-shadow: 0 3px 8px rgba(32, 93, 145, .12);
        }

        .import-action-button.warning {
            background: var(--orange);
            color: var(--white);

            box-shadow: 0 3px 8px rgba(245, 158, 11, .12);
        }

        .import-action-button:hover {
            filter: brightness(.94);

            transform: translateY(-1px);
        }

        .import-action-button.primary:hover {
            box-shadow: 0 5px 12px rgba(32, 93, 145, .18);
        }

        .import-action-button.warning:hover {
            box-shadow: 0 5px 12px rgba(245, 158, 11, .18);
        }

        .import-action-button:active {
            transform: translateY(0);

            box-shadow: none;
        }


        /* =====================================================
           RINGKASAN
        ====================================================== */

        .import-overview {
            margin-bottom: 20px;
        }

        .import-section-header {
            margin-bottom: 15px;
        }

        .import-section-header h2 {
            margin: 0 0 4px;

            font-size: 15px;
            font-weight: 700;

            color: var(--text);
        }

        .import-section-header p {
            margin: 0;

            font-size: 11px;

            color: var(--text-secondary);
        }

        .import-overview-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));

            gap: 12px;
        }

        .import-overview-item {
            display: flex;
            align-items: center;

            gap: 11px;

            padding: 13px 15px;

            border: 1px solid var(--border);
            border-radius: 10px;
        }

        .import-overview-icon {
            width: 36px;
            height: 36px;
            flex-shrink: 0;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 9px;
        }

        .import-overview-icon.blue {
            background: var(--blue-light);
            color: var(--blue);
        }

        .import-overview-icon.green {
            background: var(--green-light);
            color: var(--green);
        }

        .import-overview-icon .material-symbols-outlined {
            font-size: 19px;
        }

        .import-overview-item div:last-child {
            display: flex;
            flex-direction: column;
        }

        .import-overview-item span {
            font-size: 10px;

            color: var(--muted);
        }

        .import-overview-item strong {
            margin-top: 2px;

            font-size: 15px;

            color: var(--text);
        }


        /* =====================================================
           RIWAYAT
        ====================================================== */

        .import-history {
            margin-bottom: 20px;
        }

        .import-date {
            font-size: 12px;
            font-weight: 600;

            color: var(--text);
        }

        .import-time {
            font-size: 11px;

            color: var(--muted);
        }

        .import-number {
            font-weight: 700;
        }

        .import-number-green {
            color: var(--green);
        }

        .import-number-orange {
            color: var(--orange);
        }

        .import-empty {
            display: flex;
            flex-direction: column;
            align-items: center;

            gap: 4px;

            padding: 25px 0;

            color: var(--muted);
        }

        .import-empty .material-symbols-outlined {
            margin-bottom: 4px;

            font-size: 30px;
        }

        .import-empty strong {
            font-size: 13px;

            color: var(--text-secondary);
        }

        .import-empty p {
            margin: 0;

            font-size: 11px;
        }


        /* =====================================================
           RESPONSIVE
        ====================================================== */

        @media (max-width: 800px) {

            .import-action-grid,
            .import-overview-grid {
                grid-template-columns: 1fr;
            }

        }

        @media (max-width: 500px) {

            .import-source-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .import-connected {
                align-self: flex-start;
            }

        }

    </style>

</x-app-layout>
