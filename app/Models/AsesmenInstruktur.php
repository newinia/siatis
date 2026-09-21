<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Ppks;
use App\Models\User;

class AsesmenInstruktur extends Model
{
    protected $table = 'asesmen_instrukturs';

    protected $fillable = [
        'ppks_id',
        'status_asesmen',
        'baznas',
        'gelombang',
        'tahun',
        'tanggal_asesmen_daring',
        'petugas_asesmen_instruktur',
        'hasil_asesmen_instruktur',
        'catatan_asesmen_instruktur',
        'asesmen_luring',
        'lokasi_asesmen_luring',
        'tanggal_asesmen_luring',
        'petugas_asesmen_luring',
        'hasil_asesmen_luring',
        'catatan_asesmen_luring',
        'diubah_oleh_id',
        'diubah_oleh',
    ];

    protected $casts = [
        'asesmen_luring' => 'boolean',
        'tanggal_asesmen_daring' => 'date',
        'tanggal_asesmen_luring' => 'date',
    ];

    public function ppks()
    {
        return $this->belongsTo(Ppks::class);
    }

    public function petugasInstruktur()
    {
        return $this->belongsTo(User::class, 'petugas_asesmen_instruktur');
    }

    public function petugasLuring()
    {
        return $this->belongsTo(User::class, 'petugas_asesmen_luring');
    }

    public function diubahOleh()
    {
        return $this->belongsTo(User::class, 'diubah_oleh_id');
    }
}
