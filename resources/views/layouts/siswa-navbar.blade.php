<!-- Siswa Navbar - Responsive for Mobile & Desktop -->
<nav class="sticky top-0 z-40 bg-white border-b border-gray-200 shadow-sm">
    <div class="px-4 sm:px-6 lg:px-8 h-14 sm:h-16 lg:h-20 flex items-center justify-between">
        <!-- Left: Logo & Brand -->
        <div class="flex items-center gap-2 sm:gap-3 flex-shrink-0">
            <div class="w-9 h-9 sm:w-10 sm:h-10 bg-gradient-to-br from-blue-600 to-blue-700 rounded-lg flex items-center justify-center shadow-sm">
                <i class="fas fa-graduation-cap text-white text-base sm:text-lg"></i>
            </div>
            <div class="hidden sm:block">
                <h1 class="font-bold text-gray-900 text-sm lg:text-base">SchoolPay</h1>
                <p class="text-xs text-gray-500 hidden lg:block">Portal Siswa</p>
            </div>
        </div>

        <!-- Center: Navigation Links (Desktop Only) -->
        <div class="hidden md:flex items-center gap-1">
            <a href="{{ route('siswa.dashboard') }}" class="flex items-center gap-2 px-3 lg:px-4 py-2 rounded-lg text-sm lg:text-base text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition {{ request()->routeIs('siswa.dashboard') ? 'text-blue-600 bg-blue-50 border-b-2 border-blue-600' : '' }}">
                <i class="fas fa-home"></i>
                <span class="hidden lg:inline">Dashboard</span>
            </a>
            <a href="{{ route('siswa.tagihan.index') }}" class="flex items-center gap-2 px-3 lg:px-4 py-2 rounded-lg text-sm lg:text-base text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition {{ request()->routeIs('siswa.tagihan.*') ? 'text-blue-600 bg-blue-50 border-b-2 border-blue-600' : '' }}">
                <i class="fas fa-receipt"></i>
                <span class="hidden lg:inline">Tagihan</span>
            </a>
            <a href="{{ route('siswa.transaksi.index') }}" class="flex items-center gap-2 px-3 lg:px-4 py-2 rounded-lg text-sm lg:text-base text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition {{ request()->routeIs('siswa.transaksi.*') ? 'text-blue-600 bg-blue-50 border-b-2 border-blue-600' : '' }}">
                <i class="fas fa-history"></i>
                <span class="hidden lg:inline">Riwayat</span>
            </a>
        </div>

        <!-- Right: Notifications + User Menu -->
        <div class="flex items-center gap-2 sm:gap-4">
            <!-- Mobile Menu Button -->
            <button onclick="toggleMobileMenu()" class="md:hidden p-2 text-gray-600 hover:bg-gray-100 rounded-lg transition">
                <i class="fas fa-bars text-base sm:text-lg"></i>
            </button>

            <!-- Notifications (Hidden on mobile) -->
            <div class="relative hidden sm:block">
                <button class="relative p-2 text-gray-600 hover:bg-gray-100 rounded-lg transition" onclick="toggleNotifications()">
                    <i class="fas fa-bell text-base lg:text-lg"></i>
                    @if($pendingTagihanCount > 0)
                    <span class="absolute top-0 right-0 h-2 w-2 bg-red-500 rounded-full animate-pulse"></span>
                    @endif
                </button>

                <!-- Notifications Dropdown (Mobile-responsive) -->
                <div id="notifications-dropdown" class="hidden absolute right-0 mt-2 w-72 sm:w-80 bg-white rounded-lg shadow-xl border border-gray-100 z-50">
                    <div class="p-3 sm:p-4 border-b border-gray-100">
                        <h3 class="font-semibold text-gray-900 text-sm sm:text-base">Notifikasi</h3>
                    </div>
                    <div class="max-h-80 overflow-y-auto divide-y divide-gray-100">
                        @if($pendingTagihanCount > 0)
                        <div class="p-3 sm:p-4 hover:bg-gray-50 cursor-pointer transition">
                            <div class="flex items-start gap-2 sm:gap-3">
                                <div class="p-2 bg-orange-100 rounded-lg flex-shrink-0">
                                    <i class="fas fa-exclamation text-orange-600 text-sm"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-gray-900 text-xs sm:text-sm">{{ $pendingTagihanCount }} Tagihan Belum Dibayar</p>
                                    <p class="text-xs text-gray-500">Segera lakukan pembayaran</p>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="p-6 sm:p-8 text-center">
                            <i class="fas fa-check-circle text-green-500 text-2xl sm:text-3xl mb-2 block"></i>
                            <p class="text-gray-600 text-xs sm:text-sm">Tidak ada notifikasi baru</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- User Menu -->
            <div class="relative">
                <button onclick="toggleUserMenu()" class="flex items-center gap-2 p-1 sm:p-2 rounded-lg hover:bg-gray-100 transition">
                    <div class="hidden sm:block text-right">
                        <p class="font-medium text-gray-900 text-xs sm:text-sm line-clamp-1">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500 hidden lg:block">Siswa</p>
                    </div>
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&color=3B82F6&background=DBEAFE"
                         alt="{{ auth()->user()->name }}" class="w-8 h-8 sm:w-9 sm:h-9 rounded-full">
                </button>

                <!-- User Dropdown Menu (Mobile-responsive) -->
                <div id="user-menu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-100 z-50">
                    <div class="p-3 sm:p-4 border-b border-gray-100">
                        <p class="font-medium text-gray-900 text-sm">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-gray-50 text-sm transition">
                        <i class="fas fa-user-circle w-4"></i> Profil
                    </a>
                    
                    <!-- Mobile Navigation (visible only on small screens in dropdown) -->
                    <div class="md:hidden border-t border-gray-100 py-2">
                        <a href="{{ route('siswa.dashboard') }}" class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-gray-50 text-sm transition">
                            <i class="fas fa-home w-4"></i> Dashboard
                        </a>
                        <a href="{{ route('siswa.tagihan.index') }}" class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-gray-50 text-sm transition">
                            <i class="fas fa-receipt w-4"></i> Tagihan
                        </a>
                        <a href="{{ route('siswa.transaksi.index') }}" class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-gray-50 text-sm transition">
                            <i class="fas fa-history w-4"></i> Riwayat
                        </a>
                    </div>

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

    <!-- Mobile Navigation Menu (below navbar on mobile) -->
    <div id="mobile-menu" class="hidden md:hidden border-t border-gray-200 bg-gray-50">
        <div class="px-4 py-2 space-y-1">
            <a href="{{ route('siswa.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-gray-700 hover:text-blue-600 rounded-lg hover:bg-blue-50 transition text-sm">
                <i class="fas fa-home w-4"></i> Dashboard
            </a>
            <a href="{{ route('siswa.tagihan.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-gray-700 hover:text-blue-600 rounded-lg hover:bg-blue-50 transition text-sm">
                <i class="fas fa-receipt w-4"></i> Tagihan
            </a>
            <a href="{{ route('siswa.transaksi.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-gray-700 hover:text-blue-600 rounded-lg hover:bg-blue-50 transition text-sm">
                <i class="fas fa-history w-4"></i> Riwayat
            </a>
        </div>
    </div>
</nav>

<script>
    function toggleMobileMenu() {
        const menu = document.getElementById('mobile-menu');
        menu?.classList.toggle('hidden');
    }

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
        const notifications = document.getElementById('notifications-dropdown');
        const userMenu = document.getElementById('user-menu');

        if (!event.target.closest('.relative') && !event.target.closest('button[onclick*="toggle"]')) {
            notifications?.classList.add('hidden');
            userMenu?.classList.add('hidden');
        }
    });
</script>