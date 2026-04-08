@extends('layouts.spk')

@section('title', 'Hasil Rekomendasi')
@section('subtitle', 'Rekomendasi karir berdasarkan analisis TOPSIS')

@section('content')
@php
    $icons = ['Web Developer'=>'🌐','Mobile Developer'=>'📱','Data Analyst'=>'📊','UI/UX Designer'=>'🎨','Network Engineer'=>'🔌','Cyber Security'=>'🛡️','DevOps Engineer'=>'⚙️','System Analyst'=>'📋'];
@endphp
<!-- Top 3 -->
<div style="margin-bottom: 28px;">
    <h3 style="font-weight: 700; margin-bottom: 16px; font-size: 1.2rem;">🏆 Top 3 Rekomendasi Karir untuk {{ $mahasiswa->nama }}</h3>
    <div class="grid-3 fade-in">
        @foreach($top3 as $index => $h)
        <div class="card card-gradient" style="text-align: center; position: relative; padding: 32px;">
            <div class="medal medal-{{ $index + 1 }}" style="position: absolute; top: 16px; right: 16px;">
                {{ $index + 1 }}
            </div>
            <div style="font-size: 3rem; margin-bottom: 16px;">
                {{ $icons[$h->alternatif->nama] ?? '💼' }}
            </div>
            <h3 style="font-weight: 700; font-size: 1.2rem; margin-bottom: 8px;">{{ $h->alternatif->nama }}</h3>
            <div class="stat-number" style="font-size: 2rem;">{{ number_format((float)$h->skor * 100, 2) }}%</div>
            <div style="font-size: 0.85rem; color: var(--text-secondary); margin-top: 8px;">Skor Kesesuaian</div>
            <div style="margin-top: 12px; width: 100%; height: 6px; background: rgba(99,102,241,0.1); border-radius: 3px; overflow: hidden;">
                <div style="width: {{ (float)$h->skor * 100 }}%; height: 100%; background: linear-gradient(90deg, var(--primary), var(--accent)); border-radius: 3px; transition: width 1s ease;"></div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Chart -->
<div class="grid-2 fade-in fade-in-delay-1" style="margin-bottom: 28px;">
    <div class="card">
        <h3 style="font-weight: 700; margin-bottom: 16px;">📊 Perbandingan Skor Semua Karir</h3>
        <canvas id="fullChart" height="300"></canvas>
    </div>
    <div class="card">
        <h3 style="font-weight: 700; margin-bottom: 16px;">🍩 Distribusi Kesesuaian</h3>
        <canvas id="doughnutChart" height="300"></canvas>
    </div>
</div>

<!-- Full Ranking Table -->
<div class="card fade-in fade-in-delay-2" style="margin-bottom: 28px;">
    <h3 style="font-weight: 700; margin-bottom: 16px;">📋 Tabel Ranking Lengkap</h3>
    <div class="table-container">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Ranking</th>
                    <th>Alternatif Karir</th>
                    <th>Skor TOPSIS</th>
                    <th>Persentase</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($hasil as $h)
                <tr>
                    <td>
                        @if($h->ranking <= 3)
                            <div class="medal medal-{{ $h->ranking }}" style="width: 32px; height: 32px; font-size: 0.85rem;">
                                {{ $h->ranking }}
                            </div>
                        @else
                            <span style="font-weight: 700; color: var(--text-secondary);">#{{ $h->ranking }}</span>
                        @endif
                    </td>
                    <td>
                        <div style="font-weight: 600;">
                            {{ $icons[$h->alternatif->nama] ?? '💼' }} {{ $h->alternatif->nama }}
                        </div>
                    </td>
                    <td>
                        <span style="font-weight: 600; font-family: monospace;">{{ number_format((float)$h->skor, 6) }}</span>
                    </td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <div style="flex: 1; height: 6px; background: rgba(99,102,241,0.1); border-radius: 3px; overflow: hidden; max-width: 120px;">
                                <div style="width: {{ (float)$h->skor * 100 }}%; height: 100%; background: linear-gradient(90deg, var(--primary), var(--accent)); border-radius: 3px;"></div>
                            </div>
                            <span style="font-weight: 600; font-size: 0.85rem;">{{ number_format((float)$h->skor * 100, 2) }}%</span>
                        </div>
                    </td>
                    <td>
                        @if($h->ranking <= 3)
                            <span class="badge badge-success">Direkomendasikan</span>
                        @else
                            <span class="badge badge-primary">Alternatif</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div style="display: flex; gap: 12px; flex-wrap: wrap;">
    <a href="{{ route('hasil.detail') }}" class="btn-primary">
        🧮 Lihat Detail Perhitungan TOPSIS
    </a>
    <a href="{{ route('penilaian.create') }}" class="btn-secondary">
        ✏️ Ubah Penilaian
    </a>
    <a href="{{ route('dashboard') }}" class="btn-secondary">
        ← Kembali ke Dashboard
    </a>
</div>
@endsection

@section('scripts')
<script>
    const labels = {!! json_encode($chartLabels) !!};
    const data = {!! json_encode($chartData) !!};
    const colors = [
        'rgba(99, 102, 241, 0.8)', 'rgba(139, 92, 246, 0.8)', 'rgba(6, 182, 212, 0.8)',
        'rgba(34, 197, 94, 0.8)', 'rgba(245, 158, 11, 0.8)', 'rgba(239, 68, 68, 0.8)',
        'rgba(236, 72, 153, 0.8)', 'rgba(168, 85, 247, 0.8)'
    ];

    // Horizontal Bar
    new Chart(document.getElementById('fullChart'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Skor (%)',
                data: data,
                backgroundColor: colors,
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                x: { beginAtZero: true, max: 100, grid: { color: 'rgba(51,65,85,0.3)' }, ticks: { color: '#94a3b8' } },
                y: { grid: { display: false }, ticks: { color: '#94a3b8' } }
            }
        }
    });

    // Doughnut
    new Chart(document.getElementById('doughnutChart'), {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: colors,
                borderWidth: 0,
                hoverOffset: 8,
            }]
        },
        options: {
            responsive: true,
            cutout: '60%',
            plugins: {
                legend: { position: 'bottom', labels: { color: '#94a3b8', padding: 12, font: { size: 11 } } }
            }
        }
    });
</script>
@endsection
