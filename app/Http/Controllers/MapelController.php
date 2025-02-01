<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use App\Models\Guru;
use Illuminate\Http\Request;

class MapelController extends Controller
{
    public function index() {
        $mapel = MataPelajaran::with('gurus')->get();
        $guru = Guru::all();
        return view('admin.mapel', compact('mapel', 'guru'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'kode' => 'required|unique:mapels',
           
        ]);

        MataPelajaran::create([
            'nama' => $request->nama,
            'kode' => $request->kode,
            
        ]);
        return redirect()->back()->with('success', 'Data Mapel Berhasil Ditambahkan');
    }
}
