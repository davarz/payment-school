<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Tagihan;
use App\Models\KategoriPembayaran;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $tagihan = Tagihan::where('user_id', $user->id)
            ->with('kategori')
            ->get();
        
        $pembayaran = Pembayaran::where('user_id', $user->id)
            ->with('kategori')
            ->latest()
            ->get();

        return view('siswa.dashboard', compact('tagihan', 'pembayaran'));
    }

    public function tagihan()
    {
        $user = auth()->user();
        $tagihan = Tagihan::where('user_id', $user->id)
            ->with('kategori')
            ->get();
        
        $kategori = KategoriPembayaran::where('status', 'active')->get();

        return view('siswa.tagihan', compact('tagihan', 'kategori'));
    }

    public function createTagihan(Request $request)
    {
        $request->validate([
            'kategori_pembayaran_id' => 'required|exists:kategori_pembayaran,id',
            'jumlah_tagihan' => 'required|numeric|min:0',
            'tanggal_jatuh_tempo' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        Tagihan::create([
            'user_id' => auth()->id(),
            'kategori_pembayaran_id' => $request->kategori_pembayaran_id,
            'jumlah_tagihan' => $request->jumlah_tagihan,
            'tanggal_jatuh_tempo' => $request->tanggal_jatuh_tempo,
            'status' => 'unpaid', // 🔄 UBAH: pending → unpaid
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('siswa.tagihan')
            ->with('success', 'Tagihan berhasil diajukan');
    }

    public function transaksi()
    {
        $pembayaran = Pembayaran::where('user_id', auth()->id())
            ->with('kategori')
            ->latest()
            ->get();

        return view('siswa.transaksi', compact('pembayaran'));
    }
}