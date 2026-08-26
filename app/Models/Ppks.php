<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

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
    ];

    protected $casts = [
        'data' => 'array',
        'imported_at' => 'datetime',
        'selected_for_assessment' => 'boolean',
    ];
}
