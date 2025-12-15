<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Siswa extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'siswa';
    
    protected $fillable = [
        'user_id',
        'nis',
        'nik',
        'nisn',
        'tahun_ajaran',
        'status_siswa',
        'kelas',
        'alamat',
        'telepon',
        'tanggal_lahir',
        'tempat_lahir',
        'jenis_kelamin',
        'nama_wali',
        'telepon_wali',
        'alamat_wali',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'status_siswa' => 'string',
        'jenis_kelamin' => 'string',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scope untuk query yang sering digunakan
    public function scopeAktif($query)
    {
        return $query->where('status_siswa', 'aktif');
    }

    public function scopeByKelas($query, $kelas)
    {
        return $query->where('kelas', $kelas);
    }

    public function scopeByTahunAjaran($query, $tahunAjaran)
    {
        return $query->where('tahun_ajaran', $tahunAjaran);
    }
}