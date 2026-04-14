@extends('layouts.spk')

@section('title', 'Detail Perhitungan TOPSIS')
@section('subtitle', 'Langkah-langkah perhitungan metode AHP-TOPSIS')

@section('content')
@php
    $detail = $result['detail'];
    $hasilData = $result['hasil'];
    $bobotAhp = $detail['bobot_ahp'];
    $kolomKriteria = [
        'C1' => 'Nilai Akademik',
        'C2' => 'Skill Teknis',
        'C3' => 'Minat',
        'C4' => 'Sertifikat',
    ];
    $bobotLabels = array_values($bobotAhp);
    $jumlahKriteria = count($kolomKriteria);
@endphp

{{-- Bobot AHP --}}
<div class="card fade-in" style="margin-bottom: 24px;">
    <h3 style="font-weight: 700; margin-bottom: 16px;">
        <span class="badge badge-primary" style="margin-right: 8px;">Bobot AHP</span>
        Bobot Setiap Kriteria
    </h3>
    <div style="display: flex; gap: 16px; flex-wrap: wrap;">
        @foreach($kolomKriteria as $kode => $nama)
        @php $bIdx = array_search($kode, array_keys($kolomKriteria)); $b = $bobotLabels[$bIdx]; @endphp
        <div style="flex: 1; min-width: 160px; text-align: center; padding: 16px; background: rgba(99,102,241,0.08); border-radius: 12px; border: 1px solid rgba(99,102,241,0.2);">
            <div style="font-weight: 700; font-size: 1.1rem; color: var(--primary-light);">{{ number_format($b * 100, 2) }}%</div>
            <div style="font-size: 0.8rem; color: var(--text-secondary); margin-top: 4px;">{{ $kode }} - {{ $nama }}</div>
        </div>
        @endforeach
    </div>
</div>

{{-- Step 1: Matriks Keputusan --}}
<div class="card fade-in fade-in-delay-1" style="margin-bottom: 24px;">
    <h3 style="font-weight: 700; margin-bottom: 16px;">
        <span class="badge badge-primary" style="margin-right: 8px;">Step 1</span>
        Matriks Keputusan (X)
    </h3>
    <div class="table-container">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Alternatif</th>
                    @foreach($kolomKriteria as $kode => $nama)
                        <th style="text-align: center;">{{ $kode }}<br><small style="font-weight:400;text-transform:none;letter-spacing:0;">{{ $nama }}</small></th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($alternatifs as $i => $alt)
                <tr>
                    <td style="font-weight: 600;">{{ $alt->nama }}</td>
                    @for($j = 0; $j < $jumlahKriteria; $j++)
                        <td style="text-align: center; font-family: monospace;">
                            {{ number_format($detail['matriks_keputusan'][$i][$j], 4) }}
                        </td>
                    @endfor
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Step 2: Normalisasi --}}
<div class="card fade-in fade-in-delay-2" style="margin-bottom: 24px;">
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
                    @foreach($kolomKriteria as $kode => $nama)
                        <th style="text-align: center;">{{ $kode }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($alternatifs as $i => $alt)
                <tr>
                    <td style="font-weight: 600;">{{ $alt->nama }}</td>
                    @for($j = 0; $j < $jumlahKriteria; $j++)
                        <td style="text-align: center; font-family: monospace; font-size: 0.85rem;">
                            {{ number_format($detail['normalisasi'][$i][$j], 6) }}
                        </td>
                    @endfor
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Step 3: Terbobot --}}
<div class="card fade-in fade-in-delay-3" style="margin-bottom: 24px;">
    <h3 style="font-weight: 700; margin-bottom: 16px;">
        <span class="badge badge-primary" style="margin-right: 8px;">Step 3</span>
        Matriks Normalisasi Terbobot (V)
    </h3>
    <p style="font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 12px;">
        Rumus: v<sub>ij</sub> = w<sub>j</sub> × r<sub>ij</sub>
        &nbsp;|&nbsp; Bobot: C1=25.07%, C2=49.67%, C3=10.27%, C4=14.95%
    </p>
    <div class="table-container">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Alternatif</th>
                    @foreach($kolomKriteria as $kode => $nama)
                        <th style="text-align: center;">{{ $kode }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($alternatifs as $i => $alt)
                <tr>
                    <td style="font-weight: 600;">{{ $alt->nama }}</td>
                    @for($j = 0; $j < $jumlahKriteria; $j++)
                        <td style="text-align: center; font-family: monospace; font-size: 0.85rem;">
                            {{ number_format($detail['terbobot'][$i][$j], 6) }}
                        </td>
                    @endfor
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Step 4: Solusi Ideal --}}
<div class="card fade-in fade-in-delay-4" style="margin-bottom: 24px;">
    <h3 style="font-weight: 700; margin-bottom: 16px;">
        <span class="badge badge-primary" style="margin-right: 8px;">Step 4</span>
        Solusi Ideal Positif (A⁺) dan Negatif (A⁻)
    </h3>
    <div class="table-container">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Solusi</th>
                    @foreach($kolomKriteria as $kode => $nama)
                        <th style="text-align: center;">{{ $kode }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><span class="badge badge-success">A⁺ (Positif)</span></td>
                    @for($j = 0; $j < $jumlahKriteria; $j++)
                        <td style="text-align: center; font-family: monospace; font-size: 0.85rem; color: var(--success);">
                            {{ number_format($detail['ideal_positif'][$j], 6) }}
                        </td>
                    @endfor
                </tr>
                <tr>
                    <td><span class="badge badge-danger">A⁻ (Negatif)</span></td>
                    @for($j = 0; $j < $jumlahKriteria; $j++)
                        <td style="text-align: center; font-family: monospace; font-size: 0.85rem; color: var(--danger);">
                            {{ number_format($detail['ideal_negatif'][$j], 6) }}
                        </td>
                    @endfor
                </tr>
            </tbody>
        </table>
    </div>
</div>

{{-- Step 5: Jarak & Preferensi --}}
<div class="card fade-in" style="margin-bottom: 24px;">
    <h3 style="font-weight: 700; margin-bottom: 16px;">
        <span class="badge badge-primary" style="margin-right: 8px;">Step 5</span>
        Jarak ke Solusi Ideal & Nilai Preferensi (Ci)
    </h3>
    <p style="font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 12px;">
        D⁺ = √(Σ(v<sub>ij</sub> - v<sub>j</sub>⁺)²) &nbsp;|&nbsp; D⁻ = √(Σ(v<sub>ij</sub> - v<sub>j</sub>⁻)²) &nbsp;|&nbsp; Ci = D⁻ / (D⁺ + D⁻)
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
                @foreach($hasilData as $h)
                @php
                    $altIdx = array_search($h['alternatif_id'], array_column($detail['alternatifs'], 'id'));
                @endphp
                <tr style="{{ $h['ranking'] <= 3 ? 'background: rgba(99,102,241,0.05);' : '' }}">
                    <td style="font-weight: 600;">{{ $h['nama'] }}</td>
                    <td style="text-align: center; font-family: monospace; font-size: 0.85rem;">
                        {{ $altIdx !== false ? number_format($detail['d_positif'][$altIdx], 6) : '-' }}
                    </td>
                    <td style="text-align: center; font-family: monospace; font-size: 0.85rem;">
                        {{ $altIdx !== false ? number_format($detail['d_negatif'][$altIdx], 6) : '-' }}
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
