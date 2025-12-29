@extends('layouts.app')

@section('title', 'Detail Tagihan')

@section('content')
<div class="container mx-auto px-4 py-8">
    @if($profileIncomplete)
    <x-alert type="info" title="Profil Belum Lengkap!" closable class="mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
            <div>
                <strong>Profil Anda belum lengkap.</strong> Lengkapi data diri Anda untuk pengalaman yang lebih baik.
            </div>
            <a href="{{ route('profile.complete') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition duration-150">
                <i class="fas fa-user-edit mr-2"></i>
                Lengkapi Profil
            </a>
        </div>
    </x-alert>
    @endif

    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold">Detail Tagihan</h1>
                        <p class="opacity-90 mt-1">Informasi lengkap tentang tagihan Anda</p>
                    </div>
                    <div class="text-right">
                        <span class="text-sm opacity-80">Kode Tagihan</span>
                        <p class="text-lg font-mono font-bold">#{{ $tagihan->id }}</p>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <!-- Tagihan Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="bg-blue-50 rounded-lg p-4">
                        <h3 class="font-semibold text-blue-800 mb-2">Informasi Tagihan</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Kategori:</span>
                                <span class="font-medium">{{ $tagihan->kategori->nama_kategori ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Jumlah Tagihan:</span>
                                <span class="font-medium font-bold text-blue-600">Rp {{ number_format($tagihan->jumlah_tagihan, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tanggal Dibuat:</span>
                                <span class="font-medium">{{ $tagihan->created_at->format('d M Y H:i') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Jatuh Tempo:</span>
                                <span class="font-medium">{{ $tagihan->tanggal_jatuh_tempo->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="font-semibold text-gray-800 mb-2">Status & Keterangan</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status:</span>
                                <span class="font-medium">
                                    <x-badge type="{{ $tagihan->status === 'paid' ? 'success' : ($tagihan->status === 'pending' ? 'warning' : 'danger') }}">
                                        {{ $tagihan->status === 'paid' ? 'Lunas' : ($tagihan->status === 'pending' ? 'Pending' : 'Belum Lunas') }}
                                    </x-badge>
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Keterangan:</span>
                                <span class="font-medium text-right">{{ $tagihan->keterangan ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pembayaran Terkait -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Pembayaran Terkait</h3>
                    @if($tagihan->pembayaran->count() > 0)
                        <div class="space-y-3">
                            @foreach($tagihan->pembayaran as $pembayaran)
                            <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium text-gray-900">Kode: {{ $pembayaran->kode_transaksi }}</p>
                                        <p class="text-sm text-gray-600">Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</p>
                                        <p class="text-xs text-gray-500 mt-1">{{ $pembayaran->tanggal_bayar->format('d M Y H:i') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <x-badge type="{{ $pembayaran->status === 'verified' ? 'success' : ($pembayaran->status === 'pending' ? 'warning' : 'danger') }}">
                                            {{ $pembayaran->status === 'verified' ? 'Terverifikasi' : ($pembayaran->status === 'pending' ? 'Menunggu' : 'Ditolak') }}
                                        </x-badge>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <i class="fas fa-receipt text-gray-400 text-2xl mb-2"></i>
                            <p class="text-gray-600">Belum ada pembayaran untuk tagihan ini</p>
                        </div>
                    @endif
                </div>

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row gap-3">
                    @if($tagihan->status !== 'paid')
                    <a href="{{ route('siswa.transaksi.index') }}" class="flex-1 bg-blue-600 text-white text-center py-3 px-4 rounded-lg hover:bg-blue-700 transition duration-200">
                        <i class="fas fa-money-bill-wave mr-2"></i>Lakukan Pembayaran
                    </a>
                    @endif
                    <a href="{{ route('siswa.tagihan.index') }}" class="flex-1 bg-gray-200 text-gray-800 text-center py-3 px-4 rounded-lg hover:bg-gray-300 transition duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Tagihan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection