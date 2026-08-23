<?php

namespace App\Http\Controllers;

use App\Models\Ppks;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PpksDuplicateController extends Controller
{
    public function index(): View
    {
        $allDuplicates = Ppks::where(
            'status',
            'perlu_diperiksa'
        )
            ->orderBy('id')
            ->get();

        $processed = [];
        $cases = collect();

        foreach ($allDuplicates as $ppks) {

            /*
            |--------------------------------------------------------------------------
            | Jangan tampilkan data yang sudah menjadi bagian kasus sebelumnya
            |--------------------------------------------------------------------------
            */

            if (in_array($ppks->id, $processed)) {
                continue;
            }

            $comparison = null;

            /*
            |--------------------------------------------------------------------------
            | 1. Cari berdasarkan possible_duplicate_of
            |--------------------------------------------------------------------------
            */

            if (
                $ppks->possible_duplicate_of &&
                $ppks->possible_duplicate_of != $ppks->id
            ) {

                $comparison = $allDuplicates->firstWhere(
                    'id',
                    $ppks->possible_duplicate_of
                );

                if (!$comparison) {
                    $comparison = Ppks::find(
                        $ppks->possible_duplicate_of
                    );
                }
            }

            /*
            |--------------------------------------------------------------------------
            | 2. Kalau tidak punya pembanding,
            |    cari data lain yang menunjuk ke data ini
            |--------------------------------------------------------------------------
            */

            if (!$comparison) {

                $comparison = $allDuplicates->first(
                    function ($item) use ($ppks) {

                        return
                            $item->id != $ppks->id &&
                            $item->possible_duplicate_of == $ppks->id;
                    }
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Tandai kedua data sebagai sudah diproses
            |--------------------------------------------------------------------------
            */

            $processed[] = $ppks->id;

            if ($comparison) {
                $processed[] = $comparison->id;
            }

            /*
            |--------------------------------------------------------------------------
            | Buat satu kasus pemeriksaan
            |--------------------------------------------------------------------------
            */

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
     * Menyimpan keputusan admin.
     */
    public function decide(
        Request $request,
        Ppks $ppks
    ) {
        $request->validate([
            'decision' => [
                'required',
                'in:bukan_duplikat,duplikat',
            ],
        ]);

        $decision = $request->decision;


        /*
        |--------------------------------------------------------------------------
        | BUKAN DUPLIKAT
        |--------------------------------------------------------------------------
        */

        if ($decision === 'bukan_duplikat') {

            $ppks->update([
                'status' => 'normal',
                'duplicate_decision' => 'bukan_duplikat',
                'possible_duplicate_of' => null,
                'duplicate_note' => null,
            ]);

            return back()->with(
                'success',
                'Kasus ditandai sebagai bukan duplikat.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | DUPLIKAT
        |--------------------------------------------------------------------------
        */

        $ppks->update([
            'status' => 'duplikat',
            'duplicate_decision' => 'duplikat',
        ]);

        return back()->with(
            'success',
            'Data ditandai sebagai duplikat.'
        );
    }


    /**
     * Menentukan jenis kemungkinan duplikat.
     */
    private function getDuplicateType(?string $note): string
    {
        if (!$note) {
            return 'Perlu diperiksa';
        }

        if (
            str_contains(
                strtolower($note),
                'nik berbeda'
            )
        ) {
            return 'NIK berbeda';
        }

        if (
            str_contains(
                strtolower($note),
                'nik sama'
            )
        ) {
            return 'NIK sama';
        }

        return 'Perlu diperiksa';
    }
}
