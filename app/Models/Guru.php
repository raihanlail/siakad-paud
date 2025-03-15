<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;
    protected $table = 'gurus';
    protected $fillable = ['nama', 'nip', 'alamat',  'no_telp', 'mata_pelajaran_id'];
    public function mapel()
    {
        return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
