<!-- Mobile Sidebar Navigation - Only visible on mobile (<lg screens) -->
<div id="sidebar-backdrop" class="fixed inset-0 z-40 bg-black/50 lg:hidden hidden" onclick="toggleMobileMenu()"></div>

<!-- Sidebar - Responsive Design (Mobile: visible, Desktop lg: hidden) -->
<div id="admin-sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-2xl border-r border-gray-100 transform -translate-x-full transition-transform duration-300 ease-in-out lg:hidden flex flex-col max-h-screen overflow-y-auto">
    <!-- Header with Logo -->
    <div class="h-16 bg-gradient-to-r from-blue-600 to-blue-700 px-4 flex items-center justify-between flex-shrink-0 border-b border-blue-800/20">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur">
                <i class="fas fa-graduation-cap text-white text-lg"></i>
            </div>
            <div>
                <h1 class="text-white font-bold text-base">SchoolPay</h1>
            </div>
        </div>
        <button onclick="toggleMobileMenu()" class="text-white hover:bg-white/20 p-2 rounded-lg transition">
            <i class="fas fa-times text-lg"></i>
        </button>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
        <!-- Main Menu Section -->
        <div class="space-y-1 mb-4">
            <a href="{{ route('admin.dashboard') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-600' : 'text-gray-700 hover:bg-gray-50 border-l-4 border-transparent' }}">
                <i class="fas fa-tachometer-alt w-5 text-center {{ request()->routeIs('admin.dashboard') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                <span class="font-medium text-sm">Dashboard</span>
            </a>
        </div>

        <!-- Data Management Section -->
        <div class="space-y-1 mb-4">
            <p class="text-xs font-semibold text-gray-500 uppercase px-3 mb-3 tracking-wide">Manajemen Data</p>

            <a href="{{ route('admin.siswa.index') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.siswa.*') ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-600' : 'text-gray-700 hover:bg-gray-50 border-l-4 border-transparent' }}">
                <i class="fas fa-users w-5 text-center {{ request()->routeIs('admin.siswa.*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                <span class="font-medium text-sm">Data Siswa</span>
            </a>

            <a href="{{ route('admin.kategori.index') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.kategori.*') ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-600' : 'text-gray-700 hover:bg-gray-50 border-l-4 border-transparent' }}">
                <i class="fas fa-list-alt w-5 text-center {{ request()->routeIs('admin.kategori.*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                <span class="font-medium text-sm">Kategori Bayar</span>
            </a>
        </div>

        <!-- Transactions Section -->
        <div class="space-y-1 mb-4">
            <p class="text-xs font-semibold text-gray-500 uppercase px-3 mb-3 tracking-wide">Transaksi</p>

            <a href="{{ route('admin.pembayaran.index') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.pembayaran.*') ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-600' : 'text-gray-700 hover:bg-gray-50 border-l-4 border-transparent' }}">
                <i class="fas fa-money-bill-wave w-5 text-center {{ request()->routeIs('admin.pembayaran.*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                <span class="font-medium text-sm">Pembayaran</span>
                @if($pendingPembayaranCount > 0)
                <span class="ml-auto inline-flex items-center justify-center px-2 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 flex-shrink-0">{{ $pendingPembayaranCount }}</span>
                @endif
            </a>

            <a href="{{ route('admin.tagihan.index') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.tagihan.*') ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-600' : 'text-gray-700 hover:bg-gray-50 border-l-4 border-transparent' }}">
                <i class="fas fa-receipt w-5 text-center {{ request()->routeIs('admin.tagihan.*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                <span class="font-medium text-sm">Tagihan</span>
            </a>
        </div>

        <!-- Reports Section -->
        <div class="space-y-1 mb-4">
            <p class="text-xs font-semibold text-gray-500 uppercase px-3 mb-3 tracking-wide">Laporan</p>

            <a href="{{ route('admin.laporan.index') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.laporan.*') ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-600' : 'text-gray-700 hover:bg-gray-50 border-l-4 border-transparent' }}">
                <i class="fas fa-chart-bar w-5 text-center {{ request()->routeIs('admin.laporan.*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                <span class="font-medium text-sm">Laporan</span>
            </a>

            <a href="{{ route('admin.import-export.export') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.import-export.*') ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-600' : 'text-gray-700 hover:bg-gray-50 border-l-4 border-transparent' }}">
                <i class="fas fa-exchange-alt w-5 text-center {{ request()->routeIs('admin.import-export.*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                <span class="font-medium text-sm">Import/Export</span>
            </a>

            <a href="{{ route('admin.bulk.naik-kelas') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.bulk.*') ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-600' : 'text-gray-700 hover:bg-gray-50 border-l-4 border-transparent' }}">
                <i class="fas fa-cogs w-5 text-center {{ request()->routeIs('admin.bulk.*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                <span class="font-medium text-sm">Bulk Operations</span>
            </a>
        </div>

        <!-- Settings Section -->
        <div class="space-y-1">
            <p class="text-xs font-semibold text-gray-500 uppercase px-3 mb-3 tracking-wide">Pengaturan</p>

            <a href="{{ route('profile.edit') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 {{ request()->routeIs('profile.*') ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-600' : 'text-gray-700 hover:bg-gray-50 border-l-4 border-transparent' }}">
                <i class="fas fa-user-cog w-5 text-center {{ request()->routeIs('profile.*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                <span class="font-medium text-sm">Pengaturan Profil</span>
            </a>
        </div>
    </nav>

    <!-- Footer / Logout -->
    <div class="px-3 py-3 border-t border-gray-200 space-y-2 flex-shrink-0">
        <form method="POST" action="{{ route('logout') }}" class="w-full">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 text-red-600 hover:bg-red-50 rounded-lg transition-all duration-200 font-medium text-sm">
                <i class="fas fa-sign-out-alt w-5"></i>
                Logout
            </button>
        </form>
    </div>
</div>

<script>
    function toggleMobileMenu() {
        const sidebar = document.getElementById('admin-sidebar');
        const backdrop = document.getElementById('sidebar-backdrop');
        
        if (sidebar) {
            sidebar.classList.toggle('-translate-x-full');
            backdrop.classList.toggle('hidden');
        }
    }
</script>