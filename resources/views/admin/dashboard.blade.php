@extends('layouts.spk')

@section('title', 'Admin Dashboard')
@section('subtitle', 'Ringkasan statistik sistem')

@section('content')
<!-- Stats -->
<div class="grid-4 fade-in" style="margin-bottom: 28px;">
    <div class="stat-card">
        <div style="font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 8px;">👥 Total Pengguna</div>
        <div class="stat-number">{{ $totalUsers }}</div>
    </div>
    <div class="stat-card">
        <div style="font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 8px;">🎓 Data Mahasiswa</div>
        <div class="stat-number">{{ $totalMahasiswa }}</div>
    </div>
    <div class="stat-card">
        <div style="font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 8px;">📝 Sudah Menilai</div>
        <div class="stat-number">{{ $totalPenilaian }}</div>
    </div>
    <div class="stat-card">
        <div style="font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 8px;">📊 Total Karir</div>
        <div class="stat-number">{{ $totalAlternatif }}</div>
    </div>
</div>

<div class="grid-2 fade-in fade-in-delay-1" style="margin-bottom: 28px;">
    <!-- Distribution Chart -->
    <div class="card">
        <h3 style="font-weight: 700; margin-bottom: 16px;">📊 Distribusi Karir Terpopuler</h3>
        @if(count($chartLabels) > 0)
            <canvas id="distribusiChart" height="250"></canvas>
        @else
            <div style="text-align: center; padding: 40px; color: var(--text-secondary);">
                Belum ada data rekomendasi
            </div>
        @endif
    </div>

    <!-- Recent Users -->
    <div class="card">
        <h3 style="font-weight: 700; margin-bottom: 16px;">🕐 Pengguna Terbaru</h3>
        @if($recentUsers->isEmpty())
            <div style="text-align: center; padding: 40px; color: var(--text-secondary);">
                Belum ada pengguna terdaftar
            </div>
        @else
            @foreach($recentUsers as $u)
            <div style="display: flex; align-items: center; gap: 12px; padding: 12px 0; border-bottom: 1px solid var(--border);">
                <div style="width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), var(--secondary)); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.85rem; flex-shrink: 0;">
                    {{ strtoupper(substr($u->name, 0, 1)) }}
                </div>
                <div style="flex: 1;">
                    <div style="font-weight: 600; font-size: 0.9rem;">{{ $u->name }}</div>
                    <div style="font-size: 0.75rem; color: var(--text-secondary);">{{ $u->email }}</div>
                </div>
                <div>
                    @if($u->mahasiswa)
                        <span class="badge badge-success">Profil Lengkap</span>
                    @else
                        <span class="badge badge-warning">Belum Lengkap</span>
                    @endif
                </div>
            </div>
            @endforeach
        @endif
    </div>
</div>

<!-- Quick Links -->
<div class="grid-3 fade-in fade-in-delay-2">
    <a href="{{ route('admin.kriteria.index') }}" class="card" style="text-align: center; text-decoration: none; color: var(--text-primary);">
        <div style="font-size: 2rem; margin-bottom: 12px;">⚖️</div>
        <h3 style="font-weight: 700; margin-bottom: 4px;">Kelola Kriteria</h3>
        <p style="font-size: 0.85rem; color: var(--text-secondary);">{{ $totalKriteria }} kriteria terdaftar</p>
    </a>
    <a href="{{ route('admin.alternatif.index') }}" class="card" style="text-align: center; text-decoration: none; color: var(--text-primary);">
        <div style="font-size: 2rem; margin-bottom: 12px;">💼</div>
        <h3 style="font-weight: 700; margin-bottom: 4px;">Kelola Alternatif</h3>
        <p style="font-size: 0.85rem; color: var(--text-secondary);">{{ $totalAlternatif }} alternatif karir</p>
    </a>
    <a href="{{ route('dashboard') }}" class="card" style="text-align: center; text-decoration: none; color: var(--text-primary);">
        <div style="font-size: 2rem; margin-bottom: 12px;">🏠</div>
        <h3 style="font-weight: 700; margin-bottom: 4px;">Dashboard User</h3>
        <p style="font-size: 0.85rem; color: var(--text-secondary);">Lihat dashboard pengguna</p>
    </a>
</div>
@endsection

@section('scripts')
@if(count($chartLabels) > 0)
<script>
    new Chart(document.getElementById('distribusiChart'), {
        type: 'pie',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                data: {!! json_encode($chartData) !!},
                backgroundColor: [
                    'rgba(99, 102, 241, 0.8)', 'rgba(139, 92, 246, 0.8)',
                    'rgba(6, 182, 212, 0.8)', 'rgba(34, 197, 94, 0.8)',
                    'rgba(245, 158, 11, 0.8)', 'rgba(239, 68, 68, 0.8)',
                    'rgba(236, 72, 153, 0.8)', 'rgba(168, 85, 247, 0.8)',
                ],
                borderWidth: 0,
                hoverOffset: 8,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom', labels: { color: '#94a3b8', padding: 12, font: { size: 11 } } }
            }
        }
    });
</script>
@endif
@endsection
