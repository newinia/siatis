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
        Schema::create('kesehatan_awals', function (Blueprint $table) {
            $table->id();

            $table->foreignId('ppks_id')
                ->constrained('ppks')
                ->cascadeOnDelete();

            $table->date('tanggal_daring')->nullable();

            $table->string('gelombang')->nullable();
            $table->string('tahun')->nullable();

            $table->foreignId('petugas_kesehatan')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('hasil_asesmen_kesehatan')->nullable();

            $table->text('catatan_asesmen_kesehatan')->nullable();

            $table->boolean('asesmen_luring')->default(false);

            $table->string('lokasi_asesmen_luring')->nullable();

            $table->date('tanggal_asesmen_luring')->nullable();

            $table->foreignId('petugas_asesmen_luring')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('hasil_asesmen_luring')->nullable();

            $table->text('catatan_asesmen_luring')->nullable();

            $table->foreignId('diubah_oleh_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('diubah_oleh')->nullable();

            $table->timestamps();

            $table->unique('ppks_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kesehatan_awals');
    }
};
