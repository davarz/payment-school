<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Tagihan;
use App\Models\KategoriPembayaran;
use App\Models\Siswa; // Tambahkan model Siswa
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Ambil data siswa dari tabel siswa
        $siswa = Siswa::where('user_id', $user->id)->first();
        
        // Ambil tagihan user ini
        $tagihan = Tagihan::where('user_id', $user->id)
            ->with('kategori')
            ->get();
        
        // Ambil pembayaran user ini
        $pembayaran = Pembayaran::where('user_id', $user->id)
            ->with('kategori')
            ->latest()
            ->take(5) // Batasi untuk dashboard
            ->get();

        // Hitung statistik
        $totalTagihan = Tagihan::where('user_id', $user->id)
            ->where('status', 'unpaid')
            ->count();
            
        $totalPaid = Pembayaran::where('user_id', $user->id)
            ->where('status', 'paid')
            ->sum('jumlah_bayar');
            
        $pendingVerification = Pembayaran::where('user_id', $user->id)
            ->where('status', 'pending')
            ->count();

        return view('siswa.dashboard', compact(
            'siswa', 
            'tagihan', 
            'pembayaran',
            'totalTagihan',
            'totalPaid',
            'pendingVerification'
        ));
    }

    public function tagihan()
    {
        $user = auth()->user();
        
        // Ambil semua tagihan user
        $tagihan = Tagihan::where('user_id', $user->id)
            ->with('kategori')
            ->orderBy('tanggal_jatuh_tempo', 'asc')
            ->get();
        
        // Ambil kategori aktif untuk form pembuatan tagihan
        $kategori = KategoriPembayaran::where('status', 'active')->get();

        // Hitung total tagihan
        $totalTagihan = $tagihan->where('status', 'unpaid')->sum('jumlah_tagihan');
        $totalPaid = $tagihan->where('status', 'paid')->sum('jumlah_tagihan');

        return view('siswa.tagihan', compact(
            'tagihan', 
            'kategori',
            'totalTagihan',
            'totalPaid'
        ));
    }

    public function createTagihan(Request $request)
    {
        $request->validate([
            'kategori_pembayaran_id' => 'required|exists:kategori_pembayaran,id',
            'jumlah_tagihan' => 'required|numeric|min:0',
            'tanggal_jatuh_tempo' => 'required|date|after_or_equal:today',
            'keterangan' => 'nullable|string|max:500',
        ]);

        // Cek apakah sudah ada tagihan untuk kategori ini bulan ini
        $existingTagihan = Tagihan::where('user_id', auth()->id())
            ->where('kategori_pembayaran_id', $request->kategori_pembayaran_id)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->exists();

        if ($existingTagihan) {
            return redirect()->route('siswa.tagihan')
                ->with('error', 'Anda sudah memiliki tagihan untuk kategori ini bulan ini.');
        }

        Tagihan::create([
            'user_id' => auth()->id(),
            'kategori_pembayaran_id' => $request->kategori_pembayaran_id,
            'jumlah_tagihan' => $request->jumlah_tagihan,
            'tanggal_jatuh_tempo' => $request->tanggal_jatuh_tempo,
            'status' => 'unpaid',
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('siswa.tagihan')
            ->with('success', 'Tagihan berhasil diajukan. Menunggu verifikasi admin.');
    }

    public function transaksi()
    {
        $pembayaran = Pembayaran::where('user_id', auth()->id())
            ->with(['kategori', 'verifikator'])
            ->latest()
            ->paginate(10);

        // Hitung statistik transaksi
        $totalTransaksi = Pembayaran::where('user_id', auth()->id())->count();
        $totalDibayar = Pembayaran::where('user_id', auth()->id())
            ->where('status', 'paid')
            ->sum('jumlah_bayar');
        $pendingCount = Pembayaran::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->count();

        return view('siswa.transaksi', compact(
            'pembayaran',
            'totalTransaksi',
            'totalDibayar',
            'pendingCount'
        ));
    }

    /**
     * Tampilkan detail tagihan spesifik
     */
    public function showTagihan(Tagihan $tagihan)
    {
        // Pastikan tagihan milik user yang login
        if ($tagihan->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $tagihan->load(['kategori', 'pembayaran']);
        return view('siswa.tagihan-show', compact('tagihan'));
    }

    /**
     * Tampilkan detail pembayaran spesifik
     */
    public function showPembayaran(Pembayaran $pembayaran)
    {
        // Pastikan pembayaran milik user yang login
        if ($pembayaran->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $pembayaran->load(['kategori', 'verifikator']);
        return view('siswa.pembayaran-show', compact('pembayaran'));
    }
}