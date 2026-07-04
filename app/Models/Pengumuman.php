<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    protected $table = 'pengumumans'; 

    protected $fillable = ['judul', 'isi', 'tanggal', 'aktif'];

    protected $casts = [
        'aktif'   => 'boolean',
        'tanggal' => 'datetime',
    ];
}

