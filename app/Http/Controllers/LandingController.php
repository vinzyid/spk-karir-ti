<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $totalMahasiswa = Mahasiswa::count();
        $totalKarir = Alternatif::count();
        $totalKriteria = Kriteria::count();
        $totalUser = User::where('role', 'user')->count();

        return view('landing', compact('totalMahasiswa', 'totalKarir', 'totalKriteria', 'totalUser'));
    }
}
