@extends('layouts.spk')

@section('title', 'Hasil Rekomendasi')
@section('subtitle', 'Rekomendasi karir berdasarkan analisis AHP-TOPSIS')

@section('content')
@php
    $icons = [
        'Web Developer'    => '🌐',
        'Mobile Developer' => '📱',
        'Data Analyst'     => '📊',
        'Network Engineer' => '🔌',
        'UI/UX Designer'   => '🎨',
        'QA Engineer'      => '🛡️',
        'Data Scientist'   => '⚙️',
        'DevOps Engineer'  => '☁️',
    ];
    $deskripsi = [
        'Web Developer'    => 'Membangun aplikasi & website modern menggunakan teknologi frontend dan backend.',
        'Mobile Developer' => 'Mengembangkan aplikasi Android & iOS dengan Flutter, Kotlin, atau Swift.',
        'Data Analyst'     => 'Mengolah dan memvisualisasikan data untuk menghasilkan insight bisnis.',
        'Network Engineer' => 'Merancang dan mengelola infrastruktur jaringan komputer perusahaan.',
        'UI/UX Designer'   => 'Merancang antarmuka intuitif yang berfokus pada pengalaman pengguna.',
        'QA Engineer'      => 'Memastikan kualitas perangkat lunak melalui testing manual dan otomatis.',
        'Data Scientist'   => 'Membangun model machine learning dan AI untuk prediksi dan analisis.',
        'DevOps Engineer'  => 'Mengelola cloud infrastructure, CI/CD pipeline, dan otomasi deployment.',
    ];
    $medalColors = [
        1 => ['bg' => 'linear-gradient(135deg,#fbbf24,#f59e0b)', 'text' => '#78350f', 'glow' => 'rgba(251,191,36,0.3)', 'border' => 'rgba(251,191,36,0.4)'],
        2 => ['bg' => 'linear-gradient(135deg,#d1d5db,#9ca3af)', 'text' => '#374151', 'glow' => 'rgba(209,213,219,0.2)', 'border' => 'rgba(209,213,219,0.3)'],
        3 => ['bg' => 'linear-gradient(135deg,#d97706,#b45309)', 'text' => '#fffbeb', 'glow' => 'rgba(217,119,6,0.25)', 'border' => 'rgba(217,119,6,0.4)'],
    ];
    $top1 = $hasil->first();
@endphp

{{-- ===== HERO: REKOMENDASI #1 ===== --}}
<div class="card fade-in" style="margin-bottom: 28px; background: linear-gradient(135deg, rgba(99,102,241,0.12), rgba(139,92,246,0.08)); border-color: rgba(99,102,241,0.4); text-align: center; padding: 40px 32px; position: relative; overflow: hidden;">
    <div style="position: absolute; top: -40px; right: -40px; width: 200px; height: 200px; background: radial-gradient(circle, rgba(99,102,241,0.15), transparent); border-radius: 50%;"></div>
    <div style="position: absolute; bottom: -30px; left: -30px; width: 150px; height: 150px; background: radial-gradient(circle, rgba(139,92,246,0.1), transparent); border-radius: 50%;"></div>

    <div style="position: relative; z-index: 1;">
        <div style="font-size: 0.85rem; color: var(--primary-light); letter-spacing: 2px; text-transform: uppercase; font-weight: 600; margin-bottom: 8px;">
            ✨ Rekomendasi Terbaik untuk {{ $mahasiswa->nama }}
        </div>
        <div style="font-size: 4rem; margin-bottom: 16px; filter: drop-shadow(0 0 20px rgba(99,102,241,0.5));">
            {{ $icons[$top1->alternatif->nama] ?? '💼' }}
        </div>
        <h1 style="font-weight: 800; font-size: 2rem; margin-bottom: 8px; background: linear-gradient(135deg, var(--primary-light), var(--accent)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
            {{ $top1->alternatif->nama }}
        </h1>
        <p style="color: var(--text-secondary); font-size: 0.95rem; max-width: 500px; margin: 0 auto 20px; line-height: 1.6;">
            {{ $deskripsi[$top1->alternatif->nama] ?? '' }}
        </p>
        <div style="display: inline-flex; align-items: center; gap: 8px; padding: 12px 28px; background: rgba(99,102,241,0.2); border: 1px solid rgba(99,102,241,0.4); border-radius: 40px;">
            <span style="font-size: 1.8rem; font-weight: 800; color: var(--primary-light);">{{ number_format((float)$top1->skor * 100, 2) }}%</span>
            <span style="color: var(--text-secondary); font-size: 0.9rem;">Skor Kesesuaian TOPSIS</span>
        </div>
    </div>
</div>

{{-- ===== TOP 3 PODIUM ===== --}}
<div style="margin-bottom: 28px;">
    <h3 style="font-weight: 700; margin-bottom: 20px; font-size: 1.1rem;">🏆 Top 3 Karir yang Direkomendasikan</h3>
    <div class="grid-3 fade-in fade-in-delay-1">
        @foreach($top3 as $index => $h)
        @php $mc = $medalColors[$index + 1]; @endphp
        <div class="card" style="text-align: center; position: relative; padding: 28px 20px; border-color: {{ $mc['border'] }}; box-shadow: 0 0 30px {{ $mc['glow'] }}; {{ $index === 0 ? 'transform: scale(1.03);' : '' }}">
            {{-- Medal badge --}}
            <div style="position: absolute; top: -14px; left: 50%; transform: translateX(-50%); width: 40px; height: 40px; border-radius: 50%; background: {{ $mc['bg'] }}; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.1rem; color: {{ $mc['text'] }}; box-shadow: 0 4px 12px {{ $mc['glow'] }};">
                {{ $index + 1 }}
            </div>
            <div style="font-size: 2.8rem; margin: 16px 0 12px;">{{ $icons[$h->alternatif->nama] ?? '💼' }}</div>
            <h3 style="font-weight: 700; font-size: 1rem; margin-bottom: 12px; line-height: 1.3;">{{ $h->alternatif->nama }}</h3>

            {{-- Skor bar --}}
            <div style="margin-bottom: 8px; width: 100%; height: 6px; background: rgba(99,102,241,0.1); border-radius: 3px; overflow: hidden;">
                <div style="width: {{ (float)$h->skor * 100 }}%; height: 100%; background: {{ $mc['bg'] }}; border-radius: 3px;"></div>
            </div>
            <div class="stat-number" style="font-size: 1.6rem;">{{ number_format((float)$h->skor * 100, 2) }}%</div>
            <div style="font-size: 0.75rem; color: var(--text-secondary); margin-top: 4px;">Skor Kesesuaian</div>

            <p style="font-size: 0.78rem; color: var(--text-secondary); margin-top: 10px; line-height: 1.5;">
                {{ $deskripsi[$h->alternatif->nama] ?? '' }}
            </p>
        </div>
        @endforeach
    </div>
</div>

{{-- ===== GRAFIK ===== --}}
<div class="grid-2 fade-in fade-in-delay-2" style="margin-bottom: 28px;">
    <div class="card">
        <h3 style="font-weight: 700; margin-bottom: 16px;">📊 Perbandingan Skor Semua Karir</h3>
        <canvas id="fullChart" height="280"></canvas>
    </div>
    <div class="card">
        <h3 style="font-weight: 700; margin-bottom: 16px;">🍩 Distribusi Kesesuaian</h3>
        <canvas id="doughnutChart" height="280"></canvas>
    </div>
</div>

{{-- ===== TABEL RANKING LENGKAP ===== --}}
<div class="card fade-in fade-in-delay-3" style="margin-bottom: 28px;">
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
        <h3 style="font-weight: 700; margin: 0;">📋 Tabel Ranking Lengkap ({{ $hasil->count() }} Karir)</h3>
        <span style="font-size: 0.78rem; color: var(--text-secondary);">Diurutkan dari skor tertinggi</span>
    </div>
    <div class="table-container">
        <table class="custom-table">
            <thead>
                <tr>
                    <th style="width: 60px;">Rank</th>
                    <th>Jalur Karir</th>
                    <th style="text-align: center;">Skor TOPSIS</th>
                    <th style="text-align: center; min-width: 160px;">Persentase Kesesuaian</th>
                    <th style="text-align: center;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($hasil as $h)
                <tr style="{{ $h->ranking <= 3 ? 'background: rgba(99,102,241,0.04);' : '' }}">
                    <td>
                        @if($h->ranking === 1)
                            <div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg,#fbbf24,#f59e0b); display:flex;align-items:center;justify-content:center;font-weight:800;font-size:0.85rem;color:#78350f;">1</div>
                        @elseif($h->ranking === 2)
                            <div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg,#d1d5db,#9ca3af); display:flex;align-items:center;justify-content:center;font-weight:800;font-size:0.85rem;color:#374151;">2</div>
                        @elseif($h->ranking === 3)
                            <div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg,#d97706,#b45309); display:flex;align-items:center;justify-content:center;font-weight:800;font-size:0.85rem;color:#fffbeb;">3</div>
                        @else
                            <span style="font-weight: 700; color: var(--text-secondary); font-size: 0.95rem;">#{{ $h->ranking }}</span>
                        @endif
                    </td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <span style="font-size: 1.4rem;">{{ $icons[$h->alternatif->nama] ?? '💼' }}</span>
                            <div>
                                <div style="font-weight: 600;">{{ $h->alternatif->nama }}</div>
                                <div style="font-size: 0.75rem; color: var(--text-secondary);">{{ Str::limit($deskripsi[$h->alternatif->nama] ?? '', 50) }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="text-align: center;">
                        <span style="font-weight: 700; font-family: monospace; font-size: 0.9rem; color: {{ $h->ranking <= 3 ? 'var(--primary-light)' : 'var(--text-primary)' }};">
                            {{ number_format((float)$h->skor, 6) }}
                        </span>
                    </td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <div style="flex: 1; height: 8px; background: rgba(99,102,241,0.1); border-radius: 4px; overflow: hidden; min-width: 80px;">
                                <div style="width: {{ (float)$h->skor * 100 }}%; height: 100%; background: {{ $h->ranking === 1 ? 'linear-gradient(90deg,#fbbf24,#f59e0b)' : ($h->ranking <= 3 ? 'linear-gradient(90deg,var(--primary),var(--accent))' : 'rgba(99,102,241,0.5)') }}; border-radius: 4px;"></div>
                            </div>
                            <span style="font-weight: 700; font-size: 0.88rem; min-width: 48px; text-align: right;">{{ number_format((float)$h->skor * 100, 2) }}%</span>
                        </div>
                    </td>
                    <td style="text-align: center;">
                        @if($h->ranking === 1)
                            <span class="badge badge-warning">🥇 Terbaik</span>
                        @elseif($h->ranking <= 3)
                            <span class="badge badge-success">✅ Direkomendasikan</span>
                        @else
                            <span class="badge" style="background:rgba(99,102,241,0.1);color:var(--text-secondary);">Alternatif</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- ===== ACTION BUTTONS ===== --}}
<div style="display: flex; gap: 12px; flex-wrap: wrap;">
    <a href="{{ route('hasil.detail') }}" class="btn-primary">
        🧮 Detail Perhitungan TOPSIS
    </a>
    <a href="{{ route('penilaian-kriteria.create') }}" class="btn-secondary">
        ✏️ Ubah Penilaian Karir
    </a>
    <a href="{{ route('nilai.create') }}" class="btn-secondary">
        📝 Ubah Nilai Mata Kuliah
    </a>
    <a href="{{ route('dashboard') }}" class="btn-secondary">
        ← Dashboard
    </a>
</div>
@endsection

@section('scripts')
<script>
    const labels = {!! json_encode($chartLabels) !!};
    const data   = {!! json_encode($chartData) !!};
    const colors = [
        'rgba(99,102,241,0.85)', 'rgba(139,92,246,0.85)', 'rgba(6,182,212,0.85)',
        'rgba(34,197,94,0.85)', 'rgba(245,158,11,0.85)', 'rgba(239,68,68,0.85)',
        'rgba(236,72,153,0.85)', 'rgba(168,85,247,0.85)'
    ];

    // Horizontal bar chart
    new Chart(document.getElementById('fullChart'), {
        type: 'bar',
        data: {
            labels,
            datasets: [{ label: 'Skor (%)', data, backgroundColor: colors, borderRadius: 6, borderSkipped: false }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                x: { beginAtZero: true, max: 100, grid: { color: 'rgba(51,65,85,0.3)' }, ticks: { color: '#94a3b8', callback: v => v + '%' } },
                y: { grid: { display: false }, ticks: { color: '#94a3b8' } }
            }
        }
    });

    // Doughnut chart
    new Chart(document.getElementById('doughnutChart'), {
        type: 'doughnut',
        data: {
            labels,
            datasets: [{ data, backgroundColor: colors, borderWidth: 2, borderColor: '#1e293b', hoverOffset: 10 }]
        },
        options: {
            responsive: true,
            cutout: '65%',
            plugins: {
                legend: { position: 'bottom', labels: { color: '#94a3b8', padding: 14, font: { size: 11 } } },
                tooltip: { callbacks: { label: ctx => ` ${ctx.label}: ${ctx.parsed.toFixed(2)}%` } }
            }
        }
    });
</script>
@endsection
