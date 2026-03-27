<?php
namespace App\Http\Controllers;

use App\Models\Fingerprint;
use App\Models\User;
use Illuminate\Http\Request;

class FingerprintController extends Controller
{
    public function index()
    {
        $users = User::all(); 
        return view('fingerprint.enroll', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'fingerprint_string' => 'required|string',
        ]);

        Fingerprint::create([
            'user_id' => $request->user_id,
            'fingerprint_string' => $request->fingerprint_string,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Sidik jari berhasil disimpan ke database pusat!'
        ]);
    }

    // Untuk verify
    public function getFingerprintData($user_id)
    {
        $fp = Fingerprint::where('user_id', $user_id)->first();
        if (!$fp) {
            return response()->json(['error' => 'Karyawan ini belum mendaftarkan sidik jari!'], 404);
        }
        return response()->json(['fingerprint_string' => $fp->fingerprint_string]);
    }

    // Untuk identify
    public function getAllFingerprintsData()
    {
        $fps = Fingerprint::with('user')->get();
        
        $fingerprintList = [];
        foreach ($fps as $fp) {
            $fingerprintList[] = [
                'id' => $fp->user_id,
                'fingerprint_string' => $fp->fingerprint_string,
                'employee_name' => $fp->user->nama ?? 'Unknown'
            ];
        }
        
        return response()->json(['fingerprint_list' => $fingerprintList]);
    }
}