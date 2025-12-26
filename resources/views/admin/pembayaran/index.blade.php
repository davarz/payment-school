@extends('layouts.app')

@section('title', 'Manajemen Pembayaran')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <x-page-header title="Manajemen Pembayaran" subtitle="Verifikasi dan kelola pembayaran siswa" icon="fa-money-bill-wave" />
        <a href="{{ route('admin.pembayaran.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
            <i class="fas fa-plus"></i> Input Manual
        </a>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Pembayaran</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ count($pembayaran) }}</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i class="fas fa-money-bill-wave text-blue-600 text-2xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Menunggu Verifikasi</p>
                    <p class="text-3xl font-bold text-yellow-600 mt-2">{{ $pembayaran->where('status', 'pending')->count() ?? 0 }}</p>
                </div>
                <div class="p-3 bg-yellow-100 rounded-lg">
                    <i class="fas fa-hourglass-half text-yellow-600 text-2xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Terverifikasi</p>
                    <p class="text-3xl font-bold text-green-600 mt-2">{{ $pembayaran->where('status', 'paid')->count() ?? 0 }}</p>
                </div>
                <div class="p-3 bg-green-100 rounded-lg">
                    <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Ditolak</p>
                    <p class="text-3xl font-bold text-red-600 mt-2">{{ $pembayaran->where('status', 'rejected')->count() ?? 0 }}</p>
                </div>
                <div class="p-3 bg-red-100 rounded-lg">
                    <i class="fas fa-times-circle text-red-600 text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-bold mb-4 pb-2 border-b">Filter & Pencarian</h3>
        <form action="{{ route('admin.pembayaran.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Cari Siswa/Kode</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama atau kode transaksi..." 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Metode Pembayaran</label>
                <select name="metode_bayar" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Semua Metode</option>
                    <option value="tunai" {{ request('metode_bayar') == 'tunai' ? 'selected' : '' }}>Tunai</option>
                    <option value="transfer" {{ request('metode_bayar') == 'transfer' ? 'selected' : '' }}>Transfer</option>
                    <option value="qris" {{ request('metode_bayar') == 'qris' ? 'selected' : '' }}>QRIS</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Terverifikasi</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Bulan</label>
                <select name="bulan" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Semua Bulan</option>
                    @for($i=1; $i<=12; $i++)
                        <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>{{ DateTime::createFromFormat('!m', $i)->format('F') }}</option>
                    @endfor
                </select>
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                    <i class="fas fa-filter mr-2"></i>Filter
                </button>
                <a href="{{ route('admin.pembayaran.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                    <i class="fas fa-redo"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- Pembayaran Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Kode Transaksi</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Siswa</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Metode</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Nominal</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($pembayaran as $item)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <p class="text-sm font-mono font-semibold text-gray-900">{{ $item->kode_transaksi }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($item->user->name) }}&background=random" 
                                     alt="{{ $item->user->name }}" class="w-8 h-8 rounded-full">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $item->user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $item->user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-medium text-gray-900 capitalize">{{ $item->metode_bayar }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm font-semibold text-gray-900">Rp {{ number_format($item->jumlah_bayar, 0, ',', '.') }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-900">{{ $item->created_at->format('d M Y') }}</p>
                        </td>
                        <td class="px-6 py-4">
                            @if($item->status === 'paid')
                                <span class="px-3 py-1 inline-flex items-center text-xs font-semibold rounded-full bg-green-100 text-green-700">
                                    <i class="fas fa-check-circle mr-1"></i> Terverifikasi
                                </span>
                            @elseif($item->status === 'pending')
                                <span class="px-3 py-1 inline-flex items-center text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">
                                    <i class="fas fa-hourglass-half mr-1"></i> Pending
                                </span>
                            @else
                                <span class="px-3 py-1 inline-flex items-center text-xs font-semibold rounded-full bg-red-100 text-red-700">
                                    <i class="fas fa-times-circle mr-1"></i> Ditolak
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                @if($item->status === 'pending')
                                    <a href="{{ route('admin.pembayaran.edit', $item->id) }}" class="px-3 py-1 text-sm bg-blue-100 text-blue-600 rounded hover:bg-blue-200 transition">
                                        <i class="fas fa-check"></i> Verifikasi
                                    </a>
                                @else
                                    <button class="px-3 py-1 text-sm text-gray-400 cursor-not-allowed" disabled>
                                        <i class="fas fa-check"></i> Verifikasi
                                    </button>
                                @endif
                                <a href="{{ route('admin.pembayaran.show', $item->id) }}" class="px-3 py-1 text-sm bg-gray-100 text-gray-600 rounded hover:bg-gray-200 transition">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <i class="fas fa-inbox text-4xl text-gray-300 mb-4 block"></i>
                            <p class="text-gray-600 font-medium">Tidak ada pembayaran untuk ditampilkan</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($pembayaran instanceof \Illuminate\Pagination\LengthAwarePaginator)
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
        {{ $pembayaran->links() }}
    </div>
    @endif
</div>
@endsection
