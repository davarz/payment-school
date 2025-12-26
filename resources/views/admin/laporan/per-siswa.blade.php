@extends('layouts.app')

@section('title', 'Laporan Per Siswa')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <x-page-header
        title="Laporan Per Siswa"
        subtitle="Detail pembayaran dan tagihan per siswa"
        icon="fa-user-chart"
    />

    <!-- Tabs Navigation -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="flex border-b border-gray-100 overflow-x-auto">
            <a href="{{ route('admin.laporan.index') }}" class="px-6 py-4 font-medium text-gray-600 hover:text-gray-900 border-b-2 border-transparent whitespace-nowrap">
                <i class="fas fa-chart-line mr-2"></i>Ringkasan
            </a>
            <a href="{{ route('admin.laporan.per-siswa') }}" class="px-6 py-4 font-medium text-blue-600 border-b-2 border-blue-600 whitespace-nowrap">
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
            <form method="GET" class="space-y-4">
                <!-- Siswa Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Siswa</label>
                    <select name="siswa_id" id="siswaSelect" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" onchange="this.form.submit()">
                        <option value="">-- Pilih Siswa --</option>
                        @foreach($siswaList as $item)
                            <option value="{{ $item['id'] }}" {{ $siswaId == $item['id'] ? 'selected' : '' }}>
                                {{ $item['text'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Date Range -->
                @if($siswaId)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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
                </div>
                @endif
            </form>
        </div>

        <!-- Content -->
        <div class="p-6">
            @if($siswa)
                <!-- Student Info Card -->
                <div class="mb-6 p-6 bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl border border-blue-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">{{ $siswa->user->name }}</h2>
                            <div class="mt-2 grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <p class="text-gray-600">NIS</p>
                                    <p class="font-semibold text-gray-900">{{ $siswa->nis }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600">Kelas</p>
                                    <p class="font-semibold text-gray-900">{{ $siswa->kelas }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600">Status</p>
                                    <p class="font-semibold">
                                        @if($siswa->status_siswa === 'aktif')
                                            <span class="inline-block px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs">Aktif</span>
                                        @elseif($siswa->status_siswa === 'pindah')
                                            <span class="inline-block px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs">Pindah</span>
                                        @else
                                            <span class="inline-block px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs">Dikeluarkan</span>
                                        @endif
                                    </p>
                                </div>
                                <div>
                                    <p class="text-gray-600">Email</p>
                                    <p class="font-semibold text-gray-900 text-xs">{{ $siswa->user->email }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Pembayaran Section -->
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Riwayat Pembayaran</h3>
                        @if($pembayaran && $pembayaran->count() > 0)
                            <div class="space-y-3 max-h-96 overflow-y-auto">
                                @foreach($pembayaran as $item)
                                    <div class="p-4 border border-gray-200 rounded-lg hover:border-green-300 transition">
                                        <div class="flex justify-between items-start mb-2">
                                            <div>
                                                <p class="font-medium text-gray-900">{{ $item->kategori->nama_kategori }}</p>
                                                <p class="text-xs text-gray-600 mt-1">Kode: {{ $item->kode_transaksi }}</p>
                                            </div>
                                            <x-badge 
                                                :status="$item->status"
                                                class="text-xs"
                                            />
                                        </div>
                                        <div class="flex justify-between items-center text-sm">
                                            <span class="font-semibold text-gray-900">Rp {{ number_format($item->jumlah_bayar, 0, ',', '.') }}</span>
                                            <span class="text-xs text-gray-500">{{ $item->tanggal_bayar->format('d/m/Y') }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12 text-gray-500">
                                <i class="fas fa-inbox text-4xl mb-2"></i>
                                <p>Tidak ada pembayaran pada periode ini</p>
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
                                                <p class="font-medium text-gray-900">{{ $item->kategori->nama_kategori }}</p>
                                                <p class="text-xs text-gray-600 mt-1">Jatuh tempo: {{ $item->tanggal_jatuh_tempo->format('d/m/Y') }}</p>
                                            </div>
                                            <x-badge 
                                                :status="$item->status"
                                                class="text-xs"
                                            />
                                        </div>
                                        <div class="flex justify-between items-center text-sm">
                                            <span class="font-semibold text-gray-900">Rp {{ number_format($item->jumlah_tagihan, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12 text-gray-500">
                                <i class="fas fa-inbox text-4xl mb-2"></i>
                                <p>Tidak ada tagihan pada periode ini</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Historical Chart -->
                @if($riwayat && $riwayat->count() > 0)
                <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Riwayat Pembayaran (12 Bulan Terakhir)</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Bulan</th>
                                    <th class="px-4 py-3 text-right font-semibold text-gray-700">Total Pembayaran</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($riwayat as $item)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 text-gray-900">
                                            {{ \Carbon\Carbon::create($item->tahun, $item->bulan)->format('F Y') }}
                                        </td>
                                        <td class="px-4 py-3 text-right font-semibold text-green-600">
                                            Rp {{ number_format($item->total, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

            @else
                <div class="text-center py-16">
                    <i class="fas fa-user text-6xl text-gray-300 mb-4"></i>
                    <p class="text-gray-600 text-lg mb-2">Silakan pilih siswa untuk melihat laporan</p>
                    <p class="text-gray-500">Gunakan dropdown di atas untuk memilih siswa</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
