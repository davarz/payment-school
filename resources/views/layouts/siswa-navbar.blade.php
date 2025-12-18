<nav class="bg-white sticky top-0 z-50 shadow-sm border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('siswa.dashboard') }}" class="flex items-center space-x-2 sm:space-x-3">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-blue-600 to-blue-500 rounded-lg flex items-center justify-center shadow-sm">
                        <i class="fas fa-graduation-cap text-white text-base sm:text-lg"></i>
                    </div>
                    <span class="text-base sm:text-xl font-bold text-gray-900 hidden sm:block">SchoolPay</span>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center space-x-6 sm:space-x-8">
                <a href="{{ route('siswa.dashboard') }}"
                   class="text-gray-700 hover:text-blue-600 font-medium transition-colors duration-200 {{ request()->routeIs('siswa.dashboard') ? 'text-blue-600' : '' }}">
                    <span class="hidden sm:inline">Dashboard</span>
                    <span class="sm:hidden"><i class="fas fa-tachometer-alt"></i></span>
                </a>
                <a href="{{ route('siswa.tagihan.index') }}"
                   class="text-gray-700 hover:text-blue-600 font-medium transition-colors duration-200 {{ request()->routeIs('siswa.tagihan') ? 'text-blue-600' : '' }}">
                    <span class="hidden sm:inline">Tagihan</span>
                    <span class="sm:hidden"><i class="fas fa-receipt"></i></span>
                </a>
                <a href="{{ route('siswa.transaksi.index') }}"
                   class="text-gray-700 hover:text-blue-600 font-medium transition-colors duration-200 {{ request()->routeIs('siswa.transaksi') ? 'text-blue-600' : '' }}">
                    <span class="hidden sm:inline">Riwayat</span>
                    <span class="sm:hidden"><i class="fas fa-history"></i></span>
                </a>
                <a href="{{ route('siswa.profile.show') }}"
                   class="text-gray-700 hover:text-blue-600 font-medium transition-colors duration-200 {{ request()->routeIs('siswa.profile.*') ? 'text-blue-600' : '' }}">
                    <span class="hidden sm:inline">Profile</span>
                    <span class="sm:hidden"><i class="fas fa-user"></i></span>
                </a>
            </div>

            <!-- Right Section -->
            <div class="flex items-center space-x-2 sm:space-x-4">
                <!-- User Info Desktop -->
                <div class="hidden md:flex items-center space-x-2 sm:space-x-3">
                    <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-semibold text-xs sm:text-sm shadow-sm">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="hidden sm:block">
                        <p class="text-xs sm:text-sm font-medium text-gray-900 max-w-[80px] truncate">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] sm:text-xs text-gray-500">Siswa</p>
                    </div>
                </div>

                <!-- Logout Button Desktop -->
                <form method="POST" action="{{ route('logout') }}" class="hidden sm:block">
                    @csrf
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-3 sm:px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                        <span class="hidden sm:inline">Logout</span>
                        <span class="sm:hidden"><i class="fas fa-sign-out-alt"></i></span>
                    </button>
                </form>

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