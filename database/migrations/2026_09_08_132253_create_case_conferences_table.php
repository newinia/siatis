```php
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
        Schema::create('case_conferences', function (Blueprint $table) {
            $table->id();

            // Relasi ke data PPKS
            $table->foreignId('ppks_id')
                ->constrained('ppks')
                ->cascadeOnDelete();

            // Hasil Case Conference
            // diterima / tidak_diterima / pending
            $table->enum('hasil', [
                'diterima',
                'tidak_diterima',
                'pending',
            ])->nullable();

            // Jurusan yang diterima
            $table->string('jurusan_diterima')->nullable();

            // Tanggal pelaksanaan Case Conference
            $table->date('tanggal_case_conference')->nullable();

            // Gelombang dan tahun pelatihan
            $table->string('gelombang_pelatihan')->nullable();
            $table->string('tahun_pelatihan')->nullable();

            // Catatan hasil Case Conference
            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('case_conferences');
    }
};

