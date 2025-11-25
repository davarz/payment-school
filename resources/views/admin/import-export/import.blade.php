@extends('layouts.app')

@section('title', 'Import & Restore Data')

@section('content')
<div class="pt-16 px-6">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Import & Restore Data</h2>

            <!-- Restore Backup -->
            <div class="mb-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Restore dari Backup</h3>
                <form action="{{ route('admin.import-export.process-import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">File Backup (.sql)</label>
                            <input type="file" name="backup_file" accept=".sql" required
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>
                        
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <div class="flex">
                                <i class="fas fa-exclamation-triangle text-red-600 mt-1 mr-3"></i>
                                <div>
                                    <h4 class="text-sm font-medium text-red-800">Peringatan!</h4>
                                    <p class="text-sm text-red-700 mt-1">
                                        Restore backup akan mengganti semua data yang ada. Pastikan Anda sudah membackup data terbaru sebelum melakukan restore.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <button type="submit" 
                            class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg flex items-center">
                            <i class="fas fa-upload mr-2"></i>
                            Restore Backup
                        </button>
                    </div>
                </form>
            </div>

            <!-- Import Data Siswa -->
            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Import Data Siswa</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">File Excel/CSV</label>
                        <input type="file" 
                            class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                    </div>
                    
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex">
                            <i class="fas fa-info-circle text-blue-600 mt-1 mr-3"></i>
                            <div>
                                <h4 class="text-sm font-medium text-blue-800">Format File</h4>
                                <p class="text-sm text-blue-700 mt-1">
                                    Download template Excel untuk import data siswa. Pastikan format kolom sesuai dengan template.
                                </p>
                            </div>
                        </div>
                    </div>

                    <button class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg flex items-center">
                        <i class="fas fa-file-import mr-2"></i>
                        Import Data Siswa
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection