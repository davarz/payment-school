@extends('layouts.app')

@section('title', 'Tambah Tagihan Manual')

@section('content')
<div class="pt-16 px-6">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Tambah Tagihan Manual</h2>
                    <p class="text-gray-600">Buat tagihan untuk siswa tertentu</p>
                </div>
                <a href="{{ route('admin.tagihan.index') }}" 
                   class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">
                    Kembali
                </a>
            </div>

            <form action="{{ route('admin.tagihan.store') }}" method="POST">
                @csrf
                <div class="space-y-6">
                    <!-- Pilih Siswa -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Siswa *</label>
                        <select name="user_id" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">-- Pilih Siswa --</option>
                            @foreach($siswa as $s)
                            <option value="{{ $s->id }}" {{ old('user_id') == $s->id ? 'selected' : '' }}>
                                {{ $s->name }} - {{ $s->email }}
                            </option>
                            @endforeach
                        </select>
                        @error('user_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Pilih Kategori -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kategori Pembayaran *</label>
                        <select name="kategori_pembayaran_id" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategori as $k)
                            <option value="{{ $k->id }}" {{ old('kategori_pembayaran_id') == $k->id ? 'selected' : '' }}>
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
                        <input type="number" name="jumlah_tagihan" value="{{ old('jumlah_tagihan') }}" required 
                               min="0" step="0.01"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder="Masukkan jumlah tagihan">
                        @error('jumlah_tagihan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Jatuh Tempo -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Jatuh Tempo *</label>
                        <input type="date" name="tanggal_jatuh_tempo" value="{{ old('tanggal_jatuh_tempo') }}" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('tanggal_jatuh_tempo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Keterangan -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Keterangan</label>
                        <textarea name="keterangan" rows="3"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                  placeholder="Keterangan tagihan (opsional)">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
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
                        <span>Simpan Tagihan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Set minimal tanggal ke hari ini
    document.querySelector('input[name="tanggal_jatuh_tempo"]').min = new Date().toISOString().split('T')[0];
</script>
@endsection 