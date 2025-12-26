@extends('layouts.app')

@section('title', 'Data Siswa')

@section('content')
<div class="space-y-8 pb-8">
    <!-- Page Header -->
    <div class="border-b border-gray-200 pb-6">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-4xl font-bold text-gray-900">Data Siswa</h1>
                <p class="text-gray-600 mt-2">Kelola data siswa, ubah informasi, dan monitor status keseluruhan</p>
            </div>
            <div class="text-blue-600 text-4xl">
                <i class="fas fa-users"></i>
            </div>
        </div>
    </div>

    <!-- Filter & Search Card -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
            <h2 class="text-lg font-bold text-white flex items-center gap-2">
                <i class="fas fa-filter"></i>
                <span>Pencarian & Filter</span>
            </h2>
        </div>
        <div class="p-6">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Cari Nama/NIS</label>
                    <input type="text" name="search" placeholder="Ketik nama atau NIS..." value="{{ request('search') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                    <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        <option value="">Semua Status</option>
                        <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="pindah" {{ request('status') === 'pindah' ? 'selected' : '' }}>Pindah</option>
                        <option value="dikeluarkan" {{ request('status') === 'dikeluarkan' ? 'selected' : '' }}>Dikeluarkan</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kelas</label>
                    <select name="kelas" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        <option value="">Semua Kelas</option>
                        @if(isset($kelasList))
                            @foreach($kelasList as $kelas)
                                <option value="{{ $kelas }}" {{ request('kelas') === $kelas ? 'selected' : '' }}>{{ $kelas }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
                        <i class="fas fa-search mr-2"></i>Cari
                    </button>
                    @if(request()->hasAny(['search', 'status', 'kelas']))
                    <a href="{{ route('admin.siswa.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition font-medium text-gray-700">
                        Reset
                    </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 flex items-center justify-between">
            <h2 class="text-lg font-bold text-white flex items-center gap-2">
                <i class="fas fa-list"></i>
                <span>Daftar Siswa</span>
                <span class="text-sm bg-blue-500 px-3 py-1 rounded-full">{{ $siswa->count() ?? 0 }}</span>
            </h2>
            <a href="{{ route('admin.siswa.create') }}" class="inline-flex items-center px-4 py-2 bg-white text-blue-600 rounded-lg hover:bg-blue-50 transition font-semibold">
                <i class="fas fa-plus mr-2"></i>Tambah Siswa
            </a>
        </div>
        <div class="overflow-x-auto">
            @if($siswa && $siswa->count() > 0)
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">NIS</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Nama Lengkap</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Kelas</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Status</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Email</th>
                            <th class="px-6 py-3 text-center font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($siswa as $item)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-mono font-semibold text-gray-900">{{ $item->nis }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($item->user->name) }}&background=3B82F6&color=fff&size=40"
                                        class="w-10 h-10 rounded-full" alt="{{ $item->user->name }}">
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $item->user->name }}</p>
                                        <p class="text-xs text-gray-600">{{ $item->user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold">{{ $item->kelas }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($item->status_siswa === 'aktif')
                                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold flex items-center gap-1 w-fit">
                                        <i class="fas fa-check-circle"></i> Aktif
                                    </span>
                                @elseif($item->status_siswa === 'pindah')
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-bold flex items-center gap-1 w-fit">
                                        <i class="fas fa-arrow-right"></i> Pindah
                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold flex items-center gap-1 w-fit">
                                        <i class="fas fa-times-circle"></i> Dikeluarkan
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $item->user->email }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.siswa.edit', $item->id) }}" class="inline-flex items-center px-3 py-2 rounded-lg bg-blue-100 text-blue-600 hover:bg-blue-200 transition font-medium" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.siswa.reset-password', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Reset password siswa ini?')">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center px-3 py-2 rounded-lg bg-amber-100 text-amber-600 hover:bg-amber-200 transition font-medium" title="Reset Password">
                                            <i class="fas fa-key"></i>
                                        </button>
                                    </form>
                                    <button onclick="deleteConfirm({{ $item->id }})" class="inline-flex items-center px-3 py-2 rounded-lg bg-red-100 text-red-600 hover:bg-red-200 transition font-medium" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                <form id="delete-form-{{ $item->id }}" action="{{ route('admin.siswa.destroy', $item->id) }}" method="POST" style="display:none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="text-center py-16">
                    <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                    <p class="text-gray-600 text-lg font-medium">Belum ada data siswa</p>
                    <p class="text-gray-500 text-sm mt-2">Mulai dengan menambahkan siswa baru ke dalam sistem</p>
                    <a href="{{ route('admin.siswa.create') }}" class="inline-flex items-center mt-6 px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
                        <i class="fas fa-plus mr-2"></i>Tambah Siswa
                    </a>
                </div>
            @endif
        </div>

        <!-- Pagination -->
        @if($siswa && $siswa->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
            {{ $siswa->links() }}
        </div>
        @endif
    </div>
</div>

    <!-- Detail Modal -->
    <div id="detailModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-800">Detail Siswa</h3>
                    <button onclick="closeDetail()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <div id="detailContent">
                    <!-- Detail akan diisi via JavaScript -->
                </div>
            </div>
        </div>
    </div>

    <script>
        function deleteConfirm(id) {
            if (confirm('Apakah Anda yakin ingin menghapus siswa ini?')) {
                document.getElementById('delete-form-' + id).submit();
            }
        }
    </script>

    @push('scripts')
        <script>
            // Function untuk toggle lihat/sembunyikan password
            function togglePassword(userId, name, nis) {
                const passwordElement = document.getElementById('password-' + userId);
                const nama = name.toLowerCase().replace(/\s/g, '');
                const generatedPassword = nama.substring(0, 3) + nis.substring(nis.length - 4);

                if (passwordElement.textContent === '••••••••') {
                    passwordElement.textContent = generatedPassword;
                    passwordElement.classList.remove('text-gray-600');
                    passwordElement.classList.add('text-green-600', 'font-medium');
                } else {
                    passwordElement.textContent = '••••••••';
                    passwordElement.classList.remove('text-green-600', 'font-medium');
                    passwordElement.classList.add('text-gray-600');
                }
            }

            // Function baru untuk get data by ID (lebih reliable)
            function showDetailById(siswaId) {
                // Fetch data dari server
                fetch(`/admin/siswa/${siswaId}/json`)
                    .then(response => response.json())
                    .then(siswa => {
                        showDetail(siswa);
                    })
                    .catch(error => {
                        console.error('Error fetching siswa data:', error);
                        alert('Gagal memuat data siswa');
                    });
            }

            function showDetail(siswa) {
                // Generate password untuk ditampilkan
                const nama = siswa.name.toLowerCase().replace(/\s/g, '');
                const nis = siswa.nis;
                const generatedPassword = nama.substring(0, 3) + nis.substring(nis.length - 4);

                const detailContent = `
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="space-y-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                                                <p class="mt-1 text-sm text-gray-900">${siswa.name}</p>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">NIS</label>
                                                <p class="mt-1 text-sm text-gray-900">${siswa.nis}</p>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">NIK</label>
                                                <p class="mt-1 text-sm text-gray-900">${siswa.nik}</p>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                                <p class="mt-1 text-sm text-gray-900">${siswa.email}</p>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Telepon</label>
                                                <p class="mt-1 text-sm text-gray-900">${siswa.telepon || '-'}</p>
                                            </div>
                                        </div>
                                        <div class="space-y-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Kelas</label>
                                                <p class="mt-1 text-sm text-gray-900">${siswa.kelas}</p>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Tahun Ajaran</label>
                                                <p class="mt-1 text-sm text-gray-900">${siswa.tahun_ajaran}</p>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                                <span class="mt-1 px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    ${siswa.status_siswa == 'aktif' ? 'bg-green-100 text-green-800' :
                        (siswa.status_siswa == 'pindah' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800')}">
                                                    ${siswa.status_siswa}
                                                </span>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Info Login</label>
                                                <div class="mt-1 p-3 bg-gray-50 rounded-lg">
                                                    <p class="text-sm text-gray-700"><strong>Email:</strong> ${siswa.email}</p>
                                                    <p class="text-sm text-gray-700 mt-1"><strong>Password:</strong> ${generatedPassword}</p>
                                                    <p class="text-xs text-gray-500 mt-2">Password digenerate dari: 3 huruf pertama nama + 4 digit terakhir NIS</p>
                                                </div>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Tempat, Tanggal Lahir</label>
                                                <p class="mt-1 text-sm text-gray-900">${siswa.tempat_lahir}, ${new Date(siswa.tanggal_lahir).toLocaleDateString('id-ID')}</p>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Alamat</label>
                                                <p class="mt-1 text-sm text-gray-900">${siswa.alamat || '-'}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-6 pt-6 border-t border-gray-200">
                                        <div class="flex justify-end space-x-3">
                                            <a href="/admin/siswa/${siswa.id}/edit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                                                <i class="fas fa-edit mr-2"></i> Edit Data
                                            </a>
                                            <form action="/admin/siswa/${siswa.id}/reset-password" method="POST" class="inline">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg flex items-center" onclick="return confirm('Reset password siswa?')">
                                                    <i class="fas fa-key mr-2"></i> Reset Password
                                                </button>
                                            </form>
                                            <button onclick="closeDetail()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">
                                                Tutup
                                            </button>
                                        </div>
                                    </div>
                                `;

                document.getElementById('detailContent').innerHTML = detailContent;
                document.getElementById('detailModal').classList.remove('hidden');
            }

            function closeDetail() {
                document.getElementById('detailModal').classList.add('hidden');
            }

            // Search & Filter Functionality
            document.addEventListener('DOMContentLoaded', function () {
                const searchInput = document.getElementById('searchInput');
                const statusFilter = document.getElementById('statusFilter');
                const kelasFilter = document.getElementById('kelasFilter');

                if (searchInput) {
                    searchInput.addEventListener('input', filterTable);
                }
                if (statusFilter) {
                    statusFilter.addEventListener('change', filterTable);
                }
                if (kelasFilter) {
                    kelasFilter.addEventListener('change', filterTable);
                }
            });

            function filterTable() {
                const search = document.getElementById('searchInput').value.toLowerCase();
                const status = document.getElementById('statusFilter').value;
                const kelas = document.getElementById('kelasFilter').value;

                const rows = document.querySelectorAll('.siswa-row');

                rows.forEach(row => {
                    const name = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                    const nis = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
                    const rowStatus = row.getAttribute('data-status');
                    const rowKelas = row.getAttribute('data-kelas');

                    const matchesSearch = name.includes(search) || nis.includes(search);
                    const matchesStatus = !status || rowStatus === status;
                    const matchesKelas = !kelas || rowKelas === kelas;

                    if (matchesSearch && matchesStatus && matchesKelas) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }

            // Close modal dengan ESC key
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') {
                    closeDetail();
                }
            });
        </script>
    @endpush
@endsection