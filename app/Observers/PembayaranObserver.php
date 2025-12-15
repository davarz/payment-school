<?php

namespace App\Observers;

use App\Models\Pembayaran;
use App\Models\Tagihan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class PembayaranObserver
{
    public function creating(Pembayaran $pembayaran): void
    {
        // Generate kode transaksi jika belum ada
        if (empty($pembayaran->kode_transaksi)) {
            $pembayaran->kode_transaksi = $this->generateKodeTransaksi();
        }
        
        // Jika pembayaran dibuat oleh admin/operator, langsung verified
        if (auth()->check() && in_array(auth()->user()->role, ['admin', 'operator']) && $pembayaran->status === 'paid') {
            $pembayaran->verified_by = auth()->id();
            $pembayaran->verified_at = now();
        }
        
        Log::info('Pembayaran creating', [
            'kode_transaksi' => $pembayaran->kode_transaksi,
            'user_id' => $pembayaran->user_id,
            'jumlah' => $pembayaran->jumlah_bayar,
        ]);
    }

    public function created(Pembayaran $pembayaran): void
    {
        // Update status tagihan terkait jika ada
        if ($pembayaran->status === 'paid') {
            $this->updateRelatedTagihan($pembayaran);
        }
        
        // Clear cache untuk statistik pembayaran
        Cache::forget('dashboard_stats');
        Cache::forget('user_pembayaran_' . $pembayaran->user_id);
        
        Log::info('Pembayaran created', [
            'kode_transaksi' => $pembayaran->kode_transaksi,
            'status' => $pembayaran->status,
        ]);
    }

    public function updating(Pembayaran $pembayaran): void
    {
        // Jika status berubah menjadi paid
        if ($pembayaran->isDirty('status') && $pembayaran->status === 'paid') {
            $pembayaran->verified_by = auth()->check() ? auth()->id() : null;
            $pembayaran->verified_at = now();
            
            Log::info('Pembayaran verified', [
                'kode_transaksi' => $pembayaran->kode_transaksi,
                'verified_by' => $pembayaran->verified_by,
            ]);
        }
        
        // Jika status berubah menjadi canceled
        if ($pembayaran->isDirty('status') && $pembayaran->status === 'canceled') {
            Log::warning('Pembayaran canceled', [
                'kode_transaksi' => $pembayaran->kode_transaksi,
                'canceled_by' => auth()->check() ? auth()->id() : null,
            ]);
        }
    }

    public function updated(Pembayaran $pembayaran): void
    {
        // Update status tagihan terkait jika status pembayaran berubah
        if ($pembayaran->isDirty('status') && $pembayaran->status === 'paid') {
            $this->updateRelatedTagihan($pembayaran);
        }
        
        // Clear cache
        Cache::forget('dashboard_stats');
        Cache::forget('user_pembayaran_' . $pembayaran->user_id);
    }

    public function deleting(Pembayaran $pembayaran): void
    {
        // Hapus file bukti bayar jika ada
        if ($pembayaran->bukti_bayar && Storage::disk('public')->exists($pembayaran->bukti_bayar)) {
            Storage::disk('public')->delete($pembayaran->bukti_bayar);
        }
        
        Log::warning('Pembayaran deleting', [
            'kode_transaksi' => $pembayaran->kode_transaksi,
            'deleted_by' => auth()->check() ? auth()->id() : null,
        ]);
    }

    public function deleted(Pembayaran $pembayaran): void
    {
        // Clear cache
        Cache::forget('dashboard_stats');
        
        Log::warning('Pembayaran deleted', [
            'kode_transaksi' => $pembayaran->kode_transaksi,
        ]);
    }

    /**
     * Generate unique kode transaksi
     */
    private function generateKodeTransaksi(): string
    {
        $prefix = 'TRX';
        $date = date('Ymd');
        $random = strtoupper(substr(uniqid(), -6));
        
        return $prefix . '-' . $date . '-' . $random;
    }

    /**
     * Update related tagihan status
     */
    private function updateRelatedTagihan(Pembayaran $pembayaran): void
    {
        // Cari tagihan yang belum dibayar untuk user dan kategori yang sama
        $tagihan = Tagihan::where('user_id', $pembayaran->user_id)
            ->where('kategori_pembayaran_id', $pembayaran->kategori_pembayaran_id)
            ->where('status', 'unpaid')
            ->orderBy('tanggal_jatuh_tempo', 'asc')
            ->first();
            
        if ($tagihan) {
            $tagihan->update(['status' => 'paid']);
            
            Log::info('Related tagihan updated', [
                'tagihan_id' => $tagihan->id,
                'pembayaran_kode' => $pembayaran->kode_transaksi,
            ]);
        }
    }
}