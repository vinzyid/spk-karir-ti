<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bobot_karir', function (Blueprint $table) {
            // ID pasangan MK (misal Pemro 1 → Pemro 2), null jika tidak berpasangan
            $table->unsignedBigInteger('pasangan_kriteria_id')->nullable()->after('bobot');
        });
    }

    public function down(): void
    {
        Schema::table('bobot_karir', function (Blueprint $table) {
            $table->dropColumn('pasangan_kriteria_id');
        });
    }
};
