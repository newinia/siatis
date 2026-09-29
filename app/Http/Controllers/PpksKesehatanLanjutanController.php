<?php

namespace App\Http\Controllers;

use App\Models\Ppks;
use App\Models\KesehatanLanjutan;
use App\Models\User;
use App\Models\ProsesPeserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PpksKesehatanLanjutanController extends Controller
{
    /**
     * ============================================================
     * BELUM ASESMEN
     * ============================================================
     *
     * Peserta yang:
     * - status PPKS = normal
     * - Case Conference = diterima
     * - sudah datang
     * - belum memiliki data Kesehatan Lanjutan
     */
    public function index()
    {
        $ppks = Ppks::query()
            ->where('status', 'normal')

            ->whereIn('id', function ($query) {
                $query->select('ppks_id')
                    ->from('case_conferences')
                    ->where('hasil', 'diterima');
            })

            ->whereIn('id', function ($query) {
                $query->select('ppks_id')
                    ->from('pemanggilan_pesertas')
                    ->where('status_pemanggilan', 'sudah_datang');
            })

            ->whereNotIn('id', function ($query) {
                $query->select('ppks_id')
                    ->from('kesehatan_lanjutans');
            })

            ->with([
                'pemanggilanPeserta',
            ])

            ->get();

        $caseConferences = DB::table('case_conferences')
            ->where('hasil', 'diterima')
            ->get()
            ->keyBy('ppks_id');

        return view(
            'kesehatan-lanjutan.kesehatan-lanjutan-belum-asesmen',
            [
                'ppks' => $ppks,
                'caseConferences' => $caseConferences,
            ]
        );
    }


    /**
     * ============================================================
     * DATA LULUS
     * ============================================================
     */
    public function lulus()
    {
        $ppks = Ppks::query()
            ->where('status', 'normal')

            ->whereIn('id', function ($query) {
                $query->select('ppks_id')
                    ->from('case_conferences')
                    ->where('hasil', 'diterima');
            })

            ->whereIn('id', function ($query) {
                $query->select('ppks_id')
                    ->from('pemanggilan_pesertas')
                    ->where('status_pemanggilan', 'sudah_datang');
            })

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
            'kesehatan-lanjutan.kesehatan-lanjutan-lolos',
            [
                'ppks' => $ppks,
                'caseConferences' => $caseConferences,
            ]
        );
    }


    /**
     * ============================================================
     * DATA PENDING
     * ============================================================
     */
    public function pending()
    {
        $ppks = Ppks::query()
            ->where('status', 'normal')

            ->whereIn('id', function ($query) {
                $query->select('ppks_id')
                    ->from('case_conferences')
                    ->where('hasil', 'diterima');
            })

            ->whereIn('id', function ($query) {
                $query->select('ppks_id')
                    ->from('pemanggilan_pesertas')
                    ->where('status_pemanggilan', 'sudah_datang');
            })

            ->whereIn('id', function ($query) {
                $query->select('ppks_id')
                    ->from('kesehatan_lanjutans')
                    ->where('hasil_akhir', 'pending');
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
            'kesehatan-lanjutan.kesehatan-lanjutan-pending',
            [
                'ppks' => $ppks,
                'caseConferences' => $caseConferences,
            ]
        );
    }


    /**
     * ============================================================
     * DATA TIDAK LULUS
     * ============================================================
     */
    public function tidakLulus()
    {
        $ppks = Ppks::query()
            ->where('status', 'normal')

            ->whereIn('id', function ($query) {
                $query->select('ppks_id')
                    ->from('case_conferences')
                    ->where('hasil', 'diterima');
            })

            ->whereIn('id', function ($query) {
                $query->select('ppks_id')
                    ->from('pemanggilan_pesertas')
                    ->where('status_pemanggilan', 'sudah_datang');
            })

            ->whereIn('id', function ($query) {
                $query->select('ppks_id')
                    ->from('kesehatan_lanjutans')
                    ->where('hasil_akhir', 'tidak_lulus');
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
            'kesehatan-lanjutan.kesehatan-lanjutan-tidak-lolos',
            [
                'ppks' => $ppks,
                'caseConferences' => $caseConferences,
            ]
        );
    }


    /**
     * ============================================================
     * DETAIL KESEHATAN LANJUTAN
     * ============================================================
     */
    public function detail(Ppks $ppks)
    {
        /*
        |--------------------------------------------------------------------------
        | CEK PESERTA SUDAH DATANG
        |--------------------------------------------------------------------------
        */

        $pemanggilan = DB::table('pemanggilan_pesertas')
            ->where('ppks_id', $ppks->id)
            ->where('status_pemanggilan', 'sudah_datang')
            ->first();

        if (!$pemanggilan) {

            return redirect()
                ->route('ppks.normal.kesehatan-lanjutan')
                ->with(
                    'error',
                    'Peserta belum datang sehingga belum dapat mengikuti Kesehatan Lanjutan.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | CEK CASE CONFERENCE
        |--------------------------------------------------------------------------
        */

        $caseConference = DB::table('case_conferences')
            ->where('ppks_id', $ppks->id)
            ->where('hasil', 'diterima')
            ->first();

        if (!$caseConference) {

            return redirect()
                ->route('ppks.normal.kesehatan-lanjutan')
                ->with(
                    'error',
                    'Peserta belum diterima pada Case Conference.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | AMBIL DATA KESEHATAN LANJUTAN
        |--------------------------------------------------------------------------
        */

        $kesehatanLanjutan = KesehatanLanjutan::where(
            'ppks_id',
            $ppks->id
        )->first();


        /*
        |--------------------------------------------------------------------------
        | AMBIL PETUGAS MEDIS APPROVED
        |--------------------------------------------------------------------------
        */

        $petugas = User::query()
            ->whereIn('role', ['medis', 'super_admin'])
            ->where('status', 'approved')
            ->orderBy('name')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | DETAIL VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'kesehatan-lanjutan.asesmen-kesehatan-lanjutan-detail',
            [
                'ppks' => $ppks,
                'pemanggilan' => $pemanggilan,
                'caseConference' => $caseConference,
                'kesehatanLanjutan' => $kesehatanLanjutan,
                'petugas' => $petugas,
            ]
        );
    }


    /**
     * ============================================================
     * SIMPAN / UPDATE KESEHATAN LANJUTAN
     * ============================================================
     */
    public function update(Request $request, Ppks $ppks)
    {
        /*
        |--------------------------------------------------------------------------
        | CEK PESERTA SUDAH DATANG
        |--------------------------------------------------------------------------
        */

        $sudahDatang = DB::table('pemanggilan_pesertas')
            ->where('ppks_id', $ppks->id)
            ->where('status_pemanggilan', 'sudah_datang')
            ->exists();

        if (!$sudahDatang) {

            return back()
                ->with(
                    'error',
                    'Peserta belum datang sehingga data Kesehatan Lanjutan tidak dapat disimpan.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'tanggal_asesmen' => [
                'required',
                'date',
            ],

            'gelombang' => [
                'nullable',
                'string',
                'max:50',
            ],

            'tahun' => [
                'nullable',
                'integer',
                'min:2000',
                'max:2100',
            ],

            'petugas_kesehatan' => [
                'nullable',
                'string',
                'max:255',
            ],

            'hasil_asesmen' => [
                'nullable',
                'in:sudah,belum,proses',
            ],

            'status_asesmen_psikologi' => [
                'nullable',
                'in:sudah,belum,proses',
            ],

            'status_asesmen_fisioterapis' => [
                'nullable',
                'in:sudah,belum,proses',
            ],

            'catatan_asesmen' => [
                'nullable',
                'string',
            ],

            'hasil_akhir' => [
                'required',
                'in:lulus,tidak_lulus,pending',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | SIMPAN DATA
        |--------------------------------------------------------------------------
        |
        | Kesehatan Lanjutan dan proses_pesertas disimpan dalam
        | satu transaksi.
        |
        */

        DB::transaction(function () use ($validated, $ppks) {

            /*
            |--------------------------------------------------------------------------
            | SIMPAN / UPDATE KESEHATAN LANJUTAN
            |--------------------------------------------------------------------------
            */

            KesehatanLanjutan::updateOrCreate(

                [
                    'ppks_id' => $ppks->id,
                ],

                [
                    'tanggal_asesmen' =>
                        $validated['tanggal_asesmen'],

                    'gelombang' =>
                        $validated['gelombang'] ?? null,

                    'tahun' =>
                        $validated['tahun'] ?? null,

                    'petugas_kesehatan' =>
                        $validated['petugas_kesehatan'] ?? null,

                    'hasil_asesmen' =>
                        $validated['hasil_asesmen'] ?? null,

                    'status_asesmen_psikologi' =>
                        $validated['status_asesmen_psikologi'] ?? null,

                    'status_asesmen_fisioterapis' =>
                        $validated['status_asesmen_fisioterapis'] ?? null,

                    'catatan_asesmen' =>
                        $validated['catatan_asesmen'] ?? null,

                    'hasil_akhir' =>
                        $validated['hasil_akhir'],
                ]
            );


            /*
            |--------------------------------------------------------------------------
            | SINKRONKAN KE PROSES PESERTA
            |--------------------------------------------------------------------------
            */

            ProsesPeserta::updateOrCreate(

                [
                    'ppks_id' => $ppks->id,
                    'tahap' => 'kesehatan_lanjutan',
                ],

                [
                    'status' =>
                        $validated['hasil_akhir'],

                    'alasan_pending' =>
                        $validated['hasil_akhir'] === 'pending'
                            ? ($validated['catatan_asesmen'] ?? null)
                            : null,

                    'catatan' =>
                        $validated['catatan_asesmen'] ?? null,

                    'tanggal_panggil_kembali' => null,

                    'tanggal_proses' =>
                        $validated['tanggal_asesmen'],
                ]
            );
        });


        /*
        |--------------------------------------------------------------------------
        | KEMBALI KE DETAIL
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'ppks.normal.kesehatan-lanjutan.detail',
                $ppks
            )
            ->with(
                'success',
                'Data Kesehatan Lanjutan berhasil disimpan.'
            );
    }
}