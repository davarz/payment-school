@extends('layouts.app')

@section('title', 'Laporan Pembayaran')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <x-page-header
        title="Laporan Pembayaran"
        subtitle="Lihat ringkasan pembayaran, tagihan, dan statistik"
        icon="fa-chart-bar"
    />

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <x-stats-card
            title="Total Pembayaran"
            value="Rp {{ number_format($statistik['total_pembayaran'] ?? 0, 0, ',', '.') }}"
            icon="fa-money-bill"
            color="green"
        />
        <x-stats-card
            title="Total Tagihan"
            value="Rp {{ number_format($statistik['total_tagihan'] ?? 0, 0, ',', '.') }}"
            icon="fa-receipt"
            color="blue"
        />
        <x-stats-card
            title="Tertunggak"
            value="Rp {{ number_format($statistik['total_tunggak'] ?? 0, 0, ',', '.') }}"
            icon="fa-exclamation-circle"
            color="orange"
        />
        <x-stats-card
            title="Tingkat Pembayaran"
            value="{{ $statistik['persentase_pembayaran'] ?? 0 }}%"
            icon="fa-chart-pie"
            color="purple"
        />
    </div>

    <!-- Tabs Navigation -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="flex border-b border-gray-100 overflow-x-auto">
            <a href="{{ route('admin.laporan.index') }}" class="px-6 py-4 font-medium text-blue-600 border-b-2 border-blue-600 whitespace-nowrap">
                <i class="fas fa-chart-line mr-2"></i>Ringkasan
            </a>
            <a href="{{ route('admin.laporan.per-siswa') }}" class="px-6 py-4 font-medium text-gray-600 hover:text-gray-900 border-b-2 border-transparent whitespace-nowrap">
                <i class="fas fa-user mr-2"></i>Per Siswa
            </a>
            <a href="{{ route('admin.laporan.per-kelas') }}" class="px-6 py-4 font-medium text-gray-600 hover:text-gray-900 border-b-2 border-transparent whitespace-nowrap">
                <i class="fas fa-chalkboard-user mr-2"></i>Per Kelas
            </a>
            <a href="{{ route('admin.laporan.statistik') }}" class="px-6 py-4 font-medium text-gray-600 hover:text-gray-900 border-b-2 border-transparent whitespace-nowrap">
                <i class="fas fa-chart-column mr-2"></i>Statistik
            </a>
        </div>

        <!-- Filter Section -->
        <div class="p-6 border-b border-gray-100 bg-gray-50">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Date Range -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Dari Tanggal</label>
                    <input type="date" name="start_date" value="{{ $startDate->format('Y-m-d') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sampai Tanggal</label>
                    <input type="date" name="end_date" value="{{ $endDate->format('Y-m-d') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                </div>

                <!-- Class Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kelas</label>
                    <select name="kelas" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        <option value="">Semua Kelas</option>
                        @foreach($kelasList as $k)
                            <option value="{{ $k }}" {{ $kelas === $k ? 'selected' : '' }}>{{ $k }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Category Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kategori Pembayaran</label>
                    <select name="kategori_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        <option value="">Semua Kategori</option>
                        @foreach($kategoriList as $kat)
                            <option value="{{ $kat->id }}" {{ $kategoriId == $kat->id ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                        <i class="fas fa-filter mr-2"></i>Terapkan Filter
                    </button>
                </div>
                
                <div class="flex items-end gap-2">
                    <a href="{{ route('admin.laporan.index') }}" class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium text-center">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Content -->
        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Pembayaran Section -->
                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Riwayat Pembayaran</h3>
                    @if($pembayaran && $pembayaran->count() > 0)
                        <div class="space-y-3 max-h-96 overflow-y-auto">
                            @foreach($pembayaran as $item)
                                <div class="p-4 border border-gray-200 rounded-lg hover:border-blue-300 transition">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $item->user->siswa->user->name ?? 'N/A' }}</p>
                                            <p class="text-xs text-gray-600 mt-1">{{ $item->kategori->nama_kategori ?? 'N/A' }}</p>
                                        </div>
                                        <x-badge 
                                            :status="$item->status"
                                            class="text-xs"
                                        />
                                    </div>
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="text-gray-600">Rp {{ number_format($item->jumlah_bayar, 0, ',', '.') }}</span>
                                        <span class="text-xs text-gray-500">{{ $item->tanggal_bayar->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <i class="fas fa-inbox text-4xl mb-2"></i>
                            <p>Tidak ada data pembayaran</p>
                        </div>
                    @endif
                </div>

                <!-- Tagihan Section -->
                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Riwayat Tagihan</h3>
                    @if($tagihan && $tagihan->count() > 0)
                        <div class="space-y-3 max-h-96 overflow-y-auto">
                            @foreach($tagihan as $item)
                                <div class="p-4 border border-gray-200 rounded-lg hover:border-blue-300 transition">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $item->user->siswa->user->name ?? 'N/A' }}</p>
                                            <p class="text-xs text-gray-600 mt-1">{{ $item->kategori->nama_kategori ?? 'N/A' }}</p>
                                        </div>
                                        <x-badge 
                                            :status="$item->status"
                                            class="text-xs"
                                        />
                                    </div>
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="font-medium text-gray-900">Rp {{ number_format($item->jumlah_tagihan, 0, ',', '.') }}</span>
                                        <span class="text-xs text-gray-500">Jatuh tempo: {{ $item->tanggal_jatuh_tempo->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <i class="fas fa-inbox text-4xl mb-2"></i>
                            <p>Tidak ada data tagihan</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Export Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Ekspor Laporan</h3>
        <div class="flex flex-col sm:flex-row gap-3">
            <form method="GET" action="{{ route('admin.laporan.export') }}" class="flex-1">
                <input type="hidden" name="type" value="excel">
                <input type="hidden" name="start_date" value="{{ $startDate->format('Y-m-d') }}">
                <input type="hidden" name="end_date" value="{{ $endDate->format('Y-m-d') }}">
                <input type="hidden" name="kelas" value="{{ $kelas }}">
                <input type="hidden" name="kategori_id" value="{{ $kategoriId }}">
                <button type="submit" class="w-full px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-lg transition font-medium flex items-center justify-center">
                    <i class="fas fa-file-excel mr-2"></i>Ekspor Excel
                </button>
            </form>
            <form method="GET" action="{{ route('admin.laporan.export') }}" class="flex-1">
                <input type="hidden" name="type" value="pdf">
                <input type="hidden" name="start_date" value="{{ $startDate->format('Y-m-d') }}">
                <input type="hidden" name="end_date" value="{{ $endDate->format('Y-m-d') }}">
                <input type="hidden" name="kelas" value="{{ $kelas }}">
                <input type="hidden" name="kategori_id" value="{{ $kategoriId }}">
                <button type="submit" class="w-full px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-lg transition font-medium flex items-center justify-center">
                    <i class="fas fa-file-pdf mr-2"></i>Ekspor PDF
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
