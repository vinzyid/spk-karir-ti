@extends('layouts.spk')

@section('title', 'Input Penilaian')
@section('subtitle', 'Berikan penilaian 1-5 untuk setiap alternatif karir')

@section('content')
<div class="card fade-in" style="margin-bottom: 24px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
        <div>
            <h3 style="font-weight: 700; margin-bottom: 4px;">📝 Matriks Penilaian</h3>
            <p style="font-size: 0.85rem; color: var(--text-secondary);">
                Berikan nilai 1-5 untuk setiap karir berdasarkan kriteria yang tersedia.
            </p>
        </div>
        <div style="display: flex; gap: 8px; flex-wrap: wrap;">
            <span class="badge badge-primary">1 = Sangat Rendah</span>
            <span class="badge badge-primary">2 = Rendah</span>
            <span class="badge badge-primary">3 = Cukup</span>
            <span class="badge badge-primary">4 = Tinggi</span>
            <span class="badge badge-primary">5 = Sangat Tinggi</span>
        </div>
    </div>
</div>

<form action="{{ route('penilaian.store') }}" method="POST">
    @csrf

    <div class="card fade-in fade-in-delay-1" style="margin-bottom: 24px;">
        <div class="table-container">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th style="min-width: 180px;">Alternatif Karir</th>
                        @foreach($kriteria as $k)
                            <th style="text-align: center; min-width: 130px;">
                                <div>{{ $k->kode }}</div>
                                <div style="font-weight: 400; text-transform: none; letter-spacing: 0; font-size: 0.75rem; margin-top: 2px;">
                                    {{ $k->nama }}
                                </div>
                                <div style="font-weight: 400; text-transform: none; letter-spacing: 0; font-size: 0.7rem; color: var(--primary-light);">
                                    ({{ number_format($k->bobot * 100, 2) }}%)
                                </div>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($alternatifs as $alt)
                    <tr>
                        <td>
                            <div style="font-weight: 600;">{{ $alt->nama }}</div>
                            <div style="font-size: 0.75rem; color: var(--text-secondary); max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                {{ $alt->deskripsi }}
                            </div>
                        </td>
                        @foreach($kriteria as $k)
                        <td style="text-align: center;">
                            <select
                                name="nilai[{{ $alt->id }}][{{ $k->id }}]"
                                class="form-select"
                                style="width: 80px; text-align: center; padding: 8px;"
                                required>
                                @for($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}"
                                        {{ (isset($existingPenilaian[$alt->id][$k->id]) && (int)$existingPenilaian[$alt->id][$k->id] == $i) ? 'selected' : '' }}>
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @error('nilai')
        <div class="alert alert-error">{{ $message }}</div>
    @enderror

    <div style="display: flex; gap: 12px; flex-wrap: wrap;">
        <button type="submit" class="btn-primary">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            Simpan Penilaian
        </button>
        <a href="{{ route('dashboard') }}" class="btn-secondary">Kembali</a>
    </div>
</form>

@if(count($existingPenilaian) > 0)
<div style="margin-top: 16px;">
    <form action="{{ route('penilaian.calculate') }}" method="POST" style="display: inline;">
        @csrf
        <button type="submit" class="btn-primary" style="background: linear-gradient(135deg, #22c55e, #16a34a);">
            🚀 Hitung Rekomendasi
        </button>
    </form>
</div>
@endif
@endsection
