<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;

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
            'nama' => 'required',
            'nip' => 'required|unique:gurus',
            'no_telp' => 'required',
            'alamat' => 'required',
            
            'mata_pelajaran_id' => 'required|exists:mapels,id',
        ]);

        

        Guru::create([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
            
            'mata_pelajaran_id' => $request->mata_pelajaran_id,
        ]);

        
    
        return redirect()->back()->with('success', 'Data Guru Berhasil Ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $guru = Guru::find($id);
        $guru->update([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
            
            'mata_pelajaran_id' => $request->mata_pelajaran_id,
        ]);

        return redirect()->back()->with('success', 'Data Guru Berhasil Diupdate');
    }

    public function destroy($id) {
        $guru = Guru::find($id);
        $guru->delete();
        return redirect()->back()->with('success', 'Data Guru Berhasil Dihapus');
    }
}
