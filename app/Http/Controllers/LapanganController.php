<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use Illuminate\Http\Request;
use App\Models\Lapangan;

class LapanganController extends Controller
{
    public function index()
    {
        $lapangan = Lapangan::paginate(5);
        return view('lapangan.index', [
            'lapangan'=> $lapangan
        ]);
    }

    public function create()
    {
        return view('Lapangan.create');
    }

    public function store(Request $request)
    {
        $validatedRequest =  $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal' => 'date|required'
        ]);

        Lapangan::create($validatedRequest);

        return redirect()->route('Lapangan.index')->with('success', 'Lapangan Berhasil ditambahkan');
    }

    public function show(Lapangan $lapangan)
    {
        $jadwal = $lapangan->jadwal()->with('user')->orderBy('jam_mulai')->paginate(5);

        return view('Lapangan.show', [
            'jadwal' => $jadwal,
            'lapangan' => $lapangan,
        ]);
    }

    public function edit(Lapangan $lapangan)
    {
        return view('Lapangan.edit', [
            'lapangan' => $lapangan
        ]);
    }

    public function update(Lapangan $lapangan, Request $request)
    {
        $validatedRequest =  $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal' => 'date|required'
        ]);

        $lapangan->update($validatedRequest);

        return redirect()->route('Lapangan.index')->with('success', 'Lapangan Berhasil diubah');
    }

    public function destroy(Lapangan $lapangan)
    {
        $lapangan->delete();

        return redirect()->route('Lapangan.index')->with('success', 'Berhasil menghapus lapangan');
    }
}
