<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    use HasFactory;

    protected $fillable = [
        'ppks_id',
        'timestamp',
        'nama_lengkap',
        'nik',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'usia',
        'alamat_lengkap',
        'provinsi',
        'kota_kabupaten',
        'kecamatan',
        'kelurahan',
        'pendidikan_terakhir',
        'keterangan_pendidikan',
        'jenis_ppks',
        'keterangan_disabilitas',
        'jurusan_diminati',
        'peminatan',
        'no_hp_1',
        'no_hp_2',
        'email',
        'pelatihan_kursus',
        'kemampuan_baca_tulis',
        'aktivitas_harian',
        'bersedia_pelatihan',
        'alumni_stis',
        'kondisi_kesehatan',
        'nomor_kk',
        'upload_ktp',
        'upload_kk',
        'upload_ijazah',
        'upload_foto_full_badan',
        'upload_video',
        'upload_transkrip',
        'status_pelayanan',
    ];

    protected $casts = [
        'timestamp' => 'datetime',
        'tanggal_lahir' => 'date',
    ];


    /**
     * PPKS asal peserta.
     */
    public function ppks()
    {
        return $this->belongsTo(
            Ppks::class,
            'ppks_id'
        );
    }


    /**
     * Semua track record proses.
     */
    public function proses()
    {
        return $this->hasMany(
            ProsesPeserta::class,
            'peserta_id'
        );
    }


    /**
     * Semua riwayat asesmen.
     */
    public function riwayatAsesmen()
    {
        return $this->hasMany(
            RiwayatAsesmen::class,
            'peserta_id'
        );
    }
}
