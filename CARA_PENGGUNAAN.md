# 📖 Cara Penggunaan Sistem SPK Karir TI

> Sistem Pendukung Keputusan berbasis **AHP + TOPSIS** untuk merekomendasikan jalur karir IT yang paling sesuai dengan profil mahasiswa.

---

## ⚡ Menjalankan Aplikasi

```bash
# 1. Install dependencies (pertama kali saja)
composer install

# 2. Jalankan server
php artisan serve
```

Buka browser: `http://localhost:8000`

---

## 🔐 Akun Default

| Role | Email | Password |
|------|-------|----------|
| Admin | `admin@spk.com` | `password` |
| Mahasiswa | daftar sendiri | - |

---

## 👨‍🎓 Panduan Mahasiswa (Step by Step)

### Step 1 — Daftar Akun

1. Klik tombol **"Daftar Gratis"** di halaman utama
2. Isi nama, email, dan password
3. Klik **"Daftar"**
4. Langsung masuk ke Dashboard

---

### Step 2 — Isi Data Diri Mahasiswa

1. Klik menu **"Data Mahasiswa"** di sidebar
2. Isi form berikut:
   - **Nama Lengkap**
   - **NIM**
   - **Program Studi**
   - **Semester**
3. Klik **"Simpan Data"**

> ⚠️ Langkah ini wajib dilakukan sebelum bisa menghitung rekomendasi.

---

### Step 3 — Input Nilai Mata Kuliah

1. Klik menu **"Nilai Mata Kuliah"** di sidebar
2. Isi nilai untuk setiap mata kuliah (skala **0 – 100**)
3. Klik **"Simpan Nilai"**

**Daftar 23 Mata Kuliah yang harus diisi:**

| # | Mata Kuliah | # | Mata Kuliah |
|---|-------------|---|-------------|
| 1 | Pemrograman Web | 13 | Kalkulus Variabel Jamak |
| 2 | Pemrograman 1 | 14 | Vektor dan Matriks |
| 3 | Pemrograman 2 | 15 | Jaringan Komputer |
| 4 | Praktik Pemrograman 1 | 16 | Praktik Jaringan Komputer |
| 5 | Praktik Pemrograman 2 | 17 | Komunikasi Data |
| 6 | Struktur Data | 18 | Praktik Komunikasi Data |
| 7 | Basis Data | 19 | Sistem Operasi |
| 8 | Algoritma Pemrograman | 20 | Teknologi Multimedia |
| 9 | Pemrograman Visual | 21 | Logika |
| 10 | Praktik Basis Data | 22 | Proyek Kewirausahaan |
| 11 | Matematika Diskrit | 23 | Rekayasa Perangkat Lunak |
| 12 | Kalkulus Variabel Tunggal | | |

> 💡 Mata kuliah berpasangan (misal Pemro 1 & 2) akan **dirata-rata** otomatis oleh sistem sebelum dihitung.

---

### Step 4 — Isi Kuisioner Evaluasi Karir

1. Klik menu **"Evaluasi Karir"** di sidebar
2. Isi 4 bagian kuisioner:

**Bagian 1 – Skill Teknis** *(Opsional)*
- Centang semua skill yang kamu kuasai dari daftar yang tersedia
- Contoh: HTML/CSS, Python, Figma, Docker, dll.
- Sistem akan otomatis hitung kesesuaian skill kamu dengan tiap karir

**Bagian 2 – Minat Karir** *(Wajib)*
- Pilih **1 karir** sebagai Pilihan Pertama (paling diminati)
- Pilih **1 karir lain** sebagai Pilihan Kedua
- Pilihan 1 dan 2 tidak boleh sama

**Bagian 3 – Proyek Mandiri** *(Wajib)*
- Pilih berapa banyak proyek mandiri/tugas besar yang sudah dikerjakan
- Pilihan: Belum Ada / 1 / 2 / 3 / 4 / 5 / Lebih dari 5

**Bagian 4 – Sertifikasi** *(Wajib)*
- Pilih berapa sertifikat IT atau pengalaman kerja/magang yang kamu miliki
- Pilihan: Belum Ada / 1 / 2 / 3 / 4 / 5 / Lebih dari 5

3. Klik **"Simpan Jawaban"**

---

### Step 5 — Hitung Rekomendasi Karir

Setelah semua langkah di atas selesai:

1. Klik tombol **"🚀 Hitung Rekomendasi Karir"** (muncul setelah kuisioner tersimpan)
2. Sistem akan memproses data menggunakan **AHP + TOPSIS**
3. Tunggu sebentar — langsung redirect ke halaman hasil

---

### Step 6 — Lihat Hasil Rekomendasi

Halaman hasil menampilkan:

- **🏆 Hero Section** — Karir #1 yang paling direkomendasikan
- **🥇🥈🥉 Podium Top 3** — 3 karir terbaik dengan medal emas/perak/perunggu
- **📊 Grafik** — Bar chart perbandingan skor semua karir
- **📋 Tabel Ranking Lengkap** — Semua 8 karir dengan skor dan progress bar
- **🧮 Detail Perhitungan** — Transparansi langkah-langkah TOPSIS (opsional diklik)

---

## 👑 Panduan Admin

Login dengan akun admin, kemudian akses **"Admin Panel"** di sidebar:

| Menu | Fungsi |
|------|--------|
| Dashboard | Statistik pengguna dan distribusi rekomendasi |
| Kriteria | Kelola mata kuliah (tambah/edit/hapus) |
| Alternatif | Kelola jalur karir (tambah/edit/hapus) |

---

## 💼 8 Jalur Karir yang Tersedia

| Karir | Fokus Utama |
|-------|-------------|
| 🌐 Web Developer | Frontend & backend, HTML, JS, PHP, framework modern |
| 📱 Mobile Developer | Android & iOS, Flutter, Kotlin, React Native |
| 📊 Data Analyst | SQL, Python, Excel, Tableau, analisis data |
| 🔌 Network Engineer | Jaringan komputer, Cisco, Linux, keamanan jaringan |
| 🎨 UI/UX Designer | Figma, Adobe XD, user research, desain antarmuka |
| 🛡️ QA Engineer | Software testing, Selenium, JIRA, automation |
| ⚙️ Data Scientist | Machine learning, Python, statistika, AI |
| ☁️ DevOps Engineer | Docker, Kubernetes, CI/CD, cloud AWS/GCP |

---

## 📊 Memahami Skor Hasil

| Skor Vi | Kategori | Arti |
|---------|----------|------|
| 0.70 – 1.00 | 🟢 **Sangat Cocok** | Profil sangat sesuai dengan karir ini |
| 0.50 – 0.69 | 🟡 **Cocok** | Cukup sesuai, perlu sedikit peningkatan |
| 0.30 – 0.49 | 🟠 **Cukup** | Perlu pengembangan di beberapa area |
| 0.00 – 0.29 | 🔴 **Kurang** | Fokus pada karir dengan skor lebih tinggi |

> Skor dihitung dari 4 kriteria dengan bobot: **Skill Teknis 49.67%**, **Nilai Akademik 25.07%**, **Sertifikat 14.95%**, **Minat 10.27%**

---

## 🔄 Ingin Update Jawaban?

Kamu bisa mengisi ulang kapan saja:

- **Nilai Mata Kuliah** → klik menu Nilai lagi, edit, simpan ulang
- **Kuisioner Karir** → klik menu Evaluasi Karir lagi, ubah, simpan ulang
- Setelah itu klik **"Hitung Rekomendasi"** lagi untuk memperbarui hasil

---

## 🛠️ Troubleshooting

| Masalah | Solusi |
|---------|--------|
| Tombol Hitung tidak muncul | Pastikan kuisioner evaluasi karir sudah disimpan |
| Redirect ke halaman data mahasiswa | Isi data diri mahasiswa dulu (NIM, nama, prodi) |
| Redirect ke halaman nilai | Isi nilai mata kuliah dulu |
| Error saat submit kuisioner | Pastikan Minat 1, Minat 2, Proyek, dan Sertifikasi sudah dipilih |
| Hasil tidak berubah | Hitung ulang setelah menyimpan perubahan |

---

## 🔑 Pengaturan Akun

Klik nama di pojok kanan atas → **"Pengaturan"**:

- Ubah nama dan email
- Ubah password (dengan indikator kekuatan password)
- Hapus akun (dengan konfirmasi)

---

**🎓 Selamat menggunakan SPK Karir TI!**
