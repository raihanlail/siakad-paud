<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;


use Illuminate\Http\Request;

class DaftarSiswaController extends Controller
{
    public function index(){
        $user = Auth::user();
        

        return view('user.tambah-siswa', compact( 'user'));
    }
    public function store(Request $request)
{
    // 1. Validation is crucial to prevent "General Error" crashes
    $request->validate([
        'nama' => 'required|string|max:255',
        'alamat' => 'required|string',
        'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        'tanggal_lahir' => 'required|date',
        'orang_tua_id' => 'required|exists:users,id',
    ]);

    try {
        // 2. Generate NIS Logic
        $yearPart = date('y', strtotime($request->tanggal_lahir)); // Last 2 digits of birth year
        $genderPart = ($request->jenis_kelamin == 'Laki-laki') ? 'L' : 'P';
        $initialPart = strtoupper(substr($request->nama, 0, 1));
        
        $prefix = $yearPart . $genderPart . $initialPart; // e.g., "26LA"

        // 3. Calculate Sequence (...001, ...002)
        // Look for the latest NIS that starts with this prefix
        $lastSiswa = Siswa::where('nis', 'LIKE', $prefix . '%')
                        ->orderBy('nis', 'desc')
                        ->first();

        if ($lastSiswa) {
            // Get the last 3 digits and increment
            $lastSequence = (int) substr($lastSiswa->nis, -3);
            $newSequence = str_pad($lastSequence + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newSequence = '001';
        }

        $finalNis = $prefix . $newSequence;

        // 4. Create the Record
        Siswa::create([
            'nama' => $request->nama,
            'nis' => $finalNis, // We use the server-generated NIS
            'alamat' => $request->alamat,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'orang_tua_id' => $request->orang_tua_id,
        ]);

        return redirect('dashboard')->with('success', "Siswa Berhasil Didaftarkan! NIS: $finalNis");

    } catch (\Exception $e) {
        // This will help you see exactly what went wrong during development
        return redirect()->back()
            ->withInput() // This keeps the user's data in the form if it fails
            ->with('error', 'Gagal: ' . $e->getMessage());
    }
} 
}
