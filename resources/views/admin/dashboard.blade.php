@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="pt-16 px-6">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Siswa -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Siswa</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalSiswa }}</p>
                    <p class="text-xs text-gray-500 mt-1">Siswa aktif</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-full">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Pembayaran -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Pembayaran</p>
                    <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($totalPembayaran, 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-500 mt-1">Bulan ini</p>
                </div>
                <div class="p-3 bg-green-100 rounded-full">
                    <i class="fas fa-money-bill-wave text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Tagihan Pending -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Tagihan Pending</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $totalTagihan }}</p>
                    <p class="text-xs text-gray-500 mt-1">Belum dibayar</p>
                </div>
                <div class="p-3 bg-yellow-100 rounded-full">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Pembayaran Pending -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Pemb. Pending</p>
                    <p class="text-2xl font-bold text-red-600">{{ $pembayaranPending }}</p>
                    <p class="text-xs text-gray-500 mt-1">Menunggu verifikasi</p>
                </div>
                <div class="p-3 bg-red-100 rounded-full">
                    <i class="fas fa-exclamation-circle text-red-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Grid -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Quick Actions</h2>
                <p class="text-gray-600">Akses cepat ke fitur utama</p>
            </div>
        </div>
        
        <!-- Mobile Grid untuk layar kecil -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4">
            <!-- Generate Tagihan -->
            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-4 text-white cursor-pointer transform hover:scale-105 transition duration-300 min-h-[120px] flex flex-col justify-center items-center text-center"
                 onclick="generateBills()">
                <div class="p-3 bg-white bg-opacity-20 rounded-full mb-2">
                    <i class="fas fa-bolt text-xl"></i>
                </div>
                <h3 class="font-bold text-sm mb-1">Generate</h3>
                <p class="text-green-100 text-xs">Tagihan Otomatis</p>
            </div>

            <!-- Kelola Tagihan -->
            <a href="{{ route('admin.tagihan.index') }}" 
               class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-4 text-white transform hover:scale-105 transition duration-300 min-h-[120px] flex flex-col justify-center items-center text-center">
                <div class="p-3 bg-white bg-opacity-20 rounded-full mb-2">
                    <i class="fas fa-receipt text-xl"></i>
                </div>
                <h3 class="font-bold text-sm mb-1">Kelola</h3>
                <p class="text-blue-100 text-xs">Tagihan</p>
            </a>

            <!-- Tambah Tagihan -->
            <a href="{{ route('admin.tagihan.create') }}" 
               class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg p-4 text-white transform hover:scale-105 transition duration-300 min-h-[120px] flex flex-col justify-center items-center text-center">
                <div class="p-3 bg-white bg-opacity-20 rounded-full mb-2">
                    <i class="fas fa-plus-circle text-xl"></i>
                </div>
                <h3 class="font-bold text-sm mb-1">Tambah</h3>
                <p class="text-purple-100 text-xs">Tagihan</p>
            </a>

            <!-- Verifikasi Pembayaran -->
            <a href="{{ route('admin.pembayaran.index') }}" 
               class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg shadow-lg p-4 text-white transform hover:scale-105 transition duration-300 min-h-[120px] flex flex-col justify-center items-center text-center">
                <div class="p-3 bg-white bg-opacity-20 rounded-full mb-2">
                    <i class="fas fa-check-double text-xl"></i>
                </div>
                <h3 class="font-bold text-sm mb-1">Verifikasi</h3>
                <p class="text-orange-100 text-xs">Pembayaran</p>
            </a>

            <!-- Kelola Siswa -->
            <a href="{{ route('admin.siswa.index') }}" 
               class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg shadow-lg p-4 text-white transform hover:scale-105 transition duration-300 min-h-[120px] flex flex-col justify-center items-center text-center">
                <div class="p-3 bg-white bg-opacity-20 rounded-full mb-2">
                    <i class="fas fa-user-graduate text-xl"></i>
                </div>
                <h3 class="font-bold text-sm mb-1">Kelola</h3>
                <p class="text-indigo-100 text-xs">Siswa</p>
            </a>

            <!-- Kategori Pembayaran -->
            <a href="{{ route('admin.kategori.index') }}" 
               class="bg-gradient-to-br from-pink-500 to-pink-600 rounded-lg shadow-lg p-4 text-white transform hover:scale-105 transition duration-300 min-h-[120px] flex flex-col justify-center items-center text-center">
                <div class="p-3 bg-white bg-opacity-20 rounded-full mb-2">
                    <i class="fas fa-tags text-xl"></i>
                </div>
                <h3 class="font-bold text-sm mb-1">Kategori</h3>
                <p class="text-pink-100 text-xs">Pembayaran</p>
            </a>

            <!-- Laporan -->
            <a href="{{ route('admin.pembayaran.index') }}?status=paid" 
               class="bg-gradient-to-br from-teal-500 to-teal-600 rounded-lg shadow-lg p-4 text-white transform hover:scale-105 transition duration-300 min-h-[120px] flex flex-col justify-center items-center text-center">
                <div class="p-3 bg-white bg-opacity-20 rounded-full mb-2">
                    <i class="fas fa-chart-bar text-xl"></i>
                </div>
                <h3 class="font-bold text-sm mb-1">Laporan</h3>
                <p class="text-teal-100 text-xs">Statistik</p>
            </a>

            <!-- Bulk Operations -->
            <a href="{{ route('admin.bulk.naik-kelas') }}" 
               class="bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-lg shadow-lg p-4 text-white transform hover:scale-105 transition duration-300 min-h-[120px] flex flex-col justify-center items-center text-center">
                <div class="p-3 bg-white bg-opacity-20 rounded-full mb-2">
                    <i class="fas fa-cogs text-xl"></i>
                </div>
                <h3 class="font-bold text-sm mb-1">Bulk</h3>
                <p class="text-cyan-100 text-xs">Operations</p>
            </a>

            <!-- Backup Data -->
            <a href="{{ route('admin.import-export.export') }}" 
               class="bg-gradient-to-br from-gray-500 to-gray-600 rounded-lg shadow-lg p-4 text-white transform hover:scale-105 transition duration-300 min-h-[120px] flex flex-col justify-center items-center text-center">
                <div class="p-3 bg-white bg-opacity-20 rounded-full mb-2">
                    <i class="fas fa-file-export text-xl"></i>
                </div>
                <h3 class="font-bold text-sm mb-1">Backup</h3>
                <p class="text-gray-100 text-xs">Data</p>
            </a>

            <!-- Riwayat Transaksi -->
            <a href="{{ route('admin.pembayaran.index') }}" 
               class="bg-gradient-to-br from-red-500 to-red-600 rounded-lg shadow-lg p-4 text-white transform hover:scale-105 transition duration-300 min-h-[120px] flex flex-col justify-center items-center text-center">
                <div class="p-3 bg-white bg-opacity-20 rounded-full mb-2">
                    <i class="fas fa-history text-xl"></i>
                </div>
                <h3 class="font-bold text-sm mb-1">Riwayat</h3>
                <p class="text-red-100 text-xs">Transaksi</p>
            </a>
        </div>
    </div>

    <!-- Progress & Result Sections untuk Generate Bills -->
    <div id="progressSection" class="hidden mb-4 p-4 bg-blue-50 rounded-lg border border-blue-200">
        <div class="flex items-center space-x-3">
            <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600"></div>
            <span class="text-blue-700 font-medium" id="progressText">Sedang generate tagihan...</span>
        </div>
    </div>
    
    <div id="resultSection" class="hidden mb-4 p-4 rounded-lg border"></div>

    <!-- Pembayaran yang Pending -->
    <div class="bg-white rounded-lg shadow mb-8">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Pembayaran yang Pending</h3>
                <p class="text-sm text-gray-600">Pembayaran menunggu verifikasi admin</p>
            </div>
            <a href="{{ route('admin.pembayaran.index') }}?status=pending" class="text-blue-600 hover:text-blue-800 font-medium flex items-center space-x-1">
                <span>Lihat Semua</span>
                <i class="fas fa-arrow-right text-sm"></i>
            </a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Siswa</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Metode</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($recentPembayaran->where('status', 'pending') as $pembayaran)
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-mono font-medium text-gray-900">{{ $pembayaran->kode_transaksi }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-8 w-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-blue-600 text-xs"></i>
                                </div>
                                <div class="text-sm font-medium text-gray-900">{{ $pembayaran->user->name }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm text-gray-700">{{ $pembayaran->kategori->nama_kategori }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-semibold text-gray-900">
                                Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm text-gray-700 capitalize">{{ $pembayaran->metode_bayar }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $pembayaran->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-2">
                                <form action="{{ route('admin.pembayaran.verify', $pembayaran) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" 
                                            class="px-3 py-1 bg-green-500 hover:bg-green-600 text-white text-xs font-medium rounded transition duration-200 flex items-center space-x-1"
                                            onclick="return confirm('Verifikasi pembayaran ini?')">
                                        <i class="fas fa-check text-xs"></i>
                                        <span>Verify</span>
                                    </button>
                                </form>
                                <form action="{{ route('admin.pembayaran.cancel', $pembayaran) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" 
                                            class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white text-xs font-medium rounded transition duration-200 flex items-center space-x-1"
                                            onclick="return confirm('Tolak pembayaran ini?')">
                                        <i class="fas fa-times text-xs"></i>
                                        <span>Tolak</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-400">
                                <i class="fas fa-check-circle text-4xl mb-3 text-green-400"></i>
                                <p class="text-gray-500 font-medium">Tidak ada pembayaran pending</p>
                                <p class="text-sm text-gray-400 mt-1">Semua pembayaran sudah terverifikasi</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($recentPembayaran->where('status', 'pending')->count() > 0)
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 text-center">
            <a href="{{ route('admin.pembayaran.index') }}?status=pending" class="text-blue-600 hover:text-blue-800 font-medium inline-flex items-center space-x-1">
                <span>Lihat semua pembayaran pending</span>
                <i class="fas fa-arrow-right text-sm"></i>
            </a>
        </div>
        @endif
    </div>
</div>

<script>
function generateBills() {
    if (!confirm('Generate tagihan untuk semua siswa aktif? Tindakan ini akan membuat tagihan bulanan berdasarkan kategori yang aktif.')) {
        return;
    }

    const progressSection = document.getElementById('progressSection');
    const resultSection = document.getElementById('resultSection');
    const progressText = document.getElementById('progressText');
    
    // Disable tombol generate dan show progress
    const generateBtn = document.querySelector('[onclick="generateBills()"]');
    if (generateBtn) {
        generateBtn.style.opacity = '0.5';
        generateBtn.style.pointerEvents = 'none';
    }
    
    progressSection.classList.remove('hidden');
    resultSection.classList.add('hidden');
    progressText.textContent = 'Sedang generate tagihan...';
    
    // AJAX request
    fetch('{{ route("admin.tagihan.generate-bills") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        // Show result
        progressSection.classList.add('hidden');
        resultSection.classList.remove('hidden');
        
        if (data.success) {
            resultSection.className = 'mb-4 p-4 bg-green-50 border border-green-200 rounded-lg';
            resultSection.innerHTML = `
                <div class="flex items-center space-x-3">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    <div>
                        <p class="text-green-800 font-semibold text-lg">${data.message}</p>
                        <p class="text-green-600 text-sm">Waktu eksekusi: ${data.data.execution_time} detik</p>
                    </div>
                </div>
            `;
            
            // Refresh page after 2 seconds
            setTimeout(() => {
                window.location.reload();
            }, 2000);
        } else {
            resultSection.className = 'mb-4 p-4 bg-red-50 border border-red-200 rounded-lg';
            resultSection.innerHTML = `
                <div class="flex items-center space-x-3">
                    <i class="fas fa-times-circle text-red-600 text-xl"></i>
                    <div>
                        <p class="text-red-800 font-semibold text-lg">${data.message}</p>
                        <p class="text-red-600 text-sm">Silakan coba lagi atau hubungi administrator</p>
                    </div>
                </div>
            `;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        progressSection.classList.add('hidden');
        resultSection.classList.remove('hidden');
        resultSection.className = 'mb-4 p-4 bg-red-50 border border-red-200 rounded-lg';
        resultSection.innerHTML = `
            <div class="flex items-center space-x-3">
                <i class="fas fa-wifi text-red-600 text-xl"></i>
                <div>
                    <p class="text-red-800 font-semibold text-lg">Terjadi kesalahan jaringan</p>
                    <p class="text-red-600 text-sm">Periksa koneksi internet Anda dan coba lagi</p>
                </div>
            </div>
        `;
    })
    .finally(() => {
        // Re-enable button setelah 3 detik
        setTimeout(() => {
            if (generateBtn) {
                generateBtn.style.opacity = '1';
                generateBtn.style.pointerEvents = 'auto';
            }
        }, 3000);
    });
}
</script>
@endsection