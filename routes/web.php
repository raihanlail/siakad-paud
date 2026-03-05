<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\guru\GuruDashboardController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\OrangTuaController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\user\BayarController;
use App\Http\Controllers\user\DaftarSiswaController;
use App\Http\Controllers\User\UserController;



use Illuminate\Support\Facades\Route;

use App\Http\Middleware\UserMiddleware;
use App\Models\Pembayaran;

Route::get('/', function () {
    return redirect()->route('login');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'guruMiddleware'])->group(function() {
    Route::get('/guru/dashboard',[GuruDashboardController::class, 'index'])->name('guru.dashboard');
    Route::post('/guru/dashboard',[GuruDashboardController::class, 'store'])->name('guru.dashboard.store');
     Route::get('/guru/download',[GuruDashboardController::class, 'exportPDF'])->name('guru.download');
    Route::put('/guru/dashboard/{id}', [GuruDashboardController::class, 'update'])->name('guru.dashboard.update');
    Route::get('/guru/jadwal', [GuruDashboardController::class, 'jadwal'])->name('guru.jadwal');
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
    Route::get('/admin/orang-tua', [OrangTuaController::class, 'index'])->name('admin.orang-tua');
     Route::get('/admin/kelas',[KelasController::class, 'index'])->name('admin.kelas');
    Route::post('/admin/kelas',[KelasController::class, 'store'])->name('admin.kelas.store');
    Route::put('/admin/kelas/{id}', [KelasController::class, 'update'])->name('admin.kelas.update');
    Route::delete('/admin/kelas/{id}', [KelasController::class, 'destroy'])->name('admin.kelas.destroy');
    Route::get('/admin/siswa', [SiswaController::class, 'index'])->name('admin.siswa');
    Route::post('/admin/siswa', [SiswaController::class, 'store'])->name('admin.siswa.store');
    Route::put('/admin/siswa/{id}', [SiswaController::class, 'update'])->name('admin.siswa.update');
    Route::put('admin/siswa/{id}/verify', [SiswaController::class, 'verify'])->name('admin.siswa.verify');
Route::put('admin/siswa/{id}/reject', [SiswaController::class, 'reject'])->name('admin.siswa.reject');
    Route::delete('/admin/siswa/{id}', [SiswaController::class, 'destroy'])->name('admin.siswa.destroy');
    Route::get('/admin/siswa/download', [SiswaController::class, 'ExportPDF'])->name('admin.siswa.download');
    Route::get('/admin/mapel', action:[MapelController::class, 'index'])->name('admin.mapel');
    Route::post('/admin/mapel', action:[MapelController::class, 'store'])->name('admin.mapel.store');
    Route::get('admin/nilai/', [NilaiController::class, 'index'])->name('admin.nilai');
    Route::post('admin/nilai/', [NilaiController::class, 'store'])->name('admin.nilai.store');
    Route::put('/admin/nilai/{id}', [NilaiController::class, 'update'])->name('admin.nilai.update');
    Route::get('/admin/nilai/{mata_pelajaran_id}', [NilaiController::class, 'showByMataPelajaran'])->name('admin.nilai.perMapel');
    Route::get('/admin/nilai/download/{mata_pelajaran_id}', [NilaiController::class, 'ExportPDF'])->name('admin.nilai.download');
    Route::get('/admin/pembayaran', [PembayaranController::class, 'index'])->name('admin.pembayaran');
    Route::put('/admin/pembayaran/{id}', [PembayaranController::class, 'update'])->name('admin.pembayaran.update');
    Route::get('/admin/jadwal', [JadwalController::class, 'index'])->name('admin.jadwal');
    Route::post('/admin/jadwal', [JadwalController::class, 'store'])->name('admin.jadwal.store');
    Route::put('/admin/jadwal/{id}', [JadwalController::class, 'update'])->name('admin.jadwal.update');
    Route::delete('/admin/jadwal/{id}', [JadwalController::class, 'destroy'])->name('admin.jadwal.destroy');

    
    


});


Route::middleware(['auth', 'userMiddleware'])->group(function() {
    Route::get('/user/dashboard',[UserController::class, 'index'])->name('user.dashboard');
    Route::get('/user/download/{id}',[UserController::class, 'exportPDF'])->name('user.download');
    Route::get('/user/daftar', [DaftarSiswaController::class, 'index'])->name('user.daftar');
    
    Route::post('/user/daftar', [DaftarSiswaController::class, 'store'])->name('user.daftar.store');
    Route::get('/user/bayar', [BayarController::class, 'index'])->name('user.bayar');
    Route::post('/user/bayar', [BayarController::class, 'store'])->name('user.bayar.store');
    Route::get('user/jadwal', [UserController::class, 'jadwal'])->name('user.jadwal');
    

});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
