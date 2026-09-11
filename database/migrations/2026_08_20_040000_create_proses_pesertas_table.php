<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proses_pesertas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('ppks_id')
                ->constrained('ppks')
                ->cascadeOnDelete();

            $table->enum('tahap', [
                'instruktur',
                'kesehatan_awal',
                'case_conference',
                'kesehatan_lanjutan',
                'aktif',
                'tidak_lolos',
            ])->default('instruktur');

            $table->enum('status', [
                'sedang_diperiksa',
                'lolos',
                'pending',
                'tidak_lolos',
            ])->default('sedang_diperiksa');

            $table->text('alasan_pending')->nullable();

            $table->text('catatan')->nullable();

            $table->date('tanggal_panggil_kembali')->nullable();

            $table->timestamp('tanggal_proses')->nullable();

            $table->timestamps();

            /*
             * Satu PPKS hanya satu record
             * untuk setiap tahap.
             */
            $table->unique([
                'ppks_id',
                'tahap',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proses_pesertas');
    }
};
