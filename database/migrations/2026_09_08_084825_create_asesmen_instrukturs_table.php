<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asesmen_instrukturs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('ppks_id')
                ->constrained('ppks')
                ->cascadeOnDelete();

            $table->string('status_asesmen')->nullable();

            $table->string('baznas')->nullable();
            $table->string('gelombang')->nullable();
            $table->string('tahun')->nullable();

            $table->date('tanggal_asesmen_daring')->nullable();

            $table->foreignId('petugas_asesmen_instruktur')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('hasil_asesmen_instruktur')->nullable();
            $table->text('catatan_asesmen_instruktur')->nullable();

            $table->boolean('asesmen_luring')->default(false);

            $table->string('lokasi_asesmen_luring')->nullable();
            $table->date('tanggal_asesmen_luring')->nullable();

            $table->foreignId('petugas_asesmen_luring')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('hasil_asesmen_luring')->nullable();
            $table->text('catatan_asesmen_luring')->nullable();

            // Audit perubahan
            $table->foreignId('diubah_oleh_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('diubah_oleh')->nullable();

            $table->timestamps();

            $table->unique('ppks_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asesmen_instrukturs');
    }
};
