<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Kelas extends Model
{
    protected $fillable = ['name', 'capacity'];

    public function siswa(){
        return $this->hasMany(Siswa::class, 'kelas_id');
    }
    public function jadwal() { return $this->hasMany(Jadwal::class); }
}
