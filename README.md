# SPK Rekomendasi Karir Mahasiswa TI

> **Sistem Pendukung Keputusan** berbasis web untuk membantu mahasiswa Teknologi Informasi menentukan jalur karir yang paling sesuai menggunakan metode **AHP + TOPSIS**.

---

## 📖 Tentang Project

Sistem ini dikembangkan sebagai tugas Praktikum Sistem Pendukung Keputusan (SPK) yang mengimplementasikan dua metode sekaligus:

- **AHP (Analytical Hierarchy Process)** — menentukan bobot setiap kriteria secara objektif berdasarkan perbandingan berpasangan
- **TOPSIS (Technique for Order Preference by Similarity to Ideal Solution)** — melakukan perankingan alternatif karir berdasarkan kedekatan dengan solusi ideal positif dan negati

Hasil akhirnya berupa **ranking karir** dengan **rekomendasi terbaik (Top 3)** yang dapat dijadikan acuan mahasiswa dalam menentukan arah karirnya.

---

## ⚙️ Kriteria Penilaian

Sistem menggunakan **4 kriteria utama** dengan bobot AHP yang telah dihitung:

| Kode | Kriteria | Bobot AHP | Keterangan |
|------|----------|-----------|------------|
| C1 | Nilai Akademik | **25.07%** | Dihitung dari rata-rata nilai mata kuliah relevan per jalur karir |
| C2 | Skill Teknis | **49.67%** | Tingkat penguasaan skill teknis spesifik (0–100) |
| C3 | Minat | **10.27%** | Tingkat ketertarikan pada jalur karir (1–5) |
| C4 | Sertifikasi | **14.95%** | Jumlah sertifikat relevan yang dimiliki |

---

## 💼 Alternatif Karir

Sistem merekomendasikan dari **8 jalur karir IT**:

| # | Karir | Deskripsi |
|---|-------|-----------|
| 1 | 🌐 Web Developer | Frontend & backend development dengan HTML, JS, PHP, dan framework modern |
| 2 | 📱 Mobile Developer | Aplikasi Android & iOS menggunakan Kotlin, Flutter, atau Swift |
| 3 | 📊 Data Analyst | Analisis data menggunakan SQL, Python, Excel, Tableau, dan Power BI |
| 4 | 🔌 Network Engineer | Infrastruktur jaringan, Cisco, Linux Server, keamanan jaringan |
| 5 | 🎨 UI/UX Designer | Desain antarmuka dengan Figma, Adobe XD, user research |
| 6 | 🛡️ QA Engineer | Software testing manual & otomatis, Selenium, JIRA |
| 7 | ⚙️ Data Scientist | Machine learning, Python, TensorFlow, statistika |
| 8 | ☁️ DevOps Engineer | Docker, Kubernetes, CI/CD, cloud AWS/GCP/Azure |

---

## 🚀 Alur Penggunaan

```
1. Register / Login
       ↓
2. Isi Data Diri Mahasiswa (Nama, NIM, Prodi)
       ↓
3. Input Nilai Mata Kuliah
   (nilai 0–100 untuk setiap mata kuliah)
       ↓
4. Input Penilaian Karir
   🟣 Pilih skill teknis yang dikuasai (toggle buttons)
   ⭐ Pilih tingkat minat (bintang 1–5)
   🔢 Pilih jumlah sertifikasi (stepper 0–n)
       ↓
5. Klik "Hitung Rekomendasi Karir"
       ↓
6. Lihat Hasil: Hero rekomendasi #1 + Top 3 podium + Ranking lengkap
```

---

## 🛠️ Teknologi

| Komponen | Teknologi |
|----------|-----------|
| Backend | Laravel 12, PHP 8.2+ |
| Database | MySQL |
| Frontend | Blade Template Engine, Vanilla CSS |
| Grafik | Chart.js (Bar + Doughnut) |
| Auth | Laravel Breeze |
| Desain | Dark Glassmorphism, CSS Animations |

> **Catatan:** Tidak menggunakan Tailwind CSS atau framework frontend tambahan — murni Vanilla CSS dengan variabel CSS custom.

---

## ⚡ Cara Menjalankan

### 1. Clone & Install

```bash
git clone https://github.com/vinzyid/spk-karir-ti.git
cd spk-karir-ti
composer install
```

### 2. Konfigurasi Environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` sesuai database lokal:
```env
DB_DATABASE=spk_karir_ti
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Migrasi & Seeder

```bash
php artisan migrate
php artisan db:seed --class=AdminSeeder
php artisan db:seed --class=AlternatifSeeder
php artisan db:seed --class=MataKuliahSeeder
php artisan db:seed --class=BobotKarirSeeder
```

### 4. Jalankan Server

```bash
php artisan serve
```

Buka browser: **http://localhost:8000**

---

## 👤 Akun Default

Setelah seeder dijalankan, tersedia akun admin bawaan:

| Field | Value |
|-------|-------|
| Email | `admin@spk.com` |
| Password | `password` |
| Role | Admin |

Untuk akun mahasiswa, daftar lewat halaman **Register**.

---

## 🗂️ Struktur Database

```
users                   — Data akun pengguna (mahasiswa & admin)
mahasiswas              — Profil mahasiswa (NIM, prodi, dll)
alternatifs             — 8 jalur karir IT
kriterias               — Kriteria mata kuliah
nilai_mahasiswas        — Nilai mahasiswa per mata kuliah
bobot_karirs            — Bobot mata kuliah terhadap setiap karir
penilaian_kriterias     — Penilaian skill, minat, sertifikat per karir
hasil_rekomendassis     — Hasil ranking TOPSIS tersimpan
```

---

## 🎯 Fitur Sistem

### 👨‍🎓 Mahasiswa
- [x] Register & login
- [x] Isi data diri (NIM, nama, prodi)
- [x] Input nilai mata kuliah
- [x] Evaluasi karir: skill toggle, rating bintang, stepper sertifikasi
- [x] Hitung rekomendasi otomatis (AHP + TOPSIS)
- [x] Lihat hasil: hero rekomendasi + top 3 + ranking lengkap
- [x] Lihat detail langkah perhitungan TOPSIS
- [x] Pengaturan akun (ubah profil & password)

### 👑 Admin
- [x] Dashboard statistik (total user, mahasiswa, karir, dsb.)
- [x] Kelola kriteria (CRUD)
- [x] Kelola alternatif karir (CRUD)
- [x] Lihat distribusi rekomendasi via grafik

---

## 📱 Tampilan

- **Landing Page** — intro sistem dengan animasi
- **Dashboard** — step tracker progress pengisian data
- **Input Nilai** — tabel mata kuliah dengan input nilai 0–100
- **Evaluasi Karir** — toggle skill, bintang minat, stepper sertifikasi
- **Hasil Rekomendasi** — hero + podium + grafik + tabel ranking
- **Detail TOPSIS** — transparansi setiap langkah perhitungan
- **Pengaturan** — ubah profil & password dengan strength indicator

---

## 📌 Status Project

> 🟢 **Aktif dikembangkan** — Versi fungsional tersedia, fitur inti sudah berjalan.

---

## 👨‍💻 Developer

**Rafi** — Mahasiswa Teknologi Informasi  
Tugas Praktikum Sistem Pendukung Keputusan, Semester 4
