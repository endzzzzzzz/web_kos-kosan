<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    protected $fillable = [
        'penghuni_id',
        'judul',
        'kategori',
        'deskripsi',
        'lampiran',
        'status',
        'catatan_admin',
    ];

    public function penghuni()
    {
        return $this->belongsTo(Penghuni::class);
    }
}