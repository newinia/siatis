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
        Schema::create('riwayat_pemeriksaans', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | DATA YANG DIPERIKSA
            |--------------------------------------------------------------------------
            */
            $table->foreignId('ppks_id')
                ->constrained('ppks')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | DATA PEMBANDING
            |--------------------------------------------------------------------------
            */
            $table->foreignId('comparison_id')
                ->nullable()
                ->constrained('ppks')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | KEPUTUSAN ADMIN
            |--------------------------------------------------------------------------
            */
            $table->enum('decision', [
                'pilih_data_ini',
                'pilih_data_pembanding',
                'bukan_duplikat',
                'dikembalikan',
            ]);

            /*
            |--------------------------------------------------------------------------
            | STATUS SEBELUM / SESUDAH
            |--------------------------------------------------------------------------
            */
            $table->string('status_sebelum')->nullable();
            $table->string('status_sesudah')->nullable();

            /*
            |--------------------------------------------------------------------------
            | SNAPSHOT SEBELUM KEPUTUSAN
            |
            | Ini penting supaya tombol Kembalikan benar-benar
            | mengembalikan kondisi data sebelum keputusan.
            |--------------------------------------------------------------------------
            */
            $table->json('ppks_before')->nullable();
            $table->json('comparison_before')->nullable();

            /*
            |--------------------------------------------------------------------------
            | ADMIN
            |--------------------------------------------------------------------------
            */
            $table->foreignId('decided_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | CATATAN
            |--------------------------------------------------------------------------
            */
            $table->text('catatan')->nullable();

            $table->timestamps();

            $table->index('ppks_id');
            $table->index('comparison_id');
            $table->index('decision');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_pemeriksaans');
    }
};
