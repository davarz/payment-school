@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="space-y-8 pb-8">
    <!-- Page Header -->
    <div class="border-b border-gray-200 pb-6">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-4xl font-bold text-gray-900">Dashboard</h1>
                <p class="text-gray-600 mt-2">Pantau statistik pembayaran dan aktivitas sekolah secara real-time</p>
            </div>
            <div class="text-blue-600 text-4xl">
                <i class="fas fa-chart-line"></i>
            </div>
        </div>
    </div>

    <!-- Key Metrics Grid - Enhanced -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Siswa Card -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl border border-blue-200 p-6 hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-blue-600 text-white rounded-lg p-3 text-xl">
                    <i class="fas fa-users"></i>
                </div>
                <span class="text-xs font-semibold text-blue-700 bg-blue-200 px-2 py-1 rounded-full">Total</span>
            </div>
            <p class="text-gray-700 text-sm font-medium">Total Siswa Aktif</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalSiswa ?? 0 }}</p>
            <p class="text-xs text-gray-600 mt-2">Siswa terdaftar dalam sistem</p>
        </div>

        <!-- Total Pembayaran Card -->
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl border border-green-200 p-6 hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-green-600 text-white rounded-lg p-3 text-xl">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <span class="text-xs font-semibold text-green-700 bg-green-200 px-2 py-1 rounded-full">Bulan Ini</span>
            </div>
            <p class="text-gray-700 text-sm font-medium">Total Pembayaran Masuk</p>
            <p class="text-2xl font-bold text-gray-900 mt-2">Rp {{ number_format($totalPembayaran ?? 0, 0, ',', '.') }}</p>
            <p class="text-xs text-gray-600 mt-2">Pendapatan pembayaran</p>
        </div>

        <!-- Tagihan Pending Card -->
        <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl border border-orange-200 p-6 hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-orange-600 text-white rounded-lg p-3 text-xl">
                    <i class="fas fa-hourglass-half"></i>
                </div>
                <span class="text-xs font-semibold text-orange-700 bg-orange-200 px-2 py-1 rounded-full">Belum Dibayar</span>
            </div>
            <p class="text-gray-700 text-sm font-medium">Tagihan Belum Dibayar</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalTagihan ?? 0 }}</p>
            <p class="text-xs text-gray-600 mt-2">Butuh follow-up pelanggan</p>
        </div>

        <!-- Pembayaran Pending Card -->
        <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-xl border border-red-200 p-6 hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-red-600 text-white rounded-lg p-3 text-xl">
                    <i class="fas fa-clock"></i>
                </div>
                <span class="text-xs font-semibold text-red-700 bg-red-200 px-2 py-1 rounded-full">Pending</span>
            </div>
            <p class="text-gray-700 text-sm font-medium">Verifikasi Pending</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $pembayaranPending ?? 0 }}</p>
            <p class="text-xs text-gray-600 mt-2">Menunggu verifikasi operator</p>
        </div>
    </div>

    <!-- Main Content Grid - Reordered Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Quick Actions - Full Height -->
        <div class="lg:col-span-1 lg:row-span-2">
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                    <h2 class="text-lg font-bold text-white flex items-center gap-2">
                        <i class="fas fa-lightning-bolt"></i>
                        <span>Aksi Cepat</span>
                    </h2>
                </div>
                <div class="p-6 space-y-3">
                    <a href="{{ route('admin.pembayaran.index') }}" class="block p-4 rounded-lg bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 hover:shadow-md hover:scale-105 transition-all duration-200 text-center">
                        <div class="text-3xl text-blue-600 mb-2">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <p class="font-bold text-gray-900 text-sm">Verifikasi Pembayaran</p>
                        <p class="text-xs text-gray-600 mt-1 font-semibold">{{ $pembayaranPending }} menunggu</p>
                    </a>

                    <a href="{{ route('admin.tagihan.create') }}" class="block p-4 rounded-lg bg-gradient-to-br from-green-50 to-green-100 border border-green-200 hover:shadow-md hover:scale-105 transition-all duration-200 text-center">
                        <div class="text-3xl text-green-600 mb-2">
                            <i class="fas fa-plus-circle"></i>
                        </div>
                        <p class="font-bold text-gray-900 text-sm">Buat Tagihan</p>
                        <p class="text-xs text-gray-600 mt-1">Tagihan baru</p>
                    </a>

                    <a href="{{ route('admin.siswa.create') }}" class="block p-4 rounded-lg bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-200 hover:shadow-md hover:scale-105 transition-all duration-200 text-center">
                        <div class="text-3xl text-purple-600 mb-2">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <p class="font-bold text-gray-900 text-sm">Tambah Siswa</p>
                        <p class="text-xs text-gray-600 mt-1">Data baru</p>
                    </a>

                    <a href="{{ route('admin.kategori.create') }}" class="block p-4 rounded-lg bg-gradient-to-br from-amber-50 to-amber-100 border border-amber-200 hover:shadow-md hover:scale-105 transition-all duration-200 text-center">
                        <div class="text-3xl text-amber-600 mb-2">
                            <i class="fas fa-folder-plus"></i>
                        </div>
                        <p class="font-bold text-gray-900 text-sm">Kategori Bayar</p>
                        <p class="text-xs text-gray-600 mt-1">Kategori baru</p>
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Payments -->
        <div class="lg:col-span-3">
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 flex items-center justify-between">
                    <h2 class="text-lg font-bold text-white flex items-center gap-2">
                        <i class="fas fa-exchange-alt"></i>
                        <span>Pembayaran Terbaru</span>
                    </h2>
                    <a href="{{ route('admin.pembayaran.index') }}" class="text-blue-100 hover:text-white text-sm font-semibold transition">
                        Lihat Semua →
                    </a>
                </div>
                <div class="overflow-x-auto">
                    @if($recentPembayaran->count() > 0)
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left font-semibold text-gray-700">Kode Transaksi</th>
                                <th class="px-6 py-3 text-left font-semibold text-gray-700">Siswa</th>
                                <th class="px-6 py-3 text-left font-semibold text-gray-700">Jumlah</th>
                                <th class="px-6 py-3 text-center font-semibold text-gray-700">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($recentPembayaran as $p)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 font-mono text-gray-900 font-medium">{{ substr($p->kode_transaksi, 0, 12) }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($p->user->name) }}&size=32&background=3B82F6&color=fff"
                                             class="w-8 h-8 rounded-full" alt="{{ $p->user->name }}">
                                        <span class="text-gray-900 font-medium">{{ $p->user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-bold text-gray-900">Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-center">
                                    @if($p->status === 'paid')
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                            <i class="fas fa-check-circle"></i> Dibayar
                                        </span>
                                    @elseif($p->status === 'pending')
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-orange-100 text-orange-700">
                                            <i class="fas fa-hourglass-half"></i> Pending
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700">
                                            <i class="fas fa-times-circle"></i> Gagal
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class="text-center py-12 text-gray-500">
                        <i class="fas fa-inbox text-5xl text-gray-300 mb-4"></i>
                        <p class="font-medium">Tidak ada pembayaran terbaru</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Grid - Charts & Analytics -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Siswa per Kelas -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                <h2 class="text-lg font-bold text-white flex items-center gap-2">
                    <i class="fas fa-graduation-cap"></i>
                    <span>Distribusi Siswa per Kelas</span>
                </h2>
            </div>
            <div class="p-6">
                @if($siswaPerKelas->count() > 0)
                <div class="space-y-5">
                    @foreach($siswaPerKelas as $kelas)
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="font-semibold text-gray-900">{{ $kelas->kelas ?? 'N/A' }}</span>
                            <span class="text-sm font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded">{{ $kelas->total }} siswa</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                            <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-3 rounded-full transition-all duration-300" style="width: {{ ($kelas->total / $totalSiswa) * 100 }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-12 text-gray-500">
                    <i class="fas fa-inbox text-5xl text-gray-300 mb-4"></i>
                    <p class="font-medium">Tidak ada data siswa</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Payment Method Distribution -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                <h2 class="text-lg font-bold text-white flex items-center gap-2">
                    <i class="fas fa-credit-card"></i>
                    <span>Metode Pembayaran</span>
                </h2>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @php
                        $methods = [
                            ['label' => 'Tunai', 'color' => 'blue', 'icon' => 'fa-money-bill', 'count' => $recentPembayaran->where('metode_bayar', 'tunai')->count()],
                            ['label' => 'Transfer', 'color' => 'green', 'icon' => 'fa-university', 'count' => $recentPembayaran->where('metode_bayar', 'transfer')->count()],
                            ['label' => 'QRIS', 'color' => 'purple', 'icon' => 'fa-qrcode', 'count' => $recentPembayaran->where('metode_bayar', 'qris')->count()],
                        ];
                    @endphp

                    @foreach($methods as $method)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200 hover:bg-gray-100 transition">
                        <div class="flex items-center gap-3">
                            <div class="text-2xl text-{{ $method['color'] }}-600">
                                <i class="fas {{ $method['icon'] }}"></i>
                            </div>
                            <div>
                                <p class="font-bold text-gray-900">{{ $method['label'] }}</p>
                                <p class="text-xs text-gray-600">Metode pembayaran</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-{{ $method['color'] }}-600">{{ $method['count'] }}</p>
                            <p class="text-xs text-gray-600">transaksi</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection