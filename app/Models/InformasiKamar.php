<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InformasiKamar extends Model
{
    protected $fillable = [
        'nama_kamar',
        'slug',
        'lantai',
        'harga',
        'deskripsi',
        'gambar',
    ];

    public function gambars()
    {
        return $this->hasMany(GambarKamar::class);
    }
    
    public function kamars()
    {
        return $this->hasMany(Kamar::class);
    }
}
