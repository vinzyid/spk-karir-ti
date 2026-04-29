<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register - {{ config('app.name', 'SPK Karir TI') }}</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        * { font-family: 'Inter', sans-serif; }
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --primary-light: #818cf8;
            --secondary: #8b5cf6;
            --accent: #06b6d4;
            --bg-dark: #0f172a;
            --bg-card: #1e293b;
            --text-primary: #f1f5f9;
            --text-secondary: #94a3b8;
            --border: #334155;
            --danger: #ef4444;
        }
        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .auth-container {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 40px;
            max-width: 440px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            animation: fadeIn 0.5s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .logo {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 4px;
        }
        .logo-title {
            font-weight: 700;
            font-size: 1.4rem;
            color: var(--text-primary);
            margin-top: 14px;
            margin-bottom: 4px;
        }
        .logo-inst {
            font-size: 0.72rem;
            color: var(--text-secondary);
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .subtitle {
            text-align: center;
            color: var(--text-secondary);
            font-size: 0.9rem;
            margin-bottom: 32px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            font-size: 0.875rem;
            color: var(--text-secondary);
        }
        .form-input {
            background: var(--bg-dark);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 12px 16px;
            color: var(--text-primary);
            width: 100%;
            transition: all 0.2s ease;
            font-size: 0.9rem;
        }
        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }
        .error-text {
            color: var(--danger);
            font-size: 0.8rem;
            margin-top: 6px;
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 12px 24px;
            border-radius: 12px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            font-size: 0.95rem;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.3);
        }
        .link {
            color: var(--primary-light);
            text-decoration: none;
            font-size: 0.875rem;
            transition: color 0.2s;
        }
        .link:hover {
            color: var(--primary);
            text-decoration: underline;
        }
        .divider {
            text-align: center;
            margin: 24px 0;
            color: var(--text-secondary);
            font-size: 0.85rem;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="logo">
            <img src="{{ asset('images/logo-uny.png') }}" alt="Logo UNY" style="width:72px;height:72px;object-fit:contain;">
            <div class="logo-title">SPK Karir TI</div>
            <div class="logo-inst">Universitas Negeri Yogyakarta</div>
        </div>
        <div class="subtitle">Sistem Pendukung Keputusan Rekomendasi Karir</div>
        
        <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 24px; text-align: center;">Buat Akun Baru</h2>
        
        <form method="POST" action="{{ route('register') }}">
            @csrf
            
            <div class="form-group">
                <label for="name" class="form-label">Nama Lengkap</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus class="form-input" autocomplete="name" placeholder="Masukkan nama lengkap" />
                @error('name')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required class="form-input" autocomplete="username" placeholder="nama@email.com" />
                @error('email')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input id="password" type="password" name="password" required class="form-input" autocomplete="new-password" placeholder="Minimal 8 karakter" />
                @error('password')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required class="form-input" autocomplete="new-password" placeholder="Ulangi password" />
                @error('password_confirmation')
                    <p class="error-text">{{ $message }}</p>
                @enderror
            </div>
            
            <button type="submit" class="btn-primary">Daftar Sekarang</button>
            
            <div style="text-align: center; margin-top: 20px;">
                <span style="color: var(--text-secondary); font-size: 0.875rem;">Sudah punya akun? </span>
                <a class="link" href="{{ route('login') }}">Masuk di sini</a>
            </div>
        </form>
        
        <div class="divider">
            <a href="{{ route('landing') }}" class="link">← Kembali ke Beranda</a>
        </div>
    </div>
</body>
</html>
