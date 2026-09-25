<?php

namespace App\Http\Controllers;

use App\Models\Ppks;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class DocumentController extends Controller
{
    /**
     * ============================================================
     * PDF PEMANGGILAN PESERTA
     * ============================================================
     *
     * Menampilkan peserta yang:
     * - berstatus normal
     * - memiliki Case Conference
     * - hasil Case Conference = lulus
     *
     * Filter:
     * - Gelombang
     * - Tahun
     */
    public function pemanggilanPdf(Request $request)
    {
        $gelombang = $request->gelombang;
        $tahun = $request->tahun;

        $pesertas = Ppks::query()

            // ============================================================
            // HANYA PESERTA YANG LULUS CASE CONFERENCE
            // ============================================================
            ->whereHas('prosesPesertas', function ($query) {
                $query
                    ->where('tahap', 'case_conference')
                    ->where('status', 'lulus');
            })

            // ============================================================
            // AMBIL DATA CASE CONFERENCE TERBARU
            // ============================================================
            ->with([
                'prosesPesertas' => function ($query) {
                    $query
                        ->where('tahap', 'case_conference')
                        ->orderByDesc('tanggal_proses')
                        ->orderByDesc('created_at');
                },

                'pemanggilanPeserta',
            ])

            // ============================================================
            // FILTER GELOMBANG
            // SAMA SEPERTI CASE CONFERENCE
            // ============================================================
            ->when($gelombang, function ($query) use ($gelombang) {
                $query->where(
                    'data->gelombang_pelatihan',
                    $gelombang
                );
            })

            // ============================================================
            // FILTER TAHUN
            // SAMA SEPERTI CASE CONFERENCE
            // ============================================================
            ->when($tahun, function ($query) use ($tahun) {
                $query->where(
                    'data->tahun_pelatihan',
                    $tahun
                );
            })

            ->orderByDesc('id')
            ->get();

        // ============================================================
        // GENERATE PDF
        // ============================================================
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
            'pemanggilan.pemanggilan-pdf',
            compact(
                'pesertas',
                'gelombang',
                'tahun'
            )
        );

        // ============================================================
        // A4 PORTRAIT
        // ============================================================
        $pdf->setPaper('a4', 'portrait');

        return $pdf->stream(
            'Daftar-Peserta-Pemanggilan.pdf'
        );
    }
}
