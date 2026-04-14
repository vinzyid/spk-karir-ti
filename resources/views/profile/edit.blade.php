@extends('layouts.spk')

@section('title', 'Pengaturan Akun')
@section('subtitle', 'Kelola informasi profil dan keamanan akun')

@section('content')

{{-- Avatar & Info Header --}}
<div class="card fade-in" style="margin-bottom: 24px; padding: 28px;">
    <div style="display: flex; align-items: center; gap: 24px; flex-wrap: wrap;">
        <div style="width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), var(--secondary)); display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: 800; flex-shrink: 0; box-shadow: 0 0 30px rgba(99,102,241,0.3);">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>
        <div>
            <h2 style="font-weight: 800; font-size: 1.3rem; margin: 0 0 4px 0;">{{ auth()->user()->name }}</h2>
            <div style="color: var(--text-secondary); font-size: 0.9rem;">{{ auth()->user()->email }}</div>
            <div style="margin-top: 8px;">
                <span class="badge {{ auth()->user()->isAdmin() ? 'badge-warning' : 'badge-primary' }}">
                    {{ auth()->user()->isAdmin() ? '👑 Admin' : '🎓 Mahasiswa' }}
                </span>
            </div>
        </div>
    </div>
</div>

<div class="grid-2 fade-in fade-in-delay-1" style="gap: 24px; align-items: start;">

    {{-- KOLOM KIRI: Update Profile --}}
    <div>
        <div class="card" style="margin-bottom: 24px;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid var(--border);">
                <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(99,102,241,0.15); display: flex; align-items: center; justify-content: center; font-size: 1.1rem;">👤</div>
                <div>
                    <h3 style="font-weight: 700; margin: 0; font-size: 1rem;">Informasi Profil</h3>
                    <p style="color: var(--text-secondary); font-size: 0.8rem; margin: 0;">Perbarui nama dan alamat email</p>
                </div>
            </div>

            <form method="post" action="{{ route('profile.update') }}">
                @csrf
                @method('patch')

                <div class="form-group" style="margin-bottom: 16px;">
                    <label class="form-label" for="name">Nama Lengkap</label>
                    <input id="name" name="name" type="text" class="form-input"
                        value="{{ old('name', $user->name) }}" required autofocus autocomplete="name"
                        placeholder="Masukkan nama lengkap">
                    @error('name')
                        <p style="color: var(--danger); font-size: 0.8rem; margin-top: 6px;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group" style="margin-bottom: 24px;">
                    <label class="form-label" for="email">Alamat Email</label>
                    <input id="email" name="email" type="email" class="form-input"
                        value="{{ old('email', $user->email) }}" required autocomplete="username"
                        placeholder="Masukkan email">
                    @error('email')
                        <p style="color: var(--danger); font-size: 0.8rem; margin-top: 6px;">{{ $message }}</p>
                    @enderror

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <div style="margin-top: 8px; padding: 10px 14px; background: rgba(245,158,11,0.1); border: 1px solid rgba(245,158,11,0.3); border-radius: 10px;">
                            <p style="font-size: 0.82rem; color: var(--warning); margin: 0;">
                                Email belum diverifikasi.
                                <form id="send-verification" method="post" action="{{ route('verification.send') }}" style="display: inline;">
                                    @csrf
                                    <button type="submit" style="background: none; border: none; color: var(--primary-light); text-decoration: underline; cursor: pointer; font-size: 0.82rem;">
                                        Kirim ulang verifikasi
                                    </button>
                                </form>
                            </p>
                        </div>
                    @endif
                </div>

                <div style="display: flex; align-items: center; gap: 12px;">
                    <button type="submit" class="btn-primary">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Simpan Perubahan
                    </button>
                    @if (session('status') === 'profile-updated')
                        <span style="font-size: 0.85rem; color: var(--success);">✓ Berhasil disimpan!</span>
                    @endif
                </div>
            </form>
        </div>

        {{-- Hapus Akun --}}
        <div class="card" style="border-color: rgba(239,68,68,0.3);">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 20px; padding-bottom: 16px; border-bottom: 1px solid rgba(239,68,68,0.2);">
                <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(239,68,68,0.15); display: flex; align-items: center; justify-content: center; font-size: 1.1rem;">⚠️</div>
                <div>
                    <h3 style="font-weight: 700; margin: 0; font-size: 1rem; color: var(--danger);">Zona Berbahaya</h3>
                    <p style="color: var(--text-secondary); font-size: 0.8rem; margin: 0;">Tindakan tidak dapat dibatalkan</p>
                </div>
            </div>

            <p style="color: var(--text-secondary); font-size: 0.85rem; margin-bottom: 16px; line-height: 1.6;">
                Setelah akun dihapus, semua data termasuk nilai, penilaian, dan hasil rekomendasi akan <strong style="color: var(--danger);">dihapus permanen</strong>.
            </p>

            <button type="button" onclick="document.getElementById('deleteModal').style.display='flex'"
                style="padding: 10px 20px; background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.4); color: var(--danger); border-radius: 12px; font-weight: 600; cursor: pointer; font-size: 0.875rem; transition: all 0.2s;">
                🗑️ Hapus Akun Saya
            </button>
        </div>
    </div>

    {{-- KOLOM KANAN: Ganti Password --}}
    <div class="card">
        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid var(--border);">
            <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(139,92,246,0.15); display: flex; align-items: center; justify-content: center; font-size: 1.1rem;">🔒</div>
            <div>
                <h3 style="font-weight: 700; margin: 0; font-size: 1rem;">Ubah Password</h3>
                <p style="color: var(--text-secondary); font-size: 0.8rem; margin: 0;">Gunakan password yang kuat dan unik</p>
            </div>
        </div>

        <form method="post" action="{{ route('password.update') }}">
            @csrf
            @method('put')

            <div class="form-group" style="margin-bottom: 16px;">
                <label class="form-label" for="update_password_current_password">Password Saat Ini</label>
                <div style="position: relative;">
                    <input id="update_password_current_password" name="current_password" type="password"
                        class="form-input" autocomplete="current-password" placeholder="Masukkan password lama"
                        style="padding-right: 44px;">
                    <button type="button" onclick="togglePass('update_password_current_password', this)"
                        style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--text-secondary); cursor: pointer; font-size: 1rem;">👁</button>
                </div>
                @error('current_password', 'updatePassword')
                    <p style="color: var(--danger); font-size: 0.8rem; margin-top: 6px;">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group" style="margin-bottom: 16px;">
                <label class="form-label" for="update_password_password">Password Baru</label>
                <div style="position: relative;">
                    <input id="update_password_password" name="password" type="password"
                        class="form-input" autocomplete="new-password" placeholder="Minimal 8 karakter"
                        style="padding-right: 44px;">
                    <button type="button" onclick="togglePass('update_password_password', this)"
                        style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--text-secondary); cursor: pointer; font-size: 1rem;">👁</button>
                </div>
                @error('password', 'updatePassword')
                    <p style="color: var(--danger); font-size: 0.8rem; margin-top: 6px;">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group" style="margin-bottom: 24px;">
                <label class="form-label" for="update_password_password_confirmation">Konfirmasi Password Baru</label>
                <div style="position: relative;">
                    <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                        class="form-input" autocomplete="new-password" placeholder="Ulangi password baru"
                        style="padding-right: 44px;">
                    <button type="button" onclick="togglePass('update_password_password_confirmation', this)"
                        style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--text-secondary); cursor: pointer; font-size: 1rem;">👁</button>
                </div>
                @error('password_confirmation', 'updatePassword')
                    <p style="color: var(--danger); font-size: 0.8rem; margin-top: 6px;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password strength indicator --}}
            <div style="margin-bottom: 20px;" id="strengthContainer" style="display:none;">
                <div style="font-size: 0.75rem; color: var(--text-secondary); margin-bottom: 6px;">Kekuatan password:</div>
                <div style="height: 4px; border-radius: 2px; background: rgba(99,102,241,0.1); overflow: hidden;">
                    <div id="strengthBar" style="height: 100%; border-radius: 2px; width: 0%; transition: all 0.3s;"></div>
                </div>
                <div id="strengthText" style="font-size: 0.75rem; margin-top: 4px;"></div>
            </div>

            <div style="display: flex; align-items: center; gap: 12px;">
                <button type="submit" class="btn-primary">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    Ubah Password
                </button>
                @if (session('status') === 'password-updated')
                    <span style="font-size: 0.85rem; color: var(--success);">✓ Password diperbarui!</span>
                @endif
            </div>
        </form>
    </div>

</div>

{{-- Modal Hapus Akun --}}
<div id="deleteModal" style="display: none; position: fixed; inset: 0; z-index: 100; align-items: center; justify-content: center; background: rgba(0,0,0,0.7); backdrop-filter: blur(4px);">
    <div class="card" style="max-width: 440px; width: 90%; margin: 20px; border-color: rgba(239,68,68,0.4); box-shadow: 0 0 40px rgba(239,68,68,0.2);">
        <div style="text-align: center; margin-bottom: 20px;">
            <div style="font-size: 3rem; margin-bottom: 12px;">🗑️</div>
            <h3 style="font-weight: 700; font-size: 1.1rem; margin-bottom: 8px; color: var(--danger);">Hapus Akun?</h3>
            <p style="color: var(--text-secondary); font-size: 0.88rem; line-height: 1.6;">
                Semua data, nilai, penilaian, dan hasil rekomendasi akan <strong style="color: var(--danger);">dihapus permanen</strong> dan tidak bisa dipulihkan.
            </p>
        </div>

        <form method="post" action="{{ route('profile.destroy') }}">
            @csrf
            @method('delete')

            <div class="form-group" style="margin-bottom: 20px;">
                <label class="form-label" for="delete_password">Konfirmasi dengan Password</label>
                <input id="delete_password" name="password" type="password" class="form-input"
                    placeholder="Masukkan password Anda" required>
                @error('password', 'userDeletion')
                    <p style="color: var(--danger); font-size: 0.8rem; margin-top: 6px;">{{ $message }}</p>
                @enderror
            </div>

            <div style="display: flex; gap: 12px;">
                <button type="button" onclick="document.getElementById('deleteModal').style.display='none'"
                    class="btn-secondary" style="flex: 1; justify-content: center;">
                    Batal
                </button>
                <button type="submit"
                    style="flex: 1; padding: 10px; background: linear-gradient(135deg, #dc2626, #b91c1c); color: white; border: none; border-radius: 12px; font-weight: 700; cursor: pointer;">
                    Ya, Hapus Akun
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
// Toggle show/hide password
function togglePass(inputId, btn) {
    const input = document.getElementById(inputId);
    if (input.type === 'password') {
        input.type = 'text';
        btn.textContent = '🙈';
    } else {
        input.type = 'password';
        btn.textContent = '👁';
    }
}

// Password strength checker
const pwInput = document.getElementById('update_password_password');
if (pwInput) {
    pwInput.addEventListener('input', function() {
        const val = this.value;
        const bar = document.getElementById('strengthBar');
        const txt = document.getElementById('strengthText');
        document.getElementById('strengthContainer').style.display = val ? 'block' : 'none';

        let score = 0;
        if (val.length >= 8) score++;
        if (/[A-Z]/.test(val)) score++;
        if (/[0-9]/.test(val)) score++;
        if (/[^A-Za-z0-9]/.test(val)) score++;

        const levels = [
            { width: '25%', color: '#ef4444', label: 'Sangat Lemah' },
            { width: '50%', color: '#f59e0b', label: 'Lemah' },
            { width: '75%', color: '#6366f1', label: 'Cukup Kuat' },
            { width: '100%', color: '#22c55e', label: 'Kuat 💪' },
        ];
        const lvl = levels[Math.max(0, score - 1)];
        bar.style.width = lvl.width;
        bar.style.background = lvl.color;
        txt.textContent = lvl.label;
        txt.style.color = lvl.color;
    });
}

// Close modal on backdrop click
document.getElementById('deleteModal')?.addEventListener('click', function(e) {
    if (e.target === this) this.style.display = 'none';
});
</script>
@endsection
