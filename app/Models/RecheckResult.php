<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecheckResult extends Model
{
    protected $fillable = [
        'ppks_id',
        'sheet_row',
        'data',
        'jenis',
        'status',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function ppks()
    {
        return $this->belongsTo(Ppks::class);
    }
}
