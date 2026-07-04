<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penghuni extends Model
{
    protected $fillable = [
        'user_id',
        'kamar_id',
        'nama',
        'nomor_hp',
        'tanggal_masuk',
        'status',
        'alamat_asal',
        'status_pekerjaan',
        'tanggal_masuk',
    ];

    public function kamar()
    {
        return $this->belongsTo(Kamar::class);
    }

    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class);
    }

    public function pembayaranBelumLunas()
{
    return $this->hasOneThrough(
        \App\Models\Pembayaran::class,
        \App\Models\Pengajuan::class,
        'user_id',      // FK di pengajuans
        'pengajuan_id', // FK di pembayarans
        'user_id',      // kolom lokal di penghunis
        'id'            // PK di pengajuans
    )
    ->where('bulan', \Carbon\Carbon::now()->format('F'))
    ->where('tahun', \Carbon\Carbon::now()->format('Y'))
    ->where('pembayarans.status', 'belum_bayar');
}

    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class);
    }

    public function pengaduans()
{
    return $this->hasMany(Pengaduan::class);
}
}