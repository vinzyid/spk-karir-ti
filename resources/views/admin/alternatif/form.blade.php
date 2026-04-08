@extends('layouts.spk')

@section('title', isset($alternatif) ? 'Edit Alternatif' : 'Tambah Alternatif')
@section('subtitle', isset($alternatif) ? 'Perbarui data alternatif karir' : 'Tambahkan alternatif karir baru')

@section('content')
<div style="max-width: 560px;">
    <div class="card fade-in">
        <form action="{{ isset($alternatif) ? route('admin.alternatif.update', $alternatif) : route('admin.alternatif.store') }}" method="POST">
            @csrf
            @if(isset($alternatif)) @method('PUT') @endif

            <div style="margin-bottom: 20px;">
                <label class="form-label">Nama Karir</label>
                <input type="text" name="nama" class="form-input" placeholder="Contoh: Web Developer"
                    value="{{ old('nama', $alternatif->nama ?? '') }}" required>
                @error('nama')
                    <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>

            <div style="margin-bottom: 28px;">
                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-input" rows="4"
                    placeholder="Deskripsi singkat tentang karir ini...">{{ old('deskripsi', $alternatif->deskripsi ?? '') }}</textarea>
                @error('deskripsi')
                    <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>

            <div style="display: flex; gap: 12px;">
                <button type="submit" class="btn-primary">
                    {{ isset($alternatif) ? 'Perbarui' : 'Simpan' }}
                </button>
                <a href="{{ route('admin.alternatif.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
