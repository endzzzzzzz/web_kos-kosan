<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    protected $fillable = [
        'nomor_kamar',
        'informasi_kamar_id',
        'status',
    ];

    public function informasiKamar()
    {
        return $this->belongsTo(\App\Models\InformasiKamar::class);
    }

    public function penghuni()
    {
        return $this->hasOne(Penghuni::class)
            ->where('status', 'aktif');
    }
}