@extends('layouts.app')

@section('title', 'Tambah Kategori Pembayaran')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <x-page-header
        title="Tambah Kategori Pembayaran"
        subtitle="Buat kategori pembayaran baru untuk sistem manajemen sekolah"
        icon="fa-plus-circle"
    />

    <!-- Form Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Form Header -->
        <div class="p-6 bg-gradient-to-r from-blue-50 to-blue-100 border-b border-gray-200">
            <div class="flex items-start space-x-3">
                <i class="fas fa-info-circle text-blue-600 mt-1 text-lg"></i>
                <div>
                    <h3 class="font-semibold text-blue-900">Informasi Kategori</h3>
                    <p class="text-sm text-blue-800 mt-1">Lengkapi informasi kategori pembayaran dengan benar</p>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.kategori.store') }}" method="POST" class="p-6 space-y-6">
            @csrf

            <!-- Validation Error Alert -->
            @if ($errors->any())
            <div class="p-4 bg-red-50 border-l-4 border-red-500 rounded">
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

            <!-- Nama Kategori -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Nama Kategori <span class="text-red-500">*</span>
                </label>
                <input type="text" name="nama_kategori" required value="{{ old('nama_kategori') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                    placeholder="Contoh: SPP, Uang Praktikum, dll">
                @error('nama_kategori')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deskripsi -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Deskripsi
                </label>
                <textarea name="deskripsi" rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                    placeholder="Deskripsi kategori pembayaran (opsional)">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jumlah Pembayaran -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Jumlah Pembayaran <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 sm:text-sm">Rp</span>
                    </div>
                    <input type="text" id="jumlah_formatted" required value="{{ old('jumlah') ? number_format(old('jumlah'), 0, ',', '.') : '' }}"
                        class="w-full pl-10 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                        placeholder="0">
                    <input type="hidden" name="jumlah" id="jumlah_hidden" value="{{ old('jumlah') }}">
                </div>
                @error('jumlah')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Frekuensi & Auto Generate Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Frekuensi Tagihan <span class="text-red-500">*</span>
                    </label>
                    <select name="frekuensi" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        <option value="">-- Pilih Frekuensi --</option>
                        <option value="bulanan" {{ old('frekuensi') === 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                        <option value="semester" {{ old('frekuensi') === 'semester' ? 'selected' : '' }}>Semester</option>
                        <option value="tahunan" {{ old('frekuensi') === 'tahunan' ? 'selected' : '' }}>Tahunan</option>
                    </select>
                    <p class="text-xs text-gray-500 mt-1">
                        Pilih frekuensi generate tagihan otomatis
                    </p>
                    @error('frekuensi')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Auto Generate Tagihan
                    </label>
                    <div class="flex items-center pt-2">
                        <input type="checkbox" name="auto_generate" id="auto_generate" value="1"
                            {{ old('auto_generate') ? 'checked' : 'checked' }}
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="auto_generate" class="ml-2 block text-sm text-gray-700">
                            Aktifkan auto generate tagihan
                        </label>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">
                        Tagihan akan digenerate otomatis sesuai frekuensi
                    </p>
                </div>
            </div>

            <!-- Info Box tentang Frekuensi -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-start">
                    <i class="fas fa-info-circle text-blue-600 mt-1 mr-3"></i>
                    <div>
                        <h4 class="text-sm font-medium text-blue-800">Info Frekuensi Tagihan</h4>
                        <ul class="text-xs text-blue-700 mt-1 space-y-1" id="frekuensi-info">
                            <li>• <strong>Bulanan:</strong> Tagihan digenerate otomatis setiap bulan</li>
                            <li>• <strong>Semester:</strong> Tagihan digenerate 2x setahun (Januari & Juli)</li>
                            <li>• <strong>Tahunan:</strong> Tagihan digenerate 1x setahun (Juli)</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Tahun Ajaran & Semester -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Tahun Ajaran <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="tahun_ajaran" required value="{{ old('tahun_ajaran') ?? now()->year . '/' . (now()->year + 1) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                        placeholder="2024/2025">
                    @error('tahun_ajaran')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Semester <span class="text-red-500">*</span>
                    </label>
                    <select name="semester" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        <option value="">-- Pilih Semester --</option>
                        <option value="ganjil" {{ old('semester') === 'ganjil' ? 'selected' : (now()->month >= 7 ? 'selected' : '') }}>Ganjil</option>
                        <option value="genap" {{ old('semester') === 'genap' ? 'selected' : (now()->month < 7 ? 'selected' : '') }}>Genap</option>
                    </select>
                    @error('semester')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Status <span class="text-red-500">*</span>
                </label>
                <select name="status" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    <option value="">-- Pilih Status --</option>
                    <option value="active" {{ old('status') === 'active' ? 'selected' : 'selected' }}>Aktif</option>
                    <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                </select>
                @error('status')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Button Section -->
            <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.kategori.index') }}" class="inline-flex items-center px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition">
                    <i class="fas fa-times mr-2"></i>
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-save mr-2"></i>
                    Simpan Kategori
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Real-time info update berdasarkan pilihan frekuensi
    document.addEventListener('DOMContentLoaded', function() {
        const frekuensiSelect = document.querySelector('select[name="frekuensi"]');
        const infoBox = document.querySelector('#frekuensi-info');

        function updateInfo() {
            const selectedValue = frekuensiSelect.value;
            let infoText = '';

            switch(selectedValue) {
                case 'bulanan':
                    infoText = '<li class="text-green-600 font-medium">Tagihan akan digenerate otomatis setiap tanggal 1 bulan berikutnya untuk semua siswa aktif.</li>';
                    break;
                case 'semester':
                    infoText = '<li class="text-green-600 font-medium">Tagihan akan digenerate otomatis setiap bulan Januari dan Juli untuk semua siswa aktif.</li>';
                    break;
                case 'tahunan':
                    infoText = '<li class="text-green-600 font-medium">Tagihan akan digenerate otomatis setiap bulan Juli untuk semua siswa aktif.</li>';
                    break;
                default:
                    infoText = '<li>• <strong>Bulanan:</strong> Tagihan digenerate otomatis setiap bulan</li>' +
                               '<li>• <strong>Semester:</strong> Tagihan digenerate 2x setahun (Januari & Juli)</li>' +
                               '<li>• <strong>Tahunan:</strong> Tagihan digenerate 1x setahun (Juli)</li>';
            }

            infoBox.innerHTML = infoText;
        }

        frekuensiSelect.addEventListener('change', updateInfo);
        updateInfo(); // Initial update

        // Format jumlah pembayaran as Rupiah
        const jumlahFormatted = document.getElementById('jumlah_formatted');
        const jumlahHidden = document.getElementById('jumlah_hidden');

        function formatRupiah(angka) {
            if (angka === '' || isNaN(angka)) return '';
            // Convert to number and format with commas
            const number = parseFloat(angka);
            if (isNaN(number)) return '';
            return number.toLocaleString('id-ID');
        }

        function unformatRupiah(rupiah) {
            // Remove all non-numeric characters except decimal point
            return rupiah.replace(/[^\d.]/g, '');
        }

        // Initialize with formatted value
        if (jumlahHidden.value) {
            jumlahFormatted.value = formatRupiah(jumlahHidden.value);
        }

        if (jumlahFormatted) {
            // Format on blur (when user leaves the field)
            jumlahFormatted.addEventListener('blur', function() {
                const value = this.value;
                if (value) {
                    const numericValue = unformatRupiah(value);
                    jumlahHidden.value = numericValue;
                    this.value = formatRupiah(numericValue);
                }
            });

            // Unformat on focus (when user clicks on the field) so they can edit the number
            jumlahFormatted.addEventListener('focus', function() {
                const numericValue = jumlahHidden.value;
                if (numericValue) {
                    this.value = numericValue;
                }
            });

            // Update hidden field on input (for real-time validation)
            jumlahFormatted.addEventListener('input', function() {
                const value = this.value;
                const numericValue = unformatRupiah(value);
                jumlahHidden.value = numericValue;
            });
        }
    });
</script>
@endsection