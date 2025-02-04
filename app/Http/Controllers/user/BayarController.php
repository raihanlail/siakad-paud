<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\Auth;



use Illuminate\Http\Request;

class BayarController extends Controller
{
    public function index(){
        $user = Auth::user();
        $siswa = $user->siswa()->with('bayar')->get();
        return view('user.bayar', compact('siswa', 'user'));
    }

    public function store(Request $request)
    {
        try {
           
            $request->validate([
                'siswa_id' =>  'required',
                'jenis' => 'required',
                'jumlah' => 'required',
                
                
                'bukti' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',



            ]);
            $dd = $request->all();

            if($request->hasFile('bukti')) {
                $image = $request->file('bukti');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('bukti'), $imageName);
                $request->merge(['bukti' => $imageName]);
            } else {
                $request->merge(['bukti' => null]);
            }

           

            Pembayaran::create([
                'siswa_id' => $request->siswa_id,
                'jenis' => $request->jenis,
                'status' => $request->status ?? 'belum',
                'jumlah' => $request->jumlah,
                'bukti' => $request->bukti,
            ]);
            
        
            return redirect('dashboard')->with('success', 'Data Siswa Berhasil Ditambahkan');

        }catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan data siswa: ' . $e->getMessage());
        }
    } 
}
