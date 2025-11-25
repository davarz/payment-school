<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\CustomResetPasswordNotification;
use App\Notifications\ResetPasswordNotification;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'nis',
        'nik',
        'tahun_ajaran',
        'status_siswa',
        'kelas',
        'alamat',
        'telepon',
        'tanggal_lahir',
        'tempat_lahir',
        'role',
    ];
    
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'tanggal_lahir' => 'date',
        ];
    }

    // HAPUS SEMUA METHOD SPATIE
    // GANTI DENGAN METHOD SEDERHANA:

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isOperator()
    {
        return $this->role === 'operator';
    }

    public function isSiswa()
    {
        return $this->role === 'siswa';
    }

    // Relationship tetap
    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class);
    }

    public function tagihan()
    {
        return $this->hasMany(Tagihan::class);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}