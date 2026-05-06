@extends('layouts.spk')

@section('title', 'Data Mahasiswa')
@section('subtitle', 'Lihat semua data mahasiswa yang terdaftar')

@section('styles')
<style>
@media (max-width: 640px) {
    .th-hide, .td-hide { display: none; }
}
</style>
@endsection

@section('content')
<div class="card fade-in" style="margin-bottom: 24px;">
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; flex-wrap: wrap; gap: 12px;">
        <div>
            <h3 style="font-weight: 700; margin-bottom: 4px;">🎓 Daftar Mahasiswa</h3>
            <p style="color: var(--text-secondary); font-size: 0.85rem;">Total: <strong>{{ $mahasiswas->count() }}</strong> mahasiswa terdaftar</p>
        </div>
    </div>

    @if($mahasiswas->isEmpty())
        <div style="text-align: center; padding: 60px 20px; color: var(--text-secondary);">
            <div style="font-size: 3rem; margin-bottom: 16px;">📭</div>
            <p style="font-size: 1rem; margin-bottom: 4px;">Belum ada mahasiswa yang mendaftar</p>
            <p style="font-size: 0.85rem;">Data akan muncul setelah mahasiswa mengisi profil mereka.</p>
        </div>
    @else
        <div class="table-container">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIM</th>
                        <th class="th-hide">Prodi</th>
                        <th class="th-hide">Nilai MK</th>
                        <th>Top Karir</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mahasiswas as $index => $mhs)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), var(--secondary)); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.75rem; flex-shrink: 0;">
                                    {{ strtoupper(substr($mhs->nama, 0, 1)) }}
                                </div>
                                <div>
                                    <div style="font-weight: 600;">{{ $mhs->nama }}</div>
                                    <div style="font-size: 0.75rem; color: var(--text-secondary);">{{ $mhs->user->email ?? '-' }}</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge badge-primary">{{ $mhs->nim }}</span></td>
                        <td class="td-hide">{{ $mhs->prodi }}</td>
                        <td class="td-hide">
                            @if($mhs->jumlah_nilai > 0)
                                <span class="badge badge-success">{{ $mhs->jumlah_nilai }} MK</span>
                            @else
                                <span class="badge badge-warning">Belum</span>
                            @endif
                        </td>
                        <td>
                            @if($mhs->top_karir !== '-')
                                <div>
                                    <span style="font-weight: 600; font-size: 0.85rem;">{{ $mhs->top_karir }}</span>
                                    @if($mhs->top_skor)
                                        <div style="font-size: 0.7rem; color: var(--accent); font-family: monospace;">Skor: {{ number_format($mhs->top_skor, 4) }}</div>
                                    @endif
                                </div>
                            @else
                                <span class="badge badge-warning">Belum ada</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.mahasiswa.show', $mhs) }}" class="btn-secondary btn-sm">Detail</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
