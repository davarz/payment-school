<nav class="bg-white sticky top-0 z-50 shadow-sm border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('siswa.dashboard') }}" class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-graduation-cap text-white text-lg"></i>
                    </div>
                    <span class="text-2xl font-bold text-gray-900">SchoolPay</span>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center space-x-8">
                <a href="{{ route('siswa.dashboard') }}" 
                   class="text-gray-700 hover:text-blue-600 font-medium transition-colors duration-200 {{ request()->routeIs('siswa.dashboard') ? 'text-blue-600' : '' }}">
                    Dashboard
                </a>
                <a href="{{ route('siswa.tagihan') }}" 
                   class="text-gray-700 hover:text-blue-600 font-medium transition-colors duration-200 {{ request()->routeIs('siswa.tagihan') ? 'text-blue-600' : '' }}">
                    Tagihan
                </a>
                <a href="{{ route('siswa.transaksi') }}" 
                   class="text-gray-700 hover:text-blue-600 font-medium transition-colors duration-200 {{ request()->routeIs('siswa.transaksi') ? 'text-blue-600' : '' }}">
                    Riwayat
                </a>
                <a href="{{ route('siswa.profile.show') }}" 
                   class="text-gray-700 hover:text-blue-600 font-medium transition-colors duration-200 {{ request()->routeIs('siswa.profile.*') ? 'text-blue-600' : '' }}">
                    Profile
                </a>
            </div>

            <!-- Right Section -->
            <div class="flex items-center space-x-4">
                <!-- User Info Desktop -->
                <div class="hidden md:flex items-center space-x-3">
                    <div class="w-9 h-9 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-semibold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="text-sm">
                        <p class="font-medium text-gray-900">{{ auth()->user()->name }}</p>
                        <p class="text-gray-500">Siswa</p>
                    </div>
                </div>

                <!-- Logout Button Desktop -->
                <form method="POST" action="{{ route('logout') }}" class="hidden md:block">
                    @csrf
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-medium transition-colors duration-200">
                        Logout
                    </button>
                </form>

                <!-- Mobile Menu Button -->
                <button @click="open = !open" class="lg:hidden p-2 rounded-lg text-gray-700 hover:bg-gray-100">
                    <i class="fas fa-bars text-xl" :class="{ 'fa-times': open }"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div class="lg:hidden border-t border-gray-200 py-4" x-show="open" x-transition>
            <div class="space-y-4">
                <!-- Mobile Navigation Links -->
                <div class="space-y-2">
                    <a href="{{ route('siswa.dashboard') }}" @click="open = false"
                       class="block py-2.5 px-4 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg font-medium {{ request()->routeIs('siswa.dashboard') ? 'bg-blue-50 text-blue-600' : '' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('siswa.tagihan') }}" @click="open = false"
                       class="block py-2.5 px-4 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg font-medium {{ request()->routeIs('siswa.tagihan') ? 'bg-blue-50 text-blue-600' : '' }}">
                        Tagihan
                    </a>
                    <a href="{{ route('siswa.transaksi') }}" @click="open = false"
                       class="block py-2.5 px-4 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg font-medium {{ request()->routeIs('siswa.transaksi') ? 'bg-blue-50 text-blue-600' : '' }}">
                        Riwayat
                    </a>
                    <a href="{{ route('siswa.profile.show') }}" @click="open = false"
                       class="block py-2.5 px-4 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg font-medium {{ request()->routeIs('siswa.profile.*') ? 'bg-blue-50 text-blue-600' : '' }}">
                        Profile
                    </a>
                </div>

                <!-- Mobile User Info -->
                <div class="pt-4 border-t border-gray-200">
                    <div class="flex items-center space-x-3 px-4 py-3 bg-gray-50 rounded-lg">
                        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-semibold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-gray-900">{{ auth()->user()->name }}</p>
                            <p class="text-gray-500 text-sm">Siswa • {{ auth()->user()->kelas ?? 'Kelas' }}</p>
                        </div>
                    </div>
                    
                    <!-- Mobile Logout -->
                    <form method="POST" action="{{ route('logout') }}" class="mt-3">
                        @csrf
                        <button type="submit" @click="open = false"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2.5 px-4 rounded-lg font-medium transition-colors duration-200">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>