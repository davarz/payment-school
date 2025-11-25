<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - School Payment System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-50 min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-lg p-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="mx-auto h-16 w-16 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-key text-blue-600 text-2xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-900">Lupa Password?</h2>
            <p class="mt-2 text-sm text-gray-600">
                Masukkan email Anda, kami akan mengirim link reset password
            </p>
        </div>

        

        <!-- Status Message -->
        @if (session('status'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                <div class="flex items-center">
                    @if (str_contains(session('status'), 'baru'))
                        <i class="fas fa-sync text-green-500 mr-3"></i>
                    @else
                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                    @endif
                    <span class="text-green-700 text-sm">{{ session('status') }}</span>
                </div>
            </div>
        @endif

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>
                    <span class="text-red-700 text-sm">
                        {{ $errors->first() }}
                    </span>
                </div>
            </div>
        @endif

        <!-- Form -->
        <form class="space-y-6" action="{{ route('password.email') }}" method="POST">
            @csrf

            <!-- Email Field -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                    Alamat Email
                </label>
                <div class="relative">
                    <input id="email" name="email" type="email" required
                        class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-lg placeholder-gray-400 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out"
                        placeholder="contoh: budi@school.com" value="{{ old('email') }}">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <i class="fas fa-envelope text-gray-400"></i>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit"
                    class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <i class="fas fa-paper-plane text-blue-300"></i>
                    </span>
                    Kirim Link Reset Password
                </button>
            </div>
        </form>

        <!-- Back to Login -->
        <div class="mt-6 text-center">
            <a href="{{ route('login') }}"
                class="text-sm text-blue-600 hover:text-blue-500 flex items-center justify-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke halaman login
            </a>
        </div>

        <!-- Tambah setelah form -->
        <div class="mt-6 p-4 bg-blue-50 rounded-lg">
            <div class="flex items-start">
                <i class="fas fa-info-circle text-blue-500 mt-1 mr-3"></i>
                <div>
                    <h4 class="text-sm font-medium text-blue-800">Info Reset Password :</h4>
                    <ul class="text-xs text-blue-700 mt-1 space-y-1">
                        <li>• Link reset password berlaku <strong>1 jam</strong></li>
                        <li>• Hanya <strong>1 link aktif</strong> per email</li>
                        <li>• Jika sudah request sebelumnya, gunakan link yang sudah dikirim</li>
                        <li>• Cek folder <strong>spam/promosi</strong> jika tidak menemukan email</li>
                    </ul>
                </div>
            </div>
        </div>



        <!-- Info
        <div class="mt-6 p-4 bg-blue-50 rounded-lg">
            <div class="flex items-start">
                <i class="fas fa-info-circle text-blue-500 mt-1 mr-3"></i>
                <div>
                    <p class="text-sm text-blue-700">
                        <strong>Perhatian:</strong> Link reset password akan dikirim ke email Anda dan berlaku selama 60
                        menit.
                    </p>
                    <p class="text-xs text-blue-600 mt-1">
                        Jika tidak menerima email, cek folder spam atau hubungi administrator.
                    </p>
                </div>
            </div>
        </div> -->
    </div>
</body>

</html>