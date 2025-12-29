<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debug - Developer Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-purple-900 via-gray-900 to-black min-h-screen flex items-center justify-center px-4 py-8">
    <div class="max-w-4xl w-full">
        <!-- Developer Debug Card -->
        <div class="bg-gray-900 rounded-xl shadow-2xl border border-purple-600 overflow-hidden">
            <!-- Header dengan Gradient -->
            <div class="relative overflow-hidden bg-gradient-to-r from-purple-600 via-purple-700 to-black p-8">
                <div class="absolute inset-0 opacity-10">
                    <i class="fas fa-bug absolute top-4 right-4 text-6xl"></i>
                </div>
                <div class="relative flex flex-col items-center justify-center">
                    <div class="text-purple-400 text-6xl font-black mb-3">
                        <i class="fas fa-terminal"></i>
                    </div>
                    <h1 class="text-3xl font-bold text-white text-center">Developer Debug Panel</h1>
                    <p class="text-purple-300 mt-2 text-sm">Informasi Debug untuk Developer</p>
                </div>
            </div>

            <!-- Content -->
            <div class="p-8 space-y-6">
                <!-- Alert Box - Warning untuk Dev -->
                <div class="p-4 bg-yellow-900 border-l-4 border-yellow-400 rounded flex items-start space-x-3">
                    <i class="fas fa-exclamation text-yellow-400 text-xl mt-1 flex-shrink-0"></i>
                    <p class="text-yellow-100 text-sm">
                        <strong>⚠️ DEVELOPMENT ONLY:</strong> Halaman ini hanya untuk developer. Jangan tampilkan ke user akhir.
                    </p>
                </div>

                <!-- Error Message Section -->
                <div class="space-y-3">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                        Error Message
                    </h2>
                    <div class="bg-gray-800 p-4 rounded-lg border border-gray-700 overflow-auto">
                        <code class="text-red-400 text-sm font-mono break-words block">{{ $error->getMessage() }}</code>
                    </div>
                </div>

                <!-- File & Line Section -->
                <div class="space-y-3">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-file-code text-green-400 mr-3"></i>
                        File & Line Information
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gray-800 p-4 rounded-lg border border-gray-700">
                            <p class="text-gray-400 text-xs font-semibold mb-2 flex items-center">
                                <i class="fas fa-file-alt mr-2"></i>FILE
                            </p>
                            <code class="text-green-400 text-xs font-mono break-all block">{{ $error->getFile() }}</code>
                        </div>
                        <div class="bg-gray-800 p-4 rounded-lg border border-gray-700">
                            <p class="text-gray-400 text-xs font-semibold mb-2 flex items-center">
                                <i class="fas fa-list-ol mr-2"></i>LINE
                            </p>
                            <code class="text-blue-400 text-xs font-mono block text-2xl font-bold">{{ $error->getLine() }}</code>
                        </div>
                    </div>
                </div>

                <!-- Stack Trace Section -->
                <div class="space-y-3">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-layer-group text-purple-400 mr-3"></i>
                        Stack Trace
                    </h2>
                    <div class="bg-gray-950 p-4 rounded-lg border border-gray-700 overflow-auto max-h-96 scrollbar-thin scrollbar-thumb-gray-700 scrollbar-track-gray-900">
                        <pre class="text-cyan-400 text-xs font-mono whitespace-pre-wrap">{{ $error->getTraceAsString() }}</pre>
                    </div>
                </div>

                <!-- Environment Information -->
                <div class="space-y-3">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-sliders-h text-blue-400 mr-3"></i>
                        Environment Information
                    </h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-gray-800 p-3 rounded-lg border border-gray-700">
                            <p class="text-gray-400 text-xs font-semibold mb-1">Environment</p>
                            <code class="text-yellow-400 text-xs font-mono">{{ app()->environment() }}</code>
                        </div>
                        <div class="bg-gray-800 p-3 rounded-lg border border-gray-700">
                            <p class="text-gray-400 text-xs font-semibold mb-1">Time</p>
                            <code class="text-orange-400 text-xs font-mono">{{ date('H:i:s') }}</code>
                        </div>
                        <div class="bg-gray-800 p-3 rounded-lg border border-gray-700">
                            <p class="text-gray-400 text-xs font-semibold mb-1">Date</p>
                            <code class="text-orange-400 text-xs font-mono">{{ date('Y-m-d') }}</code>
                        </div>
                        <div class="bg-gray-800 p-3 rounded-lg border border-gray-700">
                            <p class="text-gray-400 text-xs font-semibold mb-1">App Name</p>
                            <code class="text-pink-400 text-xs font-mono">{{ config('app.name') }}</code>
                        </div>
                    </div>
                </div>

                <!-- Error Type Section -->
                <div class="space-y-3">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-tag text-indigo-400 mr-3"></i>
                        Error Details
                    </h2>
                    <div class="bg-gray-800 p-4 rounded-lg border border-gray-700">
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            <div>
                                <p class="text-gray-400 text-xs font-semibold mb-1">Error Class</p>
                                <code class="text-violet-400 text-xs font-mono block break-all">{{ get_class($error) }}</code>
                            </div>
                            <div>
                                <p class="text-gray-400 text-xs font-semibold mb-1">Code</p>
                                <code class="text-red-400 text-xs font-mono">{{ $error->getCode() }}</code>
                            </div>
                            <div>
                                <p class="text-gray-400 text-xs font-semibold mb-1">Status</p>
                                <code class="text-green-400 text-xs font-mono">Error</code>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Debug Tip -->
                <div class="p-4 bg-gradient-to-r from-purple-900 to-indigo-900 border border-purple-500 rounded-lg">
                    <h3 class="text-purple-200 font-semibold mb-2 flex items-center">
                        <i class="fas fa-lightbulb text-yellow-400 mr-2"></i>
                        Debug Tips:
                    </h3>
                    <ul class="space-y-1 text-purple-100 text-sm">
                        <li><strong>1.</strong> Periksa File & Line untuk menemukan lokasi error</li>
                        <li><strong>2.</strong> Baca Stack Trace dari atas ke bawah untuk memahami alur error</li>
                        <li><strong>3.</strong> Cek Environment untuk memastikan config yang benar</li>
                        <li><strong>4.</strong> Log aplikasi untuk info lebih detail: <code class="text-yellow-300">storage/logs/</code></li>
                    </ul>
                </div>
            </div>

            <!-- Footer -->
            <div class="px-8 py-4 bg-gray-950 border-t border-gray-700">
                <p class="text-center text-xs text-gray-500 flex items-center justify-center space-x-2">
                    <i class="fas fa-lock text-purple-500"></i>
                    <span>Developer Debug Panel - Akses Terbatas</span>
                </p>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="/" class="block p-4 bg-gray-800 border border-gray-700 rounded-lg hover:border-blue-500 transition text-center">
                <i class="fas fa-home text-blue-400 text-xl mb-2 block"></i>
                <span class="text-gray-300 text-sm font-semibold">Home</span>
            </a>
            <a href="/admin" class="block p-4 bg-gray-800 border border-gray-700 rounded-lg hover:border-purple-500 transition text-center">
                <i class="fas fa-tachometer-alt text-purple-400 text-xl mb-2 block"></i>
                <span class="text-gray-300 text-sm font-semibold">Dashboard</span>
            </a>
            <button onclick="window.location.reload()" class="block p-4 bg-gray-800 border border-gray-700 rounded-lg hover:border-green-500 transition text-center">
                <i class="fas fa-redo text-green-400 text-xl mb-2 block"></i>
                <span class="text-gray-300 text-sm font-semibold">Refresh</span>
            </button>
            <button onclick="window.history.back()" class="block p-4 bg-gray-800 border border-gray-700 rounded-lg hover:border-yellow-500 transition text-center">
                <i class="fas fa-arrow-left text-yellow-400 text-xl mb-2 block"></i>
                <span class="text-gray-300 text-sm font-semibold">Back</span>
            </button>
        </div>
    </div>

    <style>
        .scrollbar-thin::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        .scrollbar-thin::-webkit-scrollbar-track {
            background: transparent;
        }
        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: #4B5563;
            border-radius: 3px;
        }
        .scrollbar-thin::-webkit-scrollbar-thumb:hover {
            background: #6B7583;
        }
    </style>
</body>
</html>
