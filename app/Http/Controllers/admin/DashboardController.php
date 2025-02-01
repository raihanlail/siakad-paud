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
        $user = User::count();
        $guru = Guru::count();
        $siswa = Siswa::count();
        $mapel = MataPelajaran::count();
        return view('admin.dashboard', compact('user', 'guru', 'siswa', 'mapel'));
    }
}
