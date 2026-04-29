<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lupa Password - {{ config('app.name', 'SPK Karir TI') }}</title>
    
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
        .auth-logo {
            text-align: center;
            margin-bottom: 32px;
        }
        .auth-logo-text {
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--text-primary);
            margin-bottom: 4px;
        }
        .auth-logo-inst {
            font-size: 0.7rem;
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
        .alert {
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 0.875rem;
            background: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.3);
            color: #22c55e;
        }
        .info-text {
            color: var(--text-secondary);
            font-size: 0.875rem;
            line-height: 1.6;
            margin-bottom: 24px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-logo">
                <div style="display:flex;justify-content:center;margin-bottom:14px;">
                    <img src="{{ asset('images/logo-uny.png') }}" alt="Logo UNY" style="width:72px;height:72px;object-fit:contain;">
                </div>
                <div class="auth-logo-text">SPK Karir TI</div>
                <div class="auth-logo-inst">Universitas Negeri Yogyakarta</div>
                <div class="auth-subtitle">Reset Password Akun</div>
            </div>

            <div class="info-text">
                Masukkan email Anda dan kami akan mengirimkan link untuk mereset password Anda.
            </div>

            @if (session('status'))
                <div class="alert">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="form-input" autocomplete="username" placeholder="nama@email.com" />
                    @error('email')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn-primary">
                    Kirim Link Reset Password
                </button>

                <div style="text-align: center; margin-top: 20px;">
                    <a class="link-primary" href="{{ route('login') }}">← Kembali ke Login</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
