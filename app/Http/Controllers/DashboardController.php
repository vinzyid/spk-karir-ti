<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\HasilRekomendasi;
use App\Models\Kriteria;
use App\Models\Penilaian;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $mahasiswa = $user->mahasiswa;

        $data = [
            'user' => $user,
            'mahasiswa' => $mahasiswa,
            'hasMahasiswa' => $mahasiswa !== null,
            'hasPenilaian' => false,
            'hasHasil' => false,
            'top3' => [],
            'semuaHasil' => [],
            'chartLabels' => [],
            'chartData' => [],
            'kriteria' => Kriteria::orderBy('kode')->get(),
        ];

        if ($mahasiswa) {
            $penilaianCount = Penilaian::where('mahasiswa_id', $mahasiswa->id)->count();
            $data['hasPenilaian'] = $penilaianCount > 0;

            $hasil = HasilRekomendasi::where('mahasiswa_id', $mahasiswa->id)
                ->with('alternatif')
                ->orderBy('ranking')
                ->get();

            if ($hasil->isNotEmpty()) {
                $data['hasHasil'] = true;
                $data['top3'] = $hasil->take(3);
                $data['semuaHasil'] = $hasil;
                $data['chartLabels'] = $hasil->pluck('alternatif.nama')->toArray();
                $data['chartData'] = $hasil->pluck('skor')->map(fn($s) => round((float)$s * 100, 2))->toArray();
            }
        }

        return view('dashboard', $data);
    }
}
