<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pesertas', function (Blueprint $table) {
            $table->id();

            // Identitas dari Google Form
            $table->dateTime('timestamp')->nullable();
            $table->string('nama_lengkap');
            $table->string('nik', 16)->unique();
            $table->string('jenis_kelamin')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->unsignedTinyInteger('usia')->nullable();

            // Alamat
            $table->text('alamat_lengkap')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kota_kabupaten')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kelurahan')->nullable();

            // Pendidikan
            $table->string('pendidikan_terakhir')->nullable();
            $table->text('keterangan_pendidikan')->nullable();

            // PPKS / Disabilitas
            $table->string('jenis_ppks')->nullable();
            $table->text('keterangan_disabilitas')->nullable();

            // Peminatan
            $table->string('jurusan_diminati')->nullable();
            $table->string('peminatan')->nullable();

            // Kontak
            $table->string('no_hp_1')->nullable();
            $table->string('no_hp_2')->nullable();
            $table->string('email')->nullable();

            // Informasi lainnya
            $table->text('pelatihan_kursus')->nullable();
            $table->text('kemampuan_baca_tulis')->nullable();
            $table->text('aktivitas_harian')->nullable();
            $table->string('bersedia_pelatihan')->nullable();
            $table->string('alumni_stis')->nullable();
            $table->text('kondisi_kesehatan')->nullable();

            // Nomor Kartu Keluarga
            $table->string('nomor_kk', 16)->nullable();

            // Berkas dari Google Form
            $table->text('upload_ktp')->nullable();
            $table->text('upload_kk')->nullable();
            $table->text('upload_ijazah')->nullable();
            $table->text('upload_foto_full_badan')->nullable();
            $table->text('upload_video')->nullable();
            $table->text('upload_transkrip')->nullable();

            // Status pelayanan awal
            $table->enum('status_pelayanan', [
                'belum_dilayani',
                'sudah_dilayani'
            ])->default('belum_dilayani');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesertas');
    }
};
