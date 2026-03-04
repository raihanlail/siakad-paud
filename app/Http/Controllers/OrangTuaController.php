<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;


class OrangTuaController extends Controller
{
    public function index(){
        $orangTua = User::where('role', 'user')->get();
        return view('admin.orang_tua', compact('orangTua'));
    }
}
