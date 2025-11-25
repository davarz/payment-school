@extends('layouts.app')

@section('title', 'Tambah Kategori Pembayaran')

@section('content')
<div class="pt-16 px-6">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Tambah Kategori Pembayaran</h2>

            <form action="{{ route('admin.kategori.store') }}" method="POST">
                @csrf
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Kategori</label>
                        <input type="text" name="nama_kategori" required 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Contoh: SPP, Uang Praktikum, dll">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea name="deskripsi" rows="3" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Deskripsi kategori pembayaran (optional)"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jumlah Pembayaran</label>
                        <input type="number" name="jumlah" required min="0" step="0.01"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="0">
                    </div>

                    <!-- 🔥 NEW: Frekuensi & Auto Generate Section -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Frekuensi Tagihan</label>
                            <select name="frekuensi" required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="bulanan">Bulanan</option>
                                <option value="semester">Semester</option>
                                <option value="tahunan">Tahunan</option>
                            </select>
                            <p class="text-xs text-gray-500 mt-1">
                                Pilih frekuensi generate tagihan otomatis
                            </p>
                        </div>

                        <div class="flex items-center justify-center">
                            <div class="flex items-center">
                                <input type="checkbox" name="auto_generate" id="auto_generate" value="1" checked
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="auto_generate" class="ml-2 block text-sm text-gray-700">
                                    Auto Generate Tagihan
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Info Box tentang Frekuensi -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex items-start">
                            <i class="fas fa-info-circle text-blue-500 mt-1 mr-3"></i>
                            <div>
                                <h4 class="text-sm font-medium text-blue-800">Info Frekuensi Tagihan</h4>
                                <ul class="text-xs text-blue-700 mt-1 space-y-1">
                                    <li>• <strong>Bulanan:</strong> Tagihan digenerate otomatis setiap bulan</li>
                                    <li>• <strong>Semester:</strong> Tagihan digenerate 2x setahun (Januari & Juli)</li>
                                    <li>• <strong>Tahunan:</strong> Tagihan digenerate 1x setahun (Juli)</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tahun Ajaran</label>
                            <input type="text" name="tahun_ajaran" required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="2024/2025"
                                value="{{ now()->year }}/{{ now()->year + 1 }}">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Semester</label>
                            <select name="semester" required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="ganjil" {{ now()->month >= 7 ? 'selected' : '' }}>Ganjil</option>
                                <option value="genap" {{ now()->month < 7 ? 'selected' : '' }}>Genap</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex justify-end space-x-3">
                    <a href="{{ route('admin.kategori.index') }}" 
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg transition duration-200">
                        Batal
                    </a>
                    <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition duration-200">
                        Simpan Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Real-time info update berdasarkan pilihan frekuensi
    document.addEventListener('DOMContentLoaded', function() {
        const frekuensiSelect = document.querySelector('select[name="frekuensi"]');
        const infoBox = document.querySelector('.bg-blue-50');
        
        function updateInfo() {
            const selectedValue = frekuensiSelect.value;
            let infoText = '';
            
            switch(selectedValue) {
                case 'bulanan':
                    infoText = 'Tagihan akan digenerate otomatis setiap tanggal 1 bulan berikutnya untuk semua siswa aktif.';
                    break;
                case 'semester':
                    infoText = 'Tagihan akan digenerate otomatis setiap bulan Januari dan Juli untuk semua siswa aktif.';
                    break;
                case 'tahunan':
                    infoText = 'Tagihan akan digenerate otomatis setiap bulan Juli untuk semua siswa aktif.';
                    break;
            }
            
            const infoElement = infoBox.querySelector('ul');
            infoElement.innerHTML = `<li class="text-green-600 font-medium">${infoText}</li>`;
        }
        
        frekuensiSelect.addEventListener('change', updateInfo);
        updateInfo(); // Initial update
    });
</script>
@endsection