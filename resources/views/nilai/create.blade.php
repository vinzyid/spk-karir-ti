@extends('layouts.spk')

@section('title', 'Input Nilai Mata Kuliah')
@section('subtitle', 'Masukkan nilai untuk setiap mata kuliah')

@section('content')
<div class="card fade-in">
    <div style="margin-bottom: 24px;">
        <h3 style="font-weight: 700; margin-bottom: 8px;">📝 Input Nilai Mata Kuliah</h3>
        <p style="color: var(--text-secondary); font-size: 0.9rem;">
            Masukkan nilai Anda untuk setiap mata kuliah (skala 0-100). Nilai ini akan digunakan untuk menghitung rekomendasi karir yang sesuai.
        </p>
    </div>

    <form method="POST" action="{{ route('nilai.store') }}">
        @csrf
        
        <div class="grid-2" style="gap: 20px;">
            @foreach($mataKuliah as $mk)
            <div class="form-group">
                <label for="nilai_{{ $mk->id }}" class="form-label">
                    {{ $mk->kode }} - {{ $mk->nama }}
                </label>
                <input 
                    type="number" 
                    id="nilai_{{ $mk->id }}" 
                    name="nilai[{{ $mk->id }}]" 
                    class="form-input" 
                    min="0" 
                    max="100" 
                    step="0.01"
                    value="{{ $nilaiTersimpan->get($mk->id)?->nilai ?? old('nilai.'.$mk->id) }}"
                    placeholder="0-100"
                    required
                />
                @error('nilai.'.$mk->id)
                    <p style="color: var(--danger); font-size: 0.8rem; margin-top: 6px;">{{ $message }}</p>
                @enderror
            </div>
            @endforeach
        </div>

        @error('nilai')
            <div class="alert alert-error" style="margin-top: 20px;">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ $message }}
            </div>
        @enderror

        <div style="display: flex; gap: 12px; margin-top: 32px; padding-top: 24px; border-top: 1px solid var(--border);">
            <button type="submit" class="btn-primary">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Simpan Nilai
            </button>
            <a href="{{ route('dashboard') }}" class="btn-secondary">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali
            </a>
        </div>
    </form>
</div>

<div class="card fade-in fade-in-delay-1" style="margin-top: 24px;">
    <h3 style="font-weight: 700; margin-bottom: 16px;">💡 Tips Pengisian</h3>
    <ul style="color: var(--text-secondary); line-height: 1.8; padding-left: 20px;">
        <li>Masukkan nilai sesuai dengan transkrip nilai Anda</li>
        <li>Nilai dalam skala 0-100 (bisa desimal, contoh: 85.5)</li>
        <li>Pastikan semua mata kuliah terisi sebelum menyimpan</li>
        <li>Nilai yang Anda masukkan akan digunakan untuk menghitung kesesuaian dengan setiap jalur karir</li>
        <li>Setiap karir memiliki bobot berbeda untuk setiap mata kuliah</li>
    </ul>
</div>

@endsection

@section('scripts')
<script>
    // Auto-save to localStorage, scoped per user to prevent data leak
    const userId = "{{ auth()->id() }}";
    const inputs = document.querySelectorAll('input[type="number"]');
    
    inputs.forEach(input => {
        const storageKey = 'spk_nilai_' + userId + '_' + input.name;
        
        // Load from localStorage
        const saved = localStorage.getItem(storageKey);
        if (saved && !input.value) {
            input.value = saved;
        }
        
        // Save on change
        input.addEventListener('change', () => {
            localStorage.setItem(storageKey, input.value);
        });
    });
    
    // Clear localStorage on submit
    document.querySelector('form').addEventListener('submit', () => {
        inputs.forEach(input => {
            const storageKey = 'spk_nilai_' + userId + '_' + input.name;
            localStorage.removeItem(storageKey);
        });
    });
</script>
@endsection
