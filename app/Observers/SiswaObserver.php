<?php

namespace App\Observers;

use App\Models\Siswa;
use App\Models\Tagihan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SiswaObserver
{
    /**
     * Handle the Siswa "creating" event.
     */
    public function creating(Siswa $siswa): void
    {
        // Generate NISN otomatis jika belum ada
        if (empty($siswa->nisn)) {
            $siswa->nisn = $this->generateNISN();
        }
        
        // Set default tahun ajaran jika belum ada
        if (empty($siswa->tahun_ajaran)) {
            $currentYear = date('Y');
            $siswa->tahun_ajaran = $currentYear . '/' . ($currentYear + 1);
        }
        
        // Set default status siswa jika belum ada
        if (empty($siswa->status_siswa)) {
            $siswa->status_siswa = 'aktif';
        }
        
        // Set default kelas jika belum ada
        if (empty($siswa->kelas)) {
            $siswa->kelas = 'X'; // Kelas default
        }
        
        Log::info('Siswa creating', [
            'user_id' => $siswa->user_id,
            'nis' => $siswa->nis,
            'nama' => $siswa->user->name ?? 'Unknown',
        ]);
    }

    /**
     * Handle the Siswa "created" event.
     */
    public function created(Siswa $siswa): void
    {
        // Clear cache yang terkait dengan siswa
        Cache::forget('dashboard_stats');
        Cache::forget('kelas_list');
        Cache::forget('tahun_ajaran_list');
        Cache::forget('siswa_count_active');
        
        // Generate tagihan otomatis untuk siswa baru jika ada kategori aktif
        if ($siswa->status_siswa === 'aktif') {
            $this->generateInitialTagihan($siswa);
        }
        
        Log::info('Siswa created', [
            'siswa_id' => $siswa->id,
            'nis' => $siswa->nis,
            'status' => $siswa->status_siswa,
        ]);
    }

    /**
     * Handle the Siswa "updating" event.
     */
    public function updating(Siswa $siswa): void
    {
        // Log perubahan status siswa
        if ($siswa->isDirty('status_siswa')) {
            $oldStatus = $siswa->getOriginal('status_siswa');
            $newStatus = $siswa->status_siswa;
            
            Log::info('Siswa status changed', [
                'siswa_id' => $siswa->id,
                'nis' => $siswa->nis,
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'changed_by' => auth()->check() ? auth()->id() : null,
            ]);
            
            // Jika status berubah menjadi tidak aktif, hapus tagihan yang belum dibayar
            if ($newStatus !== 'aktif' && $oldStatus === 'aktif') {
                $this->handleInactiveStatus($siswa);
            }
            
            // Jika status berubah menjadi aktif dari tidak aktif, generate tagihan
            if ($newStatus === 'aktif' && $oldStatus !== 'aktif') {
                $this->handleActiveStatus($siswa);
            }
        }
        
        // Log perubahan NIS (nomor penting)
        if ($siswa->isDirty('nis')) {
            Log::warning('Siswa NIS changed', [
                'siswa_id' => $siswa->id,
                'old_nis' => $siswa->getOriginal('nis'),
                'new_nis' => $siswa->nis,
                'changed_by' => auth()->check() ? auth()->id() : null,
            ]);
        }
        
        // Log perubahan kelas
        if ($siswa->isDirty('kelas')) {
            Log::info('Siswa kelas changed', [
                'siswa_id' => $siswa->id,
                'nis' => $siswa->nis,
                'old_kelas' => $siswa->getOriginal('kelas'),
                'new_kelas' => $siswa->kelas,
                'changed_by' => auth()->check() ? auth()->id() : null,
            ]);
        }
        
        // Log perubahan tahun ajaran
        if ($siswa->isDirty('tahun_ajaran')) {
            Log::info('Siswa tahun ajaran changed', [
                'siswa_id' => $siswa->id,
                'nis' => $siswa->nis,
                'old_tahun_ajaran' => $siswa->getOriginal('tahun_ajaran'),
                'new_tahun_ajaran' => $siswa->tahun_ajaran,
                'changed_by' => auth()->check() ? auth()->id() : null,
            ]);
        }
    }

    /**
     * Handle the Siswa "updated" event.
     */
    public function updated(Siswa $siswa): void
    {
        // Clear cache yang terkait dengan siswa
        Cache::forget('dashboard_stats');
        Cache::forget('kelas_list');
        Cache::forget('tahun_ajaran_list');
        Cache::forget('siswa_count_active');
        Cache::forget('user_siswa_' . $siswa->user_id);
        
        // Jika kelas berubah, update deskripsi tagihan yang belum dibayar
        if ($siswa->isDirty('kelas')) {
            $this->updateTagihanKeterangan($siswa);
        }
    }

    /**
     * Handle the Siswa "deleting" event.
     */
    public function deleting(Siswa $siswa): void
    {
        // Cek apakah siswa memiliki tagihan atau pembayaran
        $hasTagihan = $siswa->user->tagihan()->exists();
        $hasPembayaran = $siswa->user->pembayaran()->exists();
        
        if ($hasTagihan || $hasPembayaran) {
            throw new \Exception('Tidak dapat menghapus siswa yang sudah memiliki tagihan atau pembayaran.');
        }
        
        Log::warning('Siswa deleting', [
            'siswa_id' => $siswa->id,
            'nis' => $siswa->nis,
            'deleted_by' => auth()->check() ? auth()->id() : null,
        ]);
    }

    /**
     * Handle the Siswa "deleted" event.
     */
    public function deleted(Siswa $siswa): void
    {
        // Clear cache
        Cache::forget('dashboard_stats');
        Cache::forget('kelas_list');
        Cache::forget('tahun_ajaran_list');
        Cache::forget('siswa_count_active');
        
        Log::warning('Siswa deleted', [
            'siswa_id' => $siswa->id,
            'nis' => $siswa->nis,
        ]);
    }

    /**
     * Handle the Siswa "restored" event.
     */
    public function restored(Siswa $siswa): void
    {
        // Clear cache
        Cache::forget('dashboard_stats');
        Cache::forget('kelas_list');
        Cache::forget('tahun_ajaran_list');
        Cache::forget('siswa_count_active');
        
        Log::info('Siswa restored', [
            'siswa_id' => $siswa->id,
            'nis' => $siswa->nis,
        ]);
    }

    /**
     * Handle the Siswa "force deleted" event.
     */
    public function forceDeleted(Siswa $siswa): void
    {
        // Clear cache
        Cache::forget('dashboard_stats');
        Cache::forget('kelas_list');
        Cache::forget('tahun_ajaran_list');
        Cache::forget('siswa_count_active');
        
        Log::critical('Siswa force deleted', [
            'siswa_id' => $siswa->id,
            'nis' => $siswa->nis,
        ]);
    }

    /**
     * Generate NISN otomatis
     */
    private function generateNISN(): string
    {
        // Format: 10 digit angka
        // Tahun (2 digit) + Random 8 digit
        $tahun = date('y'); // 2 digit tahun
        $random = str_pad(mt_rand(1, 99999999), 8, '0', STR_PAD_LEFT);
        
        return $tahun . $random;
    }

    /**
     * Generate tagihan awal untuk siswa baru
     */
    private function generateInitialTagihan(Siswa $siswa): void
    {
        try {
            $kategoriAktif = \App\Models\KategoriPembayaran::where('status', 'active')
                ->where('auto_generate', true)
                ->get();
            
            foreach ($kategoriAktif as $kategori) {
                // Cek apakah sudah ada tagihan untuk kategori ini
                $existingTagihan = \App\Models\Tagihan::where('user_id', $siswa->user_id)
                    ->where('kategori_pembayaran_id', $kategori->id)
                    ->exists();
                    
                if (!$existingTagihan) {
                    \App\Models\Tagihan::create([
                        'user_id' => $siswa->user_id,
                        'kategori_pembayaran_id' => $kategori->id,
                        'jumlah_tagihan' => $kategori->jumlah,
                        'tanggal_jatuh_tempo' => now()->addDays(30), // Jatuh tempo 30 hari
                        'status' => 'unpaid',
                        'keterangan' => 'Tagihan awal untuk siswa baru',
                    ]);
                    
                    Log::info('Initial tagihan created for new siswa', [
                        'siswa_id' => $siswa->id,
                        'kategori_id' => $kategori->id,
                    ]);
                }
            }
        } catch (\Exception $e) {
            Log::error('Failed to generate initial tagihan for siswa', [
                'siswa_id' => $siswa->id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Handle ketika status siswa berubah menjadi tidak aktif
     */
    private function handleInactiveStatus(Siswa $siswa): void
    {
        try {
            // Batalkan tagihan yang belum dibayar
            $canceledCount = \App\Models\Tagihan::where('user_id', $siswa->user_id)
                ->where('status', 'unpaid')
                ->update(['status' => 'canceled']);
                
            if ($canceledCount > 0) {
                Log::info('Tagihan canceled due to inactive status', [
                    'siswa_id' => $siswa->id,
                    'count' => $canceledCount,
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to handle inactive status', [
                'siswa_id' => $siswa->id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Handle ketika status siswa berubah menjadi aktif
     */
    private function handleActiveStatus(Siswa $siswa): void
    {
        try {
            // Generate tagihan untuk siswa yang kembali aktif
            $this->generateInitialTagihan($siswa);
            
            Log::info('Siswa reactivated, tagihan generated', [
                'siswa_id' => $siswa->id,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to handle active status', [
                'siswa_id' => $siswa->id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Update keterangan tagihan ketika kelas berubah
     */
    private function updateTagihanKeterangan(Siswa $siswa): void
    {
        try {
            $tagihan = Tagihan::where('user_id', $siswa->user_id)
                ->where('status', 'unpaid')
                ->get();
                
            foreach ($tagihan as $t) {
                $keterangan = $t->keterangan ?? '';
                
                // Update keterangan jika mengandung informasi kelas lama
                if (str_contains($keterangan, 'Kelas')) {
                    $oldKelas = $siswa->getOriginal('kelas');
                    $newKeterangan = str_replace(
                        "Kelas {$oldKelas}", 
                        "Kelas {$siswa->kelas}", 
                        $keterangan
                    );
                    
                    $t->update(['keterangan' => $newKeterangan]);
                }
            }
        } catch (\Exception $e) {
            Log::error('Failed to update tagihan keterangan', [
                'siswa_id' => $siswa->id,
                'error' => $e->getMessage(),
            ]);
        }
    }
}