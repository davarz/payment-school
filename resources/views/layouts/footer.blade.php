<!-- Footer -->
<footer class="border-t border-gray-200 bg-gradient-to-r from-gray-50 to-blue-50 mt-12 sm:mt-16 lg:mt-20">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
            <!-- Brand -->
            <div class="space-y-4">
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-gradient-to-br from-blue-600 to-blue-700 rounded-lg flex items-center justify-center shadow-sm">
                        <i class="fas fa-graduation-cap text-white text-sm"></i>
                    </div>
                    <span class="font-semibold text-gray-900">SchoolPay</span>
                </div>
                <p class="text-sm text-gray-600">Sistem pembayaran sekolah yang aman, cepat, dan terpercaya.</p>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="font-semibold text-gray-900 mb-4">Akses Cepat</h3>
                <ul class="space-y-2 text-sm">
                    @if(auth()->user()->isAdmin() || auth()->user()->isOperator())
                        <li><a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-blue-600 transition">Dashboard</a></li>
                        <li><a href="{{ route('admin.pembayaran.index') }}" class="text-gray-600 hover:text-blue-600 transition">Pembayaran</a></li>
                        <li><a href="{{ route('admin.tagihan.index') }}" class="text-gray-600 hover:text-blue-600 transition">Tagihan</a></li>
                        <li><a href="{{ route('admin.siswa.index') }}" class="text-gray-600 hover:text-blue-600 transition">Data Siswa</a></li>
                    @else
                        <li><a href="{{ route('siswa.dashboard') }}" class="text-gray-600 hover:text-blue-600 transition">Dashboard</a></li>
                        <li><a href="{{ route('siswa.tagihan.index') }}" class="text-gray-600 hover:text-blue-600 transition">Tagihan Saya</a></li>
                        <li><a href="{{ route('siswa.transaksi.index') }}" class="text-gray-600 hover:text-blue-600 transition">Riwayat Transaksi</a></li>
                        <li><a href="{{ route('profile.edit') }}" class="text-gray-600 hover:text-blue-600 transition">Profil Saya</a></li>
                    @endif
                </ul>
            </div>

            <!-- Help -->
            <div>
                <h3 class="font-semibold text-gray-900 mb-4">Bantuan</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="text-gray-600 hover:text-blue-600 transition">FAQ</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-blue-600 transition">Hubungi Kami</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-blue-600 transition">Kebijakan Privasi</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-blue-600 transition">Syarat & Ketentuan</a></li>
                </ul>
            </div>

            <!-- Info -->
            <div>
                <h3 class="font-semibold text-gray-900 mb-4">Informasi</h3>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li class="flex items-center space-x-2">
                        <i class="fas fa-map-marker-alt w-4 text-blue-600"></i>
                        <span>Jl. Pendidikan No. 1</span>
                    </li>
                    <li class="flex items-center space-x-2">
                        <i class="fas fa-phone w-4 text-blue-600"></i>
                        <span>(021) 1234-5678</span>
                    </li>
                    <li class="flex items-center space-x-2">
                        <i class="fas fa-envelope w-4 text-blue-600"></i>
                        <span>info@school.id</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Divider -->
        <div class="border-t border-gray-200 pt-8">
            <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
                <p class="text-sm text-gray-600">&copy; 2025 SchoolPay. All rights reserved.</p>
                <div class="flex items-center space-x-6">
                    <a href="#" class="text-gray-600 hover:text-blue-600 transition">
                        <i class="fab fa-facebook text-lg"></i>
                    </a>
                    <a href="#" class="text-gray-600 hover:text-blue-600 transition">
                        <i class="fab fa-twitter text-lg"></i>
                    </a>
                    <a href="#" class="text-gray-600 hover:text-blue-600 transition">
                        <i class="fab fa-instagram text-lg"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>
