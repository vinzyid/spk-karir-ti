<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->json('saved_skills')->nullable()->after('remember_token');
            $table->unsignedBigInteger('saved_minat_1')->nullable()->after('saved_skills');
            $table->unsignedBigInteger('saved_minat_2')->nullable()->after('saved_minat_1');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['saved_skills', 'saved_minat_1', 'saved_minat_2']);
        });
    }
};
