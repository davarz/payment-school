<!-- Responsive Mobile & Desktop Navbar for Siswa -->
<nav class="sticky top-0 z-40 bg-white/95 backdrop-blur-lg border-b border-gray-100/50 shadow-sm">
    <div class="px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
        <!-- Left: Logo & Brand -->
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-blue-700 rounded-lg flex items-center justify-center shadow-sm">
                <i class="fas fa-graduation-cap text-white text-lg"></i>
            </div>
            <div class="hidden sm:block">
                <h1 class="font-bold text-gray-900">SchoolPay</h1>
                <p class="text-xs text-gray-500">Portal Siswa</p>
            </div>
        </div>

        <!-- Center: Navigation Links (Desktop Only) -->
        <div class="hidden md:flex items-center space-x-1">
            <a href="{{ route('siswa.dashboard') }}" class="px-4 py-2 text-gray-700 hover:text-blue-600 font-medium transition {{ request()->routeIs('siswa.dashboard') ? 'text-blue-600 border-b-2 border-blue-600' : '' }}">
                <i class="fas fa-home mr-2"></i> Dashboard
            </a>
            <a href="{{ route('siswa.tagihan.index') }}" class="px-4 py-2 text-gray-700 hover:text-blue-600 font-medium transition {{ request()->routeIs('siswa.tagihan.*') ? 'text-blue-600 border-b-2 border-blue-600' : '' }}">
                <i class="fas fa-receipt mr-2"></i> Tagihan
            </a>
            <a href="{{ route('siswa.transaksi.index') }}" class="px-4 py-2 text-gray-700 hover:text-blue-600 font-medium transition {{ request()->routeIs('siswa.transaksi.*') ? 'text-blue-600 border-b-2 border-blue-600' : '' }}">
                <i class="fas fa-history mr-2"></i> Riwayat
            </a>
        </div>

        <!-- Right: Notifications & User Menu -->
        <div class="flex items-center space-x-4">
            <!-- Mobile Menu Button -->
            <button onclick="toggleMobileMenu()" class="md:hidden p-2 text-gray-600 hover:bg-gray-100 rounded-lg transition">
                <i class="fas fa-bars text-xl"></i>
            </button>

            <!-- Notifications -->
            <div class="relative hidden sm:block">
                <button class="relative p-2 text-gray-600 hover:bg-gray-100 rounded-lg transition" onclick="toggleNotifications()">
                    <i class="fas fa-bell text-lg"></i>
                    @if($pendingTagihanCount > 0)
                    <span class="absolute top-1 right-1 h-2 w-2 bg-red-500 rounded-full animate-pulse"></span>
                    @endif
                </button>
                
                <!-- Notifications Dropdown -->
                <div id="notifications-dropdown" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl border border-gray-100 z-50">
                    <div class="p-4 border-b border-gray-100">
                        <h3 class="font-semibold text-gray-900">Notifikasi</h3>
                    </div>
                    <div class="max-h-96 overflow-y-auto">
                        @if($pendingTagihanCount > 0)
                        <div class="p-4 border-b border-gray-50 hover:bg-gray-50 cursor-pointer transition">
                            <div class="flex items-start space-x-3">
                                <div class="p-2 bg-orange-100 rounded-lg">
                                    <i class="fas fa-exclamation text-orange-600"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium text-gray-900">{{ $pendingTagihanCount }} Tagihan Belum Dibayar</p>
                                    <p class="text-xs text-gray-500">Segera lakukan pembayaran</p>
                                </div>
                            </div>
                        </div>
                        @else
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
                <button onclick="toggleUserMenu()" class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100 transition">
                    <div class="hidden sm:block text-right">
                        <p class="font-medium text-gray-900 text-sm">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500">Siswa</p>
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
                    <a href="{{ route('siswa.dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-50 text-sm transition md:hidden">
                        <i class="fas fa-home mr-2"></i> Dashboard
                    </a>
                    <a href="{{ route('siswa.tagihan.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-50 text-sm transition md:hidden">
                        <i class="fas fa-receipt mr-2"></i> Tagihan
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

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden border-t border-gray-200 bg-gray-50">
        <div class="px-4 py-3 space-y-2">
            <a href="{{ route('siswa.dashboard') }}" class="block px-4 py-2 text-gray-700 hover:text-blue-600 rounded-lg hover:bg-blue-50 transition">
                <i class="fas fa-home mr-2"></i> Dashboard
            </a>
            <a href="{{ route('siswa.tagihan.index') }}" class="block px-4 py-2 text-gray-700 hover:text-blue-600 rounded-lg hover:bg-blue-50 transition">
                <i class="fas fa-receipt mr-2"></i> Tagihan
            </a>
            <a href="{{ route('siswa.transaksi.index') }}" class="block px-4 py-2 text-gray-700 hover:text-blue-600 rounded-lg hover:bg-blue-50 transition">
                <i class="fas fa-history mr-2"></i> Riwayat
            </a>
        </div>
    </div>
</nav>

<script>
    function toggleMobileMenu() {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    }

    function toggleNotifications() {
        const dropdown = document.getElementById('notifications-dropdown');
        dropdown.classList.toggle('hidden');
        document.getElementById('user-menu').classList.add('hidden');
    }

    function toggleUserMenu() {
        const menu = document.getElementById('user-menu');
        menu.classList.toggle('hidden');
        document.getElementById('notifications-dropdown')?.classList.add('hidden');
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
                <!-- Mobile Menu Button -->
                <button id="siswa-mobile-menu-button" class="lg:hidden p-2 rounded-lg text-gray-700 hover:bg-gray-100">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div id="siswa-mobile-menu" class="lg:hidden border-t border-gray-200 hidden">
            <div class="py-4 space-y-1">
                <!-- Mobile Navigation Links -->
                <a href="{{ route('siswa.dashboard') }}"
                   class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg font-medium {{ request()->routeIs('siswa.dashboard') ? 'bg-blue-50 text-blue-600' : '' }}">
                    <i class="fas fa-tachometer-alt mr-3 text-blue-500"></i>
                    Dashboard
                </a>
                <a href="{{ route('siswa.tagihan.index') }}"
                   class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg font-medium {{ request()->routeIs('siswa.tagihan') ? 'bg-blue-50 text-blue-600' : '' }}">
                    <i class="fas fa-receipt mr-3 text-blue-500"></i>
                    Tagihan
                </a>
                <a href="{{ route('siswa.transaksi.index') }}"
                   class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg font-medium {{ request()->routeIs('siswa.transaksi') ? 'bg-blue-50 text-blue-600' : '' }}">
                    <i class="fas fa-history mr-3 text-blue-500"></i>
                    Riwayat
                </a>
                <a href="{{ route('siswa.profile.show') }}"
                   class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg font-medium {{ request()->routeIs('siswa.profile.*') ? 'bg-blue-50 text-blue-600' : '' }}">
                    <i class="fas fa-user mr-3 text-blue-500"></i>
                    Profile
                </a>

                <!-- Mobile User Info -->
                <div class="pt-4 border-t border-gray-200 mt-4">
                    <div class="flex items-center space-x-3 px-4 py-3 bg-gray-50 rounded-lg">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-semibold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-gray-900">{{ auth()->user()->name }}</p>
                            <p class="text-gray-500 text-sm">Siswa • {{ auth()->user()->kelas ?? 'Kelas' }}</p>
                        </div>
                    </div>

                    <!-- Mobile Logout -->
                    <form method="POST" action="{{ route('logout') }}" class="mt-3 px-4">
                        @csrf
                        <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2.5 px-4 rounded-lg font-medium transition-colors duration-200">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Student navbar mobile menu functionality
    const mobileMenu = document.getElementById('siswa-mobile-menu');
    const mobileMenuButton = document.getElementById('siswa-mobile-menu-button');

    function toggleMobileMenu() {
        const isHidden = mobileMenu.classList.contains('hidden');

        if (isHidden) {
            // Show menu
            mobileMenu.classList.remove('hidden');
            mobileMenuButton.innerHTML = '<i class="fas fa-times"></i>';
        } else {
            // Hide menu
            mobileMenu.classList.add('hidden');
            mobileMenuButton.innerHTML = '<i class="fas fa-bars"></i>';
        }
    }

    function closeMobileMenu() {
        mobileMenu.classList.add('hidden');
        mobileMenuButton.innerHTML = '<i class="fas fa-bars"></i>';
    }

    // Event listeners
    if (mobileMenuButton) {
        mobileMenuButton.addEventListener('click', function(e) {
            e.stopPropagation();
            toggleMobileMenu();
        });
    }

    // Close menu when clicking outside
    document.addEventListener('click', function(e) {
        const isClickInsideNav = mobileMenu.contains(e.target) || mobileMenuButton.contains(e.target);

        if (!isClickInsideNav && !mobileMenu.classList.contains('hidden')) {
            closeMobileMenu();
        }
    });

    // Close menu when window is resized to large screen
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 1024) { // lg breakpoint
            closeMobileMenu();
        }
    });
});
</script>