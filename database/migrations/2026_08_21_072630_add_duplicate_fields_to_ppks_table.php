<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ppks', function (Blueprint $table) {
            // Status data
            $table->string('status')
                ->default('normal')
                ->after('data');

            // Menyimpan ID data yang kemungkinan merupakan orang yang sama
            $table->unsignedBigInteger('possible_duplicate_of')
                ->nullable()
                ->after('status');

            // Menyimpan alasan kenapa ditandai
            $table->text('duplicate_note')
                ->nullable()
                ->after('possible_duplicate_of');
        });
    }

    public function down(): void
    {
        Schema::table('ppks', function (Blueprint $table) {
            $table->dropColumn([
                'status',
                'possible_duplicate_of',
                'duplicate_note',
            ]);
        });
    }
};
