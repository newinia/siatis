<x-app-layout>

    {{-- =========================================================
    POPUP HASIL IMPORT
    ========================================================== --}}

    @if (session('success'))
        <div
            id="importSuccessPopup"
            class="global-popup success show"
        >
            <div class="global-popup-box">

                <div class="global-popup-icon">
                    <span class="material-symbols-outlined">
                        check_circle
                    </span>
                </div>

                <h3 class="global-popup-title">
                    Import Berhasil
                </h3>

                <p class="global-popup-message">
                    {{ session('success') }}
                </p>

                <div class="global-popup-actions">
                    <button
                        type="button"
                        class="global-popup-btn primary"
                        onclick="closeImportPopup('importSuccessPopup')"
                    >
                        Mengerti
                    </button>
                </div>

            </div>
        </div>
    @endif


    @if (session('error'))
        <div
            id="importErrorPopup"
            class="global-popup error show"
        >
            <div class="global-popup-box">

                <div class="global-popup-icon">
                    <span class="material-symbols-outlined">
                        error
                    </span>
                </div>

                <h3 class="global-popup-title">
                    Import Gagal
                </h3>

                <p class="global-popup-message">
                    {{ session('error') }}
                </p>

                <div class="global-popup-actions">
                    <button
                        type="button"
                        class="global-popup-btn danger"
                        onclick="closeImportPopup('importErrorPopup')"
                    >
                        Tutup
                    </button>
                </div>

            </div>
        </div>
    @endif


    {{-- =========================================================
    POPUP KONFIRMASI IMPORT
    ========================================================== --}}

    <div
        id="importConfirmPopup"
        class="global-popup confirm"
    >
        <div class="global-popup-box">

            <div class="global-popup-icon">
                <span class="material-symbols-outlined">
                    cloud_download
                </span>
            </div>

            <h3 class="global-popup-title">
                Import Data?
            </h3>

            <p class="global-popup-message">
                Yakin ingin mengimpor data peserta baru dari Google Sheets sekarang?
            </p>

            <div class="global-popup-actions">

                <button
                    type="button"
                    class="global-popup-btn cancel"
                    onclick="closeImportPopup('importConfirmPopup')"
                >
                    Batal
                </button>

                <button
                    type="button"
                    class="global-popup-btn primary"
                    onclick="confirmImport()"
                >
                    Ya, Import
                </button>

            </div>

        </div>
    </div>


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
                    id="importDataForm"
                    action="{{ route('ppks.import.process') }}"
                    method="POST"
                    class="import-card-action"
                >

                    @csrf

                    <button
                        type="button"
                        class="import-button"
                        onclick="openImportConfirm()"
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


    {{-- =========================================================
    POPUP SCRIPT
    ========================================================== --}}

    <script>

        /*
        |--------------------------------------------------------------------------
        | BUKA POPUP KONFIRMASI IMPORT
        |--------------------------------------------------------------------------
        */

        function openImportConfirm() {

            const popup = document.getElementById('importConfirmPopup');

            if (!popup) {
                return;
            }

            popup.classList.add('show');
        }


        /*
        |--------------------------------------------------------------------------
        | TUTUP POPUP
        |--------------------------------------------------------------------------
        */

        function closeImportPopup(id) {

            const popup = document.getElementById(id);

            if (!popup) {
                return;
            }

            popup.classList.remove('show');

            setTimeout(() => {

                /*
                | Jangan remove popup konfirmasi karena
                | popup tersebut masih bisa digunakan lagi.
                */

                if (id !== 'importConfirmPopup') {
                    popup.remove();
                }

            }, 200);
        }


        /*
        |--------------------------------------------------------------------------
        | KONFIRMASI IMPORT
        |--------------------------------------------------------------------------
        */

        function confirmImport() {

            const form = document.getElementById('importDataForm');

            if (!form) {
                return;
            }

            const popup = document.getElementById('importConfirmPopup');

            /*
            | Tutup popup terlebih dahulu.
            */

            if (popup) {
                popup.classList.remove('show');
            }

            /*
            | Beri sedikit waktu agar animasi popup selesai,
            | lalu submit form.
            */

            setTimeout(() => {

                form.submit();

            }, 200);
        }


        /*
        |--------------------------------------------------------------------------
        | AUTO CLOSE POPUP HASIL IMPORT
        |--------------------------------------------------------------------------
        */

        document.addEventListener('DOMContentLoaded', function () {

            const popup =
                document.querySelector(
                    '.global-popup.show:not(#importConfirmPopup)'
                );

            if (!popup) {
                return;
            }

            /*
            | Popup hasil import otomatis tertutup
            | setelah 5 detik.
            */

            setTimeout(() => {

                if (popup.classList.contains('show')) {

                    closeImportPopup(popup.id);

                }

            }, 5000);

        });

    </script>

</x-app-layout>