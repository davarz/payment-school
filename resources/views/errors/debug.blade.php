<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oops! Terjadi Kesalahan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen flex items-center justify-center p-5">
    <div class="w-full max-w-2xl">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden animate-in slide-in-from-bottom-4 duration-500">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-8 md:py-10 text-center">
                <h1 class="text-white text-2xl md:text-3xl font-bold mb-2 flex items-center justify-center gap-3">
                    <i class="fas fa-exclamation-circle text-2xl"></i>
                    Terjadi Kesalahan
                </h1>
                <p class="text-blue-100 text-sm md:text-base">Waduh ada Error nih!</p>
            </div>

            <!-- Body -->
            <div class="p-6 md:p-8">
    <div class="flex items-start gap-3 rounded-lg border border-red-200 bg-red-50 p-4">
        <svg class="h-5 w-5 text-red-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
            <path fill-rule="evenodd" d="M18 10A8 8 0 11 2 10a8 8 0 0116 0zm-8-4a1 1 0 00-1 1v3a1 1 0 002 0V7a1 1 0 00-1-1zm0 7a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" clip-rule="evenodd"/>
        </svg>

        <p class="text-sm font-medium text-red-700">
            {{ $error->getMessage() }}
        </p>
    </div>
</div>

            <!-- Footer -->
            <div class="bg-gray-50 px-6 py-3 md:py-4 border-t border-gray-200 flex items-center justify-between flex-wrap gap-3">
                <p class="text-gray-600 text-xs">
                    {{ config('app.name', 'Payment School') }} © {{ date('Y') }}
                </p>
                <a href="javascript:void(0)" 
                   onclick="location.href = location.pathname.replace('/debug', '/debug-dev')"
                   title="Developer Debug Panel"
                   class="text-gray-600 hover:text-blue-600 text-xs transition-colors flex items-center gap-1.5 px-3 py-1.5 rounded hover:bg-blue-50">
                    <i class="fas fa-bug"></i>
                    <span>Dev</span>
                </a>
            </div>
        </div>
    </div>
</body>
</html>