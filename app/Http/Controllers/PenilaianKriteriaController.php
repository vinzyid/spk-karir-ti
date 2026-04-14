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
            'nilai.*.skill_teknis' => 'required|numeric|min:0|max:100',
            'nilai.*.minat' => 'required|numeric|min:1|max:5',
            'nilai.*.sertifikat' => 'required|numeric|min:0|max:50',
        ], [
            'nilai.*.minat.required' => 'Pilih tingkat minat (⭐) untuk semua jalur karir!',
            'nilai.*.minat.min' => 'Tingkat minat harus dipilih (minimal 1 bintang).',
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

        // Cek data nilai mata kuliah
        $hasNilai = \App\Models\NilaiMahasiswa::where('user_id', $user->id)->exists();
        if (!$hasNilai) {
            return redirect()->route('nilai.create')
                ->with('error', 'Silakan isi nilai mata kuliah terlebih dahulu sebelum menghitung rekomendasi.');
        }

        // Cek data penilaian kriteria
        $hasPenilaian = PenilaianKriteria::where('user_id', $user->id)->exists();
        if (!$hasPenilaian) {
            return redirect()->back()
                ->with('error', 'Silakan lengkapi evaluasi skill, minat, dan sertifikasi terlebih dahulu.');
        }

        try {
            $service = new TopsisServiceFinal();
            $result = $service->hitung($user, true);

            if (isset($result['error'])) {
                return redirect()->back()->with('error', $result['error']);
            }

            return redirect()->route('hasil.index')
                ->with('success', '✅ Rekomendasi karir berhasil dihitung menggunakan AHP dan TOPSIS!');

        } catch (\Exception $e) {
            \Log::error('TOPSIS Calculate Error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Terjadi error saat menghitung: ' . $e->getMessage());
        }
    }
}
