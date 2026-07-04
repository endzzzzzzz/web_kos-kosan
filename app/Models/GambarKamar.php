<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GambarKamar extends Model
{
    protected $fillable = [
        'informasi_kamar_id',
        'gambar',
    ];

    public function kamar()
    {
        return $this->belongsTo(InformasiKamar::class);
    }
}