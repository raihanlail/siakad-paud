<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
     protected $fillable = [
        'kelas_id', 'mata_pelajaran_id', 'guru_id', 'hari', 'jam_mulai', 'jam_selesai'
    ];

    public function kelas()       { 
        return $this->belongsTo(Kelas::class);
         }
    public function mataPelajaran() { 
        return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran_id');
         }
    public function guru()        { 
        return $this->belongsTo(Guru::class);
         }
}
