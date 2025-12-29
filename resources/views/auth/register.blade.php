@extends('layouts.guest')

@section('title', 'Daftar')

@section('content')
<div class="w-full max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 sm:px-8 py-8 sm:py-12">
            <div class="text-center">
                <div class="h-16 w-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4 backdrop-blur">
                    <i class="fas fa-user-plus text-white text-2xl"></i>
                </div>
                <h1 class="text-3xl font-bold text-white mb-2">Daftar Akun Baru</h1>
                <p class="text-blue-100">Bergabung dengan sistem pembayaran sekolah kami</p>
            </div>
        </div>

        <!-- Form -->
        <div class="px-6 sm:px-8 py-8 sm:py-12">
            @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg" data-alert-close>
                <div class="flex items-start">
                    <i class="fas fa-exclamation-circle text-red-500 mt-0.5 mr-3 flex-shrink-0"></i>
                    <div class="flex-1">
                        <p class="text-red-700 font-medium mb-2">Daftar Gagal!</p>
                        <ul class="list-disc list-inside text-red-600 text-sm space-y-1">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" data-dismiss="alert" class="text-red-400 hover:text-red-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <!-- Full Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input 
                        id="name"
                        type="text" 
                        name="name" 
                        value="{{ old('name') }}"
                        placeholder="Contoh: Ahmad Wijaya"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150"
                    />
                    @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input 
                            id="email"
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}"
                            placeholder="nama@sekolah.com"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150"
                        />
                        <span id="email-check-loader" class="hidden absolute right-3 top-3 text-gray-400">
                            <i class="fas fa-spinner fa-spin"></i>
                        </span>
                        <span id="email-check-icon" class="hidden absolute right-3 top-3"></span>
                    </div>
                    <div id="email-error" class="hidden text-red-500 text-sm mt-1 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i>
                        <span id="email-error-text"></span>
                    </div>
                    @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input
                            id="password"
                            type="password"
                            name="password"
                            placeholder="Buat password yang kuat (minimal 8 karakter)"
                            required
                            class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150"
                        />
                        <span id="password-check-icon" class="hidden absolute right-10 top-3"></span>
                        <button type="button" class="password-toggle absolute right-3 top-3 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    
                    <!-- Password Strength Indicator -->
                    
                    <p class="text-gray-600 text-xs mt-2">Minimal 8 karakter dengan huruf dan angka</p>
                    @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Confirmation -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        Konfirmasi Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            placeholder="Ketikkan password lagi"
                            required
                            class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150"
                        />
                        <span id="password-confirmation-check-icon" class="hidden absolute right-10 top-3"></span>
                        <button type="button" class="password-toggle absolute right-3 top-3 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('password_confirmation')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Terms & Conditions -->
                <div class="flex items-start space-x-3 pt-4">
                    <input 
                        type="checkbox" 
                        name="agree" 
                        id="agree" 
                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 cursor-pointer mt-1"
                        required
                    >
                    <label for="agree" class="text-sm text-gray-700 cursor-pointer">
                        Saya setuju dengan 
                        <a href="#" class="text-blue-600 hover:text-blue-700 font-medium">Syarat & Ketentuan</a> 
                        dan 
                        <a href="#" class="text-blue-600 hover:text-blue-700 font-medium">Kebijakan Privasi</a>
                    </label>
                </div>

                <!-- Register Button -->
                <button 
                    type="submit" 
                    class="w-full py-3 px-4 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition duration-200 shadow-sm hover:shadow-md flex items-center justify-center space-x-2 mt-8"
                >
                    <i class="fas fa-user-plus"></i>
                    <span>Daftar Sekarang</span>
                </button>
            </form>

            <!-- Divider -->
            <div class="relative my-8">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-500">atau</span>
                </div>
            </div>

            <!-- Login Link -->
            <p class="text-center text-sm text-gray-600">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 font-medium">
                    Login di sini
                </a>
            </p>
        </div>
    </div>

    <!-- Info Box -->
    <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
        <div class="flex items-start space-x-3">
            <i class="fas fa-info-circle text-blue-600 mt-0.5 flex-shrink-0"></i>
            <div class="text-sm text-blue-800">
                <p class="font-medium mb-1">Informasi Penting</p>
                <p>Pastikan email yang Anda gunakan masih aktif. Email akan digunakan untuk verifikasi dan reset password.</p>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const passwordToggles = document.querySelectorAll('.password-toggle');
        
        passwordToggles.forEach(toggle => {
            toggle.addEventListener('click', function(e) {
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
        });

        // Real-time email validation
        const emailInput = document.getElementById('email');
        const emailCheckLoader = document.getElementById('email-check-loader');
        const emailCheckIcon = document.getElementById('email-check-icon');
        const emailError = document.getElementById('email-error');
        const emailErrorText = document.getElementById('email-error-text');
        let checkTimeout;

        if (emailInput) {
            emailInput.addEventListener('input', function () {
                const email = this.value.trim();
                
                clearTimeout(checkTimeout);
                
                emailCheckLoader.classList.add('hidden');
                emailCheckIcon.classList.add('hidden');
                emailError.classList.add('hidden');
                
                if (!email) return;
                
                emailCheckLoader.classList.remove('hidden');
                
                checkTimeout = setTimeout(() => {
                    fetch(`/check-email?email=${encodeURIComponent(email)}`)
                        .then(response => response.json())
                        .then(data => {
                            emailCheckLoader.classList.add('hidden');
                            
                            if (data.available) {
                                emailCheckIcon.innerHTML = '<i class="fas fa-check-circle text-green-500"></i>';
                                emailCheckIcon.classList.remove('hidden');
                                emailError.classList.add('hidden');
                                emailInput.classList.remove('border-red-500');
                                emailInput.classList.add('border-green-500');
                            } else {
                                emailCheckIcon.classList.add('hidden');
                                emailErrorText.textContent = 'Email sudah terdaftar di sistem';
                                emailError.classList.remove('hidden');
                                emailInput.classList.remove('border-green-500');
                                emailInput.classList.add('border-red-500');
                            }
                        })
                        .catch(error => {
                            console.error('Error checking email:', error);
                            emailCheckLoader.classList.add('hidden');
                        });
                }, 500);
            });
        }

        // Real-time password validation
        const passwordInput = document.getElementById('password');
        const passwordCheckIcon = document.getElementById('password-check-icon');

        if (passwordInput) {
            passwordInput.addEventListener('input', function () {
                const password = this.value;
                const length = password.length;
                const minLength = 8;

                // Update icon dan border
                if (length >= minLength) {
                    passwordCheckIcon.innerHTML = '<i class="fas fa-check text-green-500"></i>';
                    passwordCheckIcon.classList.remove('hidden');
                    passwordInput.classList.remove('border-red-500', 'border-gray-300');
                    passwordInput.classList.add('border-green-500');
                } else if (length > 0) {
                    passwordCheckIcon.classList.add('hidden');
                    passwordInput.classList.remove('border-green-500', 'border-gray-300');
                    passwordInput.classList.add('border-red-500');
                } else {
                    passwordCheckIcon.classList.add('hidden');
                    passwordInput.classList.remove('border-red-500', 'border-green-500');
                    passwordInput.classList.add('border-gray-300');
                }
            });
        }

        // Real-time password confirmation validation
        const passwordConfirmationInput = document.getElementById('password_confirmation');
        const passwordConfirmationCheckIcon = document.getElementById('password-confirmation-check-icon');

        if (passwordConfirmationInput) {
            // Add event listeners for both inputs to check confirmation
            passwordInput.addEventListener('input', validatePasswordConfirmation);
            passwordConfirmationInput.addEventListener('input', validatePasswordConfirmation);

            function validatePasswordConfirmation() {
                const password = passwordInput.value;
                const confirmation = passwordConfirmationInput.value;

                if (confirmation === '') {
                    // Empty confirmation field
                    passwordConfirmationCheckIcon.classList.add('hidden');
                    passwordConfirmationInput.classList.remove('border-green-500', 'border-red-500');
                    passwordConfirmationInput.classList.add('border-gray-300');
                } else if (password === confirmation) {
                    // Matching passwords
                    passwordConfirmationCheckIcon.innerHTML = '<i class="fas fa-check text-green-500"></i>';
                    passwordConfirmationCheckIcon.classList.remove('hidden');
                    passwordConfirmationInput.classList.remove('border-red-500', 'border-gray-300');
                    passwordConfirmationInput.classList.add('border-green-500');
                } else {
                    // Non-matching passwords
                    passwordConfirmationCheckIcon.innerHTML = '<i class="fas fa-times text-red-500"></i>';
                    passwordConfirmationCheckIcon.classList.remove('hidden');
                    passwordConfirmationInput.classList.remove('border-green-500', 'border-gray-300');
                    passwordConfirmationInput.classList.add('border-red-500');
                }
            }
        }
    });
</script>
@endsection
