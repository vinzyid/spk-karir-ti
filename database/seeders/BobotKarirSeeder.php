<?php

namespace Database\Seeders;

use App\Models\Alternatif;
use App\Models\BobotKarir;
use App\Models\Kriteria;
use Illuminate\Database\Seeder;

class BobotKarirSeeder extends Seeder
{
    public function run(): void
    {
        // Mapping nama mata kuliah ke ID (akan diambil dari database)
        $getMkId = function($nama) {
            return Kriteria::where('nama', $nama)->first()->id;
        };

        // Mapping nama alternatif ke ID
        $getAltId = function($nama) {
            return Alternatif::where('nama', $nama)->first()->id;
        };

        // Hapus data lama (gunakan delete instead of truncate)
        BobotKarir::query()->delete();

        // Data bobot sesuai dokumen (dengan mata kuliah yang sudah dipisah)
        $bobotData = [
            'Web Developer' => [
                'Pemrograman Web' => 40,
                'Pemrograman 1' => 7.5,
                'Pemrograman 2' => 7.5,
                'Praktik Pemrograman 1' => 7.5,
                'Praktik Pemrograman 2' => 7.5,
                'Struktur Data' => 10,
                'Basis Data' => 20,
            ],
            'Mobile Developer' => [
                'Pemrograman 1' => 12.5,
                'Pemrograman 2' => 12.5,
                'Praktik Pemrograman 1' => 10,
                'Praktik Pemrograman 2' => 10,
                'Struktur Data' => 10,
                'Algoritma Pemrograman' => 15,
                'Pemrograman Visual' => 30,
            ],
            'Data Analyst' => [
                'Basis Data' => 30,
                'Praktik Basis Data' => 20,
                'Matematika Diskrit' => 35,
                'Vektor dan Matriks' => 15,
            ],
            'Network Engineer' => [
                'Jaringan Komputer' => 30,
                'Praktik Jaringan Komputer' => 30,
                'Komunikasi Data' => 15,
                'Praktik Komunikasi Data' => 15,
                'Sistem Operasi' => 10,
            ],
            'UI/UX Designer' => [
                'Pemrograman Web' => 15,
                'Teknologi Multimedia' => 40,
                'Pemrograman Visual' => 20,
                'Logika' => 15,
                'Proyek Kewirausahaan' => 10,
            ],
            'QA Engineer' => [
                'Rekayasa Perangkat Lunak' => 40,
                'Pemrograman 1' => 7.5,
                'Pemrograman 2' => 7.5,
                'Struktur Data' => 10,
                'Logika' => 25,
                'Sistem Operasi' => 10,
            ],
            'Data Scientist' => [
                'Basis Data' => 25,
                'Vektor dan Matriks' => 15,
                'Kalkulus Variabel Tunggal' => 17.5,
                'Kalkulus Variabel Jamak' => 17.5,
                'Algoritma Pemrograman' => 20,
            ],
            'DevOps Engineer' => [
                'Sistem Operasi' => 35,
                'Jaringan Komputer' => 25,
                'Pemrograman 1' => 10,
                'Pemrograman 2' => 10,
                'Praktik Jaringan Komputer' => 10,
                'Komunikasi Data' => 10,
            ],
        ];

        foreach ($bobotData as $namaKarir => $bobotMk) {
            $alternatifId = $getAltId($namaKarir);
            
            foreach ($bobotMk as $namaMk => $bobot) {
                $kriteriaId = $getMkId($namaMk);
                
                BobotKarir::create([
                    'alternatif_id' => $alternatifId,
                    'kriteria_id' => $kriteriaId,
                    'bobot' => $bobot,
                ]);
            }
        }
    }
}
