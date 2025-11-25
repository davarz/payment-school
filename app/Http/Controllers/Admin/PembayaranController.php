<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\User;
use App\Models\KategoriPembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pembayaran::with(['user', 'kategori']);

        if ($request->has('bulan') && $request->bulan) {
            $query->whereMonth('tanggal_bayar', $request->bulan);
        }

        if ($request->has('tahun') && $request->tahun) {
            $query->whereYear('tanggal_bayar', $request->tahun);
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $pembayaran = $query->latest()->get();

        return view('admin.pembayaran.index', compact('pembayaran'));
    }

    public function create()
    {
        $siswa = User::where('role', 'siswa')->get();
        $kategori = KategoriPembayaran::where('status', 'active')->get();
        return view('admin.pembayaran.create', compact('siswa', 'kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'kategori_pembayaran_id' => 'required|exists:kategori_pembayaran,id',
            'jumlah_bayar' => 'required|numeric|min:0',
            'tanggal_bayar' => 'required|date',
            'metode_bayar' => 'required|in:tunai,transfer,qris',
            'keterangan' => 'nullable|string',
        ]);

        Pembayaran::create([
            'user_id' => $request->user_id,
            'kategori_pembayaran_id' => $request->kategori_pembayaran_id,
            'jumlah_bayar' => $request->jumlah_bayar,
            'tanggal_bayar' => $request->tanggal_bayar,
            'metode_bayar' => $request->metode_bayar,
            'keterangan' => $request->keterangan,
            'status' => 'paid', // 🔄 Langsung paid karena dibuat admin
            'verified_by' => auth()->id(),
            'verified_at' => now(),
        ]);

        return redirect()->route('admin.pembayaran.index')
            ->with('success', 'Pembayaran berhasil dicatat');
    }

    /**
     * VERIFY PEMBAYARAN (ubah dari pending ke paid)
     */
    public function verify(Pembayaran $pembayaran)
    {
        DB::transaction(function () use ($pembayaran) {
            $pembayaran->update([
                'status' => 'paid', // 🔄 UBAH: verified → paid
                'verified_by' => auth()->id(),
                'verified_at' => now(),
            ]);
            
            // Update related tagihan jika ada
            if ($pembayaran->tagihan_id) {
                $pembayaran->tagihan->update(['status' => 'paid']);
            }
        });

        return redirect()->route('admin.pembayaran.index')
            ->with('success', 'Pembayaran berhasil diverifikasi');
    }

    /**
     * BATALKAN PEMBAYARAN
     */
    public function cancel(Pembayaran $pembayaran)
    {
        $pembayaran->update([
            'status' => 'canceled', // 🔄 UBAH: rejected → canceled
            'verified_by' => auth()->id(),
            'verified_at' => now(),
        ]);

        return redirect()->route('admin.pembayaran.index')
            ->with('success', 'Pembayaran berhasil dibatalkan');
    }

    public function destroy(Pembayaran $pembayaran)
    {
        $pembayaran->delete();
        return redirect()->route('admin.pembayaran.index')
            ->with('success', 'Pembayaran berhasil dihapus');
    }
}