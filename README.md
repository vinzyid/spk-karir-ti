# 🚀 SPK Rekomendasi Karir Mahasiswa TI (Laravel + AHP + TOPSIS)

Website ini merupakan Sistem Pendukung Keputusan (SPK) berbasis web yang dikembangkan menggunakan Laravel untuk membantu mahasiswa Teknologi Informasi dalam menentukan jalur karir yang paling sesuai berdasarkan profil mereka. Sistem ini memanfaatkan metode Analytical Hierarchy Process (AHP) untuk menentukan bobot kriteria secara objektif, serta Technique for Order Preference by Similarity to Ideal Solution (TOPSIS) untuk melakukan proses perankingan alternatif karir sehingga menghasilkan rekomendasi yang optimal dan berbasis data.

Sistem ini mempertimbangkan empat kriteria utama yaitu nilai akademik, skill teknis, minat, dan sertifikat, dengan bobot yang telah dihitung menggunakan metode AHP. Alternatif karir yang direkomendasikan meliputi Web Developer, Mobile Developer, Data Analyst, UI/UX Designer, Network Engineer, Cyber Security, DevOps Engineer, dan System Analyst. Hasil akhir dari sistem ini berupa ranking karir serta tiga rekomendasi terbaik yang dapat dijadikan acuan oleh mahasiswa dalam menentukan arah karirnya.

Website ini dilengkapi dengan fitur autentikasi pengguna (login dan register), form input data mahasiswa, proses perhitungan SPK menggunakan metode TOPSIS, serta dashboard interaktif yang menampilkan hasil rekomendasi dalam bentuk visualisasi grafik. Selain itu, terdapat panel admin yang memungkinkan pengelolaan data kriteria dan alternatif karir. Untuk meningkatkan pengalaman pengguna, sistem ini juga dilengkapi dengan elemen visual berupa animasi 3D ringan menggunakan Lottie dan efek CSS transform yang hanya diterapkan pada bagian tertentu seperti landing page dan dashboard agar tetap menjaga performa website tetap cepat dan ringan.

Pengembangan sistem menggunakan Laravel 11 sebagai backend framework, MySQL sebagai database, Blade sebagai template engine tanpa penggunaan frontend framework tambahan seperti React atau Vue, serta Tailwind CSS untuk desain antarmuka yang modern dan responsif. Visualisasi data menggunakan Chart.js untuk memberikan tampilan yang informatif dan interaktif.

## ⚙️ Cara Menjalankan Project

Clone repository ini dan jalankan perintah berikut:

```bash
git clone https://github.com/username/spk-karir-ti.git
cd spk-karir-ti
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

Kemudian buka browser dan akses:
http://localhost:8000

## 🛠️ Teknologi yang Digunakan

Laravel 11, PHP 8.2, MySQL, Tailwind CSS, Blade Template Engine, Chart.js, dan Lottie Animation.

## 🎯 Fitur Utama

Sistem autentikasi pengguna, input data mahasiswa, perhitungan AHP dan TOPSIS, rekomendasi karir (Top 3), dashboard interaktif, visualisasi data, serta admin panel untuk manajemen data.

## 📌 Status Project

Dalam tahap pengembangan dan penyempurnaan.


## 🔥 Pengembangan Selanjutnya

Pengembangan lanjutan meliputi penambahan fitur rekomendasi skill, career roadmap, serta export hasil ke dalam format PDF.
# SPK Karir TI
