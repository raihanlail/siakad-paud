<?php

namespace App\Http\Controllers\guru;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;
use App\Models\MataPelajaran;
use App\Models\Guru;
use App\Models\User;

use App\Models\Nilai;

use Illuminate\Http\Request;

class GuruDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $siswa = Siswa::all();
        $guru = Guru::where('user_id', $user->id)->first();
        $mapel = MataPelajaran::where('id', $guru->mata_pelajaran_id)->get();
        
        $nilai = Nilai::with('mataPelajaran')->where('mata_pelajaran_id', $mapel[0]->id)->get();
       
        
        return view('guru.dashboard', compact('user', 'guru', 'siswa', 'mapel', 'nilai'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required',
            'mata_pelajaran_id' => 'required',
            'nilai' => 'required|integer|min:0|max:100'
        ]);

        // Check if nilai already exists for this siswa and mata pelajaran
        $existingNilai = Nilai::where('siswa_id', $request->siswa_id)
            ->where('mata_pelajaran_id', $request->mata_pelajaran_id)
            ->first();

        if ($existingNilai) {
            return redirect()->back()->with('error', 'Nilai untuk siswa ini pada mata pelajaran tersebut sudah ada.');
        }

        Nilai::create([
            'siswa_id' => $request->siswa_id,
            'mata_pelajaran_id' => $request->mata_pelajaran_id,
            'nilai' => $request->nilai
        ]);

        return redirect()->back()->with('success', 'Nilai berhasil disimpan.');
    }
    public function update(Request $request, $id)
    {
        $nilai = Nilai::findOrFail($id);
        $nilai->update([
            'siswa_id' => $request->siswa_id,
            'mata_pelajaran_id' => $request->mata_pelajaran_id,
            'nilai' => $request->nilai
        ]);
        return redirect()->back()->with('success', 'Nilai berhasil diperbarui.');
    }


}
