<?php

namespace App\Observers;

use App\Models\Pembayaran;
use App\Models\Tagihan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class TagihanObserver
{
    public function creating(Tagihan $tagihan): void
    {
        // Set default status jika belum ada
        if (empty($tagihan->status)) {
            $tagihan->status = 'unpaid';
        }
        
        // Validasi tanggal jatuh tempo
        if ($tagihan->tanggal_jatuh_tempo < now()->startOfDay()) {
            Log::warning('Tagihan dengan tanggal jatuh tempo yang sudah lewat dibuat', [
                'user_id' => $tagihan->user_id,
                'tanggal_jatuh_tempo' => $tagihan->tanggal_jatuh_tempo,
            ]);
        }
        
        Log::info('Tagihan creating', [
            'user_id' => $tagihan->user_id,
            'kategori_id' => $tagihan->kategori_pembayaran_id,
            'jumlah' => $tagihan->jumlah_tagihan,
        ]);
    }

    public function created(Tagihan $tagihan): void
    {
        // Kirim notifikasi ke user jika tagihan dibuat secara manual
        if (!request()->isMethod('post') || request()->has('auto_generate')) {
            // Notifikasi bisa dikirim di sini (email, notification, dll)
            // $tagihan->user->notify(new \App\Notifications\TagihanCreated($tagihan));
        }
        
        // Clear cache
        Cache::forget('dashboard_stats');
        Cache::forget('user_tagihan_' . $tagihan->user_id);
        
        Log::info('Tagihan created', [
            'tagihan_id' => $tagihan->id,
            'status' => $tagihan->status,
        ]);
    }

    public function updating(Tagihan $tagihan): void
    {
        // Log perubahan status
        if ($tagihan->isDirty('status')) {
            $oldStatus = $tagihan->getOriginal('status');
            $newStatus = $tagihan->status;
            
            Log::info('Tagihan status changed', [
                'tagihan_id' => $tagihan->id,
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'changed_by' => auth()->check() ? auth()->id() : null,
            ]);
            
            // Jika status berubah menjadi paid
            if ($newStatus === 'paid') {
                $tagihan->paid_at = now();
            }
        }
        
        // Log perubahan jumlah tagihan
        if ($tagihan->isDirty('jumlah_tagihan')) {
            Log::warning('Tagihan amount changed', [
                'tagihan_id' => $tagihan->id,
                'old_amount' => $tagihan->getOriginal('jumlah_tagihan'),
                'new_amount' => $tagihan->jumlah_tagihan,
                'changed_by' => auth()->check() ? auth()->id() : null,
            ]);
        }
    }

    public function updated(Tagihan $tagihan): void
    {
        // Clear cache
        Cache::forget('dashboard_stats');
        Cache::forget('user_tagihan_' . $tagihan->user_id);
        
        // Jika status berubah menjadi paid, cek apakah ada pembayaran terkait
        if ($tagihan->isDirty('status') && $tagihan->status === 'paid') {
            $this->checkRelatedPembayaran($tagihan);
        }
    }

    public function deleting(Tagihan $tagihan): void
    {
        // Cek apakah tagihan sudah ada pembayaran
        if ($tagihan->pembayaran()->exists()) {
            throw new \Exception('Tidak dapat menghapus tagihan yang sudah memiliki pembayaran.');
        }
        
        Log::warning('Tagihan deleting', [
            'tagihan_id' => $tagihan->id,
            'deleted_by' => auth()->check() ? auth()->id() : null,
        ]);
    }

    public function deleted(Tagihan $tagihan): void
    {
        // Clear cache
        Cache::forget('dashboard_stats');
        
        Log::warning('Tagihan deleted', [
            'tagihan_id' => $tagihan->id,
        ]);
    }

    /**
     * Cek pembayaran terkait saat tagihan diubah menjadi paid
     */
    private function checkRelatedPembayaran(Tagihan $tagihan): void
    {
        // Cari pembayaran untuk tagihan ini yang belum verified
        $pembayaran = Pembayaran::where('user_id', $tagihan->user_id)
            ->where('kategori_pembayaran_id', $tagihan->kategori_pembayaran_id)
            ->where('status', 'pending')
            ->first();
            
        if ($pembayaran) {
            $pembayaran->update([
                'status' => 'paid',
                'verified_by' => auth()->check() ? auth()->id() : null,
                'verified_at' => now(),
            ]);
        }
    }
}