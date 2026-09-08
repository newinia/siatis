<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CaseConference extends Model
{
    protected $fillable = [
        'ppks_id',
        'hasil',
        'jurusan_diterima',
        'tanggal_case_conference',
        'gelombang_pelatihan',
        'tahun_pelatihan',
        'catatan',
    ];

    protected $casts = [
        'tanggal_case_conference' => 'date',
    ];

    public function ppks(): BelongsTo
    {
        return $this->belongsTo(Ppks::class);
    }
}
