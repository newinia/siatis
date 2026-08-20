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
        Schema::create('proses_pesertas', function (Blueprint $table) {
            $table->id();

            // Hubungan dengan peserta
            $table->foreignId('peserta_id')
                ->constrained('pesertas')
                ->cascadeOnDelete();

            // Tahap proses peserta saat ini
            $table->enum('tahap', [
                'instruktur',
                'kesehatan_awal',
                'case_conference',
                'kesehatan_lanjutan',
                'aktif',
                'tidak_lolos'
            ])->default('instruktur');

            // Hasil pada tahap saat ini
            $table->enum('status', [
                'belum_dinilai',
                'lolos',
                'pending',
                'tidak_lolos'
            ])->default('belum_dinilai');

            // Khusus untuk pending / keterangan proses
            $table->text('alasan_pending')->nullable();
            $table->text('catatan')->nullable();

            // Jadwal pemanggilan kembali jika pending
            $table->date('tanggal_panggil_kembali')->nullable();

            // Waktu proses terakhir diperbarui
            $table->timestamp('tanggal_proses')->nullable();

            $table->timestamps();

            // Satu peserta hanya punya satu posisi proses aktif
            $table->unique('peserta_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proses_pesertas');
    }
};
