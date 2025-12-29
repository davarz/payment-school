@extends('layouts.app')

@section('title', 'Import & Restore Data')

@section('content')
<div class="space-y-8 pb-8">
    <!-- Page Header -->
    <div class="border-b border-gray-200 pb-6">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-4xl font-bold text-gray-900">Import & Restore</h1>
                <p class="text-gray-600 mt-2">Impor data dan restore backup database sekolah</p>
            </div>
            <div class="text-purple-600 text-4xl">
                <i class="fas fa-upload"></i>
            </div>
        </div>
    </div>

    <!-- Restore Backup Card -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4 flex items-center">
            <i class="fas fa-database text-white text-2xl mr-4"></i>
            <div>
                <h2 class="text-xl font-bold text-white">Restore dari Backup</h2>
                <p class="text-red-100 text-sm mt-1">Kembalikan database dari file backup</p>
            </div>
        </div>
        <div class="p-6">
            <form action="{{ route('admin.import-export.process-import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">File Backup (.sql)</label>
                        <input type="file" name="backup_file" accept=".sql" required
                            class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg focus:border-red-500 focus:ring-2 focus:ring-red-200 transition text-sm">
                        <p class="text-xs text-gray-500 mt-2">File maksimal 100MB dalam format .sql</p>
                    </div>
                    
                    <div class="bg-red-50 border-l-4 border-red-600 rounded-lg p-4">
                        <div class="flex">
                            <i class="fas fa-exclamation-triangle text-red-600 mt-1 mr-3 text-lg"></i>
                            <div>
                                <h4 class="text-sm font-bold text-red-900">⚠️ Peringatan!</h4>
                                <p class="text-sm text-red-800 mt-1">
                                    Restore backup akan mengganti SEMUA data yang ada. Pastikan Anda sudah membuat backup data terbaru sebelum melakukan restore. Aksi ini tidak dapat dibatalkan!
                                </p>
                            </div>
                        </div>
                    </div>

                    <button type="submit" 
                        class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-3 rounded-lg flex items-center justify-center transition">
                        <i class="fas fa-upload mr-2"></i>
                        Restore Backup Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Import Data Siswa Card -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4 flex items-center">
            <i class="fas fa-file-import text-white text-2xl mr-4"></i>
            <div>
                <h2 class="text-xl font-bold text-white">Import Data Siswa</h2>
                <p class="text-green-100 text-sm mt-1">Impor daftar siswa dari file Excel/CSV</p>
            </div>
        </div>
        <div class="p-6">
            <form action="{{ route('admin.import-export.process-siswa') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">File Excel/CSV</label>
                        <input type="file" name="siswa_file" accept=".xlsx,.xls,.csv" required
                            class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-200 transition text-sm">
                        <p class="text-xs text-gray-500 mt-2">Format: .xlsx, .xls, atau .csv (maksimal 5MB)</p>
                    </div>
                    
                    <div class="bg-blue-50 border-l-4 border-blue-600 rounded-lg p-4">
                        <div class="flex">
                            <i class="fas fa-info-circle text-blue-600 mt-1 mr-3 text-lg"></i>
                            <div>
                                <h4 class="text-sm font-bold text-blue-900">📋 Format File</h4>
                                <p class="text-sm text-blue-800 mt-1">
                                    Download template Excel untuk memastikan format kolom sesuai. Kolom yang diperlukan: NIS, Nama, Kelas, Tahun Ajaran, Status.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <a href="{{ route('admin.import-export.download-template') }}" 
                            class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-4 py-3 rounded-lg flex items-center justify-center transition">
                            <i class="fas fa-download mr-2"></i>
                            Download Template
                        </a>
                        <button type="submit" 
                            class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-3 rounded-lg flex items-center justify-center transition">
                            <i class="fas fa-file-import mr-2"></i>
                            Import Data
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection