<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class DaftarSiswaController extends Controller
{
    public function index(){
        $user = Auth::user();
        return view('user.tambah-siswa', compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'required|date',
            'orang_tua_id' => 'required|exists:users,id',
        ]);

        try {
            // 1. Generate NIS
            $yearPart    = date('y', strtotime($request->tanggal_lahir));
            $genderPart  = ($request->jenis_kelamin == 'Laki-laki') ? 'L' : 'P';
            $initialPart = strtoupper(substr($request->nama, 0, 1));
            $prefix      = $yearPart . $genderPart . $initialPart;

            $lastSiswa = Siswa::where('nis', 'LIKE', $prefix . '%')
                ->orderBy('nis', 'desc')
                ->first();

            $newSequence = $lastSiswa
                ? str_pad((int) substr($lastSiswa->nis, -3) + 1, 3, '0', STR_PAD_LEFT)
                : '001';

            $finalNis = $prefix . $newSequence;

            // 2. Find an available class (has remaining capacity)
            $availableKelas = Kelas::withCount('siswa')
                ->get()
                ->filter(fn($k) => $k->siswa_count < $k->capacity)
                ->sortBy('siswa_count')
                ->first();

            if (!$availableKelas) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Pendaftaran gagal: Semua kelas sudah penuh. Hubungi admin untuk menambah kapasitas.');
            }

            // 3. Create siswa with auto-assigned class
            Siswa::create([
                'nama'         => $request->nama,
                'nis'          => $finalNis,
                'alamat'       => $request->alamat,
                'jenis_kelamin'=> $request->jenis_kelamin,
                'tanggal_lahir'=> $request->tanggal_lahir,
                'orang_tua_id' => $request->orang_tua_id,
                'kelas_id'     => $availableKelas->id,
            ]);

            return redirect('dashboard')->with('success',
                "Siswa berhasil didaftarkan! NIS: {$finalNis} — Kelas: {$availableKelas->name}"
            );

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal: ' . $e->getMessage());
        }
    }
}