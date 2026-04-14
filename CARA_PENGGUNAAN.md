# 📖 Cara Penggunaan Sistem SPK Karir TI

## 🚀 Langkah-Langkah Penggunaan

### 1️⃣ Akses Aplikasi
```bash
php artisan serve
```
Buka browser: `http://localhost:8000`

### 2️⃣ Register/Login
- Klik "Daftar Gratis" untuk membuat akun baru
- Atau "Masuk" jika sudah punya akun
- **Akun Admin Default:**
  - Email: `admin@spk.com`
  - Password: `password`

### 3️⃣ Isi Data Mahasiswa
- Setelah login, klik "Data Mahasiswa" di sidebar
- Isi:
  - Nama Lengkap
  - NIM
  - Program Studi
  - Semester
- Klik "Simpan"

### 4️⃣ Input Nilai Mata Kuliah
- Klik "Input Nilai Mata Kuliah" di sidebar
- Isi nilai untuk **23 mata kuliah** (skala 0-100)
- Nilai bisa desimal (contoh: 85.5)
- Pastikan semua terisi
- Klik "Simpan Nilai"

**Daftar Mata Kuliah:**
1. Pemrograman Web
2. Pemrograman 1
3. Pemrograman 2
4. Praktik Pemrograman 1
5. Praktik Pemrograman 2
6. Struktur Data
7. Basis Data
8. Algoritma Pemrograman
9. Pemrograman Visual
10. Praktik Basis Data
11. Matematika Diskrit
12. Kalkulus Variabel Tunggal
13. Kalkulus Variabel Jamak
14. Vektor dan Matriks
15. Jaringan Komputer
16. Praktik Jaringan Komputer
17. Komunikasi Data
18. Praktik Komunikasi Data
19. Sistem Operasi
20. Teknologi Multimedia
21. Logika
22. Proyek Kewirausahaan
23. Rekayasa Perangkat Lunak

### 5️⃣ Hitung Rekomendasi
- Setelah nilai tersimpan, kembali ke Dashboard
- Klik tombol "🚀 Hitung Rekomendasi Sekarang"
- Sistem akan menghitung menggunakan metode TOPSIS

### 6️⃣ Lihat Hasil
- Dashboard akan menampilkan **Top 3 Rekomendasi Karir**
- Setiap karir menampilkan:
  - Nama karir
  - Skor kesesuaian (dalam %)
  - Ranking
- Klik "📋 Lihat Detail Lengkap" untuk melihat semua karir
- Klik "🧮 Detail Perhitungan TOPSIS" untuk melihat proses perhitungan

## 🎯 8 Pilihan Karir

1. **🌐 Web Developer** - Mengembangkan aplikasi dan website
2. **📱 Mobile Developer** - Mengembangkan aplikasi mobile
3. **📊 Data Analyst** - Menganalisis data untuk insight bisnis
4. **🔌 Network Engineer** - Mengelola infrastruktur jaringan
5. **🎨 UI/UX Designer** - Merancang antarmuka pengguna
6. **🧪 QA Engineer** - Menguji kualitas perangkat lunak
7. **🔬 Data Scientist** - Mengolah data untuk machine learning
8. **⚙️ DevOps Engineer** - Otomatisasi deployment dan infrastruktur

## 💡 Tips

### Untuk Mahasiswa:
- Masukkan nilai sesuai transkrip nilai Anda
- Jika belum ada nilai untuk mata kuliah tertentu, estimasi berdasarkan kemampuan Anda
- Nilai yang lebih tinggi akan meningkatkan skor untuk karir yang relevan
- Setiap karir memiliki fokus mata kuliah yang berbeda

### Untuk Admin:
- Login dengan akun admin untuk mengelola:
  - Mata Kuliah (Kriteria)
  - Alternatif Karir
  - Bobot mata kuliah untuk setiap karir
- Akses menu "Admin Panel" di sidebar

## 🔄 Update Nilai

Jika ingin mengubah nilai:
1. Klik "Input Nilai Mata Kuliah" lagi
2. Form akan menampilkan nilai yang sudah diisi sebelumnya
3. Edit nilai yang ingin diubah
4. Klik "Simpan Nilai"
5. Hitung ulang rekomendasi

## 📊 Memahami Hasil

### Skor Kesesuaian
- **80-100%**: Sangat Sesuai - Karir ini sangat cocok dengan profil Anda
- **60-79%**: Sesuai - Karir ini cukup cocok dengan profil Anda
- **40-59%**: Cukup Sesuai - Perlu pengembangan skill tambahan
- **0-39%**: Kurang Sesuai - Fokus pada karir dengan skor lebih tinggi

### Grafik
- **Bar Chart**: Membandingkan skor semua karir
- **Radar Chart**: Visualisasi kesesuaian dalam bentuk radar

## ❓ FAQ

**Q: Berapa lama proses perhitungan?**
A: Instant! Sistem langsung menghitung begitu Anda klik tombol.

**Q: Apakah bisa mengubah nilai setelah dihitung?**
A: Ya, bisa. Tinggal input ulang nilai dan hitung lagi.

**Q: Kenapa karir tertentu skornya rendah?**
A: Karena nilai mata kuliah yang penting untuk karir tersebut masih rendah. Lihat bobot mata kuliah untuk setiap karir.

**Q: Apakah hasil rekomendasi 100% akurat?**
A: Hasil adalah rekomendasi berdasarkan nilai akademik. Pertimbangkan juga minat, passion, dan pengalaman Anda.

**Q: Bagaimana cara melihat mata kuliah mana yang penting untuk karir tertentu?**
A: Lihat dokumentasi SISTEM_BARU.md untuk detail bobot setiap mata kuliah per karir.

## 🛠️ Troubleshooting

**Error saat menyimpan nilai:**
- Pastikan semua field terisi
- Nilai harus antara 0-100
- Cek koneksi database

**Hasil tidak muncul:**
- Pastikan sudah mengisi data mahasiswa
- Pastikan sudah mengisi semua nilai mata kuliah
- Coba refresh halaman

**Lupa password:**
- Klik "Lupa password?" di halaman login
- Masukkan email untuk reset password

## 📞 Support

Jika ada masalah atau pertanyaan:
1. Cek dokumentasi SISTEM_BARU.md
2. Cek file PERBAIKAN.md untuk info update terbaru
3. Hubungi administrator sistem

---

**Selamat menggunakan SPK Karir TI! 🎓✨**
