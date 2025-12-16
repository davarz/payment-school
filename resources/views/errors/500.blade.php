<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Server Error</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full text-center p-8">
        <div class="mb-8">
            <div class="mx-auto h-24 w-24 bg-red-100 rounded-full flex items-center justify-center mb-6">
                <i class="fas fa-exclamation-triangle text-red-600 text-4xl"></i>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 mb-4">500</h1>
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Terjadi Kesalahan Server</h2>
            <p class="text-gray-600 mb-8">
                Maaf, terjadi kesalahan pada server kami. Tim kami telah diberitahu dan sedang memperbaikinya.
            </p>
        </div>
        
        <div class="space-y-4">
            <a href="/" 
               class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-150 font-medium">
                <i class="fas fa-home mr-2"></i>
                Kembali ke Beranda
            </a>
            
            <button onclick="window.location.reload()" 
                    class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-150 font-medium ml-4">
                <i class="fas fa-redo mr-2"></i>
                Muat Ulang Halaman
            </button>
        </div>
        
        <div class="mt-8 text-sm text-gray-500">
            <p>Jika masalah berlanjut, silakan hubungi administrator.</p>
        </div>
    </div>
</body>
</html>