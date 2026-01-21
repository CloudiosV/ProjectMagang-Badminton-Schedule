<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use Illuminate\Http\Request;
use App\Models\Lapangan;

class LapanganController extends Controller
{
    public function index()
    {
        if(!auth()->user()->can('view lapangan')){
            abort(403, 'Unauthorized action.');
        }

        $lapangan = Lapangan::paginate(5);

        // return response()->json([
        //     'success' => true,
        //     'message' => 'Data lapangan berhasil dikirim',
        //     'data' => $lapangan
        // ], 200);
        
        return view('lapangan.index', [
            'lapangan'=> $lapangan
        ]);
    }

    public function create()
    {
        if(!auth()->user()->can('create lapangan')){
            abort(403, 'Unauthorized action.');
        }
        
        return view('lapangan.create');
    }

    public function store(Request $request)
    {
        if(!auth()->user()->can('create lapangan')){
            abort(403, 'Unauthorized action.');
        }
        
        $validatedRequest =  $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal' => 'date|required'
        ]);

        $data = Lapangan::create($validatedRequest);

        // return response()->json([
        //     'success' => true,
        //     'message' => 'Lapangan berhasil dibuat',
        //     'data' => $data
        // ], 201);

        return redirect()->route('lapangan.index')->with('success', 'Lapangan Berhasil ditambahkan');
    }

    public function show(Lapangan $lapangan)
    {
        if(!auth()->user()->can('view jadwal')){
            abort(403, 'Unauthorized action.');
        }
        
        $jadwal = $lapangan->jadwal()->with('user')->orderBy('jam_mulai')->paginate(5);

        // return response()->json([
        //     'success' => true,
        //     'message' => 'Data lapangan dan jadwal berhasil dikirim',
        //     'data' => [
        //         'lapangan' => $lapangan,
        //         'jadwal' => $jadwal
        //     ]
        // ], 200);

        return view('lapangan.show', [
            'jadwal' => $jadwal,
            'lapangan' => $lapangan,
        ]);
    }

    public function edit(Lapangan $lapangan)
    {
        if(!auth()->user()->can('edit lapangan')){
            abort(403, 'Unauthorized action.');
        }
        
        // return response()->json([
        //     'success'=> true,
        //     'message' => 'Data Lapangan berhasil dikirim ke halaman edit',
        //     'data' => $lapangan
        // ], 200);

        return view('lapangan.edit', [
            'lapangan' => $lapangan
        ]);
    }

    public function update(Lapangan $lapangan, Request $request)
    {
        if(!auth()->user()->can('edit lapangan')){
            abort(403, 'Unauthorized action.');
        }
        
        $validatedRequest =  $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal' => 'date|required'
        ]);

        $lapangan->update($validatedRequest);

        // return response()->json([
        //     'success' => true,
        //     'message' => 'Lapangan berhasil diubah',
        //     'data' => $lapangan 
        // ], 200);

        return redirect()->route('lapangan.index')->with('success', 'Lapangan Berhasil diubah');
    }

    public function destroy(Lapangan $lapangan)
    {
        if(!auth()->user()->can('delete lapangan')){
            abort(403, 'Unauthorized action.');
        }
        
        $lapangan->delete();

        // return response()->json([
        //     'success' => true,
        //     'message' => 'Lapangan berhasil dihapus',
        //     'data' => $lapangan
        // ], 200);

        return redirect()->route('lapangan.index')->with('success', 'Berhasil menghapus lapangan');
    }
}
