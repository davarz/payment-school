<!-- Desktop Top Navigation Bar - Only visible on lg screens -->
<nav class="hidden lg:flex sticky top-0 z-40 bg-white border-b border-gray-200 shadow-sm h-16">
    <div class="w-full px-8 flex items-center justify-between">
        <!-- Left side: Clean Menu Items (Text Only) -->
        <div class="flex items-center gap-1">
            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 font-medium text-sm transition-all duration-200 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'text-blue-600 bg-blue-50 border-b-2 border-blue-600' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-50' }}">
                Dashboard
            </a>
            
            <a href="{{ route('admin.siswa.index') }}" class="px-4 py-2 font-medium text-sm transition-all duration-200 rounded-lg {{ request()->routeIs('admin.siswa.*') ? 'text-blue-600 bg-blue-50 border-b-2 border-blue-600' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-50' }}">
                Data Siswa
            </a>

            <a href="{{ route('admin.kategori.index') }}" class="px-4 py-2 font-medium text-sm transition-all duration-200 rounded-lg {{ request()->routeIs('admin.kategori.*') ? 'text-blue-600 bg-blue-50 border-b-2 border-blue-600' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-50' }}">
                Kategori
            </a>

            <a href="{{ route('admin.tagihan.index') }}" class="px-4 py-2 font-medium text-sm transition-all duration-200 rounded-lg {{ request()->routeIs('admin.tagihan.*') ? 'text-blue-600 bg-blue-50 border-b-2 border-blue-600' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-50' }}">
                Tagihan
            </a>

            <a href="{{ route('admin.pembayaran.index') }}" class="px-4 py-2 font-medium text-sm transition-all duration-200 rounded-lg {{ request()->routeIs('admin.pembayaran.*') ? 'text-blue-600 bg-blue-50 border-b-2 border-blue-600' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-50' }}">
                Pembayaran
                @if($pendingPembayaranCount > 0)
                    <span class="ml-2 inline-flex items-center justify-center px-2 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-700">{{ $pendingPembayaranCount }}</span>
                @endif
            </a>

            <a href="{{ route('admin.laporan.index') }}" class="px-4 py-2 font-medium text-sm transition-all duration-200 rounded-lg {{ request()->routeIs('admin.laporan.*') ? 'text-blue-600 bg-blue-50 border-b-2 border-blue-600' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-50' }}">
                Laporan
            </a>

            <a href="{{ route('admin.import-export.export') }}" class="px-4 py-2 font-medium text-sm transition-all duration-200 rounded-lg {{ request()->routeIs('admin.import-export.*') ? 'text-blue-600 bg-blue-50 border-b-2 border-blue-600' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-50' }}">
                Import/Export
            </a>

            <a href="{{ route('admin.bulk.naik-kelas') }}" class="px-4 py-2 font-medium text-sm transition-all duration-200 rounded-lg {{ request()->routeIs('admin.bulk.*') ? 'text-blue-600 bg-blue-50 border-b-2 border-blue-600' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-50' }}">
                Bulk Ops
            </a>
        </div>

        <!-- Right side: Notifications + User Menu -->
        <div class="flex items-center gap-4">
            <!-- Notifications -->
            <div class="relative">
                <button class="relative p-2 text-gray-600 hover:bg-gray-100 rounded-lg transition" onclick="toggleNotifications()">
                    <i class="fas fa-bell text-lg"></i>
                    @if($pendingPembayaranCount > 0 || $pendingTagihanCount > 0)
                    <span class="absolute top-0 right-0 h-2 w-2 bg-red-500 rounded-full animate-pulse"></span>
                    @endif
                </button>
                
                <!-- Notifications Dropdown -->
                <div id="notifications-dropdown" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl border border-gray-100 z-50">
                    <div class="p-4 border-b border-gray-100">
                        <h3 class="font-semibold text-gray-900">Notifikasi</h3>
                    </div>
                    <div class="max-h-80 overflow-y-auto divide-y divide-gray-100">
                        @if($pendingPembayaranCount > 0)
                        <div class="p-4 hover:bg-gray-50 cursor-pointer transition">
                            <div class="flex items-start gap-3">
                                <div class="p-2 bg-orange-100 rounded-lg flex-shrink-0">
                                    <i class="fas fa-exclamation text-orange-600"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-gray-900 text-sm">{{ $pendingPembayaranCount }} Pembayaran Pending</p>
                                    <p class="text-xs text-gray-500 mt-1">Menunggu verifikasi</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($pendingTagihanCount > 0)
                        <div class="p-4 hover:bg-gray-50 cursor-pointer transition">
                            <div class="flex items-start gap-3">
                                <div class="p-2 bg-red-100 rounded-lg flex-shrink-0">
                                    <i class="fas fa-receipt text-red-600"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-gray-900 text-sm">{{ $pendingTagihanCount }} Tagihan Belum Dibayar</p>
                                    <p class="text-xs text-gray-500 mt-1">Perlu pembayaran</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($pendingPembayaranCount === 0 && $pendingTagihanCount === 0)
                        <div class="p-8 text-center">
                            <i class="fas fa-check-circle text-green-500 text-2xl mb-2"></i>
                            <p class="text-gray-600 text-sm">Tidak ada notifikasi baru</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- User Menu -->
            <div class="relative">
                <button onclick="toggleUserMenu()" class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-100 transition">
                    <div class="text-right">
                        <p class="font-medium text-gray-900 text-sm">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500 capitalize">{{ auth()->user()->role }}</p>
                    </div>
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&color=3B82F6&background=DBEAFE" 
                         alt="{{ auth()->user()->name }}" class="w-9 h-9 rounded-full">
                </button>

                <!-- User Dropdown Menu -->
                <div id="user-menu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-100 z-50">
                    <div class="p-4 border-b border-gray-100">
                        <p class="font-medium text-gray-900 text-sm">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-gray-50 text-sm transition">
                        <i class="fas fa-user-circle w-4"></i> Profil
                    </a>
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-gray-50 text-sm transition">
                        <i class="fas fa-cog w-4"></i> Pengaturan
                    </a>
                    <hr class="my-2">
                    <form method="POST" action="{{ route('logout') }}" class="block">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-red-600 hover:bg-red-50 text-sm transition">
                            <i class="fas fa-sign-out-alt w-4"></i> Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
    function toggleNotifications() {
        const dropdown = document.getElementById('notifications-dropdown');
        dropdown?.classList.toggle('hidden');
        document.getElementById('user-menu')?.classList.add('hidden');
    }

    function toggleUserMenu() {
        const menu = document.getElementById('user-menu');
        menu?.classList.toggle('hidden');
        document.getElementById('notifications-dropdown')?.classList.add('hidden');
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(event) {
        if (!event.target.closest('.relative') && !event.target.closest('button[onclick*="toggle"]')) {
            document.getElementById('notifications-dropdown')?.classList.add('hidden');
            document.getElementById('user-menu')?.classList.add('hidden');
        }
    });
</script>
