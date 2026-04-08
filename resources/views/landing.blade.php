<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sistem Pendukung Keputusan untuk Rekomendasi Karir Mahasiswa Teknologi Informasi menggunakan metode AHP dan TOPSIS">
    <title>SPK Karir TI - Temukan Karir Idealmu</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@lottiefiles/lottie-player@2.0.3/dist/lottie-player.js"></script>

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }

        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #8b5cf6;
            --accent: #06b6d4;
            --bg: #0f172a;
            --bg-card: #1e293b;
            --text: #f1f5f9;
            --text-muted: #94a3b8;
            --border: #334155;
        }

        body { background: var(--bg); color: var(--text); overflow-x: hidden; }

        /* Navbar */
        .navbar {
            position: fixed; top: 0; left: 0; right: 0; z-index: 100;
            padding: 20px 60px;
            display: flex; align-items: center; justify-content: space-between;
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(51, 65, 85, 0.5);
            transition: all 0.3s ease;
        }

        .nav-logo {
            font-size: 1.5rem; font-weight: 800;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }

        .nav-links { display: flex; gap: 32px; align-items: center; }
        .nav-links a {
            color: var(--text-muted); text-decoration: none; font-weight: 500;
            font-size: 0.9rem; transition: color 0.2s;
        }
        .nav-links a:hover { color: var(--text); }

        .nav-btn {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white; padding: 10px 28px; border-radius: 12px;
            text-decoration: none; font-weight: 600; font-size: 0.9rem;
            transition: all 0.3s ease; border: none; cursor: pointer;
        }
        .nav-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(99, 102, 241, 0.4);
        }

        .nav-btn-outline {
            background: transparent; border: 1px solid var(--border);
            color: var(--text); padding: 10px 28px; border-radius: 12px;
            text-decoration: none; font-weight: 600; font-size: 0.9rem;
            transition: all 0.3s ease;
        }
        .nav-btn-outline:hover { border-color: var(--primary); background: rgba(99, 102, 241, 0.1); }

        /* Hero */
        .hero {
            min-height: 100vh; display: flex; align-items: center;
            padding: 120px 60px 80px;
            position: relative;
        }

        .hero-bg {
            position: absolute; inset: 0; overflow: hidden; z-index: 0;
        }

        .hero-bg::before {
            content: ''; position: absolute;
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.15), transparent 70%);
            top: -100px; right: -100px;
            animation: float 8s ease-in-out infinite;
        }

        .hero-bg::after {
            content: ''; position: absolute;
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(139, 92, 246, 0.1), transparent 70%);
            bottom: -50px; left: -50px;
            animation: float 10s ease-in-out infinite reverse;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-30px) rotate(5deg); }
        }

        .hero-content {
            display: grid; grid-template-columns: 1fr 1fr;
            gap: 60px; align-items: center;
            max-width: 1200px; margin: 0 auto; width: 100%;
            position: relative; z-index: 1;
        }

        .hero-text h1 {
            font-size: 3.5rem; font-weight: 900; line-height: 1.1;
            margin-bottom: 24px;
        }

        .hero-text h1 span {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }

        .hero-text p {
            font-size: 1.1rem; color: var(--text-muted); line-height: 1.7;
            margin-bottom: 36px;
        }

        .hero-buttons { display: flex; gap: 16px; flex-wrap: wrap; }

        .hero-visual {
            display: flex; align-items: center; justify-content: center;
            position: relative;
        }

        .hero-3d-card {
            width: 100%; max-width: 450px;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(139, 92, 246, 0.05));
            border: 1px solid rgba(99, 102, 241, 0.2);
            border-radius: 24px; padding: 40px;
            backdrop-filter: blur(10px);
            transform: perspective(1000px) rotateY(-5deg) rotateX(5deg);
            transition: transform 0.5s ease;
            animation: card3d 6s ease-in-out infinite;
        }

        @keyframes card3d {
            0%, 100% { transform: perspective(1000px) rotateY(-5deg) rotateX(5deg); }
            50% { transform: perspective(1000px) rotateY(5deg) rotateX(-5deg); }
        }

        .hero-3d-card:hover {
            transform: perspective(1000px) rotateY(0) rotateX(0) scale(1.02);
        }

        /* Stats */
        .stats-row {
            display: flex; gap: 24px; margin-top: 48px;
        }

        .stat-item {
            text-align: center;
        }

        .stat-item .number {
            font-size: 2rem; font-weight: 800;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }

        .stat-item .label {
            font-size: 0.8rem; color: var(--text-muted); margin-top: 4px;
        }

        /* Features Section */
        .section {
            padding: 100px 60px;
            max-width: 1200px; margin: 0 auto;
        }

        .section-title {
            text-align: center; margin-bottom: 60px;
        }

        .section-title h2 {
            font-size: 2.5rem; font-weight: 800; margin-bottom: 16px;
        }

        .section-title h2 span {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }

        .section-title p { color: var(--text-muted); font-size: 1.1rem; }

        .features-grid {
            display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px;
        }

        .feature-card {
            background: var(--bg-card); border: 1px solid var(--border);
            border-radius: 20px; padding: 32px;
            transition: all 0.3s ease;
            position: relative; overflow: hidden;
        }

        .feature-card::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0;
            height: 3px; background: linear-gradient(90deg, var(--primary), var(--secondary));
            transform: scaleX(0); transition: transform 0.3s ease;
        }

        .feature-card:hover::before { transform: scaleX(1); }

        .feature-card:hover {
            transform: translateY(-8px);
            border-color: var(--primary);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .feature-icon {
            width: 56px; height: 56px; border-radius: 16px;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.2), rgba(139, 92, 246, 0.1));
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 20px; font-size: 1.5rem;
        }

        .feature-card h3 { font-size: 1.1rem; font-weight: 700; margin-bottom: 10px; }
        .feature-card p { font-size: 0.9rem; color: var(--text-muted); line-height: 1.6; }

        /* Careers Grid */
        .careers-grid {
            display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;
        }

        .career-card {
            background: var(--bg-card); border: 1px solid var(--border);
            border-radius: 16px; padding: 24px; text-align: center;
            transition: all 0.3s ease;
        }

        .career-card:hover {
            transform: translateY(-6px) scale(1.02);
            border-color: var(--primary);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
        }

        .career-icon { font-size: 2.5rem; margin-bottom: 12px; }
        .career-card h3 { font-size: 0.95rem; font-weight: 700; margin-bottom: 8px; }
        .career-card p { font-size: 0.8rem; color: var(--text-muted); line-height: 1.5; }

        /* Method Section */
        .method-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; }

        .method-card {
            background: var(--bg-card); border: 1px solid var(--border);
            border-radius: 20px; padding: 40px;
            transition: all 0.3s ease;
        }

        .method-card:hover {
            border-color: var(--primary);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }

        .method-card h3 {
            font-size: 1.3rem; font-weight: 800; margin-bottom: 12px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }

        .method-card p { color: var(--text-muted); line-height: 1.7; font-size: 0.95rem; }

        .method-steps {
            margin-top: 20px; display: flex; flex-direction: column; gap: 12px;
        }

        .method-step {
            display: flex; align-items: center; gap: 12px;
            padding: 10px 16px; border-radius: 10px;
            background: rgba(99, 102, 241, 0.05);
            font-size: 0.85rem; color: var(--text-muted);
        }

        .method-step-num {
            width: 28px; height: 28px; border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 0.75rem; color: white;
            flex-shrink: 0;
        }

        /* CTA */
        .cta-section {
            text-align: center; padding: 100px 60px;
            position: relative;
        }

        .cta-section::before {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.08), rgba(139, 92, 246, 0.05));
            border-radius: 32px; margin: 0 60px;
        }

        .cta-content {
            position: relative; z-index: 1;
            max-width: 600px; margin: 0 auto;
        }

        .cta-content h2 { font-size: 2.5rem; font-weight: 800; margin-bottom: 16px; }
        .cta-content p { color: var(--text-muted); margin-bottom: 32px; font-size: 1.05rem; }

        /* Footer */
        .footer {
            text-align: center; padding: 40px 60px;
            border-top: 1px solid var(--border);
            color: var(--text-muted); font-size: 0.85rem;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .features-grid, .careers-grid { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 768px) {
            .navbar { padding: 16px 24px; }
            .nav-links { display: none; }
            .hero { padding: 100px 24px 60px; }
            .hero-content { grid-template-columns: 1fr; text-align: center; }
            .hero-text h1 { font-size: 2.2rem; }
            .hero-buttons { justify-content: center; }
            .hero-visual { display: none; }
            .stats-row { justify-content: center; }
            .section { padding: 60px 24px; }
            .section-title h2 { font-size: 1.8rem; }
            .features-grid, .careers-grid, .method-grid { grid-template-columns: 1fr; }
            .cta-section { padding: 60px 24px; }
            .cta-section::before { margin: 0; }
        }

        /* Scroll animations */
        .reveal {
            opacity: 0; transform: translateY(40px);
            transition: all 0.8s ease;
        }
        .reveal.visible {
            opacity: 1; transform: translateY(0);
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
    <div class="nav-logo">🎓 SPK Karir TI</div>
    <div class="nav-links">
        <a href="#features">Fitur</a>
        <a href="#careers">Karir</a>
        <a href="#method">Metode</a>
    </div>
    <div style="display: flex; gap: 12px;">
        @auth
            <a href="{{ route('dashboard') }}" class="nav-btn">Dashboard</a>
        @else
            <a href="{{ route('login') }}" class="nav-btn-outline">Masuk</a>
            <a href="{{ route('register') }}" class="nav-btn">Daftar Gratis</a>
        @endauth
    </div>
</nav>

<!-- Hero -->
<section class="hero">
    <div class="hero-bg"></div>
    <div class="hero-content">
        <div class="hero-text">
            <h1>Temukan <span>Karir Ideal</span> di Dunia Teknologi</h1>
            <p>Sistem Pendukung Keputusan berbasis metode AHP dan TOPSIS untuk membantu mahasiswa Teknologi Informasi menemukan jalur karir yang tepat sesuai kemampuan dan minat.</p>
            <div class="hero-buttons">
                @auth
                    <a href="{{ route('dashboard') }}" class="nav-btn" style="padding: 14px 36px; font-size: 1rem;">
                        🚀 Ke Dashboard
                    </a>
                @else
                    <a href="{{ route('register') }}" class="nav-btn" style="padding: 14px 36px; font-size: 1rem;">
                        🚀 Mulai Sekarang
                    </a>
                    <a href="#method" class="nav-btn-outline" style="padding: 14px 36px; font-size: 1rem;">
                        📖 Pelajari Metode
                    </a>
                @endauth
            </div>
            <div class="stats-row">
                <div class="stat-item">
                    <div class="number">{{ $totalKarir }}</div>
                    <div class="label">Pilihan Karir</div>
                </div>
                <div class="stat-item">
                    <div class="number">{{ $totalKriteria }}</div>
                    <div class="label">Kriteria Penilaian</div>
                </div>
                <div class="stat-item">
                    <div class="number">{{ $totalUser }}</div>
                    <div class="label">Pengguna Terdaftar</div>
                </div>
            </div>
        </div>
        <div class="hero-visual">
            <div class="hero-3d-card">
                <lottie-player
                    src="https://assets2.lottiefiles.com/packages/lf20_fcfjwiyb.json"
                    background="transparent"
                    speed="1"
                    style="width: 100%; height: 300px;"
                    loop autoplay>
                </lottie-player>
                <div style="text-align: center; margin-top: 16px;">
                    <div style="font-weight: 700; font-size: 1.1rem;">Analisis Karir Cerdas</div>
                    <div style="font-size: 0.85rem; color: var(--text-muted);">Powered by AHP & TOPSIS</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features -->
<section class="section reveal" id="features">
    <div class="section-title">
        <h2>Fitur <span>Unggulan</span></h2>
        <p>Sistem lengkap untuk membantu pengambilan keputusan karir Anda</p>
    </div>
    <div class="features-grid">
        <div class="feature-card">
            <div class="feature-icon">📊</div>
            <h3>Analisis Multi-Kriteria</h3>
            <p>Evaluasi berdasarkan 4 kriteria utama: Nilai Akademik, Skill Teknis, Minat, dan Sertifikat yang dimiliki.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">🧮</div>
            <h3>Metode TOPSIS</h3>
            <p>Algoritma TOPSIS menghasilkan ranking karir paling sesuai berdasarkan jarak ke solusi ideal.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">🏆</div>
            <h3>Top 3 Rekomendasi</h3>
            <p>Dapatkan 3 rekomendasi karir terbaik dengan skor detail dan visualisasi grafik interaktif.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">📈</div>
            <h3>Dashboard Interaktif</h3>
            <p>Visualisasi data dengan Chart.js untuk memahami kekuatan dan peluang karir Anda.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">⚖️</div>
            <h3>Bobot AHP</h3>
            <p>Bobot kriteria menggunakan metode AHP untuk memastikan prioritas yang terukur dan objektif.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">🔐</div>
            <h3>Aman & Privat</h3>
            <p>Data Anda dilindungi dengan autentikasi aman. Hanya Anda yang bisa melihat hasil analisis.</p>
        </div>
    </div>
</section>

<!-- Careers -->
<section class="section reveal" id="careers">
    <div class="section-title">
        <h2>Pilihan <span>Karir IT</span></h2>
        <p>8 jalur karir di bidang Teknologi Informasi yang bisa menjadi tujuan Anda</p>
    </div>
    <div class="careers-grid">
        <div class="career-card">
            <div class="career-icon">🌐</div>
            <h3>Web Developer</h3>
            <p>Membangun aplikasi & situs web modern</p>
        </div>
        <div class="career-card">
            <div class="career-icon">📱</div>
            <h3>Mobile Developer</h3>
            <p>Mengembangkan aplikasi Android & iOS</p>
        </div>
        <div class="career-card">
            <div class="career-icon">📊</div>
            <h3>Data Analyst</h3>
            <p>Menganalisis data untuk insight bisnis</p>
        </div>
        <div class="career-card">
            <div class="career-icon">🎨</div>
            <h3>UI/UX Designer</h3>
            <p>Merancang pengalaman pengguna intuitif</p>
        </div>
        <div class="career-card">
            <div class="career-icon">🔌</div>
            <h3>Network Engineer</h3>
            <p>Mengelola infrastruktur jaringan</p>
        </div>
        <div class="career-card">
            <div class="career-icon">🛡️</div>
            <h3>Cyber Security</h3>
            <p>Melindungi sistem dari ancaman siber</p>
        </div>
        <div class="career-card">
            <div class="career-icon">⚙️</div>
            <h3>DevOps Engineer</h3>
            <p>Otomatisasi deployment & infrastruktur</p>
        </div>
        <div class="career-card">
            <div class="career-icon">📋</div>
            <h3>System Analyst</h3>
            <p>Merancang solusi sistem informasi</p>
        </div>
    </div>
</section>

<!-- Method -->
<section class="section reveal" id="method">
    <div class="section-title">
        <h2>Metode <span>Perhitungan</span></h2>
        <p>Kombinasi dua metode ilmiah untuk hasil rekomendasi yang akurat</p>
    </div>
    <div class="method-grid">
        <div class="method-card">
            <h3>⚖️ AHP (Analytical Hierarchy Process)</h3>
            <p>Menentukan bobot prioritas setiap kriteria penilaian secara terstruktur dan konsisten.</p>
            <div class="method-steps">
                <div class="method-step">
                    <div class="method-step-num">1</div>
                    Menyusun hierarki kriteria keputusan
                </div>
                <div class="method-step">
                    <div class="method-step-num">2</div>
                    Perbandingan berpasangan antar kriteria
                </div>
                <div class="method-step">
                    <div class="method-step-num">3</div>
                    Menghitung bobot prioritas (eigenvector)
                </div>
                <div class="method-step">
                    <div class="method-step-num">4</div>
                    Uji konsistensi (CR &lt; 0.1)
                </div>
            </div>
        </div>
        <div class="method-card">
            <h3>📐 TOPSIS (Technique for Order Preference)</h3>
            <p>Meranking alternatif berdasarkan jarak terdekat ke solusi ideal positif dan terjauh dari negatif.</p>
            <div class="method-steps">
                <div class="method-step">
                    <div class="method-step-num">1</div>
                    Normalisasi matriks keputusan
                </div>
                <div class="method-step">
                    <div class="method-step-num">2</div>
                    Menghitung matriks terbobot (× bobot AHP)
                </div>
                <div class="method-step">
                    <div class="method-step-num">3</div>
                    Menentukan solusi ideal positif & negatif
                </div>
                <div class="method-step">
                    <div class="method-step-num">4</div>
                    Menghitung jarak & nilai preferensi
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta-section reveal">
    <div class="cta-content">
        <h2>Siap Menemukan Karir Idealmu?</h2>
        <p>Daftar sekarang dan dapatkan rekomendasi karir berdasarkan analisis data yang akurat</p>
        @auth
            <a href="{{ route('dashboard') }}" class="nav-btn" style="padding: 16px 48px; font-size: 1.1rem;">
                Ke Dashboard →
            </a>
        @else
            <a href="{{ route('register') }}" class="nav-btn" style="padding: 16px 48px; font-size: 1.1rem;">
                Daftar Gratis Sekarang →
            </a>
        @endauth
    </div>
</section>

<!-- Footer -->
<footer class="footer">
    <p>© {{ date('Y') }} SPK Karir TI — Sistem Pendukung Keputusan Rekomendasi Karir Mahasiswa</p>
    <p style="margin-top: 8px; font-size: 0.75rem;">Dibangun dengan Laravel, metode AHP & TOPSIS</p>
</footer>

<script>
    // Scroll reveal animation
    const reveals = document.querySelectorAll('.reveal');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, { threshold: 0.1 });

    reveals.forEach(el => observer.observe(el));
</script>
</body>
</html>
