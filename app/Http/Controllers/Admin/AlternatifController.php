<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alternatif;
use Illuminate\Http\Request;

class AlternatifController extends Controller
{
    public function index()
    {
        $alternatifs = Alternatif::orderBy('nama')->get();
        return view('admin.alternatif.index', compact('alternatifs'));
    }

    public function create()
    {
        return view('admin.alternatif.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        Alternatif::create($validated);

        return redirect()->route('admin.alternatif.index')
            ->with('success', 'Alternatif karir berhasil ditambahkan!');
    }

    public function edit(Alternatif $alternatif)
    {
        return view('admin.alternatif.form', compact('alternatif'));
    }

    public function update(Request $request, Alternatif $alternatif)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $alternatif->update($validated);

        return redirect()->route('admin.alternatif.index')
            ->with('success', 'Alternatif karir berhasil diperbarui!');
    }

    public function destroy(Alternatif $alternatif)
    {
        $alternatif->delete();

        return redirect()->route('admin.alternatif.index')
            ->with('success', 'Alternatif karir berhasil dihapus!');
    }
}
