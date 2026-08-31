<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProsesPeserta extends Model
{
    use HasFactory;

    protected $table = 'proses_pesertas';

    protected $fillable = [
        'ppks_id',
        'tahap',
        'status',
        'alasan_pending',
        'catatan',
        'tanggal_panggil_kembali',
        'tanggal_proses',
    ];

    protected $casts = [
        'tanggal_proses' => 'datetime',
        'tanggal_panggil_kembali' => 'date',
    ];

    /**
     * PPKS yang menjalani proses.
     */
    public function ppks()
    {
        return $this->belongsTo(Ppks::class, 'ppks_id');
    }
}
