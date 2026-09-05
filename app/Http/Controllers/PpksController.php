<?php

namespace App\Http\Controllers;

use App\Models\Ppks;
use App\Models\ProsesPeserta;
use App\Models\ImportLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PpksController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ROLE HELPER
    |--------------------------------------------------------------------------
    */

    private function currentRole(): string
    {
        return strtolower(
            trim(
                (string) auth()->user()?->role
            )
        );
    }

    private function ensureRole(string ...$roles): void
    {
        $role = $this->currentRole();

        // Super admin selalu boleh mengakses
        if ($role === 'super_admin') {
            return;
        }

        $roles = array_map(
            fn ($item) => strtolower(trim($item)),
            $roles
        );

        if (!in_array($role, $roles, true)) {
            abort(
                403,
                'Anda tidak memiliki akses untuk melakukan tindakan ini.'
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | SEMUA DATA PPKS
    |--------------------------------------------------------------------------
    */

    public function index(Request $request): View
    {
        $query = Ppks::query();

        $this->applySearch($query, $request);

        if ($request->filled('status')) {
            $query->where(
                'status',
                $request->status
            );
        }

        $ppks = $this->applyPpksSorting($query)
            ->paginate(15)
            ->withQueryString();

        return view(
            'ppks.index',
            compact('ppks')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | RECHECK
    |--------------------------------------------------------------------------
    */

    public function recheck()
    {
        return redirect()
            ->route('ppks.import')
            ->with(
                'success',
                'Pengecekan ulang data berhasil.'
            );
    }
/*
|--------------------------------------------------------------------------
| DATA NORMAL
|--------------------------------------------------------------------------
*/

public function normal(Request $request): View
{
    $query = Ppks::query()
        ->where('status', 'normal')
        ->with([
            'prosesPesertas' => function ($query) {
                $query
                    ->orderByDesc('tanggal_proses')
                    ->orderByDesc('created_at');
            }
        ]);

    $this->applySearch($query, $request);

    $ppks = $query
        ->orderByRaw('COALESCE(imported_at, created_at) DESC')
        ->orderByDesc('sheet_row')
        ->orderByDesc('created_at')
        ->paginate(15)
        ->withQueryString();

    return view(
        'ppks.normal',
        compact('ppks')
    );
}


/*
|--------------------------------------------------------------------------
| DATA NORMAL RECORD
|--------------------------------------------------------------------------
*/

public function normalRecord(Request $request): View
{
    return $this->manual($request);
}


/*
|--------------------------------------------------------------------------
| DETAIL DATA NORMAL
|--------------------------------------------------------------------------
*/

public function normalDetail(Ppks $ppks): View
{
    $ppks->load([
        'prosesPesertas' => function ($q) {
            $q
                ->orderByDesc('tanggal_proses')
                ->orderByDesc('created_at');
        }
    ]);

    return view(
        'ppks.normal-detail',
        compact('ppks')
    );
}

    /*
    |--------------------------------------------------------------------------
    | BELUM DIMULAI
    |--------------------------------------------------------------------------
    */

    public function belumDimulai(Request $request): View
    {
        $query = Ppks::query()
            ->where('status', 'normal')
            ->whereDoesntHave('prosesPesertas')
            ->with([
                'prosesPesertas' => function ($q) {
                    $q
                        ->orderByDesc('tanggal_proses')
                        ->orderByDesc('created_at');
                }
            ]);

        $this->applySearch($query, $request);

        $ppks = $this->applyPpksSorting($query)
            ->paginate(15)
            ->withQueryString();

        $tahap = 'belum_dimulai';

        return view(
            'ppks.normal',
            compact('ppks', 'tahap')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ASESMEN INSTRUKTUR - BELUM ASESMEN
    |--------------------------------------------------------------------------
    */

    public function asesmenInstruktur(Request $request): View
    {
        $query = Ppks::query()
            ->where('status', 'normal')
            ->whereDoesntHave(
                'prosesPesertas',
                function ($q) {
                    $q
                        ->where('tahap', 'instruktur')
                        ->whereIn(
                            'status',
                            [
                                'lulus',
                                'pending',
                                'tidak_lulus',
                                'sedang_diperiksa',
                            ]
                        );
                }
            )
            ->with([
                'prosesPesertas' => function ($q) {
                    $q
                        ->where('tahap', 'instruktur')
                        ->orderByDesc('tanggal_proses')
                        ->orderByDesc('created_at');
                }
            ]);

        $this->applySearch($query, $request);

        $ppks = $this->applyPpksSorting($query)
            ->paginate(15)
            ->withQueryString();

        $tahap = 'instruktur';

        return view(
            'asesmen-instruktur.data-asesmen',
            compact('ppks', 'tahap')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ASESMEN INSTRUKTUR - LULUS
    |--------------------------------------------------------------------------
    */

    public function asesmenInstrukturLulus(Request $request): View
    {
        return $this->asesmenInstrukturByHasil(
            $request,
            'lulus',
            'asesmen-instruktur.data-lulus'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ASESMEN INSTRUKTUR - PENDING
    |--------------------------------------------------------------------------
    */

    public function asesmenInstrukturPending(Request $request): View
    {
        return $this->asesmenInstrukturByHasil(
            $request,
            'pending',
            'asesmen-instruktur.data-pending'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ASESMEN INSTRUKTUR - TIDAK LULUS
    |--------------------------------------------------------------------------
    */

    public function asesmenInstrukturTidakLulus(Request $request): View
    {
        return $this->asesmenInstrukturByHasil(
            $request,
            'tidak_lulus',
            'asesmen-instruktur.data-tidak-lulus'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | HELPER DATA HASIL INSTRUKTUR
    |--------------------------------------------------------------------------
    */

    private function asesmenInstrukturByHasil(
        Request $request,
        string $hasil,
        string $view
    ): View {
        $query = Ppks::query()
            ->where('status', 'normal')
            ->whereHas(
                'prosesPesertas',
                function ($q) use ($hasil) {
                    $q
                        ->where('tahap', 'instruktur')
                        ->where('status', $hasil);
                }
            )
            ->with([
                'prosesPesertas' => function ($q) {
                    $q
                        ->where('tahap', 'instruktur')
                        ->orderByDesc('tanggal_proses')
                        ->orderByDesc('created_at');
                }
            ]);

        $this->applySearch($query, $request);

        $ppks = $this->applyPpksSorting($query)
            ->paginate(15)
            ->withQueryString();

        $tahap = 'instruktur';

        return view(
            $view,
            compact(
                'ppks',
                'tahap',
                'hasil'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DETAIL DATA ASESMEN INSTRUKTUR
    |--------------------------------------------------------------------------
    */

    public function asesmenInstrukturDataDetail(
        Ppks $ppks
    ): View {
        $ppks->load([
            'prosesPesertas' => function ($q) {
                $q
                    ->where('tahap', 'instruktur')
                    ->orderByDesc('tanggal_proses')
                    ->orderByDesc('created_at');
            }
        ]);

        return view(
            'asesmen-instruktur.data-detail',
            compact('ppks')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | FORM ASESMEN INSTRUKTUR
    |--------------------------------------------------------------------------
    */

    public function asesmenInstrukturDetail(
        Ppks $ppks
    ): View {
        $ppks->load([
            'prosesPesertas' => function ($q) {
                $q
                    ->where('tahap', 'instruktur')
                    ->orderByDesc('tanggal_proses')
                    ->orderByDesc('created_at');
            }
        ]);

        $lulusInstruktur = ProsesPeserta::query()
            ->where('ppks_id', $ppks->id)
            ->where('tahap', 'instruktur')
            ->where('status', 'lulus')
            ->exists();



        $petugas = User::query()
            ->where('role', 'instruktur')
            ->where('status', 'approved')
            ->orderBy('name', 'asc')
            ->get();

        return view(
            'asesmen-instruktur.asesmen-instruktur-detail',
            compact(
                'ppks',
                'petugas',
                'lulusInstruktur'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SIMPAN ASESMEN INSTRUKTUR
    |--------------------------------------------------------------------------
    */

    public function simpanAsesmenInstruktur(
        Request $request,
        Ppks $ppks
    ) {
        $this->ensureRole('instruktur');

        $validated = $request->validate([
            'status_asesmen' => [
                'required',
                'string',
            ],

            'baznas' => [
                'nullable',
                'string',
            ],

            'gelombang' => [
                'nullable',
                'string',
            ],

            'tahun' => [
                'nullable',
                'string',
            ],

            'tanggal_asesmen_daring' => [
                'nullable',
                'date',
            ],

            'petugas_asesmen_instruktur' => [
                'required',
                'exists:users,id',
            ],

            'hasil_asesmen_instruktur' => [
                'required',
                'in:direkomendasikan,perlu_ditinjau,tidak_direkomendasikan',
            ],

            'catatan_asesmen_instruktur' => [
                'nullable',
                'string',
            ],

            'lokasi_asesmen_luring' => [
                'nullable',
                'string',
            ],

            'tanggal_asesmen_luring' => [
                'nullable',
                'date',
            ],

            'petugas_asesmen_luring' => [
                'nullable',
                'exists:users,id',
            ],

            'hasil_asesmen_luring' => [
                'nullable',
                'string',
            ],

            'catatan_asesmen_luring' => [
                'nullable',
                'string',
            ],
        ]);

        if ($ppks->status !== 'normal') {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Data PPKS tidak dapat diproses karena statusnya bukan normal.'
                );
        }

        $hasil = strtolower(
            trim(
                $validated['hasil_asesmen_instruktur']
            )
        );

        $statusProses = match ($hasil) {
            'direkomendasikan' => 'lulus',
            'tidak_direkomendasikan' => 'tidak_lulus',
            default => 'pending',
        };

        DB::transaction(function () use (
            $ppks,
            $validated,
            $statusProses
        ) {
            $data = $ppks->data ?? [];

            if (!is_array($data)) {
                $data = json_decode(
                    $data,
                    true
                ) ?? [];
            }

            $data['status_asesmen'] =
                $validated['status_asesmen'];

            $data['baznas'] =
                $validated['baznas'] ?? null;

            $data['gelombang'] =
                $validated['gelombang'] ?? null;

            $data['tahun'] =
                $validated['tahun'] ?? null;

            $data['tanggal_asesmen_daring'] =
                $validated['tanggal_asesmen_daring'] ?? null;

            $data['petugas_asesmen_instruktur'] =
                $validated['petugas_asesmen_instruktur'];

            $data['hasil_asesmen_instruktur'] =
                $validated['hasil_asesmen_instruktur'];

            $data['catatan_asesmen_instruktur'] =
                $validated['catatan_asesmen_instruktur'] ?? null;

            $data['lokasi_asesmen_luring'] =
                $validated['lokasi_asesmen_luring'] ?? null;

            $data['tanggal_asesmen_luring'] =
                $validated['tanggal_asesmen_luring'] ?? null;

            $data['petugas_asesmen_luring'] =
                $validated['petugas_asesmen_luring'] ?? null;

            $data['hasil_asesmen_luring'] =
                $validated['hasil_asesmen_luring'] ?? null;

            $data['catatan_asesmen_luring'] =
                $validated['catatan_asesmen_luring'] ?? null;

            $data['asesmen_instruktur_diubah_pada'] =
                now()->format('Y-m-d H:i:s');

            $data['asesmen_instruktur_diubah_oleh_id'] =
                auth()->id();

            $data['asesmen_instruktur_diubah_oleh'] =
                auth()->user()?->name;

            $ppks->update([
                'data' => $data,
                'status' => 'normal',
            ]);

            $tanggalProses =
                $validated['tanggal_asesmen_daring']
                ??
                $validated['tanggal_asesmen_luring']
                ??
                now();

            $proses = ProsesPeserta::query()
                ->where('ppks_id', $ppks->id)
                ->where('tahap', 'instruktur')
                ->first();

            if (!$proses) {
                $proses = new ProsesPeserta();

                $proses->ppks_id =
                    $ppks->id;

                $proses->tahap =
                    'instruktur';
            }

            $proses->status =
                $statusProses;

            $proses->tanggal_proses =
                $tanggalProses;

            $proses->catatan =
                $validated['catatan_asesmen_instruktur']
                ?? null;

            $proses->save();

            if ($statusProses === 'lulus') {
                $prosesKesehatan = ProsesPeserta::query()
                    ->where('ppks_id', $ppks->id)
                    ->where('tahap', 'kesehatan_awal')
                    ->first();

                if (!$prosesKesehatan) {
                    ProsesPeserta::create([
                        'ppks_id' =>
                            $ppks->id,

                        'tahap' =>
                            'kesehatan_awal',

                        'status' =>
                            'belum',

                        'tanggal_proses' =>
                            null,

                        'catatan' =>
                            null,
                    ]);
                }
            }
        });

        if ($statusProses === 'lulus') {
            return redirect()
                ->route(
                    'ppks.normal.asesmen-instruktur.lulus'
                )
                ->with(
                    'success',
                    'Data Asesmen Instruktur berhasil disimpan. Peserta sekarang LULUS dan dapat melanjutkan ke Asesmen Kesehatan Awal.'
                );
        }

        if ($statusProses === 'pending') {
            return redirect()
                ->route(
                    'ppks.normal.asesmen-instruktur.pending'
                )
                ->with(
                    'success',
                    'Data Asesmen Instruktur berhasil disimpan. Peserta sekarang berstatus PENDING.'
                );
        }

        return redirect()
            ->route(
                'ppks.normal.asesmen-instruktur.tidak-lulus'
            )
            ->with(
                'success',
                'Data Asesmen Instruktur berhasil disimpan. Peserta sekarang berstatus TIDAK LULUS.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | ASESMEN KESEHATAN AWAL - BELUM ASESMEN
    |--------------------------------------------------------------------------
    */

    public function asesmenKesehatan(
        Request $request
    ): View {
        $query = Ppks::query()
            ->where('status', 'normal')
            ->whereHas(
                'prosesPesertas',
                function ($q) {
                    $q
                        ->where('tahap', 'instruktur')
                        ->where('status', 'lulus');
                }
            )
            ->whereHas(
                'prosesPesertas',
                function ($q) {
                    $q
                        ->where('tahap', 'kesehatan_awal')
                        ->where('status', 'belum');
                }
            )
            ->with([
                'prosesPesertas' => function ($q) {
                    $q
                        ->whereIn(
                            'tahap',
                            [
                                'instruktur',
                                'kesehatan_awal',
                            ]
                        )
                        ->orderByDesc('tanggal_proses')
                        ->orderByDesc('created_at');
                }
            ]);

        $this->applySearch($query, $request);

        $this->applyHasilFilter(
            $query,
            $request,
            'kesehatan_awal'
        );

        $ppks = $this->applyPpksSorting($query)
            ->paginate(15)
            ->withQueryString();

        $tahap = 'kesehatan_awal';

        return view(
            'asesmen-kesehatan.kesehatan-awal-belum-asesmen',
            compact(
                'ppks',
                'tahap'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | KESEHATAN AWAL - LULUS
    |--------------------------------------------------------------------------
    */

    public function asesmenKesehatanLulus(
        Request $request
    ): View {
        return $this->asesmenKesehatanByHasil(
            $request,
            'lulus',
            'asesmen-kesehatan.kesehatan-awal-lolos'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | KESEHATAN AWAL - PENDING
    |--------------------------------------------------------------------------
    */

    public function asesmenKesehatanPending(
        Request $request
    ): View {
        return $this->asesmenKesehatanByHasil(
            $request,
            'pending',
            'asesmen-kesehatan.kesehatan-awal-pending'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | KESEHATAN AWAL - TIDAK LULUS
    |--------------------------------------------------------------------------
    */

    public function asesmenKesehatanTidakLulus(
        Request $request
    ): View {
        return $this->asesmenKesehatanByHasil(
            $request,
            'tidak_lulus',
            'asesmen-kesehatan.kesehatan-awal-tidak-lolos'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DETAIL FORM KESEHATAN AWAL
    |--------------------------------------------------------------------------
    */
public function asesmenKesehatanAwalDetail(
    Ppks $ppks
    ): View {

    /*
    |--------------------------------------------------------------------------
    | CEK INSTRUKTUR
    |--------------------------------------------------------------------------
    | Peserta harus pernah lulus Asesmen Instruktur.
    | Tidak lagi mengecek status PPKS harus "normal",
    | karena halaman ini juga dipakai untuk melihat riwayat
    | setelah peserta masuk Case Conference.
    |--------------------------------------------------------------------------
    */

$lulusInstruktur = ProsesPeserta::query()
    ->where('ppks_id', $ppks->id)
    ->where('tahap', 'instruktur')
    ->where('status', 'lulus')
    ->exists();
$lulusKesehatanAwal = ProsesPeserta::query()
    ->where('ppks_id', $ppks->id)
    ->where('tahap', 'kesehatan_awal')
    ->where('status', 'lulus')
    ->exists();


    /*
    |--------------------------------------------------------------------------
    | AMBIL ASESMEN KESEHATAN AWAL
    |--------------------------------------------------------------------------
    */

    $kesehatanAwal = $ppks
        ->prosesPesertas()
        ->where('tahap', 'kesehatan_awal')
        ->orderByDesc('tanggal_proses')
        ->orderByDesc('created_at')
        ->first();


    /*
    |--------------------------------------------------------------------------
    | JIKA BELUM ADA DATA KESEHATAN AWAL
    |--------------------------------------------------------------------------
    | Jangan langsung 403.
    |--------------------------------------------------------------------------
    */

    if (!$kesehatanAwal) {
        abort(
            404,
            'Data Asesmen Kesehatan Awal tidak ditemukan.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DATA PPKS
    |--------------------------------------------------------------------------
    */

    $data = $ppks->data ?? [];

    if (!is_array($data)) {
        $data = json_decode(
            $data,
            true
        ) ?? [];
    }


    /*
    |--------------------------------------------------------------------------
    | DATA ASESMEN DARING
    |--------------------------------------------------------------------------
    */

    $tanggalDaring =
        $data['tanggal_daring']
        ??
        $data['tanggal_asesmen_daring']
        ??
        null;

    $gelombang =
        $data['gelombang']
        ??
        null;

    $tahunValue =
        $data['tahun']
        ??
        null;

    $petugasKesehatan =
        $data['petugas_kesehatan']
        ??
        null;

    $hasilAsesmenKesehatan =
        $data['hasil_asesmen_kesehatan']
        ??
        null;

    $catatanAsesmenKesehatan =
        $data['catatan_asesmen_kesehatan']
        ??
        null;


    /*
    |--------------------------------------------------------------------------
    | DATA ASESMEN LURING
    |--------------------------------------------------------------------------
    */

    $asesmenLuring =
        (bool) (
            $data['asesmen_luring']
            ??
            false
        );

    $lokasiAsesmenLuring =
        $data['lokasi_asesmen_luring']
        ??
        null;

    $tanggalAsesmenLuring =
        $data['tanggal_asesmen_luring']
        ??
        null;

    $petugasAsesmenLuring =
        $data['petugas_asesmen_luring']
        ??
        null;

    $hasilAsesmenLuring =
        $data['hasil_asesmen_luring']
        ??
        null;

    $catatanAsesmenLuring =
        $data['catatan_asesmen_luring']
        ??
        null;


    /*
    |--------------------------------------------------------------------------
    | LOAD RIWAYAT PROSES
    |--------------------------------------------------------------------------
    */

    $ppks->load([
        'prosesPesertas' => function ($q) {
            $q
                ->whereIn(
                    'tahap',
                    [
                        'instruktur',
                        'kesehatan_awal',
                    ]
                )
                ->orderByDesc('tanggal_proses')
                ->orderByDesc('created_at');
        }
    ]);


    /*
    |--------------------------------------------------------------------------
    | PETUGAS MEDIS
    |--------------------------------------------------------------------------
    */

    $petugas = User::query()
        ->where('role', 'medis')
        ->where('status', 'approved')
        ->orderBy('name', 'asc')
        ->get();


    /*
    |--------------------------------------------------------------------------
    | VIEW
    |--------------------------------------------------------------------------
    */

    return view(
        'asesmen-kesehatan.asesmen-kesehatan-awal-detail',
        compact(
            'ppks',
            'kesehatanAwal',
            'tanggalDaring',
            'gelombang',
            'tahunValue',
            'petugasKesehatan',
            'hasilAsesmenKesehatan',
            'catatanAsesmenKesehatan',
            'asesmenLuring',
            'lokasiAsesmenLuring',
            'tanggalAsesmenLuring',
            'petugasAsesmenLuring',
            'hasilAsesmenLuring',
            'catatanAsesmenLuring',
            'petugas',
            'lulusKesehatanAwal'
        )
    );
}


    /*
    |--------------------------------------------------------------------------
    | DETAIL KESEHATAN LANJUTAN
    |--------------------------------------------------------------------------
    */

    public function asesmenKesehatanLanjutanDetail(
        Ppks $ppks
    ): View {
        $prosesKesehatan = $ppks
            ->prosesPesertas()
            ->where('tahap', 'kesehatan_awal')
            ->orderByDesc('tanggal_proses')
            ->orderByDesc('created_at')
            ->first();

        if (
            !$prosesKesehatan
            ||
            $prosesKesehatan->status !== 'lulus'
        ) {
            return redirect()
                ->route(
                    'ppks.normal.asesmen-kesehatan.lulus'
                )
                ->with(
                    'error',
                    'Peserta belum dinyatakan Lulus Asesmen Kesehatan Awal.'
                );
        }

        $data = $ppks->data ?? [];

        if (!is_array($data)) {
            $data = json_decode(
                $data,
                true
            ) ?? [];
        }

        return view(
            'asesmen-kesehatan.asesmen-kesehatan-lanjutan-detail',
            compact(
                'ppks',
                'data',
                'prosesKesehatan'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DETAIL HASIL KESEHATAN AWAL
    |--------------------------------------------------------------------------
    */

    private function detailAsesmenKesehatanByStatus(
        Ppks $ppks,
        string $status,
        string $routeName,
        string $message
    ) {
        if ($ppks->status !== 'normal') {
            return redirect()
                ->route($routeName)
                ->with(
                    'error',
                    'Data PPKS tidak dapat dibuka karena statusnya bukan normal.'
                );
        }

        $lulusInstruktur = $ppks
            ->prosesPesertas()
            ->where('tahap', 'instruktur')
            ->where('status', 'lulus')
            ->exists();

        if (!$lulusInstruktur) {
            return redirect()
                ->route($routeName)
                ->with(
                    'error',
                    'Peserta belum lulus Asesmen Instruktur.'
                );
        }

        $kesehatanAwal = $ppks
            ->prosesPesertas()
            ->where('tahap', 'kesehatan_awal')
            ->orderByDesc('tanggal_proses')
            ->orderByDesc('created_at')
            ->first();

        if (
            !$kesehatanAwal
            ||
            $kesehatanAwal->status !== $status
        ) {
            return redirect()
                ->route($routeName)
                ->with(
                    'error',
                    $message
                );
        }

        $data = $ppks->data ?? [];

        if (!is_array($data)) {
            $data = json_decode(
                $data,
                true
            ) ?? [];
        }

        $tanggalDaring =
            $data['tanggal_daring']
            ??
            $data['tanggal_asesmen_daring']
            ??
            null;

        $gelombang =
            $data['gelombang']
            ??
            null;

        $tahunValue =
            $data['tahun']
            ??
            null;

        $petugasKesehatan =
            $data['petugas_kesehatan']
            ??
            null;

        $hasilAsesmenKesehatan =
            $data['hasil_asesmen_kesehatan']
            ??
            $kesehatanAwal->status
            ??
            null;

        $catatanAsesmenKesehatan =
            $data['catatan_asesmen_kesehatan']
            ??
            $kesehatanAwal->catatan
            ??
            null;

        $asesmenLuring =
            (bool) (
                $data['asesmen_luring']
                ??
                false
            );

        $lokasiAsesmenLuring =
            $data['lokasi_asesmen_luring']
            ??
            null;

        $tanggalAsesmenLuring =
            $data['tanggal_asesmen_luring']
            ??
            null;

        $petugasAsesmenLuring =
            $data['petugas_asesmen_luring']
            ??
            null;

        $hasilAsesmenLuring =
            $data['hasil_asesmen_luring']
            ??
            null;

        $catatanAsesmenLuring =
            $data['catatan_asesmen_luring']
            ??
            null;

        $ppks->load([
            'prosesPesertas' => function ($q) {
                $q
                    ->whereIn(
                        'tahap',
                        [
                            'instruktur',
                            'kesehatan_awal',
                        ]
                    )
                    ->orderByDesc('tanggal_proses')
                    ->orderByDesc('created_at');
            }
        ]);

        $petugas = User::query()
            ->where('role', 'medis')
            ->where('status', 'approved')
            ->orderBy('name', 'asc')
            ->get();

        return view(
            'asesmen-kesehatan.asesmen-kesehatan-awal-detail',
            compact(
                'ppks',
                'kesehatanAwal',
                'tanggalDaring',
                'gelombang',
                'tahunValue',
                'petugasKesehatan',
                'hasilAsesmenKesehatan',
                'catatanAsesmenKesehatan',
                'asesmenLuring',
                'lokasiAsesmenLuring',
                'tanggalAsesmenLuring',
                'petugasAsesmenLuring',
                'hasilAsesmenLuring',
                'catatanAsesmenLuring'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DETAIL KESEHATAN AWAL - LULUS
    |--------------------------------------------------------------------------
    */

    public function asesmenKesehatanAwalLolos(
        Ppks $ppks
    ) {
        return $this->detailAsesmenKesehatanByStatus(
            $ppks,
            'lulus',
            'ppks.normal.asesmen-kesehatan.lulus',
            'Peserta belum dinyatakan Lulus Asesmen Kesehatan Awal.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DETAIL KESEHATAN AWAL - PENDING
    |--------------------------------------------------------------------------
    */

    public function asesmenKesehatanAwalPending(
        Ppks $ppks
    ) {
        return $this->detailAsesmenKesehatanByStatus(
            $ppks,
            'pending',
            'ppks.normal.asesmen-kesehatan.pending',
            'Peserta belum berstatus Pending pada Asesmen Kesehatan Awal.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DETAIL KESEHATAN AWAL - TIDAK LULUS
    |--------------------------------------------------------------------------
    */

    public function asesmenKesehatanAwalTidakLolos(
        Ppks $ppks
    ) {
        return $this->detailAsesmenKesehatanByStatus(
            $ppks,
            'tidak_lulus',
            'ppks.normal.asesmen-kesehatan.tidak-lulus',
            'Peserta belum dinyatakan Tidak Lulus Asesmen Kesehatan Awal.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | HELPER HASIL KESEHATAN AWAL
    |--------------------------------------------------------------------------
    */

    private function asesmenKesehatanByHasil(
        Request $request,
        string $hasil,
        string $view
    ): View {
        $query = Ppks::query()
            ->where('status', 'normal')
            ->whereHas(
                'prosesPesertas',
                function ($q) {
                    $q
                        ->where('tahap', 'instruktur')
                        ->where('status', 'lulus');
                }
            )
            ->whereHas(
                'prosesPesertas',
                function ($q) use ($hasil) {
                    $q
                        ->where('tahap', 'kesehatan_awal')
                        ->where('status', $hasil);
                }
            )
            ->with([
                'prosesPesertas' => function ($q) {
                    $q
                        ->whereIn(
                            'tahap',
                            [
                                'instruktur',
                                'kesehatan_awal',
                            ]
                        )
                        ->orderByDesc('tanggal_proses')
                        ->orderByDesc('created_at');
                }
            ]);

        $this->applySearch($query, $request);

        $ppks = $this->applyPpksSorting($query)
            ->paginate(15)
            ->withQueryString();

        $tahap = 'kesehatan_awal';

        return view(
            $view,
            compact(
                'ppks',
                'tahap',
                'hasil'
            )
        );
    }

/*
|--------------------------------------------------------------------------
| SIMPAN ASESMEN KESEHATAN AWAL
|--------------------------------------------------------------------------
*/

public function simpanAsesmenKesehatanAwal(Request $request, Ppks $ppks)
{
    /*
    |--------------------------------------------------------------------------
    | HAK AKSES
    |--------------------------------------------------------------------------
    */
    $role = strtolower(trim((string) (auth()->user()->role ?? '')));

    if (!in_array($role, ['medis', 'super_admin'], true)) {
        abort(403, 'Anda tidak memiliki izin untuk menyimpan asesmen kesehatan awal.');
    }

    /*
    |--------------------------------------------------------------------------
    | VALIDASI FORM
    |--------------------------------------------------------------------------
    |
    | Nilai hasil dari Blade:
    | - lulus
    | - tidak_lulus
    | - pending
    |
    */
    $validated = $request->validate([
        'tanggal_daring' => [
            'required',
            'date',
        ],

        'gelombang' => [
            'required',
            'integer',
            'between:1,10',
        ],

        'tahun' => [
            'required',
            'integer',
            'min:2000',
            'max:' . (date('Y') + 1),
        ],

        'petugas_kesehatan' => [
            'required',
            'integer',
            'exists:users,id',
        ],

        'hasil_asesmen_kesehatan' => [
            'required',
            'in:lulus,tidak_lulus,pending',
        ],

        'catatan_asesmen_kesehatan' => [
            'nullable',
            'string',
        ],

        'asesmen_luring' => [
            'nullable',
            'boolean',
        ],

        'lokasi_asesmen_luring' => [
            'nullable',
            'string',
            'max:255',
        ],

        'tanggal_asesmen_luring' => [
            'nullable',
            'date',
        ],

        'petugas_asesmen_luring' => [
            'nullable',
            'integer',
            'exists:users,id',
        ],

        'hasil_asesmen_luring' => [
            'nullable',
            'in:lulus,tidak_lulus,pending',
        ],

        'catatan_asesmen_luring' => [
            'nullable',
            'string',
        ],
    ]);

    /*
    |--------------------------------------------------------------------------
    | MAPPING HASIL FORM -> STATUS DATABASE
    |--------------------------------------------------------------------------
    |
    | Form:
    |   lulus        -> DB: lolos
    |   tidak_lulus  -> DB: tidak_lolos
    |   pending      -> DB: pending
    |
    */
    $status = match ($validated['hasil_asesmen_kesehatan']) {
        'lulus' => 'lulus',
        'tidak_lulus' => 'tidak_lulus',
        'pending' => 'pending',
    };

    /*
    |--------------------------------------------------------------------------
    | SIMPAN KE RECORD PPKS YANG SEDANG DIBUKA
    |--------------------------------------------------------------------------
    |
    | PENTING:
    | Jangan pakai:
    |
    | ProsesPeserta::latest()->first()
    |
    | Karena itu bisa mengambil record peserta lain.
    |
    | Kita selalu mencari berdasarkan $ppks->id.
    |--------------------------------------------------------------------------
    */

    $proses = $ppks->prosesPesertas()
        ->where('tahap', 'kesehatan_awal')
        ->first();

    /*
    |--------------------------------------------------------------------------
    | BUAT RECORD JIKA BELUM ADA
    |--------------------------------------------------------------------------
    */

    if (!$proses) {
        $proses = $ppks->prosesPesertas()->create([
            'tahap' => 'kesehatan_awal',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | SIMPAN PROSES KESEHATAN AWAL
    |--------------------------------------------------------------------------
    */

    $proses->update([
        'status' => $status,
        'catatan' => $validated['catatan_asesmen_kesehatan'] ?? null,
        'tanggal_proses' => $validated['tanggal_daring'],
    ]);

    /*
    |--------------------------------------------------------------------------
    | SIMPAN DATA DETAIL ASESMEN KE DALAM DATA PPKS
    |--------------------------------------------------------------------------
    |
    | Ini supaya data detail tetap melekat pada PPKS yang benar.
    |--------------------------------------------------------------------------
    */

    $data = is_array($ppks->data)
        ? $ppks->data
        : [];

    $data['tanggal_daring'] =
        $validated['tanggal_daring'];

    $data['gelombang'] =
        $validated['gelombang'];

    $data['tahun'] =
        $validated['tahun'];

    $data['petugas_kesehatan'] =
        $validated['petugas_kesehatan'];

    $data['hasil_asesmen_kesehatan'] =
        $validated['hasil_asesmen_kesehatan'];

    $data['catatan_asesmen_kesehatan'] =
        $validated['catatan_asesmen_kesehatan'] ?? null;

    /*
    |--------------------------------------------------------------------------
    | ASESMEN LURING
    |--------------------------------------------------------------------------
    */

    $asesmenLuring = $request->boolean('asesmen_luring');

    $data['asesmen_luring'] = $asesmenLuring;

    if ($asesmenLuring) {
        $data['lokasi_asesmen_luring'] =
            $validated['lokasi_asesmen_luring'] ?? null;

        $data['tanggal_asesmen_luring'] =
            $validated['tanggal_asesmen_luring'] ?? null;

        $data['petugas_asesmen_luring'] =
            $validated['petugas_asesmen_luring'] ?? null;

        $data['hasil_asesmen_luring'] =
            $validated['hasil_asesmen_luring'] ?? null;

        $data['catatan_asesmen_luring'] =
            $validated['catatan_asesmen_luring'] ?? null;
    } else {
        $data['lokasi_asesmen_luring'] = null;
        $data['tanggal_asesmen_luring'] = null;
        $data['petugas_asesmen_luring'] = null;
        $data['hasil_asesmen_luring'] = null;
        $data['catatan_asesmen_luring'] = null;
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE PPKS
    |--------------------------------------------------------------------------
    */

    $ppks->update([
        'data' => $data,
    ]);

    /*
    |--------------------------------------------------------------------------
    | REDIRECT
    |--------------------------------------------------------------------------
    */

    return redirect()
        ->route(
            'ppks.normal.asesmen-kesehatan.awal',
            $ppks->id
        )
        ->with(
            'success',
            'Asesmen kesehatan awal berhasil disimpan.'
        );
}




    /*
    |--------------------------------------------------------------------------
    | CASE CONFERENCE
    |--------------------------------------------------------------------------
    */

    public function caseConference(
    Request $request
): View {
    $query = Ppks::query()
        ->where('status', 'normal')

        ->whereHas(
            'prosesPesertas',
            function ($q) {
                $q
                    ->where('tahap', 'kesehatan_awal')
                    ->where('status', 'lulus');
            }
        )

        ->whereHas(
            'prosesPesertas',
            function ($q) {
                $q
                    ->where('tahap', 'case_conference')
                    ->whereIn(
                        'status',
                        [
                            'belum',
                            'sedang_diperiksa',
                            'pending',
                            'lulus',
                            'tidak_lulus',
                        ]
                    );
            }
        )

        ->with([
            'prosesPesertas' => function ($q) {
                $q
                    ->where('tahap', 'case_conference')
                    ->orderByDesc('tanggal_proses')
                    ->orderByDesc('created_at');
            }
        ]);

    $this->applySearch($query, $request);

    $this->applyHasilFilter(
        $query,
        $request,
        'case_conference'
    );

    $ppks = $this->applyPpksSorting($query)
        ->paginate(15)
        ->withQueryString();

    $tahap = 'case_conference';

    return view(
        'ppks.normal',
        compact(
            'ppks',
            'tahap'
        )
    );
}

    /*
    |--------------------------------------------------------------------------
    | DETAIL CASE CONFERENCE
    |--------------------------------------------------------------------------
    |
    | Detail tetap boleh dibuka walaupun Case Conference sebelumnya
    | sudah menghasilkan Diterima / Tidak Diterima.
    |
    */

    public function caseConferenceDetail(
        Ppks $ppks
    ): View {
        $lulusKesehatan = $ppks
            ->prosesPesertas()
            ->where('tahap', 'kesehatan_awal')
            ->where('status', 'lulus')
            ->exists();

        if (!$lulusKesehatan) {
            abort(
                403,
                'Peserta belum lulus Asesmen Kesehatan Awal.'
            );
        }

        $ppks->load([
            'prosesPesertas' => function ($q) {
                $q
                    ->whereIn(
                        'tahap',
                        [
                            'instruktur',
                            'kesehatan_awal',
                            'case_conference',
                        ]
                    )
                    ->orderByDesc('tanggal_proses')
                    ->orderByDesc('created_at');
            }
        ]);

        return view(
            'case-conference.case-conference-detail',
            compact('ppks')
        );
    }

public function caseConferenceBelum()
{
    $data = Ppks::query()
        // Wajib sudah lulus asesmen kesehatan awal
        ->whereHas('prosesPesertas', function ($query) {
            $query->where('tahap', 'kesehatan_awal')
                ->where('status', 'lulus');
        })

        // Case Conference:
        // boleh belum punya record,
        // atau sudah ada tetapi masih belum/sedang diperiksa
        ->where(function ($query) {
            $query
                ->whereDoesntHave('prosesPesertas', function ($q) {
                    $q->where('tahap', 'case_conference');
                })
                ->orWhereHas('prosesPesertas', function ($q) {
                    $q->where('tahap', 'case_conference')
                        ->whereIn('status', [
                            'belum',
                            'sedang_diperiksa',
                        ]);
                });
        })

        ->with('prosesPesertas')
        ->latest('id')
        ->paginate(20);

    return view(
        'case-conference.case-conference-belum',
        compact('data')
    );
}


public function caseConferenceSudah()
{
    $data = Ppks::query()
        ->whereHas('prosesPesertas', function ($query) {
            $query
                ->where('tahap', 'case_conference')
                ->whereIn('status', [
                    'pending',
                    'lulus',
                    'tidak_lulus',
                ]);
        })
        ->with('prosesPesertas')
        ->latest('id')
        ->paginate(20);

    return view(
        'case-conference.case-conference-sudah',
        compact('data')
    );
}


    /*
    |--------------------------------------------------------------------------
    | UPDATE CASE CONFERENCE
    |--------------------------------------------------------------------------
    |
    | Form Blade mengirim:
    |
    | hasil_case_conference
    | jurusan_diterima
    | tanggal_case_conference
    | gelombang_pelatihan
    | tahun_pelatihan
    | catatan_case_conference
    |
    */

    public function updateCaseConference(
        Request $request,
        Ppks $ppks
    ) {
        /*
        |--------------------------------------------------------------------------
        | ROLE
        |--------------------------------------------------------------------------
        */

        $this->ensureRole(
            'super_admin',
            'medis',
            'instruktur'
        );


        /*
        |--------------------------------------------------------------------------
        | VALIDASI SESUAI FIELD BLADE
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'hasil_case_conference' => [
                'required',
                'in:diterima,tidak_diterima,pending',
            ],

            'jurusan_diterima' => [
                'nullable',
                'string',
            ],

            'tanggal_case_conference' => [
                'nullable',
                'date',
            ],

            'gelombang_pelatihan' => [
                'nullable',
                'in:1,2',
            ],

            'tahun_pelatihan' => [
                'nullable',
                'in:2026,2027,2028',
            ],

            'catatan_case_conference' => [
                'nullable',
                'string',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | PASTIKAN LULUS KESEHATAN AWAL
        |--------------------------------------------------------------------------
        */

        $lulusKesehatan = $ppks
            ->prosesPesertas()
            ->where('tahap', 'kesehatan_awal')
            ->where('status', 'lulus')
            ->exists();

        if (!$lulusKesehatan) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Peserta belum lulus Asesmen Kesehatan Awal.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | KONVERSI STATUS FORM -> DATABASE
        |--------------------------------------------------------------------------
        |
        | diterima       => lulus
        | pending        => pending
        | tidak_diterima => tidak_lulus
        |
        */

        $statusMap = [
            'diterima' =>
                'lulus',

            'pending' =>
                'pending',

            'tidak_diterima' =>
                'tidak_lulus',
        ];

        $status = $statusMap[
            $validated['hasil_case_conference']
        ];


        /*
        |--------------------------------------------------------------------------
        | SIMPAN DALAM TRANSACTION
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $ppks,
            $validated,
            $status
        ) {

            /*
            |--------------------------------------------------------------------------
            | AMBIL / BUAT RECORD CASE CONFERENCE
            |--------------------------------------------------------------------------
            */

            $proses = ProsesPeserta::query()
                ->where('ppks_id', $ppks->id)
                ->where('tahap', 'case_conference')
                ->first();

            if (!$proses) {
                $proses = new ProsesPeserta();

                $proses->ppks_id =
                    $ppks->id;

                $proses->tahap =
                    'case_conference';
            }


            /*
            |--------------------------------------------------------------------------
            | SIMPAN HASIL CASE CONFERENCE
            |--------------------------------------------------------------------------
            */

            $proses->status =
                $status;

            $proses->catatan =
                $validated['catatan_case_conference']
                ??
                null;

            $proses->tanggal_proses =
                now();

            $proses->save();


            /*
            |--------------------------------------------------------------------------
            | AMBIL DATA PPKS
            |--------------------------------------------------------------------------
            */

            $data = $ppks->data ?? [];

            if (!is_array($data)) {
                $data = json_decode(
                    $data,
                    true
                ) ?? [];
            }


            /*
            |--------------------------------------------------------------------------
            | SIMPAN DATA CASE CONFERENCE
            |--------------------------------------------------------------------------
            */

            $data['jurusan_diterima'] =
                $validated['jurusan_diterima']
                ??
                null;

            $data['tanggal_case_conference'] =
                $validated['tanggal_case_conference']
                ??
                null;

            $data['gelombang_pelatihan'] =
                $validated['gelombang_pelatihan']
                ??
                null;

            $data['tahun_pelatihan'] =
                $validated['tahun_pelatihan']
                ??
                null;


            /*
            |--------------------------------------------------------------------------
            | RECORD SIAPA YANG MENGUBAH
            |--------------------------------------------------------------------------
            */

            $data['case_conference_diubah_pada'] =
                now()->format('Y-m-d H:i:s');

            $data['case_conference_diubah_oleh_id'] =
                auth()->id();

            $data['case_conference_diubah_oleh'] =
                auth()->user()?->name;


            /*
            |--------------------------------------------------------------------------
            | WAKTU SELESAI
            |--------------------------------------------------------------------------
            */

            if (
                in_array(
                    $status,
                    [
                        'lulus',
                        'tidak_lulus',
                    ],
                    true
                )
            ) {
                $data['selesai_pemeriksaan_at'] =
                    now()->format('Y-m-d H:i:s');
            } else {
                $data['selesai_pemeriksaan_at'] =
                    null;
            }


            /*
            |--------------------------------------------------------------------------
            | STATUS UTAMA PPKS
            |--------------------------------------------------------------------------
            */
            // Status utama PPKS tetap NORMAL.
            // Hasil diterima / tidak diterima / pending
            // disimpan di proses_pesertas.
            $ppks->status = 'normal';



            /*
            |--------------------------------------------------------------------------
            | SIMPAN PPKS
            |--------------------------------------------------------------------------
            */

            $ppks->data =
                $data;

            $ppks->save();
        });


        /*
        |--------------------------------------------------------------------------
        | PESAN HASIL
        |--------------------------------------------------------------------------
        */

        if ($status === 'lulus') {
            return redirect()
                ->route(
                    'ppks.normal.case-conference.detail',
                    [
                        'ppks' =>
                            $ppks->id,
                    ]
                )
                ->with(
                    'success',
                    'Data Case Conference berhasil disimpan. Peserta dinyatakan DITERIMA.'
                );
        }

        if ($status === 'tidak_lulus') {
            return redirect()
                ->route(
                    'ppks.normal.case-conference.detail',
                    [
                        'ppks' =>
                            $ppks->id,
                    ]
                )
                ->with(
                    'success',
                    'Data Case Conference berhasil disimpan. Peserta dinyatakan TIDAK DITERIMA.'
                );
        }

        return redirect()
            ->route(
                'ppks.normal.case-conference.detail',
                [
                    'ppks' =>
                        $ppks->id,
                ]
            )
            ->with(
                'success',
                'Data Case Conference berhasil disimpan. Peserta berstatus PENDING.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | SORTING
    |--------------------------------------------------------------------------
    */

    private function applyPpksSorting($query)
    {
        return $query
            ->orderByRaw("
                COALESCE(

                    STR_TO_DATE(
                        JSON_UNQUOTE(
                            JSON_EXTRACT(
                                ppks.data,
                                '$.selesai_pemeriksaan_at'
                            )
                        ),
                        '%Y-%m-%d %H:%i:%s'
                    ),

                    (
                        SELECT MAX(pp.tanggal_proses)
                        FROM proses_pesertas pp
                        WHERE pp.ppks_id = ppks.id
                    ),

                    STR_TO_DATE(
                        JSON_UNQUOTE(
                            JSON_EXTRACT(
                                ppks.data,
                                '$.masuk_normal_at'
                            )
                        ),
                        '%Y-%m-%d %H:%i:%s'
                    ),

                    STR_TO_DATE(
                        JSON_UNQUOTE(
                            JSON_EXTRACT(
                                ppks.data,
                                '$.timestamp'
                            )
                        ),
                        '%Y-%m-%d %H:%i:%s'
                    ),

                    STR_TO_DATE(
                        JSON_UNQUOTE(
                            JSON_EXTRACT(
                                ppks.data,
                                '$.timestamp'
                            )
                        ),
                        '%m/%d/%Y %H:%i:%s'
                    ),

                    ppks.created_at

                ) DESC
            ")
            ->orderByDesc('ppks.id');
    }


    /*
    |--------------------------------------------------------------------------
    | FILTER HASIL
    |--------------------------------------------------------------------------
    */

    private function applyHasilFilter(
        $query,
        Request $request,
        string $tahap
    ): void {
        if (!$request->filled('hasil')) {
            return;
        }

        $hasil =
            $request->hasil;

        $query->whereHas(
            'prosesPesertas',
            function ($q) use (
                $tahap,
                $hasil
            ) {
                $q
                    ->where('tahap', $tahap)
                    ->where('status', $hasil);
            }
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SEARCH
    |--------------------------------------------------------------------------
    */

    private function applySearch(
        $query,
        Request $request
    ): void {
        if (!$request->filled('search')) {
            return;
        }

        $search =
            trim(
                $request->search
            );

        if ($search === '') {
            return;
        }

        $searchLike =
            '%' .
            $search .
            '%';

        $query->where(
            function ($q) use (
                $searchLike
            ) {
                $q->where(
                    'sheet_row',
                    'like',
                    $searchLike
                );

                $q->orWhereRaw(
                    'LOWER(TRIM(JSON_UNQUOTE(JSON_EXTRACT(ppks.data, "$.nama_lengkap")))) LIKE LOWER(?)',
                    [$searchLike]
                );

                $q->orWhereRaw(
                    'LOWER(TRIM(JSON_UNQUOTE(JSON_EXTRACT(ppks.data, "$.nik")))) LIKE LOWER(?)',
                    [$searchLike]
                );

                $q->orWhereRaw(
                    'LOWER(TRIM(JSON_UNQUOTE(JSON_EXTRACT(ppks.data, "$.jenis_ppks")))) LIKE LOWER(?)',
                    [$searchLike]
                );
            }
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DATA DITERIMA
    |--------------------------------------------------------------------------
    */

    public function diterima(
        Request $request
    ): View {
        $query = Ppks::query()
            ->where('status', 'diterima')
            ->with([
                'prosesPesertas' => function ($q) {
                    $q
                        ->orderByDesc('tanggal_proses')
                        ->orderByDesc('created_at');
                }
            ]);

        $this->applySearch(
            $query,
            $request
        );

        $ppks = $this->applyPpksSorting($query)
            ->paginate(15)
            ->withQueryString();

        $tahap =
            'diterima';

        return view(
            'ppks.normal',
            compact(
                'ppks',
                'tahap'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DATA TIDAK DITERIMA
    |--------------------------------------------------------------------------
    */

    public function tidakDiterima(
        Request $request
    ): View {
        $query = Ppks::query()
            ->where(
                'status',
                'tidak_diterima'
            )
            ->with([
                'prosesPesertas' => function ($q) {
                    $q
                        ->orderByDesc('tanggal_proses')
                        ->orderByDesc('created_at');
                }
            ]);

        $this->applySearch(
            $query,
            $request
        );

        $ppks = $this->applyPpksSorting($query)
            ->paginate(15)
            ->withQueryString();

        $tahap =
            'tidak_diterima';

        return view(
            'ppks.normal',
            compact(
                'ppks',
                'tahap'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DATA MANUAL
    |--------------------------------------------------------------------------
    */

    public function manual(
        Request $request
    ): View {
        $query = Ppks::query()
            ->where('status', 'normal')
            ->where(
                'data->sumber_data',
                'manual'
            )
            ->with('createdBy');

        $this->applySearch(
            $query,
            $request
        );

        $ppks = $query
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return view(
            'ppks.manual',
            compact('ppks')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | FORM TAMBAH DATA MANUAL
    |--------------------------------------------------------------------------
    */

    public function createNormal(): View
    {
        $admins = User::query()
            ->whereIn(
                'role',
                [
                    'super_admin',
                    'medis',
                    'instruktur',
                ]
            )
            ->where(
                'status',
                'approved'
            )
            ->orderBy(
                'name',
                'asc'
            )
            ->get();

        return view(
            'ppks.normal-create',
            compact('admins')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SIMPAN DATA MANUAL
    |--------------------------------------------------------------------------
    */

    public function storeNormal(
        Request $request
    ) {
        $validated = $request->validate([
            'diinput_oleh' => [
                'required',
                'integer',
                'exists:users,id',
            ],

            'nama_lengkap' => [
                'required',
                'string',
                'max:255',
            ],

            'nik' => [
                'required',
                'string',
                'max:30',
            ],

            'jenis_kelamin' => [
                'required',
                'string',
                'max:50',
            ],

            'tempat_lahir' => [
                'nullable',
                'string',
                'max:100',
            ],

            'tanggal_lahir' => [
                'nullable',
                'date',
            ],

            'usia' => [
                'nullable',
                'integer',
                'min:0',
                'max:150',
            ],

            'alamat_lengkap' => [
                'nullable',
                'string',
            ],

            'provinsi' => [
                'nullable',
                'string',
                'max:100',
            ],

            'kabupaten' => [
                'nullable',
                'string',
                'max:100',
            ],

            'kecamatan' => [
                'nullable',
                'string',
                'max:100',
            ],

            'kelurahan' => [
                'nullable',
                'string',
                'max:100',
            ],

            'pendidikan_terakhir' => [
                'nullable',
                'string',
                'max:100',
            ],

            'keterangan_pendidikan' => [
                'nullable',
                'string',
            ],

            'jenis_ppks' => [
                'required',
                'string',
                'max:255',
            ],

            'keterangan_disabilitas' => [
                'nullable',
                'string',
            ],

            'jurusan_yang_diminati' => [
                'nullable',
                'string',
                'max:255',
            ],

            'peminatan' => [
                'nullable',
                'string',
                'max:255',
            ],

            'alumni_stis' => [
                'nullable',
                'string',
                'max:50',
            ],

            'no_hp_1' => [
                'required',
                'string',
                'max:30',
            ],

            'no_hp_2' => [
                'nullable',
                'string',
                'max:30',
            ],

            'email' => [
                'nullable',
                'email',
                'max:255',
            ],

            'nomor_kartu_keluarga' => [
                'nullable',
                'string',
                'max:30',
            ],

            'pelatihan_kursus' => [
                'nullable',
                'string',
            ],

            'kemampuan_membaca_menulis' => [
                'nullable',
                'string',
            ],

            'aktivitas_sehari_hari' => [
                'nullable',
                'string',
            ],

            'bersedia_pelatihan_vokasional' => [
                'nullable',
                'string',
                'max:50',
            ],

            'kondisi_kesehatan' => [
                'nullable',
                'string',
            ],

            'upload_ktp' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:20480',
            ],

            'upload_kk' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:20480',
            ],

            'upload_ijazah_terakhir' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:20480',
            ],

            'upload_foto_full_badan' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png',
                'max:20480',
            ],

            'upload_video' => [
                'nullable',
                'file',
                'mimes:mp4,mov,avi,mkv',
                'max:51200',
            ],

            'upload_transkrip' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:20480',
            ],
        ]);

        $nikSudahAda = Ppks::query()
            ->where(
                'data->nik',
                $validated['nik']
            )
            ->exists();

        if ($nikSudahAda) {
            return back()
                ->withInput()
                ->withErrors([
                    'nik' =>
                        'Data tidak dapat disimpan karena NIK tersebut sudah tersedia.',
                ]);
        }

        $admin = User::query()
            ->whereIn(
                'role',
                [
                    'super_admin',
                    'medis',
                    'instruktur',
                ]
            )
            ->where(
                'status',
                'approved'
            )
            ->findOrFail(
                $validated['diinput_oleh']
            );

        $data = $validated;

        unset(
            $data['diinput_oleh']
        );

        $data['timestamp'] =
            now()->format(
                'Y-m-d H:i:s'
            );

        $data['masuk_normal_at'] =
            now()->format(
                'Y-m-d H:i:s'
            );

        $data['sumber_data'] =
            'manual';

        $data['dimasukkan_oleh_id'] =
            $admin->id;

        $data['dimasukkan_oleh'] =
            $admin->name;

        $fileFields = [
            'upload_ktp',
            'upload_kk',
            'upload_ijazah_terakhir',
            'upload_foto_full_badan',
            'upload_video',
            'upload_transkrip',
        ];

        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $data[$field] =
                    $request
                        ->file($field)
                        ->store(
                            'ppks',
                            'public'
                        );
            } else {
                unset(
                    $data[$field]
                );
            }
        }

        Ppks::create([
            'created_by' =>
                auth()->id(),

            'sheet_row' =>
                null,

            'data' =>
                $data,

            'status' =>
                'normal',

            'possible_duplicate_of' =>
                null,

            'duplicate_note' =>
                null,

            'selected_for_assessment' =>
                false,

            'selected_from_duplicate_id' =>
                null,

            'duplicate_decision' =>
                null,

            'imported_at' =>
                null,
        ]);

        return redirect()
            ->route(
                'ppks.manual'
            )
            ->with(
                'success',
                'Data PPKS berhasil ditambahkan dan masuk ke Data Normal.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | EDIT DATA MANUAL
    |--------------------------------------------------------------------------
    */

    public function editNormal(
        Ppks $ppks
    ): View {
        if (
            ($ppks->data['sumber_data'] ?? null)
            !==
            'manual'
        ) {
            abort(404);
        }

        return view(
            'ppks.normal-edit',
            compact('ppks')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE DATA MANUAL
    |--------------------------------------------------------------------------
    */

    public function updateNormal(
        Request $request,
        Ppks $ppks
    ) {
        if (
            ($ppks->data['sumber_data'] ?? null)
            !==
            'manual'
        ) {
            abort(404);
        }

        $validated = $request->validate([
            'nama_lengkap' => [
                'required',
                'string',
                'max:255',
            ],

            'nik' => [
                'required',
                'string',
                'max:30',
            ],

            'jenis_kelamin' => [
                'required',
                'string',
                'max:50',
            ],

            'tempat_lahir' => [
                'nullable',
                'string',
                'max:100',
            ],

            'tanggal_lahir' => [
                'nullable',
                'date',
            ],

            'usia' => [
                'nullable',
                'integer',
                'min:0',
                'max:150',
            ],

            'alamat_lengkap' => [
                'nullable',
                'string',
            ],

            'provinsi' => [
                'nullable',
                'string',
                'max:100',
            ],

            'kabupaten' => [
                'nullable',
                'string',
                'max:100',
            ],

            'kecamatan' => [
                'nullable',
                'string',
                'max:100',
            ],

            'kelurahan' => [
                'nullable',
                'string',
                'max:100',
            ],

            'pendidikan_terakhir' => [
                'nullable',
                'string',
                'max:100',
            ],

            'keterangan_pendidikan' => [
                'nullable',
                'string',
            ],

            'jenis_ppks' => [
                'required',
                'string',
                'max:255',
            ],

            'keterangan_disabilitas' => [
                'nullable',
                'string',
            ],

            'jurusan_yang_diminati' => [
                'nullable',
                'string',
                'max:255',
            ],

            'peminatan' => [
                'nullable',
                'string',
                'max:255',
            ],

            'alumni_stis' => [
                'nullable',
                'string',
                'max:50',
            ],

            'no_hp_1' => [
                'required',
                'string',
                'max:30',
            ],

            'no_hp_2' => [
                'nullable',
                'string',
                'max:30',
            ],

            'email' => [
                'nullable',
                'email',
                'max:255',
            ],

            'nomor_kartu_keluarga' => [
                'nullable',
                'string',
                'max:30',
            ],

            'pelatihan_kursus' => [
                'nullable',
                'string',
            ],

            'kemampuan_membaca_menulis' => [
                'nullable',
                'string',
            ],

            'aktivitas_sehari_hari' => [
                'nullable',
                'string',
            ],

            'bersedia_pelatihan_vokasional' => [
                'nullable',
                'string',
                'max:50',
            ],

            'kondisi_kesehatan' => [
                'nullable',
                'string',
            ],

            'upload_ktp' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:20480',
            ],

            'upload_kk' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:20480',
            ],

            'upload_ijazah_terakhir' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:20480',
            ],

            'upload_foto_full_badan' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png',
                'max:20480',
            ],

            'upload_video' => [
                'nullable',
                'file',
                'mimes:mp4,mov,avi,mkv',
                'max:51200',
            ],

            'upload_transkrip' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:20480',
            ],
        ]);

        $nikSudahAda = Ppks::query()
            ->where(
                'data->nik',
                $validated['nik']
            )
            ->where(
                'id',
                '!=',
                $ppks->id
            )
            ->exists();

        if ($nikSudahAda) {
            return back()
                ->withInput()
                ->withErrors([
                    'nik' =>
                        'Data tidak dapat diperbarui karena NIK tersebut sudah digunakan oleh data lain.',
                ]);
        }

        $data = $ppks->data ?? [];

        if (!is_array($data)) {
            $data = json_decode(
                $data,
                true
            ) ?? [];
        }

        $normalFields = [
            'nama_lengkap',
            'nik',
            'jenis_kelamin',
            'tempat_lahir',
            'tanggal_lahir',
            'usia',
            'alamat_lengkap',
            'provinsi',
            'kabupaten',
            'kecamatan',
            'kelurahan',
            'pendidikan_terakhir',
            'keterangan_pendidikan',
            'jenis_ppks',
            'keterangan_disabilitas',
            'jurusan_yang_diminati',
            'peminatan',
            'alumni_stis',
            'no_hp_1',
            'no_hp_2',
            'email',
            'nomor_kartu_keluarga',
            'pelatihan_kursus',
            'kemampuan_membaca_menulis',
            'aktivitas_sehari_hari',
            'bersedia_pelatihan_vokasional',
            'kondisi_kesehatan',
        ];

        foreach (
            $normalFields
            as $field
        ) {
            if (
                array_key_exists(
                    $field,
                    $validated
                )
            ) {
                $data[$field] =
                    $validated[$field];
            }
        }

        $fileFields = [
            'upload_ktp',
            'upload_kk',
            'upload_ijazah_terakhir',
            'upload_foto_full_badan',
            'upload_video',
            'upload_transkrip',
        ];

        foreach (
            $fileFields
            as $field
        ) {
            if ($request->hasFile($field)) {
                $oldFile =
                    $data[$field]
                    ??
                    null;

                if (
                    $oldFile
                    &&
                    !filter_var(
                        $oldFile,
                        FILTER_VALIDATE_URL
                    )
                ) {
                    Storage::disk('public')
                        ->delete(
                            $oldFile
                        );
                }

                $data[$field] =
                    $request
                        ->file($field)
                        ->store(
                            'ppks',
                            'public'
                        );
            }
        }

        $data['sumber_data'] =
            'manual';

        $data['dimasukkan_oleh_id'] =
            $ppks->created_by;

        $creator =
            User::find(
                $ppks->created_by
            );

        $data['dimasukkan_oleh'] =
            $creator?->name;

        $data['diubah_pada'] =
            now()->format(
                'Y-m-d H:i:s'
            );

        $data['diubah_oleh_id'] =
            auth()->id();

        $data['diubah_oleh'] =
            auth()->user()?->name;

        $data['timestamp'] =
            now()->format(
                'Y-m-d H:i:s'
            );

        $ppks->update([
            'sheet_row' =>
                null,

            'imported_at' =>
                null,

            'data' =>
                $data,
        ]);

        return redirect()
            ->route(
                'ppks.manual'
            )
            ->with(
                'success',
                'Data PPKS berhasil diperbarui.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | HAPUS DATA MANUAL
    |--------------------------------------------------------------------------
    */

    public function destroyNormal(
        Ppks $ppks
    ) {
        if (
            ($ppks->data['sumber_data'] ?? null)
            !==
            'manual'
        ) {
            abort(404);
        }

        $fileFields = [
            'upload_ktp',
            'upload_kk',
            'upload_ijazah_terakhir',
            'upload_foto_full_badan',
            'upload_video',
            'upload_transkrip',
        ];

        foreach (
            $fileFields
            as $field
        ) {
            $file =
                $ppks->data[$field]
                ??
                null;

            if (
                $file
                &&
                !filter_var(
                    $file,
                    FILTER_VALIDATE_URL
                )
            ) {
                Storage::disk('public')
                    ->delete(
                        $file
                    );
            }
        }

        $ppks
            ->prosesPesertas()
            ->delete();

        if (
            method_exists(
                $ppks,
                'peserta'
            )
            &&
            $ppks->peserta
        ) {
            $ppks
                ->peserta()
                ->delete();
        }

        $ppks->delete();

        return redirect()
            ->route(
                'ppks.manual'
            )
            ->with(
                'success',
                'Data PPKS berhasil dihapus.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | PILIH DATA
    |--------------------------------------------------------------------------
    */

    public function pilih(
        Ppks $ppks
    ) {
        $data =
            $ppks->data
            ??
            [];

        if (!is_array($data)) {
            $data =
                json_decode(
                    $data,
                    true
                )
                ??
                [];
        }

        $data['masuk_normal_at'] =
            now()->format(
                'Y-m-d H:i:s'
            );

        $ppks->update([
            'status' =>
                'normal',

            'selected_for_assessment' =>
                true,

            'data' =>
                $data,
        ]);

        return back()->with(
            'success',
            'Data berhasil dipindahkan ke Data Normal.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | MULAI ASESMEN
    |--------------------------------------------------------------------------
    */

    public function mulaiAsesmen(
        Request $request,
        Ppks $ppks
    ) {
        $request->validate([
            'tahap' => [
                'required',
                'in:instruktur,kesehatan_awal,case_conference',
            ],
        ]);

        $tahap =
            $request->tahap;


        /*
        |--------------------------------------------------------------------------
        | ROLE ASESMEN
        |--------------------------------------------------------------------------
        */

        if (
            $tahap ===
            'instruktur'
        ) {
            $this->ensureRole(
                'instruktur'
            );
        }

        elseif (
            $tahap ===
            'kesehatan_awal'
        ) {
            $this->ensureRole(
                'medis'
            );
        }

        elseif (
            $tahap ===
            'case_conference'
        ) {
            $this->ensureRole(
                'super_admin',
                'medis',
                'instruktur'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | STATUS NORMAL
        |--------------------------------------------------------------------------
        */

        if (
            $ppks->status !==
            'normal'
        ) {
            return back()->with(
                'error',
                'Data belum berstatus normal.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | CEK KESEHATAN AWAL
        |--------------------------------------------------------------------------
        */

        if (
            $tahap ===
            'kesehatan_awal'
        ) {
            $lulusInstruktur =
                $ppks
                    ->prosesPesertas()
                    ->where(
                        'tahap',
                        'instruktur'
                    )
                    ->where(
                        'status',
                        'lulus'
                    )
                    ->exists();

            if (!$lulusInstruktur) {
                return back()->with(
                    'error',
                    'Peserta belum lulus Asesmen Instruktur.'
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | CEK CASE CONFERENCE
        |--------------------------------------------------------------------------
        */

        if (
            $tahap ===
            'case_conference'
        ) {
            $lulusKesehatan =
                $ppks
                    ->prosesPesertas()
                    ->where(
                        'tahap',
                        'kesehatan_awal'
                    )
                    ->where(
                        'status',
                        'lulus'
                    )
                    ->exists();

            if (!$lulusKesehatan) {
                return back()->with(
                    'error',
                    'Peserta belum lulus Asesmen Kesehatan Awal.'
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | CARI PROSES
        |--------------------------------------------------------------------------
        */

        $proses =
            ProsesPeserta::query()
                ->where(
                    'ppks_id',
                    $ppks->id
                )
                ->where(
                    'tahap',
                    $tahap
                )
                ->first();

        if ($proses) {

            if (
                $proses->status ===
                'belum'
            ) {
                $proses->update([
                    'status' =>
                        'sedang_diperiksa',

                    'tanggal_proses' =>
                        now(),
                ]);

                return back()->with(
                    'success',
                    'Asesmen berhasil dimulai.'
                );
            }

            if (
                $proses->status ===
                'pending'
            ) {
                return back()->with(
                    'error',
                    'Peserta berstatus PENDING dan tidak dapat melanjutkan asesmen pada tahap ini.'
                );
            }

            if (
                $proses->status ===
                'tidak_lulus'
            ) {
                return back()->with(
                    'error',
                    'Peserta berstatus TIDAK LULUS dan tidak dapat melanjutkan asesmen pada tahap ini.'
                );
            }

            if (
                $proses->status ===
                'lulus'
            ) {
                return back()->with(
                    'error',
                    'Tahap ini sudah dinyatakan LULUS.'
                );
            }

            if (
                $proses->status ===
                'sedang_diperiksa'
            ) {
                return back()->with(
                    'error',
                    'Asesmen tahap ini sedang berlangsung.'
                );
            }

            return back()->with(
                'error',
                'Tahap ini sudah memiliki hasil.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | BUAT PROSES BARU
        |--------------------------------------------------------------------------
        */

        ProsesPeserta::create([
            'ppks_id' =>
                $ppks->id,

            'tahap' =>
                $tahap,

            'status' =>
                'sedang_diperiksa',

            'tanggal_proses' =>
                now(),
        ]);

        return back()->with(
            'success',
            'Asesmen berhasil dimulai.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | HASIL ASESMEN UMUM
    |--------------------------------------------------------------------------
    */

    public function hasilAsesmen(
        Request $request,
        Ppks $ppks,
        string $tahap
    ) {
        $request->validate([
            'status' => [
                'required',
                'in:lulus,pending,tidak_lulus',
            ],

            'alasan_pending' => [
                'nullable',
                'string',
            ],

            'catatan' => [
                'nullable',
                'string',
            ],

            'tanggal_panggil_kembali' => [
                'nullable',
                'date',
            ],
        ]);

        $tahapMap = [
            'instruktur' =>
                'instruktur',

            'kesehatan' =>
                'kesehatan_awal',

            'kesehatan_awal' =>
                'kesehatan_awal',

            'cc' =>
                'case_conference',

            'case_conference' =>
                'case_conference',
        ];

        if (
            !isset(
                $tahapMap[$tahap]
            )
        ) {
            return back()->with(
                'error',
                'Tahap asesmen tidak valid.'
            );
        }

        $tahapSekarang =
            $tahapMap[$tahap];


        /*
        |--------------------------------------------------------------------------
        | ROLE
        |--------------------------------------------------------------------------
        */

        if (
            $tahapSekarang ===
            'instruktur'
        ) {
            $this->ensureRole(
                'instruktur'
            );
        }

        elseif (
            $tahapSekarang ===
            'kesehatan_awal'
        ) {
            $this->ensureRole(
                'medis'
            );
        }

        elseif (
            $tahapSekarang ===
            'case_conference'
        ) {
            $this->ensureRole(
                'super_admin',
                'medis',
                'instruktur'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | STATUS NORMAL
        |--------------------------------------------------------------------------
        */

        if (
            $ppks->status !==
            'normal'
        ) {
            return back()->with(
                'error',
                'Data tidak dapat diproses karena statusnya bukan normal.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | SYARAT KESEHATAN AWAL
        |--------------------------------------------------------------------------
        */

        if (
            $tahapSekarang ===
            'kesehatan_awal'
        ) {
            $lulusInstruktur =
                $ppks
                    ->prosesPesertas()
                    ->where(
                        'tahap',
                        'instruktur'
                    )
                    ->where(
                        'status',
                        'lulus'
                    )
                    ->exists();

            if (!$lulusInstruktur) {
                return back()->with(
                    'error',
                    'Peserta belum lulus Asesmen Instruktur.'
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | SYARAT CASE CONFERENCE
        |--------------------------------------------------------------------------
        */

        if (
            $tahapSekarang ===
            'case_conference'
        ) {
            $lulusKesehatan =
                $ppks
                    ->prosesPesertas()
                    ->where(
                        'tahap',
                        'kesehatan_awal'
                    )
                    ->where(
                        'status',
                        'lulus'
                    )
                    ->exists();

            if (!$lulusKesehatan) {
                return back()->with(
                    'error',
                    'Peserta belum lulus Asesmen Kesehatan Awal.'
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | PROSES
        |--------------------------------------------------------------------------
        */

        $proses =
            ProsesPeserta::query()
                ->where(
                    'ppks_id',
                    $ppks->id
                )
                ->where(
                    'tahap',
                    $tahapSekarang
                )
                ->first();

        if (!$proses) {
            return back()->with(
                'error',
                'Asesmen belum dimulai.'
            );
        }

        if (
            $proses->status !==
            'sedang_diperiksa'
        ) {
            return back()->with(
                'error',
                'Tahap ini sudah memiliki hasil atau belum dimulai.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | TRANSACTION
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $request,
            $ppks,
            $proses,
            $tahapSekarang
        ) {

            $waktuSelesai =
                now()->format(
                    'Y-m-d H:i:s'
                );

            $proses->update([
                'status' =>
                    $request->status,

                'alasan_pending' =>
                    $request->alasan_pending,

                'catatan' =>
                    $request->catatan,

                'tanggal_panggil_kembali' =>
                    $request->tanggal_panggil_kembali,

                'tanggal_proses' =>
                    $waktuSelesai,
            ]);


            /*
            |--------------------------------------------------------------------------
            | CASE CONFERENCE SELESAI
            |--------------------------------------------------------------------------
            */

            if (
                $tahapSekarang ===
                'case_conference'
                &&
                in_array(
                    $request->status,
                    [
                        'lulus',
                        'tidak_lulus',
                    ],
                    true
                )
            ) {
                $data =
                    $ppks->data
                    ??
                    [];

                if (!is_array($data)) {
                    $data =
                        json_decode(
                            $data,
                            true
                        )
                        ??
                        [];
                }

                $data['selesai_pemeriksaan_at'] =
                    $waktuSelesai;

                $ppks->update([
                    'data' =>
                        $data,
                ]);
            }


            /*
            |--------------------------------------------------------------------------
            | TIDAK LULUS
            |--------------------------------------------------------------------------
            */
/*
|--------------------------------------------------------------------------
| TIDAK LULUS
|--------------------------------------------------------------------------
*/

if (
    $request->status ===
    'tidak_lulus'
) {
    return;
}



            /*
            |--------------------------------------------------------------------------
            | INSTRUKTUR LULUS
            |--------------------------------------------------------------------------
            */

            if (
                $request->status ===
                'lulus'
                &&
                $tahapSekarang ===
                'instruktur'
            ) {
                $prosesKesehatan =
                    ProsesPeserta::query()
                        ->where(
                            'ppks_id',
                            $ppks->id
                        )
                        ->where(
                            'tahap',
                            'kesehatan_awal'
                        )
                        ->first();

                if (!$prosesKesehatan) {
                    ProsesPeserta::create([
                        'ppks_id' =>
                            $ppks->id,

                        'tahap' =>
                            'kesehatan_awal',

                        'status' =>
                            'belum',

                        'tanggal_proses' =>
                            null,

                        'catatan' =>
                            null,
                    ]);
                }

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | KESEHATAN AWAL LULUS
            |--------------------------------------------------------------------------
            */

            if (
                $request->status ===
                'lulus'
                &&
                $tahapSekarang ===
                'kesehatan_awal'
            ) {
                $prosesCase =
                    ProsesPeserta::query()
                        ->where(
                            'ppks_id',
                            $ppks->id
                        )
                        ->where(
                            'tahap',
                            'case_conference'
                        )
                        ->first();

                if (!$prosesCase) {
                    ProsesPeserta::create([
                        'ppks_id' =>
                            $ppks->id,

                        'tahap' =>
                            'case_conference',

                        'status' =>
                            'belum',

                        'tanggal_proses' =>
                            null,

                        'catatan' =>
                            null,
                    ]);
                }

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | CASE CONFERENCE LULUS
            |--------------------------------------------------------------------------
            */


        });


        /*
        |--------------------------------------------------------------------------
        | RESPONSE
        |--------------------------------------------------------------------------
        */

        if (
            $request->status ===
            'tidak_lulus'
        ) {
            return back()->with(
                'success',
                'Peserta dinyatakan Tidak Lulus.'
            );
        }

        if (
            $request->status ===
            'pending'
        ) {
            return back()->with(
                'success',
                'Peserta ditetapkan sebagai Pending.'
            );
        }

        if (
            $request->status ===
            'lulus'
            &&
            $tahapSekarang ===
            'instruktur'
        ) {
            return back()->with(
                'success',
                'Asesmen Instruktur Lulus. Peserta dapat melanjutkan ke Asesmen Kesehatan Awal.'
            );
        }

        if (
            $request->status ===
            'lulus'
            &&
            $tahapSekarang ===
            'kesehatan_awal'
        ) {
            return back()->with(
                'success',
                'Asesmen Kesehatan Awal Lulus. Peserta dapat melanjutkan ke Case Conference.'
            );
        }

        if (
    $request->status === 'lulus' &&
    $tahapSekarang === 'case_conference'
) {
    return back()->with(
        'success',
        'Case Conference Lulus. Peserta dinyatakan DITERIMA.'
    );
}
return back();
}



    /*
    |--------------------------------------------------------------------------
    | KEMBALIKAN DATA
    |--------------------------------------------------------------------------
    */

    public function kembalikan(
        Ppks $ppks
    ) {
        $comparison =
            null;

        if (
            $ppks->selected_from_duplicate_id
        ) {
            $comparison =
                Ppks::find(
                    $ppks->selected_from_duplicate_id
                );
        }

        $ppks->update([
            'status' =>
                'perlu_diperiksa',

            'selected_for_assessment' =>
                false,

            'selected_from_duplicate_id' =>
                null,

            'duplicate_decision' =>
                null,
        ]);

        if ($comparison) {
            $comparison->update([
                'status' =>
                    'perlu_diperiksa',

                'selected_for_assessment' =>
                    false,

                'selected_from_duplicate_id' =>
                    null,

                'duplicate_decision' =>
                    null,
            ]);
        }

        return redirect()
            ->route(
                'ppks.perlu-diperiksa'
            )
            ->with(
                'success',
                'Data berhasil dikembalikan ke Data Pemeriksaan.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | IMPORT
    |--------------------------------------------------------------------------
    */

    public function import(): View
    {
        $totalImported =
            Ppks::count();

        $importLogs =
            ImportLog::query()
                ->orderBy(
                    'started_at',
                    'desc'
                )
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
