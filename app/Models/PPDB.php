<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PPDB extends Model
{
    use HasFactory;
    protected $fillable = ['siswa_id', 'tahun_ajaran', 'status'];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
