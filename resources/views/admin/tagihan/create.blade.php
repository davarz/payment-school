@extends('layouts.app')

@section('title', 'Tambah Tagihan Manual')

@section('content')
<div class="space-y-6">
    <x-page-header title="Tambah Tagihan Manual" subtitle="Buat tagihan baru untuk siswa tertentu" icon="fa-plus-circle" />

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('admin.tagihan.store') }}" method="POST">
            @csrf

            <!-- Informasi Tagihan Section -->
            <div>
                <h3 class="text-lg font-bold mb-4 pb-2 border-b flex items-center">
                    <i class="fas fa-credit-card mr-2 text-blue-600"></i> Informasi Tagihan
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Siswa <span class="text-red-500">*</span></label>
                        <select name="user_id" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">-- Pilih Siswa --</option>
                            @foreach($siswa as $s)
                                <option value="{{ $s->user_id }}" {{ old('user_id') == $s->user_id ? 'selected' : '' }}>
                                    {{ $s->user->name }} ({{ $s->nis }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori Pembayaran <span class="text-red-500">*</span></label>
                        <select name="kategori_pembayaran_id" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategori as $k)
                                <option value="{{ $k->id }}" {{ old('kategori_pembayaran_id') == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama_kategori }} - Rp {{ number_format($k->jumlah, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori_pembayaran_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah Tagihan <span class="text-red-500">*</span></label>
                        <input type="number" name="jumlah_tagihan" value="{{ old('jumlah_tagihan') }}" required 
                               min="0" step="0.01" placeholder="0"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('jumlah_tagihan')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Jatuh Tempo <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_jatuh_tempo" value="{{ old('tanggal_jatuh_tempo') }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('tanggal_jatuh_tempo')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Detail Tambahan Section -->
            <div>
                <h3 class="text-lg font-bold mb-4 pb-2 border-b flex items-center">
                    <i class="fas fa-notes-medical mr-2 text-green-600"></i> Detail Tambahan
                </h3>
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Keterangan</label>
                    <textarea name="keterangan" rows="4" placeholder="Tambahkan keterangan tagihan (opsional)"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <a href="{{ route('admin.tagihan.index') }}" class="px-6 py-2 text-gray-600 hover:text-gray-900 font-medium rounded-lg hover:bg-gray-100 transition">
                    <i class="fas fa-times mr-2"></i> Batal
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-save mr-2"></i> Simpan Tagihan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.querySelector('input[name="tanggal_jatuh_tempo"]').min = new Date().toISOString().split('T')[0];
</script>
@endsection 