@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<div class="w-full max-w-5xl mx-auto">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-0 rounded-2xl overflow-hidden shadow-2xl">
        <!-- Welcome Sidebar -->
        <div class="hidden lg:flex bg-gradient-to-br from-blue-600 to-blue-800 text-white p-12 flex-col justify-center">
            <div class="mb-8">
                <div class="h-16 w-16 bg-white/20 rounded-full flex items-center justify-center mb-6 backdrop-blur">
                    <i class="fas fa-graduation-cap text-white text-2xl"></i>
                </div>
                <h1 class="text-4xl font-bold mb-3">Selamat Datang Kembali!</h1>
                <p class="text-blue-100 text-lg">Kelola pembayaran dan siswa dengan mudah</p>
            </div>
            
            <div class="space-y-4 mb-12">
                <div class="flex items-start space-x-3">
                    <div class="p-2 bg-white/20 rounded-lg flex-shrink-0">
                        <i class="fas fa-receipt text-white"></i>
                    </div>
                    <div>
                        <p class="font-semibold">Kelola Pembayaran</p>
                        <p class="text-blue-100 text-sm">Pantau dan verifikasi pembayaran siswa</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <div class="p-2 bg-white/20 rounded-lg flex-shrink-0">
                        <i class="fas fa-chart-bar text-white"></i>
                    </div>
                    <div>
                        <p class="font-semibold">Laporan Lengkap</p>
                        <p class="text-blue-100 text-sm">Akses data dan analisis mendalam</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <div class="p-2 bg-white/20 rounded-lg flex-shrink-0">
                        <i class="fas fa-users text-white"></i>
                    </div>
                    <div>
                        <p class="font-semibold">Manajemen Siswa</p>
                        <p class="text-blue-100 text-sm">Kelola data dan profil siswa</p>
                    </div>
                </div>
            </div>

            <div class="p-6 bg-white/10 rounded-xl backdrop-blur border border-white/20">
                <p class="text-sm text-blue-100 mb-4">Belum punya akun?</p>
                <a href="{{ route('register') }}" class="block w-full text-center py-3 px-4 border border-white text-white rounded-lg hover:bg-white hover:text-blue-600 transition duration-200 font-semibold">
                    Daftar Sekarang
                </a>
            </div>
        </div>

        <!-- Form Section -->
        <div class="bg-white p-8 sm:p-10 lg:p-12 flex flex-col justify-center">
            <!-- Mobile Header -->
            <div class="lg:hidden text-center mb-8">
                <div class="h-12 w-12 bg-blue-600 rounded-lg flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-graduation-cap text-white text-lg"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-900">Selamat Datang!</h1>
                <p class="text-gray-600 mt-2">Masuk ke akun Anda</p>
            </div>

            <!-- Desktop Header -->
            <div class="hidden lg:block mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Masuk ke Akun</h2>
                <p class="text-gray-600">Gunakan email dan password Anda</p>
            </div>

            @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg flex items-start" data-alert-close>
                <i class="fas fa-exclamation-circle text-red-500 mt-0.5 mr-3 flex-shrink-0"></i>
                <div class="flex-1">
                    <p class="text-red-700 font-medium">Login Gagal!</p>
                    <p class="text-red-600 text-sm mt-1">Periksa kembali email dan password Anda.</p>
                </div>
                <button type="button" data-dismiss="alert" class="text-red-400 hover:text-red-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            @endif

            @if (session('status'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-start" data-alert-close>
                <i class="fas fa-check-circle text-green-500 mt-0.5 mr-3 flex-shrink-0"></i>
                <p class="text-green-700 text-sm">{{ session('status') }}</p>
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input 
                        id="email"
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}"
                        placeholder="nama@contoh.com"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150"
                    />
                    @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input 
                            id="password"
                            type="password" 
                            name="password" 
                            placeholder="Masukkan password Anda"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150"
                        />
                        <button type="button" class="password-toggle absolute right-4 top-3 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Ingat saya</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                        Lupa password?
                    </a>
                </div>

                <button type="submit" class="w-full py-3 px-4 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition duration-200 shadow-sm hover:shadow-md flex items-center justify-center space-x-2">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Masuk</span>
                </button>
            </form>

            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-500">atau</span>
                </div>
            </div>

            <p class="text-center text-sm text-gray-600">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-700 font-medium">
                    Daftar di sini
                </a>
            </p>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const passwordToggle = document.querySelector('.password-toggle');
        if (passwordToggle) {
            passwordToggle.addEventListener('click', function(e) {
                e.preventDefault();
                const input = this.closest('div').querySelector('input');
                const icon = this.querySelector('i');
                
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        }
    });
</script>
@endsection