@extends('layouts.spk')

@section('title', 'Kelola Alternatif Karir')
@section('subtitle', 'Manage pilihan karir IT')

@section('content')
@section('styles')
<style>
@media (max-width: 640px) {
    .td-desc { display: none; }
    .th-desc { display: none; }
}
</style>
@endsection

<div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; flex-wrap: wrap; gap: 12px;">
    <p style="color: var(--text-secondary); font-size: 0.9rem;">
        Total: <strong>{{ $alternatifs->count() }}</strong> alternatif karir
    </p>
    <a href="{{ route('admin.alternatif.create') }}" class="btn-primary">
        + Tambah Alternatif
    </a>
</div>

<div class="card fade-in">
    <div class="table-container">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Karir</th>
                    <th class="th-desc">Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($alternatifs as $index => $alt)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td style="font-weight: 600;">
                        @php
                            $icons = ['Web Developer'=>'🌐','Mobile Developer'=>'📱','Data Analyst'=>'📊','UI/UX Designer'=>'🎨','Network Engineer'=>'🔌','Cyber Security'=>'🛡️','DevOps Engineer'=>'⚙️','System Analyst'=>'📋'];
                        @endphp
                        {{ $icons[$alt->nama] ?? '💼' }} {{ $alt->nama }}
                    </td>
                    <td class="td-desc" style="font-size: 0.85rem; color: var(--text-secondary); max-width: 400px;">
                        {{ Str::limit($alt->deskripsi, 100) }}
                    </td>
                    <td>
                        <div style="display: flex; gap: 8px;">
                            <a href="{{ route('admin.alternatif.edit', $alt) }}" class="btn-secondary btn-sm">Edit</a>
                            <form action="{{ route('admin.alternatif.destroy', $alt) }}" method="POST" onsubmit="return confirm('Yakin hapus alternatif ini?')">
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
