<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\Auth;



use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $pembayaran = Pembayaran::latest()->paginate(10);
        return view('admin.pembayaran', compact('pembayaran', 'user'));
    }

    public function update(Request $request, $id)
    {
        $pembayaran = Pembayaran::find($id);
        $pembayaran->update([
            'jenis' => $request->jenis,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Data Terkonfirmasi');
    }

   
}
