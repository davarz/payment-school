@extends('layouts.app')

@section('title', 'Edit Kategori Pembayaran')

@section('content')
<div class="pt-16 px-6">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Kategori Pembayaran</h2>

            <form action="{{ route('admin.kategori.update', $kategori->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Kategori</label>
                        <input type="text" name="nama_kategori" value="{{ $kategori->nama_kategori }}" required 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea name="deskripsi" rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ $kategori->deskripsi }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jumlah Pembayaran</label>
                        <input type="number" name="jumlah" value="{{ $kategori->jumlah }}" required min="0" step="0.01"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Frekuensi</label>
                            <select name="frekuensi" required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="bulanan" {{ $kategori->frekuensi == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                                <option value="semester" {{ $kategori->frekuensi == 'semester' ? 'selected' : '' }}>Semester</option>
                                <option value="tahunan" {{ $kategori->frekuensi == 'tahunan' ? 'selected' : '' }}>Tahunan</option>
                            </select>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="auto_generate" id="auto_generate" value="1" 
                                {{ $kategori->auto_generate ? 'checked' : '' }}
                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <label for="auto_generate" class="ml-2 text-sm text-gray-700">Auto Generate Tagihan</label>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tahun Ajaran</label>
                            <input type="text" name="tahun_ajaran" value="{{ $kategori->tahun_ajaran }}" required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Semester</label>
                            <select name="semester" required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="ganjil" {{ $kategori->semester == 'ganjil' ? 'selected' : '' }}>Ganjil</option>
                                <option value="genap" {{ $kategori->semester == 'genap' ? 'selected' : '' }}>Genap</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" required 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="active" {{ $kategori->status == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ $kategori->status == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div class="mt-8 flex justify-end space-x-3">
                    <a href="{{ route('admin.kategori.index') }}" 
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">
                        Batal
                    </a>
                    <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                        Update Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection