@extends('layouts.app')

@section('title', 'Backup & Export Data')

@section('content')
<div class="pt-16 px-6">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Backup & Export Data</h2>

            <!-- Export Options -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Backup Database -->
                <div class="border border-gray-200 rounded-lg p-6">
                    <div class="flex items-center mb-4">
                        <div class="p-3 bg-blue-100 rounded-lg mr-4">
                            <i class="fas fa-database text-blue-600 text-xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">Backup Database</h3>
                    </div>
                    <p class="text-gray-600 mb-4">Download backup lengkap database dalam format SQL</p>
                    <a href="{{ route('admin.import-export.download-backup') }}" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg inline-flex items-center">
                        <i class="fas fa-download mr-2"></i>
                        Download Backup
                    </a>
                </div>

                <!-- Export Data Siswa -->
                <div class="border border-gray-200 rounded-lg p-6">
                    <div class="flex items-center mb-4">
                        <div class="p-3 bg-green-100 rounded-lg mr-4">
                            <i class="fas fa-users text-green-600 text-xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">Export Data Siswa</h3>
                    </div>
                    <p class="text-gray-600 mb-4">Export data siswa ke format Excel/CSV</p>
                    <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg inline-flex items-center">
                        <i class="fas fa-file-excel mr-2"></i>
                        Export Excel
                    </button>
                </div>
            </div>

            <!-- Statistics -->
            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Statistik Data</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-gray-50 rounded-lg p-4 text-center">
                        <p class="text-2xl font-bold text-gray-900">{{ \App\Models\User::where('role', 'siswa')->count() }}</p>
                        <p class="text-sm text-gray-600">Total Siswa</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4 text-center">
                        <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Pembayaran::count() }}</p>
                        <p class="text-sm text-gray-600">Total Transaksi</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4 text-center">
                        <p class="text-2xl font-bold text-gray-900">{{ \App\Models\KategoriPembayaran::count() }}</p>
                        <p class="text-sm text-gray-600">Kategori Bayar</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4 text-center">
                        <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Tagihan::where('status', 'pending')->count() }}</p>
                        <p class="text-sm text-gray-600">Tagihan Pending</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection