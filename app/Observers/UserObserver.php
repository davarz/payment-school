<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class UserObserver
{
    public function creating(User $user): void
    {
        // Set default role jika belum ada
        if (empty($user->role)) {
            $user->role = 'siswa';
        }
        
        // Hash password jika diisi plain text
        if ($user->isDirty('password') && !Hash::needsRehash($user->password)) {
            $user->password = Hash::make($user->password);
        }
        
        Log::info('User creating', [
            'email' => $user->email,
            'role' => $user->role,
        ]);
    }

    public function created(User $user): void
    {
        // Buat data siswa otomatis jika role adalah siswa
        if ($user->role === 'siswa') {
            $this->createSiswaData($user);
        }
        
        Log::info('User created', [
            'user_id' => $user->id,
            'email' => $user->email,
        ]);
    }

    public function updating(User $user): void
    {
        // Hash password jika diubah
        if ($user->isDirty('password') && !Hash::needsRehash($user->password)) {
            $user->password = Hash::make($user->password);
            Log::info('User password changed', ['user_id' => $user->id]);
        }
        
        // Log perubahan role
        if ($user->isDirty('role')) {
            $oldRole = $user->getOriginal('role');
            $newRole = $user->role;
            
            Log::warning('User role changed', [
                'user_id' => $user->id,
                'old_role' => $oldRole,
                'new_role' => $newRole,
                'changed_by' => auth()->check() ? auth()->id() : null,
            ]);
        }
        
        // Log perubahan email
        if ($user->isDirty('email')) {
            Log::info('User email changed', [
                'user_id' => $user->id,
                'old_email' => $user->getOriginal('email'),
                'new_email' => $user->email,
            ]);
        }
    }

    public function deleting(User $user): void
    {
        // Hapus data terkait sebelum menghapus user
        $this->deleteRelatedData($user);
        
        Log::warning('User deleting', [
            'user_id' => $user->id,
            'deleted_by' => auth()->check() ? auth()->id() : null,
        ]);
    }

    public function deleted(User $user): void
    {
        Log::warning('User deleted', [
            'user_id' => $user->id,
            'email' => $user->email,
        ]);
    }

    public function restored(User $user): void
    {
        Log::info('User restored', [
            'user_id' => $user->id,
        ]);
    }

    public function forceDeleted(User $user): void
    {
        Log::critical('User force deleted', [
            'user_id' => $user->id,
        ]);
    }

    /**
     * Create siswa data when user with role siswa is created
     */
    private function createSiswaData(User $user): void
    {
        try {
            \App\Models\Siswa::create([
                'user_id' => $user->id,
                'status_siswa' => 'aktif',
                'tahun_ajaran' => date('Y') . '/' . (date('Y') + 1),
                // Field lainnya bisa diisi default atau kosong
            ]);
            
            Log::info('Siswa data created for user', ['user_id' => $user->id]);
        } catch (\Exception $e) {
            Log::error('Failed to create siswa data', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Delete related data when user is deleted
     */
    private function deleteRelatedData(User $user): void
    {
        try {
            // Hapus data siswa jika ada
            if ($user->siswa) {
                $user->siswa->delete();
            }
            
            // Hapus tagihan
            $user->tagihan()->delete();
            
            // Hapus pembayaran
            $user->pembayaran()->delete();
            
            // Hapus password reset tokens
            DB::table('password_reset_tokens')->where('email', $user->email)->delete();
            
            // Hapus sessions
            DB::table('sessions')->where('user_id', $user->id)->delete();
            
        } catch (\Exception $e) {
            Log::error('Failed to delete user related data', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);
        }
    }
}