<!-- Top Navigation Bar - Responsive -->
<nav class="sticky top-0 z-40 bg-white border-b border-gray-200 shadow-sm">
    <div class="px-4 sm:px-6 lg:px-8 h-14 sm:h-16 lg:h-20 flex items-center justify-between">
        <!-- Left side: Mobile menu toggle + Logo (Mobile) -->
        <div class="flex items-center gap-3 lg:hidden">
            <button onclick="toggleMobileMenu()" class="p-2 rounded-lg text-gray-600 hover:bg-gray-100 transition">
                <i class="fas fa-bars text-lg sm:text-xl"></i>
            </button>
            <div class="block lg:hidden">
                <h2 class="text-sm sm:text-base font-bold text-gray-900">SchoolPay</h2>
            </div>
        </div>

        <!-- Center: Page Title/Breadcrumb (Hidden on mobile) -->
        <div class="hidden sm:flex items-center space-x-2 text-sm lg:text-base text-gray-600 flex-1 lg:flex-none">
            <i class="fas fa-home text-blue-600"></i>
            <span class="hidden md:inline text-gray-900 font-medium">{{ request()->route()->getName() ?? 'Dashboard' }}</span>
        </div>

        <!-- Right side: Notifications + User Menu -->
        <div class="flex items-center gap-2 sm:gap-4">
            <!-- Notifications (Hidden on mobile, visible on tablet+) -->
            <div class="relative hidden sm:block">
                <button class="relative p-2 text-gray-600 hover:bg-gray-100 rounded-lg transition" onclick="toggleNotifications()">
                    <i class="fas fa-bell text-base lg:text-lg"></i>
                    @if($pendingPembayaranCount > 0 || $pendingTagihanCount > 0)
                    <span class="absolute top-0 right-0 h-2 w-2 bg-red-500 rounded-full animate-pulse"></span>
                    @endif
                </button>
                
                <!-- Notifications Dropdown (Mobile-responsive width) -->
                <div id="notifications-dropdown" class="hidden absolute right-0 mt-2 w-72 sm:w-80 bg-white rounded-lg shadow-xl border border-gray-100 z-50">
                    <div class="p-3 sm:p-4 border-b border-gray-100">
                        <h3 class="font-semibold text-gray-900 text-sm sm:text-base">Notifikasi</h3>
                    </div>
                    <div class="max-h-80 overflow-y-auto divide-y divide-gray-100">
                        @if($pendingPembayaranCount > 0)
                        <div class="p-3 sm:p-4 hover:bg-gray-50 cursor-pointer transition">
                            <div class="flex items-start gap-2 sm:gap-3">
                                <div class="p-2 bg-orange-100 rounded-lg flex-shrink-0">
                                    <i class="fas fa-exclamation text-orange-600 text-sm"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-gray-900 text-xs sm:text-sm">{{ $pendingPembayaranCount }} Pembayaran Pending</p>
                                    <p class="text-xs text-gray-500">Menunggu verifikasi</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($pendingTagihanCount > 0)
                        <div class="p-3 sm:p-4 hover:bg-gray-50 cursor-pointer transition">
                            <div class="flex items-start gap-2 sm:gap-3">
                                <div class="p-2 bg-red-100 rounded-lg flex-shrink-0">
                                    <i class="fas fa-receipt text-red-600 text-sm"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-gray-900 text-xs sm:text-sm">{{ $pendingTagihanCount }} Tagihan Belum Dibayar</p>
                                    <p class="text-xs text-gray-500">Perlu pembayaran</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($pendingPembayaranCount === 0 && $pendingTagihanCount === 0)
                        <div class="p-8 text-center">
                            <i class="fas fa-check-circle text-green-500 text-2xl sm:text-3xl mb-2"></i>
                            <p class="text-gray-600 text-xs sm:text-sm">Tidak ada notifikasi baru</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- User Menu -->
            <div class="relative">
                <button onclick="toggleUserMenu()" class="flex items-center gap-2 sm:gap-3 p-1 sm:p-2 rounded-lg hover:bg-gray-100 transition">
                    <div class="hidden sm:block text-right">
                        <p class="font-medium text-gray-900 text-xs sm:text-sm line-clamp-1">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500 capitalize hidden sm:block">{{ auth()->user()->role }}</p>
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
