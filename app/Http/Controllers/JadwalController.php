<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;


class JadwalController extends Controller
{
    public function index() {
    $jadwal = Jadwal::with(['kelas','mataPelajaran','guru'])->orderByRaw("FIELD(hari,'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu')")->get()->groupBy('hari');
    $kelas  = Kelas::all();
    $mapel  = MataPelajaran::all();
    $guru   = Guru::with('mapel')->get();
    return view('admin.jadwal', compact('jadwal', 'kelas', 'mapel', 'guru'));
}

public function store(Request $request) {
    $request->validate([
        'kelas_id'          => 'required|exists:kelas,id',
        'mata_pelajaran_id' => 'required|exists:mapels,id',
        'guru_id'           => 'required|exists:gurus,id',
        'hari'              => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
        'jam_mulai'         => 'required|date_format:H:i',
        'jam_selesai'       => 'required|date_format:H:i|after:jam_mulai',
    ]);
    Jadwal::create($request->all());
    return redirect()->back()->with('success', 'Jadwal berhasil ditambahkan.');
}

public function destroy($id) {
    Jadwal::find($id)->delete();
    return redirect()->back()->with('success', 'Jadwal berhasil dihapus.');
}
}
