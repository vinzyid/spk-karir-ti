<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\HasilRekomendasi;
use App\Models\Kriteria;
use App\Services\TopsisAhpService;

class HasilController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $mahasiswa = $user->mahasiswa;

        if (!$mahasiswa) {
            return redirect()->route('mahasiswa.create')
                ->with('warning', 'Silakan lengkapi data mahasiswa terlebih dahulu.');
        }

        $hasil = HasilRekomendasi::where('mahasiswa_id', $mahasiswa->id)
            ->with('alternatif')
            ->orderBy('ranking')
            ->get();

        if ($hasil->isEmpty()) {
            return redirect()->route('penilaian-kriteria.create')
                ->with('warning', 'Belum ada hasil perhitungan. Silakan lengkapi nilai dan penilaian karir terlebih dahulu.');
        }

        $top3 = $hasil->take(3);
        $chartLabels = $hasil->pluck('alternatif.nama')->toArray();
        $chartData = $hasil->pluck('skor')->map(fn($s) => round((float)$s * 100, 2))->toArray();

        return view('hasil.index', compact('mahasiswa', 'hasil', 'top3', 'chartLabels', 'chartData'));
    }

    public function detail()
    {
        $user = auth()->user();
        $mahasiswa = $user->mahasiswa;

        if (!$mahasiswa) {
            return redirect()->route('mahasiswa.create');
        }

        $service = new TopsisAhpService();
        $result = $service->hitung($user, simpan: false);

        if (isset($result['error'])) {
            return redirect()->route('penilaian-kriteria.create')
                ->with('error', $result['error']);
        }

        $kriteria = Kriteria::orderBy('kode')->get();
        $alternatifs = Alternatif::orderBy('id')->get();

        return view('hasil.detail', [
            'mahasiswa' => $mahasiswa,
            'result' => $result,
            'kriteria' => $kriteria,
            'alternatifs' => $alternatifs,
        ]);
    }
}
