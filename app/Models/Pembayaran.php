<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $fillable = [
        'user_id',
        'pengajuan_id',
        'bulan',
        'tahun',
        'nominal',
        'metode_pembayaran',
        'bukti_transfer',
        'status',
        'tanggal_bayar',
    ];

    public function kamar()
    {
        return $this->belongsTo(\App\Models\Kamar::class);
    }

    public function penghuni()
    {
        return $this->belongsTo(\App\Models\penghuni::class);
    }

    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    protected $casts = [
        'tanggal_bayar' => 'datetime',
    ];
}