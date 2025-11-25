<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    // TAMBAH INI
    protected $table = 'pembayaran';
    protected $fillable = [
        'kode_transaksi',
        'user_id',
        'kategori_pembayaran_id',
        'jumlah_bayar',
        'tanggal_bayar',
        'metode_bayar',
        'status',
        'keterangan',
        'bukti_bayar',
        'verified_by',
        'verified_at',
    ];

    protected $casts = [
        'jumlah_bayar' => 'decimal:2',
        'tanggal_bayar' => 'date',
        'verified_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriPembayaran::class, 'kategori_pembayaran_id');
    }

    public function verifikator()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->kode_transaksi = 'TRX-' . date('Ymd') . '-' . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
        });
    }
}