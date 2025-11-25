<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - School Payment System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @auth
        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'operator')
            @include('layouts.admin-sidebar')
        @else
            @include('layouts.siswa-navbar')
        @endif
    @endauth

    <main class="@auth @if(auth()->user()->role === 'admin' || auth()->user()->role === 'operator') ml-64 @endif @endauth">
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>