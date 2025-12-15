<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Tagihan;
use App\Models\Siswa;
use App\Models\KategoriPembayaran;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    /**
     * Display laporan index page
     */
    public function index(Request $request)
    {
        // Default date range: current month
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));
        
        // Validate dates
        $startDate = Carbon::parse($startDate)->startOfDay();
        $endDate = Carbon::parse($endDate)->endOfDay();
        
        // Get filter parameters
        $kelas = $request->get('kelas');
        $status = $request->get('status');
        $kategoriId = $request->get('kategori_id');
        
        // Query pembayaran
        $pembayaranQuery = Pembayaran::with(['user.siswa', 'kategori', 'verifikator'])
            ->whereBetween('tanggal_bayar', [$startDate, $endDate]);
            
        // Query tagihan
        $tagihanQuery = Tagihan::with(['user.siswa', 'kategori'])
            ->whereBetween('created_at', [$startDate, $endDate]);
        
        // Filter by kelas
        if ($kelas) {
            $pembayaranQuery->whereHas('user.siswa', function ($q) use ($kelas) {
                $q->where('kelas', $kelas);
            });
            
            $tagihanQuery->whereHas('user.siswa', function ($q) use ($kelas) {
                $q->where('kelas', $kelas);
            });
        }
        
        // Filter by kategori
        if ($kategoriId) {
            $pembayaranQuery->where('kategori_pembayaran_id', $kategoriId);
            $tagihanQuery->where('kategori_pembayaran_id', $kategoriId);
        }
        
        // Filter by status (untuk pembayaran)
        if ($status && $status !== 'all') {
            $pembayaranQuery->where('status', $status);
        }
        
        // Execute queries
        $pembayaran = $pembayaranQuery->latest()->get();
        $tagihan = $tagihanQuery->latest()->get();
        
        // Get statistics
        $statistik = $this->getStatistik($startDate, $endDate, $kelas, $kategoriId);
        
        // Get filter options
        $kelasList = Siswa::distinct()->whereNotNull('kelas')->pluck('kelas')->sort()->values();
        $kategoriList = KategoriPembayaran::where('status', 'active')->get();
        
        return view('admin.laporan.index', compact(
            'pembayaran',
            'tagihan',
            'statistik',
            'startDate',
            'endDate',
            'kelas',
            'status',
            'kategoriId',
            'kelasList',
            'kategoriList'
        ));
    }
    
    /**
     * Export laporan to Excel/PDF
     */
    public function export(Request $request)
    {
        $type = $request->get('type', 'excel');
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));
        $kelas = $request->get('kelas');
        $kategoriId = $request->get('kategori_id');
        
        $startDate = Carbon::parse($startDate)->startOfDay();
        $endDate = Carbon::parse($endDate)->endOfDay();
        
        // Get data for export
        $pembayaran = Pembayaran::with(['user.siswa', 'kategori'])
            ->whereBetween('tanggal_bayar', [$startDate, $endDate])
            ->where('status', 'paid')
            ->when($kelas, function ($q) use ($kelas) {
                return $q->whereHas('user.siswa', function ($q) use ($kelas) {
                    $q->where('kelas', $kelas);
                });
            })
            ->when($kategoriId, function ($q) use ($kategoriId) {
                return $q->where('kategori_pembayaran_id', $kategoriId);
            })
            ->get();
            
        $tagihan = Tagihan::with(['user.siswa', 'kategori'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->when($kelas, function ($q) use ($kelas) {
                return $q->whereHas('user.siswa', function ($q) use ($kelas) {
                    $q->where('kelas', $kelas);
                });
            })
            ->when($kategoriId, function ($q) use ($kategoriId) {
                return $q->where('kategori_pembayaran_id', $kategoriId);
            })
            ->get();
        
        $statistik = $this->getStatistik($startDate, $endDate, $kelas, $kategoriId);
        
        if ($type === 'pdf') {
            return $this->exportToPDF($pembayaran, $tagihan, $statistik, $startDate, $endDate);
        }
        
        // Default: Excel
        return $this->exportToExcel($pembayaran, $tagihan, $statistik, $startDate, $endDate);
    }
    
    /**
     * Laporan per siswa
     */
    public function perSiswa(Request $request)
    {
        $siswaId = $request->get('siswa_id');
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));
        
        $startDate = Carbon::parse($startDate)->startOfDay();
        $endDate = Carbon::parse($endDate)->endOfDay();
        
        $siswa = null;
        $pembayaran = collect();
        $tagihan = collect();
        $riwayat = collect();
        
        if ($siswaId) {
            $siswa = Siswa::with('user')->find($siswaId);
            
            if ($siswa) {
                // Get pembayaran
                $pembayaran = Pembayaran::with('kategori')
                    ->where('user_id', $siswa->user_id)
                    ->whereBetween('tanggal_bayar', [$startDate, $endDate])
                    ->latest()
                    ->get();
                
                // Get tagihan
                $tagihan = Tagihan::with('kategori')
                    ->where('user_id', $siswa->user_id)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->latest()
                    ->get();
                
                // Get riwayat pembayaran (all time untuk statistik)
                $riwayat = Pembayaran::where('user_id', $siswa->user_id)
                    ->where('status', 'paid')
                    ->select(
                        DB::raw('YEAR(tanggal_bayar) as tahun'),
                        DB::raw('MONTH(tanggal_bayar) as bulan'),
                        DB::raw('SUM(jumlah_bayar) as total')
                    )
                    ->groupBy('tahun', 'bulan')
                    ->orderBy('tahun', 'desc')
                    ->orderBy('bulan', 'desc')
                    ->limit(12)
                    ->get();
            }
        }
        
        // Get list siswa untuk dropdown
        $siswaList = Siswa::with('user')
            ->where('status_siswa', 'aktif')
            ->get()
            ->map(function ($siswa) {
                return [
                    'id' => $siswa->id,
                    'text' => "{$siswa->nis} - {$siswa->user->name} - {$siswa->kelas}"
                ];
            });
        
        return view('admin.laporan.per-siswa', compact(
            'siswa',
            'pembayaran',
            'tagihan',
            'riwayat',
            'siswaList',
            'siswaId',
            'startDate',
            'endDate'
        ));
    }
    
    /**
     * Laporan tagihan per kelas
     */
    public function perKelas(Request $request)
    {
        $kelas = $request->get('kelas');
        $tahunAjaran = $request->get('tahun_ajaran', date('Y') . '/' . (date('Y') + 1));
        
        // Get list kelas
        $kelasList = Siswa::distinct()->whereNotNull('kelas')->pluck('kelas')->sort()->values();
        $tahunAjaranList = Siswa::distinct()->whereNotNull('tahun_ajaran')->pluck('tahun_ajaran')->sort()->values();
        
        $data = collect();
        
        if ($kelas) {
            // Get siswa in kelas
            $siswaIds = Siswa::where('kelas', $kelas)
                ->where('tahun_ajaran', $tahunAjaran)
                ->where('status_siswa', 'aktif')
                ->pluck('user_id');
            
            // Get tagihan for these students
            $tagihan = Tagihan::with(['user.siswa', 'kategori'])
                ->whereIn('user_id', $siswaIds)
                ->where('status', 'unpaid')
                ->get()
                ->groupBy(function ($item) {
                    return $item->kategori->nama_kategori;
                });
            
            // Get summary statistics
            $totalTagihan = $tagihan->flatten()->sum('jumlah_tagihan');
            $totalSiswa = $siswaIds->count();
            $siswaSudahBayar = Tagihan::whereIn('user_id', $siswaIds)
                ->where('status', 'paid')
                ->distinct('user_id')
                ->count('user_id');
            
            $data = [
                'kelas' => $kelas,
                'tahun_ajaran' => $tahunAjaran,
                'total_siswa' => $totalSiswa,
                'siswa_sudah_bayar' => $siswaSudahBayar,
                'siswa_belum_bayar' => $totalSiswa - $siswaSudahBayar,
                'total_tagihan' => $totalTagihan,
                'detail_tagihan' => $tagihan
            ];
        }
        
        return view('admin.laporan.per-kelas', compact(
            'data',
            'kelas',
            'tahunAjaran',
            'kelasList',
            'tahunAjaranList'
        ));
    }
    
    /**
     * Dashboard statistik
     */
    public function statistik()
    {
        // Monthly revenue (last 6 months)
        $monthlyRevenue = Pembayaran::where('status', 'paid')
            ->select(
                DB::raw('YEAR(tanggal_bayar) as tahun'),
                DB::raw('MONTH(tanggal_bayar) as bulan'),
                DB::raw('SUM(jumlah_bayar) as total')
            )
            ->where('tanggal_bayar', '>=', Carbon::now()->subMonths(6))
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'period' => Carbon::create($item->tahun, $item->bulan)->format('M Y'),
                    'total' => (float) $item->total
                ];
            })
            ->reverse()
            ->values();
        
        // Tagihan status distribution
        $tagihanStatus = Tagihan::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->status => $item->count];
            });
        
        // Pembayaran by kategori
        $pembayaranByKategori = Pembayaran::where('status', 'paid')
            ->with('kategori')
            ->select('kategori_pembayaran_id', DB::raw('SUM(jumlah_bayar) as total'))
            ->groupBy('kategori_pembayaran_id')
            ->get()
            ->map(function ($item) {
                return [
                    'kategori' => $item->kategori->nama_kategori,
                    'total' => (float) $item->total
                ];
            });
        
        // Siswa by kelas
        $siswaByKelas = Siswa::where('status_siswa', 'aktif')
            ->select('kelas', DB::raw('COUNT(*) as count'))
            ->groupBy('kelas')
            ->get()
            ->map(function ($item) {
                return [
                    'kelas' => $item->kelas ?? 'Belum Ada',
                    'count' => $item->count
                ];
            });
        
        return view('admin.laporan.statistik', compact(
            'monthlyRevenue',
            'tagihanStatus',
            'pembayaranByKategori',
            'siswaByKelas'
        ));
    }
    
    /**
     * Helper: Get statistics
     */
    private function getStatistik($startDate, $endDate, $kelas = null, $kategoriId = null)
    {
        // Total pembayaran
        $totalPembayaran = Pembayaran::whereBetween('tanggal_bayar', [$startDate, $endDate])
            ->where('status', 'paid')
            ->when($kelas, function ($q) use ($kelas) {
                return $q->whereHas('user.siswa', function ($q) use ($kelas) {
                    $q->where('kelas', $kelas);
                });
            })
            ->when($kategoriId, function ($q) use ($kategoriId) {
                return $q->where('kategori_pembayaran_id', $kategoriId);
            })
            ->sum('jumlah_bayar');
        
        // Total tagihan
        $totalTagihan = Tagihan::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'unpaid')
            ->when($kelas, function ($q) use ($kelas) {
                return $q->whereHas('user.siswa', function ($q) use ($kelas) {
                    $q->where('kelas', $kelas);
                });
            })
            ->when($kategoriId, function ($q) use ($kategoriId) {
                return $q->where('kategori_pembayaran_id', $kategoriId);
            })
            ->sum('jumlah_tagihan');
        
        // Count transactions
        $countPembayaran = Pembayaran::whereBetween('tanggal_bayar', [$startDate, $endDate])
            ->when($kelas, function ($q) use ($kelas) {
                return $q->whereHas('user.siswa', function ($q) use ($kelas) {
                    $q->where('kelas', $kelas);
                });
            })
            ->when($kategoriId, function ($q) use ($kategoriId) {
                return $q->where('kategori_pembayaran_id', $kategoriId);
            })
            ->count();
        
        $countTagihan = Tagihan::whereBetween('created_at', [$startDate, $endDate])
            ->when($kelas, function ($q) use ($kelas) {
                return $q->whereHas('user.siswa', function ($q) use ($kelas) {
                    $q->where('kelas', $kelas);
                });
            })
            ->when($kategoriId, function ($q) use ($kategoriId) {
                return $q->where('kategori_pembayaran_id', $kategoriId);
            })
            ->count();
        
        // Average payment
        $avgPayment = $countPembayaran > 0 ? $totalPembayaran / $countPembayaran : 0;
        
        return [
            'total_pembayaran' => $totalPembayaran,
            'total_tagihan' => $totalTagihan,
            'count_pembayaran' => $countPembayaran,
            'count_tagihan' => $countTagihan,
            'avg_payment' => $avgPayment,
        ];
    }
    
    /**
     * Export to Excel (placeholder)
     */
    private function exportToExcel($pembayaran, $tagihan, $statistik, $startDate, $endDate)
    {
        return back()->with('info', 'Fitur export Excel akan segera tersedia. Silakan install package Laravel Excel.');
    }
    
    /**
     * Export to PDF (placeholder)
     */
    private function exportToPDF($pembayaran, $tagihan, $statistik, $startDate, $endDate)
    {
        return back()->with('info', 'Fitur export PDF akan segera tersedia. Silakan install package Laravel DomPDF.');
    }
}