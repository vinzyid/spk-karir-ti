@extends('layouts.spk')

@section('title', isset($kriteria) ? 'Edit Kriteria' : 'Tambah Kriteria')
@section('subtitle', isset($kriteria) ? 'Perbarui data kriteria' : 'Tambahkan kriteria baru')

@section('content')
<div style="max-width: 560px;">
    <div class="card fade-in">
        <form action="{{ isset($kriteria) ? route('admin.kriteria.update', $kriteria) : route('admin.kriteria.store') }}" method="POST">
            @csrf
            @if(isset($kriteria)) @method('PUT') @endif

            <div style="margin-bottom: 20px;">
                <label class="form-label">Kode Kriteria</label>
                <input type="text" name="kode" class="form-input" placeholder="C1, C2, dst."
                    value="{{ old('kode', $kriteria->kode ?? '') }}" required>
                @error('kode')
                    <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>

            <div style="margin-bottom: 20px;">
                <label class="form-label">Nama Kriteria</label>
                <input type="text" name="nama" class="form-input" placeholder="Contoh: Nilai Akademik"
                    value="{{ old('nama', $kriteria->nama ?? '') }}" required>
                @error('nama')
                    <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>

            <div style="margin-bottom: 20px;">
                <label class="form-label">Bobot (0 - 1)</label>
                <input type="number" name="bobot" class="form-input" step="0.0001" min="0" max="1"
                    placeholder="0.2507" value="{{ old('bobot', $kriteria->bobot ?? '') }}" required>
                @error('bobot')
                    <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>

            <div style="margin-bottom: 28px;">
                <label class="form-label">Tipe Kriteria</label>
                <select name="tipe" class="form-select" required>
                    <option value="benefit" {{ old('tipe', $kriteria->tipe ?? '') == 'benefit' ? 'selected' : '' }}>Benefit (semakin tinggi semakin baik)</option>
                    <option value="cost" {{ old('tipe', $kriteria->tipe ?? '') == 'cost' ? 'selected' : '' }}>Cost (semakin rendah semakin baik)</option>
                </select>
                @error('tipe')
                    <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>

            <div style="display: flex; gap: 12px;">
                <button type="submit" class="btn-primary">
                    {{ isset($kriteria) ? 'Perbarui' : 'Simpan' }}
                </button>
                <a href="{{ route('admin.kriteria.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
