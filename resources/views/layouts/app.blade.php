<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - SchoolPay</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <style>
        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #888; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #555; }
        
        /* Smooth transitions */
        * { @apply transition-colors duration-200; }
        
        /* Utility classes */
        .glass-effect {
            @apply bg-white/80 backdrop-blur-lg border border-white/20;
        }
        
        .gradient-primary {
            @apply bg-gradient-to-r from-blue-600 to-blue-700;
        }
        
        .gradient-success {
            @apply bg-gradient-to-r from-green-500 to-green-600;
        }
        
        .gradient-warning {
            @apply bg-gradient-to-r from-yellow-500 to-yellow-600;
        }
        
        .gradient-danger {
            @apply bg-gradient-to-r from-red-500 to-red-600;
        }
        
        .btn-base {
            @apply inline-flex items-center justify-center px-4 py-2 rounded-lg font-medium transition-all duration-200 whitespace-nowrap;
        }
        
        .btn-primary {
            @apply btn-base bg-blue-600 text-white hover:bg-blue-700 shadow-sm hover:shadow-md;
        }
        
        .btn-secondary {
            @apply btn-base bg-gray-200 text-gray-800 hover:bg-gray-300 shadow-sm;
        }
        
        .btn-danger {
            @apply btn-base bg-red-600 text-white hover:bg-red-700 shadow-sm hover:shadow-md;
        }
        
        .card {
            @apply bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow;
        }
        
        .card-header {
            @apply px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-indigo-50;
        }
        
        .card-body {
            @apply px-6 py-4;
        }
        
        .badge {
            @apply inline-flex items-center px-3 py-1 rounded-full text-sm font-medium;
        }
        
        .badge-success {
            @apply badge bg-green-100 text-green-800;
        }
        
        .badge-warning {
            @apply badge bg-yellow-100 text-yellow-800;
        }
        
        .badge-danger {
            @apply badge bg-red-100 text-red-800;
        }
        
        .badge-info {
            @apply badge bg-blue-100 text-blue-800;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-900 antialiased">
    <!-- Mobile Menu Backdrop -->
    <div id="menu-backdrop" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-30 hidden lg:hidden" onclick="toggleMobileMenu()"></div>

    @auth
        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'operator')
            @include('layouts.admin-sidebar')
            <div class="lg:ml-64 min-h-screen flex flex-col">
                @include('layouts.top-navbar')
                <main class="flex-1 overflow-y-auto">
                    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6 lg:py-8">
                        @yield('content')
                    </div>
                </main>
                @include('layouts.footer')
            </div>
        @else
            @include('layouts.siswa-navbar')
            <div class="pt-16 sm:pt-20 min-h-screen flex flex-col">
                <main class="flex-1 overflow-y-auto">
                    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6 lg:py-8">
                        @yield('content')
                    </div>
                </main>
                @include('layouts.footer')
            </div>
        @endif
    @endauth

    <!-- Toast Container -->
    <div id="toast-container" class="fixed bottom-6 right-6 z-50 space-y-3"></div>

    <!-- Scripts -->
    <script>
        function toggleMobileMenu() {
            const sidebar = document.getElementById('admin-sidebar');
            const backdrop = document.getElementById('menu-backdrop');
            
            if (sidebar) {
                sidebar.classList.toggle('-translate-x-full');
                backdrop.classList.toggle('hidden');
            }
        }

        function showToast(message, type = 'info') {
            const container = document.getElementById('toast-container');
            const colors = {
                'success': 'bg-green-500',
                'error': 'bg-red-500',
                'warning': 'bg-yellow-500',
                'info': 'bg-blue-500'
            };
            
            const toast = document.createElement('div');
            toast.className = `animate-slide-in ${colors[type]} text-white px-4 sm:px-6 py-3 sm:py-4 rounded-lg shadow-lg flex items-center justify-between max-w-xs`;
            toast.innerHTML = `
                <span>${message}</span>
                <button onclick="this.parentElement.remove()" class="ml-3 text-xl">&times;</button>
            `;
            
            container.appendChild(toast);
            setTimeout(() => toast.classList.add('animate-fade-out'), 3000);
            setTimeout(() => toast.remove(), 3500);
        }
    </script>

    @stack('scripts')
</body>
</html>