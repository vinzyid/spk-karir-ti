<?php

namespace Database\Seeders;

use App\Models\Alternatif;
use App\Models\BobotKarir;
use App\Models\Kriteria;
use Illuminate\Database\Seeder;

class BobotKarirSeeder extends Seeder
{
    /**
     * Bobot per mata kuliah (atau pasangan MK).
     *
     * Untuk MK berpasangan (Pemrograman 1 & 2), bobot diisi PENUH di masing-masing
     * karena service akan mengambil rata-rata nilainya sebelum mengalikan bobot.
     *
     * Contoh: Pemro 1 = 15%, Pemro 2 = 15%
     * → Service: rata_rata(nilai_Pemro1, nilai_Pemro2) × 15%
     * → Hasilnya sama dengan (nilai_Pemro1×15% + nilai_Pemro2×15%) / 2
     */
    public function run(): void
    {
        $getMkId  = fn($nama) => Kriteria::where('nama', $nama)->first()?->id;
        $getAltId = fn($nama) => Alternatif::where('nama', $nama)->first()?->id;

        BobotKarir::query()->delete();

        // ------------------------------------------------------------
        // PASANGAN MK (bobot penuh, nilai akan di-rata-rata di service):
        //   Pemrograman 1 & 2              → pasangan
        //   Praktik Pemrograman 1 & 2      → pasangan
        //   Kalkulus Variabel Tunggal & Jamak → pasangan
        //   Jaringan Komputer & Praktik Jaringan Komputer → masing-masing punya bobot sendiri (tidak rata-rata)
        //   Komunikasi Data & Praktik Komunikasi Data     → masing-masing punya bobot sendiri
        // ------------------------------------------------------------

        $bobotData = [

            // ─────────────────────────────
            // A1 – Web Developer
            // Pemrograman Web 40%
            // Pemrograman 1 & 2 15%  → rata-rata nilai Pemro1 & Pemro2 × 15%
            // Praktik Pemrograman 1 & 2 15% → rata-rata nilai PrakPemro1 & PrakPemro2 × 15%
            // Struktur Data 10%
            // Basis Data 20%
            // ─────────────────────────────
            'Web Developer' => [
                'Pemrograman Web'        => ['bobot' => 40, 'pasangan' => null],
                'Pemrograman 1'          => ['bobot' => 15, 'pasangan' => 'Pemrograman 2'],
                'Praktik Pemrograman 1'  => ['bobot' => 15, 'pasangan' => 'Praktik Pemrograman 2'],
                'Struktur Data'          => ['bobot' => 10, 'pasangan' => null],
                'Basis Data'             => ['bobot' => 20, 'pasangan' => null],
            ],

            // ─────────────────────────────
            // A2 – Mobile Developer
            // Pemrograman 1 & 2 25%  → rata-rata × 25%
            // Praktik Pemrograman 1 & 2 20% → rata-rata × 20%
            // Struktur Data 10%
            // Algoritma Pemrograman 15%
            // Pemrograman Visual 30%
            // ─────────────────────────────
            'Mobile Developer' => [
                'Pemrograman 1'         => ['bobot' => 25, 'pasangan' => 'Pemrograman 2'],
                'Praktik Pemrograman 1' => ['bobot' => 20, 'pasangan' => 'Praktik Pemrograman 2'],
                'Struktur Data'         => ['bobot' => 10, 'pasangan' => null],
                'Algoritma Pemrograman' => ['bobot' => 15, 'pasangan' => null],
                'Pemrograman Visual'    => ['bobot' => 30, 'pasangan' => null],
            ],

            // ─────────────────────────────
            // A3 – Data Analyst
            // Basis Data 30%
            // Praktik Basis Data 20%
            // Matematika Diskrit / Kalkulus Tunggal & Jamak 35% → rata-rata × 35%
            // Vektor dan Matriks 15%
            // ─────────────────────────────
            'Data Analyst' => [
                'Basis Data'                => ['bobot' => 30, 'pasangan' => null],
                'Praktik Basis Data'        => ['bobot' => 20, 'pasangan' => null],
                'Kalkulus Variabel Tunggal' => ['bobot' => 35, 'pasangan' => 'Kalkulus Variabel Jamak'],
                'Vektor dan Matriks'        => ['bobot' => 15, 'pasangan' => null],
            ],

            // ─────────────────────────────
            // A4 – Network Engineer
            // Jaringan Komputer 30%
            // Praktik Jaringan Komputer 30%
            // Komunikasi Data 15%
            // Praktik Komunikasi Data 15%
            // Sistem Operasi 10%
            // ─────────────────────────────
            'Network Engineer' => [
                'Jaringan Komputer'         => ['bobot' => 30, 'pasangan' => null],
                'Praktik Jaringan Komputer' => ['bobot' => 30, 'pasangan' => null],
                'Komunikasi Data'           => ['bobot' => 15, 'pasangan' => null],
                'Praktik Komunikasi Data'   => ['bobot' => 15, 'pasangan' => null],
                'Sistem Operasi'            => ['bobot' => 10, 'pasangan' => null],
            ],

            // ─────────────────────────────
            // A5 – UI/UX Designer
            // Pemrograman Web 15%
            // Teknologi Multimedia 40%
            // Pemrograman Visual 20%
            // Logika 15%
            // Proyek Kewirausahaan 10%
            // ─────────────────────────────
            'UI/UX Designer' => [
                'Pemrograman Web'       => ['bobot' => 15, 'pasangan' => null],
                'Teknologi Multimedia'  => ['bobot' => 40, 'pasangan' => null],
                'Pemrograman Visual'    => ['bobot' => 20, 'pasangan' => null],
                'Logika'                => ['bobot' => 15, 'pasangan' => null],
                'Proyek Kewirausahaan'  => ['bobot' => 10, 'pasangan' => null],
            ],

            // ─────────────────────────────
            // A6 – QA Engineer
            // Rekayasa Perangkat Lunak 40%
            // Pemrograman 1 & 2 15% → rata-rata × 15%
            // Struktur Data 10%
            // Logika 25%
            // Sistem Operasi 10%
            // ─────────────────────────────
            'QA Engineer' => [
                'Rekayasa Perangkat Lunak' => ['bobot' => 40, 'pasangan' => null],
                'Pemrograman 1'            => ['bobot' => 15, 'pasangan' => 'Pemrograman 2'],
                'Struktur Data'            => ['bobot' => 10, 'pasangan' => null],
                'Logika'                   => ['bobot' => 25, 'pasangan' => null],
                'Sistem Operasi'           => ['bobot' => 10, 'pasangan' => null],
            ],

            // ─────────────────────────────
            // A7 – Data Scientist
            // Basis Data 25%
            // Vektor dan Matriks 15%
            // Kalkulus Tunggal & Jamak 35% → rata-rata × 35%
            // Algoritma Pemrograman 20%
            // Matematika Diskrit 5%
            // ─────────────────────────────
            'Data Scientist' => [
                'Basis Data'                => ['bobot' => 25, 'pasangan' => null],
                'Vektor dan Matriks'        => ['bobot' => 15, 'pasangan' => null],
                'Kalkulus Variabel Tunggal' => ['bobot' => 35, 'pasangan' => 'Kalkulus Variabel Jamak'],
                'Algoritma Pemrograman'     => ['bobot' => 20, 'pasangan' => null],
                'Matematika Diskrit'        => ['bobot' =>  5, 'pasangan' => null],
            ],

            // ─────────────────────────────
            // A8 – DevOps Engineer
            // Sistem Operasi 35%
            // Jaringan Komputer 25%
            // Pemrograman 1 & 2 20% → rata-rata × 20%
            // Praktik Jaringan Komputer 10%
            // Komunikasi Data 10%
            // ─────────────────────────────
            'DevOps Engineer' => [
                'Sistem Operasi'            => ['bobot' => 35, 'pasangan' => null],
                'Jaringan Komputer'         => ['bobot' => 25, 'pasangan' => null],
                'Pemrograman 1'             => ['bobot' => 20, 'pasangan' => 'Pemrograman 2'],
                'Praktik Jaringan Komputer' => ['bobot' => 10, 'pasangan' => null],
                'Komunikasi Data'           => ['bobot' => 10, 'pasangan' => null],
            ],
        ];

        foreach ($bobotData as $namaKarir => $bobotMk) {
            $alternatifId = $getAltId($namaKarir);
            if (!$alternatifId) continue;

            foreach ($bobotMk as $namaMk => $config) {
                $kriteriaId = $getMkId($namaMk);
                if (!$kriteriaId) continue;

                // Nama pasangan (null jika tidak ada)
                $pasanganId = $config['pasangan']
                    ? ($getMkId($config['pasangan']) ?? null)
                    : null;

                BobotKarir::updateOrCreate(
                    ['alternatif_id' => $alternatifId, 'kriteria_id' => $kriteriaId],
                    ['bobot' => $config['bobot'], 'pasangan_kriteria_id' => $pasanganId]
                );
            }
        }
    }
}
