<?php

namespace App\Http\Controllers;

use App\Models\Ppks;
use App\Models\PemanggilanPeserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PpksPemanggilanController extends Controller
{
    /**
     * =========================================================
     * MENAMPILKAN HALAMAN PEMANGGILAN PESERTA
     * =========================================================
     *
     * Peserta yang ditampilkan:
     * - Data PPKS normal
     * - Sudah diterima Case Conference
     *
     * Status pemanggilan diambil dari tabel
     * pemanggilan_pesertas.
     */
    public function index()
    {
        // =====================================================
        // AMBIL PESERTA YANG DITERIMA CASE CONFERENCE
        // =====================================================

        $pesertas = Ppks::query()
            ->where('status', 'normal')

            ->whereIn('id', function ($query) {
                $query->select('ppks_id')
                    ->from('case_conferences')
                    ->where('hasil', 'diterima');
            })

            ->with('pemanggilanPeserta')

            ->get();


        // =====================================================
        // AMBIL DATA CASE CONFERENCE
        // UNTUK DATA JURUSAN / PEMINATAN
        // =====================================================

        $caseConferences = DB::table('case_conferences')
            ->where('hasil', 'diterima')
            ->get()
            ->keyBy('ppks_id');


        // =====================================================
        // KIRIM DATA KE BLADE
        // =====================================================

        return view(
            'pemanggilan-peserta',
            compact(
                'pesertas',
                'caseConferences'
            )
        );
    }


    /**
     * =========================================================
     * MENYIMPAN / MENGUBAH DATA PEMANGGILAN
     * =========================================================
     */
    public function update(Request $request, Ppks $ppks)
    {
        // =====================================================
        // VALIDASI
        // =====================================================

        $validated = $request->validate([
            'status_pemanggilan' => [
                'required',
                'in:belum_dipanggil,sudah_dipanggil,belum_datang,sudah_datang',
            ],

            'tanggal_pemanggilan' => [
                'nullable',
                'date',
            ],

            'tanggal_kedatangan' => [
                'nullable',
                'date',
            ],
        ]);


        // =====================================================
        // PASTIKAN DATA ADALAH PPKS NORMAL
        // =====================================================

        if ($ppks->status !== 'normal') {
            return back()->with(
                'error',
                'Data peserta tidak dapat diproses melalui Pemanggilan Peserta.'
            );
        }


        // =====================================================
        // CEK CASE CONFERENCE
        // HARUS SUDAH DITERIMA
        // =====================================================

        $caseConference = DB::table('case_conferences')
            ->where('ppks_id', $ppks->id)
            ->where('hasil', 'diterima')
            ->first();


        if (!$caseConference) {
            return back()->with(
                'error',
                'Peserta belum diterima pada Case Conference.'
            );
        }


        // =====================================================
        // AMBIL DATA PEMANGGILAN SEBELUMNYA
        // =====================================================

        $pemanggilan = $ppks->pemanggilanPeserta;


        // =====================================================
        // PESERTA TIDAK BOLEH KEMBALI KE
        // BELUM DIPANGGIL SETELAH SUDAH PERNAH DIPANGGIL
        // =====================================================

        if (
            $pemanggilan &&
            in_array(
                $pemanggilan->status_pemanggilan,
                [
                    'sudah_dipanggil',
                    'belum_datang',
                    'sudah_datang',
                ]
            ) &&
            $validated['status_pemanggilan'] === 'belum_dipanggil'
        ) {
            return back()->with(
                'error',
                'Peserta yang sudah pernah dipanggil tidak dapat dikembalikan menjadi Belum Dipanggil.'
            );
        }


        // =====================================================
        // TANGGAL KEDATANGAN
        //
        // Hanya boleh ada ketika status = sudah_datang
        // =====================================================

        if (
            $validated['status_pemanggilan'] !== 'sudah_datang'
        ) {
            $validated['tanggal_kedatangan'] = null;
        }


        // =====================================================
        // TANGGAL PEMANGGILAN OTOMATIS
        //
        // Jika status sudah dipanggil / belum datang /
        // sudah datang dan tanggal kosong,
        // gunakan tanggal hari ini.
        // =====================================================

        if (
            in_array(
                $validated['status_pemanggilan'],
                [
                    'sudah_dipanggil',
                    'belum_datang',
                    'sudah_datang',
                ]
            ) &&
            empty($validated['tanggal_pemanggilan'])
        ) {
            $validated['tanggal_pemanggilan'] =
                now()->format('Y-m-d');
        }


        // =====================================================
        // SIMPAN / UPDATE DATA PEMANGGILAN
        // =====================================================

        PemanggilanPeserta::updateOrCreate(
            [
                'ppks_id' => $ppks->id,
            ],
            [
                'status_pemanggilan' =>
                    $validated['status_pemanggilan'],

                'tanggal_pemanggilan' =>
                    $validated['tanggal_pemanggilan'] ?? null,

                'tanggal_kedatangan' =>
                    $validated['tanggal_kedatangan'] ?? null,
            ]
        );


        // =====================================================
        // KEMBALI KE HALAMAN PEMANGGILAN
        // =====================================================

        return back()->with(
            'success',
            'Data pemanggilan peserta berhasil diperbarui.'
        );
    }
}