@extends('layouts.app')

@section('title', 'Kategori Pembayaran')

@section('content')
<div class="space-y-8 pb-8">
    <!-- Page Header -->
    <div class="border-b border-gray-200 pb-6">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-4xl font-bold text-gray-900">Kategori Pembayaran</h1>
                <p class="text-gray-600 mt-2">Kelola kategori pembayaran dan atur besaran biaya sekolah</p>
            </div>
            <div class="text-blue-600 text-4xl">
                <i class="fas fa-list-alt"></i>
            </div>
        </div>
    </div>

    <!-- Kategori Table Card -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 flex items-center justify-between">
            <h2 class="text-lg font-bold text-white flex items-center gap-2">
                <i class="fas fa-folder-open"></i>
                <span>Daftar Kategori</span>
            </h2>
            <a href="{{ route('admin.kategori.create') }}" class="inline-flex items-center px-4 py-2 bg-white text-blue-600 rounded-lg hover:bg-blue-50 transition font-semibold">
                <i class="fas fa-plus mr-2"></i>Tambah Kategori
            </a>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            @if($kategori && $kategori->count() > 0)
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Nama Kategori</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Jumlah</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Tahun Ajaran</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Semester</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Auto Generate</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Status</th>
                            <th class="px-6 py-3 text-center font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($kategori as $item)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $item->nama_kategori }}</p>
                                    <p class="text-xs text-gray-600 mt-1">{{ $item->deskripsi }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-bold text-gray-900">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-bold">{{ $item->tahun_ajaran }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs font-bold">{{ ucfirst($item->semester) }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($item->auto_generate)
                                    <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold flex items-center gap-1 w-fit">
                                        <i class="fas fa-check-circle"></i> Ya
                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-bold flex items-center gap-1 w-fit">
                                        <i class="fas fa-times-circle"></i> Tidak
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($item->status == 'active')
                                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold flex items-center gap-1 w-fit">
                                        <i class="fas fa-circle-notch animate-spin"></i> Aktif
                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold flex items-center gap-1 w-fit">
                                        <i class="fas fa-times-circle"></i> Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.kategori.edit', $item->id) }}" class="inline-flex items-center px-3 py-2 rounded-lg bg-blue-100 text-blue-600 hover:bg-blue-200 transition font-medium" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.kategori.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus kategori ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-3 py-2 rounded-lg bg-red-100 text-red-600 hover:bg-red-200 transition font-medium" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="text-center py-16">
                    <i class="fas fa-folder text-6xl text-gray-300 mb-4"></i>
                    <p class="text-gray-600 text-lg font-medium">Belum ada kategori pembayaran</p>
                    <p class="text-gray-500 text-sm mt-2">Mulai dengan menambahkan kategori pembayaran baru</p>
                    <a href="{{ route('admin.kategori.create') }}" class="inline-flex items-center mt-6 px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
                        <i class="fas fa-plus mr-2"></i>Tambah Kategori
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection