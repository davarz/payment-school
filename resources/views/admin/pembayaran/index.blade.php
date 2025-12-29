@extends('layouts.app')

@section('title', 'Manajemen Pembayaran')

@section('content')
<div class="space-y-8 pb-8">
    <!-- Page Header -->
    <div class="border-b border-gray-200 pb-6">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-4xl font-bold text-gray-900">Pembayaran</h1>
                <p class="text-gray-600 mt-2">Verifikasi dan kelola semua pembayaran siswa</p>
            </div>
            <div class="text-blue-600 text-4xl">
                <i class="fas fa-money-bill-wave"></i>
            </div>
        </div>
    </div>

    <!-- Stats Grid - Enhanced -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Pembayaran -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl border border-blue-200 p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-blue-600 text-white rounded-lg p-3 text-xl">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <span class="text-xs font-semibold text-blue-700 bg-blue-200 px-2 py-1 rounded-full">Total</span>
            </div>
            <p class="text-gray-700 text-sm font-medium">Total Pembayaran</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ count($pembayaran) }}</p>
            <p class="text-xs text-gray-600 mt-2">Pembayaran terdaftar</p>
        </div>

        <!-- Menunggu Verifikasi -->
        <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl border border-orange-200 p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-orange-600 text-white rounded-lg p-3 text-xl">
                    <i class="fas fa-hourglass-half"></i>
                </div>
                <span class="text-xs font-semibold text-orange-700 bg-orange-200 px-2 py-1 rounded-full">Pending</span>
            </div>
            <p class="text-gray-700 text-sm font-medium">Menunggu Verifikasi</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $pembayaran->where('status', 'pending')->count() ?? 0 }}</p>
            <p class="text-xs text-gray-600 mt-2">Butuh verifikasi</p>
        </div>

        <!-- Terverifikasi -->
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl border border-green-200 p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-green-600 text-white rounded-lg p-3 text-xl">
                    <i class="fas fa-check-circle"></i>
                </div>
                <span class="text-xs font-semibold text-green-700 bg-green-200 px-2 py-1 rounded-full">Terverifikasi</span>
            </div>
            <p class="text-gray-700 text-sm font-medium">Terverifikasi</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $pembayaran->where('status', 'paid')->count() ?? 0 }}</p>
            <p class="text-xs text-gray-600 mt-2">Sudah diverifikasi</p>
        </div>

        <!-- Ditolak -->
        <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-xl border border-red-200 p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-red-600 text-white rounded-lg p-3 text-xl">
                    <i class="fas fa-times-circle"></i>
                </div>
                <span class="text-xs font-semibold text-red-700 bg-red-200 px-2 py-1 rounded-full">Ditolak</span>
            </div>
            <p class="text-gray-700 text-sm font-medium">Ditolak</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $pembayaran->where('status', 'rejected')->count() ?? 0 }}</p>
            <p class="text-xs text-gray-600 mt-2">Pembayaran ditolak</p>
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
            <form action="{{ route('admin.pembayaran.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Cari Siswa/Kode</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama atau kode transaksi..." 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Metode Pembayaran</label>
                    <select name="metode_bayar" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        <option value="">Semua Metode</option>
                        <option value="tunai" {{ request('metode_bayar') == 'tunai' ? 'selected' : '' }}>Tunai</option>
                        <option value="transfer" {{ request('metode_bayar') == 'transfer' ? 'selected' : '' }}>Transfer</option>
                        <option value="qris" {{ request('metode_bayar') == 'qris' ? 'selected' : '' }}>QRIS</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                    <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Terverifikasi</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Bulan</label>
                    <select name="bulan" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        <option value="">Semua Bulan</option>
                        @for($i=1; $i<=12; $i++)
                            <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>{{ DateTime::createFromFormat('!m', $i)->format('F') }}</option>
                        @endfor
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
                        <i class="fas fa-search mr-2"></i>Cari
                    </button>
                    @if(request()->hasAny(['search', 'metode_bayar', 'status', 'bulan']))
                    <a href="{{ route('admin.pembayaran.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition font-medium text-gray-700">
                        Reset
                    </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Pembayaran Table Card -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
            <h2 class="text-lg font-bold text-white flex items-center gap-2">
                <i class="fas fa-list"></i>
                <span>Daftar Pembayaran</span>
            </h2>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            @if($pembayaran->count() > 0)
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Kode Transaksi</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Siswa</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Metode</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Nominal</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Tanggal</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Status</th>
                            <th class="px-6 py-3 text-center font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($pembayaran as $item)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <p class="text-sm font-mono font-semibold text-gray-900">{{ substr($item->kode_transaksi, 0, 12) }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($item->user->name) }}&background=3B82F6&color=fff" 
                                         alt="{{ $item->user->name }}" class="w-10 h-10 rounded-full">
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $item->user->name }}</p>
                                        <p class="text-xs text-gray-600">{{ $item->user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($item->metode_bayar === 'tunai')
                                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">💵 Tunai</span>
                                @elseif($item->metode_bayar === 'transfer')
                                    <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold">🏦 Transfer</span>
                                @else
                                    <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-bold">📱 QRIS</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-bold text-gray-900">Rp {{ number_format($item->jumlah_bayar, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-gray-900">{{ $item->created_at->format('d M Y') }}</p>
                            </td>
                            <td class="px-6 py-4">
                                @if($item->status === 'paid')
                                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold inline-flex items-center gap-1">
                                        <i class="fas fa-check-circle"></i> Terverifikasi
                                    </span>
                                @elseif($item->status === 'pending')
                                    <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-xs font-bold inline-flex items-center gap-1">
                                        <i class="fas fa-hourglass-half"></i> Pending
                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold inline-flex items-center gap-1">
                                        <i class="fas fa-times-circle"></i> Ditolak
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    @if($item->status === 'pending')
                                        <a href="{{ route('admin.pembayaran.edit', $item->id) }}" class="inline-flex items-center px-3 py-2 rounded-lg bg-blue-100 text-blue-600 hover:bg-blue-200 transition font-medium" title="Verifikasi">
                                            <i class="fas fa-check"></i>
                                        </a>
                                    @else
                                        <button class="inline-flex items-center px-3 py-2 rounded-lg bg-gray-100 text-gray-400 cursor-not-allowed" disabled title="Tidak dapat diverifikasi">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    @endif
                                    <a href="{{ route('admin.pembayaran.show', $item->id) }}" class="inline-flex items-center px-3 py-2 rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200 transition font-medium" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="text-center py-16">
                    <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                    <p class="text-gray-600 text-lg font-medium">Tidak ada pembayaran untuk ditampilkan</p>
                    <p class="text-gray-500 text-sm mt-2">Coba ubah filter atau cari dengan parameter lain</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Pagination -->
    @if($pembayaran instanceof \Illuminate\Pagination\LengthAwarePaginator && $pembayaran->hasPages())
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4">
        {{ $pembayaran->links() }}
    </div>
    @endif
</div>
@endsection
