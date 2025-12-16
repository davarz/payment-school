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
                    <!-- Session Messages -->
                    @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-3"></i>
                            <span class="text-green-700">{{ session('success') }}</span>
                        </div>
                    </div>
                    @endif

                    @if($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>
                            <span class="text-red-700">
                                {{ $errors->first() }}
                            </span>
                        </div>
                    </div>
                    @endif

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
                                           value="{{ old('name') }}">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <i class="fas fa-user text-gray-400"></i>
                                    </div>
                                </div>
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
                            </div>
                        </div>

                        <!-- Row 3: NISN & Jenis Kelamin -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="nisn" class="block text-sm font-medium text-gray-700 mb-1">
                                    NISN
                                </label>
                                <div class="relative">
                                    <input id="nisn" name="nisn" type="text" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150"
                                           placeholder="Nomor Induk Siswa Nasional (opsional)"
                                           value="{{ old('nisn') }}">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <i class="fas fa-id-badge text-gray-400"></i>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-1">
                                    Jenis Kelamin *
                                </label>
                                <div class="relative">
                                    <select id="jenis_kelamin" name="jenis_kelamin" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent appearance-none transition duration-150">
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Row 4: Tahun Ajaran & Kelas -->
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
                            </div>
                        </div>

                        <!-- Row 5: Tempat Lahir & Tanggal Lahir -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="tempat_lahir" class="block text-sm font-medium text-gray-700 mb-1">
                                    Tempat Lahir *
                                </label>
                                <div class="relative">
                                    <input id="tempat_lahir" name="tempat_lahir" type="text" required 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150"
                                           placeholder="Kota tempat lahir"
                                           value="{{ old('tempat_lahir') }}">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <i class="fas fa-map-marker-alt text-gray-400"></i>
                                    </div>
                                </div>
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
                            </div>
                        </div>

                        <!-- Row 6: Telepon & Alamat -->
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
                            </div>

                            <div class="md:col-span-2">
                                <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">
                                    Alamat Lengkap *
                                </label>
                                <textarea id="alamat" name="alamat" rows="3" required
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150"
                                          placeholder="Alamat lengkap tempat tinggal">{{ old('alamat') }}</textarea>
                            </div>
                        </div>

                        <!-- Row 7: Data Wali (Opsional) -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h3 class="text-lg font-medium text-gray-800 mb-3">Data Wali (Opsional)</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="nama_wali" class="block text-sm font-medium text-gray-700 mb-1">
                                        Nama Wali
                                    </label>
                                    <input id="nama_wali" name="nama_wali" type="text"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150"
                                           placeholder="Nama wali siswa"
                                           value="{{ old('nama_wali') }}">
                                </div>

                                <div>
                                    <label for="telepon_wali" class="block text-sm font-medium text-gray-700 mb-1">
                                        Telepon Wali
                                    </label>
                                    <input id="telepon_wali" name="telepon_wali" type="tel"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150"
                                           placeholder="08xxxxxxxxxx"
                                           value="{{ old('telepon_wali') }}">
                                </div>

                                <div class="md:col-span-2">
                                    <label for="alamat_wali" class="block text-sm font-medium text-gray-700 mb-1">
                                        Alamat Wali
                                    </label>
                                    <textarea id="alamat_wali" name="alamat_wali" rows="2"
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150"
                                              placeholder="Alamat wali siswa">{{ old('alamat_wali') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Row 8: Password & Confirm Password -->
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
                            </div>
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="flex items-start">
                            <input id="terms" name="terms" type="checkbox" required
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded mt-1">
                            <label for="terms" class="ml-2 block text-sm text-gray-700">
                                Saya menyetujui 
                                <a href="#" class="text-blue-600 hover:text-blue-500">Syarat dan Ketentuan</a> 
                                serta 
                                <a href="#" class="text-blue-600 hover:text-blue-500">Kebijakan Privasi</a>
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-4">
                            <button type="submit" 
                                    class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-4 px-6 rounded-lg font-semibold text-lg hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transition duration-150 ease-in-out">
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
                © {{ date('Y') }} School Payment System. All rights reserved.
            </p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
                    } else {
                        input.type = 'password';
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    }
                });
            });

            // Validate minimum birth year (12 years old)
            const tanggalLahirInput = document.getElementById('tanggal_lahir');
            if (tanggalLahirInput) {
                tanggalLahirInput.addEventListener('change', function() {
                    const selectedDate = new Date(this.value);
                    const today = new Date();
                    const minDate = new Date();
                    minDate.setFullYear(today.getFullYear() - 12); // Minimum 12 years old
                    
                    if (selectedDate > minDate) {
                        alert('Siswa harus berusia minimal 12 tahun');
                        this.value = '';
                    }
                });
            }

            // Auto-format phone numbers
            const phoneInputs = document.querySelectorAll('input[type="tel"]');
            phoneInputs.forEach(input => {
                input.addEventListener('input', function() {
                    let value = this.value.replace(/\D/g, '');
                    if (value.length > 0) {
                        if (!value.startsWith('0')) {
                            value = '0' + value;
                        }
                        if (value.length > 12) {
                            value = value.substring(0, 13);
                        }
                    }
                    this.value = value;
                });
            });
        });
    </script>
</body>
</html>