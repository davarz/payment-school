@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@section('content')
<div>
    <!-- Welcome Header -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Greeting Card -->
        <div class="lg:col-span-2 bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 rounded-2xl shadow-lg p-6 sm:p-8 text-white overflow-hidden relative">
            <div class="absolute top-0 right-0 opacity-10">
                <i class="fas fa-graduation-cap text-9xl"></i>
            </div>
            <div class="relative z-10">
                <h1 class="text-2xl sm:text-3xl font-bold mb-2">Selamat Datang, {{ auth()->user()->name }}! 👋</h1>
                <p class="text-blue-100 text-sm sm:text-base">Kelola pembayaran sekolah Anda dengan mudah dan aman</p>
                <div class="flex items-center space-x-6 mt-6">
                    <div class="flex items-center space-x-2 bg-white/20 rounded-lg px-4 py-2 backdrop-blur">
                        <i class="fas fa-user-graduate"></i>
                        <span class="font-medium">Kelas {{ $currentSiswa->kelas ?? 'N/A' }}</span>
                    </div>
                    <div class="flex items-center space-x-2 bg-white/20 rounded-lg px-4 py-2 backdrop-blur">
                        <i class="fas fa-calendar"></i>
                        <span class="font-medium">{{ $currentSiswa->tahun_ajaran ?? date('Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Info Card -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
            <h3 class="text-gray-600 text-sm font-semibold mb-4 uppercase tracking-wide">Status Akun</h3>
            <div class="space-y-4">
                <div>
                    <p class="text-xs text-gray-500 uppercase">Status Siswa</p>
                    <p class="text-lg font-bold text-gray-900 capitalize">{{ $currentSiswa->status_siswa ?? 'Aktif' }}</p>
                </div>
                <div class="pt-4 border-t border-gray-200">
                    <p class="text-xs text-gray-500 uppercase">NIS</p>
                    <p class="text-lg font-bold text-gray-900">{{ $currentSiswa->nis ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Alert -->
    @php
        $unpaidCount = $tagihan->where('status', 'unpaid')->count();
        $totalUnpaid = $tagihan->where('status', 'unpaid')->sum('jumlah_tagihan');
        $paidCount = $tagihan->where('status', 'paid')->count();
    @endphp

    @if($unpaidCount > 0)
    <x-alert type="warning" title="Perhatian!" closable class="mb-8">
        Anda memiliki <strong>{{ $unpaidCount }} tagihan</strong> yang belum dibayar dengan total <strong>Rp {{ number_format($totalUnpaid, 0, ',', '.') }}</strong>
    </x-alert>
    @else
    <x-alert type="success" title="Sempurna!" closable class="mb-8">
        Semua tagihan Anda sudah lunas! Terus jaga kelancaran pembayaran Anda.
    </x-alert>
    @endif

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <x-stats-card 
            label="Total Tagihan" 
            value="{{ $tagihan->count() }}"
            subtitle="Semua kategori"
            color="blue"
            icon="fa-receipt"
        />
        <x-stats-card 
            label="Tagihan Belum Dibayar" 
            value="{{ $unpaidCount }}"
            subtitle="Menunggu pembayaran"
            color="orange"
            icon="fa-clock"
        />
        <x-stats-card 
            label="Tagihan Sudah Dibayar" 
            value="{{ $paidCount }}"
            subtitle="Status lunas"
            color="green"
            icon="fa-check-circle"
        />
        <x-stats-card 
            label="Total Pembayaran" 
            value="Rp {{ number_format($tagihan->where('status', 'paid')->sum('jumlah_tagihan'), 0, ',', '.') }}"
            subtitle="Sudah dibayarkan"
            color="purple"
            icon="fa-money-bill"
        />
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Tagihan List -->
        <div class="lg:col-span-2">
            <x-card>
                <div class="card-header flex items-center justify-between">
                    <h2 class="text-lg font-bold text-gray-900 flex items-center space-x-2">
                        <i class="fas fa-receipt text-blue-600"></i>
                        <span>Daftar Tagihan Saya</span>
                    </h2>
                    <a href="{{ route('siswa.tagihan.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                        Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
                
                <div class="card-body">
                    @if($tagihan->count() > 0)
                        <div class="space-y-3">
                            @foreach($tagihan->take(5) as $item)
                            <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                                <div class="flex-1">
                                    <p class="font-medium text-gray-900">{{ $item->kategori->nama_kategori ?? 'Tagihan' }}</p>
                                    <p class="text-xs text-gray-500 mt-1">Jatuh tempo: {{ $item->tanggal_jatuh_tempo->format('d M Y') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-gray-900">Rp {{ number_format($item->jumlah_tagihan, 0, ',', '.') }}</p>
                                    <x-badge type="{{ $item->status === 'paid' ? 'success' : 'warning' }}">
                                        {{ ucfirst($item->status) }}
                                    </x-badge>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                            <p class="text-gray-600">Tidak ada tagihan untuk ditampilkan</p>
                        </div>
                    @endif
                </div>
            </x-card>
        </div>

        <!-- Quick Actions -->
        <div>
            <x-card>
                <div class="card-header">
                    <h2 class="text-lg font-bold text-gray-900 flex items-center space-x-2">
                        <i class="fas fa-zap text-blue-600"></i>
                        <span>Aksi Cepat</span>
                    </h2>
                </div>
                
                <div class="card-body space-y-3">
                    <a href="{{ route('siswa.tagihan.index') }}" class="block p-4 border-2 border-blue-200 rounded-lg hover:bg-blue-50 text-center transition">
                        <i class="fas fa-list text-blue-600 text-2xl mb-2"></i>
                        <p class="font-semibold text-gray-900">Lihat Semua Tagihan</p>
                        <p class="text-xs text-gray-600 mt-1">{{ $tagihan->count() }} tagihan</p>
                    </a>

                    <a href="{{ route('siswa.transaksi.index') }}" class="block p-4 border-2 border-green-200 rounded-lg hover:bg-green-50 text-center transition">
                        <i class="fas fa-history text-green-600 text-2xl mb-2"></i>
                        <p class="font-semibold text-gray-900">Riwayat Transaksi</p>
                        <p class="text-xs text-gray-600 mt-1">Pembayaran Anda</p>
                    </a>

                    <a href="{{ route('profile.edit') }}" class="block p-4 border-2 border-purple-200 rounded-lg hover:bg-purple-50 text-center transition">
                        <i class="fas fa-user-circle text-purple-600 text-2xl mb-2"></i>
                        <p class="font-semibold text-gray-900">Profil Saya</p>
                        <p class="text-xs text-gray-600 mt-1">Kelola data pribadi</p>
                    </a>
                </div>
            </x-card>
        </div>
    </div>

    <!-- Recent Transactions -->
    <x-card>
        <div class="card-header flex items-center justify-between">
            <h2 class="text-lg font-bold text-gray-900 flex items-center space-x-2">
                <i class="fas fa-exchange-alt text-blue-600"></i>
                <span>Riwayat Pembayaran Terbaru</span>
            </h2>
            <a href="{{ route('siswa.transaksi.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                Lihat Semua
            </a>
        </div>

        <div class="card-body overflow-x-auto">
            @php
                $pembayaran = auth()->user()->pembayaran()->latest()->take(5)->get();
            @endphp

            @if($pembayaran->count() > 0)
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Kode</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Jumlah</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($pembayaran as $p)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm font-mono text-gray-900">{{ $p->kode_transaksi }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $p->kategori->nama_kategori ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm font-semibold text-gray-900">Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-sm">
                            <x-badge type="{{ $p->status === 'paid' ? 'success' : ($p->status === 'pending' ? 'warning' : 'danger') }}">
                                {{ ucfirst($p->status) }}
                            </x-badge>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $p->tanggal_bayar->format('d M Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="text-center py-8">
                <i class="fas fa-history text-4xl text-gray-300 mb-4"></i>
                <p class="text-gray-600">Belum ada riwayat pembayaran</p>
            </div>
            @endif
        </div>
    </x-card>
</div>
@endsection