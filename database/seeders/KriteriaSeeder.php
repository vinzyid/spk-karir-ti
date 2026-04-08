<?php

namespace Database\Seeders;

use App\Models\Kriteria;
use Illuminate\Database\Seeder;

class KriteriaSeeder extends Seeder
{
    public function run(): void
    {
        $kriteria = [
            ['nama' => 'Nilai Akademik', 'kode' => 'C1', 'bobot' => 0.2507, 'tipe' => 'benefit'],
            ['nama' => 'Skill Teknis', 'kode' => 'C2', 'bobot' => 0.4967, 'tipe' => 'benefit'],
            ['nama' => 'Minat', 'kode' => 'C3', 'bobot' => 0.1027, 'tipe' => 'benefit'],
            ['nama' => 'Sertifikat', 'kode' => 'C4', 'bobot' => 0.1499, 'tipe' => 'benefit'],
        ];

        foreach ($kriteria as $k) {
            Kriteria::updateOrCreate(['kode' => $k['kode']], $k);
        }
    }
}
