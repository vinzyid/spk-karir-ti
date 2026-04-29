<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SPK Karir TI') }} - Login</title>
    
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
            width: 100%;
            max-width: 440px;
            animation: fadeInUp 0.6s ease;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .auth-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 48px 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
        }
        @media (max-width: 480px) {
            body { padding: 16px; align-items: flex-start; padding-top: 32px; }
            .auth-card { padding: 32px 24px; border-radius: 16px; }
            .auth-logo-icon img { width: 56px; height: 56px; }
        }
        .auth-logo {
            text-align: center;
            margin-bottom: 32px;
        }
        .auth-logo-icon {
            display: flex;
            justify-content: center;
            margin-bottom: 14px;
        }
        .auth-logo-text {
            font-weight: 700;
            font-size: 1.4rem;
            color: var(--text-primary);
            margin-bottom: 4px;
        }
        .auth-logo-inst {
            font-size: 0.72rem;
            color: var(--text-secondary);
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-bottom: 4px;
        }
        .auth-subtitle {
            color: var(--text-secondary);
            font-size: 0.9rem;
        }
        .form-group {
            margin-bottom: 24px;
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
            padding: 14px 16px;
            color: var(--text-primary);
            width: 100%;
            transition: all 0.2s ease;
            font-size: 0.95rem;
        }
        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }
        .form-error {
            color: var(--danger);
            font-size: 0.8rem;
            margin-top: 6px;
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 14px 32px;
            border-radius: 12px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            font-size: 1rem;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.4);
        }
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 24px;
        }
        .checkbox-input {
            width: 18px;
            height: 18px;
            border-radius: 4px;
            border: 1px solid var(--border);
            background: var(--bg-dark);
            cursor: pointer;
        }
        .checkbox-label {
            font-size: 0.875rem;
            color: var(--text-secondary);
            cursor: pointer;
        }
        .link-primary {
            color: var(--primary-light);
            text-decoration: none;
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }
        .link-primary:hover {
            color: var(--primary);
            text-decoration: underline;
        }
        .divider {
            text-align: center;
            margin: 24px 0;
            color: var(--text-secondary);
            font-size: 0.875rem;
        }
        .alert {
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 0.875rem;
            background: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.3);
            color: #22c55e;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-logo">
                <div class="auth-logo-icon">
                    <img src="{{ asset('images/logo-uny.png') }}" alt="Logo UNY" style="width:72px;height:72px;object-fit:contain;">
                </div>
                <div class="auth-logo-text">SPK Karir TI</div>
                <div class="auth-logo-inst">Universitas Negeri Yogyakarta</div>
                <div class="auth-subtitle">Sistem Pendukung Keputusan Rekomendasi Karir</div>
            </div>

            @if (session('status'))
                <div class="alert">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="form-input" autocomplete="username" placeholder="nama@email.com" />
                    @error('email')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" type="password" name="password" required class="form-input" autocomplete="current-password" placeholder="••••••••" />
                    @error('password')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="checkbox-group">
                    <input id="remember_me" type="checkbox" name="remember" class="checkbox-input" />
                    <label for="remember_me" class="checkbox-label">Ingat saya</label>
                </div>

                <button type="submit" class="btn-primary">
                    Masuk
                </button>

                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px;">
                    @if (Route::has('password.request'))
                        <a class="link-primary" href="{{ route('password.request') }}">Lupa password?</a>
                    @endif
                    <a class="link-primary" href="{{ route('register') }}">Daftar akun baru</a>
                </div>
            </form>
        </div>
        
        <div style="text-align: center; margin-top: 24px;">
            <a href="{{ route('landing') }}" class="link-primary">← Kembali ke Beranda</a>
        </div>
    </div>
</body>
</html>
