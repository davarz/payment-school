@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="space-y-8 pb-8">
    <!-- Page Header -->
    <div class="border-b border-gray-200 pb-6">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-4xl font-bold text-gray-900">Profil Saya</h1>
                <p class="text-gray-600 mt-2">Kelola informasi akun dan keamanan Anda</p>
            </div>
            <div class="text-blue-600 text-4xl">
                <i class="fas fa-user-circle"></i>
            </div>
        </div>
    </div>

    <!-- Profile Information Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 flex items-center">
            <i class="fas fa-user text-white text-2xl mr-4"></i>
            <div>
                <h2 class="text-xl font-bold text-white">Informasi Profil</h2>
                <p class="text-blue-100 text-sm mt-1">Perbarui data pribadi dan email Anda</p>
            </div>
        </div>
        <div class="p-6">
                <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                    @csrf
                </form>

                <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                    @csrf
                    @method('patch')

                    <!-- Name Field -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-3">Nama Lengkap</label>
                        <input 
                            id="name" 
                            name="name" 
                            type="text" 
                            value="{{ old('name', $user->name) }}" 
                            required 
                            autofocus 
                            autocomplete="name"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 text-gray-900 placeholder-gray-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                            placeholder="Nama lengkap Anda"
                        />
                        @if($errors->has('name'))
                            <p class="mt-2 text-sm text-red-600">{{ $errors->first('name') }}</p>
                        @endif
                    </div>

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-3">Alamat Email</label>
                        <input 
                            id="email" 
                            name="email" 
                            type="email" 
                            value="{{ old('email', $user->email) }}" 
                            required 
                            autocomplete="username"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 text-gray-900 placeholder-gray-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                            placeholder="email@sekolah.com"
                        />
                        @if($errors->has('email'))
                            <p class="mt-2 text-sm text-red-600">{{ $errors->first('email') }}</p>
                        @endif

                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                            <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                                <p class="text-sm text-yellow-800">
                                    Your email address is unverified.
                                    <button form="send-verification" type="submit" class="font-medium underline text-yellow-900 hover:text-yellow-700">
                                        Click here to re-send the verification email.
                                    </button>
                                </p>

                                @if (session('status') === 'verification-link-sent')
                                    <p class="mt-2 text-sm font-medium text-green-600">
                                        A new verification link has been sent to your email address.
                                    </p>
                                @endif
                            </div>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-center gap-3 pt-6">
                        <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg flex items-center gap-2 transition">
                            <i class="fas fa-check-circle"></i>
                            Simpan Perubahan
                        </button>

                        @if (session('status') === 'profile-updated')
                            <p class="text-sm text-green-600 font-semibold">✓ Profil berhasil diperbarui</p>
                        @endif
                    </div>
                </form>
        </div>
    </div>

    <!-- Password Update Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4 flex items-center">
            <i class="fas fa-lock text-white text-2xl mr-4"></i>
            <div>
                <h2 class="text-xl font-bold text-white">Ubah Password</h2>
                <p class="text-green-100 text-sm mt-1">Gunakan password yang kuat dan random untuk keamanan akun</p>
            </div>
        </div>
        <div class="p-6">
                <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                    @csrf
                    @method('put')

                    <!-- Current Password -->
                    <div>
                        <label for="update_password_current_password" class="block text-sm font-semibold text-gray-700 mb-3">Password Saat Ini</label>
                        <input 
                            id="update_password_current_password" 
                            name="current_password" 
                            type="password" 
                            autocomplete="current-password"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 text-gray-900 placeholder-gray-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                            placeholder="Masukkan password Anda sekarang"
                        />
                        @if($errors->updatePassword->has('current_password'))
                            <p class="mt-2 text-sm text-red-600">{{ $errors->updatePassword->first('current_password') }}</p>
                        @endif
                    </div>

                    <!-- New Password -->
                    <div>
                        <label for="update_password_password" class="block text-sm font-semibold text-gray-700 mb-3">Password Baru</label>
                        <input 
                            id="update_password_password" 
                            name="password" 
                            type="password" 
                            autocomplete="new-password"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 text-gray-900 placeholder-gray-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                            placeholder="Masukkan password baru Anda"
                        />
                        @if($errors->updatePassword->has('password'))
                            <p class="mt-2 text-sm text-red-600">{{ $errors->updatePassword->first('password') }}</p>
                        @endif
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="update_password_password_confirmation" class="block text-sm font-semibold text-gray-700 mb-3">Konfirmasi Password</label>
                        <input 
                            id="update_password_password_confirmation" 
                            name="password_confirmation" 
                            type="password" 
                            autocomplete="new-password"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 text-gray-900 placeholder-gray-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                            placeholder="Konfirmasi password baru Anda"
                        />
                        @if($errors->updatePassword->has('password_confirmation'))
                            <p class="mt-2 text-sm text-red-600">{{ $errors->updatePassword->first('password_confirmation') }}</p>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-center gap-3 pt-6">
                        <button type="submit" class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg flex items-center gap-2 transition">
                            <i class="fas fa-check-circle"></i>
                            Perbarui Password
                        </button>

                        @if (session('status') === 'password-updated')
                            <p class="text-sm text-green-600 font-semibold">✓ Password berhasil diperbarui</p>
                        @endif
                    </div>
                </form>
        </div>
    </div>

    <!-- Danger Zone -->
    <div class="bg-white rounded-xl shadow-sm border border-red-200 overflow-hidden">
        <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4 flex items-center">
            <i class="fas fa-trash-alt text-white text-2xl mr-4"></i>
            <div>
                <h2 class="text-xl font-bold text-white">Zona Berbahaya</h2>
                <p class="text-red-100 text-sm mt-1">Aksi yang tidak dapat dibatalkan</p>
            </div>
        </div>
        <div class="p-6">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>
@endsection
