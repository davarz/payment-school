@extends('layouts.app')

@section('title', 'Edit Tagihan')

@section('content')
<div class="pt-16 px-6">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Edit Tagihan</h2>
                    <p class="text-gray-600">Update data tagihan</p>
                </div>
                <a href="{{ route('admin.tagihan.index') }}" 
                   class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">
                    Kembali
                </a>
            </div>

            <form action="{{ route('admin.tagihan.update', $tagihan->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-6">
                    <!-- Info Siswa (Readonly) -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Informasi Siswa</h3>
                        <p class="text-gray-900">{{ $tagihan->user->name }}</p>
                        <p class="text-sm text-gray-600">{{ $tagihan->user->email }}</p>
                    </div>

                    <!-- Pilih Kategori -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kategori Pembayaran *</label>
                        <select name="kategori_pembayaran_id" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategori as $k)
                            <option value="{{ $k->id }}" {{ $tagihan->kategori_pembayaran_id == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kategori }} - Rp {{ number_format($k->jumlah, 0, ',', '.') }}
                            </option>
                            @endforeach
                        </select>
                        @error('kategori_pembayaran_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jumlah Tagihan -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Tagihan *</label>
                        <input type="number" name="jumlah_tagihan" value="{{ old('jumlah_tagihan', $tagihan->jumlah_tagihan) }}" required 
                               min="0" step="0.01"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('jumlah_tagihan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Jatuh Tempo -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Jatuh Tempo *</label>
                        <input type="date" name="tanggal_jatuh_tempo" 
                               value="{{ old('tanggal_jatuh_tempo', $tagihan->tanggal_jatuh_tempo->format('Y-m-d')) }}" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('tanggal_jatuh_tempo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                        <select name="status" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="pending" {{ $tagihan->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ $tagihan->status == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="overdue" {{ $tagihan->status == 'overdue' ? 'selected' : '' }}>Overdue</option>
                        </select>
                        @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Keterangan -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Keterangan</label>
                        <textarea name="keterangan" rows="3"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                  placeholder="Keterangan tagihan">{{ old('keterangan', $tagihan->keterangan) }}</textarea>
                        @error('keterangan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Info Created -->
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <h3 class="text-sm font-medium text-blue-700 mb-1">Informasi Sistem</h3>
                        <p class="text-xs text-blue-600">
                            Dibuat: {{ $tagihan->created_at->format('d M Y H:i') }}
                            @if($tagihan->paid_at)
                            | Lunas: {{ $tagihan->paid_at->format('d M Y H:i') }}
                            @endif
                        </p>
                    </div>
                </div>

                <div class="mt-8 flex justify-end space-x-3">
                    <a href="{{ route('admin.tagihan.index') }}" 
                       class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-lg">
                        Batal
                    </a>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg flex items-center space-x-2">
                        <i class="fas fa-save"></i>
                        <span>Update Tagihan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection