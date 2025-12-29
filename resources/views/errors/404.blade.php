<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-blue-50 via-purple-50 to-pink-50 min-h-screen flex items-center justify-center px-4">
    <div class="max-w-2xl w-full">
        <!-- Error Card -->
        <div class="bg-white rounded-xl shadow-xl border border-gray-200 overflow-hidden">
            <!-- Header dengan Gradient -->
            <div class="relative overflow-hidden bg-gradient-to-r from-blue-500 via-purple-600 to-pink-600 p-12">
                <div class="absolute inset-0 opacity-10">
                    <i class="fas fa-question-circle absolute top-4 right-4 text-6xl"></i>
                </div>
                <div class="relative flex flex-col items-center justify-center">
                    <div class="text-white text-8xl font-black mb-4">404</div>
                    <h1 class="text-3xl font-bold text-white text-center">Halaman Tidak Ditemukan</h1>
                </div>
            </div>

            <!-- Content -->
            <div class="p-8">
                <!-- Alert Box -->
                <div class="mb-8 p-6 bg-blue-50 border-l-4 border-blue-500 rounded">
                    <div class="flex items-start space-x-4">
                        <i class="fas fa-info-circle text-blue-600 text-2xl mt-1"></i>
                        <div>
                            <h2 class="font-semibold text-blue-900 mb-2">Halaman Tidak Tersedia</h2>
                            <p class="text-blue-800">
                                Halaman yang Anda cari tidak ada atau mungkin telah dipindahkan. Silakan periksa kembali URL atau navigasi kembali ke menu utama.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Status Info -->
                <div class="mb-8 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <p class="text-sm text-gray-600"><strong>Status:</strong></p>
                        <p class="text-lg font-semibold text-blue-600">Halaman Tidak Ditemukan (404)</p>
                    </div>
                    <div class="p-4 bg-purple-50 rounded-lg border border-purple-200">
                        <p class="text-sm text-gray-600"><strong>URL:</strong></p>
                        <p class="text-lg font-semibold text-gray-900 truncate">{{ request()->path() }}</p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="space-y-3">
                    <a href="/" class="block w-full px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-lg hover:shadow-lg transition text-center">
                        <i class="fas fa-home mr-2"></i>
                        Kembali ke Beranda
                    </a>
                    
                    <a href="/admin" class="block w-full px-6 py-3 bg-gradient-to-r from-purple-600 to-purple-700 text-white font-semibold rounded-lg hover:shadow-lg transition text-center">
                        <i class="fas fa-tachometer-alt mr-2"></i>
                        Ke Dashboard
                    </a>
                    
                    <a href="javascript:history.back()" class="block w-full px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition text-center">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Halaman Sebelumnya
                    </a>
                </div>

                <!-- Help Section -->
                <div class="mt-8 p-6 bg-gray-50 rounded-lg border border-gray-200">
                    <h3 class="font-semibold text-gray-900 mb-3">
                        <i class="fas fa-lightbulb text-yellow-500 mr-2"></i>
                        Saran
                    </h3>
                    <ul class="space-y-2 text-sm text-gray-700">
                        <li class="flex items-start space-x-2">
                            <i class="fas fa-check text-green-500 mt-1 flex-shrink-0"></i>
                            <span>Periksa URL yang Anda masukkan</span>
                        </li>
                        <li class="flex items-start space-x-2">
                            <i class="fas fa-check text-green-500 mt-1 flex-shrink-0"></i>
                            <span>Gunakan menu navigasi untuk menemukan yang Anda cari</span>
                        </li>
                        <li class="flex items-start space-x-2">
                            <i class="fas fa-check text-green-500 mt-1 flex-shrink-0"></i>
                            <span>Jika Anda yakin ini adalah bug, hubungi administrator</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Footer -->
            <div class="px-8 py-4 bg-gray-50 border-t border-gray-200">
                <p class="text-center text-xs text-gray-600">
                    © {{ date('Y') }} {{ config('app.name', 'Payment School') }}. Semua hak dilindungi.
                </p>
            </div>
        </div>

        <!-- Support Info -->
        <div class="text-center mt-6">
            <p class="text-gray-600">
                <i class="fas fa-envelope text-blue-500 mr-2"></i>
                Butuh bantuan? Hubungi <a href="mailto:support@example.com" class="text-blue-600 hover:underline font-semibold">support</a>
            </p>
        </div>
    </div>
</body>
</html>
