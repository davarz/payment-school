<?php

namespace App\Observers;

use App\Models\KategoriPembayaran;
use App\Models\Tagihan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class KategoriPembayaranObserver
{
    public function creating(KategoriPembayaran $kategori): void
    {
        // Set default status jika belum ada
        if (empty($kategori->status)) {
            $kategori->status = 'active';
        }
        
        // Set default frekuensi jika belum ada
        if (empty($kategori->frekuensi)) {
            $kategori->frekuensi = 'bulanan';
        }
        
        // Set default auto_generate jika belum ada
        if (is_null($kategori->auto_generate)) {
            $kategori->auto_generate = true;
        }
        
        Log::info('KategoriPembayaran creating', [
            'nama_kategori' => $kategori->nama_kategori,
            'jumlah' => $kategori->jumlah,
        ]);
    }

    public function created(KategoriPembayaran $kategori): void
    {
        // Clear cache
        Cache::forget('kategori_pembayaran_active');
        Cache::forget('kategori_pembayaran_all');
        
        Log::info('KategoriPembayaran created', [
            'kategori_id' => $kategori->id,
        ]);
    }

    public function updating(KategoriPembayaran $kategori): void
    {
        // Log perubahan jumlah
        if ($kategori->isDirty('jumlah')) {
            Log::warning('KategoriPembayaran amount changed', [
                'kategori_id' => $kategori->id,
                'old_amount' => $kategori->getOriginal('jumlah'),
                'new_amount' => $kategori->jumlah,
                'changed_by' => auth()->check() ? auth()->id() : null,
            ]);
        }
        
        // Log perubahan status
        if ($kategori->isDirty('status')) {
            $oldStatus = $kategori->getOriginal('status');
            $newStatus = $kategori->status;
            
            Log::info('KategoriPembayaran status changed', [
                'kategori_id' => $kategori->id,
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'changed_by' => auth()->check() ? auth()->id() : null,
            ]);
            
            // Jika status berubah menjadi inactive, nonaktifkan auto_generate
            if ($newStatus === 'inactive') {
                $kategori->auto_generate = false;
            }
        }
    }

    public function updated(KategoriPembayaran $kategori): void
    {
        // Clear cache
        Cache::forget('kategori_pembayaran_active');
        Cache::forget('kategori_pembayaran_all');
        
        // Jika jumlah berubah, update tagihan yang belum dibayar
        if ($kategori->isDirty('jumlah')) {
            $this->updateUnpaidTagihan($kategori);
        }
    }

    public function deleting(KategoriPembayaran $kategori): void
    {
        // Cek apakah kategori sudah digunakan di tagihan atau pembayaran
        if ($kategori->tagihan()->exists() || $kategori->pembayaran()->exists()) {
            throw new \Exception('Tidak dapat menghapus kategori yang sudah digunakan dalam tagihan atau pembayaran.');
        }
        
        Log::warning('KategoriPembayaran deleting', [
            'kategori_id' => $kategori->id,
            'deleted_by' => auth()->check() ? auth()->id() : null,
        ]);
    }

    public function deleted(KategoriPembayaran $kategori): void
    {
        // Clear cache
        Cache::forget('kategori_pembayaran_active');
        Cache::forget('kategori_pembayaran_all');
        
        Log::warning('KategoriPembayaran deleted', [
            'kategori_id' => $kategori->id,
        ]);
    }

    /**
     * Update unpaid tagihan when kategori amount changes
     */
    private function updateUnpaidTagihan(KategoriPembayaran $kategori): void
    {
        try {
            $updatedCount = Tagihan::where('kategori_pembayaran_id', $kategori->id)
                ->where('status', 'unpaid')
                ->update(['jumlah_tagihan' => $kategori->jumlah]);
                
            if ($updatedCount > 0) {
                Log::info('Unpaid tagihan updated', [
                    'kategori_id' => $kategori->id,
                    'count' => $updatedCount,
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to update unpaid tagihan', [
                'kategori_id' => $kategori->id,
                'error' => $e->getMessage(),
            ]);
        }
    }
}