<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ppks', function (Blueprint $table) {
            $table->boolean('selected_for_assessment')
                ->default(false)
                ->after('duplicate_note');

            $table->foreignId('selected_from_duplicate_id')
                ->nullable()
                ->after('selected_for_assessment')
                ->constrained('ppks')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('ppks', function (Blueprint $table) {
            $table->dropForeign([
                'selected_from_duplicate_id'
            ]);

            $table->dropColumn([
                'selected_for_assessment',
                'selected_from_duplicate_id',
            ]);
        });
    }
};
