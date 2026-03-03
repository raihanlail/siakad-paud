<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;

class KelasController extends Controller
{
      public function index() {
        $kelas = Kelas::with('siswa')->get();
        $siswa = Siswa::all();
        return view('admin.kelas', compact('kelas', 'siswa'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'capacity' => 'required',
           
        ]);

        Kelas::create([
            'name' => $request->name,
            'capacity' => $request->capacity,
            
        ]);
        return redirect()->back()->with('success', 'Data Kelas Berhasil Ditambahkan');
    }

     public function update(Request $request, $id)
    {
        $kelas = Kelas::find($id);
        $kelas->update([
            'name' => $request->name,
            'capacity' => $request->capacity,
           
        ]);

        return redirect()->back()->with('success', 'Data Kelas Berhasil Diupdate');
    }

    public function destroy($id) {
        $kelas = Kelas::find($id);
        $kelas->delete();
        return redirect()->back()->with('success', 'Data Kelas Berhasil Dihapus');
    }
}
