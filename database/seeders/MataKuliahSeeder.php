<?php

namespace Database\Seeders;

use App\Models\Kriteria;
use Illuminate\Database\Seeder;

class MataKuliahSeeder extends Seeder
{
    public function run(): void
    {
        $mataKuliah = [
            ['nama' => 'Pemrograman Web', 'kode' => 'MK01'],
            ['nama' => 'Pemrograman 1', 'kode' => 'MK02'],
            ['nama' => 'Pemrograman 2', 'kode' => 'MK03'],
            ['nama' => 'Praktik Pemrograman 1', 'kode' => 'MK04'],
            ['nama' => 'Praktik Pemrograman 2', 'kode' => 'MK05'],
            ['nama' => 'Struktur Data', 'kode' => 'MK06'],
            ['nama' => 'Basis Data', 'kode' => 'MK07'],
            ['nama' => 'Algoritma Pemrograman', 'kode' => 'MK08'],
            ['nama' => 'Pemrograman Visual', 'kode' => 'MK09'],
            ['nama' => 'Praktik Basis Data', 'kode' => 'MK10'],
            ['nama' => 'Matematika Diskrit', 'kode' => 'MK11'],
            ['nama' => 'Kalkulus Variabel Tunggal', 'kode' => 'MK12'],
            ['nama' => 'Kalkulus Variabel Jamak', 'kode' => 'MK13'],
            ['nama' => 'Vektor dan Matriks', 'kode' => 'MK14'],
            ['nama' => 'Jaringan Komputer', 'kode' => 'MK15'],
            ['nama' => 'Praktik Jaringan Komputer', 'kode' => 'MK16'],
            ['nama' => 'Komunikasi Data', 'kode' => 'MK17'],
            ['nama' => 'Praktik Komunikasi Data', 'kode' => 'MK18'],
            ['nama' => 'Sistem Operasi', 'kode' => 'MK19'],
            ['nama' => 'Teknologi Multimedia', 'kode' => 'MK20'],
            ['nama' => 'Logika', 'kode' => 'MK21'],
            ['nama' => 'Proyek Kewirausahaan', 'kode' => 'MK22'],
            ['nama' => 'Rekayasa Perangkat Lunak', 'kode' => 'MK23'],
        ];

        // Gunakan updateOrCreate agar aman (tidak hapus data existing)
        foreach ($mataKuliah as $mk) {
            Kriteria::updateOrCreate(
                ['kode' => $mk['kode']],
                [
                    'nama' => $mk['nama'],
                    'bobot' => 0,
                    'tipe' => 'benefit',
                ]
            );
        }
    }
}
