<?php

namespace App\Http\Controllers;

use App\Models\Ppks;
use App\Models\ImportLog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PpksController extends Controller
{
    /**
     * Semua data PPKS
     */
    public function index(Request $request): View
    {
        $query = Ppks::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(
                'sheet_row',
                'like',
                "%{$search}%"
            );
        }

        if ($request->filled('status')) {
            $query->where(
                'status',
                $request->status
            );
        }

        $ppks = $query
            ->orderBy('sheet_row', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view(
            'ppks.index',
            compact('ppks')
        );
    }


    /**
     * Data PPKS Normal
     */
    public function normal(Request $request): View
    {
        $query = Ppks::query()
            ->where('status', 'normal');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(
                'sheet_row',
                'like',
                "%{$search}%"
            );
        }

        $ppks = $query
            ->orderBy('sheet_row', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view(
            'ppks.normal',
            compact('ppks')
        );
    }


    /**
     * Pilih data secara langsung
     * Pemeriksaan → Data Normal
     */
    public function pilih(Ppks $ppks)
    {
        $ppks->update([
            'status' => 'normal',
            'selected_for_assessment' => true,
        ]);

        return back()->with(
            'success',
            'Data berhasil dipindahkan ke Data Normal.'
        );
    }


    /**
     * Batalkan keputusan pemeriksaan
     *
     * Kondisi awal:
     * A = perlu_diperiksa
     * B = perlu_diperiksa
     *
     * Setelah memilih A:
     * A = normal
     * B = duplikat
     *
     * Setelah dikembalikan:
     * A = perlu_diperiksa
     * B = perlu_diperiksa
     *
     * possible_duplicate_of tetap dipertahankan.
     */
    public function kembalikan(Ppks $ppks)
    {
        // Cari pasangan yang sebelumnya terkait
        $comparison = null;

        if ($ppks->selected_from_duplicate_id) {
            $comparison = Ppks::find(
                $ppks->selected_from_duplicate_id
            );
        }

        // Kembalikan data yang dipilih
        $ppks->update([
            'status' => 'perlu_diperiksa',
            'selected_for_assessment' => false,
            'selected_from_duplicate_id' => null,
            'duplicate_decision' => null,
        ]);

        // Kembalikan pasangan
        if ($comparison) {
            $comparison->update([
                'status' => 'perlu_diperiksa',
                'selected_for_assessment' => false,
                'selected_from_duplicate_id' => null,
                'duplicate_decision' => null,
            ]);
        }

        // Jangan menghapus possible_duplicate_of
        // supaya pasangan tetap bisa ditemukan.

        return redirect()
            ->route('ppks.perlu-diperiksa')
            ->with(
                'success',
                'Keputusan dibatalkan. Data dikembalikan ke kondisi pemeriksaan sebelumnya.'
            );
    }
    /**
 * Halaman Import Data PPKS
 */
public function import(): View
{
    $totalImported = Ppks::count();

    $importLogs = ImportLog::query()
        ->orderBy('started_at', 'desc')
        ->get();

    return view(
        'ppks.import',
        compact(
            'totalImported',
            'importLogs'
        )
    );
}
}
