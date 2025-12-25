<!-- Top Navigation Bar -->
<nav class="sticky top-0 z-40 bg-white/95 backdrop-blur-lg border-b border-gray-100/50 shadow-sm">
    <div class="px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
        <!-- Left side: Mobile menu toggle -->
        <div class="flex items-center">
            <button onclick="toggleMobileMenu()" class="lg:hidden p-2 rounded-lg text-gray-600 hover:bg-gray-100 transition">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </div>

        <!-- Center: Breadcrumb or Title -->
        <div class="hidden md:flex items-center space-x-2 text-sm text-gray-600">
            <i class="fas fa-home text-blue-600"></i>
            <span>{{ request()->route()->getName() ?? 'Dashboard' }}</span>
        </div>

        <!-- Right side: User info and notifications -->
        <div class="flex items-center space-x-4">
            <!-- Notifications -->
            <div class="relative hidden sm:block">
                <button class="relative p-2 text-gray-600 hover:bg-gray-100 rounded-lg transition" onclick="toggleNotifications()">
                    <i class="fas fa-bell text-lg"></i>
                    @if($pendingPembayaranCount > 0 || $pendingTagihanCount > 0)
                    <span class="absolute top-1 right-1 h-2 w-2 bg-red-500 rounded-full animate-pulse"></span>
                    @endif
                </button>
                
                <!-- Notifications Dropdown -->
                <div id="notifications-dropdown" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl border border-gray-100 z-50">
                    <div class="p-4 border-b border-gray-100">
                        <h3 class="font-semibold text-gray-900">Notifikasi</h3>
                    </div>
                    <div class="max-h-96 overflow-y-auto">
                        @if($pendingPembayaranCount > 0)
                        <div class="p-4 border-b border-gray-50 hover:bg-gray-50 cursor-pointer transition">
                            <div class="flex items-start space-x-3">
                                <div class="p-2 bg-orange-100 rounded-lg">
                                    <i class="fas fa-exclamation text-orange-600"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium text-gray-900">{{ $pendingPembayaranCount }} Pembayaran Pending</p>
                                    <p class="text-xs text-gray-500">Menunggu verifikasi Anda</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($pendingTagihanCount > 0)
                        <div class="p-4 hover:bg-gray-50 cursor-pointer transition">
                            <div class="flex items-start space-x-3">
                                <div class="p-2 bg-red-100 rounded-lg">
                                    <i class="fas fa-receipt text-red-600"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium text-gray-900">{{ $pendingTagihanCount }} Tagihan Belum Dibayar</p>
                                    <p class="text-xs text-gray-500">Tagihan menunggu pembayaran</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($pendingPembayaranCount === 0 && $pendingTagihanCount === 0)
                        <div class="p-8 text-center">
                            <i class="fas fa-check-circle text-green-500 text-3xl mb-2"></i>
                            <p class="text-gray-600 text-sm">Tidak ada notifikasi baru</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- User Menu -->
            <div class="relative">
                <button onclick="toggleUserMenu()" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-100 transition">
                    <div class="hidden sm:block text-right">
                        <p class="font-medium text-gray-900 text-sm">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500 capitalize">{{ auth()->user()->role }}</p>
                    </div>
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&color=3B82F6&background=DBEAFE" 
                         alt="{{ auth()->user()->name }}" class="w-9 h-9 rounded-full">
                </button>

                <!-- User Dropdown Menu -->
                <div id="user-menu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-100 z-50">
                    <div class="p-4 border-b border-gray-100">
                        <p class="font-medium text-gray-900">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-50 text-sm transition">
                        <i class="fas fa-user-circle mr-2"></i> Profil
                    </a>
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-50 text-sm transition">
                        <i class="fas fa-cog mr-2"></i> Pengaturan
                    </a>
                    <hr class="my-2">
                    <form method="POST" action="{{ route('logout') }}" class="block">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 text-sm transition">
                            <i class="fas fa-sign-out-alt mr-2"></i> Keluar
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
        dropdown.classList.toggle('hidden');
        document.getElementById('user-menu').classList.add('hidden');
    }

    function toggleUserMenu() {
        const menu = document.getElementById('user-menu');
        menu.classList.toggle('hidden');
        document.getElementById('notifications-dropdown').classList.add('hidden');
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(event) {
        const notifications = document.getElementById('notifications-dropdown');
        const userMenu = document.getElementById('user-menu');
        
        if (event.target.closest('.relative') === null) {
            notifications?.classList.add('hidden');
            userMenu?.classList.add('hidden');
        }
    });
</script>
