<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    use HasFactory;
    protected $table = 'mapels';

    protected $fillable = ['nama', 'kode'];
    public function nilais()
    {
        return $this->hasMany(Nilai::class);
    }
    public function gurus()
    {
        return $this->hasMany(Guru::class, 'mata_pelajaran_id');
    }
}
