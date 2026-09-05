<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatPemeriksaan extends Model
{
    protected $table = 'riwayat_pemeriksaans';

    protected $fillable = [
        'ppks_id',
        'comparison_id',
        'decision',
        'status_sebelum',
        'status_sesudah',
        'ppks_before',
        'comparison_before',
        'decided_by',
        'catatan',
    ];

    protected $casts = [
        'ppks_before' => 'array',
        'comparison_before' => 'array',
    ];

    /**
     * Data PPKS yang diperiksa.
     */
    public function ppks(): BelongsTo
    {
        return $this->belongsTo(
            Ppks::class,
            'ppks_id'
        );
    }

    /**
     * Data pembanding.
     */
    public function comparison(): BelongsTo
    {
        return $this->belongsTo(
            Ppks::class,
            'comparison_id'
        );
    }

    /**
     * Admin yang melakukan keputusan.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'decided_by'
        );
    }
}
