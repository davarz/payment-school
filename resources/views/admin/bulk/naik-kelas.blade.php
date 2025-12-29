@extends('layouts.app')

@section('title', 'Bulk Operations - Naik Kelas')

@section('content')
<div class="space-y-8 pb-8">
    <!-- Page Header -->
    <div class="border-b border-gray-200 pb-6">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-4xl font-bold text-gray-900">Bulk Operations</h1>
                <p class="text-gray-600 mt-2">Update tahun ajaran dan kelas siswa secara massal</p>
            </div>
            <div class="text-indigo-600 text-4xl">
                <i class="fas fa-users"></i>
            </div>
        </div>
    </div>

    <!-- Main Form Card -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-4 flex items-center">
            <i class="fas fa-graduation-cap text-white text-2xl mr-4"></i>
            <div>
                <h2 class="text-xl font-bold text-white">Naik Kelas</h2>
                <p class="text-indigo-100 text-sm mt-1">Update tahun ajaran dan kelas untuk multiple siswa</p>
            </div>
        </div>

        <form action="{{ route('admin.bulk.update-naik-kelas') }}" method="POST" class="p-6">
            @csrf
            
            <!-- Input Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Tahun Ajaran Baru</label>
                    <input type="text" name="tahun_ajaran" required 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                        placeholder="2024/2025">
                    <p class="text-xs text-gray-500 mt-1">Format: YYYY/YYYY (contoh: 2024/2025)</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Kelas Baru</label>
                    <input type="text" name="kelas" required 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                        placeholder="XI IPA 1">
                    <p class="text-xs text-gray-500 mt-1">Contoh: X IPA 1, XI IPS 2, XII Teknik</p>
                </div>
            </div>

            <!-- Siswa Selection -->
            <div class="mb-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Pilih Siswa</h3>
                        <p class="text-sm text-gray-600 mt-1">Centang siswa yang akan diupdate</p>
                    </div>
                    <div class="flex items-center gap-3 bg-indigo-50 px-4 py-2 rounded-lg">
                        <input type="checkbox" id="select-all" class="rounded border-indigo-300 accent-indigo-600">
                        <label for="select-all" class="text-sm font-medium text-indigo-700 cursor-pointer">Pilih Semua</label>
                    </div>
                </div>

                <!-- Student List -->
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                        <p class="text-sm font-semibold text-gray-700">
                            Total Siswa: <span id="total-siswa">{{ count($siswa) }}</span> | 
                            Terpilih: <span id="selected-count" class="text-indigo-600 font-bold">0</span>
                        </p>
                    </div>
                    <div class="max-h-96 overflow-y-auto">
                        <div class="divide-y divide-gray-200">
                            @foreach($siswa as $s)
                            <div class="hover:bg-indigo-50 transition p-4 flex items-start gap-4">
                                <input type="checkbox" name="siswa_ids[]" value="{{ $s->id }}" 
                                    class="student-checkbox mt-1 rounded border-gray-300 accent-indigo-600" 
                                    onchange="updateSelectedCount()">
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900">{{ $s->user->name ?? 'N/A' }}</p>
                                    <div class="flex flex-wrap gap-2 mt-2">
                                        <span class="inline-flex items-center gap-1 text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded">
                                            <i class="fas fa-id-card"></i>{{ $s->nis }}
                                        </span>
                                        <span class="inline-flex items-center gap-1 text-xs bg-purple-100 text-purple-700 px-2 py-1 rounded">
                                            <i class="fas fa-chalkboard"></i>{{ $s->kelas }}
                                        </span>
                                        <span class="inline-flex items-center gap-1 text-xs bg-green-100 text-green-700 px-2 py-1 rounded">
                                            <i class="fas fa-calendar"></i>{{ $s->tahun_ajaran }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Warning Alert -->
            <div class="bg-yellow-50 border-l-4 border-yellow-600 rounded-lg p-4 mb-8">
                <div class="flex gap-4">
                    <i class="fas fa-exclamation-triangle text-yellow-600 text-lg mt-0.5 flex-shrink-0"></i>
                    <div>
                        <h4 class="text-sm font-bold text-yellow-900">⚠️ Peringatan Penting</h4>
                        <p class="text-sm text-yellow-800 mt-1">
                            Operasi ini akan mengupdate tahun ajaran dan kelas untuk <strong>semua siswa yang dipilih</strong>. 
                            Pastikan data sudah benar sebelum melanjutkan. Aksi ini tidak dapat dibatalkan!
                        </p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.siswa.index') }}" 
                    class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-semibold flex items-center">
                    <i class="fas fa-times mr-2"></i>
                    Batal
                </a>
                <button type="submit" 
                    class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition font-semibold flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    Update Massal
                </button>
            </div>
        </form>
    </div>

    <!-- Info Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Active Students -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl border border-blue-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-blue-600 text-white rounded-lg p-3 text-xl">
                    <i class="fas fa-user-check"></i>
                </div>
                <span class="text-xs font-semibold text-blue-700 bg-blue-200 px-2 py-1 rounded-full">Aktif</span>
            </div>
            <p class="text-gray-700 text-sm font-medium">Siswa Aktif</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ count($siswa) }}</p>
            <p class="text-xs text-gray-600 mt-2">Siap untuk diupdate</p>
        </div>

        <!-- Current Year -->
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl border border-purple-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-purple-600 text-white rounded-lg p-3 text-xl">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <span class="text-xs font-semibold text-purple-700 bg-purple-200 px-2 py-1 rounded-full">Tahun</span>
            </div>
            <p class="text-gray-700 text-sm font-medium">Tahun Akademik</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ date('Y') }}</p>
            <p class="text-xs text-gray-600 mt-2">Periode saat ini</p>
        </div>

        <!-- Info -->
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl border border-green-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="bg-green-600 text-white rounded-lg p-3 text-xl">
                    <i class="fas fa-info-circle"></i>
                </div>
                <span class="text-xs font-semibold text-green-700 bg-green-200 px-2 py-1 rounded-full">Info</span>
            </div>
            <p class="text-gray-700 text-sm font-medium">Tindakan</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">Bulk</p>
            <p class="text-xs text-gray-600 mt-2">Update massal data</p>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const selectAllCheckbox = document.getElementById('select-all');
    const studentCheckboxes = document.querySelectorAll('.student-checkbox');

    selectAllCheckbox.addEventListener('change', function() {
        studentCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateSelectedCount();
    });

    function updateSelectedCount() {
        const count = document.querySelectorAll('.student-checkbox:checked').length;
        document.getElementById('selected-count').textContent = count;
    }

    // Initial count
    updateSelectedCount();
</script>
@endpush
@endsection