<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\View\View;



use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $user = Auth::user();
        $siswa = $user->siswa()->with('nilai')->get();

        return view('user.dashboard', compact('siswa', 'user'));
    }

    
}
