<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function create()
    {
        $mahasiswa = auth()->user()->mahasiswa;
        return view('mahasiswa.create', compact('mahasiswa'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|max:20|unique:mahasiswas,nim,' . (auth()->user()->mahasiswa?->id ?? 'NULL'),
            'prodi' => 'required|string|max:255',
        ]);

        $validated['user_id'] = auth()->id();

        $mahasiswa = auth()->user()->mahasiswa;

        if ($mahasiswa) {
            $mahasiswa->update($validated);
            $message = 'Data mahasiswa berhasil diperbarui!';
        } else {
            Mahasiswa::create($validated);
            $message = 'Data mahasiswa berhasil disimpan!';
        }

        return redirect()->route('dashboard')->with('success', $message);
    }
}
