<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Models\MataPelajaran;
use App\Models\Guru;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $mapel = MataPelajaran::all();
        return view('auth.register', compact('mapel') );
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'role' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        if($request->role === 'guru') {
            $guru = new Guru();
            $guru->user_id = $user->id;
            $guru->nama = $request->name;
            $guru->nip = $request->nip;
            $guru->no_telp = $request->no_telp;
            $guru->alamat = $request->alamat;
            $guru->mata_pelajaran_id = $request->mata_pelajaran_id;
            $guru->save();
        }

        event(new Registered($user));

        Auth::login($user);

        if($request->role === 'guru') {
            return redirect(route('guru.dashboard', absolute: false));
        }
        if($request->role === 'user') {
            return redirect(route('dashboard', absolute: false));
        }

        return redirect(route('dashboard', absolute: false)); // Default fallback return
    }
}
