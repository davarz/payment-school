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
    ]; // Hapus 'paid_at' karena tidak ada di migration

    protected $casts = [
        'tanggal_jatuh_tempo' => 'date',
        'jumlah_tagihan' => 'decimal:2',
        'status' => 'string',
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