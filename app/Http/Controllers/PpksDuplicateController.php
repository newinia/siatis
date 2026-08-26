<?php

namespace App\Http\Controllers;

use App\Models\Ppks;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PpksDuplicateController extends Controller
{
    /**
     * Menampilkan data yang perlu diperiksa.
     */
    public function index(): View
    {
        $allDuplicates = Ppks::where(
            'status',
            'perlu_diperiksa'
        )
            ->orderBy('sheet_row', 'desc')
            ->get();

        $processed = [];
        $cases = collect();

        foreach ($allDuplicates as $ppks) {

            // Lewati jika sudah diproses
            if (in_array($ppks->id, $processed)) {
                continue;
            }

            // Cari data pembanding
            $comparison = $this->findComparison(
                $ppks,
                $allDuplicates
            );

            // Tandai data utama
            $processed[] = $ppks->id;

            // Tandai pembanding
            if ($comparison) {
                $processed[] = $comparison->id;
            }

            $cases->push([
                'id' => $ppks->id,
                'data' => $ppks,
                'comparison' => $comparison,
                'note' => $ppks->duplicate_note,
                'type' => $this->getDuplicateType(
                    $ppks->duplicate_note
                ),
            ]);
        }

        return view(
            'ppks.duplicates',
            compact('cases')
        );
    }


    /**
     * Menyimpan keputusan pemeriksaan admin.
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
        | Cari data pembanding
        |--------------------------------------------------------------------------
        */

        $comparison = $this->findComparison($ppks);


        /*
        |--------------------------------------------------------------------------
        | 1. PILIH DATA A
        |--------------------------------------------------------------------------
        */

        if ($decision === 'pilih_data_ini') {

            // Data A menjadi data normal dan siap asesmen
            $ppks->update([
                'status' => 'normal',
                'selected_for_assessment' => true,
                'selected_from_duplicate_id' =>
                    $comparison?->id,
                'duplicate_decision' =>
                    'pilih_data_ini',
            ]);

            // Pembanding menjadi duplikat
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

            return back()->with(
                'success',
                'Data A berhasil dipilih dan masuk ke Data Normal.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | 2. PILIH DATA PEMBANDING
        |--------------------------------------------------------------------------
        */

        if ($decision === 'pilih_data_pembanding') {

            if (!$comparison) {

                return back()->with(
                    'error',
                    'Data pembanding tidak ditemukan.'
                );
            }

            // Data pembanding menjadi data normal
            $comparison->update([
                'status' => 'normal',
                'selected_for_assessment' => true,
                'selected_from_duplicate_id' =>
                    $ppks->id,
                'duplicate_decision' =>
                    'pilih_data_pembanding',
            ]);

            // Data A menjadi duplikat
            $ppks->update([
                'status' => 'duplikat',
                'selected_for_assessment' => false,
                'selected_from_duplicate_id' =>
                    $comparison->id,
                'duplicate_decision' =>
                    'duplikat',
            ]);

            return back()->with(
                'success',
                'Data pembanding berhasil dipilih dan masuk ke Data Normal.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | 3. KEDUANYA BUKAN DUPLIKAT
        |--------------------------------------------------------------------------
        */

        if ($decision === 'bukan_duplikat') {

            /*
            |--------------------------------------------------------------------------
            | Data A valid
            |--------------------------------------------------------------------------
            */

            $ppks->update([
                'status' => 'normal',
                'selected_for_assessment' => true,
                'selected_from_duplicate_id' => null,
                'duplicate_decision' =>
                    'bukan_duplikat',
                'possible_duplicate_of' => null,
                'duplicate_note' => null,
            ]);


            /*
            |--------------------------------------------------------------------------
            | Data pembanding juga valid
            |--------------------------------------------------------------------------
            */

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

            return back()->with(
                'success',
                'Kedua data dinyatakan valid dan masuk ke Data Normal.'
            );
        }

        return back();
    }


    /**
     * Mencari data pembanding.
     */
    private function findComparison(
        Ppks $ppks,
        $collection = null
    ): ?Ppks {

        /*
        |--------------------------------------------------------------------------
        | Cara 1:
        | Data ini menunjuk ke pembanding
        |--------------------------------------------------------------------------
        */

        if (
            $ppks->possible_duplicate_of &&
            $ppks->possible_duplicate_of != $ppks->id
        ) {

            $comparison = $collection
                ? $collection->firstWhere(
                    'id',
                    $ppks->possible_duplicate_of
                )
                : null;

            if (!$comparison) {

                $comparison = Ppks::find(
                    $ppks->possible_duplicate_of
                );
            }

            if ($comparison) {
                return $comparison;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Cara 2:
        | Data lain menunjuk ke data ini
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


    /**
     * Menentukan jenis kemungkinan duplikat.
     */
    private function getDuplicateType(
        ?string $note
    ): string {

        if (!$note) {
            return 'Perlu diperiksa';
        }

        $note = strtolower($note);

        if (str_contains($note, 'nik berbeda')) {
            return 'NIK berbeda';
        }

        if (str_contains($note, 'nik sama')) {
            return 'NIK sama';
        }

        return 'Perlu diperiksa';
    }
}
