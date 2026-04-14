<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel untuk menyimpan nilai mahasiswa per mata kuliah
        Schema::create('nilai_mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('kriteria_id')->constrained('kriteria')->onDelete('cascade');
            $table->decimal('nilai', 5, 2); // Nilai 0-100
            $table->timestamps();
            
            $table->unique(['user_id', 'kriteria_id']);
        });

        // Tabel untuk menyimpan bobot setiap mata kuliah untuk setiap karir
        Schema::create('bobot_karir', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alternatif_id')->constrained('alternatifs')->onDelete('cascade');
            $table->foreignId('kriteria_id')->constrained('kriteria')->onDelete('cascade');
            $table->decimal('bobot', 5, 2); // Bobot dalam persen (0-100)
            $table->timestamps();
            
            $table->unique(['alternatif_id', 'kriteria_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bobot_karir');
        Schema::dropIfExists('nilai_mahasiswa');
    }
};
