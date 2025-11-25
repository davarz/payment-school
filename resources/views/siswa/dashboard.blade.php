@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@section('content')
<div class="pt-16 px-4 sm:px-6 lg:px-8">
    <!-- Welcome Card & Tagihan Unpaid -->
    <div class="mb-8">
        <!-- Welcome Message -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl shadow-lg p-6 text-white mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold mb-2">Selamat Datang, {{ auth()->user()->name }}! 👋</h1>
                    <p class="text-blue-100 text-sm">Semoga harimu menyenangkan</p>
                </div>
                <div class="mt-4 sm:mt-0">
                    <div class="flex items-center space-x-2 bg-white/20 rounded-lg px-4 py-2">
                        <i class="fas fa-user-graduate text-sm"></i>
                        <span class="text-sm font-medium">Kelas {{ auth()->user()->kelas }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tagihan Unpaid Card -->
        @php
            $unpaidCount = $tagihan->where('status', 'unpaid')->count();
            $totalUnpaid = $tagihan->where('status', 'unpaid')->sum('jumlah_tagihan');
        @endphp

        @if($unpaidCount > 0)
        <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-2xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-white/20 rounded-full">
                        <i class="fas fa-exclamation-triangle text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold mb-1">Pemberitahuan Tagihan</h3>
                        <p class="text-orange-100 text-sm">
                            Anda mempunyai <span class="font-bold">{{ $unpaidCount }} tagihan</span> yang belum dibayar
                        </p>
                        <p class="text-orange-100 text-sm mt-1">
                            Total: <span class="font-bold">Rp {{ number_format($totalUnpaid, 0, ',', '.') }}</span>
                        </p>
                    </div>
                </div>
                <a href="{{ route('siswa.tagihan') }}" 
                   class="bg-white text-orange-600 hover:bg-orange-50 px-6 py-3 rounded-xl font-semibold transition duration-200 flex items-center space-x-2">
                    <span>Lihat Tagihan</span>
                    <i class="fas fa-arrow-right text-sm"></i>
                </a>
            </div>
        </div>
        @else
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-2xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-white/20 rounded-full">
                        <i class="fas fa-check-circle text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold mb-1">Status Tagihan</h3>
                        <p class="text-green-100 text-sm">
                            Semua tagihan Anda sudah lunas! 🎉
                        </p>
                        <p class="text-green-100 text-sm mt-1">
                            Tidak ada tagihan yang perlu dibayar saat ini
                        </p>
                    </div>
                </div>
                <a href="{{ route('siswa.tagihan') }}" 
                   class="bg-white text-green-600 hover:bg-green-50 px-6 py-3 rounded-xl font-semibold transition duration-200 flex items-center space-x-2">
                    <span>Riwayat</span>
                    <i class="fas fa-history text-sm"></i>
                </a>
            </div>
        </div>
        @endif
    </div>

    <!-- Quick Actions Grid -->
    <div class="mb-8">
        <h2 class="text-xl font-bold text-gray-800 mb-6">Akses Cepat</h2>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- Lihat Tagihan -->
            <a href="{{ route('siswa.tagihan') }}" 
               class="bg-white rounded-2xl shadow-lg p-6 border border-gray-200 hover:shadow-xl transition-all duration-300 group">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-blue-100 rounded-xl group-hover:bg-blue-500 transition-colors duration-300">
                        <i class="fas fa-receipt text-blue-600 group-hover:text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800 text-lg mb-1">Tagihan Saya</h3>
                        <p class="text-gray-600 text-sm">Lihat dan bayar tagihan</p>
                    </div>
                </div>
            </a>

            <!-- Riwayat Pembayaran -->
            <a href="{{ route('siswa.transaksi') }}" 
               class="bg-white rounded-2xl shadow-lg p-6 border border-gray-200 hover:shadow-xl transition-all duration-300 group">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-green-100 rounded-xl group-hover:bg-green-500 transition-colors duration-300">
                        <i class="fas fa-history text-green-600 group-hover:text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800 text-lg mb-1">Riwayat</h3>
                        <p class="text-gray-600 text-sm">Transaksi pembayaran</p>
                    </div>
                </div>
            </a>

            <!-- Profile -->
            <a href="{{ route('siswa.profile.show') }}" 
               class="bg-white rounded-2xl shadow-lg p-6 border border-gray-200 hover:shadow-xl transition-all duration-300 group">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-purple-100 rounded-xl group-hover:bg-purple-500 transition-colors duration-300">
                        <i class="fas fa-user text-purple-600 group-hover:text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800 text-lg mb-1">Profile</h3>
                        <p class="text-gray-600 text-sm">Kelola data diri</p>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Recent Activity & Quick Stats -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Pembayaran Terbaru -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Pembayaran Terbaru</h3>
            </div>
            <div class="p-6">
                @forelse($pembayaran->take(5) as $pembayaran)
                <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-b-0">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center 
                            @if($pembayaran->status == 'paid') bg-green-100 text-green-600
                            @elseif($pembayaran->status == 'pending') bg-yellow-100 text-yellow-600
                            @else bg-red-100 text-red-600 @endif">
                            <i class="fas 
                                @if($pembayaran->status == 'paid') fa-check-circle
                                @elseif($pembayaran->status == 'pending') fa-clock
                                @else fa-times-circle @endif text-sm">
                            </i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800">{{ $pembayaran->kategori->nama_kategori }}</p>
                            <p class="text-sm text-gray-500">{{ $pembayaran->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold text-gray-800">Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</p>
                        <span class="inline-block px-2 py-1 text-xs rounded-full 
                            @if($pembayaran->status == 'paid') bg-green-100 text-green-800
                            @elseif($pembayaran->status == 'pending') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ ucfirst($pembayaran->status) }}
                        </span>
                    </div>
                </div>
                @empty
                <div class="text-center py-8">
                    <i class="fas fa-receipt text-4xl text-gray-300 mb-3"></i>
                    <p class="text-gray-500 font-medium">Belum ada pembayaran</p>
                    <p class="text-sm text-gray-400 mt-1">Riwayat pembayaran akan muncul di sini</p>
                </div>
                @endforelse
                
                @if($pembayaran->count() > 0)
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <a href="{{ route('siswa.transaksi') }}" class="text-blue-600 hover:text-blue-800 font-medium flex items-center justify-center space-x-2">
                        <span>Lihat Semua Riwayat</span>
                        <i class="fas fa-arrow-right text-sm"></i>
                    </a>
                </div>
                @endif
            </div>
        </div>

        <!-- Tagihan Aktif -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Tagihan Aktif</h3>
            </div>
            <div class="p-6">
                @forelse($tagihan->where('status', 'unpaid')->take(3) as $tagihanItem)
                <div class="bg-orange-50 border border-orange-200 rounded-xl p-4 mb-3 last:mb-0">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-semibold text-orange-800">{{ $tagihanItem->kategori->nama_kategori }}</p>
                            <p class="text-sm text-orange-600 mt-1">
                                Jatuh tempo: {{ \Carbon\Carbon::parse($tagihanItem->tanggal_jatuh_tempo)->format('d M Y') }}
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-orange-800 text-lg">Rp {{ number_format($tagihanItem->jumlah_tagihan, 0, ',', '.') }}</p>
                            <span class="inline-block px-2 py-1 bg-orange-100 text-orange-800 text-xs rounded-full mt-1">
                                Belum Bayar
                            </span>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-8">
                    <i class="fas fa-check-circle text-4xl text-green-300 mb-3"></i>
                    <p class="text-gray-500 font-medium">Tidak ada tagihan aktif</p>
                    <p class="text-sm text-gray-400 mt-1">Semua tagihan sudah lunas</p>
                </div>
                @endforelse
                
                @if($tagihan->where('status', 'unpaid')->count() > 0)
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <a href="{{ route('siswa.tagihan') }}" class="text-blue-600 hover:text-blue-800 font-medium flex items-center justify-center space-x-2">
                        <span>Lihat Semua Tagihan</span>
                        <i class="fas fa-arrow-right text-sm"></i>
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection