<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Tagihan;
use App\Models\KategoriPembayaran;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GenerateMonthlyBills extends Command
{
    protected $signature = 'bills:generate-monthly';
    protected $description = 'Generate monthly bills for all active students';

    public function handle()
    {
        $this->info('🔄 Memulai generate tagihan bulanan...');
        $this->info('📅 Tanggal: ' . now()->format('Y-m-d H:i:s'));

        $siswaAktif = User::where('role', 'siswa')
            ->where('status_siswa', 'aktif')
            ->get();

        $kategoriAktif = KategoriPembayaran::where('status', 'active')
            ->where('auto_generate', true)
            ->get();

        $this->info("👥 Siswa aktif: {$siswaAktif->count()} siswa");
        $this->info("📋 Kategori aktif: {$kategoriAktif->count()} kategori");

        $totalGenerated = 0;

        foreach ($siswaAktif as $siswa) {
            foreach ($kategoriAktif as $kategori) {
                
                $shouldGenerate = $this->shouldGenerateThisMonth($kategori);
                
                if ($shouldGenerate) {
                    $created = $this->createTagihan($siswa, $kategori);
                    if ($created) $totalGenerated++;
                }
            }
        }

        $this->info("✅ Tagihan berhasil digenerate: {$totalGenerated} tagihan");
        Log::info('Auto bill generation completed', [
            'total_generated' => $totalGenerated,
            'date' => now()->toDateTimeString()
        ]);
    }

    protected function shouldGenerateThisMonth($kategori)
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;
        
        $this->info("🔍 Cek kategori: {$kategori->nama_kategori} - Frekuensi: {$kategori->frekuensi}");
        
        return match($kategori->frekuensi) {
            'bulanan' => $this->shouldGenerateBulanan($kategori),
            'semester' => $this->shouldGenerateSemester($kategori),
            'tahunan' => $this->shouldGenerateTahunan($kategori),
            default => false,
        };
    }

    protected function shouldGenerateBulanan($kategori)
    {
        // Untuk bulanan, selalu generate kecuali sudah ada di bulan ini
        return true;
    }

    protected function shouldGenerateSemester($kategori)
    {
        $currentMonth = now()->month;
        
        // Semester ganjil: Juli-Desember (generate di bulan 7)
        // Semester genap: Januari-Juni (generate di bulan 1)
        $shouldGenerate = in_array($currentMonth, [1, 7]);
        
        if ($shouldGenerate) {
            $this->info("🎯 Semester: Generate di bulan {$currentMonth}");
        }
        
        return $shouldGenerate;
    }

    protected function shouldGenerateTahunan($kategori)
    {
        $currentMonth = now()->month;
        
        // Tahunan: Generate di bulan 7 (Juli)
        $shouldGenerate = $currentMonth == 7;
        
        if ($shouldGenerate) {
            $this->info("🎯 Tahunan: Generate di bulan {$currentMonth}");
        }
        
        return $shouldGenerate;
    }

    protected function createTagihan($siswa, $kategori)
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;

        // Cek apakah sudah ada tagihan di bulan/tahun ini untuk kategori yang sama
        $existing = Tagihan::where('user_id', $siswa->id)
            ->where('kategori_pembayaran_id', $kategori->id)
            ->whereYear('created_at', $currentYear);
            
        // Untuk bulanan, cek per bulan
        if ($kategori->frekuensi === 'bulanan') {
            $existing->whereMonth('created_at', $currentMonth);
        } 
        // Untuk semester, cek per semester
        else if ($kategori->frekuensi === 'semester') {
            $semester = $currentMonth <= 6 ? 'genap' : 'ganjil';
            $existing->whereHas('kategori', function($q) use ($semester) {
                $q->where('semester', $semester);
            });
        }
        // Untuk tahunan, cek per tahun
        else if ($kategori->frekuensi === 'tahunan') {
            // Tidak perlu filter bulan, cukup tahun
        }

        if ($existing->exists()) {
            $this->warn("⏭️ Skip: {$siswa->name} - {$kategori->nama_kategori} (sudah ada)");
            return false;
        }

        // Generate tagihan baru
        Tagihan::create([
            'user_id' => $siswa->id,
            'kategori_pembayaran_id' => $kategori->id,
            'jumlah_tagihan' => $kategori->jumlah,
            'tanggal_jatuh_tempo' => now()->addDays(15),
            'status' => 'pending',
            'keterangan' => $this->generateKeterangan($kategori)
        ]);

        $this->info("✅ Generated: {$siswa->name} - {$kategori->nama_kategori}");
        return true;
    }

    protected function generateKeterangan($kategori)
    {
        $bulan = now()->translatedFormat('F Y');
        
        return match($kategori->frekuensi) {
            'bulanan' => "Tagihan {$kategori->nama_kategori} {$bulan}",
            'semester' => "Tagihan {$kategori->nama_kategori} Semester " . (now()->month <= 6 ? 'Genap' : 'Ganjil') . " TA {$kategori->tahun_ajaran}",
            'tahunan' => "Tagihan {$kategori->nama_kategori} Tahun " . now()->year,
        };
    }
}