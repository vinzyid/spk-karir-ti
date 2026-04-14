<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\NilaiMahasiswa;
use App\Services\TopsisServiceNew;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NilaiMahasiswaController extends Controller
{
    public function create()
    {
        $user = auth()->user();
        $mataKuliah = Kriteria::orderBy('kode')->get();
        
        // Ambil nilai yang sudah diisi
        $nilaiTersimpan = NilaiMahasiswa::where('user_id', $user->id)
            ->get()
            ->keyBy('kriteria_id');
        
        return view('nilai.create', compact('mataKuliah', 'nilaiTersimpan'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        
        $validated = $request->validate([
            'nilai' => 'required|array',
            'nilai.*' => 'required|numeric|min:0|max:100',
        ]);

        DB::transaction(function () use ($user, $validated) {
            // Hapus nilai lama
            NilaiMahasiswa::where('user_id', $user->id)->delete();
            
            // Simpan nilai baru
            foreach ($validated['nilai'] as $kriteriaId => $nilai) {
                NilaiMahasiswa::create([
                    'user_id' => $user->id,
                    'kriteria_id' => $kriteriaId,
                    'nilai' => $nilai,
                ]);
            }
        });

        return redirect()->route('penilaian-kriteria.create')
            ->with('success', 'Nilai mata kuliah berhasil disimpan! Selanjutnya, lengkapi penilaian Skill, Minat, dan Sertifikasi.');
    }

    public function calculate()
    {
        return redirect()->route('penilaian-kriteria.create')
            ->with('warning', 'Lengkapi penilaian Skill, Minat, dan Sertifikasi terlebih dahulu sebelum menghitung rekomendasi.');
    }
}
