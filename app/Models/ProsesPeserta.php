<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProsesPeserta extends Model
{
    use HasFactory;

    protected $fillable = [
        'peserta_id',
        'tahap',
        'status',
        'alasan_pending',
        'catatan',
        'tanggal_panggil_kembali',
        'tanggal_proses',
    ];

    protected $casts = [
        'tanggal_panggil_kembali' => 'date',
        'tanggal_proses' => 'datetime',
    ];

    /**
     * Peserta yang sedang menjalani proses ini.
     */
    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }
}
