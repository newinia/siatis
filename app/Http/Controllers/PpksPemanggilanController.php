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
     * Filter:
     * - Search Nama / NIK
     * - Status Pemanggilan
     * - Gelombang
     * - Tahun
     */
    public function index(Request $request)
    {
        // =====================================================
        // AMBIL PARAMETER FILTER
        // =====================================================

        $search = trim((string) $request->input('search', ''));

        $status = trim((string) $request->input('status', ''));

        $gelombang = trim((string) $request->input('gelombang', ''));

        $tahun = trim((string) $request->input('tahun', ''));


        // =====================================================
        // QUERY PESERTA
        // =====================================================

        $query = Ppks::query()

            // Hanya data normal
            ->where('status', 'normal')

            // Hanya peserta yang Case Conference-nya diterima
            ->whereIn('id', function ($query) {
                $query->select('ppks_id')
                    ->from('case_conferences')
                    ->where('hasil', 'diterima');
            })

            // Relasi pemanggilan peserta
            ->with('pemanggilanPeserta');


        // =====================================================
        // FILTER SEARCH
        // NAMA / NIK
        // =====================================================

        if ($search !== '') {

            $query->where(function ($q) use ($search) {

                $searchLower = strtolower($search);

                $q->whereRaw(
                    "LOWER(JSON_UNQUOTE(JSON_EXTRACT(data, '$.nama_lengkap'))) LIKE ?",
                    ["%{$searchLower}%"]
                )

                ->orWhereRaw(
                    "JSON_UNQUOTE(JSON_EXTRACT(data, '$.nik')) LIKE ?",
                    ["%{$search}%"]
                );

            });
        }


        // =====================================================
        // FILTER STATUS PEMANGGILAN
        // =====================================================

        if ($status !== '') {

            $query->whereHas('pemanggilanPeserta', function ($q) use ($status) {

                $q->where(
                    'status_pemanggilan',
                    $status
                );

            });
        }


        // =====================================================
        // FILTER GELOMBANG
        //
        // Data gelombang berasal dari:
        // case_conferences.gelombang_pelatihan
        // =====================================================

        if ($gelombang !== '') {

            $query->whereIn('id', function ($q) use ($gelombang) {

                $q->select('ppks_id')
                    ->from('case_conferences')
                    ->where('hasil', 'diterima')
                    ->where(
                        'gelombang_pelatihan',
                        $gelombang
                    );

            });
        }


        // =====================================================
        // FILTER TAHUN
        //
        // Data tahun berasal dari:
        // case_conferences.tahun_pelatihan
        // =====================================================

        if ($tahun !== '') {

            $query->whereIn('id', function ($q) use ($tahun) {

                $q->select('ppks_id')
                    ->from('case_conferences')
                    ->where('hasil', 'diterima')
                    ->where(
                        'tahun_pelatihan',
                        $tahun
                    );

            });
        }


        // =====================================================
        // PAGINATION
        //
        // Filter sudah diterapkan SEBELUM pagination.
        // Jadi halaman 1, 2, 3 dst mengikuti hasil filter DB.
        // =====================================================

        $pesertas = $query
            ->orderBy('id', 'desc')
            ->paginate(15)
            ->withQueryString();


        // =====================================================
        // AMBIL DATA CASE CONFERENCE
        // UNTUK DATA JURUSAN / PEMINATAN
        // =====================================================

        $caseConferences = DB::table('case_conferences')
            ->where('hasil', 'diterima')
            ->get()
            ->keyBy('ppks_id');


        // =====================================================
        // DATA UNTUK OPTION GELOMBANG
        // =====================================================

        $gelombangOptions = DB::table('case_conferences')
            ->where('hasil', 'diterima')
            ->whereNotNull('gelombang_pelatihan')
            ->where('gelombang_pelatihan', '!=', '')
            ->select('gelombang_pelatihan')
            ->distinct()
            ->orderBy('gelombang_pelatihan')
            ->pluck('gelombang_pelatihan');


        // =====================================================
        // DATA UNTUK OPTION TAHUN
        // =====================================================

        $tahunOptions = DB::table('case_conferences')
            ->where('hasil', 'diterima')
            ->whereNotNull('tahun_pelatihan')
            ->where('tahun_pelatihan', '!=', '')
            ->select('tahun_pelatihan')
            ->distinct()
            ->orderBy('tahun_pelatihan')
            ->pluck('tahun_pelatihan');


        // =====================================================
        // KIRIM DATA KE BLADE
        // =====================================================

        return view(
            'pemanggilan.pemanggilan-peserta',
            compact(
                'pesertas',
                'caseConferences',
                'gelombangOptions',
                'tahunOptions'
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
        // Jika status:
        // - sudah_dipanggil
        // - belum_datang
        // - sudah_datang
        //
        // dan tanggal kosong, gunakan tanggal hari ini.
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