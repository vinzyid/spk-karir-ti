<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\HasilRekomendasi;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Services\TopsisService;
use Illuminate\Http\Request;

class HasilController extends Controller
{
    public function index()
    {
        $mahasiswa = auth()->user()->mahasiswa;

        if (!$mahasiswa) {
            return redirect()->route('mahasiswa.create')
                ->with('warning', 'Silakan lengkapi data mahasiswa terlebih dahulu.');
        }

        $hasil = HasilRekomendasi::where('mahasiswa_id', $mahasiswa->id)
            ->with('alternatif')
            ->orderBy('ranking')
            ->get();

        if ($hasil->isEmpty()) {
            return redirect()->route('penilaian.create')
                ->with('warning', 'Belum ada hasil perhitungan. Silakan lakukan penilaian terlebih dahulu.');
        }

        $top3 = $hasil->take(3);
        $chartLabels = $hasil->pluck('alternatif.nama')->toArray();
        $chartData = $hasil->pluck('skor')->map(fn($s) => round((float)$s * 100, 2))->toArray();

        return view('hasil.index', compact('mahasiswa', 'hasil', 'top3', 'chartLabels', 'chartData'));
    }

    public function detail()
    {
        $mahasiswa = auth()->user()->mahasiswa;

        if (!$mahasiswa) {
            return redirect()->route('mahasiswa.create');
        }

        $topsisService = new TopsisService();
        $result = $topsisService->hitung($mahasiswa, simpan: false);

        if (isset($result['error'])) {
            return redirect()->route('penilaian.create')
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
