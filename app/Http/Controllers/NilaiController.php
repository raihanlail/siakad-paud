<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Models\Siswa;
use Barryvdh\DomPDF\Facade\Pdf;


use Illuminate\Http\Request;

class NilaiController extends Controller
{
    public function index()
    {
        $nilai = Nilai::with('siswa', 'mataPelajaran')->latest()->get();
        $siswa = Siswa::all();
        $mapel = MataPelajaran::all();
        
        return view('admin.nilai', compact('nilai', 'siswa', 'mapel'));
    }

    public function create()
    {
        $siswa = Siswa::all();
        $mapel = MataPelajaran::all();
        return view('admin.nilai.create', compact('siswa', 'mapel'));
    }

    public function showByMataPelajaran($mata_pelajaran_id)
{
    $mataPelajaran = MataPelajaran::findOrFail($mata_pelajaran_id);
    $siswa = Siswa::all();
    $nilai = Nilai::with('siswa')
                  ->where('mata_pelajaran_id', $mata_pelajaran_id)
                  ->get();

    return view('admin.nilai.per-mapel', compact('mataPelajaran', 'nilai', 'siswa'));
}

    public function exportPDF($mata_pelajaran_id)
    {
        $mataPelajaran = MataPelajaran::findOrFail($mata_pelajaran_id);
        $nilai = Nilai::with('siswa')
                      ->where('mata_pelajaran_id', $mata_pelajaran_id)
                      ->get();
                      $pdf = Pdf::loadView('admin.pdf.export-nilai', compact('mataPelajaran', 'nilai'));
                     
                      return $pdf->download('nilai-' . $mataPelajaran->nama . '.pdf');
    }

    // Simpan nilai ke database
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
