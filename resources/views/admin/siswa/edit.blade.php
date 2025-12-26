@extends('layouts.app')

@section('title', 'Edit Siswa')

@section('content')
<div class="space-y-6">
    <x-page-header title="Edit Data Siswa" subtitle="Perbarui informasi data siswa" icon="fa-edit" />

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('admin.siswa.update', $siswa->id) }}" method="POST">
                @csrf
            @method('PUT')

            <!-- Data Pribadi Section -->
            <div>
                <h3 class="text-lg font-bold mb-4 pb-2 border-b flex items-center">
                    <i class="fas fa-user mr-2 text-blue-600"></i> Data Pribadi
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $siswa->name) }}" required 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email', $siswa->email) }}" required 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">NIS <span class="text-red-500">*</span></label>
                        <input type="text" name="nis" value="{{ old('nis', $siswa->nis) }}" required 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('nis')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">NISN</label>
                        <input type="text" name="nisn" value="{{ old('nisn', $siswa->nisn) }}" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('nisn')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Data Akademik Section -->
            <div>
                <h3 class="text-lg font-bold mb-4 pb-2 border-b flex items-center">
                    <i class="fas fa-graduation-cap mr-2 text-green-600"></i> Data Akademik
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Kelas <span class="text-red-500">*</span></label>
                        <select name="kelas" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Pilih Kelas</option>
                            <option value="10" {{ old('kelas', $siswa->kelas) == '10' ? 'selected' : '' }}>Kelas 10</option>
                            <option value="11" {{ old('kelas', $siswa->kelas) == '11' ? 'selected' : '' }}>Kelas 11</option>
                            <option value="12" {{ old('kelas', $siswa->kelas) == '12' ? 'selected' : '' }}>Kelas 12</option>
                        </select>
                        @error('kelas')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun Ajaran <span class="text-red-500">*</span></label>
                        <input type="text" name="tahun_ajaran" value="{{ old('tahun_ajaran', $siswa->tahun_ajaran) }}" placeholder="2024/2025" required 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('tahun_ajaran')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Kelamin <span class="text-red-500">*</span></label>
                        <select name="jenis_kelamin" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Status Siswa <span class="text-red-500">*</span></label>
                        <select name="status_siswa" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Pilih Status</option>
                            <option value="Aktif" {{ old('status_siswa', $siswa->status_siswa) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Pindah" {{ old('status_siswa', $siswa->status_siswa) == 'Pindah' ? 'selected' : '' }}>Pindah</option>
                            <option value="Dikeluarkan" {{ old('status_siswa', $siswa->status_siswa) == 'Dikeluarkan' ? 'selected' : '' }}>Dikeluarkan</option>
                        </select>
                        @error('status_siswa')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <a href="{{ route('admin.siswa.index') }}" class="px-6 py-2 text-gray-600 hover:text-gray-900 font-medium rounded-lg hover:bg-gray-100 transition">
                    <i class="fas fa-times mr-2"></i> Batal
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-save mr-2"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection