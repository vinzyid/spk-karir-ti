<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\NilaiMahasiswa;
use App\Models\PenilaianKriteria;
use App\Services\TopsisServiceFinal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenilaianKriteriaController extends Controller
{
    public function create()
    {
        $user = auth()->user();
        $alternatifs = Alternatif::orderBy('id')->get();
        $hasNilaiAkademik = NilaiMahasiswa::where('user_id', $user->id)->exists();

        // Ambil nilai yang sudah diisi
        $penilaianTersimpan = PenilaianKriteria::where('user_id', $user->id)
            ->get()
            ->keyBy('alternatif_id');

        return view('penilaian_kriteria.create', compact('alternatifs', 'penilaianTersimpan', 'hasNilaiAkademik'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        
        $request->validate([
            'nilai' => 'required|array',
            'nilai.*.skill_teknis' => 'required|numeric|min:1|max:100',
            'nilai.*.minat' => 'required|numeric|min:1|max:5',
            'nilai.*.sertifikat' => 'required|numeric|min:0|max:50',
        ]);

        DB::transaction(function () use ($user, $request) {
            foreach ($request->nilai as $alternatifId => $kriteria) {
                PenilaianKriteria::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'alternatif_id' => $alternatifId,
                    ],
                    [
                        'skill_teknis' => $kriteria['skill_teknis'],
                        'minat' => $kriteria['minat'],
                        'sertifikat' => $kriteria['sertifikat'],
                    ]
                );
            }
        });

        return redirect()->route('penilaian-kriteria.create')
            ->with('success', 'Penilaian skill, minat, dan sertifikasi berhasil disimpan! Silakan klik Hitung Rekomendasi Karir.');
    }

    public function calculate()
    {
        $user = auth()->user();
        
        if (!$user->mahasiswa) {
            return redirect()->route('mahasiswa.create')
                ->with('error', 'Silakan lengkapi data mahasiswa terlebih dahulu.');
        }
        
        $service = new TopsisServiceFinal();
        $result = $service->hitung($user, true);
        
        if (isset($result['error'])) {
            return redirect()->back()->with('error', $result['error']);
        }
        
        return redirect()->route('hasil.index')
            ->with('success', 'Rekomendasi karir menggunakan AHP dan TOPSIS berhasil dihitung!');
    }
}
