@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="container mx-auto px-4 py-8">
    @if($profileIncomplete)
    <x-alert type="info" title="Profil Belum Lengkap!" closable class="mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
            <div>
                <strong>Profil Anda belum lengkap.</strong> Lengkapi data diri Anda untuk pengalaman yang lebih baik.
            </div>
            <a href="{{ route('profile.complete') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition duration-150">
                <i class="fas fa-user-edit mr-2"></i>
                Lengkapi Profil
            </a>
        </div>
    </x-alert>
    @endif

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Edit Profile</h1>
        <p class="text-gray-600">Perbarui informasi pribadi dan keamanan akun</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Edit Profile Form -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800">Informasi Pribadi</h2>
                </div>

                <form action="{{ route('siswa.profile.update') }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div class="md:col-span-2">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                Nama Lengkap *
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" 
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="md:col-span-2">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                Email *
                            </label>
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" 
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="telepon" class="block text-sm font-medium text-gray-700 mb-1">
                                No. Telepon *
                            </label>
                            <input type="text" id="telepon" name="telepon" value="{{ old('telepon', $siswa->telepon ?? '') }}"
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150">
                            @error('telepon')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Birth Place -->
                        <div>
                            <label for="tempat_lahir" class="block text-sm font-medium text-gray-700 mb-1">
                                Tempat Lahir *
                            </label>
                            <input type="text" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir', $siswa->tempat_lahir ?? '') }}"
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150">
                            @error('tempat_lahir')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Birth Date -->
                        <div>
                            <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-1">
                                Tanggal Lahir *
                            </label>
                            <input type="date" id="tanggal_lahir" name="tanggal_lahir"
                                   value="{{ old('tanggal_lahir', $siswa->tanggal_lahir ? $siswa->tanggal_lahir->format('Y-m-d') : '') }}"
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150">
                            @error('tanggal_lahir')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div class="md:col-span-2">
                            <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">
                                Alamat Lengkap *
                            </label>
                            <textarea id="alamat" name="alamat" rows="3"
                                      required
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150">{{ old('alamat', $siswa->alamat ?? '') }}</textarea>
                            @error('alamat')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="mt-6 pt-6 border-t border-gray-200 flex justify-between">
                        <a href="{{ route('siswa.profile.show') }}" 
                           class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-lg transition-colors">
                            Batal
                        </a>
                        <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg flex items-center transition-colors">
                            <i class="fas fa-save mr-2"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Change Password Form -->
            <div id="password-section" class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800">Ubah Password</h2>
                    <p class="text-sm text-gray-600">Pastikan password baru kuat dan mudah diingat</p>
                </div>

                <form action="{{ route('siswa.profile.update-password') }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="space-y-4">
                        <!-- Current Password -->
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">
                                Password Saat Ini *
                            </label>
                            <input type="password" id="current_password" name="current_password" 
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150">
                            @error('current_password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- New Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                                Password Baru *
                            </label>
                            <input type="password" id="password" name="password" 
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150">
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                                Konfirmasi Password Baru *
                            </label>
                            <input type="password" id="password_confirmation" name="password_confirmation" 
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150">
                        </div>

                        <!-- Password Requirements -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Kriteria Password:</h4>
                            <ul class="text-xs text-gray-600 space-y-1">
                                <li class="flex items-center">
                                    <i class="fas fa-check text-green-500 mr-2"></i>
                                    Minimal 8 karakter
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-check text-green-500 mr-2"></i>
                                    Kombinasi huruf dan angka
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-check text-green-500 mr-2"></i>
                                    Tidak sama dengan password lama
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="mt-6 pt-6 border-t border-gray-200 flex justify-end">
                        <button type="submit" 
                                class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg flex items-center transition-colors">
                            <i class="fas fa-lock mr-2"></i>
                            Ubah Password
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Profile Summary -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="text-center">
                    <div class="mx-auto h-20 w-20 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-user text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800">{{ $user->name }}</h3>
                    <p class="text-sm text-gray-600">{{ $user->email }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ $siswa->kelas ?? 'N/A' }} • {{ $siswa->tahun_ajaran ?? 'N/A' }}</p>
                </div>
            </div>

            <!-- Tips -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                <div class="flex items-start">
                    <i class="fas fa-lightbulb text-yellow-600 mt-1 mr-3"></i>
                    <div>
                        <h4 class="text-sm font-medium text-yellow-800">Tips Keamanan</h4>
                        <ul class="text-xs text-yellow-700 mt-2 space-y-1">
                            <li>• Gunakan password yang kuat</li>
                            <li>• Jangan bagikan data login</li>
                            <li>• Perbarui informasi secara berkala</li>
                            <li>• Logout setelah menggunakan komputer bersama</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Real-time password validation
    document.addEventListener('DOMContentLoaded', function() {
        const passwordInput = document.getElementById('password');
        const confirmInput = document.getElementById('password_confirmation');

        function validatePassword() {
            const password = passwordInput.value;
            const confirmPassword = confirmInput.value;
            
            // Reset styles
            passwordInput.classList.remove('border-red-300', 'border-green-300');
            confirmInput.classList.remove('border-red-300', 'border-green-300');
            
            // Validate password length
            if (password.length > 0) {
                if (password.length < 8) {
                    passwordInput.classList.add('border-red-300');
                } else {
                    passwordInput.classList.add('border-green-300');
                }
            }
            
            // Validate confirmation
            if (confirmPassword && password !== confirmPassword) {
                confirmInput.classList.add('border-red-300');
            } else if (confirmPassword) {
                confirmInput.classList.add('border-green-300');
            }
        }

        if (passwordInput) {
            passwordInput.addEventListener('input', validatePassword);
        }
        if (confirmInput) {
            confirmInput.addEventListener('input', validatePassword);
        }
    });
</script>
@endsection