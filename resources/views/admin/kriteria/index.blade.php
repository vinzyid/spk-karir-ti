@extends('layouts.spk')

@section('title', 'Kelola Kriteria')
@section('subtitle', 'Manage bobot dan kriteria AHP')

@section('content')
<div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
    <div>
        <p style="color: var(--text-secondary); font-size: 0.9rem;">
            Total Bobot: <strong style="color: {{ abs($totalBobot - 1) < 0.01 ? 'var(--success)' : 'var(--danger)' }};">{{ number_format($totalBobot, 4) }}</strong>
            @if(abs($totalBobot - 1) < 0.01)
                <span class="badge badge-success">✓ Valid</span>
            @else
                <span class="badge badge-danger">✗ Total harus = 1</span>
            @endif
        </p>
    </div>
    <a href="{{ route('admin.kriteria.create') }}" class="btn-primary">
        + Tambah Kriteria
    </a>
</div>

<div class="card fade-in">
    <div class="table-container">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama Kriteria</th>
                    <th>Bobot</th>
                    <th>Persentase</th>
                    <th>Tipe</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kriteria as $index => $k)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td><span class="badge badge-primary">{{ $k->kode }}</span></td>
                    <td style="font-weight: 600;">{{ $k->nama }}</td>
                    <td style="font-family: monospace; font-weight: 600;">{{ number_format($k->bobot, 4) }}</td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <div style="flex: 1; height: 6px; background: rgba(99,102,241,0.1); border-radius: 3px; overflow: hidden; max-width: 100px;">
                                <div style="width: {{ $k->bobot * 100 }}%; height: 100%; background: linear-gradient(90deg, var(--primary), var(--accent)); border-radius: 3px;"></div>
                            </div>
                            <span style="font-size: 0.85rem;">{{ number_format($k->bobot * 100, 2) }}%</span>
                        </div>
                    </td>
                    <td><span class="badge {{ $k->tipe == 'benefit' ? 'badge-success' : 'badge-warning' }}">{{ ucfirst($k->tipe) }}</span></td>
                    <td>
                        <div style="display: flex; gap: 8px;">
                            <a href="{{ route('admin.kriteria.edit', $k) }}" class="btn-secondary btn-sm">Edit</a>
                            <form action="{{ route('admin.kriteria.destroy', $k) }}" method="POST" onsubmit="return confirm('Yakin hapus kriteria ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-danger btn-sm">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
