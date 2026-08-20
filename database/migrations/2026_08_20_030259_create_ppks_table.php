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
        Schema::create('ppks', function (Blueprint $table) {
            $table->id();

            // Identitas baris dari Google Sheets
            $table->unsignedBigInteger('sheet_row')->unique();

            // Menyimpan seluruh data 1 baris dalam bentuk JSON
            $table->json('data');

            // Waktu data diambil dari Google Sheets
            $table->timestamp('imported_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ppks');
    }
};
