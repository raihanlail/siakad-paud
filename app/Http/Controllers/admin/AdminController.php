<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use App\Models\User;
use App\Models\Guru;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\View\View;



class AdminController extends Controller
{
    public function index(){
        $siswa = Siswa::count();
        $guru = Guru::count();
        $mapel = MataPelajaran::count();
        $user = User::count();
        return view('admin.dashboard', compact('siswa', 'guru', 'mapel', 'user'));
    }

    public function boot()
{
    View::composer('*', function ($view) {
        $mataPelajaran = MataPelajaran::all();
        $view->with('mataPelajaran', $mataPelajaran);
    });
}
}
