<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImportLog extends Model
{
    protected $table = 'import_logs';

    protected $fillable = [
        'started_at',
        'finished_at',
        'data_ditemukan',
        'nik_unik',
        'data_normal',
        'data_perlu_diperiksa',
        'data_diupdate',
        'status',
        'message',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
    ];
}
