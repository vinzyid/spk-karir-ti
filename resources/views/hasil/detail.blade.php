@extends('layouts.spk')

@section('title', 'Detail Perhitungan TOPSIS')
@section('subtitle', 'Langkah-langkah perhitungan metode TOPSIS')

@section('content')
@php
    $detail = $result['detail'];
    $hasil = $result['hasil'];
@endphp

<!-- Step 1: Matriks Keputusan -->
<div class="card fade-in" style="margin-bottom: 24px;">
    <h3 style="font-weight: 700; margin-bottom: 16px;">
        <span class="badge badge-primary" style="margin-right: 8px;">Step 1</span>
        Matriks Keputusan (X)
    </h3>
    <div class="table-container">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Alternatif</th>
                    @foreach($kriteria as $k)
                        <th style="text-align: center;">{{ $k->kode }} ({{ $k->nama }})</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($alternatifs as $i => $alt)
                <tr>
                    <td style="font-weight: 600;">{{ $alt->nama }}</td>
                    @foreach($kriteria as $j => $k)
                        <td style="text-align: center; font-family: monospace;">
                            {{ number_format($detail['matriks_keputusan'][$i][$j], 4) }}
                        </td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Step 2: Normalisasi -->
<div class="card fade-in fade-in-delay-1" style="margin-bottom: 24px;">
    <h3 style="font-weight: 700; margin-bottom: 16px;">
        <span class="badge badge-primary" style="margin-right: 8px;">Step 2</span>
        Matriks Normalisasi (R)
    </h3>
    <p style="font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 12px;">
        Rumus: r<sub>ij</sub> = x<sub>ij</sub> / √(Σ x<sub>ij</sub>²)
    </p>
    <div class="table-container">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Alternatif</th>
                    @foreach($kriteria as $k)
                        <th style="text-align: center;">{{ $k->kode }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($alternatifs as $i => $alt)
                <tr>
                    <td style="font-weight: 600;">{{ $alt->nama }}</td>
                    @foreach($kriteria as $j => $k)
                        <td style="text-align: center; font-family: monospace; font-size: 0.85rem;">
                            {{ number_format($detail['normalisasi'][$i][$j], 6) }}
                        </td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Step 3: Terbobot -->
<div class="card fade-in fade-in-delay-2" style="margin-bottom: 24px;">
    <h3 style="font-weight: 700; margin-bottom: 16px;">
        <span class="badge badge-primary" style="margin-right: 8px;">Step 3</span>
        Matriks Normalisasi Terbobot (V)
    </h3>
    <p style="font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 12px;">
        Rumus: v<sub>ij</sub> = w<sub>j</sub> × r<sub>ij</sub>
        &nbsp;|&nbsp; Bobot:
        @foreach($kriteria as $k)
            {{ $k->kode }}={{ $k->bobot }}{{ !$loop->last ? ', ' : '' }}
        @endforeach
    </p>
    <div class="table-container">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Alternatif</th>
                    @foreach($kriteria as $k)
                        <th style="text-align: center;">{{ $k->kode }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($alternatifs as $i => $alt)
                <tr>
                    <td style="font-weight: 600;">{{ $alt->nama }}</td>
                    @foreach($kriteria as $j => $k)
                        <td style="text-align: center; font-family: monospace; font-size: 0.85rem;">
                            {{ number_format($detail['terbobot'][$i][$j], 6) }}
                        </td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Step 4: Solusi Ideal -->
<div class="card fade-in fade-in-delay-3" style="margin-bottom: 24px;">
    <h3 style="font-weight: 700; margin-bottom: 16px;">
        <span class="badge badge-primary" style="margin-right: 8px;">Step 4</span>
        Solusi Ideal Positif (A⁺) dan Negatif (A⁻)
    </h3>
    <div class="table-container">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Solusi</th>
                    @foreach($kriteria as $k)
                        <th style="text-align: center;">{{ $k->kode }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><span class="badge badge-success">A⁺ (Positif)</span></td>
                    @foreach($kriteria as $j => $k)
                        <td style="text-align: center; font-family: monospace; font-size: 0.85rem; color: var(--success);">
                            {{ number_format($detail['ideal_positif'][$j], 6) }}
                        </td>
                    @endforeach
                </tr>
                <tr>
                    <td><span class="badge badge-danger">A⁻ (Negatif)</span></td>
                    @foreach($kriteria as $j => $k)
                        <td style="text-align: center; font-family: monospace; font-size: 0.85rem; color: var(--danger);">
                            {{ number_format($detail['ideal_negatif'][$j], 6) }}
                        </td>
                    @endforeach
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Step 5: Jarak & Preferensi -->
<div class="card fade-in fade-in-delay-4" style="margin-bottom: 24px;">
    <h3 style="font-weight: 700; margin-bottom: 16px;">
        <span class="badge badge-primary" style="margin-right: 8px;">Step 5</span>
        Jarak ke Solusi Ideal & Nilai Preferensi
    </h3>
    <p style="font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 12px;">
        D⁺ = √(Σ(vij - vj⁺)²) &nbsp;|&nbsp; D⁻ = √(Σ(vij - vj⁻)²) &nbsp;|&nbsp; Ci = D⁻ / (D⁺ + D⁻)
    </p>
    <div class="table-container">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Alternatif</th>
                    <th style="text-align: center;">D⁺</th>
                    <th style="text-align: center;">D⁻</th>
                    <th style="text-align: center;">Preferensi (Ci)</th>
                    <th style="text-align: center;">Ranking</th>
                </tr>
            </thead>
            <tbody>
                @foreach($hasil as $h)
                @php
                    $altIndex = array_search($h['alternatif_id'], array_column($detail['alternatifs'], 'id'));
                @endphp
                <tr style="{{ $h['ranking'] <= 3 ? 'background: rgba(99,102,241,0.05);' : '' }}">
                    <td style="font-weight: 600;">{{ $h['nama'] }}</td>
                    <td style="text-align: center; font-family: monospace; font-size: 0.85rem;">
                        {{ $altIndex !== false ? number_format($detail['d_positif'][$altIndex], 6) : '-' }}
                    </td>
                    <td style="text-align: center; font-family: monospace; font-size: 0.85rem;">
                        {{ $altIndex !== false ? number_format($detail['d_negatif'][$altIndex], 6) : '-' }}
                    </td>
                    <td style="text-align: center; font-family: monospace; font-size: 0.85rem; font-weight: 700; color: var(--primary-light);">
                        {{ number_format($h['skor'], 6) }}
                    </td>
                    <td style="text-align: center;">
                        @if($h['ranking'] <= 3)
                            <div class="medal medal-{{ $h['ranking'] }}" style="width: 32px; height: 32px; font-size: 0.85rem; margin: 0 auto;">
                                {{ $h['ranking'] }}
                            </div>
                        @else
                            <span style="font-weight: 700; color: var(--text-secondary);">#{{ $h['ranking'] }}</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div style="display: flex; gap: 12px; flex-wrap: wrap;">
    <a href="{{ route('hasil.index') }}" class="btn-primary">← Kembali ke Hasil</a>
    <a href="{{ route('dashboard') }}" class="btn-secondary">Dashboard</a>
</div>
@endsection
