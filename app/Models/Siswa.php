<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;
    protected $table = 'siswas';
    protected $primaryKey = 'id';
    public $incrementing = true; 
    protected $fillable = ['nama', 'nis', 'alamat', 'jenis_kelamin', 'tanggal_lahir', 'orang_tua_id'];

    public function orangTua()
    {
        return $this->belongsTo(User::class, 'orang_tua_id');
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'siswa_id');
    }

    public function bayar()
    {
        return $this->hasOne(Pembayaran::class);
    }
}
