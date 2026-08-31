<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pesertas', function (Blueprint $table) {
            $table->foreignId('ppks_id')
                ->nullable()
                ->after('id')
                ->constrained('ppks')
                ->nullOnDelete();

            $table->unique('ppks_id');
        });
    }

    public function down(): void
    {
        Schema::table('pesertas', function (Blueprint $table) {
            $table->dropForeign(['ppks_id']);
            $table->dropUnique(['pesertas_ppks_id_unique']);
            $table->dropColumn('ppks_id');
        });
    }
};
