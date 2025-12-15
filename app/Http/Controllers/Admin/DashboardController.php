<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Tagihan;
use App\Models\Siswa; // Ganti User dengan Siswa
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Total siswa dari tabel siswa
        $totalSiswa = Siswa::where('status_siswa', 'aktif')->count();
        
        // Total pembayaran yang sudah dibayar
        $totalPembayaran = Pembayaran::where('status', 'paid')->sum('jumlah_bayar');
        
        // Total tagihan yang belum dibayar
        $totalTagihan = Tagihan::where('status', 'unpaid')->count();
        
        // Pembayaran yang pending (menunggu verifikasi)
        $pembayaranPending = Pembayaran::where('status', 'pending')->count();

        // Recent pembayaran dengan relasi yang benar
        $recentPembayaran = Pembayaran::with(['user', 'kategori'])
            ->latest()
            ->take(5)
            ->get();

        // Jika perlu data siswa untuk chart atau statistik lainnya
        $siswaPerKelas = Siswa::selectRaw('kelas, COUNT(*) as total')
            ->where('status_siswa', 'aktif')
            ->groupBy('kelas')
            ->get();

        return view('admin.dashboard', compact(
            'totalSiswa',
            'totalPembayaran',
            'totalTagihan',
            'pembayaranPending',
            'recentPembayaran',
            'siswaPerKelas'
        ));
    }
}