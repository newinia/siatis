<x-app-layout>

```
<div class="check-page">

    {{-- HEADER --}}
    <div class="check-header">
        <div>
            <h1>Riwayat Pemeriksaan</h1>
            <p>Riwayat keputusan pemeriksaan data yang terindikasi memiliki kesamaan identitas.</p>
        </div>

        <div class="count-badge">
            {{ $histories->count() }} Riwayat
        </div>
    </div>

    {{-- RIWAYAT --}}
    <div class="history-list">

        @forelse ($histories as $history)

            @php
                $ppksData = $history->ppks_before['data'] ?? [];
                $comparisonData = $history->comparison_before['data'] ?? [];

                $decisionLabels = [
                    'pilih_data_ini' => 'Pilih Data Ini',
                    'pilih_data_pembanding' => 'Pilih Data Pembanding',
                    'bukan_duplikat' => 'Bukan Duplikat',
                    'dikembalikan' => 'Dikembalikan',
                ];

                $decisionLabel = $decisionLabels[$history->decision]
                    ?? ucfirst(str_replace('_', ' ', $history->decision));
            @endphp

            <div class="history-card">

                {{-- TOP --}}
                <div class="history-top">

                    <div>
                        <span class="history-label">Keputusan Pemeriksaan</span>

                        <h3>
                            {{ $decisionLabel }}
                        </h3>
                    </div>

                    <div class="history-date">
                        {{ $history->created_at?->format('d M Y, H:i') }}
                    </div>

                </div>

                {{-- DATA --}}
                <div class="history-content">

                    <div class="person-card">
                        <span class="person-label">PPKS</span>

                        <strong>
                            {{ $ppksData['nama_lengkap'] ?? '-' }}
                        </strong>

                        <div class="person-detail">
                            NIK: {{ $ppksData['nik'] ?? '-' }}
                        </div>

                        <div class="person-detail">
                            Status sebelum:
                            <span class="status-text">
                                {{ $history->status_sebelum ?? '-' }}
                            </span>
                        </div>
                    </div>

                    <div class="vs">
                        VS
                    </div>

                    <div class="person-card">
                        <span class="person-label">Pembanding</span>

                        <strong>
                            {{ $comparisonData['nama_lengkap'] ?? '-' }}
                        </strong>

                        <div class="person-detail">
                            NIK: {{ $comparisonData['nik'] ?? '-' }}
                        </div>
                    </div>

                </div>

                {{-- FOOTER --}}
                <div class="history-footer">

                    <div class="history-info">
                        <span>
                            Pemeriksa:
                            <strong>
                                {{ $history->user?->name ?? 'Tidak diketahui' }}
                            </strong>
                        </span>

                        @if ($history->catatan)
                            <span>
                                {{ $history->catatan }}
                            </span>
                        @endif
                    </div>

                    <form
                        method="POST"
                        action="{{ route('ppks.duplicate-restore', $history) }}"
                        onsubmit="return confirm('Yakin ingin mengembalikan data ke kondisi sebelum keputusan ini?')"
                    >
                        @csrf
                        @method('PATCH')

                        <button type="submit" class="restore-button">
                            Kembalikan
                        </button>
                    </form>

                </div>

            </div>

        @empty

            <div class="empty-history">
                <div class="empty-icon">✓</div>

                <h3>Belum Ada Riwayat</h3>

                <p>
                    Belum ada keputusan pemeriksaan yang tersimpan.
                </p>
            </div>

        @endforelse

    </div>

</div>

<style>

    .check-page {
        padding: 28px 32px 40px;
        max-width: 1400px;
        margin: 0 auto;
    }

    .check-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 24px;
    }

    .check-header h1 {
        margin: 0;
        font-size: 25px;
        font-weight: 700;
        color: #222;
    }

    .check-header p {
        margin: 6px 0 0;
        color: #777;
        font-size: 13px;
        line-height: 1.5;
        font-weight: 400;
    }

    .count-badge {
        padding: 8px 14px;
        border-radius: 20px;
        background: #f1f1f1;
        color: #555;
        font-size: 13px;
        font-weight: 600;
    }

    .history-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .history-card {
        background: #fff;
        border: 1px solid #e8e8e8;
        border-radius: 14px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }

    .history-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding-bottom: 16px;
        border-bottom: 1px solid #eeeeee;
    }

    .history-label {
        display: block;
        font-size: 11px;
        color: #999;
        margin-bottom: 4px;
        text-transform: uppercase;
        letter-spacing: .4px;
    }

    .history-top h3 {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
        color: #333;
    }

    .history-date {
        font-size: 12px;
        color: #888;
    }

    .history-content {
        display: grid;
        grid-template-columns: 1fr 70px 1fr;
        align-items: center;
        gap: 14px;
        padding: 18px 0;
    }

    .person-card {
        border: 1px solid #ededed;
        border-radius: 10px;
        padding: 15px;
        background: #fafafa;
    }

    .person-label {
        display: block;
        font-size: 11px;
        color: #999;
        margin-bottom: 7px;
        text-transform: uppercase;
    }

    .person-card strong {
        display: block;
        font-size: 15px;
        color: #333;
        margin-bottom: 8px;
    }

    .person-detail {
        font-size: 12px;
        color: #777;
        margin-top: 4px;
    }

    .status-text {
        color: #555;
        font-weight: 600;
    }

    .vs {
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 11px;
        font-weight: 700;
        color: #aaa;
    }

    .history-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        padding-top: 15px;
        border-top: 1px solid #eeeeee;
    }

    .history-info {
        display: flex;
        flex-direction: column;
        gap: 5px;
        font-size: 12px;
        color: #888;
    }

    .history-info strong {
        color: #555;
    }

    .restore-button {
        border: none;
        border-radius: 8px;
        padding: 9px 15px;
        background: #f2f2f2;
        color: #444;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: .2s;
    }

    .restore-button:hover {
        background: #e5e5e5;
    }

    .empty-history {
        background: #fff;
        border: 1px solid #e8e8e8;
        border-radius: 14px;
        padding: 60px 20px;
        text-align: center;
    }

    .empty-icon {
        width: 44px;
        height: 44px;
        margin: 0 auto 12px;
        border-radius: 50%;
        background: #f2f2f2;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #777;
        font-size: 18px;
    }

    .empty-history h3 {
        margin: 0;
        font-size: 16px;
        color: #444;
    }

    .empty-history p {
        margin: 6px 0 0;
        font-size: 13px;
        color: #999;
    }

    @media (max-width: 700px) {

        .check-page {
            padding: 20px 16px;
        }

        .check-header {
            flex-direction: column;
            gap: 12px;
        }

        .history-content {
            grid-template-columns: 1fr;
        }

        .vs {
            padding: 4px;
        }

        .history-footer {
            flex-direction: column;
            align-items: stretch;
        }

        .restore-button {
            width: 100%;
        }
    }

</style>
```

</x-app-layout>
