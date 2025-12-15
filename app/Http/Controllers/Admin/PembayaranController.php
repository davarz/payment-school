<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Siswa; // Ganti User dengan Siswa
use App\Models\KategoriPembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pembayaran::with(['user', 'kategori', 'user.siswa']); // Tambahkan relasi siswa

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
        // Ambil siswa yang aktif melalui relasi
        $siswa = Siswa::where('status_siswa', 'aktif')
            ->with('user')
            ->get()
            ->map(function ($siswa) {
                return [
                    'id' => $siswa->user_id, // Gunakan user_id untuk pembayaran
                    'name' => $siswa->user->name ?? 'N/A',
                    'nis' => $siswa->nis,
                    'kelas' => $siswa->kelas,
                ];
            });
            
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
            'bukti_bayar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'user_id' => $request->user_id,
            'kategori_pembayaran_id' => $request->kategori_pembayaran_id,
            'jumlah_bayar' => $request->jumlah_bayar,
            'tanggal_bayar' => $request->tanggal_bayar,
            'metode_bayar' => $request->metode_bayar,
            'keterangan' => $request->keterangan,
            'status' => 'paid',
            'verified_by' => auth()->id(),
            'verified_at' => now(),
        ];

        // Upload bukti bayar jika ada
        if ($request->hasFile('bukti_bayar')) {
            $path = $request->file('bukti_bayar')->store('bukti_pembayaran', 'public');
            $data['bukti_bayar'] = $path;
        }

        Pembayaran::create($data);

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
                'status' => 'paid',
                'verified_by' => auth()->id(),
                'verified_at' => now(),
            ]);
            
            // Update related tagihan jika ada (cari berdasarkan user dan kategori)
            $tagihan = \App\Models\Tagihan::where('user_id', $pembayaran->user_id)
                ->where('kategori_pembayaran_id', $pembayaran->kategori_pembayaran_id)
                ->where('status', 'unpaid')
                ->first();
                
            if ($tagihan) {
                $tagihan->update(['status' => 'paid']);
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
            'status' => 'canceled',
            'verified_by' => auth()->id(),
            'verified_at' => now(),
        ]);

        return redirect()->route('admin.pembayaran.index')
            ->with('success', 'Pembayaran berhasil dibatalkan');
    }

    public function destroy(Pembayaran $pembayaran)
    {
        // Hapus bukti bayar jika ada
        if ($pembayaran->bukti_bayar && Storage::disk('public')->exists($pembayaran->bukti_bayar)) {
            Storage::disk('public')->delete($pembayaran->bukti_bayar);
        }
        
        $pembayaran->delete();
        return redirect()->route('admin.pembayaran.index')
            ->with('success', 'Pembayaran berhasil dihapus');
    }

    /**
     * SHOW DETAIL PEMBAYARAN
     */
    public function show(Pembayaran $pembayaran)
    {
        $pembayaran->load(['user', 'kategori', 'verifikator', 'user.siswa']);
        return view('admin.pembayaran.show', compact('pembayaran'));
    }
}