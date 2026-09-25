<?php

namespace App\Http\Controllers;

use App\Models\Ppks;
use Illuminate\Support\Facades\DB;

class PpksAktifController extends Controller
{
    public function index()
    {
        $ppks = Ppks::query()
            ->where('status', 'normal')
            ->whereIn('id', function ($query) {
                $query->select('ppks_id')
                    ->from('kesehatan_lanjutans')
                    ->where('hasil_akhir', 'lulus');
            })
            ->with([
                'kesehatanLanjutan',
                'pemanggilanPeserta',
            ])
            ->get();

        $caseConferences = DB::table('case_conferences')
            ->where('hasil', 'diterima')
            ->get()
            ->keyBy('ppks_id');

        return view(
            'peserta-aktif.peserta-aktif',
            [
                'ppks' => $ppks,
                'caseConferences' => $caseConferences,
            ]
        );
    }
}