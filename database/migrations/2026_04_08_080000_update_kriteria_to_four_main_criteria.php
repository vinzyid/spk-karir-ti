<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tidak perlu mengubah struktur tabel, hanya update data kriteria
        // Tabel nilai_mahasiswa tetap untuk nilai mata kuliah
        // Tabel bobot_karir tetap untuk bobot mata kuliah per karir
        
        // Tambah tabel untuk penilaian kriteria utama (Skill, Minat, Sertifikat)
        Schema::create('penilaian_kriteria', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('alternatif_id')->constrained('alternatifs')->onDelete('cascade');
            $table->decimal('skill_teknis', 5, 2); // 0-100
            $table->decimal('minat', 5, 2); // 0-100
            $table->decimal('sertifikat', 5, 2); // 0-100
            $table->timestamps();
            
            $table->unique(['user_id', 'alternatif_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penilaian_kriteria');
    }
};
