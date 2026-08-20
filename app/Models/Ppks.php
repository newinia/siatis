<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ppks extends Model
{
    protected $table = 'ppks';

    protected $fillable = [
        'sheet_row',
        'data',
        'imported_at',
    ];

    protected $casts = [
        'data' => 'array',
        'imported_at' => 'datetime',
    ];
}
