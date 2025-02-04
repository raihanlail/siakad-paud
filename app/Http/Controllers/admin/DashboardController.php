<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use App\Models\User;
use App\Models\Guru;
use App\Models\Siswa;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totaluser = User::count();
        $totalguru = Guru::count();
        $totalsiswa = Siswa::count();
        $totalmapel = MataPelajaran::count();
        return view('admin.dashboard', compact('totaluser', 'totalguru', 'siswa', 'mapel'));
    }
}
