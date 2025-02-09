<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;


class SiswaController extends Controller
{
    public function index()
    {
        $siswa = Siswa::with('orangTua')->latest()->paginate(7);
        $orangTua = User::all();
        return view('admin.siswa', compact('siswa', 'orangTua'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama' => 'required',
                'nis' => 'required|unique:siswas',
                'alamat' => 'required',
                'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
                'tanggal_lahir' => 'required|date',
                'orang_tua_id' => 'required|exists:users,id',
            ]);

            Siswa::create([
                'nama' => $request->nama,
                'nis' => $request->nis,
                'alamat' => $request->alamat,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tanggal_lahir' => $request->tanggal_lahir,
                'orang_tua_id' => $request->orang_tua_id,
            ]);
        
            return redirect()->back()->with('success', 'Data Siswa Berhasil Ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan data siswa: ' . $e->getMessage());
        }
    }    public function update(Request $request, $id)
    {
        $siswa = Siswa::find($id);
        $siswa->update([
            'nama' => $request->nama,
            'nis' => $request->nis,
            'alamat' => $request->alamat,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'orang_tua_id' => $request->orang_tua_id,
        ]);

        return redirect()->back()->with('success', 'Data Siswa Berhasil Diupdate');
    }

    public function destroy($id)
    {
        $siswa = Siswa::find($id);
        $siswa->delete();

        return redirect()->back()->with('success', 'Data Siswa Berhasil Dihapus');
    }

    public function exportPDF() 
    {
        $siswa = Siswa::all();
        $pdf = Pdf::loadView('admin.pdf.export-siswa', ['siswa' => $siswa]);
        return $pdf->download('data-siswa.pdf');
    }
}
