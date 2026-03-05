<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrangTua extends Model
{
    protected $table = 'orang_tuas';

    protected $fillable = ['nama', 'alamat', 'email', 'phone', 'user_id'];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
