<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriPembayaran extends Model
{
    use HasFactory;

    protected $table = 'kategori_pembayaran';
    
    protected $fillable = [
        'nama_kategori',
        'deskripsi',
        'jumlah',
        'tahun_ajaran',
        'semester',
        'frekuensi',
        'auto_generate',
        'status',
    ];

    protected $casts = [
        'jumlah' => 'decimal:2',
        'auto_generate' => 'boolean',
        'semester' => 'string',
        'frekuensi' => 'string',
        'status' => 'string',
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