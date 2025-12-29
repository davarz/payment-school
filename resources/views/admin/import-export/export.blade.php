@extends('layouts.app')

@section('title', 'Backup & Export Data')

@section('content')
<div class="space-y-8 pb-8">
    <!-- Page Header -->
    <div class="border-b border-gray-200 pb-6">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-4xl font-bold text-gray-900">Backup & Export</h1>
                <p class="text-gray-600 mt-2">Backup database dan ekspor data sekolah</p>
            </div>
            <div class="text-blue-600 text-4xl">
                <i class="fas fa-download"></i>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Siswa -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl border border-blue-200 p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-blue-600 text-white rounded-lg p-3 text-xl">
                    <i class="fas fa-users"></i>
                </div>
                <span class="text-xs font-semibold text-blue-700 bg-blue-200 px-2 py-1 rounded-full">Total</span>
            </div>
            <p class="text-gray-700 text-sm font-medium">Total Siswa</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ \App\Models\User::where('role', 'siswa')->count() }}</p>
            <p class="text-xs text-gray-600 mt-2">Data siswa terdaftar</p>
        </div>

        <!-- Total Transaksi -->
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl border border-green-200 p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-green-600 text-white rounded-lg p-3 text-xl">
                    <i class="fas fa-exchange-alt"></i>
                </div>
                <span class="text-xs font-semibold text-green-700 bg-green-200 px-2 py-1 rounded-full">Total</span>
            </div>
            <p class="text-gray-700 text-sm font-medium">Total Transaksi</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ \App\Models\Pembayaran::count() }}</p>
            <p class="text-xs text-gray-600 mt-2">Pembayaran tercatat</p>
        </div>

        <!-- Kategori Bayar -->
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl border border-purple-200 p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-purple-600 text-white rounded-lg p-3 text-xl">
                    <i class="fas fa-list"></i>
                </div>
                <span class="text-xs font-semibold text-purple-700 bg-purple-200 px-2 py-1 rounded-full">Total</span>
            </div>
            <p class="text-gray-700 text-sm font-medium">Kategori Bayar</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ \App\Models\KategoriPembayaran::count() }}</p>
            <p class="text-xs text-gray-600 mt-2">Kategori pembayaran aktif</p>
        </div>

        <!-- Tagihan Tertunggak -->
        <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl border border-orange-200 p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-orange-600 text-white rounded-lg p-3 text-xl">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
                <span class="text-xs font-semibold text-orange-700 bg-orange-200 px-2 py-1 rounded-full">Pending</span>
            </div>
            <p class="text-gray-700 text-sm font-medium">Tagihan Tertunggak</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ \App\Models\Tagihan::where('status', 'unpaid')->count() }}</p>
            <p class="text-xs text-gray-600 mt-2">Tagihan belum dibayar</p>
        </div>
    </div>

    <!-- Export Options -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Backup Database -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 flex items-center">
                <i class="fas fa-database text-white text-2xl mr-4"></i>
                <div>
                    <h3 class="text-lg font-bold text-white">Backup Database</h3>
                    <p class="text-blue-100 text-sm mt-1">Download full backup dalam format SQL</p>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <p class="text-gray-600 text-sm">Download backup lengkap database untuk keamanan data. File ini dapat digunakan untuk restore data jika diperlukan.</p>
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                        <p class="text-xs text-blue-800"><strong>Ukuran backup:</strong> Dihitung otomatis saat download</p>
                    </div>
                    <a href="{{ route('admin.import-export.download-backup') }}" 
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg flex items-center justify-center transition">
                        <i class="fas fa-download mr-2"></i>
                        Download Backup Database
                    </a>
                </div>
            </div>
        </div>

        <!-- Export Data Siswa -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4 flex items-center">
                <i class="fas fa-file-excel text-white text-2xl mr-4"></i>
                <div>
                    <h3 class="text-lg font-bold text-white">Export Data Siswa</h3>
                    <p class="text-green-100 text-sm mt-1">Ekspor ke format Excel/CSV</p>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <p class="text-gray-600 text-sm">Export seluruh data siswa ke format Excel untuk analisis lebih lanjut atau integrasi dengan sistem lain.</p>
                    <div class="bg-green-50 border border-green-200 rounded-lg p-3">
                        <p class="text-xs text-green-800"><strong>Total data:</strong> {{ \App\Models\User::where('role', 'siswa')->count() }} siswa akan diekspor</p>
                    </div>
                    <form action="{{ route('admin.import-export.export-siswa') }}" method="POST" class="flex gap-2">
                        @csrf
                        <select name="format" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition text-sm">
                            <option value="excel">Format Excel (.xlsx)</option>
                            <option value="csv">Format CSV (.csv)</option>
                        </select>
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded-lg flex items-center transition">
                            <i class="fas fa-file-export mr-2"></i>
                            Export
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Export Options -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-6 py-4 flex items-center">
            <i class="fas fa-file-export text-white text-2xl mr-4"></i>
            <div>
                <h3 class="text-lg font-bold text-white">Opsi Export Lainnya</h3>
                <p class="text-purple-100 text-sm mt-1">Export data pembayaran dan tagihan</p>
            </div>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <form action="{{ route('admin.import-export.export-pembayaran') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold px-4 py-3 rounded-lg flex items-center justify-center transition">
                        <i class="fas fa-money-bill-wave mr-2"></i>
                        Export Data Pembayaran
                    </button>
                </form>
                <form action="{{ route('admin.import-export.export-tagihan') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-orange-600 hover:bg-orange-700 text-white font-semibold px-4 py-3 rounded-lg flex items-center justify-center transition">
                        <i class="fas fa-receipt mr-2"></i>
                        Export Data Tagihan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection