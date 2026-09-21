<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KesehatanAwal extends Model
{
    protected $table = 'kesehatan_awals';

    protected $fillable = [
        'ppks_id',
        'tanggal_daring',
        'gelombang',
        'tahun',
        'petugas_kesehatan',
        'hasil_asesmen_kesehatan',
        'catatan_asesmen_kesehatan',
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
        'tanggal_daring' => 'date',
        'tanggal_asesmen_luring' => 'date',
        'asesmen_luring' => 'boolean',
    ];

    public function ppks()
    {
        return $this->belongsTo(Ppks::class);
    }

    public function petugasKesehatan()
    {
        return $this->belongsTo(User::class, 'petugas_kesehatan');
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
