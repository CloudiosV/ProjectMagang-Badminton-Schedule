<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Lapangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    public function create(Lapangan $lapangan)
    {
        return view('jadwal.create', [
            'lapangan' => $lapangan
        ]);
    }

    public function store(Lapangan $lapangan, Request $request)
    {
        // $user = Auth::user();
    
        $validatedRequest = $request->validate([
            'jam_mulai' => 'date_format:H:i|required',
            'jam_berhenti' => 'date_format:H:i|required'
        ]);

        $validatedRequest['lapangan_id'] = $lapangan->id;
        // $validatedRequest['user_id'] = $user->id;
        $validatedRequest['user_id'] = Auth::user()->id;

        Jadwal::create($validatedRequest);

        return redirect()->route('lapangan.show', $lapangan)->with('success', 'Jadwal berhasil disimpan!');
    }

    public function edit(Lapangan $lapangan, Jadwal $jadwal)
    {
        return view('jadwal.edit', [
            'lapangan' => $lapangan,
            'jadwal' => $jadwal
        ]);
    }

    public function update(Lapangan $lapangan, Jadwal $jadwal, Request $request)
    {
        $validatedRequest = $request->validate([
            'jam_mulai' => 'date_format:H:i|required',
            'jam_berhenti' => 'date_format:H:i|required'
        ]);

        $jadwal->update($validatedRequest);

        return redirect()->route('lapangan.show', $lapangan)->with('success', 'Jadwal berhasil diubah!');
    }

    public function destroy(Lapangan $lapangan, Jadwal $jadwal)
    {
        $jadwal->delete();
        return redirect()->route('lapangan.show', $lapangan)->with('success', 'Jadwal berhasil dihapus!');
    } 
}
