@extends('layouts.app')

@section('title', 'Manajemen Tagihan')

@section('content')
<div class="space-y-8 pb-8">
    <!-- Page Header -->
    <div class="border-b border-gray-200 pb-6">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-4xl font-bold text-gray-900">Tagihan</h1>
                <p class="text-gray-600 mt-2">Kelola tagihan siswa dan monitor status pembayaran</p>
            </div>
            <div class="text-blue-600 text-4xl">
                <i class="fas fa-receipt"></i>
            </div>
        </div>
    </div>

    <!-- Stats Grid - Enhanced -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Tagihan -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl border border-blue-200 p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-blue-600 text-white rounded-lg p-3 text-xl">
                    <i class="fas fa-receipt"></i>
                </div>
                <span class="text-xs font-semibold text-blue-700 bg-blue-200 px-2 py-1 rounded-full">Total</span>
            </div>
            <p class="text-gray-700 text-sm font-medium">Total Tagihan</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $tagihan->total() ?? 0 }}</p>
            <p class="text-xs text-gray-600 mt-2">Tagihan terdaftar</p>
        </div>

        <!-- Tagihan Pending -->
        <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl border border-orange-200 p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-orange-600 text-white rounded-lg p-3 text-xl">
                    <i class="fas fa-hourglass-half"></i>
                </div>
                <span class="text-xs font-semibold text-orange-700 bg-orange-200 px-2 py-1 rounded-full">Pending</span>
            </div>
            <p class="text-gray-700 text-sm font-medium">Tagihan Belum Dibayar</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $tagihan->where('status', 'unpaid')->count() ?? 0 }}</p>
            <p class="text-xs text-gray-600 mt-2">Butuh pembayaran</p>
        </div>

        <!-- Tagihan Lunas -->
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl border border-green-200 p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-green-600 text-white rounded-lg p-3 text-xl">
                    <i class="fas fa-check-circle"></i>
                </div>
                <span class="text-xs font-semibold text-green-700 bg-green-200 px-2 py-1 rounded-full">Lunas</span>
            </div>
            <p class="text-gray-700 text-sm font-medium">Tagihan Lunas</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $tagihan->where('status', 'paid')->count() ?? 0 }}</p>
            <p class="text-xs text-gray-600 mt-2">Sudah dibayar</p>
        </div>

        <!-- Total Nominal -->
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl border border-purple-200 p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-purple-600 text-white rounded-lg p-3 text-xl">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <span class="text-xs font-semibold text-purple-700 bg-purple-200 px-2 py-1 rounded-full">Nominal</span>
            </div>
            <p class="text-gray-700 text-sm font-medium">Total Nominal</p>
            <p class="text-2xl font-bold text-gray-900 mt-2">Rp {{ number_format($tagihan->sum('jumlah_tagihan') ?? 0, 0, ',', '.') }}</p>
            <p class="text-xs text-gray-600 mt-2">Jumlah keseluruhan</p>
        </div>
    </div>

    <!-- Filter & Search Card -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
            <h2 class="text-lg font-bold text-white flex items-center gap-2">
                <i class="fas fa-filter"></i>
                <span>Filter & Pencarian</span>
            </h2>
        </div>
        <div class="p-6">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Cari Siswa</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama atau NIS siswa..." 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                    <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        <option value="">Semua Status</option>
                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Lunas</option>
                        <option value="unpaid" {{ request('status') == 'unpaid' ? 'selected' : '' }}>Belum Dibayar</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori</label>
                    <select name="kategori" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        <option value="">Semua Kategori</option>
                        @foreach(\App\Models\KategoriPembayaran::all() as $cat)
                            <option value="{{ $cat->id }}" {{ request('kategori') == $cat->id ? 'selected' : '' }}>{{ $cat->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
                        <i class="fas fa-search mr-2"></i>Cari
                    </button>
                    @if(request()->hasAny(['search', 'status', 'kategori']))
                    <a href="{{ route('admin.tagihan.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition font-medium text-gray-700">
                        Reset
                    </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Tagihan Table Card -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
            <h2 class="text-lg font-bold text-white flex items-center gap-2">
                <i class="fas fa-list"></i>
                <span>Daftar Tagihan</span>
            </h2>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            @if($tagihan->count() > 0)
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Siswa</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Kategori</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Nominal</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Jatuh Tempo</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Status</th>
                            <th class="px-6 py-3 text-center font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($tagihan as $item)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($item->siswa->user->name) }}&background=3B82F6&color=fff" 
                                         alt="{{ $item->siswa->user->name }}" class="w-10 h-10 rounded-full">
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $item->siswa->user->name }}</p>
                                        <p class="text-xs text-gray-600">{{ $item->siswa->nis }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs font-bold">{{ $item->kategoriPembayaran->nama_kategori }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-bold text-gray-900">Rp {{ number_format($item->jumlah_tagihan, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-gray-900">{{ $item->tanggal_jatuh_tempo->format('d M Y') }}</p>
                            </td>
                            <td class="px-6 py-4">
                                @if($item->status === 'paid')
                                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold inline-flex items-center gap-1">
                                        <i class="fas fa-check-circle"></i> Lunas
                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-xs font-bold inline-flex items-center gap-1">
                                        <i class="fas fa-hourglass-half"></i> Belum Dibayar
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.tagihan.edit', $item->id) }}" class="inline-flex items-center px-3 py-2 rounded-lg bg-blue-100 text-blue-600 hover:bg-blue-200 transition font-medium" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.tagihan.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus tagihan ini?')">
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
                    <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                    <p class="text-gray-600 text-lg font-medium">Tidak ada tagihan untuk ditampilkan</p>
                    <p class="text-gray-500 text-sm mt-2">Coba ubah filter atau cari dengan parameter lain</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Pagination -->
    @if($tagihan instanceof \Illuminate\Pagination\LengthAwarePaginator && $tagihan->hasPages())
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4">
        {{ $tagihan->links() }}
    </div>
    @endif
</div>
@endsection
