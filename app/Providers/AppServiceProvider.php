<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use App\Models\User;
use App\Models\Siswa;
use App\Models\KategoriPembayaran;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Set default string length untuk MySQL
        Schema::defaultStringLength(191);

        // Load auth routes jika ada
        if (file_exists(base_path('routes/auth.php'))) {
            require base_path('routes/auth.php');
        }

        // Share data dengan semua view
        $this->shareViewData();
        
        // Register custom blade directives
        $this->registerBladeDirectives();
        
        // Setup model observers
        $this->setupObservers();
        
        // Setup default settings
        $this->setupDefaultSettings();
        
        // Setup custom validation rules
        $this->setupValidationRules();
    }

    /**
     * Share common data with all views
     */
    private function shareViewData(): void
    {
        // Share data untuk layout
        View::composer('*', function ($view) {
            $user = auth()->user();
            $siswaData = null;
            
            if ($user) {
                // Tambahkan data siswa jika user adalah siswa
                if ($user->role === 'siswa') {
                    $siswaData = Siswa::where('user_id', $user->id)->first();
                }
                
                // Hitung notifikasi atau data lainnya
                $unreadNotifications = $user->unreadNotifications ?? collect();
                $pendingPembayaran = 0;
                $pendingTagihan = 0;
                
                if ($user->role === 'admin' || $user->role === 'operator') {
                    $pendingPembayaran = \App\Models\Pembayaran::where('status', 'pending')->count();
                    $pendingTagihan = \App\Models\Tagihan::where('status', 'unpaid')->count();
                }
                
                if ($user->role === 'siswa') {
                    $pendingTagihan = \App\Models\Tagihan::where('user_id', $user->id)
                        ->where('status', 'unpaid')
                        ->count();
                }
                
                $view->with([
                    'currentUser' => $user,
                    'currentSiswa' => $siswaData,
                    'unreadNotifications' => $unreadNotifications,
                    'pendingPembayaranCount' => $pendingPembayaran,
                    'pendingTagihanCount' => $pendingTagihan,
                ]);
            }
        });

        // Share app settings atau config umum
        View::share([
            'appName' => config('app.name', 'Sistem Pembayaran Sekolah'),
            'appVersion' => '1.0.0',
            'currentYear' => date('Y'),
            'semesterAktif' => session('semester_aktif', 'ganjil'),
            'tahunAjaranAktif' => session('tahun_ajaran_aktif', date('Y') . '/' . (date('Y') + 1)),
            'kelasList' => Cache::remember('kelas_list', 3600, function () {
                return Siswa::distinct()->whereNotNull('kelas')->pluck('kelas')->sort()->values();
            }),
            'tahunAjaranList' => Cache::remember('tahun_ajaran_list', 3600, function () {
                return Siswa::distinct()->whereNotNull('tahun_ajaran')->pluck('tahun_ajaran')->sort()->values();
            }),
        ]);
    }

    /**
     * Register custom blade directives
     */
    private function registerBladeDirectives(): void
    {
        // Directive untuk cek role
        Blade::if('role', function ($role) {
            $user = auth()->user();
            
            if (!$user) {
                return false;
            }
            
            // Support multiple roles: @role('admin,operator')
            $roles = explode(',', $role);
            return in_array($user->role, $roles);
        });

        // Directive untuk cek apakah admin
        Blade::if('admin', function () {
            return auth()->check() && auth()->user()->isAdmin();
        });

        // Directive untuk cek apakah operator
        Blade::if('operator', function () {
            return auth()->check() && auth()->user()->isOperator();
        });

        // Directive untuk cek apakah siswa
        Blade::if('siswa', function () {
            return auth()->check() && auth()->user()->isSiswa();
        });

        // Directive untuk cek apakah siswa aktif
        Blade::if('siswaAktif', function () {
            if (!auth()->check() || !auth()->user()->isSiswa()) {
                return false;
            }
            
            $siswa = Siswa::where('user_id', auth()->id())->first();
            return $siswa && $siswa->status_siswa === 'aktif';
        });

        // Directive untuk format currency
        Blade::directive('currency', function ($expression) {
            return "<?php echo 'Rp ' . number_format($expression, 0, ',', '.'); ?>";
        });

        // Directive untuk format tanggal Indonesia
        Blade::directive('indoDate', function ($expression) {
            return "<?php 
                if (!empty($expression)) {
                    \$date = \Carbon\Carbon::parse($expression);
                    \$hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                    \$bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                    echo \$hari[\$date->dayOfWeek] . ', ' . \$date->format('d') . ' ' . \$bulan[\$date->month - 1] . ' ' . \$date->format('Y');
                }
            ?>";
        });

        // Directive untuk tanggal singkat
        Blade::directive('shortDate', function ($expression) {
            return "<?php 
                if (!empty($expression)) {
                    echo \Carbon\Carbon::parse($expression)->format('d/m/Y');
                }
            ?>";
        });

        // Directive untuk badge status
        Blade::directive('statusBadge', function ($expression) {
            return "<?php
                \$status = $expression;
                \$badgeClass = 'bg-gray-100 text-gray-800';
                \$text = ucfirst(\$status);
                
                switch (\$status) {
                    case 'aktif':
                    case 'active':
                    case 'paid':
                        \$badgeClass = 'bg-green-100 text-green-800';
                        \$text = 'Aktif';
                        break;
                    case 'pending':
                        \$badgeClass = 'bg-yellow-100 text-yellow-800';
                        \$text = 'Pending';
                        break;
                    case 'unpaid':
                        \$badgeClass = 'bg-red-100 text-red-800';
                        \$text = 'Belum Bayar';
                        break;
                    case 'inactive':
                        \$badgeClass = 'bg-gray-100 text-gray-800';
                        \$text = 'Tidak Aktif';
                        break;
                    case 'canceled':
                        \$badgeClass = 'bg-gray-100 text-gray-800';
                        \$text = 'Dibatalkan';
                        break;
                    case 'pindah':
                        \$badgeClass = 'bg-blue-100 text-blue-800';
                        \$text = 'Pindah';
                        break;
                    case 'dikeluarkan':
                        \$badgeClass = 'bg-red-100 text-red-800';
                        \$text = 'Dikeluarkan';
                        break;
                    case 'lulus':
                        \$badgeClass = 'bg-purple-100 text-purple-800';
                        \$text = 'Lulus';
                        break;
                }
                
                echo '<span class=\"px-2 py-1 text-xs font-medium rounded-full ' . \$badgeClass . '\">' . \$text . '</span>';
            ?>";
        });

        // Directive untuk truncate text
        Blade::directive('truncate', function ($expression) {
            list($text, $length) = explode(',', $expression . ',50');
            return "<?php echo Str::limit($text, $length); ?>";
        });
    }

    /**
     * Setup model observers
     */
    private function setupObservers(): void
    {
        // Observer untuk User model
        User::observe(\App\Observers\UserObserver::class);
        
        // Observer untuk Siswa model
        Siswa::observe(\App\Observers\SiswaObserver::class);
        
        // Observer untuk Pembayaran model
        \App\Models\Pembayaran::observe(\App\Observers\PembayaranObserver::class);
        
        // Observer untuk Tagihan model
        \App\Models\Tagihan::observe(\App\Observers\TagihanObserver::class);
        
        // Observer untuk KategoriPembayaran model
        \App\Models\KategoriPembayaran::observe(\App\Observers\KategoriPembayaranObserver::class);
    }

    /**
     * Setup default settings atau konfigurasi
     */
    private function setupDefaultSettings(): void
    {
        // Set semester aktif jika belum ada di session
        if (!session()->has('semester_aktif')) {
            $currentMonth = date('n');
            $semester = ($currentMonth >= 1 && $currentMonth <= 6) ? 'genap' : 'ganjil';
            session(['semester_aktif' => $semester]);
        }

        // Set tahun ajaran aktif jika belum ada di session
        if (!session()->has('tahun_ajaran_aktif')) {
            $currentYear = date('Y');
            $tahunAjaran = $currentYear . '/' . ($currentYear + 1);
            session(['tahun_ajaran_aktif' => $tahunAjaran]);
        }
    }

    /**
     * Setup custom validation rules
     */
    private function setupValidationRules(): void
    {
        // Contoh custom validation rule (jika diperlukan)
        // Validator::extend('nis_format', function ($attribute, $value, $parameters, $validator) {
        //     return preg_match('/^[0-9]{10}$/', $value);
        // }, 'Format NIS tidak valid. Harus 10 digit angka.');
    }
}