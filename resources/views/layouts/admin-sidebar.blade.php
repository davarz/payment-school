<!-- Mobile sidebar backdrop -->
<div id="sidebar-backdrop" class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden hidden" onclick="toggleMobileMenu()"></div>

<!-- Sidebar -->
<div id="admin-sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-2xl border-r border-gray-100 transform -translate-x-full transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:z-0 flex flex-col">
    <!-- Header -->
    <div class="h-20 bg-gradient-to-r from-blue-600 to-blue-700 px-6 flex items-center justify-between border-b border-blue-800/20">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur">
                <i class="fas fa-graduation-cap text-white text-lg"></i>
            </div>
            <div>
                <h1 class="text-white font-bold text-lg">SchoolPay</h1>
                <p class="text-blue-100 text-xs">Admin Panel</p>
            </div>
        </div>
        <button onclick="toggleMobileMenu()" class="lg:hidden text-white hover:bg-white/20 p-2 rounded-lg transition">
            <i class="fas fa-times text-xl"></i>
        </button>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto px-4 py-6 space-y-2">
        <!-- Main Menu -->
        <div class="space-y-1 mb-6">
            <p class="text-xs font-semibold text-gray-500 uppercase px-3 mb-3 tracking-wide">Menu Utama</p>
            
            <a href="{{ route('admin.dashboard') }}" class="group flex items-center px-4 py-3 text-gray-700 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-600' : 'hover:bg-gray-50 border-l-4 border-transparent' }}">
                <i class="fas fa-tachometer-alt w-5 text-center {{ request()->routeIs('admin.dashboard') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }} transition"></i>
                <span class="ml-3 font-medium">Dashboard</span>
            </a>
        </div>

        <!-- Data Management -->
        <div class="space-y-1 mb-6">
            <p class="text-xs font-semibold text-gray-500 uppercase px-3 mb-3 tracking-wide">Manajemen Data</p>
            
            <a href="{{ route('admin.siswa.index') }}" class="group flex items-center px-4 py-3 text-gray-700 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.siswa.*') ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-600' : 'hover:bg-gray-50 border-l-4 border-transparent' }}">
                <i class="fas fa-users w-5 text-center {{ request()->routeIs('admin.siswa.*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }} transition"></i>
                <span class="ml-3 font-medium">Data Siswa</span>
            </a>

            <a href="{{ route('admin.kategori.index') }}" class="group flex items-center px-4 py-3 text-gray-700 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.kategori.*') ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-600' : 'hover:bg-gray-50 border-l-4 border-transparent' }}">
                <i class="fas fa-list-alt w-5 text-center {{ request()->routeIs('admin.kategori.*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }} transition"></i>
                <span class="ml-3 font-medium">Kategori Bayar</span>
            </a>
        </div>

        <!-- Transactions -->
        <div class="space-y-1 mb-6">
            <p class="text-xs font-semibold text-gray-500 uppercase px-3 mb-3 tracking-wide">Transaksi</p>
            
            <a href="{{ route('admin.pembayaran.index') }}" class="group flex items-center px-4 py-3 text-gray-700 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.pembayaran.*') ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-600' : 'hover:bg-gray-50 border-l-4 border-transparent' }}">
                <i class="fas fa-money-bill-wave w-5 text-center {{ request()->routeIs('admin.pembayaran.*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }} transition"></i>
                <span class="ml-3 font-medium">Pembayaran</span>
                @if($pendingPembayaranCount > 0)
                <span class="ml-auto inline-flex items-center px-2 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700">{{ $pendingPembayaranCount }}</span>
                @endif
            </a>

            <a href="{{ route('admin.tagihan.index') }}" class="group flex items-center px-4 py-3 text-gray-700 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.tagihan.*') ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-600' : 'hover:bg-gray-50 border-l-4 border-transparent' }}">
                <i class="fas fa-receipt w-5 text-center {{ request()->routeIs('admin.tagihan.*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }} transition"></i>
                <span class="ml-3 font-medium">Tagihan</span>
            </a>
        </div>

        <!-- Reports & Operations -->
        <div class="space-y-1 mb-6">
            <p class="text-xs font-semibold text-gray-500 uppercase px-3 mb-3 tracking-wide">Laporan</p>
            
            <a href="{{ route('admin.laporan.index') }}" class="group flex items-center px-4 py-3 text-gray-700 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.laporan.*') ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-600' : 'hover:bg-gray-50 border-l-4 border-transparent' }}">
                <i class="fas fa-chart-bar w-5 text-center {{ request()->routeIs('admin.laporan.*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }} transition"></i>
                <span class="ml-3 font-medium">Laporan</span>
            </a>

            <a href="{{ route('admin.import-export.export') }}" class="group flex items-center px-4 py-3 text-gray-700 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.import-export.*') ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-600' : 'hover:bg-gray-50 border-l-4 border-transparent' }}">
                <i class="fas fa-exchange-alt w-5 text-center {{ request()->routeIs('admin.import-export.*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }} transition"></i>
                <span class="ml-3 font-medium">Import/Export</span>
            </a>
        </div>

        <!-- Settings -->
        <div class="space-y-1">
            <p class="text-xs font-semibold text-gray-500 uppercase px-3 mb-3 tracking-wide">Pengaturan</p>
            
            <a href="{{ route('profile.edit') }}" class="group flex items-center px-4 py-3 text-gray-700 rounded-lg transition-all duration-200 {{ request()->routeIs('profile.*') ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-600' : 'hover:bg-gray-50 border-l-4 border-transparent' }}">
                <i class="fas fa-user-cog w-5 text-center {{ request()->routeIs('profile.*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }} transition"></i>
                <span class="ml-3 font-medium">Pengaturan Profil</span>
            </a>
        </div>
    </nav>

    <!-- Footer / Logout -->
    <div class="px-4 py-4 border-t border-gray-200 space-y-2">
        <form method="POST" action="{{ route('logout') }}" class="w-full">
            @csrf
            <button type="submit" class="w-full flex items-center px-4 py-3 text-red-600 hover:bg-red-50 rounded-lg transition-all duration-200 border-l-4 border-transparent hover:border-red-600">
                <i class="fas fa-sign-out-alt w-5"></i>
                <span class="ml-3 font-medium">Keluar</span>
            </button>
        </form>
    </div>
</div>
<!-- Bulk Operations -->
            <a href="{{ route('admin.bulk.naik-kelas') }}" class="group flex items-center px-3 py-2.5 text-slate-600 hover:text-blue-700 hover:bg-blue-50 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.bulk.*') ? 'bg-blue-50 text-blue-700 border border-blue-200 shadow-sm' : '' }}">
                <div class="w-9 h-9 flex items-center justify-center rounded-lg {{ request()->routeIs('admin.bulk.*') ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-500 group-hover:bg-blue-100 group-hover:text-blue-600' }} transition-colors">
                    <i class="fas fa-cogs text-sm"></i>
                </div>
                <span class="ml-3 font-medium">Bulk Operations</span>
            </a>

            <!-- Import/Export -->
            <a href="{{ route('admin.import-export.export') }}" class="group flex items-center px-3 py-2.5 text-slate-600 hover:text-blue-700 hover:bg-blue-50 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.import-export.*') ? 'bg-blue-50 text-blue-700 border border-blue-200 shadow-sm' : '' }}">
                <div class="w-9 h-9 flex items-center justify-center rounded-lg {{ request()->routeIs('admin.import-export.*') ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-500 group-hover:bg-blue-100 group-hover:text-blue-600' }} transition-colors">
                    <i class="fas fa-file-export text-sm"></i>
                </div>
                <span class="ml-3 font-medium">Backup Data</span>
            </a>
        </div>
    </nav>

    <!-- User Menu -->
    <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-200 bg-white">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-semibold text-sm shadow-sm">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-slate-800 truncate">
                    {{ auth()->user()->name }}
                </p>
                <p class="text-xs text-slate-500 truncate capitalize">
                    {{ auth()->user()->role }}
                </p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all duration-200">
                    <i class="fas fa-sign-out-alt text-sm"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Top Bar -->
<div class="fixed top-0 right-0 left-0 lg:left-64 z-40 bg-white shadow-sm border-b border-gray-200 transition-all duration-300">
    <div class="flex items-center justify-between h-16 px-4 sm:px-6">
        <div class="flex items-center">
            <!-- Mobile menu button -->
            <button id="mobile-menu-button" class="lg:hidden mr-3 p-2 rounded-lg text-slate-600 hover:text-slate-900 hover:bg-slate-100">
                <i class="fas fa-bars text-lg"></i>
            </button>

            <div>
                <h1 class="text-lg sm:text-xl font-bold text-slate-800">@yield('title')</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1 flex items-center">
                    <i class="fas fa-calendar-day mr-2 text-blue-500"></i>
                    {{ date('l, d F Y') }}
                </p>
            </div>
        </div>
        <div class="flex items-center space-x-3 sm:space-x-4">
            <!-- Notifications -->
            <button class="relative p-2 text-slate-500 hover:text-slate-700 hover:bg-slate-100 rounded-lg transition-colors duration-200">
                <i class="fas fa-bell"></i>
                <span class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full border-2 border-white"></span>
            </button>

            <!-- Quick Stats -->
            <div class="hidden sm:flex items-center space-x-2 sm:space-x-3 px-2 sm:px-3 py-1.5 bg-blue-50 rounded-lg border border-blue-200">
                <i class="fas fa-users text-blue-600 text-sm"></i>
                <span class="text-xs sm:text-sm font-medium text-blue-700">{{ $totalSiswa ?? 0 }} Siswa</span>
            </div>

            <!-- User Profile -->
            <div class="flex items-center space-x-2 sm:space-x-3">
                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-semibold text-xs sm:text-sm shadow-sm">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <span class="hidden sm:block text-sm font-medium text-slate-800 max-w-[100px] truncate">{{ auth()->user()->name }}</span>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sidebar functionality
    const sidebar = document.getElementById('admin-sidebar');
    const backdrop = document.getElementById('sidebar-backdrop');
    const mobileMenuButton = document.getElementById('mobile-menu-button');

    function toggleSidebar() {
        const isOpen = !sidebar.classList.contains('-translate-x-full');

        if (isOpen) {
            // Close sidebar
            sidebar.classList.add('-translate-x-full');
            backdrop.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        } else {
            // Open sidebar
            sidebar.classList.remove('-translate-x-full');
            backdrop.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }
    }

    function closeSidebar() {
        sidebar.classList.add('-translate-x-full');
        backdrop.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    // Event listeners
    if (mobileMenuButton) {
        mobileMenuButton.addEventListener('click', function(e) {
            e.stopPropagation();
            toggleSidebar();
        });
    }

    if (backdrop) {
        backdrop.addEventListener('click', closeSidebar);
    }

    // Close sidebar when clicking outside on the sidebar itself
    if (sidebar) {
        sidebar.addEventListener('click', function(e) {
            e.stopPropagation(); // Don't propagate clicks inside the sidebar
        });
    }

    // On window resize, close sidebar if window is large enough
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 1024) { // lg breakpoint
            closeSidebar();
        }
    });
});
</script>