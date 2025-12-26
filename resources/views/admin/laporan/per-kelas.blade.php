@extends('layouts.app')

@section('title', 'Laporan Per Kelas')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <x-page-header
        title="Laporan Per Kelas"
        subtitle="Ringkasan pembayaran dan tagihan per kelas"
        icon="fa-chalkboard-user"
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
            <a href="{{ route('admin.laporan.per-kelas') }}" class="px-6 py-4 font-medium text-blue-600 border-b-2 border-blue-600 whitespace-nowrap">
                <i class="fas fa-chalkboard-user mr-2"></i>Per Kelas
            </a>
            <a href="{{ route('admin.laporan.statistik') }}" class="px-6 py-4 font-medium text-gray-600 hover:text-gray-900 border-b-2 border-transparent whitespace-nowrap">
                <i class="fas fa-chart-column mr-2"></i>Statistik
            </a>
        </div>

        <!-- Filter Section -->
        <div class="p-6 border-b border-gray-100 bg-gray-50">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Class Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Kelas</label>
                    <select name="kelas" id="kelasSelect" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" onchange="this.form.submit()">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($kelasList as $item)
                            <option value="{{ $item }}" {{ $kelas === $item ? 'selected' : '' }}>{{ $item }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Tahun Ajaran -->
                @if($kelas)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tahun Ajaran</label>
                    <select name="tahun_ajaran" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        @foreach($tahunAjaranList as $tahun)
                            <option value="{{ $tahun }}" {{ $tahunAjaran === $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                        @endforeach
                    </select>
                </div>
                @endif
            </form>
        </div>

        <!-- Content -->
        <div class="p-6">
            @if($kelas && !empty($data))
                <!-- Statistics Cards -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-4 rounded-xl border border-blue-200">
                        <p class="text-gray-600 text-xs font-medium mb-1">Total Siswa</p>
                        <p class="text-2xl font-bold text-blue-700">{{ $data['total_siswa'] }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-green-50 to-green-100 p-4 rounded-xl border border-green-200">
                        <p class="text-gray-600 text-xs font-medium mb-1">Sudah Bayar</p>
                        <p class="text-2xl font-bold text-green-700">{{ $data['siswa_sudah_bayar'] }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-orange-50 to-orange-100 p-4 rounded-xl border border-orange-200">
                        <p class="text-gray-600 text-xs font-medium mb-1">Belum Bayar</p>
                        <p class="text-2xl font-bold text-orange-700">{{ $data['siswa_belum_bayar'] }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-4 rounded-xl border border-purple-200">
                        <p class="text-gray-600 text-xs font-medium mb-1">Total Tagihan</p>
                        <p class="text-xl font-bold text-purple-700">Rp {{ number_format($data['total_tagihan'], 0, ',', '.') }}</p>
                    </div>
                </div>

                <!-- Tagihan Details by Category -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    @forelse($data['detail_tagihan'] as $kategori => $tagihan)
                        <div class="bg-white border border-gray-200 rounded-xl p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">{{ $kategori }}</h3>
                            <div class="space-y-2 max-h-64 overflow-y-auto">
                                @foreach($tagihan as $item)
                                    <div class="p-3 bg-gray-50 rounded-lg border border-gray-200">
                                        <div class="flex justify-between items-start mb-1">
                                            <p class="font-medium text-gray-900 text-sm">{{ $item->user->siswa->user->name ?? 'N/A' }}</p>
                                            <x-badge 
                                                :status="$item->status"
                                                class="text-xs"
                                            />
                                        </div>
                                        <div class="flex justify-between items-center text-xs text-gray-600">
                                            <span>Rp {{ number_format($item->jumlah_tagihan, 0, ',', '.') }}</span>
                                            <span>Jatuh tempo: {{ $item->tanggal_jatuh_tempo->format('d/m/Y') }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <div class="col-span-2 text-center py-12">
                            <i class="fas fa-inbox text-4xl text-gray-300 mb-2"></i>
                            <p class="text-gray-600">Tidak ada data tagihan untuk kelas ini</p>
                        </div>
                    @endforelse
                </div>

                <!-- Summary Table -->
                <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                        <h3 class="text-lg font-bold text-gray-900">Ringkasan Tagihan</h3>
                    </div>
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left font-semibold text-gray-700">Kategori Pembayaran</th>
                                <th class="px-6 py-3 text-right font-semibold text-gray-700">Jumlah Tagihan</th>
                                <th class="px-6 py-3 text-center font-semibold text-gray-700">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($data['detail_tagihan'] as $kategori => $tagihan)
                                @php
                                    $paid = $tagihan->where('status', 'paid')->count();
                                    $unpaid = $tagihan->where('status', 'unpaid')->count();
                                    $total = $tagihan->sum('jumlah_tagihan');
                                @endphp
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $kategori }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <span class="font-semibold text-gray-900">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="text-xs px-2 py-1 bg-blue-100 text-blue-700 rounded-full">
                                            {{ $paid }} lunas / {{ $unpaid }} tunggak
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-8 text-center text-gray-500">
                                        Tidak ada data tagihan
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            @else
                <div class="text-center py-16">
                    <i class="fas fa-chalkboard text-6xl text-gray-300 mb-4"></i>
                    <p class="text-gray-600 text-lg mb-2">Silakan pilih kelas untuk melihat laporan</p>
                    <p class="text-gray-500">Gunakan dropdown di atas untuk memilih kelas</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
