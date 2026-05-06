<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\NilaiMahasiswa;
use App\Models\HasilRekomendasi;
use App\Models\User;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswas = Mahasiswa::with(['user', 'hasilRekomendasis.alternatif'])
            ->latest()
            ->get()
            ->map(function ($mhs) {
                // Cek apakah sudah input nilai
                $mhs->jumlah_nilai = NilaiMahasiswa::where('user_id', $mhs->user_id)->count();

                // Ambil rekomendasi karir #1 (ranking 1)
                $topRekomendasi = $mhs->hasilRekomendasis->where('ranking', 1)->first();
                $mhs->top_karir = $topRekomendasi?->alternatif?->nama ?? '-';
                $mhs->top_skor = $topRekomendasi?->skor ?? null;

                return $mhs;
            });

        return view('admin.mahasiswa.index', compact('mahasiswas'));
    }

    public function show(Mahasiswa $mahasiswa)
    {
        $mahasiswa->load(['user', 'hasilRekomendasis.alternatif']);

        // Ambil semua nilai mata kuliah
        $nilaiMk = NilaiMahasiswa::where('user_id', $mahasiswa->user_id)
            ->with('kriteria')
            ->get();

        // Ambil data skill & minat dari user
        $user = $mahasiswa->user;

        // Ambil semua hasil rekomendasi
        $hasilRekomendasi = HasilRekomendasi::where('mahasiswa_id', $mahasiswa->id)
            ->with('alternatif')
            ->orderBy('ranking')
            ->get();

        return view('admin.mahasiswa.show', compact('mahasiswa', 'nilaiMk', 'user', 'hasilRekomendasi'));
    }
}
