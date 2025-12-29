@extends('layouts.app')

@section('title', 'Profile Saya')

@section('content')
<div class="container mx-auto px-4 py-8">
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

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Profile Saya</h1>
        <p class="text-gray-600">Kelola informasi akun dan password Anda</p>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                <span class="text-green-700">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column - Profile Info -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <!-- Header -->
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800">Informasi Pribadi</h2>
                    <p class="text-sm text-gray-600">Data diri dan informasi kontak</p>
                </div>

                <!-- Profile Content -->
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Personal Information -->
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Nama Lengkap</label>
                                <p class="text-lg font-semibold text-gray-900">{{ $user->name }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Email</label>
                                <p class="text-lg text-gray-900">{{ $user->email }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">NIS</label>
                                <p class="text-lg font-mono text-gray-900">{{ $siswa->nis ?? '-' }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">NIK</label>
                                <p class="text-lg font-mono text-gray-900">{{ $siswa->nik ?? '-' }}</p>
                            </div>
                        </div>

                        <!-- School & Contact Information -->
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Kelas</label>
                                <p class="text-lg text-gray-900">{{ $siswa->kelas ?? '-' }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Tahun Ajaran</label>
                                <p class="text-lg text-gray-900">{{ $siswa->tahun_ajaran ?? '-' }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">No. Telepon</label>
                                <p class="text-lg text-gray-900">{{ $siswa->telepon ?? '-' }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Status</label>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                    {{ $siswa->status_siswa == 'aktif' ? 'bg-green-100 text-green-800' :
                                       ($siswa->status_siswa == 'pindah' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($siswa->status_siswa) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Info -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Tempat, Tanggal Lahir</label>
                                <p class="text-gray-900">
                                    {{ $siswa->tempat_lahir ?? '-' }},
                                    {{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->translatedFormat('d F Y') : '-' }}
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Alamat</label>
                                <p class="text-gray-900">{{ $siswa->alamat ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">
                            Terdaftar sejak {{ $user->created_at->translatedFormat('d F Y') }}
                        </span>
                        <a href="{{ route('siswa.profile.edit') }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                            <i class="fas fa-edit mr-2"></i>
                            Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Quick Actions & Stats -->
        <div class="space-y-6">
            <!-- Password Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center mb-4">
                    <div class="p-2 bg-red-100 rounded-lg mr-3">
                        <i class="fas fa-key text-red-600"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800">Keamanan</h3>
                </div>
                
                <p class="text-sm text-gray-600 mb-4">
                    Ubah password Anda secara berkala untuk menjaga keamanan akun
                </p>
                
                <a href="{{ route('siswa.profile.edit') }}#password-section" 
                   class="w-full bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded-lg flex items-center justify-center transition-colors">
                    <i class="fas fa-lock mr-2"></i>
                    Ganti Password
                </a>
            </div>

            <!-- Account Stats -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Statistik Akun</h3>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Transaksi Sukses</span>
                        <span class="font-semibold text-blue-600">
                            {{ $user->pembayaran->where('status', 'verified')->count() }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Tagihan Pending</span>
                        <span class="font-semibold text-orange-600">
                            {{ $user->tagihan->where('status', 'pending')->count() }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="bg-blue-50 rounded-lg border border-blue-200 p-6">
                <h3 class="text-lg font-semibold text-blue-800 mb-3">Akses Cepat</h3>
                
                <div class="space-y-2">
                    <a href="{{ route('siswa.dashboard') }}" 
                       class="flex items-center text-blue-700 hover:text-blue-800 transition-colors">
                        <i class="fas fa-tachometer-alt mr-2"></i>
                        Dashboard Utama
                    </a>
                    
                    <a href="{{ route('siswa.tagihan.index') }}" 
                       class="flex items-center text-blue-700 hover:text-blue-800 transition-colors">
                        <i class="fas fa-file-invoice mr-2"></i>
                        Lihat Tagihan
                    </a>
                    
                    <a href="{{ route('siswa.transaksi.index') }}" 
                       class="flex items-center text-blue-700 hover:text-blue-800 transition-colors">
                        <i class="fas fa-history mr-2"></i>
                        Riwayat Transaksi
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection