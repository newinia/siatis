<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_asesmens', function (Blueprint $table) {
            $table->id();

            // Peserta yang menjalani asesmen
            $table->foreignId('peserta_id')
                ->constrained('pesertas')
                ->cascadeOnDelete();

            // Tahap asesmen
            $table->enum('tahap', [
                'instruktur',
                'kesehatan_awal',
                'case_conference',
                'kesehatan_lanjutan'
            ]);

            // Hasil asesmen
            $table->enum('hasil', [
                'lolos',
                'pending',
                'tidak_lolos'
            ]);

            // Alasan jika pending
            $table->text('alasan_pending')->nullable();

            // Catatan dari petugas
            $table->text('catatan')->nullable();

            // Petugas yang melakukan asesmen
            $table->foreignId('petugas_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Tanggal asesmen
            $table->dateTime('tanggal_asesmen')->nullable();

            // Jika pending dan perlu dipanggil kembali
            $table->date('tanggal_panggil_kembali')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_asesmens');
    }
};
