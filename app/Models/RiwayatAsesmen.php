<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatAsesmen extends Model
{
    use HasFactory;

    protected $fillable = [
        'peserta_id',
        'tahap',
        'hasil',
        'alasan_pending',
        'catatan',
        'petugas_id',
        'tanggal_asesmen',
        'tanggal_panggil_kembali',
    ];

    protected $casts = [
        'tanggal_asesmen' => 'datetime',
        'tanggal_panggil_kembali' => 'date',
    ];

    /**
     * Peserta yang menjalani asesmen.
     */
    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }

    /**
     * Petugas yang melakukan asesmen.
     */
    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }
}
