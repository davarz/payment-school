@extends('layouts.app')

@section('title', 'Lengkapi Profil')

@section('content')
<div class="w-full max-w-3xl mx-auto p-6">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-8">
            <div class="text-center">
                <div class="h-16 w-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4 backdrop-blur">
                    <i class="fas fa-user-edit text-white text-2xl"></i>
                </div>
                <h1 class="text-3xl font-bold text-white mb-2">Lengkapi Profil Anda</h1>
                <p class="text-blue-100">Mohon lengkapi data diri Anda untuk melengkapi akun Anda</p>
            </div>
        </div>

        <!-- Form -->
        <div class="px-6 py-8">
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <div class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mt-0.5 mr-3 flex-shrink-0"></i>
                        <div class="flex-1">
                            <p class="text-green-700 font-medium">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('profile.complete.update') }}" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- NIS -->
                <div>
                    <label for="nis" class="block text-sm font-medium text-gray-700 mb-2">
                        NIS (Nomor Induk Siswa)
                    </label>
                    <input
                        id="nis"
                        type="text"
                        name="nis"
                        value="{{ old('nis', $siswa->nis ?? '') }}"
                        placeholder="Masukkan NIS Anda"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150"
                    />
                    @error('nis')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- NIK -->
                <div>
                    <label for="nik" class="block text-sm font-medium text-gray-700 mb-2">
                        NIK (Nomor Induk Kependudukan)
                    </label>
                    <input
                        id="nik"
                        type="text"
                        name="nik"
                        value="{{ old('nik', $siswa->nik ?? '') }}"
                        placeholder="Masukkan NIK Anda"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150"
                    />
                    @error('nik')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- NISN -->
                <div>
                    <label for="nisn" class="block text-sm font-medium text-gray-700 mb-2">
                        NISN (Nomor Induk Siswa Nasional)
                    </label>
                    <input
                        id="nisn"
                        type="text"
                        name="nisn"
                        value="{{ old('nisn', $siswa->nisn ?? '') }}"
                        placeholder="Masukkan NISN Anda"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150"
                    />
                    @error('nisn')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tahun Ajaran -->
                <div>
                    <label for="tahun_ajaran" class="block text-sm font-medium text-gray-700 mb-2">
                        Tahun Ajaran
                    </label>
                    <input
                        id="tahun_ajaran"
                        type="text"
                        name="tahun_ajaran"
                        value="{{ old('tahun_ajaran', $siswa->tahun_ajaran ?? '') }}"
                        placeholder="Contoh: 2023/2024"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150"
                    />
                    @error('tahun_ajaran')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kelas -->
                <div>
                    <label for="kelas" class="block text-sm font-medium text-gray-700 mb-2">
                        Kelas
                    </label>
                    <input
                        id="kelas"
                        type="text"
                        name="kelas"
                        value="{{ old('kelas', $siswa->kelas ?? '') }}"
                        placeholder="Contoh: XI IPA 1"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150"
                    />
                    @error('kelas')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jenis Kelamin -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Jenis Kelamin
                    </label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="flex items-center">
                            <input
                                type="radio"
                                name="jenis_kelamin"
                                value="L"
                                {{ (old('jenis_kelamin', $siswa->jenis_kelamin ?? '') === 'L') ? 'checked' : '' }}
                                class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                            />
                            <span class="ml-2 text-gray-700">Laki-laki</span>
                        </label>
                        <label class="flex items-center">
                            <input
                                type="radio"
                                name="jenis_kelamin"
                                value="P"
                                {{ (old('jenis_kelamin', $siswa->jenis_kelamin ?? '') === 'P') ? 'checked' : '' }}
                                class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                            />
                            <span class="ml-2 text-gray-700">Perempuan</span>
                        </label>
                    </div>
                    @error('jenis_kelamin')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tempat Lahir -->
                <div>
                    <label for="tempat_lahir" class="block text-sm font-medium text-gray-700 mb-2">
                        Tempat Lahir
                    </label>
                    <input
                        id="tempat_lahir"
                        type="text"
                        name="tempat_lahir"
                        value="{{ old('tempat_lahir', $siswa->tempat_lahir ?? '') }}"
                        placeholder="Contoh: Jakarta"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150"
                    />
                    @error('tempat_lahir')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal Lahir -->
                <div>
                    <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Lahir
                    </label>
                    <input
                        id="tanggal_lahir"
                        type="date"
                        name="tanggal_lahir"
                        value="{{ old('tanggal_lahir', $siswa->tanggal_lahir ?? '') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150"
                    />
                    @error('tanggal_lahir')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Telepon -->
                <div>
                    <label for="telepon" class="block text-sm font-medium text-gray-700 mb-2">
                        Telepon
                    </label>
                    <input
                        id="telepon"
                        type="text"
                        name="telepon"
                        value="{{ old('telepon', $siswa->telepon ?? '') }}"
                        placeholder="Contoh: 081234567890"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150"
                    />
                    @error('telepon')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Alamat -->
                <div>
                    <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">
                        Alamat
                    </label>
                    <textarea
                        id="alamat"
                        name="alamat"
                        rows="3"
                        placeholder="Masukkan alamat lengkap Anda"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150"
                    >{{ old('alamat', $siswa->alamat ?? '') }}</textarea>
                    @error('alamat')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama Wali -->
                <div>
                    <label for="nama_wali" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Wali
                    </label>
                    <input
                        id="nama_wali"
                        type="text"
                        name="nama_wali"
                        value="{{ old('nama_wali', $siswa->nama_wali ?? '') }}"
                        placeholder="Masukkan nama wali Anda"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150"
                    />
                    @error('nama_wali')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Telepon Wali -->
                <div>
                    <label for="telepon_wali" class="block text-sm font-medium text-gray-700 mb-2">
                        Telepon Wali
                    </label>
                    <input
                        id="telepon_wali"
                        type="text"
                        name="telepon_wali"
                        value="{{ old('telepon_wali', $siswa->telepon_wali ?? '') }}"
                        placeholder="Contoh: 081234567890"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150"
                    />
                    @error('telepon_wali')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Alamat Wali -->
                <div>
                    <label for="alamat_wali" class="block text-sm font-medium text-gray-700 mb-2">
                        Alamat Wali
                    </label>
                    <textarea
                        id="alamat_wali"
                        name="alamat_wali"
                        rows="3"
                        placeholder="Masukkan alamat wali Anda"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150"
                    >{{ old('alamat_wali', $siswa->alamat_wali ?? '') }}</textarea>
                    @error('alamat_wali')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="pt-6">
                    <button
                        type="submit"
                        class="w-full py-3 px-4 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition duration-200 shadow-sm hover:shadow-md"
                    >
                        Simpan Profil
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection