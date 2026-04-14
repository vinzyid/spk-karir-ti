@extends('layouts.spk')

@section('title', 'Dashboard')
@section('subtitle', 'Selamat datang, ' . $user->name)

@section('content')
<!-- Progress Steps -->
<div class="card fade-in" style="margin-bottom: 28px; padding: 28px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
        <div>
            <h3 style="font-weight: 700; margin-bottom: 4px;">📋 Progress Anda</h3>
            <p style="font-size: 0.85rem; color: var(--text-secondary);">Langkah-langkah menuju rekomendasi karir</p>
        </div>
        <div class="step-indicator">
            <div class="step">
                <div class="step-circle {{ $hasMahasiswa ? 'completed' : 'active' }}">
                    @if($hasMahasiswa) ✓ @else 1 @endif
                </div>
                <span style="font-size: 0.8rem; color: var(--text-secondary);">Data Diri</span>
            </div>
            <div class="step-line {{ $hasMahasiswa ? 'completed' : '' }}"></div>
            <div class="step">
                <div class="step-circle {{ $hasNilai ? 'completed' : ($hasMahasiswa ? 'active' : '') }}">
                    @if($hasNilai) ✓ @else 2 @endif
                </div>
                <span style="font-size: 0.8rem; color: var(--text-secondary);">Nilai Mata Kuliah</span>
            </div>
            <div class="step-line {{ $hasNilai ? 'completed' : '' }}"></div>
            <div class="step">
                <div class="step-circle {{ $hasHasil ? 'completed' : ($hasNilai ? 'active' : '') }}">
                    @if($hasHasil) ✓ @else 3 @endif
                </div>
                <span style="font-size: 0.8rem; color: var(--text-secondary);">Hasil</span>
            </div>
        </div>
    </div>
</div>

@if(!$hasMahasiswa)
<!-- Belum ada data mahasiswa -->
<div class="card fade-in fade-in-delay-1" style="text-align: center; padding: 60px;">
    <div style="font-size: 3rem; margin-bottom: 16px;">👋</div>
    <h2 style="font-weight: 700; margin-bottom: 8px;">Selamat Datang!</h2>
    <p style="color: var(--text-secondary); margin-bottom: 24px;">Langkah pertama, silakan lengkapi data mahasiswa Anda.</p>
    <a href="{{ route('mahasiswa.create') }}" class="btn-primary">
        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        Isi Data Mahasiswa
    </a>
</div>
@else
<!-- Stat Cards -->
<div class="grid-4 fade-in fade-in-delay-1" style="margin-bottom: 28px;">
    <div class="stat-card">
        <div style="font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 8px;">Nama</div>
        <div style="font-size: 1.1rem; font-weight: 700;">{{ $mahasiswa->nama }}</div>
        <div style="font-size: 0.8rem; color: var(--text-secondary); margin-top: 4px;">{{ $mahasiswa->nim }}</div>
    </div>
    <div class="stat-card">
        <div style="font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 8px;">Program Studi</div>
        <div style="font-size: 1.1rem; font-weight: 700;">{{ $mahasiswa->prodi }}</div>
    </div>
    <div class="stat-card">
        <div style="font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 8px;">Status Nilai</div>
        <div style="margin-top: 4px;">
            @if($hasNilai)
                <span class="badge badge-success">✅ Sudah Diisi</span>
            @else
                <span class="badge badge-warning">⏳ Belum Diisi</span>
            @endif
        </div>
    </div>
    <div class="stat-card">
        <div style="font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 8px;">Hasil Rekomendasi</div>
        <div style="margin-top: 4px;">
            @if($hasHasil)
                <span class="badge badge-success">✅ Tersedia</span>
            @else
                <span class="badge badge-warning">⏳ Belum Ada</span>
            @endif
        </div>
    </div>
</div>

@if($hasHasil)
<!-- Top 3 Recommendations -->
<div class="fade-in fade-in-delay-2" style="margin-bottom: 28px;">
    <h3 style="font-weight: 700; margin-bottom: 16px;">🏆 Top 3 Rekomendasi Karir Anda</h3>
    <div class="grid-3">
        @foreach($top3 as $index => $h)
        <div class="card card-gradient" style="text-align: center; position: relative;">
            <div class="medal medal-{{ $index + 1 }}" style="position: absolute; top: 16px; right: 16px;">
                {{ $index + 1 }}
            </div>
            <div style="font-size: 2.5rem; margin-bottom: 12px;">
                @php
                    $icons = ['🌐','📱','📊','🎨','🔌','🛡️','⚙️','📋'];
                    $altNames = ['Web Developer','Mobile Developer','Data Analyst','UI/UX Designer','Network Engineer','Cyber Security','DevOps Engineer','System Analyst'];
                    $iconIdx = array_search($h->alternatif->nama, $altNames);
                @endphp
                {{ $iconIdx !== false ? $icons[$iconIdx] : '💼' }}
            </div>
            <h3 style="font-weight: 700; font-size: 1.1rem; margin-bottom: 8px;">{{ $h->alternatif->nama }}</h3>
            <div class="stat-number" style="font-size: 1.8rem;">{{ number_format((float)$h->skor * 100, 1) }}%</div>
            <div style="font-size: 0.8rem; color: var(--text-secondary); margin-top: 4px;">Skor Kesesuaian</div>
        </div>
        @endforeach
    </div>
</div>

<!-- Chart -->
<div class="grid-2 fade-in fade-in-delay-3" style="margin-bottom: 28px;">
    <div class="card">
        <h3 style="font-weight: 700; margin-bottom: 16px;">📊 Grafik Skor Karir</h3>
        <canvas id="skorChart" height="250"></canvas>
    </div>
    <div class="card">
        <h3 style="font-weight: 700; margin-bottom: 16px;">🎯 Radar Kesesuaian</h3>
        <canvas id="radarChart" height="250"></canvas>
    </div>
</div>

<div style="display: flex; gap: 12px; flex-wrap: wrap;">
    <a href="{{ route('hasil.index') }}" class="btn-primary">
        📋 Lihat Detail Lengkap
    </a>
    <a href="{{ route('hasil.detail') }}" class="btn-secondary">
        🧮 Detail Perhitungan TOPSIS
    </a>
</div>
@elseif(!$hasNilai)
<div class="card fade-in fade-in-delay-2" style="text-align: center; padding: 48px;">
    <div style="font-size: 3rem; margin-bottom: 16px;">📝</div>
    <h3 style="font-weight: 700; margin-bottom: 8px;">Lanjutkan ke Input Nilai</h3>
    <p style="color: var(--text-secondary); margin-bottom: 24px;">Data mahasiswa sudah lengkap. Sekarang masukkan nilai mata kuliah Anda.</p>
    <a href="{{ route('nilai.create') }}" class="btn-primary">
        Mulai Input Nilai →
    </a>
</div>
@else
<div class="card fade-in fade-in-delay-2" style="text-align: center; padding: 48px;">
    <div style="font-size: 3rem; margin-bottom: 16px;">🧮</div>
    <h3 style="font-weight: 700; margin-bottom: 8px;">Nilai Sudah Lengkap!</h3>
    <p style="color: var(--text-secondary); margin-bottom: 24px;">Hitung rekomendasi karir Anda menggunakan metode TOPSIS.</p>
    <form action="{{ route('nilai.calculate') }}" method="POST" style="display: inline;">
        @csrf
        <button type="submit" class="btn-primary">
            🚀 Hitung Rekomendasi Sekarang
        </button>
    </form>
</div>
@endif
@endif

<!-- Bobot Kriteria -->
<div class="card fade-in fade-in-delay-4" style="margin-top: 28px;">
    <h3 style="font-weight: 700; margin-bottom: 16px;">📚 Mata Kuliah</h3>
    <p style="color: var(--text-secondary); font-size: 0.9rem; margin-bottom: 16px;">
        Total {{ $kriteria->count() }} mata kuliah yang digunakan untuk perhitungan rekomendasi karir
    </p>
    <div class="grid-4">
        @foreach($kriteria->take(8) as $k)
        <div style="text-align: center; padding: 12px; background: rgba(99,102,241,0.05); border-radius: 12px;">
            <div style="font-size: 0.75rem; color: var(--text-secondary); margin-bottom: 4px;">{{ $k->kode }}</div>
            <div style="font-weight: 600; font-size: 0.85rem;">{{ $k->nama }}</div>
        </div>
        @endforeach
    </div>
    @if($kriteria->count() > 8)
    <div style="text-align: center; margin-top: 16px;">
        <a href="{{ route('nilai.create') }}" class="link-primary" style="font-size: 0.85rem;">
            Lihat semua mata kuliah →
        </a>
    </div>
    @endif
</div>
@endsection

@section('scripts')
@if($hasHasil ?? false)
<script>
    // Bar Chart
    const ctx1 = document.getElementById('skorChart').getContext('2d');
    new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                label: 'Skor Kesesuaian (%)',
                data: {!! json_encode($chartData) !!},
                backgroundColor: [
                    'rgba(99, 102, 241, 0.8)',
                    'rgba(139, 92, 246, 0.8)',
                    'rgba(6, 182, 212, 0.8)',
                    'rgba(34, 197, 94, 0.8)',
                    'rgba(245, 158, 11, 0.8)',
                    'rgba(239, 68, 68, 0.8)',
                    'rgba(236, 72, 153, 0.8)',
                    'rgba(168, 85, 247, 0.8)',
                ],
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    grid: { color: 'rgba(51, 65, 85, 0.3)' },
                    ticks: { color: '#94a3b8' }
                },
                x: {
                    grid: { display: false },
                    ticks: { color: '#94a3b8', maxRotation: 45 }
                }
            }
        }
    });

    // Radar Chart
    const ctx2 = document.getElementById('radarChart').getContext('2d');
    new Chart(ctx2, {
        type: 'radar',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                label: 'Skor (%)',
                data: {!! json_encode($chartData) !!},
                borderColor: 'rgba(99, 102, 241, 1)',
                backgroundColor: 'rgba(99, 102, 241, 0.15)',
                pointBackgroundColor: 'rgba(99, 102, 241, 1)',
                borderWidth: 2,
                pointRadius: 4,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                r: {
                    beginAtZero: true,
                    max: 100,
                    grid: { color: 'rgba(51, 65, 85, 0.3)' },
                    angleLines: { color: 'rgba(51, 65, 85, 0.3)' },
                    pointLabels: { color: '#94a3b8', font: { size: 10 } },
                    ticks: { display: false }
                }
            }
        }
    });
</script>
@endif
@endsection
