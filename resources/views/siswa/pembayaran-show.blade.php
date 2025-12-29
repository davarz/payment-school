@extends('layouts.app')

@section('title', 'Detail Pembayaran')

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
            <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold">Detail Pembayaran</h1>
                        <p class="opacity-90 mt-1">Informasi lengkap tentang pembayaran Anda</p>
                    </div>
                    <div class="text-right">
                        <span class="text-sm opacity-80">Kode Transaksi</span>
                        <p class="text-lg font-mono font-bold">{{ $pembayaran->kode_transaksi }}</p>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <!-- Pembayaran Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="bg-green-50 rounded-lg p-4">
                        <h3 class="font-semibold text-green-800 mb-2">Informasi Pembayaran</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Kategori:</span>
                                <span class="font-medium">{{ $pembayaran->kategori->nama_kategori ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Jumlah Bayar:</span>
                                <span class="font-medium font-bold text-green-600">Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tanggal Bayar:</span>
                                <span class="font-medium">{{ $pembayaran->tanggal_bayar->format('d M Y H:i') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Metode Bayar:</span>
                                <span class="font-medium">{{ ucfirst(str_replace('_', ' ', $pembayaran->metode_bayar)) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="font-semibold text-gray-800 mb-2">Status & Verifikasi</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status:</span>
                                <span class="font-medium">
                                    <x-badge type="{{ $pembayaran->status === 'verified' ? 'success' : ($pembayaran->status === 'pending' ? 'warning' : 'danger') }}">
                                        {{ $pembayaran->status === 'verified' ? 'Terverifikasi' : ($pembayaran->status === 'pending' ? 'Menunggu' : 'Ditolak') }}
                                    </x-badge>
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Verifikator:</span>
                                <span class="font-medium">{{ $pembayaran->verifikator->name ?? 'Belum diverifikasi' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tanggal Verifikasi:</span>
                                <span class="font-medium">{{ $pembayaran->tanggal_verifikasi ? $pembayaran->tanggal_verifikasi->format('d M Y H:i') : '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bukti Pembayaran -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Bukti Pembayaran</h3>
                    @if($pembayaran->bukti_pembayaran)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center justify-center">
                            <a href="{{ Storage::url($pembayaran->bukti_pembayaran) }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-file-image text-4xl"></i>
                                <p class="mt-2 text-sm">Lihat Bukti Pembayaran</p>
                            </a>
                        </div>
                    </div>
                    @else
                    <div class="bg-gray-50 rounded-lg p-4 text-center">
                        <i class="fas fa-file-upload text-gray-400 text-2xl mb-2"></i>
                        <p class="text-gray-600">Tidak ada bukti pembayaran</p>
                    </div>
                    @endif
                </div>

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('siswa.transaksi.index') }}" class="flex-1 bg-blue-600 text-white text-center py-3 px-4 rounded-lg hover:bg-blue-700 transition duration-200">
                        <i class="fas fa-history mr-2"></i>Kembali ke Riwayat Transaksi
                    </a>
                    <a href="{{ route('siswa.tagihan.index') }}" class="flex-1 bg-gray-200 text-gray-800 text-center py-3 px-4 rounded-lg hover:bg-gray-300 transition duration-200">
                        <i class="fas fa-receipt mr-2"></i>Ke Daftar Tagihan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection