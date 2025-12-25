@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div>
    <!-- Page Header -->
    <x-page-header 
        title="Dashboard Admin"
        subtitle="Pantau statistik dan aktivitas pembayaran sekolah"
        icon="fa-tachometer-alt"
    />

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <x-stats-card 
            label="Total Siswa Aktif" 
            value="{{ $totalSiswa }}"
            subtitle="Siswa terdaftar"
            color="blue"
            icon="fa-users"
        />
        <x-stats-card 
            label="Total Pembayaran" 
            value="Rp {{ number_format($totalPembayaran, 0, ',', '.') }}"
            subtitle="Sudah diterima"
            color="green"
            icon="fa-money-bill-wave"
        />
        <x-stats-card 
            label="Tagihan Belum Dibayar" 
            value="{{ $totalTagihan }}"
            subtitle="Menunggu pembayaran"
            color="orange"
            icon="fa-clock"
        />
        <x-stats-card 
            label="Pembayaran Pending" 
            value="{{ $pembayaranPending }}"
            subtitle="Menunggu verifikasi"
            color="red"
            icon="fa-exclamation-circle"
        />
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Quick Actions -->
        <div class="lg:col-span-1">
            <x-card>
                <div class="card-header">
                    <h2 class="text-lg font-bold text-gray-900">Aksi Cepat</h2>
                </div>
                <div class="card-body space-y-3">
                    <a href="{{ route('admin.pembayaran.index') }}" class="block p-4 rounded-lg bg-blue-50 border-2 border-blue-200 hover:bg-blue-100 text-center transition">
                        <i class="fas fa-check-circle text-blue-600 text-2xl mb-2"></i>
                        <p class="font-semibold text-gray-900 text-sm">Verifikasi Pembayaran</p>
                        <p class="text-xs text-gray-600 mt-1">{{ $pembayaranPending }} menunggu</p>
                    </a>

                    <a href="{{ route('admin.tagihan.create') }}" class="block p-4 rounded-lg bg-green-50 border-2 border-green-200 hover:bg-green-100 text-center transition">
                        <i class="fas fa-plus-circle text-green-600 text-2xl mb-2"></i>
                        <p class="font-semibold text-gray-900 text-sm">Buat Tagihan</p>
                        <p class="text-xs text-gray-600 mt-1">Tagihan baru</p>
                    </a>

                    <a href="{{ route('admin.siswa.create') }}" class="block p-4 rounded-lg bg-purple-50 border-2 border-purple-200 hover:bg-purple-100 text-center transition">
                        <i class="fas fa-user-plus text-purple-600 text-2xl mb-2"></i>
                        <p class="font-semibold text-gray-900 text-sm">Tambah Siswa</p>
                        <p class="text-xs text-gray-600 mt-1">Data baru</p>
                    </a>

                    <a href="{{ route('admin.kategori.create') }}" class="block p-4 rounded-lg bg-yellow-50 border-2 border-yellow-200 hover:bg-yellow-100 text-center transition">
                        <i class="fas fa-folder-plus text-yellow-600 text-2xl mb-2"></i>
                        <p class="font-semibold text-gray-900 text-sm">Kategori Bayar</p>
                        <p class="text-xs text-gray-600 mt-1">Kategori baru</p>
                    </a>
                </div>
            </x-card>
        </div>

        <!-- Recent Payments -->
        <div class="lg:col-span-2">
            <x-card>
                <div class="card-header flex items-center justify-between">
                    <h2 class="text-lg font-bold text-gray-900 flex items-center space-x-2">
                        <i class="fas fa-exchange-alt text-blue-600"></i>
                        <span>Pembayaran Terbaru</span>
                    </h2>
                    <a href="{{ route('admin.pembayaran.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                        Lihat Semua
                    </a>
                </div>
                <div class="card-body overflow-x-auto">
                    @if($recentPembayaran->count() > 0)
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold text-gray-700">Kode</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-700">Siswa</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-700">Jumlah</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-700">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($recentPembayaran as $p)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 font-mono text-gray-900">{{ substr($p->kode_transaksi, 0, 8) }}...</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center space-x-2">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($p->user->name) }}&size=32" 
                                             class="w-8 h-8 rounded-full" alt="{{ $p->user->name }}">
                                        <span class="text-gray-900 font-medium">{{ $p->user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 font-semibold text-gray-900">Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}</td>
                                <td class="px-4 py-3">
                                    <x-badge type="{{ $p->status === 'paid' ? 'success' : ($p->status === 'pending' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($p->status) }}
                                    </x-badge>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class="text-center py-8">
                        <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-600">Tidak ada pembayaran terbaru</p>
                    </div>
                    @endif
                </div>
            </x-card>
        </div>
    </div>

    <!-- Secondary Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Siswa per Kelas -->
        <x-card>
            <div class="card-header">
                <h2 class="text-lg font-bold text-gray-900 flex items-center space-x-2">
                    <i class="fas fa-graduation-cap text-blue-600"></i>
                    <span>Distribusi Siswa per Kelas</span>
                </h2>
            </div>
            <div class="card-body">
                @if($siswaPerKelas->count() > 0)
                <div class="space-y-4">
                    @foreach($siswaPerKelas as $kelas)
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="font-medium text-gray-900">{{ $kelas->kelas ?? 'N/A' }}</span>
                            <span class="font-bold text-gray-900">{{ $kelas->total }} siswa</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ ($kelas->total / $totalSiswa) * 100 }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-8">
                    <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-600">Tidak ada data siswa</p>
                </div>
                @endif
            </div>
        </x-card>

        <!-- Payment Method Distribution -->
        <x-card>
            <div class="card-header">
                <h2 class="text-lg font-bold text-gray-900 flex items-center space-x-2">
                    <i class="fas fa-credit-card text-green-600"></i>
                    <span>Metode Pembayaran</span>
                </h2>
            </div>
            <div class="card-body">
                <div class="space-y-4">
                    @php
                        $methods = [
                            'tunai' => ['label' => 'Tunai', 'color' => 'blue', 'count' => $recentPembayaran->where('metode_bayar', 'tunai')->count()],
                            'transfer' => ['label' => 'Transfer', 'color' => 'green', 'count' => $recentPembayaran->where('metode_bayar', 'transfer')->count()],
                            'qris' => ['label' => 'QRIS', 'color' => 'purple', 'count' => $recentPembayaran->where('metode_bayar', 'qris')->count()],
                        ];
                    @endphp
                    
                    @foreach($methods as $method)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 rounded-full bg-{{ $method['color'] }}-500"></div>
                            <span class="font-medium text-gray-900">{{ $method['label'] }}</span>
                        </div>
                        <span class="font-bold text-gray-900">{{ $method['count'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </x-card>
    </div>
</div>
@endsection
                <p class="text-purple-100 text-xs">Tagihan</p>