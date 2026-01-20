<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\LapanganResource;
use App\Models\Lapangan;
use Illuminate\Http\Request;

class LapanganController extends Controller
{
    public function show(Lapangan $lapangan)
    {
        // $lapangan->load([
        //     'jadwal' => function ($q) {
        //         $q->with(['user', ' lapangan'])
        //         ->orderBy('jam_mulai');
        //     }
        // ]);

        $lapangan->load('jadwal');

        $lapangan->jadwal->load('user')->sortBy('jam_mulai');

        return response()->json([
            'status' => 'success',
            'message' => 'Data lapangan dan jadwal berhasil dikirim',
            'data' => new LapanganResource($lapangan)
        ], 200);
    }
}
