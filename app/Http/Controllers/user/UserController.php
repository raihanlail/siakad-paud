<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
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

    public function jadwal()
{
    $user = Auth::user();

    // Get all siswa belonging to this orang tua
    $siswa = Siswa::with('kelas')
        ->where('orang_tua_id', $user->id)
        ->get();

    // Get unique kelas_ids from verified siswa only
    $kelasIds = $siswa
        ->filter(fn($s) => ($s->status ?? '') === 'Verified')
        ->pluck('kelas_id')
        ->filter()
        ->unique()
        ->values();

    // Load all jadwal for those kelas, grouped by [kelas_id][hari]
    $jadwal = Jadwal::with(['mataPelajaran', 'guru', 'kelas'])
        ->whereIn('kelas_id', $kelasIds)
        ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu')")
        ->get()
        ->groupBy(['kelas_id', 'hari']);

    return view('user.jadwal', compact('siswa', 'jadwal'));
}


    public function exportPDF($id) {
        $user = Auth::user();
        $siswa = Siswa::where('id', $id)->where('orang_tua_id', $user->id)->with('nilai')->first();
        //dd($siswa);
        $pdf = Pdf::loadView('user.pdf.export-nilai', ['siswa' => $siswa]);
        return $pdf->download('nilai-' . $siswa->nama . '.pdf' );

    }

   

    
}
