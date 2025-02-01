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

        
        try {
            Siswa::create([
                'nama' => $request->nama,
                'nis' => $request->nis,
                'alamat' => $request->alamat,
                'tanggal_lahir' => $request->tanggal_lahir,
                'orang_tua_id' => $request->orang_tua_id,
            ]);
            
        
            return redirect('dashboard')->with('success', 'Data Siswa Berhasil Ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan data siswa: ' . $e->getMessage());
        }    } 
}
