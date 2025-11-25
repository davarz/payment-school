<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    use HasFactory;

    protected $table = "tagihan";
    protected $fillable = [
        'user_id',
        'kategori_pembayaran_id', 
        'jumlah_tagihan',
        'tanggal_jatuh_tempo',
        'status',
        'keterangan',
        'paid_at'
    ];

    protected $casts = [
        'tanggal_jatuh_tempo' => 'date',
        'paid_at' => 'datetime',
        'jumlah_tagihan' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriPembayaran::class, 'kategori_pembayaran_id');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class);
    }
}