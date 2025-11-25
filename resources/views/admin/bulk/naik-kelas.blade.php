@extends('layouts.app')

@section('title', 'Bulk Operations - Naik Kelas')

@section('content')
<div class="pt-16 px-6">
    <div class="max-w-6xl mx-auto">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Bulk Operations - Naik Kelas</h2>

            <form action="{{ route('admin.bulk.update-naik-kelas') }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tahun Ajaran Baru</label>
                        <input type="text" name="tahun_ajaran" required 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="2024/2025">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kelas Baru</label>
                        <input type="text" name="kelas" required 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="XI IPA 1">
                    </div>
                </div>

                <div class="mb-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900">Pilih Siswa</h3>
                        <div class="flex items-center space-x-2">
                            <input type="checkbox" id="select-all" class="rounded border-gray-300">
                            <label for="select-all" class="text-sm text-gray-700">Pilih Semua</label>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-lg p-4 max-h-96 overflow-y-auto">
                    <div class="space-y-2">
                        @foreach($siswa as $s)
                        <div class="flex items-center p-3 bg-white rounded border">
                            <input type="checkbox" name="siswa_ids[]" value="{{ $s->id }}" 
                                class="student-checkbox rounded border-gray-300 mr-3">
                            <div class="flex-1">
                                <p class="font-medium text-gray-900">{{ $s->name }}</p>
                                <p class="text-sm text-gray-600">
                                    NIS: {{ $s->nis }} | Kelas: {{ $s->kelas }} | Tahun: {{ $s->tahun_ajaran }}
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <div class="flex">
                        <i class="fas fa-exclamation-triangle text-yellow-600 mt-1 mr-3"></i>
                        <div>
                            <h4 class="text-sm font-medium text-yellow-800">Peringatan</h4>
                            <p class="text-sm text-yellow-700 mt-1">
                                Operasi ini akan mengupdate tahun ajaran dan kelas untuk semua siswa yang dipilih. 
                                Pastikan data sudah benar sebelum melanjutkan.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit" 
                        class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg flex items-center">
                        <i class="fas fa-users mr-2"></i>
                        Update Massal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('select-all').addEventListener('change', function(e) {
        const checkboxes = document.querySelectorAll('.student-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = e.target.checked;
        });
    });
</script>
@endpush
@endsection