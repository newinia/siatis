<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PemanggilanPeserta extends Model
{
    protected $table = 'pemanggilan_pesertas';

    protected $fillable = [
        'ppks_id',
        'status_pemanggilan',
        'tanggal_pemanggilan',
        'tanggal_kedatangan',
    ];

    protected $casts = [
        'tanggal_pemanggilan' => 'date',
        'tanggal_kedatangan' => 'date',
    ];

    public function ppks(): BelongsTo
    {
        return $this->belongsTo(
            Ppks::class,
            'ppks_id'
        );
    }
}