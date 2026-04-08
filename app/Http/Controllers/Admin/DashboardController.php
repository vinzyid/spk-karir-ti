<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alternatif;
use App\Models\HasilRekomendasi;
use App\Models\Kriteria;
use App\Models\Mahasiswa;
use App\Models\Penilaian;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::where('role', 'user')->count();
        $totalMahasiswa = Mahasiswa::count();
        $totalPenilaian = Penilaian::distinct('mahasiswa_id')->count('mahasiswa_id');
        $totalKriteria = Kriteria::count();
        $totalAlternatif = Alternatif::count();

        // Distribusi rekomendasi karir
        $distribusi = HasilRekomendasi::where('ranking', 1)
            ->selectRaw('alternatif_id, COUNT(*) as total')
            ->groupBy('alternatif_id')
            ->with('alternatif')
            ->get();

        $chartLabels = $distribusi->pluck('alternatif.nama')->toArray();
        $chartData = $distribusi->pluck('total')->toArray();

        // Recent users
        $recentUsers = User::where('role', 'user')
            ->with('mahasiswa')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers', 'totalMahasiswa', 'totalPenilaian',
            'totalKriteria', 'totalAlternatif',
            'chartLabels', 'chartData', 'recentUsers'
        ));
    }
}
