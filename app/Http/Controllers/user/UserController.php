<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use App\Models\Siswa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\View\View;



use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $user = Auth::user();
        $siswa = Siswa::where('orang_tua_id', $user->id)->with('nilai')->get();

        return view('user.dashboard', compact('siswa', 'user'));
    }

    public function exportPDF($id) {
        $user = Auth::user();
        $siswa = Siswa::where('id', $id)->where('orang_tua_id', $user->id)->with('nilai')->first();
        //dd($siswa);
        $pdf = Pdf::loadView('user.pdf.export-nilai', ['siswa' => $siswa]);
        return $pdf->download('nilai-' . $siswa->nama . '.pdf' );

    }

   

    
}
