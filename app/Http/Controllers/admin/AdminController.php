<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use App\Models\User;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\View\View;




class AdminController extends Controller
{
   public function index()
{
    // Counts
    $siswaCount = Siswa::count();
    $guruCount  = Guru::count();
    $mapelCount = MataPelajaran::count();
    $kelasCount = Kelas::count();

    // Payment stats
    $lunas    = \App\Models\Pembayaran::where('status', 'lunas')->count();
    $belumBayar = Siswa::doesntHave('bayar')->count()
                + \App\Models\Pembayaran::where('status', '!=', 'lunas')->count();

    // Nilai stats
    $nilaiTuntas   = \App\Models\Nilai::where('nilai', '>=', 75)->count();
    $nilaiRemedial = \App\Models\Nilai::where('nilai', '<', 75)->count();
    $rataRata      = \App\Models\Nilai::avg('nilai');

    // Recent siswa (last 5)
    $recentSiswa = Siswa::with(['kelas', 'orangTua'])
                        ->latest()
                        ->take(5)
                        ->get();

    // Kelas capacity overview
    $kelas = Kelas::withCount('siswa')->get();

    return view('admin.dashboard', compact(
        'siswaCount', 'guruCount', 'mapelCount', 'kelasCount',
        'lunas', 'belumBayar',
        'nilaiTuntas', 'nilaiRemedial', 'rataRata',
        'recentSiswa', 'kelas'
    ));
}

    public function boot()
{
    View::composer('*', function ($view) {
        $mataPelajaran = MataPelajaran::all();
        $view->with('mataPelajaran', $mataPelajaran);
    });
}
}
