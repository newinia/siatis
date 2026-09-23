<x-app-layout>

    <div class="main-page duplicate-page">

        {{-- =====================================================
             HEADER
        ====================================================== --}}

        <div class="main-page-header">

            <div>
                <h1>Perlu Pemeriksaan</h1>

                <p>
                    Periksa data yang terindikasi memiliki kesamaan identitas.
                </p>
            </div>

            <div class="duplicate-summary">

                <div class="duplicate-summary-number">
                    {{ $duplicates->count() }}
                </div>

                <div class="duplicate-summary-text">

                    <strong>Kasus</strong>

                    <span>
                        Menunggu pemeriksaan
                    </span>

                </div>

            </div>

        </div>


        {{-- =====================================================
             DATA PERLU DIPERIKSA
        ====================================================== --}}

        <div class="duplicate-section-header">

            <div class="duplicate-section-title">

                <h2>
                    Data Perlu Diperiksa
                </h2>

                <span>
                    {{ $duplicates->count() }}
                </span>

            </div>

        </div>


        @if ($duplicates->count())

            <div class="duplicate-check-list">

                @foreach ($duplicates as $index => $ppks)

                    @php

                        $data = is_array($ppks->data)
                            ? $ppks->data
                            : [];

                        $nama =
                            $data['nama_lengkap']
                            ?? '-';

                        $nik =
                            $data['nik']
                            ?? '-';


                        $comparison = null;

                        if ($ppks->possible_duplicate_of) {

                            $comparison =
                                \App\Models\Ppks::find(
                                    $ppks->possible_duplicate_of
                                );

                        }


                        $comparisonData =
                            $comparison &&
                            is_array($comparison->data)
                                ? $comparison->data
                                : [];


                        $comparisonNama =
                            $comparisonData['nama_lengkap']
                            ?? '-';

                        $comparisonNik =
                            $comparisonData['nik']
                            ?? '-';


                        $note = strtolower(
                            $ppks->duplicate_note ?? ''
                        );


                        if (
                            str_contains(
                                $note,
                                'nik berbeda'
                            )
                        ) {

                            $kondisi = 'NIK berbeda';

                        } elseif (
                            str_contains(
                                $note,
                                'nik sama'
                            )
                        ) {

                            $kondisi = 'NIK sama';

                        } else {

                            $kondisi = 'Perlu diperiksa';

                        }

                    @endphp


                    <div class="duplicate-check-item">

                        {{-- NOMOR --}}

                        <div class="duplicate-check-number">
                            {{ $index + 1 }}
                        </div>


                        {{-- DATA UTAMA --}}

                        <div class="duplicate-check-person">

                            <span class="duplicate-check-label">
                                Data PPKS
                            </span>

                            <strong>
                                {{ $nama }}
                            </strong>

                            <span class="duplicate-check-nik">
                                NIK {{ $nik }}
                            </span>

                        </div>


                        {{-- PEMBANDING --}}

                        <div class="duplicate-check-person">

                            <span class="duplicate-check-label">
                                Data Pembanding
                            </span>

                            @if ($comparison)

                                <strong>
                                    {{ $comparisonNama }}
                                </strong>

                                <span class="duplicate-check-nik">
                                    NIK {{ $comparisonNik }}
                                </span>

                            @else

                                <strong>
                                    Tidak ditemukan
                                </strong>

                                <span class="duplicate-check-nik">
                                    -
                                </span>

                            @endif

                        </div>


                        {{-- KONDISI + AKSI --}}

                        <div class="duplicate-check-actions">

                            <span class="duplicate-condition">
                                {{ $kondisi }}
                            </span>

                            <button
                                type="button"
                                class="action-btn action-btn-detail"
                                onclick="openDetail({{ $ppks->id }})"
                            >

                                <span class="material-symbols-outlined">
                                    visibility
                                </span>

                                Detail

                            </button>

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <div class="empty-state">

                <span class="material-symbols-outlined">
                    task_alt
                </span>

                <h3>
                    Tidak ada data yang perlu diperiksa
                </h3>

                <p>
                    Semua data sudah diperiksa.
                </p>

            </div>

        @endif


        {{-- =====================================================
             RIWAYAT PEMERIKSAAN
        ====================================================== --}}

        <div class="duplicate-history">

            <div class="duplicate-history-header">

                <div>

                    <h2>
                        Riwayat Pemeriksaan
                    </h2>

                    <p>
                        Daftar keputusan pemeriksaan yang telah dilakukan.
                    </p>

                </div>

                <span class="duplicate-history-count">
                    {{ $histories->count() }} riwayat
                </span>

            </div>


            @if ($histories->count())

                <div class="table-wrapper">

                    <table class="table">

                        <thead>

                            <tr>

                                <th>No</th>

                                <th>
                                    Data yang Diperiksa
                                </th>

                                <th>
                                    Data Pembanding
                                </th>

                                <th>
                                    Keputusan
                                </th>

                                <th>
                                    Pemeriksa
                                </th>

                                <th>
                                    Tanggal
                                </th>

                                <th>
                                    Aksi
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach ($histories as $history)

                                @php

                                    $beforeData =
                                        is_array(
                                            $history->ppks_before
                                        )
                                            ? (
                                                $history
                                                    ->ppks_before['data']
                                                ?? []
                                            )
                                            : [];


                                    $comparisonBefore =
                                        is_array(
                                            $history->comparison_before
                                        )
                                            ? (
                                                $history
                                                    ->comparison_before['data']
                                                ?? []
                                            )
                                            : [];


                                    $decisionLabels = [

                                        'pilih_data_ini' =>
                                            'Pilih Data Ini',

                                        'pilih_data_pembanding' =>
                                            'Pilih Data Pembanding',

                                        'bukan_duplikat' =>
                                            'Bukan Duplikat',

                                        'dikembalikan' =>
                                            'Dikembalikan',

                                    ];


                                    $decisionLabel =
                                        $decisionLabels[
                                            $history->decision
                                        ]
                                        ?? ucfirst(
                                            str_replace(
                                                '_',
                                                ' ',
                                                $history->decision
                                            )
                                        );


                                    $badgeClass = match (
                                        $history->decision
                                    ) {

                                        'pilih_data_ini' =>
                                            'duplicate-history-badge primary',

                                        'pilih_data_pembanding' =>
                                            'duplicate-history-badge info',

                                        'bukan_duplikat' =>
                                            'duplicate-history-badge success',

                                        'dikembalikan' =>
                                            'duplicate-history-badge warning',

                                        default =>
                                            'duplicate-history-badge primary',

                                    };

                                @endphp


                                <tr>

                                    {{-- NO --}}

                                    <td>
                                        {{ $loop->iteration }}
                                    </td>


                                    {{-- DATA YANG DIPERIKSA --}}

                                    <td>

                                        <div class="table-person">

                                            <strong>
                                                {{
                                                    $beforeData[
                                                        'nama_lengkap'
                                                    ]
                                                    ?? '-'
                                                }}
                                            </strong>

                                            <span>
                                                NIK
                                                {{
                                                    $beforeData['nik']
                                                    ?? '-'
                                                }}
                                            </span>

                                        </div>

                                    </td>


                                    {{-- DATA PEMBANDING --}}

                                    <td>

                                        <div class="table-person">

                                            <strong>
                                                {{
                                                    $comparisonBefore[
                                                        'nama_lengkap'
                                                    ]
                                                    ?? '-'
                                                }}
                                            </strong>

                                            <span>
                                                NIK
                                                {{
                                                    $comparisonBefore['nik']
                                                    ?? '-'
                                                }}
                                            </span>

                                        </div>

                                    </td>


                                    {{-- KEPUTUSAN --}}

                                    <td>

                                        <span class="{{ $badgeClass }}">
                                            {{ $decisionLabel }}
                                        </span>

                                    </td>


                                    {{-- PEMERIKSA --}}

                                    <td>

                                        <div class="table-person">

                                            <strong>
                                                {{
                                                    $history->user?->name
                                                    ?? 'Tidak diketahui'
                                                }}
                                            </strong>

                                        </div>

                                    </td>


                                    {{-- TANGGAL --}}

                                    <td>

                                        <span class="table-date">
                                            {{
                                                $history
                                                    ->created_at
                                                    ?->format(
                                                        'd M Y, H:i'
                                                    )
                                            }}
                                        </span>

                                    </td>


                                    {{-- AKSI --}}

                                    <td>

                                        <button
                                            type="button"
                                            class="action-btn action-btn-detail"
                                            onclick="openRestorePopup({{ $history->id }})"
                                        >

                                            <span class="material-symbols-outlined">
                                                undo
                                            </span>

                                            Kembalikan

                                        </button>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="empty-state">

                    <span class="material-symbols-outlined">
                        history
                    </span>

                    <h3>
                        Belum ada riwayat pemeriksaan
                    </h3>

                    <p>
                        Riwayat keputusan pemeriksaan akan muncul di sini.
                    </p>

                </div>

            @endif

        </div>

    </div>


    {{-- =====================================================
         DETAIL MODAL
    ====================================================== --}}

    @foreach ($duplicates as $ppks)

        @php

            $data = is_array($ppks->data)
                ? $ppks->data
                : [];


            $comparison = null;

            if ($ppks->possible_duplicate_of) {

                $comparison =
                    \App\Models\Ppks::find(
                        $ppks->possible_duplicate_of
                    );

            }


            $comparisonData =
                $comparison &&
                is_array($comparison->data)
                    ? $comparison->data
                    : [];

        @endphp


        <div
            id="detailModal{{ $ppks->id }}"
            class="duplicate-detail-modal"
        >

            <div class="duplicate-detail-box">

                {{-- HEADER --}}

                <div class="duplicate-detail-header">

                    <div>

                        <h2>
                            Detail Pemeriksaan
                        </h2>

                        <p>
                            Perbandingan data PPKS
                        </p>

                    </div>


                    <button
                        type="button"
                        class="duplicate-close-button"
                        onclick="closeDetail({{ $ppks->id }})"
                    >

                        <span class="material-symbols-outlined">
                            close
                        </span>

                    </button>

                </div>


                {{-- BODY --}}

                <div class="duplicate-detail-body">

                    <div class="duplicate-detail-title">
                        Perbandingan Data
                    </div>


                    <div class="duplicate-comparison-grid">

                        {{-- DATA UTAMA --}}

                        <div class="duplicate-info-card main">

                            <div class="duplicate-info-label">
                                Data yang diperiksa
                            </div>

                            <div class="duplicate-info-name">
                                {{ $data['nama_lengkap'] ?? '-' }}
                            </div>


                            <div class="duplicate-info-row">

                                <span>
                                    NIK
                                </span>

                                <strong>
                                    {{ $data['nik'] ?? '-' }}
                                </strong>

                            </div>


                            <div class="duplicate-info-row">

                                <span>
                                    Jenis Kelamin
                                </span>

                                <strong>
                                    {{ $data['jenis_kelamin'] ?? '-' }}
                                </strong>

                            </div>


                            <div class="duplicate-info-row">

                                <span>
                                    Tempat Lahir
                                </span>

                                <strong>
                                    {{ $data['tempat_lahir'] ?? '-' }}
                                </strong>

                            </div>


                            <div class="duplicate-info-row">

                                <span>
                                    Tanggal Lahir
                                </span>

                                <strong>
                                    {{ $data['tanggal_lahir'] ?? '-' }}
                                </strong>

                            </div>


                            <div class="duplicate-info-row">

                                <span>
                                    Timestamp
                                </span>

                                <strong>
                                    {{ $data['timestamp'] ?? '-' }}
                                </strong>

                            </div>

                        </div>


                        {{-- DATA PEMBANDING --}}

                        <div class="duplicate-info-card comparison">

                            <div class="duplicate-info-label">
                                Data pembanding
                            </div>


                            @if ($comparison)

                                <div class="duplicate-info-name">
                                    {{ $comparisonData['nama_lengkap'] ?? '-' }}
                                </div>


                                <div class="duplicate-info-row">

                                    <span>
                                        NIK
                                    </span>

                                    <strong>
                                        {{ $comparisonData['nik'] ?? '-' }}
                                    </strong>

                                </div>


                                <div class="duplicate-info-row">

                                    <span>
                                        Jenis Kelamin
                                    </span>

                                    <strong>
                                        {{ $comparisonData['jenis_kelamin'] ?? '-' }}
                                    </strong>

                                </div>


                                <div class="duplicate-info-row">

                                    <span>
                                        Tempat Lahir
                                    </span>

                                    <strong>
                                        {{ $comparisonData['tempat_lahir'] ?? '-' }}
                                    </strong>

                                </div>


                                <div class="duplicate-info-row">

                                    <span>
                                        Tanggal Lahir
                                    </span>

                                    <strong>
                                        {{ $comparisonData['tanggal_lahir'] ?? '-' }}
                                    </strong>

                                </div>


                                <div class="duplicate-info-row">

                                    <span>
                                        Timestamp
                                    </span>

                                    <strong>
                                        {{ $comparisonData['timestamp'] ?? '-' }}
                                    </strong>

                                </div>

                            @else

                                <div class="duplicate-info-name">
                                    Tidak ditemukan
                                </div>

                            @endif

                        </div>

                    </div>


                    {{-- DETAIL LENGKAP --}}

                    <div class="duplicate-full-detail">

                        <div class="duplicate-detail-title">
                            Informasi Lengkap Data Utama
                        </div>


                        <div class="duplicate-detail-grid">

                            <div>

                                <span>
                                    Nomor KK
                                </span>

                                <strong>
                                    {{ $data['nomor_kk'] ?? '-' }}
                                </strong>

                            </div>


                            <div>

                                <span>
                                    No. HP
                                </span>

                                <strong>
                                    {{ $data['no_hp_1'] ?? '-' }}
                                </strong>

                            </div>


                            <div>

                                <span>
                                    Email
                                </span>

                                <strong>
                                    {{ $data['email'] ?? '-' }}
                                </strong>

                            </div>


                            <div>

                                <span>
                                    Provinsi
                                </span>

                                <strong>
                                    {{ $data['provinsi'] ?? '-' }}
                                </strong>

                            </div>


                            <div>

                                <span>
                                    Kabupaten
                                </span>

                                <strong>
                                    {{ $data['kabupaten'] ?? '-' }}
                                </strong>

                            </div>


                            <div>

                                <span>
                                    Kecamatan
                                </span>

                                <strong>
                                    {{ $data['kecamatan'] ?? '-' }}
                                </strong>

                            </div>


                            <div>

                                <span>
                                    Kelurahan
                                </span>

                                <strong>
                                    {{ $data['kelurahan'] ?? '-' }}
                                </strong>

                            </div>


                            <div>

                                <span>
                                    Jenis PPKS
                                </span>

                                <strong>
                                    {{ $data['jenis_ppks'] ?? '-' }}
                                </strong>

                            </div>


                            <div>

                                <span>
                                    Pendidikan
                                </span>

                                <strong>
                                    {{ $data['pendidikan_terakhir'] ?? '-' }}
                                </strong>

                            </div>


                            <div>

                                <span>
                                    Peminatan
                                </span>

                                <strong>
                                    {{ $data['peminatan'] ?? '-' }}
                                </strong>

                            </div>


                            <div>

                                <span>
                                    Jurusan
                                </span>

                                <strong>
                                    {{ $data['jurusan_yang_diminati'] ?? '-' }}
                                </strong>

                            </div>


                            <div>

                                <span>
                                    Kondisi Kesehatan
                                </span>

                                <strong>
                                    {{ $data['kondisi_kesehatan'] ?? '-' }}
                                </strong>

                            </div>

                        </div>


                        @if ($ppks->duplicate_note)

                            <div class="duplicate-note">

                                <strong>
                                    Keterangan:
                                </strong>

                                {{ $ppks->duplicate_note }}

                            </div>

                        @endif

                    </div>

                </div>


                {{-- KEPUTUSAN --}}

                <div class="duplicate-decision-footer">

                    <button
                        type="button"
                        class="btn-next"
                        onclick="openDecisionPopup(
                            {{ $ppks->id }},
                            'pilih_data_ini',
                            'Pilih Data Ini',
                            'Yakin ingin memilih data ini sebagai data yang dipertahankan?'
                        )"
                    >
                        Pilih Data Ini
                    </button>


                    @if ($comparison)

                        <button
                            type="button"
                            class="btn-save"
                            onclick="openDecisionPopup(
                                {{ $ppks->id }},
                                'pilih_data_pembanding',
                                'Pilih Data Pembanding',
                                'Yakin ingin menggunakan data pembanding sebagai data yang dipertahankan?'
                            )"
                        >
                            Pilih Data Pembanding
                        </button>

                    @endif


                    <button
                        type="button"
                        class="action-btn-delete"
                        onclick="openDecisionPopup(
                            {{ $ppks->id }},
                            'bukan_duplikat',
                            'Bukan Duplikat',
                            'Yakin kedua data ini bukan merupakan duplikat?'
                        )"
                    >
                        Bukan Duplikat
                    </button>

                </div>

            </div>

        </div>

    @endforeach


    {{-- =====================================================
         FORM KEPUTUSAN
    ====================================================== --}}

    <form
        id="decisionForm"
        method="POST"
        style="display:none;"
    >

        @csrf

        @method('PATCH')

        <input
            type="hidden"
            id="decisionInput"
            name="decision"
        >

    </form>


    {{-- =====================================================
         FORM RESTORE
    ====================================================== --}}

    <form
        id="restoreForm"
        method="POST"
        style="display:none;"
    >

        @csrf

        @method('PATCH')

    </form>


    {{-- =====================================================
         POPUP KEPUTUSAN
    ====================================================== --}}

    <div
        id="decisionPopup"
        class="global-popup confirm"
    >

        <div class="global-popup-box">

            <div class="global-popup-icon">

                <span class="material-symbols-outlined">
                    help
                </span>

            </div>


            <h3
                id="decisionPopupTitle"
                class="global-popup-title"
            >
                Konfirmasi
            </h3>


            <p
                id="decisionPopupMessage"
                class="global-popup-message"
            >
                Yakin ingin melanjutkan?
            </p>


            <div class="global-popup-actions">

                <button
                    type="button"
                    class="global-popup-btn cancel"
                    onclick="closeDecisionPopup()"
                >
                    Batal
                </button>


                <button
                    type="button"
                    class="global-popup-btn primary"
                    onclick="submitDecision()"
                >
                    Ya, Lanjutkan
                </button>

            </div>

        </div>

    </div>


    {{-- =====================================================
         POPUP RESTORE
    ====================================================== --}}

    <div
        id="restorePopup"
        class="global-popup confirm"
    >

        <div class="global-popup-box">

            <div class="global-popup-icon">

                <span class="material-symbols-outlined">
                    undo
                </span>

            </div>


            <h3 class="global-popup-title">
                Kembalikan Data?
            </h3>


            <p class="global-popup-message">
                Yakin ingin mengembalikan data ke kondisi sebelum keputusan ini?
            </p>


            <div class="global-popup-actions">

                <button
                    type="button"
                    class="global-popup-btn cancel"
                    onclick="closeRestorePopup()"
                >
                    Batal
                </button>


                <button
                    type="button"
                    class="global-popup-btn warning"
                    onclick="submitRestore()"
                >
                    Kembalikan
                </button>

            </div>

        </div>

    </div>



    {{-- =====================================================
         JAVASCRIPT
    ====================================================== --}}

    <script>

        let currentDecisionId = null;
        let currentDecision = null;
        let currentRestoreId = null;


        /* =====================================================
           DETAIL
        ====================================================== */

        function openDetail(id) {

            const modal =
                document.getElementById(
                    'detailModal' + id
                );

            if (!modal) return;

            modal.classList.add('active');

            document.body.style.overflow = 'hidden';

        }


        function closeDetail(id) {

            const modal =
                document.getElementById(
                    'detailModal' + id
                );

            if (!modal) return;

            modal.classList.remove('active');

            document.body.style.overflow = '';

        }


        /* =====================================================
           DECISION POPUP
        ====================================================== */

        function openDecisionPopup(
            id,
            decision,
            title,
            message
        ) {

            currentDecisionId = id;
            currentDecision = decision;


            document.getElementById(
                'decisionPopupTitle'
            ).textContent = title;


            document.getElementById(
                'decisionPopupMessage'
            ).textContent = message;


            const popup =
                document.getElementById(
                    'decisionPopup'
                );


            popup.classList.add('show');

            document.body.style.overflow = 'hidden';

        }


        function closeDecisionPopup() {

            const popup =
                document.getElementById(
                    'decisionPopup'
                );


            popup.classList.remove('show');


            currentDecisionId = null;
            currentDecision = null;


            document.body.style.overflow = '';

        }


        function submitDecision() {

            if (
                !currentDecisionId ||
                !currentDecision
            ) {

                return;

            }


            const form =
                document.getElementById(
                    'decisionForm'
                );


            const input =
                document.getElementById(
                    'decisionInput'
                );


            form.action =
                "{{ url('/ppks/duplicate-decision') }}/"
                + currentDecisionId;


            input.value =
                currentDecision;


            form.submit();

        }


        /* =====================================================
           RESTORE POPUP
        ====================================================== */

        function openRestorePopup(id) {

            currentRestoreId = id;


            const popup =
                document.getElementById(
                    'restorePopup'
                );


            popup.classList.add('show');

            document.body.style.overflow = 'hidden';

        }


        function closeRestorePopup() {

            const popup =
                document.getElementById(
                    'restorePopup'
                );


            popup.classList.remove('show');


            currentRestoreId = null;


            document.body.style.overflow = '';

        }


        function submitRestore() {

            if (!currentRestoreId) {

                return;

            }


            const form =
                document.getElementById(
                    'restoreForm'
                );


            form.action =
                "{{ url('/ppks/duplicate-restore') }}/"
                + currentRestoreId;


            form.submit();

        }


        /* =====================================================
           CLICK OUTSIDE
        ====================================================== */

        document.addEventListener(
            'click',
            function(event) {

                if (
                    event.target.classList.contains(
                        'duplicate-detail-modal'
                    )
                ) {

                    event.target.classList.remove(
                        'active'
                    );

                    document.body.style.overflow = '';

                }


                if (
                    event.target.classList.contains(
                        'global-popup'
                    )
                ) {

                    event.target.classList.remove(
                        'show'
                    );


                    currentDecisionId = null;
                    currentDecision = null;
                    currentRestoreId = null;


                    document.body.style.overflow = '';

                }

            }
        );


        /* =====================================================
           ESC
        ====================================================== */

        document.addEventListener(
            'keydown',
            function(event) {

                if (event.key !== 'Escape') {

                    return;

                }


                document
                    .querySelectorAll(
                        '.duplicate-detail-modal.active'
                    )
                    .forEach(
                        function(modal) {

                            modal.classList.remove(
                                'active'
                            );

                        }
                    );


                document
                    .querySelectorAll(
                        '.global-popup.show'
                    )
                    .forEach(
                        function(popup) {

                            popup.classList.remove(
                                'show'
                            );

                        }
                    );


                currentDecisionId = null;
                currentDecision = null;
                currentRestoreId = null;


                document.body.style.overflow = '';

            }
        );

    </script>

</x-app-layout>