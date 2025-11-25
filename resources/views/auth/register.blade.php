<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - School Payment System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen flex items-center justify-center py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl w-full">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="mx-auto h-20 w-20 bg-white rounded-full flex items-center justify-center mb-4 shadow-lg">
                <i class="fas fa-graduation-cap text-blue-600 text-3xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-800">Pendaftaran Siswa Baru</h1>
            <p class="mt-2 text-gray-600">Isi formulir berikut untuk membuat akun baru</p>
        </div>

        <!-- Main Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="flex flex-col lg:flex-row">
                <!-- Left Side - Welcome & Info -->
                <div class="lg:w-2/5 bg-gradient-to-br from-blue-600 to-indigo-700 p-8 text-white">
                    <div class="flex flex-col justify-between h-full">
                        <div>
                            <h2 class="text-2xl font-bold mb-4">Selamat Datang!</h2>
                            <p class="text-blue-100 mb-6">Bergabung dengan sistem pembayaran sekolah kami untuk kemudahan mengelola administrasi keuangan.</p>
                            
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 bg-white/20 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-check text-sm"></i>
                                    </div>
                                    <span class="text-blue-100">Kelola pembayaran dengan mudah</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="h-8 w-8 bg-white/20 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-check text-sm"></i>
                                    </div>
                                    <span class="text-blue-100">Akses riwayat transaksi</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="h-8 w-8 bg-white/20 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-check text-sm"></i>
                                    </div>
                                    <span class="text-blue-100">Notifikasi tagihan otomatis</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8">
                            <div class="bg-white/10 rounded-lg p-4">
                                <p class="text-sm text-blue-100 mb-2">Sudah punya akun?</p>
                                <a href="{{ route('login') }}" 
                                   class="block w-full text-center py-2 px-4 border border-white text-white rounded-lg hover:bg-white hover:text-blue-600 transition duration-150 ease-in-out font-medium">
                                    Login di sini
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side - Registration Form -->
                <div class="lg:w-3/5 p-8">
                    <form method="POST" action="{{ route('register') }}" class="space-y-4">
                        @csrf

                        <!-- Row 1: Name & Email -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                    Nama Lengkap *
                                </label>
                                <div class="relative">
                                    <input id="name" name="name" type="text" required 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150"
                                           placeholder="Nama lengkap"
                                           value="{{ old('name') }}"
                                           style="text-transform: uppercase;">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <i class="fas fa-user text-gray-400"></i>
                                    </div>
                                </div>
                                <div class="text-xs text-gray-500 mt-1 flex items-center">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Nama akan otomatis menjadi huruf besar
                                </div>
                                <x-input-error :messages="$errors->get('name')" class="mt-1" />
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                    Email *
                                </label>
                                <div class="relative">
                                    <input id="email" name="email" type="email" required 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150"
                                           placeholder="alamat@email.com"
                                           value="{{ old('email') }}">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <i class="fas fa-envelope text-gray-400"></i>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('email')" class="mt-1" />
                            </div>
                        </div>

                        <!-- Row 2: NIS & NIK -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="nis" class="block text-sm font-medium text-gray-700 mb-1">
                                    NIS *
                                </label>
                                <div class="relative">
                                    <input id="nis" name="nis" type="text" required 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150"
                                           placeholder="Nomor Induk Siswa"
                                           value="{{ old('nis') }}">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <i class="fas fa-id-card text-gray-400"></i>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('nis')" class="mt-1" />
                            </div>

                            <div>
                                <label for="nik" class="block text-sm font-medium text-gray-700 mb-1">
                                    NIK *
                                </label>
                                <div class="relative">
                                    <input id="nik" name="nik" type="text" required 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150"
                                           placeholder="Nomor Induk Kependudukan"
                                           value="{{ old('nik') }}">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <i class="fas fa-address-card text-gray-400"></i>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('nik')" class="mt-1" />
                            </div>
                        </div>

                        <!-- Row 3: Tahun Ajaran & Kelas -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="tahun_ajaran" class="block text-sm font-medium text-gray-700 mb-1">
                                    Tahun Ajaran *
                                </label>
                                <div class="relative">
                                    <select id="tahun_ajaran" name="tahun_ajaran" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent appearance-none transition duration-150">
                                        <option value="">Pilih Tahun Ajaran</option>
                                        @php
                                            $currentYear = date('Y');
                                            $years = range($currentYear - 2, $currentYear + 1);
                                        @endphp
                                        @foreach($years as $year)
                                            <option value="{{ $year }}/{{ $year + 1 }}" {{ old('tahun_ajaran') == $year.'/'.($year+1) ? 'selected' : '' }}>
                                                {{ $year }}/{{ $year + 1 }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('tahun_ajaran')" class="mt-1" />
                            </div>

                            <div>
                                <label for="kelas" class="block text-sm font-medium text-gray-700 mb-1">
                                    Kelas *
                                </label>
                                <div class="relative">
                                    <select id="kelas" name="kelas" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent appearance-none transition duration-150">
                                        <option value="">Pilih Kelas</option>
                                        <option value="10" {{ old('kelas') == '10' ? 'selected' : '' }}>Kelas 10</option>
                                        <option value="11" {{ old('kelas') == '11' ? 'selected' : '' }}>Kelas 11</option>
                                        <option value="12" {{ old('kelas') == '12' ? 'selected' : '' }}>Kelas 12</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('kelas')" class="mt-1" />
                            </div>
                        </div>

                        <!-- Row 4: Tempat Lahir & Tanggal Lahir -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="tempat_lahir" class="block text-sm font-medium text-gray-700 mb-1">
                                    Tempat Lahir *
                                </label>
                                <div class="relative">
                                    <input id="tempat_lahir" name="tempat_lahir" type="text" required 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150"
                                           placeholder="Kota tempat lahir"
                                           value="{{ old('tempat_lahir') }}"
                                           style="text-transform: uppercase;">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <i class="fas fa-map-marker-alt text-gray-400"></i>
                                    </div>
                                </div>
                                <div class="text-xs text-gray-500 mt-1 flex items-center">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Nama kota akan otomatis menjadi huruf besar
                                </div>
                                <x-input-error :messages="$errors->get('tempat_lahir')" class="mt-1" />
                            </div>

                            <div>
                                <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-1">
                                    Tanggal Lahir *
                                </label>
                                <div class="relative">
                                    <input id="tanggal_lahir" name="tanggal_lahir" type="date" required 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150"
                                           value="{{ old('tanggal_lahir') }}">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <i class="fas fa-calendar-alt text-gray-400"></i>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('tanggal_lahir')" class="mt-1" />
                            </div>
                        </div>

                        <!-- Row 5: Telepon & Alamat -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="telepon" class="block text-sm font-medium text-gray-700 mb-1">
                                    Nomor Telepon *
                                </label>
                                <div class="relative">
                                    <input id="telepon" name="telepon" type="tel" required 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150"
                                           placeholder="08xxxxxxxxxx"
                                           value="{{ old('telepon') }}">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <i class="fas fa-phone text-gray-400"></i>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('telepon')" class="mt-1" />
                            </div>

                            <div class="md:col-span-2">
                                <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">
                                    Alamat Lengkap *
                                </label>
                                <textarea id="alamat" name="alamat" rows="3" required
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150"
                                          placeholder="Alamat lengkap tempat tinggal"
                                          style="text-transform: uppercase;">{{ old('alamat') }}</textarea>
                                <div class="text-xs text-gray-500 mt-1 flex items-center">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Alamat akan otomatis menjadi huruf besar
                                </div>
                                <x-input-error :messages="$errors->get('alamat')" class="mt-1" />
                            </div>
                        </div>

                        <!-- Row 6: Password & Confirm Password -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                                    Password *
                                </label>
                                <div class="relative">
                                    <input id="password" name="password" type="password" required 
                                           class="w-full px-4 py-3 pr-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150"
                                           placeholder="Minimal 8 karakter">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <button type="button" class="password-toggle text-gray-400 hover:text-gray-600 transition duration-150">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('password')" class="mt-1" />
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                                    Konfirmasi Password *
                                </label>
                                <div class="relative">
                                    <input id="password_confirmation" name="password_confirmation" type="password" required 
                                           class="w-full px-4 py-3 pr-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150"
                                           placeholder="Ulangi password">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <button type="button" class="password-toggle text-gray-400 hover:text-gray-600 transition duration-150">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                            </div>
                        </div>

                        <!-- Password Strength Indicator -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-700">Kekuatan Password:</span>
                                <span id="password-strength-text" class="text-xs font-medium">-</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div id="password-strength-bar" class="h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                            </div>
                            <div class="text-xs text-gray-500 mt-2">
                                <i class="fas fa-info-circle mr-1"></i>
                                Gunakan kombinasi huruf, angka, dan simbol untuk keamanan maksimal
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-4">
                            <button type="submit" 
                                    class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-4 px-6 rounded-lg font-semibold text-lg hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transition duration-150 ease-in-out transform hover:-translate-y-0.5">
                                <i class="fas fa-user-plus mr-2"></i>
                                Daftar Sekarang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-6">
            <p class="text-sm text-gray-600">
                © 2024 School Payment System. All rights reserved.
            </p>
        </div>
    </div>

    <script>
        // Auto Uppercase Functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Function to convert text to uppercase
            function convertToUppercase(element) {
                const cursorPosition = element.selectionStart;
                element.value = element.value.toUpperCase();
                element.setSelectionRange(cursorPosition, cursorPosition);
            }

            // Get fields that should be uppercase
            const nameInput = document.getElementById('name');
            const tempatLahirInput = document.getElementById('tempat_lahir');
            const alamatTextarea = document.getElementById('alamat');

            // Add uppercase functionality to name field
            if (nameInput) {
                nameInput.addEventListener('input', function() {
                    convertToUppercase(this);
                });
                nameInput.addEventListener('blur', function() {
                    convertToUppercase(this);
                });
            }

            // Add uppercase functionality to tempat lahir field
            if (tempatLahirInput) {
                tempatLahirInput.addEventListener('input', function() {
                    convertToUppercase(this);
                });
                tempatLahirInput.addEventListener('blur', function() {
                    convertToUppercase(this);
                });
            }

            // Add uppercase functionality to alamat field
            if (alamatTextarea) {
                alamatTextarea.addEventListener('input', function() {
                    convertToUppercase(this);
                });
                alamatTextarea.addEventListener('blur', function() {
                    convertToUppercase(this);
                });
            }

            // Show/Hide Password Functionality
            const passwordToggles = document.querySelectorAll('.password-toggle');
            
            passwordToggles.forEach(toggle => {
                toggle.addEventListener('click', function() {
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
            });

            // Password Strength Indicator
            const passwordInput = document.getElementById('password');
            const strengthBar = document.getElementById('password-strength-bar');
            const strengthText = document.getElementById('password-strength-text');

            if (passwordInput && strengthBar && strengthText) {
                passwordInput.addEventListener('input', function() {
                    const password = this.value;
                    const strength = calculatePasswordStrength(password);
                    
                    // Update progress bar
                    strengthBar.style.width = strength.percentage + '%';
                    strengthBar.className = 'h-2 rounded-full transition-all duration-300 ' + strength.color;
                    
                    // Update text
                    strengthText.textContent = strength.text;
                    strengthText.className = 'text-xs font-medium ' + strength.textColor;
                });

                function calculatePasswordStrength(password) {
                    let score = 0;
                    
                    // Length check
                    if (password.length >= 8) score += 25;
                    if (password.length >= 12) score += 10;
                    
                    // Character variety
                    if (/[a-z]/.test(password)) score += 10;
                    if (/[A-Z]/.test(password)) score += 15;
                    if (/[0-9]/.test(password)) score += 15;
                    if (/[^A-Za-z0-9]/.test(password)) score += 25;
                    
                    // Bonus for mixed case and numbers
                    if (/[a-z]/.test(password) && /[A-Z]/.test(password)) score += 10;
                    if (/[0-9]/.test(password) && /[^A-Za-z0-9]/.test(password)) score += 10;

                    // Cap at 100%
                    score = Math.min(score, 100);

                    // Determine strength level
                    if (score === 0) {
                        return { percentage: 0, color: 'bg-gray-300', text: 'Kosong', textColor: 'text-gray-500' };
                    } else if (score < 40) {
                        return { percentage: score, color: 'bg-red-500', text: 'Lemah', textColor: 'text-red-600' };
                    } else if (score < 70) {
                        return { percentage: score, color: 'bg-yellow-500', text: 'Cukup', textColor: 'text-yellow-600' };
                    } else if (score < 90) {
                        return { percentage: score, color: 'bg-blue-500', text: 'Kuat', textColor: 'text-blue-600' };
                    } else {
                        return { percentage: score, color: 'bg-green-500', text: 'Sangat Kuat', textColor: 'text-green-600' };
                    }
                }
            }

            // Real-time validation feedback
            const inputs = document.querySelectorAll('input, select, textarea');
            
            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    if (this.value.trim() === '') {
                        this.classList.add('border-red-300');
                    } else {
                        this.classList.remove('border-red-300');
                    }
                });

                input.addEventListener('input', function() {
                    if (this.value.trim() !== '') {
                        this.classList.remove('border-red-300');
                        this.classList.add('border-green-300');
                    } else {
                        this.classList.remove('border-green-300');
                    }
                });
            });

            // Email validation
            const emailInput = document.getElementById('email');
            if (emailInput) {
                emailInput.addEventListener('blur', function() {
                    const email = this.value;
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    
                    if (email && !emailRegex.test(email)) {
                        this.classList.add('border-red-300');
                    } else if (email) {
                        this.classList.remove('border-red-300');
                        this.classList.add('border-green-300');
                    }
                });
            }

            // Password confirmation validation
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('password_confirmation');
            
            if (password && confirmPassword) {
                function validatePasswordMatch() {
                    if (password.value && confirmPassword.value) {
                        if (password.value === confirmPassword.value) {
                            confirmPassword.classList.remove('border-red-300');
                            confirmPassword.classList.add('border-green-300');
                        } else {
                            confirmPassword.classList.remove('border-green-300');
                            confirmPassword.classList.add('border-red-300');
                        }
                    }
                }

                password.addEventListener('input', validatePasswordMatch);
                confirmPassword.addEventListener('input', validatePasswordMatch);
            }
        });
    </script>
</body>
</html>