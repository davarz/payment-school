<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Notifications\ResetPasswordNotification;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
        'remember_token',
    ]; // Hapus field siswa karena sudah dipisah ke tabel siswa
    
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relationship dengan Siswa
    public function siswa()
    {
        return $this->hasOne(Siswa::class);
    }

    // Relationship dengan Pembayaran
    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class);
    }

    public function tagihan()
    {
        return $this->hasMany(Tagihan::class);
    }

    // Method permission (jika masih menggunakan role di users table)
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

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}