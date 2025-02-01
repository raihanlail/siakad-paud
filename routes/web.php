<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\user\DaftarSiswaController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

use App\Http\Middleware\UserMiddleware;

Route::get('/', function () {
    return redirect()->route('login');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';

Route::middleware(['auth', 'userMiddleware'])->group(function() {
    Route::get('dashboard',[UserController::class, 'index'])->name('dashboard');

});

Route::middleware(['auth', 'adminMiddleware'])->group(function() {
    Route::get('/admin/dashboard',[AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/guru',[GuruController::class, 'index'])->name('admin.guru');
    Route::post('/admin/guru',[GuruController::class, 'store'])->name('admin.guru.store');
    Route::put('/admin/guru/{id}', [GuruController::class, 'update'])->name('admin.guru.update');
    Route::delete('/admin/guru/{id}', [GuruController::class, 'destroy'])->name('admin.guru.destroy');
    Route::get('/admin/siswa', [SiswaController::class, 'index'])->name('admin.siswa');
    Route::post('/admin/siswa', [SiswaController::class, 'store'])->name('admin.siswa.store');
    Route::put('/admin/siswa/{id}', [SiswaController::class, 'update'])->name('admin.siswa.update');
    Route::delete('/admin/siswa/{id}', [SiswaController::class, 'destroy'])->name('admin.siswa.destroy');
    Route::get('/admin/mapel', action:[MapelController::class, 'index'])->name('admin.mapel');
    Route::post('/admin/mapel', action:[MapelController::class, 'store'])->name('admin.mapel.store');
    Route::get('admin/nilai/', [NilaiController::class, 'index'])->name('admin.nilai');
    Route::post('admin/nilai/', [NilaiController::class, 'store'])->name('admin.nilai.store');
    Route::get('/admin/nilai/{mata_pelajaran_id}', [NilaiController::class, 'showByMataPelajaran'])->name('admin.nilai.perMapel');
    
    


});


Route::middleware(['auth', 'userMiddleware'])->group(function() {
    Route::get('/user/dashboard',[UserController::class, 'index'])->name('user.dashboard');
    Route::get('/user/daftar', [DaftarSiswaController::class, 'index'])->name('user.daftar');
    
    Route::post('/user/daftar', [DaftarSiswaController::class, 'store'])->name('user.daftar.store');
    

});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
