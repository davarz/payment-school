<!-- Mobile sidebar backdrop -->
<div id="sidebar-backdrop" class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden hidden"></div>

<!-- Sidebar -->
<div id="admin-sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-2xl border-r border-gray-100 transform -translate-x-full transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:z-0">
    <!-- Header -->
    <div class="flex items-center justify-center h-16 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
        <div class="flex items-center space-x-2">
            <div class="w-8 h-8 bg-gradient-to-br from-blue-600 to-blue-500 rounded-lg flex items-center justify-center shadow-sm">
                <i class="fas fa-graduation-cap text-white text-sm"></i>
            </div>
            <span class="text-slate-800 text-lg font-semibold tracking-wide">SchoolPay</span>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="mt-6 px-3">
        <div class="space-y-1">
            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}" class="group flex items-center px-3 py-2.5 text-slate-600 hover:text-blue-700 hover:bg-blue-50 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-700 border border-blue-200 shadow-sm' : '' }}">
                <div class="w-9 h-9 flex items-center justify-center rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-500 group-hover:bg-blue-100 group-hover:text-blue-600' }} transition-colors">
                    <i class="fas fa-tachometer-alt text-sm"></i>
                </div>
                <span class="ml-3 font-medium">Dashboard</span>
            </a>

            <!-- Manajemen Siswa -->
            <a href="{{ route('admin.siswa.index') }}" class="group flex items-center px-3 py-2.5 text-slate-600 hover:text-blue-700 hover:bg-blue-50 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.siswa.*') ? 'bg-blue-50 text-blue-700 border border-blue-200 shadow-sm' : '' }}">
                <div class="w-9 h-9 flex items-center justify-center rounded-lg {{ request()->routeIs('admin.siswa.*') ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-500 group-hover:bg-blue-100 group-hover:text-blue-600' }} transition-colors">
                    <i class="fas fa-users text-sm"></i>
                </div>
                <span class="ml-3 font-medium">Data Siswa</span>
            </a>

            <!-- Kategori Pembayaran -->
            <a href="{{ route('admin.kategori.index') }}" class="group flex items-center px-3 py-2.5 text-slate-600 hover:text-blue-700 hover:bg-blue-50 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.kategori.*') ? 'bg-blue-50 text-blue-700 border border-blue-200 shadow-sm' : '' }}">
                <div class="w-9 h-9 flex items-center justify-center rounded-lg {{ request()->routeIs('admin.kategori.*') ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-500 group-hover:bg-blue-100 group-hover:text-blue-600' }} transition-colors">
                    <i class="fas fa-list-alt text-sm"></i>
                </div>
                <span class="ml-3 font-medium">Kategori Bayar</span>
            </a>

            <!-- Pembayaran -->
            <a href="{{ route('admin.pembayaran.index') }}" class="group flex items-center px-3 py-2.5 text-slate-600 hover:text-blue-700 hover:bg-blue-50 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.pembayaran.*') ? 'bg-blue-50 text-blue-700 border border-blue-200 shadow-sm' : '' }}">
                <div class="w-9 h-9 flex items-center justify-center rounded-lg {{ request()->routeIs('admin.pembayaran.*') ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-500 group-hover:bg-blue-100 group-hover:text-blue-600' }} transition-colors">
                    <i class="fas fa-money-bill-wave text-sm"></i>
                </div>
                <span class="ml-3 font-medium">Pembayaran</span>
            </a>

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