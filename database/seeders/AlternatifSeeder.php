<?php

namespace Database\Seeders;

use App\Models\Alternatif;
use Illuminate\Database\Seeder;

class AlternatifSeeder extends Seeder
{
    public function run(): void
    {
        $alternatifs = [
            ['nama' => 'Web Developer', 'deskripsi' => 'Mengembangkan aplikasi dan situs web menggunakan teknologi frontend dan backend seperti HTML, CSS, JavaScript, PHP, dan framework modern.'],
            ['nama' => 'Mobile Developer', 'deskripsi' => 'Membangun aplikasi mobile untuk platform Android dan iOS menggunakan Kotlin, Swift, Flutter, atau React Native.'],
            ['nama' => 'Data Analyst', 'deskripsi' => 'Menganalisis data untuk menghasilkan insight bisnis menggunakan SQL, Python, Excel, dan tools visualisasi data.'],
            ['nama' => 'UI/UX Designer', 'deskripsi' => 'Merancang antarmuka dan pengalaman pengguna yang intuitif menggunakan Figma, Adobe XD, dan prinsip desain modern.'],
            ['nama' => 'Network Engineer', 'deskripsi' => 'Merancang, mengimplementasi, dan mengelola infrastruktur jaringan komputer perusahaan.'],
            ['nama' => 'Cyber Security', 'deskripsi' => 'Melindungi sistem dan jaringan dari ancaman keamanan siber, melakukan penetration testing dan audit keamanan.'],
            ['nama' => 'DevOps Engineer', 'deskripsi' => 'Mengelola infrastruktur cloud, CI/CD pipeline, dan otomatisasi deployment menggunakan Docker, Kubernetes, dan AWS/GCP.'],
            ['nama' => 'System Analyst', 'deskripsi' => 'Menganalisis kebutuhan bisnis dan merancang solusi sistem informasi yang efektif dan efisien.'],
        ];

        foreach ($alternatifs as $a) {
            Alternatif::updateOrCreate(['nama' => $a['nama']], $a);
        }
    }
}
