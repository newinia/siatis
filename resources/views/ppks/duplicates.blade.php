<x-app-layout>

<style>
    /* =========================================================
       BASE
    ========================================================= */
    .check-page {
        width: 100%;
        max-width: 1400px;
        margin: 0 auto;
        padding: 42px 34px 60px;
        color: #1f2937;
    }

    /* =========================================================
       HEADER
    ========================================================= */
    .check-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
        margin-bottom: 30px;
    }

    .check-header-left {
        min-width: 0;
    }

    .check-header-left h1 {
        margin: 0;
        font-size: 25px;
        line-height: 1.25;
        font-weight: 700;
        color: #172033;
        letter-spacing: -.35px;
    }

    .check-header-left p {
        margin: 7px 0 0;
        font-size: 12px;
        line-height: 1.5;
        color: #7c8494;
    }

    .check-summary {
        display: flex;
        align-items: center;
        gap: 11px;
        min-width: 175px;
        padding: 11px 14px;
        border: 1px solid #e5e8ef;
        border-radius: 12px;
        background: #ffffff;
        box-shadow: 0 3px 12px rgba(15, 23, 42, .035);
    }

    .summary-number {
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border-radius: 9px;
        background: #eef2ff;
        color: #4f46e5;
        font-size: 14px;
        font-weight: 700;
    }

    .summary-text {
        display: flex;
        flex-direction: column;
        gap: 3px;
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
        margin-bottom: 13px;
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
        min-width: 25px;
        height: 22px;
        padding: 0 7px;
        border-radius: 20px;
        background: #f1f3f7;
        color: #697386;
        font-size: 9px;
        font-weight: 700;
    }

    /* =========================================================
       CASE LIST
    ========================================================= */
    .check-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .check-card {
        overflow: hidden;
        background: #ffffff;
        border: 1px solid #e5e8ef;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, .025);
        transition:
            border-color .18s ease,
            box-shadow .18s ease,
            transform .18s ease;
    }

    .check-card:hover {
        border-color: #d5d9e4;
        box-shadow: 0 8px 22px rgba(15, 23, 42, .06);
        transform: translateY(-1px);
    }

    .check-card-main {
        min-height: 84px;
        display: grid;
        grid-template-columns:
            36px
            minmax(200px, 1fr)
            38px
            minmax(200px, 1fr)
            auto;
        align-items: center;
        gap: 17px;
        padding: 15px 18px;
    }

    .case-no {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        background: #f4f5f8;
        color: #687286;
        font-size: 10px;
        font-weight: 700;
    }

    .person-block {
        min-width: 0;
    }

    .person-label {
        margin-bottom: 5px;
        color: #9aa1af;
        font-size: 8px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .6px;
    }

    .person-name {
        overflow: hidden;
        color: #252e42;
        font-size: 12px;
        font-weight: 700;
        line-height: 1.35;
        white-space: nowrap;
        text-overflow: ellipsis;
    }

    .person-nik {
        margin-top: 4px;
        color: #858e9e;
        font-size: 9px;
    }

    .vs {
        width: 29px;
        height: 29px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: auto;
        border: 1px solid #e2e5ed;
        border-radius: 50%;
        background: #f8f9fb;
        color: #7b8291;
        font-size: 8px;
        font-weight: 700;
    }

    .case-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 8px;
        white-space: nowrap;
    }

    .condition-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        height: 27px;
        padding: 0 10px;
        border-radius: 20px;
        background: #fff7ed;
        color: #c56a18;
        font-size: 9px;
        font-weight: 700;
        white-space: nowrap;
    }

    .detail-btn {
        height: 29px;
        padding: 0 13px;
        border: 1px solid #dfe3eb;
        border-radius: 7px;
        background: #ffffff;
        color: #4f5869;
        font-size: 9px;
        font-weight: 700;
        cursor: pointer;
        transition: all .16s ease;
    }

    .detail-btn:hover {
        border-color: #bfc5d1;
        background: #f7f8fa;
        color: #30394a;
    }

    .detail-btn:focus-visible,
    .close-btn:focus-visible,
    .decision-btn:focus-visible,
    .ktp-preview-button:focus-visible {
        outline: 2px solid #818cf8;
        outline-offset: 2px;
    }

    /* =========================================================
       EMPTY
    ========================================================= */
    .empty-box {
        padding: 50px 20px;
        border: 1px solid #e5e8ef;
        border-radius: 12px;
        background: #ffffff;
        text-align: center;
    }

    .empty-check {
        width: 46px;
        height: 46px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 13px;
        border-radius: 50%;
        background: #ecfdf5;
        color: #16a34a;
        font-size: 18px;
        font-weight: 700;
    }

    .empty-box h3 {
        margin: 0;
        color: #30384a;
        font-size: 14px;
        font-weight: 700;
    }

    .empty-box p {
        margin: 6px 0 0;
        color: #969eae;
        font-size: 10px;
    }

    /* =========================================================
       HISTORY
    ========================================================= */
    .history-section {
        margin-top: 42px;
        padding-top: 28px;
        border-top: 1px solid #e6e9ef;
    }

    .history-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 13px;
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
    }

    .history-count {
        color: #858e9d;
        font-size: 9px;
        font-weight: 600;
        white-space: nowrap;
    }

    .history-table {
        overflow: hidden;
        border: 1px solid #e4e7ed;
        border-radius: 12px;
        background: #ffffff;
        box-shadow: 0 2px 8px rgba(15, 23, 42, .025);
    }

    .history-table-head {
        display: grid;
        grid-template-columns:
            minmax(220px, 1.4fr)
            minmax(180px, 1fr)
            140px
            145px
            90px;
        align-items: center;
        gap: 15px;
        padding: 11px 16px;
        border-bottom: 1px solid #e9ebf0;
        background: #f8f9fb;
    }

    .history-table-head span {
        color: #858d9c;
        font-size: 8px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .5px;
    }

    .history-row {
        display: grid;
        grid-template-columns:
            minmax(220px, 1.4fr)
            minmax(180px, 1fr)
            140px
            145px
            90px;
        align-items: center;
        gap: 15px;
        min-height: 62px;
        padding: 11px 16px;
        border-bottom: 1px solid #f0f1f4;
        transition: background .15s ease;
    }

    .history-row:last-child {
        border-bottom: none;
    }

    .history-row:hover {
        background: #fafbfc;
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
        margin-bottom: 3px;
        color: #a0a6b2;
        font-size: 7px;
        text-transform: uppercase;
        letter-spacing: .4px;
    }

    .history-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 24px;
        padding: 0 9px;
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
        font-weight: 600;
    }

    .history-date {
        margin-top: 3px;
        color: #a0a6b2;
        font-size: 8px;
    }

    .history-restore button {
        height: 27px;
        padding: 0 9px;
        border: 1px solid #dfe3e9;
        border-radius: 6px;
        background: #ffffff;
        color: #737b8b;
        font-size: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all .15s ease;
    }

    .history-restore button:hover {
        background: #f5f6f8;
        border-color: #cdd2dc;
        color: #4f5665;
    }

    .history-empty {
        padding: 30px 20px;
        border: 1px solid #e7e9ef;
        border-radius: 11px;
        background: #ffffff;
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
        padding: 22px;
        background: rgba(15, 23, 42, .56);
        backdrop-filter: blur(2px);
    }

    .detail-modal.active {
        display: flex;
    }

    .modal-box {
        width: 100%;
        max-width: 900px;
        max-height: 91vh;
        overflow: hidden;
        border: 1px solid rgba(255,255,255,.2);
        border-radius: 15px;
        background: #ffffff;
        box-shadow: 0 25px 70px rgba(0,0,0,.22);
        animation: modalIn .18s ease-out;
    }

    @keyframes modalIn {
        from {
            opacity: 0;
            transform: translateY(8px) scale(.99);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .modal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        padding: 19px 22px;
        background: linear-gradient(135deg, #4f46e5, #6366f1);
        color: #ffffff;
    }

    .modal-header h2 {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
    }

    .modal-header p {
        margin: 4px 0 0;
        font-size: 9px;
        opacity: .82;
    }

    .close-btn {
        width: 31px;
        height: 31px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border: none;
        border-radius: 7px;
        background: rgba(255,255,255,.15);
        color: #ffffff;
        font-size: 18px;
        line-height: 1;
        cursor: pointer;
        transition: background .15s ease;
    }

    .close-btn:hover {
        background: rgba(255,255,255,.25);
    }

    .modal-body {
        max-height: calc(91vh - 150px);
        overflow-y: auto;
        padding: 21px 22px;
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
        gap: 13px;
    }

    .info-card {
        padding: 15px;
        border: 1px solid #e5e8ef;
        border-radius: 10px;
    }

    .main-data {
        background: #fafaff;
        border-color: #e0e3f8;
    }

    .compare-data {
        background: #fafcff;
        border-color: #dfe8f5;
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

    /* =========================================================
       KTP PREVIEW
    ========================================================= */
    .ktp-preview-wrapper {
        margin-top: 12px;
        padding-top: 12px;
        border-top: 1px solid rgba(0,0,0,.06);
    }

    .ktp-preview-label {
        margin-bottom: 8px;
        color: #9199a8;
        font-size: 9px;
        font-weight: 700;
    }

    .ktp-preview-button {
        display: block;
        width: 100%;
        padding: 0;
        border: 1px solid #dfe3eb;
        border-radius: 8px;
        background: #ffffff;
        overflow: hidden;
        cursor: pointer;
        transition: all .15s ease;
    }

    .ktp-preview-button:hover {
        border-color: #b8bfd0;
        box-shadow: 0 4px 12px rgba(15, 23, 42, .08);
        transform: translateY(-1px);
    }

    .ktp-preview-image {
        display: block;
        width: 100%;
        height: 145px;
        object-fit: cover;
        object-position: center;
        background: #f4f5f8;
    }

    .ktp-preview-caption {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        min-height: 30px;
        padding: 6px 8px;
        color: #596275;
        font-size: 8px;
        font-weight: 700;
    }

    .ktp-unavailable {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 80px;
        padding: 10px;
        border: 1px dashed #d9dde5;
        border-radius: 8px;
        background: #f8f9fb;
        color: #9aa1af;
        font-size: 8px;
        text-align: center;
    }

    /* =========================================================
       DECISION
    ========================================================= */
    .decision-footer {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
        padding: 14px 22px;
        border-top: 1px solid #edf0f4;
        background: #fafbfc;
    }

    .decision-footer form {
        margin: 0;
    }

    .decision-btn {
        height: 32px;
        padding: 0 13px;
        border: none;
        border-radius: 7px;
        font-size: 8px;
        font-weight: 700;
        cursor: pointer;
        transition: all .15s ease;
    }

    .choose-main {
        background: #4f46e5;
        color: #ffffff;
    }

    .choose-main:hover {
        background: #4338ca;
    }

    .choose-compare {
        background: #eef2ff;
        color: #4f46e5;
    }

    .choose-compare:hover {
        background: #e0e7ff;
    }

    .not-duplicate {
        background: #eaf8f0;
        color: #16834f;
    }

    .not-duplicate:hover {
        background: #d9f3e5;
    }

    /* =========================================================
       RESPONSIVE
    ========================================================= */
    @media (max-width: 1150px) {
        .check-card-main {
            grid-template-columns:
                34px
                minmax(160px, 1fr)
                34px
                minmax(160px, 1fr);
        }

        .case-actions {
            grid-column: 2 / -1;
            justify-content: flex-start;
            padding-top: 2px;
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
            padding: 30px 15px 40px;
        }

        .check-header {
            align-items: flex-start;
            margin-bottom: 25px;
        }

        .check-header-left h1 {
            font-size: 22px;
        }

        .check-summary {
            display: none;
        }

        .check-card-main {
            grid-template-columns: 30px 1fr;
            gap: 12px;
            padding: 14px;
        }

        .vs {
            display: none;
        }

        .case-actions {
            grid-column: 2;
            justify-content: flex-start;
            flex-wrap: wrap;
        }

        .comparison-grid {
            grid-template-columns: 1fr;
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
        .check-page {
            padding: 25px 12px 35px;
        }

        .modal-body {
            padding: 17px;
        }

        .modal-header {
            padding: 16px 17px;
        }

        .decision-footer {
            padding: 13px 17px;
        }

        .history-table-head,
        .history-row {
            min-width: 780px;
        }

        .info-row {
            grid-template-columns: 95px 1fr;
        }

        .ktp-preview-image {
            height: 125px;
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
                <strong>Kasus</strong>

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
                        $comparison && is_array($comparison->data)
                            ? $comparison->data
                            : [];

                    $comparisonNama =
                        $comparisonData['nama_lengkap'] ?? '-';

                    $comparisonNik =
                        $comparisonData['nik'] ?? '-';

                    $note = strtolower(
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

                        {{-- NOMOR --}}
                        <div class="case-no">
                            {{ $index + 1 }}
                        </div>


                        {{-- DATA PPKS --}}
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


                        {{-- VS --}}
                        <div class="vs">
                            VS
                        </div>


                        {{-- DATA PEMBANDING --}}
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


                        {{-- AKSI --}}
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


                {{-- DATA --}}
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
            $comparison && is_array($comparison->data)
                ? $comparison->data
                : [];


        /*
        |--------------------------------------------------------------------------
        | HELPER GOOGLE DRIVE
        |--------------------------------------------------------------------------
        */

        $getDriveFileId = function ($file) {

            if (!$file) {
                return null;
            }

            $file = trim((string) $file);


            // Format:
            // https://drive.google.com/file/d/FILE_ID/view
            if (
                preg_match(
                    '#drive\.google\.com/file/d/([^/?]+)#',
                    $file,
                    $matches
                )
            ) {
                return $matches[1];
            }


            // Format:
            // https://drive.google.com/open?id=FILE_ID
            if (
                preg_match(
                    '#drive\.google\.com/open\?id=([^&]+)#',
                    $file,
                    $matches
                )
            ) {
                return $matches[1];
            }


            // Format:
            // https://drive.google.com/uc?id=FILE_ID
            if (
                preg_match(
                    '#drive\.google\.com/uc\?.*id=([^&]+)#',
                    $file,
                    $matches
                )
            ) {
                return $matches[1];
            }


            // Format:
            // https://drive.usercontent.google.com/download?id=FILE_ID
            if (
                preg_match(
                    '#drive\.usercontent\.google\.com/.*[?&]id=([^&]+)#',
                    $file,
                    $matches
                )
            ) {
                return $matches[1];
            }


            // Raw Google Drive File ID
            if (
                !str_contains($file, '/')
                && !str_contains($file, ':')
                && strlen($file) > 10
            ) {
                return $file;
            }

            return null;
        };


        /*
        |--------------------------------------------------------------------------
        | HELPER URL FILE
        |--------------------------------------------------------------------------
        */

        $getFileUrl = function ($file) use ($getDriveFileId) {

            if (!$file) {
                return null;
            }

            $file = trim((string) $file);

            $driveId = $getDriveFileId($file);


            // Google Drive
            if ($driveId) {

                return route(
                    'ppks.file',
                    [
                        'fileId' => $driveId
                    ]
                );

            }


            // URL biasa
            if (
                str_starts_with($file, 'http://')
                || str_starts_with($file, 'https://')
            ) {
                return $file;
            }


            // File lokal
            return asset(
                'storage/' . ltrim($file, '/')
            );

        };


        /*
        |--------------------------------------------------------------------------
        | KTP DATA YANG DIPERIKSA
        |--------------------------------------------------------------------------
        */

        $ktp = $data['upload_ktp'] ?? null;

        $ktpUrl = $getFileUrl($ktp);


        /*
        |--------------------------------------------------------------------------
        | KTP DATA PEMBANDING
        |--------------------------------------------------------------------------
        */

        $comparisonKtp =
            $comparisonData['upload_ktp'] ?? null;

        $comparisonKtpUrl =
            $getFileUrl($comparisonKtp);

    @endphp


    <div
        id="detailModal{{ $ppks->id }}"
        class="detail-modal"
        role="dialog"
        aria-modal="true"
        aria-labelledby="detailTitle{{ $ppks->id }}"
    >

        <div class="modal-box">

            {{-- HEADER --}}
            <div class="modal-header">

                <div>

                    <h2 id="detailTitle{{ $ppks->id }}">
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
                    aria-label="Tutup detail"
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

                    {{-- =================================================
                         DATA YANG DIPERIKSA
                    ================================================== --}}
                    <div class="info-card main-data">

                        <div class="info-card-label">
                            Data yang diperiksa
                        </div>

                        <div class="info-card-name">
                            {{ $data['nama_lengkap'] ?? '-' }}
                        </div>


                        <div class="info-row">

                            <span class="info-label">
                                NIK
                            </span>

                            <span class="info-value">
                                {{ $data['nik'] ?? '-' }}
                            </span>

                        </div>


                        <div class="info-row">

                            <span class="info-label">
                                Jenis Kelamin
                            </span>

                            <span class="info-value">
                                {{ $data['jenis_kelamin'] ?? '-' }}
                            </span>

                        </div>


                        <div class="info-row">

                            <span class="info-label">
                                Tempat Lahir
                            </span>

                            <span class="info-value">
                                {{ $data['tempat_lahir'] ?? '-' }}
                            </span>

                        </div>


                        <div class="info-row">

                            <span class="info-label">
                                Tanggal Lahir
                            </span>

                            <span class="info-value">
                                {{ $data['tanggal_lahir'] ?? '-' }}
                            </span>

                        </div>


                        <div class="info-row">

                            <span class="info-label">
                                Timestamp
                            </span>

                            <span class="info-value">
                                {{ $data['timestamp'] ?? '-' }}
                            </span>

                        </div>


                        {{-- =================================================
                             KTP DATA YANG DIPERIKSA
                        ================================================== --}}
                        <div class="ktp-preview-wrapper">

                            <div class="ktp-preview-label">
                                Kartu Tanda Penduduk (KTP)
                            </div>


                            @if ($ktpUrl)

                                <button
                                    type="button"
                                    class="ktp-preview-button"
                                    onclick="openKtpPreview(
                                        @js($ktpUrl),
                                        @js('KTP - ' . ($data['nama_lengkap'] ?? 'Data yang diperiksa'))
                                    )"
                                    title="Lihat KTP"
                                >

                                    <img
                                        src="{{ $ktpUrl }}"
                                        alt="KTP {{ $data['nama_lengkap'] ?? '' }}"
                                        class="ktp-preview-image"
                                        loading="lazy"
                                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                    >

                                    <div
                                        class="ktp-unavailable"
                                        style="display:none;"
                                    >
                                        KTP tidak dapat ditampilkan.
                                        Klik tombol untuk membuka file.
                                    </div>

                                    <div class="ktp-preview-caption">
                                        Lihat KTP
                                    </div>

                                </button>

                            @else

                                <div class="ktp-unavailable">
                                    Foto KTP tidak tersedia
                                </div>

                            @endif

                        </div>

                    </div>


                    {{-- =================================================
                         DATA PEMBANDING
                    ================================================== --}}
                    <div class="info-card compare-data">

                        <div class="info-card-label">
                            Data Pembanding
                        </div>


                        @if ($comparison)

                            <div class="info-card-name">
                                {{ $comparisonData['nama_lengkap'] ?? '-' }}
                            </div>


                            <div class="info-row">

                                <span class="info-label">
                                    NIK
                                </span>

                                <span class="info-value">
                                    {{ $comparisonData['nik'] ?? '-' }}
                                </span>

                            </div>


                            <div class="info-row">

                                <span class="info-label">
                                    Jenis Kelamin
                                </span>

                                <span class="info-value">
                                    {{ $comparisonData['jenis_kelamin'] ?? '-' }}
                                </span>

                            </div>


                            <div class="info-row">

                                <span class="info-label">
                                    Tempat Lahir
                                </span>

                                <span class="info-value">
                                    {{ $comparisonData['tempat_lahir'] ?? '-' }}
                                </span>

                            </div>


                            <div class="info-row">

                                <span class="info-label">
                                    Tanggal Lahir
                                </span>

                                <span class="info-value">
                                    {{ $comparisonData['tanggal_lahir'] ?? '-' }}
                                </span>

                            </div>


                            <div class="info-row">

                                <span class="info-label">
                                    Timestamp
                                </span>

                                <span class="info-value">
                                    {{ $comparisonData['timestamp'] ?? '-' }}
                                </span>

                            </div>


                            {{-- =================================================
                                 KTP DATA PEMBANDING
                            ================================================== --}}
                            <div class="ktp-preview-wrapper">

                                <div class="ktp-preview-label">
                                    Kartu Tanda Penduduk (KTP)
                                </div>


                                @if ($comparisonKtpUrl)

                                    <button
                                        type="button"
                                        class="ktp-preview-button"
                                        onclick="openKtpPreview(
                                            @js($comparisonKtpUrl),
                                            @js('KTP - ' . ($comparisonData['nama_lengkap'] ?? 'Data Pembanding'))
                                        )"
                                        title="Lihat KTP Pembanding"
                                    >

                                        <img
                                            src="{{ $comparisonKtpUrl }}"
                                            alt="KTP {{ $comparisonData['nama_lengkap'] ?? '' }}"
                                            class="ktp-preview-image"
                                            loading="lazy"
                                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                        >

                                        <div
                                            class="ktp-unavailable"
                                            style="display:none;"
                                        >
                                            KTP tidak dapat ditampilkan.
                                            Klik tombol untuk membuka file.
                                        </div>

                                        <div class="ktp-preview-caption">
                                            Lihat KTP Pembanding
                                        </div>

                                    </button>

                                @else

                                    <div class="ktp-unavailable">
                                        Foto KTP tidak tersedia
                                    </div>

                                @endif

                            </div>


                        @else

                            <div class="info-card-name">
                                Tidak ditemukan
                            </div>

                            <div class="ktp-unavailable">
                                Data pembanding tidak tersedia
                            </div>

                        @endif

                    </div>

                </div>

            </div>


            {{-- =========================================================
                 DECISION
            ========================================================== --}}
            <div class="decision-footer">

                {{-- PILIH DATA INI --}}
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


                {{-- PILIH PEMBANDING --}}
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


                {{-- BUKAN DUPLIKAT --}}
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
    /**
     * =========================================================
     * DETAIL MODAL
     * =========================================================
     */

    function openDetail(id) {

        const modal =
            document.getElementById('detailModal' + id);

        if (!modal) {
            return;
        }

        modal.classList.add('active');

        document.body.style.overflow = 'hidden';


        const closeButton =
            modal.querySelector('.close-btn');

        if (closeButton) {

            setTimeout(function () {
                closeButton.focus();
            }, 50);

        }

    }


    function closeDetail(id) {

        const modal =
            document.getElementById('detailModal' + id);

        if (!modal) {
            return;
        }

        modal.classList.remove('active');


        const activeModal =
            document.querySelector('.detail-modal.active');

        if (!activeModal) {
            document.body.style.overflow = '';
        }

    }


    /**
     * =========================================================
     * PREVIEW KTP
     * =========================================================
     */

    function openKtpPreview(url, title) {

        if (!url) {
            return;
        }


        const width = 1000;
        const height = 750;


        const left =
            Math.max(
                0,
                (window.screen.width - width) / 2
            );


        const top =
            Math.max(
                0,
                (window.screen.height - height) / 2
            );


        const previewWindow =
            window.open(
                '',
                '_blank',
                'width=' + width +
                ',height=' + height +
                ',left=' + left +
                ',top=' + top +
                ',resizable=yes,scrollbars=yes'
            );


        /*
         * Jika browser memblokir popup,
         * buka URL langsung.
         */
        if (!previewWindow) {

            window.open(
                url,
                '_blank'
            );

            return;
        }


        previewWindow.document.write(`
            <!DOCTYPE html>

            <html lang="id">

            <head>

                <meta charset="UTF-8">

                <title>${escapeHtml(title)}</title>

                <style>

                    * {
                        box-sizing: border-box;
                    }

                    body {
                        margin: 0;
                        min-height: 100vh;
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        justify-content: center;
                        padding: 25px;
                        background: #111827;
                        font-family: Arial, sans-serif;
                    }

                    .preview-title {
                        margin-bottom: 15px;
                        color: #ffffff;
                        font-size: 15px;
                        font-weight: 700;
                        text-align: center;
                    }

                    .preview-image {
                        display: block;
                        max-width: 95vw;
                        max-height: 82vh;
                        object-fit: contain;
                        border-radius: 8px;
                        background: #ffffff;
                        box-shadow:
                            0 15px 45px rgba(0,0,0,.35);
                    }

                    .preview-note {
                        margin-top: 12px;
                        color: #cbd5e1;
                        font-size: 11px;
                        text-align: center;
                    }

                    .preview-note a {
                        color: #93c5fd;
                    }

                </style>

            </head>


            <body>

                <div class="preview-title">
                    ${escapeHtml(title)}
                </div>


                <img
                    src="${escapeAttribute(url)}"
                    class="preview-image"
                    alt="${escapeAttribute(title)}"
                    onerror="this.style.display='none'; document.getElementById('error').style.display='block';"
                >


                <div
                    id="error"
                    class="preview-note"
                    style="display:none;"
                >

                    KTP tidak dapat ditampilkan sebagai gambar.

                    <br>

                    Silakan buka file secara langsung.

                    <br><br>

                    <a
                        href="${escapeAttribute(url)}"
                        target="_blank"
                    >
                        Buka file
                    </a>

                </div>

            </body>

            </html>
        `);


        previewWindow.document.close();

    }


    /**
     * =========================================================
     * ESCAPE HTML
     * =========================================================
     */

    function escapeHtml(value) {

        return String(value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');

    }


    /**
     * =========================================================
     * ESCAPE ATTRIBUTE
     * =========================================================
     */

    function escapeAttribute(value) {

        return String(value)
            .replace(/&/g, '&amp;')
            .replace(/"/g, '&quot;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');

    }


    /**
     * =========================================================
     * KLIK BACKGROUND MODAL
     * =========================================================
     */

    document.addEventListener(
        'click',
        function (event) {

            if (
                event.target.classList.contains(
                    'detail-modal'
                )
            ) {

                event.target.classList.remove(
                    'active'
                );


                const activeModal =
                    document.querySelector(
                        '.detail-modal.active'
                    );


                if (!activeModal) {
                    document.body.style.overflow = '';
                }

            }

        }
    );


    /**
     * =========================================================
     * ESC UNTUK MENUTUP MODAL
     * =========================================================
     */

    document.addEventListener(
        'keydown',
        function (event) {

            if (event.key !== 'Escape') {
                return;
            }


            const activeModals =
                document.querySelectorAll(
                    '.detail-modal.active'
                );


            activeModals.forEach(
                function (modal) {

                    modal.classList.remove(
                        'active'
                    );

                }
            );


            document.body.style.overflow = '';

        }
    );


    /**
     * =========================================================
     * MENCEGAH KLIK DALAM MODAL
     * =========================================================
     */

    document
        .querySelectorAll('.modal-box')
        .forEach(
            function (box) {

                box.addEventListener(
                    'click',
                    function (event) {

                        event.stopPropagation();

                    }
                );

            }
        );

</script>

</x-app-layout>
