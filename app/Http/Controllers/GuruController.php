<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\MataPelajaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{
    public function index()
    {
        $gurus = Guru::with('mapel')->latest()->paginate(10);
        $mapel = MataPelajaran::all();
        return view('admin.guru', compact('gurus', 'mapel'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'              => 'required|string',
            'nip'               => 'required|unique:gurus',
            'no_telp'           => 'required|string',
            'alamat'            => 'required|string',
            'mata_pelajaran_id' => 'required|exists:mapels,id',
            'email'             => 'required|email|unique:users,email',
            'password'          => 'required|string|min:6',
        ]);

        // 1. Create User account with role "guru"
        $user = User::create([
            'name'              => $request->nama,
            'email'             => $request->email,
            'password'          => Hash::make($request->password),
            'role'              => 'guru',
            
        ]);

        // 2. Create Guru record linked to the User
        Guru::create([
            'nama'              => $request->nama,
            'nip'               => $request->nip,
            'no_telp'           => $request->no_telp,
            'alamat'            => $request->alamat,
            'mata_pelajaran_id' => $request->mata_pelajaran_id,
            'user_id'           => $user->id,
        ]);

        return redirect()->back()->with('success', 'Data Guru Berhasil Ditambahkan. Login: ' . $request->email);
    }

    public function update(Request $request, $id)
    {
        $guru = Guru::find($id);

        $guru->update([
            'nama'              => $request->nama,
            'nip'               => $request->nip,
            'no_telp'           => $request->no_telp,
            'alamat'            => $request->alamat,
            'mata_pelajaran_id' => $request->mata_pelajaran_id,
        ]);

        // Also update the linked User
        if ($guru->user_id) {
            $user = User::find($guru->user_id);
            if ($user) {
                $user->update([
                    'name'              => $request->nama,
                    'mata_pelajaran_id' => $request->mata_pelajaran_id,
                ]);

                // Only update password if provided
                if ($request->filled('password')) {
                    $user->update(['password' => Hash::make($request->password)]);
                }
            }
        }

        return redirect()->back()->with('success', 'Data Guru Berhasil Diupdate');
    }

    public function destroy($id)
    {
        $guru = Guru::find($id);

        // Delete the linked User account too
        if ($guru->user_id) {
            User::find($guru->user_id)?->delete();
        }

        $guru->delete();

        return redirect()->back()->with('success', 'Data Guru Berhasil Dihapus');
    }
}