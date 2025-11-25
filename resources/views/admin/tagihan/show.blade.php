@extends('layouts.app')

@section('title', 'Detail Tagihan')

@section('content')
<div class="pt-16 px-6">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Detail Tagihan</h1>
                    <p class="text-gray-600">Informasi lengkap tagihan</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.tagihan.edit', $tagihan->id) }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2">
                        <i class="fas fa-edit"></i>
                        <span>Edit</span>
                    </a>
                    <a href="{{ route('admin.tagihan.index') }}" 
                       class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">
                        Kembali
                    </a>
                </div>
            </div>

            <!-- Content -->
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Informasi Siswa -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Informasi Siswa</h3>
                        <div class="space-y-2">
                            <div>
                                <span class="text-sm font-medium text-gray-600">Nama:</span>
                                <p class="text-gray-900">{{ $tagihan->user->name }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600">Email:</span>
                                <p class="text-gray-900">{{ $tagihan->user->email }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600">Kelas:</span>
                                <p class="text-gray-900">{{ $tagihan->user->kelas ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Tagihan -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Informasi Tagihan</h3>
                        <div class="space-y-2">
                            <div>
                                <span class="text-sm font-medium text-gray-600">Kategori:</span>
                                <p class="text-gray-900">{{ $tagihan->kategori->nama_kategori }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600">Jumlah:</span>
                                <p class="text-xl font-bold text-gray-900">
                                    Rp {{ number_format($tagihan->jumlah_tagihan, 0, ',', '.') }}
                                </p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600">Status:</span>
                                @php
                                    $statusColors = [
                                        'paid' => 'bg-green-100 text-green-800',
                                        'pending' => 'bg-yellow-100 text-yellow-800', 
                                        'overdue' => 'bg-red-100 text-red-800'
                                    ];
                                @endphp
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $statusColors[$tagihan->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($tagihan->status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Tanggal -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Informasi Tanggal</h3>
                        <div class="space-y-2">
                            <div>
                                <span class="text-sm font-medium text-gray-600">Dibuat:</span>
                                <p class="text-gray-900">{{ $tagihan->created_at->format('d M Y H:i') }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600">Jatuh Tempo:</span>
                                <p class="text-gray-900 {{ $tagihan->tanggal_jatuh_tempo->isPast() && $tagihan->status == 'pending' ? 'text-red-600 font-semibold' : '' }}">
                                    {{ $tagihan->tanggal_jatuh_tempo->format('d M Y') }}
                                    @if($tagihan->tanggal_jatuh_tempo->isPast() && $tagihan->status == 'pending')
                                    <span class="text-xs">(Terlambat)</span>
                                    @endif
                                </p>
                            </div>
                            @if($tagihan->paid_at)
                            <div>
                                <span class="text-sm font-medium text-gray-600">Dibayar:</span>
                                <p class="text-gray-900">{{ $tagihan->paid_at->format('d M Y H:i') }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Keterangan -->
                    <div class="bg-gray-50 p-4 rounded-lg md:col-span-2">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Keterangan</h3>
                        <p class="text-gray-900">{{ $tagihan->keterangan ?? 'Tidak ada keterangan' }}</p>
                    </div>
                </div>

                <!-- Riwayat Pembayaran -->
                @if($tagihan->pembayaran)
                <div class="mt-6 bg-green-50 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold text-green-800 mb-3">Riwayat Pembayaran</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-green-700">Tanggal Bayar:</span>
                            <span class="text-green-900">{{ $tagihan->pembayaran->tanggal_bayar->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-green-700">Metode Bayar:</span>
                            <span class="text-green-900 capitalize">{{ $tagihan->pembayaran->metode_bayar }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-green-700">Status:</span>
                            <span class="px-2 py-1 text-xs rounded-full bg-green-200 text-green-800 capitalize">
                                {{ $tagihan->pembayaran->status }}
                            </span>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection