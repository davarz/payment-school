@extends('layouts.app')

@section('title', 'Edit Siswa')

@section('content')
<div class="space-y-6">
    <x-page-header title="Edit Data Siswa" subtitle="Perbarui informasi data siswa" icon="fa-edit" />

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Validation Error Alert -->
        @if ($errors->any())
        <div class="p-4 bg-red-50 border-l-4 border-red-500 m-6 rounded">
            <div class="flex items-start space-x-3">
                <i class="fas fa-exclamation-circle text-red-600 mt-1 text-lg flex-shrink-0"></i>
                <div class="flex-1">
                    <h3 class="font-semibold text-red-900">Validasi Gagal</h3>
                    <ul class="mt-2 space-y-1 text-sm text-red-800">
                        @foreach ($errors->all() as $error)
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-check-circle text-red-500 text-xs"></i>
                            <span>{{ $error }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        <form action="{{ route('admin.siswa.update', $siswa->id) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Data Pribadi Section -->
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
                        <input type="text" name="name" required value="{{ old('name', $siswa->user->name) }}"
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
                        <input type="email" name="email" required value="{{ old('email', $siswa->user->email) }}"
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
                        <input type="text" name="nis" required value="{{ old('nis', $siswa->nis) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            placeholder="Nomor Induk Siswa">
                        @error('nis')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- NIK -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            NIK <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nik" required value="{{ old('nik', $siswa->nik) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            placeholder="Nomor Induk Kependudukan">
                        @error('nik')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- NISN -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            NISN
                        </label>
                        <input type="text" name="nisn" value="{{ old('nisn', $siswa->nisn) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            placeholder="Nomor Induk Siswa Nasional (opsional)">
                        @error('nisn')
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
                            <option value="L" {{ old('jenis_kelamin', $siswa->jenis_kelamin) === 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin', $siswa->jenis_kelamin) === 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Birth Information Section -->
            <div>
                <h3 class="text-lg font-bold text-gray-900 mb-4 pb-2 border-b border-gray-200 flex items-center">
                    <i class="fas fa-birthday-cake text-blue-600 mr-2"></i>
                    Informasi Kelahiran
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Tanggal Lahir -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Tanggal Lahir <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="tanggal_lahir" required value="{{ old('tanggal_lahir', $siswa->tanggal_lahir) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        @error('tanggal_lahir')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tempat Lahir -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Tempat Lahir <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="tempat_lahir" required value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            placeholder="Contoh: Jakarta">
                        @error('tempat_lahir')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Contact Information Section -->
            <div>
                <h3 class="text-lg font-bold text-gray-900 mb-4 pb-2 border-b border-gray-200 flex items-center">
                    <i class="fas fa-phone text-blue-600 mr-2"></i>
                    Informasi Kontak
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                    <!-- Telepon -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Nomor Telepon <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" name="telepon" required value="{{ old('telepon', $siswa->telepon) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            placeholder="Contoh: 081234567890">
                        @error('telepon')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Address Information Section -->
            <div>
                <h3 class="text-lg font-bold text-gray-900 mb-4 pb-2 border-b border-gray-200 flex items-center">
                    <i class="fas fa-map-marker-alt text-blue-600 mr-2"></i>
                    Informasi Alamat
                </h3>

                <div class="grid grid-cols-1 gap-6">
                    <!-- Alamat Siswa -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Alamat <span class="text-red-500">*</span>
                        </label>
                        <textarea name="alamat" required rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            placeholder="Jalan, No. Rumah, RT/RW, Kelurahan, Kecamatan, Kabupaten/Kota, Provinsi">{{ old('alamat', $siswa->alamat) }}</textarea>
                        @error('alamat')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Guardian Information Section -->
            <div>
                <h3 class="text-lg font-bold text-gray-900 mb-4 pb-2 border-b border-gray-200 flex items-center">
                    <i class="fas fa-user-tie text-blue-600 mr-2"></i>
                    Informasi Wali/Orang Tua
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama Wali -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Nama Wali/Orang Tua <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_wali" required value="{{ old('nama_wali', $siswa->nama_wali) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            placeholder="Nama lengkap wali">
                        @error('nama_wali')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Telepon Wali -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Telepon Wali/Orang Tua <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" name="telepon_wali" required value="{{ old('telepon_wali', $siswa->telepon_wali) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            placeholder="Nomor telepon wali">
                        @error('telepon_wali')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Alamat Wali -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Alamat Wali/Orang Tua <span class="text-red-500">*</span>
                        </label>
                        <textarea name="alamat_wali" required rows="2"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            placeholder="Alamat lengkap wali">{{ old('alamat_wali', $siswa->alamat_wali) }}</textarea>
                        @error('alamat_wali')
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
                            <option value="10" {{ old('kelas', $siswa->kelas) === '10' ? 'selected' : '' }}>Kelas 10</option>
                            <option value="11" {{ old('kelas', $siswa->kelas) === '11' ? 'selected' : '' }}>Kelas 11</option>
                            <option value="12" {{ old('kelas', $siswa->kelas) === '12' ? 'selected' : '' }}>Kelas 12</option>
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
                        <input type="text" name="tahun_ajaran" required value="{{ old('tahun_ajaran', $siswa->tahun_ajaran) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            placeholder="2024/2025">
                        @error('tahun_ajaran')
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
                            <option value="aktif" {{ old('status_siswa', $siswa->status_siswa) === 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="pindah" {{ old('status_siswa', $siswa->status_siswa) === 'pindah' ? 'selected' : '' }}>Pindah</option>
                            <option value="dikeluarkan" {{ old('status_siswa', $siswa->status_siswa) === 'dikeluarkan' ? 'selected' : '' }}>Dikeluarkan</option>
                            <option value="lulus" {{ old('status_siswa', $siswa->status_siswa) === 'lulus' ? 'selected' : '' }}>Lulus</option>
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
                    Simpan Perubahan
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