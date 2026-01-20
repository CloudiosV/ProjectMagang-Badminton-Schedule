<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\JadwalResource;
use App\Models\Jadwal;
use App\Models\Lapangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
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

        $jadwal = Jadwal::create($validatedRequest);

        $jadwal->load('user');

        return response()->json([
            'status' => 'success',
            'message' => 'Jadwal berhasil dibuat',
            'data' => new JadwalResource($jadwal)
        ], 201);
    }
    public function update(Lapangan $lapangan, Jadwal $jadwal, Request $request)
    {
        $validatedRequest = $request->validate([
            'jam_mulai' => 'date_format:H:i|required',
            'jam_berhenti' => 'date_format:H:i|required'
        ]);

        $jadwal->update($validatedRequest);
        $jadwal->load('user');

        return response()->json([
            'status'=> 'success',
            'message'=> 'Jadwal berhasil diubah',
            'data' => new JadwalResource($jadwal)
        ], 200);
    }

    public function destroy(Lapangan $lapangan, Jadwal $jadwal)
    {
        $jadwal->delete();

        return response()->json([
            'status'=> 'success',
            'message'=> 'Jadwal berhasil dihapus',
            'data'=> $jadwal
        ]);
    } 
}
