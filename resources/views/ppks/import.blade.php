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

                <span>
                    {{ session('success') }}
                </span>

            </div>
        </div>
    @endif


    @if (session('error'))
        <div class="main-page">
            <div class="approval-alert approval-alert-error">

                <span class="material-symbols-outlined">
                    error
                </span>

                <span>
                    {{ session('error') }}
                </span>

            </div>
        </div>
    @endif


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
                    Kelola dan perbarui data peserta dari Google Sheets.
                </p>

            </div>

        </div>


        {{-- =====================================================
        OVERVIEW
        ====================================================== --}}

        <div class="import-overview">


            {{-- =================================================
            IMPORT DATA
            ================================================== --}}

            <section class="import-card import-action-card">

                <div class="import-card-content">

                    <span class="import-card-label">
                        IMPORT DATA
                    </span>

                    <h2>
                        Import data peserta
                    </h2>

                    <p>
                        Tambahkan data yang belum tersedia di SIATIS.
                    </p>

                </div>


                <form
                    action="{{ route('ppks.import.process') }}"
                    method="POST"
                    class="import-card-action"
                >

                    @csrf

                    <button
                        type="submit"
                        class="import-button"
                        onclick="return confirm('Import data peserta baru dari Google Sheets sekarang?')"
                    >

                        <span class="material-symbols-outlined">
                            cloud_download
                        </span>

                        <span>
                            Import Data
                        </span>

                    </button>

                </form>

            </section>


            {{-- =================================================
            DATA SAAT INI
            ================================================== --}}

            <section class="import-card import-current-card">

                <span class="import-card-label">
                    DATA SAAT INI
                </span>

                <div class="current-data-number">
                    {{ number_format($totalImported ?? 0) }}
                </div>

                <div class="current-data-label">
                    Data peserta
                </div>

            </section>


        </div>


        {{-- =====================================================
        RIWAYAT IMPORT
        ====================================================== --}}

        <section class="content-card import-history">

            <div class="import-heading">

                <div>

                    <h2>
                        Riwayat Import
                    </h2>

                    <p>
                        Riwayat proses import data peserta.
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

                                        <div class="import-time">
                                            {{ $log->started_at->format('H:i:s') }}
                                        </div>

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

                                <td colspan="6">

                                    <div class="import-empty">

                                        <span class="material-symbols-outlined">
                                            history
                                        </span>

                                        <strong>
                                            Belum ada riwayat import
                                        </strong>

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </section>

</div>

</x-app-layout>

