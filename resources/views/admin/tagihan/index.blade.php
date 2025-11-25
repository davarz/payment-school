@extends('layouts.app')

@section('title', 'Manajemen Tagihan')

@section('content')
<div class="pt-16 px-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Manajemen Tagihan</h1>
                <p class="text-gray-600">Kelola tagihan siswa</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <button onclick="generateBills()" 
                        id="generateBtn"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition duration-200">
                    <i class="fas fa-bolt text-sm"></i>
                    <span>Generate Tagihan</span>
                </button>
                <a href="{{ route('admin.tagihan.create') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2">
                    <i class="fas fa-plus text-sm"></i>
                    <span>Tambah Manual</span>
                </a>
            </div>
        </div>

        <!-- Progress & Result Sections -->
        <div id="progressSection" class="hidden mb-4 p-4 bg-blue-50 rounded-lg">
            <div class="flex items-center space-x-3">
                <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-blue-600"></div>
                <span class="text-blue-700" id="progressText">Sedang generate tagihan...</span>
            </div>
        </div>
        
        <div id="resultSection" class="hidden mb-4 p-4 rounded-lg"></div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Lunas</option>
                        <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Terlambat</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bulan Jatuh Tempo</label>
                    <select name="bulan" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Semua Bulan</option>
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                    <input type="number" name="tahun" value="{{ request('tahun') ?? now()->year }}" 
                           min="2020" max="2030"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div class="flex items-end space-x-2">
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg w-full transition duration-200">
                        <i class="fas fa-filter mr-2"></i>
                        Filter
                    </button>
                    <a href="{{ route('admin.tagihan.index') }}" 
                       class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg transition duration-200">
                        <i class="fas fa-refresh mr-2"></i>
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white rounded-lg shadow p-4 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Tagihan</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $tagihan->total() }}</p>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <i class="fas fa-receipt text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-4 border-l-4 border-yellow-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Pending</p>
                        <p class="text-2xl font-bold text-yellow-600">{{ $tagihan->where('status', 'pending')->count() }}</p>
                    </div>
                    <div class="p-3 bg-yellow-100 rounded-lg">
                        <i class="fas fa-clock text-yellow-600 text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-4 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Lunas</p>
                        <p class="text-2xl font-bold text-green-600">{{ $tagihan->where('status', 'paid')->count() }}</p>
                    </div>
                    <div class="p-3 bg-green-100 rounded-lg">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Siswa
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kategori
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Jumlah
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Jatuh Tempo
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($tagihan as $item)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user text-blue-600"></i>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $item->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $item->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $item->kategori->nama_kategori }}</div>
                                <div class="text-sm text-gray-500 truncate max-w-xs">{{ $item->keterangan }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-semibold text-gray-900">
                                    Rp {{ number_format($item->jumlah_tagihan, 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 {{ $item->tanggal_jatuh_tempo->isPast() && $item->status == 'pending' ? 'text-red-600 font-semibold' : '' }}">
                                    {{ $item->tanggal_jatuh_tempo->format('d M Y') }}
                                    @if($item->tanggal_jatuh_tempo->isPast() && $item->status == 'pending')
                                    <div class="text-xs text-red-500 mt-1">
                                        <i class="fas fa-exclamation-triangle mr-1"></i>Terlambat
                                    </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusConfig = [
                                        'paid' => ['color' => 'bg-green-100 text-green-800', 'icon' => 'fa-check-circle'],
                                        'pending' => ['color' => 'bg-yellow-100 text-yellow-800', 'icon' => 'fa-clock'], 
                                        'overdue' => ['color' => 'bg-red-100 text-red-800', 'icon' => 'fa-exclamation-triangle']
                                    ];
                                    $config = $statusConfig[$item->status] ?? ['color' => 'bg-gray-100 text-gray-800', 'icon' => 'fa-question'];
                                @endphp
                                <span class="px-3 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full {{ $config['color'] }}">
                                    <i class="fas {{ $config['icon'] }} mr-1"></i>
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    @if($item->status == 'pending')
                                    <form action="{{ route('admin.tagihan.mark-paid', $item->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" 
                                                class="text-green-600 hover:text-green-900 transition duration-200 p-1 rounded"
                                                title="Tandai sebagai lunas"
                                                onclick="return confirm('Tandai tagihan sebagai lunas?')">
                                            <i class="fas fa-check-circle text-lg"></i>
                                        </button>
                                    </form>
                                    @endif
                                    
                                    <a href="{{ route('admin.tagihan.edit', $item->id) }}" 
                                       class="text-blue-600 hover:text-blue-900 transition duration-200 p-1 rounded"
                                       title="Edit tagihan">
                                        <i class="fas fa-edit text-lg"></i>
                                    </a>
                                    
                                    <a href="{{ route('admin.tagihan.show', $item->id) }}" 
                                       class="text-purple-600 hover:text-purple-900 transition duration-200 p-1 rounded"
                                       title="Lihat detail">
                                        <i class="fas fa-eye text-lg"></i>
                                    </a>

                                    <form action="{{ route('admin.tagihan.destroy', $item->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-red-600 hover:text-red-900 transition duration-200 p-1 rounded"
                                                title="Hapus tagihan"
                                                onclick="return confirm('Hapus tagihan ini?')">
                                            <i class="fas fa-trash text-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-400">
                                    <i class="fas fa-receipt text-5xl mb-4"></i>
                                    <p class="text-lg font-medium text-gray-500 mb-2">Belum ada data tagihan</p>
                                    <p class="text-sm text-gray-400 mb-4">Mulai dengan membuat tagihan manual atau generate otomatis</p>
                                    <div class="flex space-x-3">
                                        <button onclick="generateBills()" 
                                                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition duration-200">
                                            <i class="fas fa-bolt text-sm"></i>
                                            <span>Generate Tagihan</span>
                                        </button>
                                        <a href="{{ route('admin.tagihan.create') }}" 
                                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2">
                                            <i class="fas fa-plus text-sm"></i>
                                            <span>Tambah Manual</span>
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($tagihan->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Menampilkan {{ $tagihan->firstItem() }} - {{ $tagihan->lastItem() }} dari {{ $tagihan->total() }} tagihan
                    </div>
                    <div class="flex space-x-2">
                        {{ $tagihan->links() }}
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
function generateBills() {
    const btn = document.getElementById('generateBtn');
    const progressSection = document.getElementById('progressSection');
    const resultSection = document.getElementById('resultSection');
    const progressText = document.getElementById('progressText');
    
    // Disable button dan show progress
    btn.disabled = true;
    btn.classList.add('opacity-50', 'cursor-not-allowed');
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
            btn.disabled = false;
            btn.classList.remove('opacity-50', 'cursor-not-allowed');
        }, 3000);
    });
}

// Add confirmation for generate bills
document.addEventListener('DOMContentLoaded', function() {
    const generateBtn = document.getElementById('generateBtn');
    if (generateBtn) {
        generateBtn.addEventListener('click', function(e) {
            if (!confirm('Generate tagihan untuk semua siswa aktif? Tindakan ini akan membuat tagihan bulanan berdasarkan kategori yang aktif.')) {
                e.preventDefault();
            }
        });
    }
});
</script>
@endsection