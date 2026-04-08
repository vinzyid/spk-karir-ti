@extends('layouts.spk')

@section('title', 'Data Mahasiswa')
@section('subtitle', 'Lengkapi informasi data diri Anda')

@section('content')
<div style="max-width: 640px;">
    <div class="card fade-in">
        <div style="margin-bottom: 24px;">
            <h3 style="font-weight: 700; margin-bottom: 8px;">
                {{ $mahasiswa ? '✏️ Edit Data Mahasiswa' : '📝 Input Data Mahasiswa' }}
            </h3>
            <p style="font-size: 0.85rem; color: var(--text-secondary);">
                {{ $mahasiswa ? 'Perbarui informasi data diri Anda.' : 'Silakan isi data diri untuk memulai analisis karir.' }}
            </p>
        </div>

        <form action="{{ route('mahasiswa.store') }}" method="POST">
            @csrf

            <div style="margin-bottom: 20px;">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama" class="form-input" placeholder="Masukkan nama lengkap"
                    value="{{ old('nama', $mahasiswa?->nama ?? '') }}" required>
                @error('nama')
                    <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>

            <div style="margin-bottom: 20px;">
                <label class="form-label">NIM (Nomor Induk Mahasiswa)</label>
                <input type="text" name="nim" class="form-input" placeholder="Contoh: 2023001234"
                    value="{{ old('nim', $mahasiswa?->nim ?? '') }}" required>
                @error('nim')
                    <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>

            <div style="margin-bottom: 28px;">
                <label class="form-label">Program Studi</label>
                <select name="prodi" class="form-select" required>
                    <option value="">-- Pilih Program Studi --</option>
                    @php
                        $prodiList = ['Teknologi Informasi', 'Teknik Informatika', 'Sistem Informasi', 'Ilmu Komputer', 'Teknik Komputer'];
                        $currentProdi = old('prodi', $mahasiswa?->prodi ?? '');
                    @endphp
                    @foreach($prodiList as $p)
                        <option value="{{ $p }}" {{ $currentProdi == $p ? 'selected' : '' }}>{{ $p }}</option>
                    @endforeach
                </select>
                @error('prodi')
                    <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>

            <div style="display: flex; gap: 12px;">
                <button type="submit" class="btn-primary">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    {{ $mahasiswa ? 'Perbarui Data' : 'Simpan Data' }}
                </button>
                <a href="{{ route('dashboard') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
