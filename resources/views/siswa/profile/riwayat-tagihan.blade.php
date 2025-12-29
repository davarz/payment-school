@extends('layouts.app')

@section('title', 'Riwayat Tagihan')

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

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Riwayat Tagihan</h1>
        <p class="text-gray-600">Daftar tagihan yang telah Anda ajukan</p>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6">
            @if($tagihan->isEmpty())
                <div class="text-center py-12">
                    <i class="fas fa-file-invoice text-gray-400 text-5xl mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">Belum Ada Tagihan</h3>
                    <p class="text-gray-500">Tagihan Anda akan muncul di sini setelah Anda mengajukan tagihan</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Tagihan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Jatuh Tempo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($tagihan as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $item->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $item->kategori->nama_kategori ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    Rp {{ number_format($item->jumlah_tagihan, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $item->tanggal_jatuh_tempo->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ $item->status === 'paid' ? 'bg-green-100 text-green-800' :
                                           ($item->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ $item->status === 'paid' ? 'Lunas' :
                                           ($item->status === 'pending' ? 'Pending' : 'Belum Lunas') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <a href="{{ route('siswa.tagihan.show', $item->id) }}" 
                                       class="text-blue-600 hover:text-blue-900">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $tagihan->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection