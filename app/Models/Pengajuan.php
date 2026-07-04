<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    protected $fillable = [
        'user_id',
        'kamar_id',
        'nama',
        'no_hp',
        'alamat_asal',
        'status',
        'tanggal_rencana_masuk',
    ];

    public function kamar()
    {
        return $this->belongsTo(\App\Models\Kamar::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function penghuni()
    {
        return $this->hasOne(Penghuni::class);
    }

    public function pembayaran() 
    {
        return $this->hasMany(Pembayaran::class);
    }
}