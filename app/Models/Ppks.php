<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ppks extends Model
{
    protected $table = 'ppks';

    protected $fillable = [
        'sheet_row',
        'data',
        'status',
        'possible_duplicate_of',
        'duplicate_note',
        'imported_at',
        'selected_for_assessment',
        'selected_from_duplicate_id',
        'duplicate_decision',
        'created_by',
    ];

    protected $casts = [
        'data' => 'array',
        'imported_at' => 'datetime',
        'selected_for_assessment' => 'boolean',
    ];

    /**
     * =========================================================
     * PESERTA
     * =========================================================
     */
    public function peserta(): HasOne
    {
        return $this->hasOne(
            Peserta::class,
            'ppks_id'
        );
    }

    /**
     * =========================================================
     * ADMIN YANG MEMASUKKAN DATA
     * =========================================================
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'created_by'
        );
    }

    /**
     * =========================================================
     * TRACK RECORD PROSES
     * =========================================================
     */
    public function prosesPesertas(): HasMany
    {
        return $this->hasMany(
            ProsesPeserta::class,
            'ppks_id'
        );
    }
}
