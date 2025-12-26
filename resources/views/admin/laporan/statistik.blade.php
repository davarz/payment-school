@extends('layouts.app')

@section('title', 'Statistik Pembayaran')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <x-page-header
        title="Statistik Pembayaran"
        subtitle="Dashboard statistik pembayaran dan tagihan"
        icon="fa-chart-column"
    />

    <!-- Tabs Navigation -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="flex border-b border-gray-100 overflow-x-auto">
            <a href="{{ route('admin.laporan.index') }}" class="px-6 py-4 font-medium text-gray-600 hover:text-gray-900 border-b-2 border-transparent whitespace-nowrap">
                <i class="fas fa-chart-line mr-2"></i>Ringkasan
            </a>
            <a href="{{ route('admin.laporan.per-siswa') }}" class="px-6 py-4 font-medium text-gray-600 hover:text-gray-900 border-b-2 border-transparent whitespace-nowrap">
                <i class="fas fa-user mr-2"></i>Per Siswa
            </a>
            <a href="{{ route('admin.laporan.per-kelas') }}" class="px-6 py-4 font-medium text-gray-600 hover:text-gray-900 border-b-2 border-transparent whitespace-nowrap">
                <i class="fas fa-chalkboard-user mr-2"></i>Per Kelas
            </a>
            <a href="{{ route('admin.laporan.statistik') }}" class="px-6 py-4 font-medium text-blue-600 border-b-2 border-blue-600 whitespace-nowrap">
                <i class="fas fa-chart-column mr-2"></i>Statistik
            </a>
        </div>

        <!-- Content -->
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <!-- Overall Stats -->
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-xl border border-blue-200">
                    <p class="text-gray-600 text-sm font-medium mb-2">Total Pembayaran</p>
                    <p class="text-3xl font-bold text-blue-700">Rp {{ number_format($statistik['total_pembayaran'] ?? 0, 0, ',', '.') }}</p>
                    <p class="text-xs text-blue-600 mt-2">{{ $statistik['jumlah_pembayaran'] ?? 0 }} transaksi</p>
                </div>

                <div class="bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-xl border border-green-200">
                    <p class="text-gray-600 text-sm font-medium mb-2">Pembayaran Terverifikasi</p>
                    <p class="text-3xl font-bold text-green-700">Rp {{ number_format($statistik['total_pembayaran_terverifikasi'] ?? 0, 0, ',', '.') }}</p>
                    <p class="text-xs text-green-600 mt-2">{{ $statistik['jumlah_pembayaran_terverifikasi'] ?? 0 }} transaksi</p>
                </div>

                <div class="bg-gradient-to-br from-orange-50 to-orange-100 p-6 rounded-xl border border-orange-200">
                    <p class="text-gray-600 text-sm font-medium mb-2">Total Tagihan</p>
                    <p class="text-3xl font-bold text-orange-700">Rp {{ number_format($statistik['total_tagihan'] ?? 0, 0, ',', '.') }}</p>
                    <p class="text-xs text-orange-600 mt-2">{{ $statistik['jumlah_tagihan'] ?? 0 }} tagihan</p>
                </div>

                <div class="bg-gradient-to-br from-red-50 to-red-100 p-6 rounded-xl border border-red-200">
                    <p class="text-gray-600 text-sm font-medium mb-2">Tunggakan Pembayaran</p>
                    <p class="text-3xl font-bold text-red-700">Rp {{ number_format($statistik['total_tunggakan'] ?? 0, 0, ',', '.') }}</p>
                    <p class="text-xs text-red-600 mt-2">{{ $statistik['jumlah_tunggakan'] ?? 0 }} tagihan</p>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Monthly Revenue Chart -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Pendapatan Bulanan (6 Bulan Terakhir)</h3>
                    <div class="h-64 flex items-end justify-between gap-2 px-2">
                        @php
                            $maxRevenue = $statistik['monthly_revenue']->max('total') ?? 1;
                        @endphp
                        @forelse($statistik['monthly_revenue'] ?? [] as $month)
                            <div class="flex-1 flex flex-col items-center">
                                <div class="w-full bg-blue-200 rounded-t-lg flex items-end justify-center" 
                                    style="height: {{ ($month['total'] / $maxRevenue * 100) }}%; min-height: 2rem;">
                                    <span class="text-xs font-bold text-blue-700 pb-1">
                                        @if(($month['total'] / 1000000) >= 1)
                                            {{ round($month['total'] / 1000000, 1) }}M
                                        @else
                                            {{ round($month['total'] / 1000, 0) }}K
                                        @endif
                                    </span>
                                </div>
                                <p class="text-xs text-gray-600 mt-2 text-center">{{ $month['period'] }}</p>
                            </div>
                        @empty
                            <div class="w-full text-center py-12 text-gray-500">
                                <p>Tidak ada data pembayaran</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Tagihan Status Distribution -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Distribusi Status Tagihan</h3>
                    <div class="space-y-4">
                        @php
                            $totalTags = array_sum(array_column($statistik['tagihan_status'] ?? [], 'count'));
                        @endphp
                        @forelse($statistik['tagihan_status'] ?? [] as $status)
                            <div>
                                <div class="flex justify-between items-center mb-1">
                                    <span class="text-sm font-medium text-gray-700">
                                        @if($status['status'] === 'paid')
                                            <i class="fas fa-check-circle text-green-600 mr-2"></i>Lunas
                                        @else
                                            <i class="fas fa-exclamation-circle text-red-600 mr-2"></i>Belum Lunas
                                        @endif
                                    </span>
                                    <span class="text-sm font-bold text-gray-900">{{ $status['count'] }} ({{ round($status['count'] / max($totalTags, 1) * 100) }}%)</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="h-2 rounded-full transition-all {{ $status['status'] === 'paid' ? 'bg-green-500' : 'bg-red-500' }}"
                                        style="width: {{ round($status['count'] / max($totalTags, 1) * 100) }}%">
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-4">Tidak ada data</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Payment Method Distribution -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Pembayaran Berdasarkan Metode</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @php
                        $methods = [
                            'tunai' => ['label' => 'Tunai', 'color' => 'bg-blue-100', 'text' => 'text-blue-700'],
                            'transfer' => ['label' => 'Transfer', 'color' => 'bg-green-100', 'text' => 'text-green-700'],
                            'qris' => ['label' => 'QRIS', 'color' => 'bg-purple-100', 'text' => 'text-purple-700']
                        ];
                    @endphp
                    @foreach($methods as $method => $info)
                        @php
                            $methodData = collect($statistik['payment_methods'] ?? [])->firstWhere('metode_bayar', $method);
                            $count = $methodData['count'] ?? 0;
                            $total = $methodData['total'] ?? 0;
                        @endphp
                        <div class="{{ $info['color'] }} {{ $info['text'] }} p-4 rounded-lg border-2 border-current">
                            <p class="text-sm font-medium opacity-75">{{ $info['label'] }}</p>
                            <p class="text-2xl font-bold mt-1">{{ $count }}</p>
                            <p class="text-xs opacity-75 mt-1">Rp {{ number_format($total, 0, ',', '.') }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Top Categories -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Kategori Pembayaran Terpopuler</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold text-gray-700">Kategori</th>
                                <th class="px-4 py-3 text-right font-semibold text-gray-700">Jumlah Pembayaran</th>
                                <th class="px-4 py-3 text-right font-semibold text-gray-700">Total</th>
                                <th class="px-4 py-3 text-right font-semibold text-gray-700">% dari Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @php
                                $totalAmount = collect($statistik['category_statistics'] ?? [])->sum('total');
                            @endphp
                            @forelse($statistik['category_statistics'] ?? [] as $category)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-4 font-medium text-gray-900">{{ $category['kategori'] }}</td>
                                    <td class="px-4 py-4 text-right text-gray-600">{{ $category['count'] }}</td>
                                    <td class="px-4 py-4 text-right font-semibold text-gray-900">
                                        Rp {{ number_format($category['total'], 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-4 text-right">
                                        <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">
                                            {{ round($category['total'] / max($totalAmount, 1) * 100) }}%
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-8 text-center text-gray-500">
                                        Tidak ada data kategori
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
