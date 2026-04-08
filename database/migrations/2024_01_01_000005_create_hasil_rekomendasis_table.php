<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hasil_rekomendasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained()->onDelete('cascade');
            $table->foreignId('alternatif_id')->constrained()->onDelete('cascade');
            $table->decimal('skor', 10, 6);
            $table->integer('ranking');
            $table->timestamps();

            $table->unique(['mahasiswa_id', 'alternatif_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hasil_rekomendasis');
    }
};
