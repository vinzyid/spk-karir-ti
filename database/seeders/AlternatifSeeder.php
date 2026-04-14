<?php

namespace Database\Seeders;

use App\Models\Alternatif;
use Illuminate\Database\Seeder;

class AlternatifSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus data lama (gunakan delete instead of truncate)
        Alternatif::query()->delete();
        
        $alternatifs = [
            ['nama' => 'Web Developer', 'deskripsi' => 'Mengembangkan aplikasi dan situs web menggunakan teknologi frontend dan backend seperti HTML, CSS, JavaScript, PHP, dan framework modern.'],
            ['nama' => 'Mobile Developer', 'deskripsi' => 'Membangun aplikasi mobile untuk platform Android dan iOS menggunakan Kotlin, Swift, Flutter, atau React Native.'],
            ['nama' => 'Data Analyst', 'deskripsi' => 'Menganalisis data untuk menghasilkan insight bisnis menggunakan SQL, Python, Excel, dan tools visualisasi data.'],
            ['nama' => 'Network Engineer', 'deskripsi' => 'Merancang, mengimplementasi, dan mengelola infrastruktur jaringan komputer perusahaan.'],
            ['nama' => 'UI/UX Designer', 'deskripsi' => 'Merancang antarmuka dan pengalaman pengguna yang intuitif menggunakan Figma, Adobe XD, dan prinsip desain modern.'],
            ['nama' => 'QA Engineer', 'deskripsi' => 'Menguji kualitas perangkat lunak, melakukan testing manual dan otomatis untuk memastikan aplikasi bebas bug.'],
            ['nama' => 'Data Scientist', 'deskripsi' => 'Mengolah dan memodelkan data untuk prediksi dan machine learning menggunakan Python, R, dan algoritma AI.'],
            ['nama' => 'DevOps Engineer', 'deskripsi' => 'Mengelola infrastruktur cloud, CI/CD pipeline, dan otomatisasi deployment menggunakan Docker, Kubernetes, dan AWS/GCP.'],
        ];

        foreach ($alternatifs as $alt) {
            Alternatif::updateOrCreate(
                ['nama' => $alt['nama']],
                ['deskripsi' => $alt['deskripsi']]
            );
        }
    }
}
