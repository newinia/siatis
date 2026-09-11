<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KesehatanLanjutan extends Model
{
    use HasFactory;

    protected $table = 'kesehatan_lanjutans';

    protected $fillable = [
        'ppks_id',
        'tanggal_asesmen',
        'gelombang',
        'tahun',
        'petugas_kesehatan',
        'hasil_asesmen',
        'status_asesmen_psikologi',
        'status_asesmen_fisioterapis',
        'catatan_asesmen',
        'hasil_akhir',
    ];

    protected $casts = [
        'tanggal_asesmen' => 'date',
        'tahun' => 'integer',
    ];

    /**
     * Relasi ke data PPKS
     */
    public function ppks(): BelongsTo
    {
        return $this->belongsTo(Ppks::class, 'ppks_id');
    }
}