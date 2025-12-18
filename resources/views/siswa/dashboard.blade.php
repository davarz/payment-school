@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@section('content')
<div class="pt-8 pb-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Welcome Card & Tagihan Unpaid -->
        <div class="mb-8">
            <!-- Welcome Message -->
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl shadow-lg p-6 text-white mb-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex-1">
                        <h1 class="text-xl sm:text-2xl font-bold mb-2">Selamat Datang, {{ auth()->user()->name }}! 👋</h1>
                        <p class="text-blue-100 text-sm">Semoga harimu menyenangkan</p>
                    </div>
                    <div class="mt-3 sm:mt-0 flex justify-center sm:justify-end">
                        <div class="flex items-center space-x-2 bg-white/20 rounded-lg px-4 py-2">
                            <i class="fas fa-user-graduate text-sm"></i>
                            <span class="text-sm font-medium">Kelas {{ auth()->user()->kelas ?? 'N/A' }}</span>
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
            <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-2xl shadow-lg p-4 sm:p-6 text-white mb-4">
                <div class="flex flex-col items-center text-center sm:text-left sm:flex-row sm:items-start sm:justify-between gap-4">
                    <div class="flex flex-col items-center sm:flex-row sm:items-start space-y-3 sm:space-y-0 sm:space-x-4 flex-1 w-full sm:w-auto">
                        <div class="p-3 bg-white/20 rounded-full flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-xl"></i>
                        </div>
                        <div class="text-center sm:text-left">
                            <h3 class="text-lg font-bold mb-1">Pemberitahuan Tagihan</h3>
                            <p class="text-orange-100 text-sm">
                                Anda mempunyai <span class="font-bold">{{ $unpaidCount }} tagihan</span> yang belum dibayar
                            </p>
                            <p class="text-orange-100 text-sm mt-1">
                                Total: <span class="font-bold">Rp {{ number_format($totalUnpaid, 0, ',', '.') }}</span>
                            </p>
                        </div>
                    </div>
                    <a href="{{ route('siswa.tagihan.index') }}"
                       class="bg-white text-orange-600 hover:bg-orange-50 px-4 py-2 sm:px-6 sm:py-3 rounded-xl font-semibold transition duration-200 w-full sm:w-auto text-center">
                        Lihat Tagihan
                    </a>
                </div>
            </div>
            @else
            <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-2xl shadow-lg p-4 sm:p-6 text-white mb-4">
                <div class="flex flex-col items-center text-center sm:text-left sm:flex-row sm:items-start sm:justify-between gap-4">
                    <div class="flex flex-col items-center sm:flex-row sm:items-start space-y-3 sm:space-y-0 sm:space-x-4 flex-1 w-full sm:w-auto">
                        <div class="p-3 bg-white/20 rounded-full flex-shrink-0">
                            <i class="fas fa-check-circle text-xl"></i>
                        </div>
                        <div class="text-center sm:text-left">
                            <h3 class="text-lg font-bold mb-1">Status Tagihan</h3>
                            <p class="text-green-100 text-sm">
                                Semua tagihan Anda sudah lunas! 🎉
                            </p>
                            <p class="text-green-100 text-sm mt-1">
                                Tidak ada tagihan yang perlu dibayar saat ini
                            </p>
                        </div>
                    </div>
                    <a href="{{ route('siswa.tagihan.index') }}"
                       class="bg-white text-green-600 hover:bg-green-50 px-4 py-2 sm:px-6 sm:py-3 rounded-xl font-semibold transition duration-200 w-full sm:w-auto text-center">
                        Riwayat
                    </a>
                </div>
            </div>
            @endif
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-8">
            <div class="bg-white rounded-xl shadow-md p-4 border border-gray-200">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <i class="fas fa-receipt text-blue-600 text-lg"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-xs sm:text-sm font-medium text-gray-600">Total Tagihan</p>
                        <p class="text-lg sm:text-xl font-bold text-gray-900">{{ $tagihan->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-4 border border-gray-200">
                <div class="flex items-center">
                    <div class="p-3 bg-orange-100 rounded-lg">
                        <i class="fas fa-exclamation-circle text-orange-600 text-lg"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-xs sm:text-sm font-medium text-gray-600">Belum Dibayar</p>
                        <p class="text-lg sm:text-xl font-bold text-gray-900">{{ $tagihan->where('status', 'unpaid')->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-4 border border-gray-200">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-lg">
                        <i class="fas fa-check-circle text-green-600 text-lg"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-xs sm:text-sm font-medium text-gray-600">Sudah Dibayar</p>
                        <p class="text-lg sm:text-xl font-bold text-gray-900">{{ $tagihan->where('status', 'paid')->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-4 border border-gray-200">
                <div class="flex items-center">
                    <div class="p-3 bg-purple-100 rounded-lg">
                        <i class="fas fa-history text-purple-600 text-lg"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-xs sm:text-sm font-medium text-gray-600">Total Pembayaran</p>
                        <p class="text-lg sm:text-xl font-bold text-gray-900">{{ $pembayaran->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions Grid -->
        <div class="mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-4 sm:mb-6">Akses Cepat</h2>

            <div class="grid grid-cols-1 gap-3 sm:gap-4">
                <!-- Lihat Tagihan -->
                <a href="{{ route('siswa.tagihan.index') }}"
                   class="bg-white rounded-xl sm:rounded-2xl shadow-md sm:shadow-lg p-4 sm:p-6 border border-gray-200 hover:shadow-xl transition-all duration-300 group">
                    <div class="flex items-center space-x-3 sm:space-x-4">
                        <div class="p-3 bg-blue-100 rounded-lg sm:rounded-xl group-hover:bg-blue-500 transition-colors duration-300">
                            <i class="fas fa-receipt text-blue-600 group-hover:text-white text-lg sm:text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 text-base sm:text-lg mb-1">Tagihan Saya</h3>
                            <p class="text-gray-600 text-xs sm:text-sm">Lihat dan bayar tagihan</p>
                        </div>
                    </div>
                </a>

                <!-- Riwayat Pembayaran -->
                <a href="{{ route('siswa.transaksi.index') }}"
                   class="bg-white rounded-xl sm:rounded-2xl shadow-md sm:shadow-lg p-4 sm:p-6 border border-gray-200 hover:shadow-xl transition-all duration-300 group">
                    <div class="flex items-center space-x-3 sm:space-x-4">
                        <div class="p-3 bg-green-100 rounded-lg sm:rounded-xl group-hover:bg-green-500 transition-colors duration-300">
                            <i class="fas fa-history text-green-600 group-hover:text-white text-lg sm:text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 text-base sm:text-lg mb-1">Riwayat</h3>
                            <p class="text-gray-600 text-xs sm:text-sm">Transaksi pembayaran</p>
                        </div>
                    </div>
                </a>

                <!-- Profile -->
                <a href="{{ route('siswa.profile.show') }}"
                   class="bg-white rounded-xl sm:rounded-2xl shadow-md sm:shadow-lg p-4 sm:p-6 border border-gray-200 hover:shadow-xl transition-all duration-300 group">
                    <div class="flex items-center space-x-3 sm:space-x-4">
                        <div class="p-3 bg-purple-100 rounded-lg sm:rounded-xl group-hover:bg-purple-500 transition-colors duration-300">
                            <i class="fas fa-user text-purple-600 group-hover:text-white text-lg sm:text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 text-base sm:text-lg mb-1">Profile</h3>
                            <p class="text-gray-600 text-xs sm:text-sm">Kelola data diri</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Recent Activity & Quick Stats -->
        <div class="grid grid-cols-1 gap-4 sm:gap-6">
            <!-- Pembayaran Terbaru -->
            <div class="bg-white rounded-xl sm:rounded-2xl shadow-md sm:shadow-lg border border-gray-200">
                <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-history text-gray-600 mr-2 text-sm sm:text-base"></i>
                        Pembayaran Terbaru
                    </h3>
                </div>
                <div class="p-3 sm:p-4 sm:p-6">
                    @forelse($pembayaran->take(5) as $pembayaran)
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between py-3 sm:py-4 border-b border-gray-100 last:border-b-0 gap-3 sm:gap-0">
                        <div class="flex items-center space-x-3 flex-1 min-w-0 w-full sm:w-auto">
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
                            <div class="min-w-0 flex-1">
                                <p class="font-medium text-gray-800 text-sm sm:text-base truncate">{{ $pembayaran->kategori->nama_kategori }}</p>
                                <p class="text-xs text-gray-500">{{ $pembayaran->created_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                        <div class="text-right w-full sm:w-auto">
                            <p class="font-semibold text-gray-800 text-sm">Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</p>
                            <span class="inline-block px-2 py-1 text-[10px] sm:text-xs rounded-full mt-1
                                @if($pembayaran->status == 'paid') bg-green-100 text-green-800
                                @elseif($pembayaran->status == 'pending') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ $pembayaran->status == 'paid' ? 'Lunas' :
                                   ($pembayaran->status == 'pending' ? 'Menunggu' : 'Ditolak') }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-6 sm:py-8">
                        <i class="fas fa-receipt text-3xl sm:text-4xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500 font-medium text-sm sm:text-base">Belum ada pembayaran</p>
                        <p class="text-xs sm:text-sm text-gray-400 mt-1">Riwayat pembayaran akan muncul di sini</p>
                    </div>
                    @endforelse

                    @if($pembayaran->count() > 0)
                    <div class="mt-4 sm:mt-6 pt-3 sm:pt-4 border-t border-gray-200">
                        <a href="{{ route('siswa.transaksi') }}" class="text-blue-600 hover:text-blue-800 font-medium flex items-center justify-center text-sm">
                            Lihat Semua Riwayat
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Tagihan Aktif -->
            <div class="bg-white rounded-xl sm:rounded-2xl shadow-md sm:shadow-lg border border-gray-200">
                <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-receipt text-gray-600 mr-2 text-sm sm:text-base"></i>
                        Tagihan Aktif
                    </h3>
                </div>
                <div class="p-3 sm:p-4 sm:p-6">
                    @forelse($tagihan->where('status', 'unpaid')->take(3) as $tagihanItem)
                    <div class="bg-orange-50 border border-orange-200 rounded-lg sm:rounded-xl p-3 sm:p-4 mb-3 sm:mb-4 last:mb-0">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between">
                            <div class="min-w-0 flex-1 mb-2 sm:mb-0">
                                <p class="font-semibold text-orange-800 text-sm sm:text-base truncate">{{ $tagihanItem->kategori->nama_kategori }}</p>
                                <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-4 space-y-1 sm:space-y-0 mt-1 sm:mt-2">
                                    <p class="text-xs text-orange-600">
                                        <i class="fas fa-calendar-alt mr-1 text-[10px] sm:text-xs"></i>
                                        Jatuh tempo: {{ \Carbon\Carbon::parse($tagihanItem->tanggal_jatuh_tempo)->format('d M Y') }}
                                    </p>
                                    <p class="text-xs text-orange-600">
                                        <i class="fas fa-calendar-day mr-1 text-[10px] sm:text-xs"></i>
                                        Dibuat: {{ $tagihanItem->created_at->format('d M Y') }}
                                    </p>
                                </div>
                            </div>
                            <div class="text-right w-full sm:w-auto flex-shrink-0">
                                <p class="font-bold text-orange-800 text-sm sm:text-base">Rp {{ number_format($tagihanItem->jumlah_tagihan, 0, ',', '.') }}</p>
                                <span class="inline-block px-2 py-1 bg-orange-100 text-orange-800 text-[10px] sm:text-xs rounded-full mt-2">
                                    Belum Bayar
                                </span>
                            </div>
                        </div>
                        @if($tagihanItem->keterangan)
                        <div class="mt-2 sm:mt-3 pt-2 sm:pt-3 border-t border-orange-100">
                            <p class="text-[10px] sm:text-xs text-orange-700"><span class="font-medium">Keterangan:</span> {{ $tagihanItem->keterangan }}</p>
                        </div>
                        @endif
                    </div>
                    @empty
                    <div class="text-center py-6 sm:py-8">
                        <i class="fas fa-check-circle text-3xl sm:text-4xl text-green-300 mb-3"></i>
                        <p class="text-gray-500 font-medium text-sm sm:text-base">Tidak ada tagihan aktif</p>
                        <p class="text-xs sm:text-sm text-gray-400 mt-1">Semua tagihan sudah lunas</p>
                    </div>
                    @endforelse

                    @if($tagihan->where('status', 'unpaid')->count() > 0)
                    <div class="mt-4 sm:mt-6 pt-3 sm:pt-4 border-t border-gray-200">
                        <a href="{{ route('siswa.tagihan') }}" class="text-blue-600 hover:text-blue-800 font-medium flex items-center justify-center text-sm">
                            Lihat Semua Tagihan
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection