<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\OrangTua;
use App\Models\User;
use Illuminate\Http\Request;



class OrangTuaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $orangTua = OrangTua::with('user')
            ->when($search, function ($query) use ($search) {
                $query->where('nama', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%");
            })
            ->paginate(10);
            

        return view('admin.orang-tua', compact('orangTua'));
    }
}
