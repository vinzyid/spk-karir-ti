<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Services\TopsisService;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    public function create()
    {
        $user = auth()->user();
        $mahasiswa = $user->mahasiswa;

        if (!$mahasiswa) {
            return redirect()->route('mahasiswa.create')
                ->with('warning', 'Silakan lengkapi data mahasiswa terlebih dahulu.');
        }

        $kriteria = Kriteria::orderBy('kode')->get();
        $alternatifs = Alternatif::orderBy('id')->get();

        // Load existing penilaian
        $existingPenilaian = [];
        $penilaians = Penilaian::where('mahasiswa_id', $mahasiswa->id)->get();
        foreach ($penilaians as $p) {
            $existingPenilaian[$p->alternatif_id][$p->kriteria_id] = $p->nilai;
        }

        return view('penilaian.create', compact('mahasiswa', 'kriteria', 'alternatifs', 'existingPenilaian'));
    }

    public function store(Request $request)
    {
        $mahasiswa = auth()->user()->mahasiswa;

        if (!$mahasiswa) {
            return redirect()->route('mahasiswa.create');
        }

        $request->validate([
            'nilai' => 'required|array',
            'nilai.*.*' => 'required|numeric|min:1|max:5',
        ]);

        foreach ($request->nilai as $alternatifId => $kriteriaValues) {
            foreach ($kriteriaValues as $kriteriaId => $nilai) {
                Penilaian::updateOrCreate(
                    [
                        'mahasiswa_id' => $mahasiswa->id,
                        'alternatif_id' => $alternatifId,
                        'kriteria_id' => $kriteriaId,
                    ],
                    ['nilai' => $nilai]
                );
            }
        }

        return redirect()->route('penilaian.create')
            ->with('success', 'Penilaian berhasil disimpan! Silakan hitung rekomendasi.');
    }

    public function calculate(TopsisService $topsisService)
    {
        $mahasiswa = auth()->user()->mahasiswa;

        if (!$mahasiswa) {
            return redirect()->route('mahasiswa.create');
        }

        $alternatifCount = Alternatif::count();
        $kriteriaCount = Kriteria::count();
        $penilaianCount = Penilaian::where('mahasiswa_id', $mahasiswa->id)->count();

        if ($penilaianCount < $alternatifCount * $kriteriaCount) {
            return redirect()->route('penilaian.create')
                ->with('warning', 'Mohon lengkapi semua penilaian terlebih dahulu.');
        }

        $result = $topsisService->hitung($mahasiswa);

        if (isset($result['error'])) {
            return redirect()->route('penilaian.create')
                ->with('error', $result['error']);
        }

        return redirect()->route('hasil.index')
            ->with('success', 'Perhitungan TOPSIS berhasil! Berikut hasil rekomendasi karir Anda.');
    }
}
