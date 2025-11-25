<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tagihan;
use App\Models\User;
use App\Models\KategoriPembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TagihanController extends Controller
{
    public function index(Request $request)
    {
        $query = Tagihan::with(['user', 'kategori']);

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('bulan') && $request->bulan) {
            $query->whereMonth('tanggal_jatuh_tempo', $request->bulan);
        }

        if ($request->has('tahun') && $request->tahun) {
            $query->whereYear('tanggal_jatuh_tempo', $request->tahun);
        }

        $tagihan = $query->latest()->paginate(10);

        return view('admin.tagihan.index', compact('tagihan'));
    }

    public function show(Tagihan $tagihan)
    {
        $tagihan->load(['user', 'kategori', 'pembayaran']);
        return view('admin.tagihan.show', compact('tagihan'));
    }

    public function create()
    {
        $siswa = User::where('role', 'siswa')->where('status_siswa', 'aktif')->get();
        $kategori = KategoriPembayaran::where('status', 'active')->get();
        return view('admin.tagihan.create', compact('siswa', 'kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'kategori_pembayaran_id' => 'required|exists:kategori_pembayaran,id',
            'jumlah_tagihan' => 'required|numeric|min:0',
            'tanggal_jatuh_tempo' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        Tagihan::create([
            'user_id' => $request->user_id,
            'kategori_pembayaran_id' => $request->kategori_pembayaran_id,
            'jumlah_tagihan' => $request->jumlah_tagihan,
            'tanggal_jatuh_tempo' => $request->tanggal_jatuh_tempo,
            'keterangan' => $request->keterangan,
            'status' => 'unpaid', // 🔄 UBAH: pending → unpaid
        ]);

        return redirect()->route('admin.tagihan.index')
            ->with('success', 'Tagihan berhasil dibuat');
    }

    public function edit(Tagihan $tagihan)
    {
        $kategori = KategoriPembayaran::where('status', 'active')->get();
        return view('admin.tagihan.edit', compact('tagihan', 'kategori'));
    }

    public function update(Request $request, Tagihan $tagihan)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'kategori_pembayaran_id' => 'required|exists:kategori_pembayaran,id',
            'jumlah_tagihan' => 'required|numeric|min:0',
            'tanggal_jatuh_tempo' => 'required|date',
            'keterangan' => 'nullable|string',
            'status' => 'required|in:unpaid,pending,paid,canceled', // 🔄 UBAH
        ]);

        $tagihan->update($request->all());

        return redirect()->route('admin.tagihan.index')
            ->with('success', 'Tagihan berhasil diperbarui');
    }

    public function destroy(Tagihan $tagihan)
    {
        $tagihan->delete();
        return redirect()->route('admin.tagihan.index')
            ->with('success', 'Tagihan berhasil dihapus');
    }

    public function generateBills(Request $request)
    {
        try {
            $startTime = microtime(true);

            $siswaIds = User::where('role', 'siswa')
                ->where('status_siswa', 'aktif')
                ->pluck('id');

            $kategoriAktif = KategoriPembayaran::where('status', 'active')
                ->where('auto_generate', true)
                ->get(['id', 'nama_kategori', 'jumlah', 'frekuensi', 'tahun_ajaran', 'semester']);

            $totalGenerated = 0;
            $bulanIni = now()->month;
            $tahunIni = now()->year;

            foreach ($siswaIds as $siswaId) {
                foreach ($kategoriAktif as $kategori) {
                    if ($this->shouldGenerateThisMonth($kategori)) {
                        $created = $this->createTagihan($siswaId, $kategori, $bulanIni, $tahunIni);
                        if ($created)
                            $totalGenerated++;
                    }
                }
            }

            $executionTime = round(microtime(true) - $startTime, 2);

            return response()->json([
                'success' => true,
                'message' => "✅ Berhasil generate {$totalGenerated} tagihan dalam {$executionTime} detik",
                'data' => [
                    'total_generated' => $totalGenerated,
                    'execution_time' => $executionTime
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '❌ Gagal generate tagihan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * MARK TAGIHAN SUDAH DIBAYAR
     */
    public function markAsPaid(Tagihan $tagihan)
    {
        $tagihan->update([
            'status' => 'paid', // 🔄 UBAH: paid (tetap sama)
            'paid_at' => now(),
        ]);

        return redirect()->route('admin.tagihan.index')
            ->with('success', 'Tagihan berhasil ditandai sebagai lunas');
    }

    /**
     * BATALKAN TAGIHAN
     */
    public function cancel(Tagihan $tagihan)
    {
        $tagihan->update([
            'status' => 'canceled', // 🔄 STATUS BARU
        ]);

        return redirect()->route('admin.tagihan.index')
            ->with('success', 'Tagihan berhasil dibatalkan');
    }

    // ==================== HELPER METHODS ====================

    protected function shouldGenerateThisMonth($kategori)
    {
        $currentMonth = now()->month;

        return match ($kategori->frekuensi) {
            'bulanan' => true,
            'semester' => in_array($currentMonth, [1, 7]),
            'tahunan' => $currentMonth == 7,
            default => false,
        };
    }

    protected function createTagihan($siswaId, $kategori, $bulanIni, $tahunIni)
    {
        $existing = Tagihan::where('user_id', $siswaId)
            ->where('kategori_pembayaran_id', $kategori->id)
            ->whereYear('created_at', $tahunIni);

        if ($kategori->frekuensi === 'bulanan') {
            $existing->whereMonth('created_at', $bulanIni);
        }

        if ($existing->exists()) {
            return false;
        }

        try {
            Tagihan::create([
                'user_id' => $siswaId,
                'kategori_pembayaran_id' => $kategori->id,
                'jumlah_tagihan' => $kategori->jumlah,
                'tanggal_jatuh_tempo' => now()->addDays(15),
                'status' => 'unpaid', // 🔄 UBAH: pending → unpaid
                'keterangan' => $this->generateKeterangan($kategori)
            ]);
            return true;
        } catch (\Exception $e) {
            Log::error('Gagal membuat tagihan', [
                'user_id' => $siswaId,
                'kategori_id' => $kategori->id,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    protected function generateKeterangan($kategori)
    {
        $bulan = now()->translatedFormat('F Y');

        return match ($kategori->frekuensi) {
            'bulanan' => "Tagihan {$kategori->nama_kategori} {$bulan}",
            'semester' => "Tagihan {$kategori->nama_kategori} Semester " . (now()->month <= 6 ? 'Genap' : 'Ganjil') . " TA {$kategori->tahun_ajaran}",
            'tahunan' => "Tagihan {$kategori->nama_kategori} Tahun " . now()->year,
        };
    }
}