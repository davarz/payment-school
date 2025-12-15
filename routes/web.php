<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\SiswaController as AdminSiswaController;
use App\Http\Controllers\Admin\KategoriPembayaranController;
use App\Http\Controllers\Admin\PembayaranController as AdminPembayaranController;
use App\Http\Controllers\Admin\TagihanController as AdminTagihanController;
use App\Http\Controllers\Admin\BulkOperationController;
use App\Http\Controllers\Admin\ImportExportController;
use App\Http\Controllers\Admin\SecurityController;
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;
use App\Http\Controllers\Siswa\ProfileController as SiswaProfileController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\LaporanController;
use App\Models\Tagihan;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// ==================== PUBLIC ROUTES ====================
Route::get('/', [HomeController::class, 'index'])->name('home');

// ==================== AUTH ROUTES ====================
require __DIR__ . '/auth.php';

// ==================== AUTHENTICATED USER ROUTES ====================
Route::middleware(['auth'])->group(function () {
    // Dashboard redirect berdasarkan role
    Route::get('/dashboard', function () {
        $user = Auth::user();

        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'operator':
                return redirect()->route('operator.dashboard');
            case 'siswa':
                return redirect()->route('siswa.dashboard');
            default:
                return redirect()->route('home');
        }
    })->name('dashboard');

    // Profile routes (Laravel Breeze default)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ==================== ADMIN ROUTES ====================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Siswa Management
    Route::prefix('siswa')->name('siswa.')->group(function () {
        Route::get('/', [AdminSiswaController::class, 'index'])->name('index');
        Route::get('/create', [AdminSiswaController::class, 'create'])->name('create');
        Route::post('/', [AdminSiswaController::class, 'store'])->name('store');
        Route::get('/{siswa}', [AdminSiswaController::class, 'show'])->name('show');
        Route::get('/{siswa}/edit', [AdminSiswaController::class, 'edit'])->name('edit');
        Route::put('/{siswa}', [AdminSiswaController::class, 'update'])->name('update');
        Route::delete('/{siswa}', [AdminSiswaController::class, 'destroy'])->name('destroy');
        Route::post('/{siswa}/reset-password', [AdminSiswaController::class, 'resetPassword'])->name('reset-password');
        Route::get('/{siswa}/json', [AdminSiswaController::class, 'getJson'])->name('json');
    });

    // Kategori Pembayaran
    Route::prefix('kategori')->name('kategori.')->group(function () {
        Route::get('/', [KategoriPembayaranController::class, 'index'])->name('index');
        Route::get('/create', [KategoriPembayaranController::class, 'create'])->name('create');
        Route::post('/', [KategoriPembayaranController::class, 'store'])->name('store');
        Route::get('/{kategori}/edit', [KategoriPembayaranController::class, 'edit'])->name('edit');
        Route::put('/{kategori}', [KategoriPembayaranController::class, 'update'])->name('update');
        Route::delete('/{kategori}', [KategoriPembayaranController::class, 'destroy'])->name('destroy');
    });

    // laporan Management
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\LaporanController::class, 'index'])->name('index');
        Route::get('/export', [\App\Http\Controllers\Admin\LaporanController::class, 'export'])->name('export');
        Route::get('/per-siswa', [\App\Http\Controllers\Admin\LaporanController::class, 'perSiswa'])->name('per-siswa');
        Route::get('/per-kelas', [\App\Http\Controllers\Admin\LaporanController::class, 'perKelas'])->name('per-kelas');
        Route::get('/statistik', [\App\Http\Controllers\Admin\LaporanController::class, 'statistik'])->name('statistik');
    });

    // Tagihan Management
    Route::prefix('tagihan')->name('tagihan.')->group(function () {
        Route::get('/', [AdminTagihanController::class, 'index'])->name('index');
        Route::get('/create', [AdminTagihanController::class, 'create'])->name('create');
        Route::post('/', [AdminTagihanController::class, 'store'])->name('store');
        Route::get('/{tagihan}', [AdminTagihanController::class, 'show'])->name('show');
        Route::get('/{tagihan}/edit', [AdminTagihanController::class, 'edit'])->name('edit');
        Route::put('/{tagihan}', [AdminTagihanController::class, 'update'])->name('update');
        Route::delete('/{tagihan}', [AdminTagihanController::class, 'destroy'])->name('destroy');
        Route::post('/generate-bills', [AdminTagihanController::class, 'generateBills'])->name('generate.bills');
        Route::post('/{tagihan}/mark-paid', [AdminTagihanController::class, 'markAsPaid'])->name('mark.paid');
        Route::post('/{tagihan}/cancel', [AdminTagihanController::class, 'cancel'])->name('cancel');
    });

    // Pembayaran Management
    Route::prefix('pembayaran')->name('pembayaran.')->group(function () {
        Route::get('/', [AdminPembayaranController::class, 'index'])->name('index');
        Route::get('/create', [AdminPembayaranController::class, 'create'])->name('create');
        Route::post('/', [AdminPembayaranController::class, 'store'])->name('store');
        Route::get('/{pembayaran}', [AdminPembayaranController::class, 'show'])->name('show');
        Route::delete('/{pembayaran}', [AdminPembayaranController::class, 'destroy'])->name('destroy');
        Route::post('/{pembayaran}/verify', [AdminPembayaranController::class, 'verify'])->name('verify');
        Route::post('/{pembayaran}/cancel', [AdminPembayaranController::class, 'cancel'])->name('cancel');
    });

    // Bulk Operations
    Route::prefix('bulk')->name('bulk.')->group(function () {
        Route::get('/naik-kelas', [BulkOperationController::class, 'naikKelas'])->name('naik-kelas');
        Route::post('/naik-kelas', [BulkOperationController::class, 'updateNaikKelas'])->name('update-naik-kelas');
        Route::post('/update-semester', [BulkOperationController::class, 'updateSemester'])->name('update-semester');
    });

    // Import/Export
    Route::prefix('import-export')->name('import-export.')->group(function () {
        Route::get('/export', [ImportExportController::class, 'exportData'])->name('export');
        Route::get('/download-backup', [ImportExportController::class, 'downloadBackup'])->name('download-backup');
        Route::get('/import', [ImportExportController::class, 'importData'])->name('import');
        Route::post('/import', [ImportExportController::class, 'processImport'])->name('process-import');
    });

    // Security
    Route::prefix('security')->name('security.')->group(function () {
        Route::get('/logs', [SecurityController::class, 'securityLogs'])->name('logs');
        Route::post('/clear-reset-attempts', [SecurityController::class, 'clearResetAttempts'])->name('clear-reset-attempts');
    });

    // Laporan (Shared dengan operator)
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])->name('index');
        Route::get('/export', [LaporanController::class, 'export'])->name('export');
    });
});

// ==================== OPERATOR ROUTES ====================
Route::middleware(['auth', 'role:operator'])->prefix('operator')->name('operator.')->group(function () {
    // Dashboard (gunakan controller yang sama atau buat khusus)
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Siswa Management (view only)
    Route::prefix('siswa')->name('siswa.')->group(function () {
        Route::get('/', [AdminSiswaController::class, 'index'])->name('index');
        Route::get('/{siswa}', [AdminSiswaController::class, 'show'])->name('show');
    });

    // Tagihan Management (limited access)
    Route::prefix('tagihan')->name('tagihan.')->group(function () {
        Route::get('/', [AdminTagihanController::class, 'index'])->name('index');
        Route::get('/create', [AdminTagihanController::class, 'create'])->name('create');
        Route::post('/', [AdminTagihanController::class, 'store'])->name('store');
        Route::get('/{tagihan}', [AdminTagihanController::class, 'show'])->name('show');
        Route::get('/{tagihan}/edit', [AdminTagihanController::class, 'edit'])->name('edit');
        Route::put('/{tagihan}', [AdminTagihanController::class, 'update'])->name('update');
        Route::post('/{tagihan}/mark-paid', [AdminTagihanController::class, 'markAsPaid'])->name('mark.paid');
    });

    // Pembayaran Management (limited access)
    Route::prefix('pembayaran')->name('pembayaran.')->group(function () {
        Route::get('/', [AdminPembayaranController::class, 'index'])->name('index');
        Route::get('/create', [AdminPembayaranController::class, 'create'])->name('create');
        Route::post('/', [AdminPembayaranController::class, 'store'])->name('store');
        Route::get('/{pembayaran}', [AdminPembayaranController::class, 'show'])->name('show');
        Route::post('/{pembayaran}/verify', [AdminPembayaranController::class, 'verify'])->name('verify');
    });

    // Laporan
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])->name('index');
    });
});

// ==================== SISWA ROUTES ====================
Route::middleware(['auth', 'role:siswa', 'siswa.status'])->prefix('siswa')->name('siswa.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('dashboard');

    // Tagihan
    Route::prefix('tagihan')->name('tagihan.')->group(function () {
        Route::get('/', [SiswaDashboardController::class, 'tagihan'])->name('index');
        Route::post('/', [SiswaDashboardController::class, 'createTagihan'])->name('create');
        Route::get('/{tagihan}', [SiswaDashboardController::class, 'showTagihan'])->name('show');
    });

    // Transaksi
    Route::prefix('transaksi')->name('transaksi.')->group(function () {
        Route::get('/', [SiswaDashboardController::class, 'transaksi'])->name('index');
        Route::get('/{pembayaran}', [SiswaDashboardController::class, 'showPembayaran'])->name('show');
    });

    // Profile
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [SiswaProfileController::class, 'show'])->name('show');
        Route::get('/edit', [SiswaProfileController::class, 'edit'])->name('edit');
        Route::put('/', [SiswaProfileController::class, 'update'])->name('update');
        Route::put('/password', [SiswaProfileController::class, 'updatePassword'])->name('password.update');
        Route::get('/riwayat-pembayaran', [SiswaProfileController::class, 'riwayatPembayaran'])->name('riwayat.pembayaran');
        Route::get('/riwayat-tagihan', [SiswaProfileController::class, 'riwayatTagihan'])->name('riwayat.tagihan');
    });
});

// ==================== SHARED API ROUTES (untuk AJAX) ====================
Route::middleware(['auth'])->prefix('api')->name('api.')->group(function () {
    // Search siswa by NIS/NISN/Nama
    Route::get('/siswa/search', function (\Illuminate\Http\Request $request) {
        $search = $request->get('q');

        if (!$search) {
            return response()->json(['data' => []]);
        }

        $siswa = \App\Models\Siswa::with('user')
            ->where('nis', 'like', "%{$search}%")
            ->orWhere('nisn', 'like', "%{$search}%")
            ->orWhereHas('user', function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->limit(10)
            ->get()
            ->map(function ($siswa) {
                return [
                    'id' => $siswa->user_id,
                    'text' => "{$siswa->nis} - {$siswa->user->name}",
                    'nis' => $siswa->nis,
                    'name' => $siswa->user->name,
                    'kelas' => $siswa->kelas,
                ];
            });

        return response()->json(['data' => $siswa]);
    })->name('siswa.search');

    // Get dashboard stats
    Route::get('/dashboard/stats', function () {
        $user = auth()->user();
        $stats = [];

        if ($user->role === 'admin' || $user->role === 'operator') {
            $stats = [
                'total_siswa' => \App\Models\Siswa::where('status_siswa', 'aktif')->count(),
                'total_pembayaran' => \App\Models\Pembayaran::where('status', 'paid')->sum('jumlah_bayar'),
                'total_tagihan' => \App\Models\Tagihan::where('status', 'unpaid')->count(),
                'pending_pembayaran' => \App\Models\Pembayaran::where('status', 'pending')->count(),
            ];
        } elseif ($user->role === 'siswa') {
            $stats = [
                'total_tagihan' => \App\Models\Tagihan::where('user_id', $user->id)
                    ->where('status', 'unpaid')
                    ->count(),
                'total_paid' => \App\Models\Pembayaran::where('user_id', $user->id)
                    ->where('status', 'paid')
                    ->sum('jumlah_bayar'),
                'pending_pembayaran' => \App\Models\Pembayaran::where('user_id', $user->id)
                    ->where('status', 'pending')
                    ->count(),
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    })->name('dashboard.stats');

    // Get tagihan by siswa
    Route::get('/tagihan/siswa/{user_id}', function ($user_id) {
        $tagihan = Tagihan::where('user_id', $user_id)
            ->with('kategori')
            ->where('status', 'unpaid')
            ->get()
            ->map(function ($tagihan) {
                return [
                    'id' => $tagihan->id,
                    'kategori' => $tagihan->kategori->nama_kategori,
                    'jumlah' => $tagihan->jumlah_tagihan,
                    'jatuh_tempo' => $tagihan->tanggal_jatuh_tempo->format('d/m/Y'),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $tagihan
        ]);
    })->name('tagihan.siswa');
});

// ==================== DEBUG ROUTES (Local Only) ====================
if (app()->environment('local')) {
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

    Route::post('/debug-check-password', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['error' => 'User tidak ditemukan'], 404);
        }

        $matches = \Illuminate\Support\Facades\Hash::check($request->password, $user->password);

        \Illuminate\Support\Facades\Log::info('Password check debug', [
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

    Route::get('/debug-force-reset/{email}/{password}', function ($email, $password) {
        $user = \App\Models\User::where('email', $email)->first();

        if (!$user) {
            return "User tidak ditemukan";
        }

        $oldHash = $user->password;
        $newHash = \Illuminate\Support\Facades\Hash::make($password);

        $user->password = $newHash;
        $user->save();
        $user->refresh();

        $canLogin = \Illuminate\Support\Facades\Hash::check($password, $user->password);

        \Illuminate\Support\Facades\Log::info('Force password reset', [
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

    Route::get('/debug-reset-tokens', function () {
        $tokens = \Illuminate\Support\Facades\DB::table('password_reset_tokens')->get();

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

    Route::get('/debug-clear-tokens', function () {
        $count = \Illuminate\Support\Facades\DB::table('password_reset_tokens')->count();
        \Illuminate\Support\Facades\DB::table('password_reset_tokens')->truncate();

        return "Cleared {$count} tokens";
    });

    // Artisan commands via web
    Route::get('/artisan/{command}', function ($command) {
        try {
            Artisan::call($command);
            return Artisan::output();
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
    });
}

// ==================== FALLBACK ROUTE ====================
Route::fallback(function () {
    if (auth()->check()) {
        $user = auth()->user();

        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'operator':
                return redirect()->route('operator.dashboard');
            case 'siswa':
                return redirect()->route('siswa.dashboard');
            default:
                return redirect()->route('login');
        }
    }

    return redirect()->route('login');
});