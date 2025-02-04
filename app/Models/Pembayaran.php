<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;
    protected $table = 'pembayarans';
    protected $fillable = ['siswa_id', 'jenis', 'jumlah', 'bukti', 'status'];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
