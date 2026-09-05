<?php

namespace App\Http\Controllers;

use App\Models\Ppks;
use App\Models\RiwayatPemeriksaan;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PpksDuplicateController extends Controller
{
    /**
     * ============================================================
     * PERLU PEMERIKSAAN
     * ============================================================
     */
    public function index(): View
    {
        $duplicates = Ppks::where('status', 'perlu_diperiksa')
            ->orderByDesc('id')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | RIWAYAT PEMERIKSAAN
        |--------------------------------------------------------------------------
        */
        $histories = RiwayatPemeriksaan::with([
            'ppks',
            'comparison',
            'user',
        ])
            ->where('decision', '!=', 'dikembalikan')
            ->orderByDesc('created_at')
            ->get();

        return view(
            'ppks.duplicates',
            compact('duplicates', 'histories')
        );
    }

    /**
     * ============================================================
     * KEPUTUSAN DATA
     * ============================================================
     */
    public function decide(
        Request $request,
        Ppks $ppks
    ): RedirectResponse {

        $request->validate([
            'decision' => [
                'required',
                'in:pilih_data_ini,pilih_data_pembanding,bukan_duplikat',
            ],
        ]);

        $decision = $request->decision;

        /*
        |--------------------------------------------------------------------------
        | CARI DATA PEMBANDING
        |--------------------------------------------------------------------------
        */
        $comparison = $this->findComparison($ppks);

        /*
        |--------------------------------------------------------------------------
        | PILIH DATA PEMBANDING TAPI TIDAK ADA PEMBANDING
        |--------------------------------------------------------------------------
        */
        if (
            $decision === 'pilih_data_pembanding'
            && !$comparison
        ) {
            return back()->with(
                'error',
                'Data pembanding tidak ditemukan.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | SIMPAN SNAPSHOT SEBELUM PERUBAHAN
        |--------------------------------------------------------------------------
        */
        $ppksBefore = $this->snapshot($ppks);

        $comparisonBefore = $comparison
            ? $this->snapshot($comparison)
            : null;

        /*
        |--------------------------------------------------------------------------
        | PROSES DALAM TRANSACTION
        |--------------------------------------------------------------------------
        */
        DB::transaction(function () use (
            $ppks,
            $comparison,
            $decision,
            $ppksBefore,
            $comparisonBefore
        ) {

            /*
            |--------------------------------------------------------------------------
            | PILIH DATA INI
            |--------------------------------------------------------------------------
            */
            if ($decision === 'pilih_data_ini') {

                $ppks->update([
                    'status' => 'normal',
                    'selected_for_assessment' => true,
                    'selected_from_duplicate_id' =>
                        $comparison?->id,
                    'duplicate_decision' =>
                        'pilih_data_ini',
                ]);

                if ($comparison) {

                    $comparison->update([
                        'status' => 'duplikat',
                        'selected_for_assessment' => false,
                        'selected_from_duplicate_id' =>
                            $ppks->id,
                        'duplicate_decision' =>
                            'duplikat',
                    ]);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | PILIH DATA PEMBANDING
            |--------------------------------------------------------------------------
            */
            if ($decision === 'pilih_data_pembanding') {

                $comparison->update([
                    'status' => 'normal',
                    'selected_for_assessment' => true,
                    'selected_from_duplicate_id' =>
                        $ppks->id,
                    'duplicate_decision' =>
                        'pilih_data_pembanding',
                ]);

                $ppks->update([
                    'status' => 'duplikat',
                    'selected_for_assessment' => false,
                    'selected_from_duplicate_id' =>
                        $comparison->id,
                    'duplicate_decision' =>
                        'duplikat',
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | BUKAN DUPLIKAT
            |--------------------------------------------------------------------------
            */
            if ($decision === 'bukan_duplikat') {

                $ppks->update([
                    'status' => 'normal',
                    'selected_for_assessment' => true,
                    'selected_from_duplicate_id' => null,
                    'duplicate_decision' =>
                        'bukan_duplikat',
                    'possible_duplicate_of' => null,
                    'duplicate_note' => null,
                ]);

                if ($comparison) {

                    $comparison->update([
                        'status' => 'normal',
                        'selected_for_assessment' => true,
                        'selected_from_duplicate_id' => null,
                        'duplicate_decision' =>
                            'bukan_duplikat',
                        'possible_duplicate_of' => null,
                        'duplicate_note' => null,
                    ]);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | SIMPAN RIWAYAT
            |--------------------------------------------------------------------------
            */
            RiwayatPemeriksaan::create([
                'ppks_id' =>
                    $ppks->id,

                'comparison_id' =>
                    $comparison?->id,

                'decision' =>
                    $decision,

                'status_sebelum' =>
                    $ppksBefore['status'] ?? null,

                'status_sesudah' =>
                    $ppks->fresh()->status,

                'ppks_before' =>
                    $ppksBefore,

                'comparison_before' =>
                    $comparisonBefore,

                'decided_by' =>
                    Auth::id(),

                'catatan' =>
                    null,
            ]);
        });

        /*
        |--------------------------------------------------------------------------
        | PESAN
        |--------------------------------------------------------------------------
        */
        if ($decision === 'pilih_data_ini') {

            return back()->with(
                'success',
                'Data ini berhasil dipilih dan masuk ke Data Normal.'
            );
        }

        if ($decision === 'pilih_data_pembanding') {

            return back()->with(
                'success',
                'Data pembanding berhasil dipilih dan masuk ke Data Normal.'
            );
        }

        return back()->with(
            'success',
            'Data dinyatakan bukan duplikat dan masuk ke Data Normal.'
        );
    }

    /**
     * ============================================================
     * RIWAYAT PEMERIKSAAN
     * ============================================================
     *
     * Method ini tetap disediakan karena route history sudah ada.
     * Halaman utama riwayat tetap ditampilkan di duplicates.blade.php.
     */
    public function history(): View
    {
        $histories = RiwayatPemeriksaan::with([
            'ppks',
            'comparison',
            'user',
        ])
            ->where('decision', '!=', 'dikembalikan')
            ->orderByDesc('created_at')
            ->get();

        return view(
            'ppks.duplicate-history',
            compact('histories')
        );
    }

    /**
     * ============================================================
     * KEMBALIKAN DATA
     * ============================================================
     */
    public function restore(
        RiwayatPemeriksaan $history
    ): RedirectResponse {

        /*
        |--------------------------------------------------------------------------
        | CEK SNAPSHOT
        |--------------------------------------------------------------------------
        */
        if (!$history->ppks_before) {

            return back()->with(
                'error',
                'Data lama tidak memiliki snapshot sehingga tidak dapat dikembalikan.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | CARI DATA
        |--------------------------------------------------------------------------
        */
        $ppks = Ppks::find(
            $history->ppks_id
        );

        $comparison = $history->comparison_id
            ? Ppks::find($history->comparison_id)
            : null;

        if (!$ppks) {

            return back()->with(
                'error',
                'Data PPKS tidak ditemukan.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | RESTORE DALAM TRANSACTION
        |--------------------------------------------------------------------------
        */
        DB::transaction(function () use (
            $history,
            $ppks,
            $comparison
        ) {

            /*
            |--------------------------------------------------------------------------
            | SNAPSHOT KONDISI SAAT INI
            |--------------------------------------------------------------------------
            */
            $currentPpks =
                $this->snapshot($ppks);

            $currentComparison =
                $comparison
                    ? $this->snapshot($comparison)
                    : null;

            /*
            |--------------------------------------------------------------------------
            | SNAPSHOT LAMA
            |--------------------------------------------------------------------------
            */
            $before =
                $history->ppks_before;

            /*
            |--------------------------------------------------------------------------
            | KEMBALIKAN DATA UTAMA
            |--------------------------------------------------------------------------
            */
            $ppks->update([

                'data' =>
                    $before['data']
                    ?? $ppks->data,

                'status' =>
                    $before['status']
                    ?? 'perlu_diperiksa',

                'possible_duplicate_of' =>
                    $before['possible_duplicate_of']
                    ?? null,

                'duplicate_note' =>
                    $before['duplicate_note']
                    ?? null,

                'selected_for_assessment' =>
                    $before['selected_for_assessment']
                    ?? false,

                'selected_from_duplicate_id' =>
                    $before['selected_from_duplicate_id']
                    ?? null,

                'duplicate_decision' =>
                    $before['duplicate_decision']
                    ?? null,
            ]);

            /*
            |--------------------------------------------------------------------------
            | KEMBALIKAN DATA PEMBANDING
            |--------------------------------------------------------------------------
            */
            if (
                $comparison
                && $history->comparison_before
            ) {

                $comparisonBefore =
                    $history->comparison_before;

                $comparison->update([

                    'data' =>
                        $comparisonBefore['data']
                        ?? $comparison->data,

                    'status' =>
                        $comparisonBefore['status']
                        ?? 'normal',

                    'possible_duplicate_of' =>
                        $comparisonBefore['possible_duplicate_of']
                        ?? null,

                    'duplicate_note' =>
                        $comparisonBefore['duplicate_note']
                        ?? null,

                    'selected_for_assessment' =>
                        $comparisonBefore['selected_for_assessment']
                        ?? false,

                    'selected_from_duplicate_id' =>
                        $comparisonBefore['selected_from_duplicate_id']
                        ?? null,

                    'duplicate_decision' =>
                        $comparisonBefore['duplicate_decision']
                        ?? null,
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | CATAT BAHWA DATA DIKEMBALIKAN
            |--------------------------------------------------------------------------
            */
            RiwayatPemeriksaan::create([

                'ppks_id' =>
                    $history->ppks_id,

                'comparison_id' =>
                    $history->comparison_id,

                'decision' =>
                    'dikembalikan',

                'status_sebelum' =>
                    $currentPpks['status']
                    ?? null,

                'status_sesudah' =>
                    $ppks->fresh()->status,

                'ppks_before' =>
                    $currentPpks,

                'comparison_before' =>
                    $currentComparison,

                'decided_by' =>
                    Auth::id(),

                'catatan' =>
                    'Data dikembalikan ke kondisi sebelum keputusan pemeriksaan.',
            ]);
        });

        return back()->with(
            'success',
            'Data berhasil dikembalikan ke kondisi sebelum keputusan.'
        );
    }

    /**
     * ============================================================
     * SNAPSHOT DATA
     * ============================================================
     */
    private function snapshot(Ppks $ppks): array
    {
        return [

            'id' =>
                $ppks->id,

            'data' =>
                $ppks->data,

            'status' =>
                $ppks->status,

            'possible_duplicate_of' =>
                $ppks->possible_duplicate_of,

            'duplicate_note' =>
                $ppks->duplicate_note,

            'selected_for_assessment' =>
                $ppks->selected_for_assessment,

            'selected_from_duplicate_id' =>
                $ppks->selected_from_duplicate_id,

            'duplicate_decision' =>
                $ppks->duplicate_decision,
        ];
    }

    /**
     * ============================================================
     * CARI DATA PEMBANDING
     * ============================================================
     */
    private function findComparison(
        Ppks $ppks
    ): ?Ppks {

        /*
        |--------------------------------------------------------------------------
        | CARA 1
        |--------------------------------------------------------------------------
        */
        if (
            $ppks->possible_duplicate_of
            && $ppks->possible_duplicate_of != $ppks->id
        ) {

            $comparison = Ppks::find(
                $ppks->possible_duplicate_of
            );

            if ($comparison) {
                return $comparison;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | CARA 2
        |--------------------------------------------------------------------------
        */
        $comparison = Ppks::where(
            'possible_duplicate_of',
            $ppks->id
        )->first();

        if ($comparison) {
            return $comparison;
        }

        return null;
    }
}
