@extends('layouts.app')

@section('title', 'Tagihan Saya')

@section('content')
<div class="container mx-auto px-4 py-6 sm:py-8">
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

    <div class="flex flex-col items-center text-center sm:text-left sm:flex-row sm:items-center justify-between mb-6 sm:mb-8 gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Tagihan & Pembayaran Saya</h1>
            <p class="text-gray-600 mt-1 sm:mt-2 text-sm">Kelola tagihan Anda dan lihat riwayat pembayaran</p>
        </div>
        <button onclick="openModal('create-tagihan-modal')"
            class="bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white px-4 py-2 sm:px-6 sm:py-3 rounded-lg shadow-md w-full sm:w-auto text-center">
            Ajukan Tagihan
        </button>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-3 sm:gap-4 mb-6 sm:mb-8">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-4 sm:p-6 text-white">
            <div class="flex items-center">
                <div class="p-3 bg-blue-400 bg-opacity-30 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 sm:h-8 w-6 sm:w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-3 sm:ml-4">
                    <h3 class="text-xs sm:text-sm font-medium opacity-80">Total Tagihan</h3>
                    <p class="text-lg sm:text-2xl font-bold">Rp {{ number_format($totalTagihan, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-4 sm:p-6 text-white">
            <div class="flex items-center">
                <div class="p-3 bg-green-400 bg-opacity-30 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 sm:h-8 w-6 sm:w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-3 sm:ml-4">
                    <h3 class="text-xs sm:text-sm font-medium opacity-80">Lunas</h3>
                    <p class="text-lg sm:text-2xl font-bold">Rp {{ number_format($totalPaid, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-4 sm:p-6 text-white">
            <div class="flex items-center">
                <div class="p-3 bg-purple-400 bg-opacity-30 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 sm:h-8 w-6 sm:w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div class="ml-3 sm:ml-4">
                    <h3 class="text-xs sm:text-sm font-medium opacity-80">Pembayaran Terbaru</h3>
                    <p class="text-lg sm:text-2xl font-bold">{{ $pembayaran->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 sm:gap-6 sm:gap-8">
        <!-- Tagihan Aktif Section -->
        <div class="bg-white rounded-xl sm:rounded-2xl shadow-md sm:shadow-lg overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-4 sm:px-6 py-3 sm:py-4 border-b">
                <h2 class="text-lg sm:text-xl font-bold text-gray-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 sm:h-6 w-5 sm:w-6 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Tagihan Aktif
                </h2>
            </div>
            <div class="overflow-x-auto">
                <div class="divide-y divide-gray-200">
                    @forelse($tagihan as $item)
                    <div class="p-3 sm:p-4 hover:bg-gray-50 transition-colors duration-200">
                        <div class="flex flex-col justify-between gap-3">
                            <div>
                                <h3 class="font-semibold text-gray-800 text-sm sm:text-base">{{ $item->kategori->nama_kategori }}</h3>
                                <p class="text-gray-600 text-xs sm:text-sm mt-1">Rp {{ number_format($item->jumlah_tagihan, 0, ',', '.') }}</p>
                                <div class="flex items-center mt-2 text-xs sm:text-sm text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 sm:h-4 w-3 sm:w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Jatuh tempo: {{ $item->tanggal_jatuh_tempo->format('d M Y') }}
                                </div>
                            </div>
                            <div class="flex flex-col items-start sm:items-end">
                                <span class="px-2 py-1 text-[10px] sm:text-xs font-semibold rounded-full mb-2
                                    {{ $item->status == 'paid' ? 'bg-green-100 text-green-800' :
                                       ($item->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ $item->status == 'paid' ? 'Lunas' :
                                       ($item->status == 'pending' ? 'Pending' : 'Belum Lunas') }}
                                </span>
                                <p class="text-[10px] sm:text-xs text-gray-500">{{ $item->keterangan ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-6 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 sm:h-16 w-12 sm:w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="mt-3 sm:mt-4 text-base sm:text-lg font-medium text-gray-900">Tidak Ada Tagihan</h3>
                        <p class="mt-1 sm:mt-2 text-sm sm:text-base text-gray-500">Anda tidak memiliki tagihan aktif saat ini.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Pembayaran Terbaru Section -->
        <div class="bg-white rounded-xl sm:rounded-2xl shadow-md sm:shadow-lg overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-4 sm:px-6 py-3 sm:py-4 border-b">
                <h2 class="text-lg sm:text-xl font-bold text-gray-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 sm:h-6 w-5 sm:w-6 mr-2 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    Pembayaran Terbaru
                </h2>
            </div>
            <div class="overflow-x-auto">
                <div class="divide-y divide-gray-200">
                    @forelse($pembayaran as $pembayaranItem)
                    <div class="p-3 sm:p-4 hover:bg-gray-50 transition-colors duration-200">
                        <div class="flex flex-col justify-between gap-3">
                            <div>
                                <h3 class="font-semibold text-gray-800 text-sm sm:text-base">{{ $pembayaranItem->kategori->nama_kategori }}</h3>
                                <p class="text-gray-600 text-xs sm:text-sm mt-1">Rp {{ number_format($pembayaranItem->jumlah_pembayaran, 0, ',', '.') }}</p>
                                <div class="flex items-center mt-2 text-xs sm:text-sm text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 sm:h-4 w-3 sm:w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $pembayaranItem->created_at->format('d M Y H:i') }}
                                </div>
                            </div>
                            <div class="flex flex-col items-start sm:items-end">
                                <span class="px-2 py-1 text-[10px] sm:text-xs font-semibold rounded-full mb-2
                                    @if($pembayaranItem->status == 'verified')
                                        bg-green-100 text-green-800
                                    @elseif($pembayaranItem->status == 'pending')
                                        bg-yellow-100 text-yellow-800
                                    @else
                                        bg-red-100 text-red-800
                                    @endif">
                                    {{ $pembayaranItem->status == 'verified' ? 'Terverifikasi' :
                                       ($pembayaranItem->status == 'pending' ? 'Menunggu' : 'Ditolak') }}
                                </span>
                                <a href="{{ route('siswa.pembayaran.show', $pembayaranItem->id) }}"
                                   class="text-xs sm:text-sm text-blue-600 hover:text-blue-800 transition-colors">Detail ></a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-6 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 sm:h-16 w-12 sm:w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="mt-3 sm:mt-4 text-base sm:text-lg font-medium text-gray-900">Tidak Ada Pembayaran</h3>
                        <p class="mt-1 sm:mt-2 text-sm sm:text-base text-gray-500">Riwayat pembayaran Anda akan muncul di sini.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Tagihan Modal -->
<div id="create-tagihan-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95 opacity-0 translate-y-4 sm:translate-y-0 sm:scale-100"
         x-data="{ open: false }" x-init="() => { $el.classList.remove('opacity-0', 'scale-95', 'translate-y-4'); }">
        <div class="p-6">
            <div class="flex justify-between items-center pb-4 border-b">
                <h3 class="text-xl font-bold text-gray-800">Ajukan Tagihan Baru</h3>
                <button onclick="closeModal('create-tagihan-modal')"
                    class="text-gray-500 hover:text-gray-700 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form action="{{ route('siswa.tagihan.create') }}" method="POST">
                @csrf
                <div class="space-y-4 mt-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori Pembayaran</label>
                        <select name="kategori_pembayaran_id" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            <option value="">Pilih Kategori</option>
                            @foreach($kategori as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Tagihan</label>
                        <input type="number" name="jumlah_tagihan" required min="0" step="0.01"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                            placeholder="Masukkan jumlah tagihan">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Jatuh Tempo</label>
                        <input type="date" name="tanggal_jatuh_tempo" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                        <textarea name="keterangan" rows="3"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                            placeholder="Tambahkan keterangan (opsional)"></textarea>
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="closeModal('create-tagihan-modal')"
                        class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                        class="bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white px-6 py-3 rounded-lg shadow-md transition-all duration-300">
                        Ajukan Tagihan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            // Add scroll lock
            document.body.style.overflow = 'hidden';
        }
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');

            // Remove scroll lock
            document.body.style.overflow = '';
        }
    }

    // Close modal when clicking on backdrop
    document.addEventListener('click', function(e) {
        const modal = document.getElementById('create-tagihan-modal');
        if (modal && modal.classList.contains('flex') && e.target === modal) {
            closeModal('create-tagihan-modal');
        }
    });
</script>
@endsection