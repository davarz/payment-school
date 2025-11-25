<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Tagihan;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSiswa = User::where('role', 'siswa')->count();
        $totalPembayaran = Pembayaran::where('status', 'paid')->sum('jumlah_bayar'); // 🔄 UBAH: verified → paid
        $totalTagihan = Tagihan::where('status', 'unpaid')->count(); // 🔄 UBAH: pending → unpaid
        $pembayaranPending = Pembayaran::where('status', 'pending')->count();

        $recentPembayaran = Pembayaran::with(['user', 'kategori'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalSiswa',
            'totalPembayaran',
            'totalTagihan',
            'pembayaranPending',
            'recentPembayaran'
        ));
    }
}