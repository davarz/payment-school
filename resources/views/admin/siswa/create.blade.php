@extends('layouts.app')

@section('title', 'Tambah Siswa')

@section('content')
<div class="pt-16 px-6">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Tambah Siswa Baru</h2>

            <!-- Info Auto Password -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <div class="flex">
                    <i class="fas fa-info-circle text-blue-600 mt-1 mr-3"></i>
                    <div>
                        <h4 class="text-sm font-medium text-blue-800">Info Login Siswa</h4>
                        <p class="text-sm text-blue-700 mt-1">
                            Password akan digenerate otomatis dari <strong>3 huruf pertama nama + 4 digit terakhir NIS</strong>.
                            Contoh: <strong>Dava</strong> + <strong>0809</strong> = <strong>dav0809</strong>
                        </p>
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.siswa.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Data Pribadi -->
                    <div class="md:col-span-2">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Data Pribadi</h3>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Lengkap *</label>
                        <input type="text" name="name" required 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Contoh: Dava Setiawan">
                        <p class="text-xs text-gray-500 mt-1">Untuk generate password</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email *</label>
                        <input type="email" name="email" required 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="dava@school.com">
                        <p class="text-xs text-gray-500 mt-1">Untuk login</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">NIS *</label>
                        <input type="text" name="nis" required 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Contoh: 190809">
                        <p class="text-xs text-gray-500 mt-1">4 digit terakhir untuk password</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">NIK *</label>
                        <input type="text" name="nik" required 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <!-- Data Sekolah -->
                    <div class="md:col-span-2">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Data Sekolah</h3>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tahun Ajaran *</label>
                        <input type="text" name="tahun_ajaran" required 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="2024/2025">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kelas *</label>
                        <input type="text" name="kelas" required 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="X IPA 1">
                    </div>

                    <!-- Kontak -->
                    <div class="md:col-span-2">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Kontak & Lainnya</h3>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Alamat *</label>
                        <textarea name="alamat" rows="3" required 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Telepon *</label>
                        <input type="text" name="telepon" required 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tempat Lahir *</label>
                        <input type="text" name="tempat_lahir" required 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal Lahir *</label>
                        <input type="date" name="tanggal_lahir" required 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>

                <div class="mt-8 flex justify-end space-x-3">
                    <a href="{{ route('admin.siswa.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">
                        Batal
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                        Simpan Siswa
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection