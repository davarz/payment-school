<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - School Payment System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl w-full bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="flex flex-col md:flex-row">
            <!-- Welcome Section -->
            <div class="md:w-1/2 bg-gradient-to-br from-blue-600 to-blue-800 p-8 text-white">
                <div class="flex flex-col justify-center h-full">
                    <div class="mb-6">
                        <div class="h-16 w-16 bg-white/20 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-graduation-cap text-white text-2xl"></i>
                        </div>
                        <h1 class="text-3xl font-bold">Selamat Datang Kembali!</h1>
                        <p class="mt-2 text-blue-100">Masuk ke akun Anda untuk melanjutkan</p>
                    </div>
                    
                    <div class="space-y-4 mt-8">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-300 mr-3"></i>
                            <span class="text-blue-100">Akses tagihan dan pembayaran</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-300 mr-3"></i>
                            <span class="text-blue-100">Pantau riwayat transaksi</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-300 mr-3"></i>
                            <span class="text-blue-100">Kelola profil siswa</span>
                        </div>
                    </div>

                    <!-- Register Prompt -->
                    <div class="mt-12 p-4 bg-white/10 rounded-lg">
                        <p class="text-sm text-blue-100 mb-3">Belum punya akun?</p>
                        <a href="{{ route('register') }}" 
                           class="block w-full text-center py-2 px-4 border border-white text-white rounded-lg hover:bg-white hover:text-blue-600 transition duration-150 ease-in-out font-medium">
                            Daftar Sekarang
                        </a>
                    </div>
                </div>
            </div>

            <!-- Login Form Section -->
            <div class="md:w-1/2 p-8">
                <!-- Header -->
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-gray-900">School Payment System</h2>
                    <p class="mt-2 text-sm text-gray-600">Silakan login ke akun Anda</p>
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-3"></i>
                            <span class="text-green-700 text-sm">{{ session('status') }}</span>
                        </div>
                    </div>
                @endif

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>
                            <span class="text-red-700 text-sm">
                                {{ $errors->first() }}
                            </span>
                        </div>
                    </div>
                @endif

                <!-- Login Form -->
                <form class="space-y-6" action="{{ route('login') }}" method="POST">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                            Alamat Email
                        </label>
                        <div class="relative">
                            <input id="email" name="email" type="email" required 
                                   class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-lg placeholder-gray-400 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out"
                                   placeholder="masukkan email Anda"
                                   value="{{ old('email') }}"
                                   autocomplete="email"
                                   autofocus>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                            Password
                        </label>
                        <div class="relative">
                            <input id="password" name="password" type="password" required 
                                   class="appearance-none block w-full px-3 py-3 pr-10 border border-gray-300 rounded-lg placeholder-gray-400 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out"
                                   placeholder="masukkan password"
                                   autocomplete="current-password">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <button type="button" class="password-toggle text-gray-400 hover:text-gray-600 transition duration-150">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <label class="flex items-center">
                            <input type="checkbox" name="remember" 
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                        </label>

                        <a href="{{ route('password.request') }}" 
                           class="text-sm text-blue-600 hover:text-blue-500">
                            Lupa password?
                        </a>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit" 
                                class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                <i class="fas fa-sign-in-alt text-blue-300"></i>
                            </span>
                            Login
                        </button>
                    </div>
                </form>

                <!-- Register Link for Mobile -->
                <div class="mt-6 text-center md:hidden">
                    <p class="text-sm text-gray-600">
                        Belum punya akun? 
                        <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-500 font-medium">
                            Daftar di sini
                        </a>
                    </p>
                </div>

                <!-- Footer -->
                <div class="mt-6 text-center">
                    <p class="text-xs text-gray-500">
                        © 2024 School Payment System. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Show/Hide Password Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const passwordToggle = document.querySelector('.password-toggle');
            
            if (passwordToggle) {
                passwordToggle.addEventListener('click', function() {
                    const input = this.closest('.relative').querySelector('input');
                    const icon = this.querySelector('i');
                    
                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                        this.classList.add('text-blue-500');
                    } else {
                        input.type = 'password';
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                        this.classList.remove('text-blue-500');
                    }
                    
                    // Focus back to input for better UX
                    input.focus();
                });
            }

            // Real-time validation feedback
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');

            function validateEmail() {
                const email = emailInput.value;
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                
                if (email && !emailRegex.test(email)) {
                    emailInput.classList.add('border-red-300');
                } else {
                    emailInput.classList.remove('border-red-300');
                }
            }

            function validatePassword() {
                const password = passwordInput.value;
                
                if (password && password.length < 1) {
                    passwordInput.classList.add('border-red-300');
                } else {
                    passwordInput.classList.remove('border-red-300');
                }
            }

            if (emailInput) {
                emailInput.addEventListener('input', validateEmail);
                emailInput.addEventListener('blur', validateEmail);
            }

            if (passwordInput) {
                passwordInput.addEventListener('input', validatePassword);
                passwordInput.addEventListener('blur', validatePassword);
            }
        });
    </script>
</body>
</html>