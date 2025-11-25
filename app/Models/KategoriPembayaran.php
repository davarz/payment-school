<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriPembayaran extends Model
{
    use HasFactory;

    // TAMBAH INI
    protected $table = 'kategori_pembayaran';
    protected $fillable = [
        'nama_kategori',
        'deskripsi',
        'jumlah',
        'tahun_ajaran',
        'semester',
        'status',
    ];

    protected $casts = [
        'jumlah' => 'decimal:2',
    ];

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class);
    }

    public function tagihan()
    {
        return $this->hasMany(Tagihan::class);
    }
}