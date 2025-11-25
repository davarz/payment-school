<?php

use App\Http\Controllers\Admin\BulkOperationController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\ImportExportController;
use App\Http\Controllers\Admin\KategoriPembayaranController;
use App\Http\Controllers\Admin\PembayaranController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\TagihanController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboard;
use App\Http\Controllers\Siswa\ProfileController as SiswaProfile;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

// ============================================================================
// DEFAULT ROUTES
// ============================================================================

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    $user = Auth::user();
    return $user->role === 'admin' || $user->role === 'operator'
        ? redirect()->route('admin.dashboard')
        : redirect()->route('siswa.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ============================================================================
// AUTH PROFILE ROUTES
// ============================================================================

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ============================================================================
// ADMIN ROUTES
// ============================================================================

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    
    // Siswa Management
    Route::prefix('siswa')->name('siswa.')->group(function () {
        Route::get('/{siswa}/json', [SiswaController::class, 'getJson'])->name('json');
        Route::post('/{siswa}/reset-password', [SiswaController::class, 'resetPassword'])->name('reset-password');
    });
    Route::resource('siswa', SiswaController::class);

    // Kategori Pembayaran
    Route::resource('kategori', KategoriPembayaranController::class);

    // Pembayaran Management
    Route::prefix('pembayaran')->name('pembayaran.')->group(function () {
        Route::post('/{pembayaran}/verify', [PembayaranController::class, 'verify'])->name('verify');
        Route::post('/{pembayaran}/reject', [PembayaranController::class, 'reject'])->name('reject');
    });
    Route::resource('pembayaran', PembayaranController::class);

    // Tagihan Management (NEW)
    Route::prefix('tagihan')->name('tagihan.')->group(function () {
        Route::post('/generate-bills', [TagihanController::class, 'generateBills'])->name('generate-bills');
        Route::put('/{tagihan}/mark-paid', [TagihanController::class, 'markAsPaid'])->name('mark-paid');
    });
    Route::resource('tagihan', TagihanController::class);

    // Bulk Operations
    Route::prefix('bulk')->name('bulk.')->group(function () {
        Route::get('naik-kelas', [BulkOperationController::class, 'naikKelas'])->name('naik-kelas');
        Route::post('naik-kelas', [BulkOperationController::class, 'updateNaikKelas'])->name('update-naik-kelas');
        Route::post('update-semester', [BulkOperationController::class, 'updateSemester'])->name('update-semester');
    });

    // Import Export
    Route::prefix('import-export')->name('import-export.')->group(function () {
        Route::get('export', [ImportExportController::class, 'exportData'])->name('export');
        Route::get('download-backup', [ImportExportController::class, 'downloadBackup'])->name('download-backup');
        Route::get('import', [ImportExportController::class, 'importData'])->name('import');
        Route::post('import', [ImportExportController::class, 'processImport'])->name('process-import');
    });
});

// ============================================================================
// PASSWORD RESET ROUTES (PRODUCTION-READY)
// ============================================================================

// Route::middleware('guest')->group(function () {
//     // Forgot Password
//     Route::get('forgot-password', [PasswordResetController::class, 'showForgotForm'])
//         ->name('password.request');
    
//     Route::post('forgot-password', [PasswordResetController::class, 'sendResetLink'])
//         ->name('password.email');

//     // Reset Password
//     Route::get('reset-password/{token}', [PasswordResetController::class, 'showResetForm'])
//         ->name('password.reset');
    
//     Route::post('reset-password', [PasswordResetController::class, 'resetPassword'])
//         ->name('password.update');
// });

// ============================================================================
// SISWA ROUTES
// ============================================================================

Route::middleware(['auth'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', [SiswaDashboard::class, 'index'])->name('dashboard');
    Route::get('/tagihan', [SiswaDashboard::class, 'tagihan'])->name('tagihan');
    Route::post('/tagihan', [SiswaDashboard::class, 'createTagihan'])->name('create-tagihan');
    Route::get('/transaksi', [SiswaDashboard::class, 'transaksi'])->name('transaksi');
    
    // Profile Routes
    Route::get('/profile', [SiswaProfile::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [SiswaProfile::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [SiswaProfile::class, 'update'])->name('profile.update');
    Route::put('/profile/update-password', [SiswaProfile::class, 'updatePassword'])->name('profile.update-password');
});

// ============================================================================
// DEBUG ROUTES (REMOVE IN PRODUCTION)
// ============================================================================

if (app()->environment('local')) {
    
    // Test login dengan password tertentu
    Route::get('/debug-test-login/{email}', function ($email) {
        $user = \App\Models\User::where('email', $email)->first();
        
        if (!$user) {
            return "User tidak ditemukan";
        }

        return response()->json([
            'email' => $user->email,
            'current_password_hash' => $user->password,
            'hash_preview' => substr($user->password, 0, 30) . '...',
            'hash_length' => strlen($user->password),
            'hash_algorithm' => 'bcrypt (should start with $2y$)',
            'last_updated' => $user->updated_at,
        ]);
    });

    // Test password match
    Route::post('/debug-check-password', function (Illuminate\Http\Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['error' => 'User tidak ditemukan'], 404);
        }

        $matches = Hash::check($request->password, $user->password);

        Log::info('Password check debug', [
            'email' => $request->email,
            'password_length' => strlen($request->password),
            'hash_preview' => substr($user->password, 0, 30) . '...',
            'matches' => $matches
        ]);

        return response()->json([
            'email' => $user->email,
            'password_matches' => $matches,
            'password_length' => strlen($request->password),
            'hash_preview' => substr($user->password, 0, 30) . '...',
            'message' => $matches ? '✅ Password COCOK' : '❌ Password TIDAK COCOK'
        ]);
    });

    // Manual reset password (bypass reset flow)
    Route::get('/debug-force-reset/{email}/{password}', function ($email, $password) {
        $user = \App\Models\User::where('email', $email)->first();

        if (!$user) {
            return "User tidak ditemukan";
        }

        $oldHash = $user->password;
        $newHash = Hash::make($password);

        $user->password = $newHash;
        $user->save();
        $user->refresh();

        $canLogin = Hash::check($password, $user->password);

        Log::info('Force password reset', [
            'email' => $email,
            'new_password' => $password,
            'old_hash' => substr($oldHash, 0, 20) . '...',
            'new_hash' => substr($newHash, 0, 20) . '...',
            'saved_hash' => substr($user->password, 0, 20) . '...',
            'can_login' => $canLogin
        ]);

        return response()->json([
            'status' => 'Password force reset',
            'email' => $email,
            'new_password' => $password,
            'old_hash_preview' => substr($oldHash, 0, 30) . '...',
            'new_hash_preview' => substr($user->password, 0, 30) . '...',
            'hash_changed' => $oldHash !== $user->password,
            'verification_test' => $canLogin ? '✅ PASS' : '❌ FAIL',
            'message' => $canLogin 
                ? "Password berhasil diubah ke: {$password}" 
                : "PASSWORD UPDATE GAGAL! Hash tersimpan tapi tidak bisa diverifikasi"
        ]);
    });

    // Cek semua tokens aktif
    Route::get('/debug-reset-tokens', function () {
        $tokens = DB::table('password_reset_tokens')->get();
        
        return response()->json([
            'total_tokens' => $tokens->count(),
            'tokens' => $tokens->map(function ($token) {
                return [
                    'email' => $token->email,
                    'token_preview' => substr($token->token, 0, 20) . '...',
                    'created_at' => $token->created_at,
                    'age_minutes' => now()->diffInMinutes($token->created_at),
                    'expired' => now()->diffInMinutes($token->created_at) > 60
                ];
            })
        ]);
    });

    // Clear semua tokens
    Route::get('/debug-clear-tokens', function () {
        $count = DB::table('password_reset_tokens')->count();
        DB::table('password_reset_tokens')->truncate();
        
        return "Cleared {$count} tokens";
    });
}

require __DIR__ . '/auth.php';