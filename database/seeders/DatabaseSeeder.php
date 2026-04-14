<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            MataKuliahSeeder::class,  // Mata kuliah (kriteria)
            AlternatifSeeder::class,   // Karir
            BobotKarirSeeder::class,   // Bobot mata kuliah untuk setiap karir
        ]);
    }
}
