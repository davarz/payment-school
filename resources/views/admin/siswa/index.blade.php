@extends('layouts.app')

@section('title', 'Data Siswa')

@section('content')
    <div class="pt-16 px-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Data Siswa</h2>
            <a href="{{ route('admin.siswa.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-plus mr-2"></i> Tambah Siswa
            </a>
        </div>

        <!-- Search & Filter -->
        <div class="bg-white rounded-lg shadow p-4 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <input type="text" id="searchInput" placeholder="Cari nama/NIS..."
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <select id="statusFilter"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Semua Status</option>
                        <option value="aktif">Aktif</option>
                        <option value="pindah">Pindah</option>
                        <option value="dikeluarkan">Dikeluarkan</option>
                    </select>
                </div>
                <div>
                    <select id="kelasFilter"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Semua Kelas</option>
                        @foreach($kelasList as $kelas)
                            <option value="{{ $kelas }}">{{ $kelas }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">NIS</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kelas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Password</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="siswaTable">
                        @foreach($siswa as $item)
                                        <tr class="siswa-row cursor-pointer hover:bg-gray-50 transition-all duration-200"
                                            data-status="{{ $item->status_siswa }}" data-kelas="{{ $item->kelas }}"
                                            onclick="showDetailById({{ $item->id }})">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $item->nis }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <div class="flex items-center">
                                                    {{ $item->name }}
                                                    <i class="fas fa-external-link-alt ml-2 text-gray-400 text-xs"></i>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $item->kelas }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <div class="flex items-center">
                                                    <span id="password-{{ $item->id }}" class="text-gray-600">••••••••</span>
                                                    <button
                                                        onclick="togglePassword({{ $item->id }}, '{{ $item->name }}', '{{ $item->nis }}')"
                                                        class="ml-2 text-blue-600 hover:text-blue-900 text-xs" title="Lihat Password">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    {{ $item->status_siswa == 'aktif' ? 'bg-green-100 text-green-800' :
                            ($item->status_siswa == 'pindah' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                    {{ ucfirst($item->status_siswa) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2"
                                                onclick="event.stopPropagation()">
                                                <a href="{{ route('admin.siswa.edit', $item->id) }}"
                                                    class="text-blue-600 hover:text-blue-900" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.siswa.reset-password', $item->id) }}" method="POST"
                                                    class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-yellow-600 hover:text-yellow-900"
                                                        onclick="return confirm('Reset password?')" title="Reset Password">
                                                        <i class="fas fa-key"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.siswa.destroy', $item->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900"
                                                        onclick="return confirm('Hapus siswa?')" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $siswa->links() }}
            </div>
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