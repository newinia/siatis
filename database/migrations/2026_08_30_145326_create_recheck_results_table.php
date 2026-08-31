<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recheck_results', function (Blueprint $table) {
            $table->id();

            // Data PPKS yang dibandingkan
            $table->foreignId('ppks_id')
                ->nullable()
                ->constrained('ppks')
                ->nullOnDelete();

            // Baris terbaru dari Google Sheet
            $table->unsignedInteger('sheet_row');

            // Isi lengkap response Google Form
            $table->json('data');

            // Jenis temuan
            $table->string('jenis');

            // pending / diambil / diabaikan
            $table->string('status')->default('pending');

            $table->timestamps();

            $table->index('status');
            $table->index('sheet_row');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recheck_results');
    }
};
