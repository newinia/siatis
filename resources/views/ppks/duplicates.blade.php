<x-app-layout>

<style>
    /* =========================================================
       BASE
    ========================================================= */

    .check-page {
        max-width: 1400px;
        margin: 0 auto;
        padding: 30px 34px 50px;
        color: #1f2937;
    }

    /* =========================================================
       HEADER
    ========================================================= */

    .check-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 24px;
    }

    .check-header-left h1 {
        margin: 0;
        font-size: 25px;
        line-height: 1.25;
        font-weight: 700;
        color: #172033;
        letter-spacing: -.3px;
    }

    .check-header-left p {
        margin: 7px 0 0;
        font-size: 12px;
        line-height: 1.5;
        color: #7c8494;
        font-weight: 400;
    }

    .check-summary {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 9px 13px;
        border: 1px solid #e8eaf0;
        border-radius: 10px;
        background: #fff;
    }

    .summary-number {
        min-width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        background: #f0f1ff;
        color: #4f46e5;
        font-size: 13px;
        font-weight: 700;
    }

    .summary-text {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .summary-text strong {
        color: #30384a;
        font-size: 11px;
        font-weight: 700;
    }

    .summary-text span {
        color: #9299a8;
        font-size: 9px;
    }

    /* =========================================================
       SECTION TITLE
    ========================================================= */

    .section-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 11px;
    }

    .section-heading-left {
        display: flex;
        align-items: center;
        gap: 9px;
    }

    .section-heading h2 {
        margin: 0;
        font-size: 14px;
        font-weight: 700;
        color: #293246;
    }

    .section-heading span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 22px;
        height: 20px;
        padding: 0 7px;
        border-radius: 20px;
        background: #f2f3f7;
        color: #70798a;
        font-size: 9px;
        font-weight: 700;
    }

    /* =========================================================
       CASE LIST
    ========================================================= */

    .check-list {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .check-card {
        background: #fff;
        border: 1px solid #e8eaf0;
        border-radius: 11px;
        transition: border-color .15s ease, box-shadow .15s ease;
    }

    .check-card:hover {
        border-color: #dcdfea;
        box-shadow: 0 5px 18px rgba(30, 41, 59, .045);
    }

    .check-card-main {
        min-height: 76px;
        display: grid;
        grid-template-columns: 34px minmax(210px, 1fr) 42px minmax(210px, 1fr) auto;
        align-items: center;
        gap: 15px;
        padding: 13px 16px;
    }

    .case-no {
        width: 31px;
        height: 31px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        background: #f5f6f9;
        color: #70798a;
        font-size: 10px;
        font-weight: 700;
    }

    .person-block {
        min-width: 0;
    }

    .person-label {
        margin-bottom: 4px;
        color: #9ba2b0;
        font-size: 8px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .55px;
    }

    .person-name {
        overflow: hidden;
        color: #273044;
        font-size: 12px;
        font-weight: 700;
        line-height: 1.35;
        white-space: nowrap;
        text-overflow: ellipsis;
    }

    .person-nik {
        margin-top: 3px;
        color: #8991a1;
        font-size: 9px;
    }

    .vs {
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: auto;
        border: 1px solid #e6e8f3;
        border-radius: 50%;
        background: #f7f7fc;
        color: #777caa;
        font-size: 8px;
        font-weight: 700;
    }

    .case-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 8px;
    }

    .condition-badge {
        display: inline-flex;
        align-items: center;
        height: 25px;
        padding: 0 9px;
        border-radius: 20px;
        background: #fff7ed;
        color: #c56a18;
        font-size: 9px;
        font-weight: 700;
        white-space: nowrap;
    }

    .detail-btn {
        height: 29px;
        padding: 0 12px;
        border: 1px solid #e0e2e9;
        border-radius: 7px;
        background: #fff;
        color: #525b6d;
        font-size: 9px;
        font-weight: 700;
        cursor: pointer;
        transition: .15s ease;
    }

    .detail-btn:hover {
        border-color: #cfd3df;
        background: #f8f9fb;
    }

    /* =========================================================
       EMPTY
    ========================================================= */

    .empty-box {
        padding: 45px 20px;
        border: 1px solid #e8eaf0;
        border-radius: 12px;
        background: #fff;
        text-align: center;
    }

    .empty-check {
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
        border-radius: 50%;
        background: #ecfdf5;
        color: #16a34a;
        font-size: 17px;
        font-weight: 700;
    }

    .empty-box h3 {
        margin: 0;
        color: #30384a;
        font-size: 14px;
        font-weight: 700;
    }

    .empty-box p {
        margin: 5px 0 0;
        color: #969eae;
        font-size: 10px;
    }

    /* =========================================================
       HISTORY
    ========================================================= */

    .history-section {
        margin-top: 40px;
        padding-top: 28px;
        border-top: 1px solid #e7e9ef;
    }

    .history-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        margin-bottom: 12px;
    }

    .history-header h2 {
        margin: 0;
        color: #293246;
        font-size: 15px;
        font-weight: 700;
    }

    .history-header p {
        margin: 4px 0 0;
        color: #8b93a3;
        font-size: 10px;
        font-weight: 400;
    }

    .history-count {
        color: #9299a8;
        font-size: 9px;
    }

    .history-table {
        overflow: hidden;
        border: 1px solid #e7e9ef;
        border-radius: 11px;
        background: #fff;
    }

    .history-table-head {
        display: grid;
        grid-template-columns: minmax(220px, 1.4fr) minmax(180px, 1fr) 140px 145px 85px;
        align-items: center;
        gap: 15px;
        padding: 10px 15px;
        border-bottom: 1px solid #eceef3;
        background: #fafbfc;
    }

    .history-table-head span {
        color: #9aa1af;
        font-size: 8px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .5px;
    }

    .history-row {
        display: grid;
        grid-template-columns: minmax(220px, 1.4fr) minmax(180px, 1fr) 140px 145px 85px;
        align-items: center;
        gap: 15px;
        padding: 12px 15px;
        border-bottom: 1px solid #f0f1f4;
    }

    .history-row:last-child {
        border-bottom: none;
    }

    .history-row:hover {
        background: #fcfcfd;
    }

    .history-person {
        min-width: 0;
    }

    .history-person-name {
        overflow: hidden;
        color: #30384a;
        font-size: 10px;
        font-weight: 700;
        white-space: nowrap;
        text-overflow: ellipsis;
    }

    .history-person-nik {
        margin-top: 3px;
        color: #969dac;
        font-size: 8px;
    }

    .history-comparison {
        overflow: hidden;
        color: #687183;
        font-size: 9px;
        white-space: nowrap;
        text-overflow: ellipsis;
    }

    .history-comparison span {
        display: block;
        margin-bottom: 2px;
        color: #a0a6b2;
        font-size: 7px;
        text-transform: uppercase;
        letter-spacing: .4px;
    }

    .history-badge {
        display: inline-flex;
        align-items: center;
        width: fit-content;
        min-height: 23px;
        padding: 0 8px;
        border-radius: 20px;
        font-size: 8px;
        font-weight: 700;
        white-space: nowrap;
    }

    .history-badge.pilih-ini {
        background: #eef2ff;
        color: #4f46e5;
    }

    .history-badge.pilih-pembanding {
        background: #eff6ff;
        color: #2563eb;
    }

    .history-badge.bukan-duplikat {
        background: #ecfdf5;
        color: #16834f;
    }

    .history-badge.dikembalikan {
        background: #fff7ed;
        color: #c56a18;
    }

    .history-user {
        color: #626b7c;
        font-size: 9px;
    }

    .history-date {
        margin-top: 3px;
        color: #a0a6b2;
        font-size: 8px;
    }

    .history-restore button {
        height: 26px;
        padding: 0 9px;
        border: 1px solid #e0e3e9;
        border-radius: 6px;
        background: #fff;
        color: #737b8b;
        font-size: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: .15s ease;
    }

    .history-restore button:hover {
        background: #f7f8fa;
        color: #4f5665;
    }

    .history-empty {
        padding: 30px 20px;
        border: 1px solid #e7e9ef;
        border-radius: 11px;
        background: #fff;
        color: #969eae;
        font-size: 10px;
        text-align: center;
    }

    /* =========================================================
       MODAL
    ========================================================= */

    .detail-modal {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 9999;
        align-items: center;
        justify-content: center;
        padding: 25px;
        background: rgba(15, 23, 42, .52);
    }

    .detail-modal.active {
        display: flex;
    }

    .modal-box {
        width: 100%;
        max-width: 900px;
        max-height: 91vh;
        overflow-y: auto;
        border-radius: 15px;
        background: #fff;
        box-shadow: 0 25px 70px rgba(0,0,0,.2);
    }

    .modal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 19px 22px;
        background: linear-gradient(135deg, #4f46e5, #6366f1);
        color: #fff;
    }

    .modal-header h2 {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
    }

    .modal-header p {
        margin: 4px 0 0;
        font-size: 9px;
        opacity: .8;
    }

    .close-btn {
        width: 30px;
        height: 30px;
        border: none;
        border-radius: 7px;
        background: rgba(255,255,255,.15);
        color: #fff;
        font-size: 17px;
        cursor: pointer;
    }

    .modal-body {
        padding: 20px 22px;
    }

    .comparison-title {
        margin-bottom: 10px;
        color: #30384a;
        font-size: 11px;
        font-weight: 700;
    }

    .comparison-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    .info-card {
        padding: 14px;
        border: 1px solid #e7e9ef;
        border-radius: 10px;
    }

    .main-data {
        background: #fafaff;
        border-color: #e2e3fa;
    }

    .compare-data {
        background: #fafcff;
        border-color: #e1eaf6;
    }

    .info-card-label {
        margin-bottom: 6px;
        color: #8e96a5;
        font-size: 8px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .5px;
    }

    .info-card-name {
        margin-bottom: 10px;
        color: #30384a;
        font-size: 13px;
        font-weight: 700;
    }

    .info-row {
        display: grid;
        grid-template-columns: 110px 1fr;
        gap: 8px;
        padding: 7px 0;
        border-top: 1px solid rgba(0,0,0,.05);
    }

    .info-row:first-of-type {
        border-top: none;
    }

    .info-label {
        color: #9199a8;
        font-size: 9px;
    }

    .info-value {
        color: #454e60;
        font-size: 9px;
        font-weight: 600;
        word-break: break-word;
    }

    .full-detail {
        margin-top: 20px;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 8px;
    }

    .detail-item {
        padding: 9px 10px;
        border-radius: 8px;
        background: #f8f9fb;
    }

    .detail-label {
        margin-bottom: 3px;
        color: #949baa;
        font-size: 7px;
    }

    .detail-value {
        color: #4a5364;
        font-size: 9px;
        font-weight: 600;
        line-height: 1.4;
        word-break: break-word;
    }

    .note-box {
        margin-top: 14px;
        padding: 10px 12px;
        border: 1px solid #f3e3c8;
        border-radius: 8px;
        background: #fff9ef;
        color: #85682f;
        font-size: 9px;
        line-height: 1.5;
    }

    .decision-footer {
        display: flex;
        justify-content: flex-end;
        gap: 7px;
        padding: 14px 22px;
        border-top: 1px solid #edf0f4;
        background: #fafbfc;
    }

    .decision-footer form {
        margin: 0;
    }

    .decision-btn {
        height: 31px;
        padding: 0 12px;
        border: none;
        border-radius: 7px;
        font-size: 8px;
        font-weight: 700;
        cursor: pointer;
    }

    .choose-main {
        background: #4f46e5;
        color: #fff;
    }

    .choose-compare {
        background: #eef2ff;
        color: #4f46e5;
    }

    .not-duplicate {
        background: #eaf8f0;
        color: #16834f;
    }

    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 1000px) {

        .check-card-main {
            grid-template-columns: 34px 1fr 1fr auto;
        }

        .vs {
            display: none;
        }

        .history-table {
            overflow-x: auto;
        }

        .history-table-head,
        .history-row {
            min-width: 850px;
        }
    }

    @media (max-width: 700px) {

        .check-page {
            padding: 22px 15px 35px;
        }

        .check-header {
            align-items: flex-start;
        }

        .check-summary {
            display: none;
        }

        .check-card-main {
            grid-template-columns: 30px 1fr;
        }

        .case-actions {
            grid-column: 2;
            justify-content: flex-start;
        }

        .comparison-grid {
            grid-template-columns: 1fr;
        }

        .detail-grid {
            grid-template-columns: 1fr 1fr;
        }

        .decision-footer {
            flex-direction: column;
        }

        .decision-footer form,
        .decision-btn {
            width: 100%;
        }
    }

    @media (max-width: 450px) {

        .detail-grid {
            grid-template-columns: 1fr;
        }

        .history-table-head,
        .history-row {
            min-width: 780px;
        }
    }
</style>


<div class="check-page">

    {{-- =========================================================
         HEADER
    ========================================================== --}}

    <div class="check-header">

        <div class="check-header-left">

            <h1>Perlu Pemeriksaan</h1>

            <p>
                Periksa data yang terindikasi memiliki kesamaan identitas.
            </p>

        </div>

        <div class="check-summary">

            <div class="summary-number">
                {{ $duplicates->count() }}
            </div>

            <div class="summary-text">

                <strong>
                    Kasus
                </strong>

                <span>
                    Menunggu pemeriksaan
                </span>

            </div>

        </div>

    </div>


    {{-- =========================================================
         PERLU PEMERIKSAAN
    ========================================================== --}}

    <div class="section-heading">

        <div class="section-heading-left">

            <h2>
                Data Perlu Diperiksa
            </h2>

            <span>
                {{ $duplicates->count() }}
            </span>

        </div>

    </div>


    @if ($duplicates->count())

        <div class="check-list">

            @foreach ($duplicates as $index => $ppks)

                @php

                    $data = is_array($ppks->data)
                        ? $ppks->data
                        : [];

                    $nama = $data['nama_lengkap'] ?? '-';
                    $nik = $data['nik'] ?? '-';

                    $comparison = null;

                    if ($ppks->possible_duplicate_of) {

                        $comparison = \App\Models\Ppks::find(
                            $ppks->possible_duplicate_of
                        );

                    }

                    $comparisonData =
                        $comparison &&
                        is_array($comparison->data)
                            ? $comparison->data
                            : [];

                    $comparisonNama =
                        $comparisonData['nama_lengkap'] ?? '-';

                    $comparisonNik =
                        $comparisonData['nik'] ?? '-';

                    $note =
                        strtolower(
                            $ppks->duplicate_note ?? ''
                        );

                    if (str_contains($note, 'nik berbeda')) {

                        $kondisi = 'NIK berbeda';

                    } elseif (str_contains($note, 'nik sama')) {

                        $kondisi = 'NIK sama';

                    } else {

                        $kondisi = 'Perlu diperiksa';

                    }

                @endphp


                <div class="check-card">

                    <div class="check-card-main">

                        <div class="case-no">
                            {{ $index + 1 }}
                        </div>


                        <div class="person-block">

                            <div class="person-label">
                                Data PPKS
                            </div>

                            <div class="person-name">
                                {{ $nama }}
                            </div>

                            <div class="person-nik">
                                NIK {{ $nik }}
                            </div>

                        </div>


                        <div class="vs">
                            VS
                        </div>


                        <div class="person-block">

                            <div class="person-label">
                                Data Pembanding
                            </div>

                            @if ($comparison)

                                <div class="person-name">
                                    {{ $comparisonNama }}
                                </div>

                                <div class="person-nik">
                                    NIK {{ $comparisonNik }}
                                </div>

                            @else

                                <div class="person-name">
                                    Tidak ditemukan
                                </div>

                                <div class="person-nik">
                                    -
                                </div>

                            @endif

                        </div>


                        <div class="case-actions">

                            <span class="condition-badge">
                                {{ $kondisi }}
                            </span>

                            <button
                                type="button"
                                class="detail-btn"
                                onclick="openDetail({{ $ppks->id }})"
                            >
                                Detail
                            </button>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    @else

        <div class="empty-box">

            <div class="empty-check">
                ✓
            </div>

            <h3>
                Tidak ada data yang perlu diperiksa
            </h3>

            <p>
                Semua data sudah diperiksa.
            </p>

        </div>

    @endif


    {{-- =========================================================
         RIWAYAT
    ========================================================== --}}

    <div class="history-section">

        <div class="history-header">

            <div>

                <h2>
                    Riwayat Pemeriksaan
                </h2>

                <p>
                    Daftar keputusan pemeriksaan yang telah dilakukan.
                </p>

            </div>

            <div class="history-count">
                {{ $histories->count() }} riwayat
            </div>

        </div>


        @if ($histories->count())

            <div class="history-table">

                {{-- HEADER --}}
                <div class="history-table-head">

                    <span>
                        Data yang diperiksa
                    </span>

                    <span>
                        Data pembanding
                    </span>

                    <span>
                        Keputusan
                    </span>

                    <span>
                        Pemeriksa
                    </span>

                    <span>
                        Aksi
                    </span>

                </div>


                {{-- ROW --}}
                @foreach ($histories as $history)

                    @php

                        $beforeData =
                            is_array($history->ppks_before)
                                ? ($history->ppks_before['data'] ?? [])
                                : [];

                        $comparisonBefore =
                            is_array($history->comparison_before)
                                ? ($history->comparison_before['data'] ?? [])
                                : [];

                        $decisionLabels = [

                            'pilih_data_ini' =>
                                'Pilih Data Ini',

                            'pilih_data_pembanding' =>
                                'Pilih Pembanding',

                            'bukan_duplikat' =>
                                'Bukan Duplikat',

                            'dikembalikan' =>
                                'Dikembalikan',

                        ];

                        $decisionLabel =
                            $decisionLabels[$history->decision]
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
                                'pilih-ini',

                            'pilih_data_pembanding' =>
                                'pilih-pembanding',

                            'bukan_duplikat' =>
                                'bukan-duplikat',

                            'dikembalikan' =>
                                'dikembalikan',

                            default =>
                                'pilih-ini',

                        };

                    @endphp


                    <div class="history-row">

                        {{-- DATA --}}
                        <div class="history-person">

                            <div class="history-person-name">
                                {{ $beforeData['nama_lengkap'] ?? '-' }}
                            </div>

                            <div class="history-person-nik">
                                NIK {{ $beforeData['nik'] ?? '-' }}
                            </div>

                        </div>


                        {{-- PEMBANDING --}}
                        <div class="history-comparison">

                            <span>
                                Pembanding
                            </span>

                            {{ $comparisonBefore['nama_lengkap'] ?? '-' }}

                        </div>


                        {{-- KEPUTUSAN --}}
                        <div>

                            <span class="history-badge {{ $badgeClass }}">
                                {{ $decisionLabel }}
                            </span>

                        </div>


                        {{-- PEMERIKSA --}}
                        <div>

                            <div class="history-user">
                                {{ $history->user?->name ?? 'Tidak diketahui' }}
                            </div>

                            <div class="history-date">
                                {{ $history->created_at?->format('d M Y, H:i') }}
                            </div>

                        </div>


                        {{-- AKSI --}}
                        <div class="history-restore">

                            <form
                                method="POST"
                                action="{{ route('ppks.duplicate-restore', $history->id) }}"
                                onsubmit="return confirm('Yakin ingin mengembalikan data ke kondisi sebelum keputusan ini?')"
                            >

                                @csrf

                                @method('PATCH')

                                <button type="submit">
                                    Kembalikan
                                </button>

                            </form>

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <div class="history-empty">
                Belum ada riwayat pemeriksaan.
            </div>

        @endif

    </div>

</div>


{{-- =========================================================
     MODAL DETAIL
========================================================== --}}

@foreach ($duplicates as $ppks)

    @php

        $data = is_array($ppks->data)
            ? $ppks->data
            : [];

        $comparison = null;

        if ($ppks->possible_duplicate_of) {

            $comparison = \App\Models\Ppks::find(
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
        class="detail-modal"
    >

        <div class="modal-box">

            {{-- HEADER --}}
            <div class="modal-header">

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
                    class="close-btn"
                    onclick="closeDetail({{ $ppks->id }})"
                >
                    ×
                </button>

            </div>


            {{-- BODY --}}
            <div class="modal-body">

                <div class="comparison-title">
                    Perbandingan Data
                </div>


                <div class="comparison-grid">

                    {{-- DATA UTAMA --}}
                    <div class="info-card main-data">

                        <div class="info-card-label">
                            Data yang diperiksa
                        </div>

                        <div class="info-card-name">
                            {{ $data['nama_lengkap'] ?? '-' }}
                        </div>

                        <div class="info-row">
                            <span class="info-label">NIK</span>
                            <span class="info-value">
                                {{ $data['nik'] ?? '-' }}
                            </span>
                        </div>

                        <div class="info-row">
                            <span class="info-label">Jenis Kelamin</span>
                            <span class="info-value">
                                {{ $data['jenis_kelamin'] ?? '-' }}
                            </span>
                        </div>

                        <div class="info-row">
                            <span class="info-label">Tempat Lahir</span>
                            <span class="info-value">
                                {{ $data['tempat_lahir'] ?? '-' }}
                            </span>
                        </div>

                        <div class="info-row">
                            <span class="info-label">Tanggal Lahir</span>
                            <span class="info-value">
                                {{ $data['tanggal_lahir'] ?? '-' }}
                            </span>
                        </div>

                        <div class="info-row">
                            <span class="info-label">Timestamp</span>
                            <span class="info-value">
                                {{ $data['timestamp'] ?? '-' }}
                            </span>
                        </div>

                    </div>


                    {{-- PEMBANDING --}}
                    <div class="info-card compare-data">

                        <div class="info-card-label">
                            Data pembanding
                        </div>

                        @if ($comparison)

                            <div class="info-card-name">
                                {{ $comparisonData['nama_lengkap'] ?? '-' }}
                            </div>

                            <div class="info-row">
                                <span class="info-label">NIK</span>
                                <span class="info-value">
                                    {{ $comparisonData['nik'] ?? '-' }}
                                </span>
                            </div>

                            <div class="info-row">
                                <span class="info-label">Jenis Kelamin</span>
                                <span class="info-value">
                                    {{ $comparisonData['jenis_kelamin'] ?? '-' }}
                                </span>
                            </div>

                            <div class="info-row">
                                <span class="info-label">Tempat Lahir</span>
                                <span class="info-value">
                                    {{ $comparisonData['tempat_lahir'] ?? '-' }}
                                </span>
                            </div>

                            <div class="info-row">
                                <span class="info-label">Tanggal Lahir</span>
                                <span class="info-value">
                                    {{ $comparisonData['tanggal_lahir'] ?? '-' }}
                                </span>
                            </div>

                            <div class="info-row">
                                <span class="info-label">Timestamp</span>
                                <span class="info-value">
                                    {{ $comparisonData['timestamp'] ?? '-' }}
                                </span>
                            </div>

                        @else

                            <div class="info-card-name">
                                Tidak ditemukan
                            </div>

                        @endif

                    </div>

                </div>


                {{-- DETAIL --}}
                <div class="full-detail">

                    <div class="comparison-title">
                        Informasi Lengkap Data Utama
                    </div>

                    <div class="detail-grid">

                        <div class="detail-item">
                            <div class="detail-label">Nomor KK</div>
                            <div class="detail-value">
                                {{ $data['nomor_kk'] ?? '-' }}
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">No. HP</div>
                            <div class="detail-value">
                                {{ $data['no_hp_1'] ?? '-' }}
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Email</div>
                            <div class="detail-value">
                                {{ $data['email'] ?? '-' }}
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Provinsi</div>
                            <div class="detail-value">
                                {{ $data['provinsi'] ?? '-' }}
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Kabupaten</div>
                            <div class="detail-value">
                                {{ $data['kabupaten'] ?? '-' }}
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Kecamatan</div>
                            <div class="detail-value">
                                {{ $data['kecamatan'] ?? '-' }}
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Kelurahan</div>
                            <div class="detail-value">
                                {{ $data['kelurahan'] ?? '-' }}
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Jenis PPKS</div>
                            <div class="detail-value">
                                {{ $data['jenis_ppks'] ?? '-' }}
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Pendidikan</div>
                            <div class="detail-value">
                                {{ $data['pendidikan_terakhir'] ?? '-' }}
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Peminatan</div>
                            <div class="detail-value">
                                {{ $data['peminatan'] ?? '-' }}
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Jurusan</div>
                            <div class="detail-value">
                                {{ $data['jurusan_yang_diminati'] ?? '-' }}
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Kondisi Kesehatan</div>
                            <div class="detail-value">
                                {{ $data['kondisi_kesehatan'] ?? '-' }}
                            </div>
                        </div>

                    </div>


                    @if ($ppks->duplicate_note)

                        <div class="note-box">

                            <strong>
                                Keterangan:
                            </strong>

                            {{ $ppks->duplicate_note }}

                        </div>

                    @endif

                </div>

            </div>


            {{-- DECISION --}}
            <div class="decision-footer">

                <form
                    method="POST"
                    action="{{ route('ppks.duplicate-decision', $ppks->id) }}"
                >

                    @csrf
                    @method('PATCH')

                    <input
                        type="hidden"
                        name="decision"
                        value="pilih_data_ini"
                    >

                    <button
                        type="submit"
                        class="decision-btn choose-main"
                    >
                        Pilih Data Ini
                    </button>

                </form>


                @if ($comparison)

                    <form
                        method="POST"
                        action="{{ route('ppks.duplicate-decision', $ppks->id) }}"
                    >

                        @csrf
                        @method('PATCH')

                        <input
                            type="hidden"
                            name="decision"
                            value="pilih_data_pembanding"
                        >

                        <button
                            type="submit"
                            class="decision-btn choose-compare"
                        >
                            Pilih Data Pembanding
                        </button>

                    </form>

                @endif


                <form
                    method="POST"
                    action="{{ route('ppks.duplicate-decision', $ppks->id) }}"
                >

                    @csrf
                    @method('PATCH')

                    <input
                        type="hidden"
                        name="decision"
                        value="bukan_duplikat"
                    >

                    <button
                        type="submit"
                        class="decision-btn not-duplicate"
                    >
                        Bukan Duplikat
                    </button>

                </form>

            </div>

        </div>

    </div>

@endforeach


<script>

    function openDetail(id) {

        const modal =
            document.getElementById('detailModal' + id);

        if (modal) {

            modal.classList.add('active');

            document.body.style.overflow = 'hidden';

        }
    }


    function closeDetail(id) {

        const modal =
            document.getElementById('detailModal' + id);

        if (modal) {

            modal.classList.remove('active');

            document.body.style.overflow = '';

        }
    }


    document.addEventListener('click', function(event) {

        if (
            event.target.classList.contains('detail-modal')
        ) {

            event.target.classList.remove('active');

            document.body.style.overflow = '';

        }

    });


    document.addEventListener('keydown', function(event) {

        if (event.key === 'Escape') {

            document
                .querySelectorAll('.detail-modal.active')
                .forEach(function(modal) {

                    modal.classList.remove('active');

                });

            document.body.style.overflow = '';

        }

    });

</script>

</x-app-layout>
