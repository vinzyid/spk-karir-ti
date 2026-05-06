@extends('layouts.spk')

@section('title', 'Detail Mahasiswa')
@section('subtitle', $mahasiswa->nama)

@section('content')
<div style="margin-bottom: 20px;">
    <a href="{{ route('admin.mahasiswa.index') }}" class="btn-secondary btn-sm">
        ← Kembali ke Daftar
    </a>
</div>

<!-- Profil Mahasiswa -->
<div class="card fade-in" style="margin-bottom: 24px;">
    <h3 style="font-weight: 700; margin-bottom: 20px;">👤 Profil Mahasiswa</h3>
    <div class="grid-3">
        <div>
            <div style="font-size: 0.8rem; color: var(--text-secondary); margin-bottom: 4px;">Nama Lengkap</div>
            <div style="font-weight: 600;">{{ $mahasiswa->nama }}</div>
        </div>
        <div>
            <div style="font-size: 0.8rem; color: var(--text-secondary); margin-bottom: 4px;">NIM</div>
            <div style="font-weight: 600;">{{ $mahasiswa->nim }}</div>
        </div>
        <div>
            <div style="font-size: 0.8rem; color: var(--text-secondary); margin-bottom: 4px;">Program Studi</div>
            <div style="font-weight: 600;">{{ $mahasiswa->prodi }}</div>
        </div>
        <div>
            <div style="font-size: 0.8rem; color: var(--text-secondary); margin-bottom: 4px;">Email</div>
            <div style="font-weight: 600;">{{ $user->email }}</div>
        </div>
        <div>
            <div style="font-size: 0.8rem; color: var(--text-secondary); margin-bottom: 4px;">Tanggal Daftar</div>
            <div style="font-weight: 600;">{{ $user->created_at->format('d M Y, H:i') }}</div>
        </div>
        <div>
            <div style="font-size: 0.8rem; color: var(--text-secondary); margin-bottom: 4px;">Skill Teknis</div>
            <div style="font-weight: 600;">
                @php
                    $skills = $user->saved_skills;
                    if (is_string($skills)) {
                        $skills = json_decode($skills, true) ?? [];
                    }
                @endphp
                @if(is_array($skills) && count($skills) > 0)
                    @foreach($skills as $skill)
                        <span class="badge badge-primary" style="margin: 2px;">{{ $skill }}</span>
                    @endforeach
                @else
                    <span style="color: var(--text-secondary);">Belum diisi</span>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Nilai Mata Kuliah -->
<div class="card fade-in fade-in-delay-1" style="margin-bottom: 24px;">
    <h3 style="font-weight: 700; margin-bottom: 20px;">📝 Nilai Mata Kuliah</h3>
    @if($nilaiMk->isEmpty())
        <div style="text-align: center; padding: 40px; color: var(--text-secondary);">
            Mahasiswa belum menginput nilai mata kuliah.
        </div>
    @else
        <div class="table-container">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Mata Kuliah</th>
                        <th>Nilai</th>
                        <th>Huruf</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($nilaiMk as $index => $nilai)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td style="font-weight: 600;">{{ $nilai->kriteria->nama ?? '-' }}</td>
                        <td style="font-family: monospace; font-weight: 600;">{{ number_format($nilai->nilai, 2) }}</td>
                        <td>
                            @php
                                $n = $nilai->nilai;
                                $huruf = $n >= 85 ? 'A' : ($n >= 80 ? 'A-' : ($n >= 75 ? 'B+' : ($n >= 70 ? 'B' : ($n >= 65 ? 'B-' : ($n >= 60 ? 'C+' : ($n >= 55 ? 'C' : 'D'))))));
                                $badgeClass = $n >= 75 ? 'badge-success' : ($n >= 60 ? 'badge-warning' : 'badge-danger');
                            @endphp
                            <span class="badge {{ $badgeClass }}">{{ $huruf }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<!-- Hasil Rekomendasi Karir -->
<div class="card fade-in fade-in-delay-2">
    <h3 style="font-weight: 700; margin-bottom: 20px;">🏆 Hasil Rekomendasi Karir</h3>
    @if($hasilRekomendasi->isEmpty())
        <div style="text-align: center; padding: 40px; color: var(--text-secondary);">
            Mahasiswa belum melakukan perhitungan rekomendasi karir.
        </div>
    @else
        <div class="table-container">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Ranking</th>
                        <th>Karir</th>
                        <th>Skor TOPSIS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($hasilRekomendasi as $hasil)
                    <tr>
                        <td>
                            @if($hasil->ranking <= 3)
                                <div class="medal medal-{{ $hasil->ranking }}">{{ $hasil->ranking }}</div>
                            @else
                                <span style="font-weight: 600; padding-left: 12px;">{{ $hasil->ranking }}</span>
                            @endif
                        </td>
                        <td style="font-weight: 600;">{{ $hasil->alternatif->nama ?? '-' }}</td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="flex: 1; max-width: 150px; height: 6px; background: rgba(99,102,241,0.1); border-radius: 3px; overflow: hidden;">
                                    <div style="width: {{ $hasil->skor * 100 }}%; height: 100%; background: linear-gradient(90deg, var(--primary), var(--accent)); border-radius: 3px;"></div>
                                </div>
                                <span style="font-family: monospace; font-weight: 600;">{{ number_format($hasil->skor, 6) }}</span>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
