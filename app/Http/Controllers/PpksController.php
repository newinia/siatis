<?php

namespace App\Http\Controllers;

use App\Models\Ppks;
use App\Models\ProsesPeserta;
use App\Models\ImportLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PpksController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | SEMUA DATA PPKS
    |--------------------------------------------------------------------------
    */

    public function index(Request $request): View
    {
        $query = Ppks::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('sheet_row', 'like', "%{$search}%")
                    ->orWhere('data->nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('data->nik', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $ppks = $query
            ->orderByRaw('sheet_row IS NULL ASC')
            ->orderByDesc('sheet_row')
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return view('ppks.index', compact('ppks'));
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
            ->with('success', 'Pengecekan ulang data berhasil.');
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
                    $query->orderByDesc('tanggal_proses')
                        ->orderByDesc('created_at');
                }
            ]);

        $this->applySearch($query, $request);

        $ppks = $query
            ->orderByRaw('sheet_row IS NULL ASC')
            ->orderByDesc('sheet_row')
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return view(
            'ppks.normal',
            compact('ppks')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | RECORD DATA NORMAL / DATA MANUAL
    |--------------------------------------------------------------------------
    */

    public function normalRecord(Request $request): View
    {
        return $this->manual($request);
    }


    /*
    |--------------------------------------------------------------------------
    | BELUM DIMULAI
    |--------------------------------------------------------------------------
    |
    | Data Normal yang belum memiliki proses asesmen sama sekali.
    |
    */

    public function belumDimulai(Request $request): View
    {
        $query = Ppks::query()
            ->where('status', 'normal')
            ->whereDoesntHave('prosesPesertas');

        $this->applySearch($query, $request);

        $ppks = $query
            ->orderByRaw('sheet_row IS NULL ASC')
            ->orderByDesc('sheet_row')
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return view(
            'ppks.normal',
            compact('ppks')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ASESMEN INSTRUKTUR
    |--------------------------------------------------------------------------
    |
    | SEMUA DATA NORMAL masuk ke sini.
    |
    */

    public function asesmenInstruktur(Request $request): View
    {
        return $this->dataTahap(
            $request,
            'instruktur'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ASESMEN KESEHATAN AWAL
    |--------------------------------------------------------------------------
    |
    | HANYA DATA YANG LULUS INSTRUKTUR.
    |
    */

    public function asesmenKesehatan(Request $request): View
    {
        return $this->dataTahap(
            $request,
            'kesehatan_awal'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CASE CONFERENCE
    |--------------------------------------------------------------------------
    |
    | HANYA DATA YANG LULUS KESEHATAN AWAL.
    |
    */

    public function caseConference(Request $request): View
    {
        return $this->dataTahap(
            $request,
            'case_conference'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DATA BERDASARKAN TAHAP
    |--------------------------------------------------------------------------
    */

    private function dataTahap(
        Request $request,
        string $tahap
    ): View {

        $query = Ppks::query()
            ->where('status', 'normal');


        /*
        |--------------------------------------------------------------------------
        | INSTRUKTUR
        |--------------------------------------------------------------------------
        |
        | Semua Data Normal masuk.
        |
        */

        if ($tahap === 'instruktur') {

            // Tidak perlu syarat proses.
            // Semua data normal tampil.

        }


        /*
        |--------------------------------------------------------------------------
        | KESEHATAN AWAL
        |--------------------------------------------------------------------------
        |
        | Hanya yang sudah LULUS instruktur.
        |
        */

        elseif ($tahap === 'kesehatan_awal') {

            $query->whereHas(
                'prosesPesertas',
                function ($q) {

                    $q->where('tahap', 'instruktur')
                        ->where('status', 'lulus');

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | CASE CONFERENCE
        |--------------------------------------------------------------------------
        |
        | Hanya yang sudah LULUS kesehatan awal.
        |
        */

        elseif ($tahap === 'case_conference') {

            $query->whereHas(
                'prosesPesertas',
                function ($q) {

                    $q->where('tahap', 'kesehatan_awal')
                        ->where('status', 'lulus');

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | FILTER HASIL
        |--------------------------------------------------------------------------
        |
        | Data Lulus / Pending / Tidak Lulus.
        |
        */

        if ($request->filled('hasil')) {

            $hasil = $request->hasil;

            $query->whereHas(
                'prosesPesertas',
                function ($q) use ($tahap, $hasil) {

                    $q->where('tahap', $tahap)
                        ->where('status', $hasil);

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | LOAD PROSES TAHAP
        |--------------------------------------------------------------------------
        */

        $query->with([
            'prosesPesertas' => function ($q) use ($tahap) {

                $q->where('tahap', $tahap)
                    ->orderByDesc('tanggal_proses')
                    ->orderByDesc('created_at');

            }
        ]);


        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        $this->applySearch(
            $query,
            $request
        );


        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        */

        $ppks = $query
            ->orderByRaw('sheet_row IS NULL ASC')
            ->orderByDesc('sheet_row')
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();


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
    | SEARCH
    |--------------------------------------------------------------------------
    */

    private function applySearch(
        $query,
        Request $request
    ): void {

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where(
                    'data->nama_lengkap',
                    'like',
                    "%{$search}%"
                )
                    ->orWhere(
                        'data->nik',
                        'like',
                        "%{$search}%"
                    )
                    ->orWhere(
                        'data->jenis_ppks',
                        'like',
                        "%{$search}%"
                    );

            });
        }
    }


    /*
    |--------------------------------------------------------------------------
    | DATA DITERIMA
    |--------------------------------------------------------------------------
    */

    public function diterima(Request $request): View
    {
        $query = Ppks::query()
            ->where('status', 'diterima');

        $this->applySearch(
            $query,
            $request
        );

        $ppks = $query
            ->orderByDesc('updated_at')
            ->paginate(15)
            ->withQueryString();

        return view(
            'ppks.normal',
            compact('ppks')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DATA TIDAK DITERIMA
    |--------------------------------------------------------------------------
    */

    public function tidakDiterima(Request $request): View
    {
        $query = Ppks::query()
            ->where('status', 'tidak_diterima');

        $this->applySearch(
            $query,
            $request
        );

        $ppks = $query
            ->orderByDesc('updated_at')
            ->paginate(15)
            ->withQueryString();

        return view(
            'ppks.normal',
            compact('ppks')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DATA MANUAL
    |--------------------------------------------------------------------------
    */

    public function manual(Request $request): View
    {
        $query = Ppks::query()
            ->where('status', 'normal')
            ->where('data->sumber_data', 'manual')
            ->with('createdBy');

        $this->applySearch(
            $query,
            $request
        );

        $ppks = $query
            ->orderByDesc('created_at')
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
            ->whereIn('role', [
                'super_admin',
                'medis',
                'instruktur',
            ])
            ->where('status', 'approved')
            ->orderBy('name', 'asc')
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

    public function storeNormal(Request $request)
    {
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
                'max:5120',
            ],

            'upload_kk' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:5120',
            ],

            'upload_ijazah_terakhir' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:5120',
            ],

            'upload_foto_full_badan' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png',
                'max:5120',
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
                'max:5120',
            ],

        ]);


        $admin = User::query()
            ->whereIn('role', [
                'super_admin',
                'medis',
                'instruktur',
            ])
            ->where('status', 'approved')
            ->findOrFail(
                $validated['diinput_oleh']
            );


        $data = $validated;

        unset(
            $data['diinput_oleh']
        );


        $data['timestamp'] =
            now()->format('Y-m-d H:i:s');

        $data['sumber_data'] =
            'manual';

        $data['dimasukkan_oleh_id'] =
            $admin->id;

        $data['dimasukkan_oleh'] =
            $admin->name;


        /*
        |--------------------------------------------------------------------------
        | FILE
        |--------------------------------------------------------------------------
        */

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

                unset($data[$field]);

            }
        }


        /*
        |--------------------------------------------------------------------------
        | SHEET ROW
        |--------------------------------------------------------------------------
        */

        $lastSheetRow =
            Ppks::max('sheet_row');

        $nextSheetRow =
            max(
                1,
                (int) $lastSheetRow
            ) + 1;


        /*
        |--------------------------------------------------------------------------
        | SIMPAN
        |--------------------------------------------------------------------------
        */

        Ppks::create([

            'sheet_row' =>
                $nextSheetRow,

            'data' =>
                $data,

            'status' =>
                'normal',

            'selected_for_assessment' =>
                false,

            'selected_from_duplicate_id' =>
                null,

            'possible_duplicate_of' =>
                null,

            'duplicate_note' =>
                null,

            'duplicate_decision' =>
                null,

            'created_by' =>
                auth()->id(),

            'imported_at' =>
                now(),

        ]);


        return redirect()
            ->route('ppks.manual')
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
            !== 'manual'
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
            !== 'manual'
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

            'email' => [
                'nullable',
                'email',
                'max:255',
            ],

            'no_hp_2' => [
                'nullable',
                'string',
                'max:30',
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
                'max:5120',
            ],

            'upload_kk' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:5120',
            ],

            'upload_ijazah_terakhir' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:5120',
            ],

            'upload_foto_full_badan' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png',
                'max:5120',
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
                'max:5120',
            ],

        ]);


        $data =
            $ppks->data ?? [];


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


        /*
        |--------------------------------------------------------------------------
        | FILE
        |--------------------------------------------------------------------------
        */

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

            if (
                $request->hasFile($field)
            ) {

                $oldFile =
                    $data[$field] ?? null;


                if (
                    $oldFile &&
                    !filter_var(
                        $oldFile,
                        FILTER_VALIDATE_URL
                    )
                ) {

                    Storage::disk('public')
                        ->delete($oldFile);

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


        /*
        |--------------------------------------------------------------------------
        | METADATA
        |--------------------------------------------------------------------------
        */

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
            auth()->user()->name;


        $ppks->update([
            'data' => $data,
        ]);


        return redirect()
            ->route('ppks.manual')
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
            !== 'manual'
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
                $ppks->data[$field] ?? null;


            if (
                $file &&
                !filter_var(
                    $file,
                    FILTER_VALIDATE_URL
                )
            ) {

                Storage::disk('public')
                    ->delete($file);

            }

        }


        /*
        |--------------------------------------------------------------------------
        | HAPUS PROSES
        |--------------------------------------------------------------------------
        */

        $ppks
            ->prosesPesertas()
            ->delete();


        /*
        |--------------------------------------------------------------------------
        | HAPUS PESERTA
        |--------------------------------------------------------------------------
        */

        if ($ppks->peserta) {

            $ppks
                ->peserta()
                ->delete();

        }


        $ppks->delete();


        return redirect()
            ->route('ppks.manual')
            ->with(
                'success',
                'Data PPKS berhasil dihapus.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | PILIH DATA DARI PEMERIKSAAN
    |--------------------------------------------------------------------------
    */

    public function pilih(
        Ppks $ppks
    ) {

        $ppks->update([

            'status' =>
                'normal',

            'selected_for_assessment' =>
                true,

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
    |
    | Tahap ditentukan dari form/button.
    |
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
        | INSTRUKTUR
        |--------------------------------------------------------------------------
        */

        if (
            $tahap ===
            'instruktur'
        ) {

            if (
                $ppks->status !==
                'normal'
            ) {

                return back()->with(
                    'error',
                    'Data belum berstatus normal.'
                );

            }

        }


        /*
        |--------------------------------------------------------------------------
        | KESEHATAN AWAL
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
        | CASE CONFERENCE
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
        | CARI PROSES TAHAP
        |--------------------------------------------------------------------------
        */

        $proses =
            ProsesPeserta::where(
                'ppks_id',
                $ppks->id
            )
            ->where(
                'tahap',
                $tahap
            )
            ->first();


        /*
        |--------------------------------------------------------------------------
        | JIKA SUDAH ADA
        |--------------------------------------------------------------------------
        */

        if ($proses) {

            if (
                $proses->status ===
                'pending'
            ) {

                $proses->update([

                    'status' =>
                        'sedang_diperiksa',

                    'tanggal_proses' =>
                        now(),

                ]);


                return back()->with(
                    'success',
                    'Asesmen dilanjutkan kembali.'
                );

            }


            return back()->with(
                'error',
                'Tahap ini sudah memiliki hasil.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | BUAT PROSES
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
    | HASIL ASESMEN
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


        /*
        |--------------------------------------------------------------------------
        | NORMALISASI TAHAP
        |--------------------------------------------------------------------------
        */

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
        | CARI PROSES
        |--------------------------------------------------------------------------
        */

        $proses =
            ProsesPeserta::where(
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


        /*
        |--------------------------------------------------------------------------
        | HARUS SEDANG DIPERIKSA
        |--------------------------------------------------------------------------
        */

        if (
            $proses->status !==
            'sedang_diperiksa'
        ) {

            return back()->with(
                'error',
                'Tahap ini sudah memiliki hasil.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | SIMPAN HASIL
        |--------------------------------------------------------------------------
        */

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
                now(),

        ]);


        /*
        |--------------------------------------------------------------------------
        | TIDAK LULUS
        |--------------------------------------------------------------------------
        */

        if (
            $request->status ===
            'tidak_lulus'
        ) {

            $ppks->update([
                'status' =>
                    'tidak_diterima',
            ]);


            return back()->with(
                'success',
                'Peserta dinyatakan Tidak Lulus.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | PENDING
        |--------------------------------------------------------------------------
        */

        if (
            $request->status ===
            'pending'
        ) {

            return back()->with(
                'success',
                'Peserta ditetapkan sebagai Pending.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | LULUS
        |--------------------------------------------------------------------------
        |
        | TIDAK membuat proses tahap berikutnya.
        |
        */

        if (
            $request->status ===
            'lulus'
        ) {

            if (
                $tahapSekarang ===
                'instruktur'
            ) {

                return back()->with(
                    'success',
                    'Asesmen Instruktur Lulus. Peserta masuk ke Asesmen Kesehatan Awal.'
                );

            }


            if (
                $tahapSekarang ===
                'kesehatan_awal'
            ) {

                return back()->with(
                    'success',
                    'Asesmen Kesehatan Awal Lulus. Peserta masuk ke Case Conference.'
                );

            }


            if (
                $tahapSekarang ===
                'case_conference'
            ) {

                $ppks->update([
                    'status' =>
                        'diterima',
                ]);


                return back()->with(
                    'success',
                    'Case Conference Lulus. Peserta dinyatakan DITERIMA.'
                );

            }

        }


        return back();
    }


    /*
    |--------------------------------------------------------------------------
    | KEMBALIKAN DATA KE PEMERIKSAAN
    |--------------------------------------------------------------------------
    */

    public function kembalikan(
        Ppks $ppks
    ) {

        $comparison = null;


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
    | HALAMAN IMPORT
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
