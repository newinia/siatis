<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('import_logs', function (Blueprint $table) {
            $table->id();

            $table->dateTime('started_at');
            $table->dateTime('finished_at')->nullable();

            $table->unsignedInteger('data_ditemukan')->default(0);
            $table->unsignedInteger('nik_unik')->default(0);
            $table->unsignedInteger('data_normal')->default(0);
            $table->unsignedInteger('data_perlu_diperiksa')->default(0);
            $table->unsignedInteger('data_diupdate')->default(0);

            $table->string('status')->default('proses');
            $table->text('message')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('import_logs');
    }
};
