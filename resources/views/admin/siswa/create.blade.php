@extends('layouts.app')

@section('title', 'Tambah Siswa Baru')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <x-page-header
        title="Tambah Siswa Baru"
        subtitle="Daftarkan data siswa baru ke dalam sistem"
        icon="fa-user-plus"
    />

    <!-- Form Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Form Header -->
        <div class="p-6 bg-gradient-to-r from-blue-50 to-blue-100 border-b border-gray-200">
            <div class="flex items-start space-x-3">
                <i class="fas fa-lightbulb text-blue-600 mt-1 text-lg"></i>
                <div>
                    <h3 class="font-semibold text-blue-900">Password Otomatis</h3>
                    <p class="text-sm text-blue-800 mt-1">Password akan digenerate dari <strong>3 huruf pertama nama + 4 digit terakhir NIS</strong>. Contoh: Nama "Dava" + NIS "2010809" = Password "dav0809"</p>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.siswa.store') }}" method="POST" class="p-6 space-y-6">
            @csrf

            <!-- Personal Data Section -->
            <div>
                <h3 class="text-lg font-bold text-gray-900 mb-4 pb-2 border-b border-gray-200 flex items-center">
                    <i class="fas fa-user text-blue-600 mr-2"></i>
                    Data Pribadi
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama Lengkap -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" required value="{{ old('name') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            placeholder="Contoh: Ahmad Wijaya">
                        @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" required value="{{ old('email') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            placeholder="ahmad@school.com">
                        @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- NIS -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            NIS <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nis" required value="{{ old('nis') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            placeholder="Nomor Induk Siswa">
                        @error('nis')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- NISN -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            NISN
                        </label>
                        <input type="text" name="nisn" value="{{ old('nisn') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            placeholder="Nomor Induk Siswa Nasional (opsional)">
                        @error('nisn')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Academic Data Section -->
            <div>
                <h3 class="text-lg font-bold text-gray-900 mb-4 pb-2 border-b border-gray-200 flex items-center">
                    <i class="fas fa-graduation-cap text-blue-600 mr-2"></i>
                    Data Akademik
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kelas -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Kelas <span class="text-red-500">*</span>
                        </label>
                        <select name="kelas" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            <option value="">-- Pilih Kelas --</option>
                            <option value="10" {{ old('kelas') === '10' ? 'selected' : '' }}>Kelas 10</option>
                            <option value="11" {{ old('kelas') === '11' ? 'selected' : '' }}>Kelas 11</option>
                            <option value="12" {{ old('kelas') === '12' ? 'selected' : '' }}>Kelas 12</option>
                        </select>
                        @error('kelas')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tahun Ajaran -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Tahun Ajaran <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="tahun_ajaran" required value="{{ old('tahun_ajaran') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            placeholder="2024/2025">
                        @error('tahun_ajaran')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jenis Kelamin -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Jenis Kelamin <span class="text-red-500">*</span>
                        </label>
                        <select name="jenis_kelamin" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="L" {{ old('jenis_kelamin') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin') === 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status Siswa -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Status Siswa <span class="text-red-500">*</span>
                        </label>
                        <select name="status_siswa" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            <option value="">-- Pilih Status --</option>
                            <option value="aktif" {{ old('status_siswa') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="pindah" {{ old('status_siswa') === 'pindah' ? 'selected' : '' }}>Pindah</option>
                            <option value="dikeluarkan" {{ old('status_siswa') === 'dikeluarkan' ? 'selected' : '' }}>Dikeluarkan</option>
                        </select>
                        @error('status_siswa')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Button Section -->
            <div class="flex items-center space-x-3 pt-6 border-t border-gray-200">
                <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-save mr-2"></i>
                    Simpan Data Siswa
                </button>
                <a href="{{ route('admin.siswa.index') }}" class="inline-flex items-center px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition">
                    <i class="fas fa-times mr-2"></i>
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
