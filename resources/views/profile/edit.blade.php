@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="min-h-screen bg-gray-50 py-6 lg:py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-6 lg:mb-8">
            <h1 class="text-3xl lg:text-4xl font-bold text-gray-900">Edit Profile</h1>
            <p class="mt-1 text-sm lg:text-base text-gray-600">Manage your account settings and preferences</p>
        </div>

        <!-- Profile Information Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
            <div class="px-6 py-4 lg:px-8 lg:py-6 border-b border-gray-100">
                <h2 class="text-xl lg:text-2xl font-bold text-gray-900">Profile Information</h2>
                <p class="mt-1 text-sm text-gray-600">Update your account's profile information and email address.</p>
            </div>
            <div class="px-6 py-6 lg:px-8 lg:py-8">
                <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                    @csrf
                </form>

                <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                    @csrf
                    @method('patch')

                    <!-- Name Field -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                        <input 
                            id="name" 
                            name="name" 
                            type="text" 
                            value="{{ old('name', $user->name) }}" 
                            required 
                            autofocus 
                            autocomplete="name"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 text-gray-900 placeholder-gray-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                            placeholder="Full Name"
                        />
                        @if($errors->has('name'))
                            <p class="mt-2 text-sm text-red-600">{{ $errors->first('name') }}</p>
                        @endif
                    </div>

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                        <input 
                            id="email" 
                            name="email" 
                            type="email" 
                            value="{{ old('email', $user->email) }}" 
                            required 
                            autocomplete="username"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 text-gray-900 placeholder-gray-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                            placeholder="email@example.com"
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
                    <div class="flex items-center gap-3 pt-4">
                        <button type="submit" class="px-4 lg:px-6 py-2.5 lg:py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                            Save Changes
                        </button>

                        @if (session('status') === 'profile-updated')
                            <p class="text-sm text-green-600 font-medium">✓ Profile updated successfully</p>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Password Update Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
            <div class="px-6 py-4 lg:px-8 lg:py-6 border-b border-gray-100">
                <h2 class="text-xl lg:text-2xl font-bold text-gray-900">Update Password</h2>
                <p class="mt-1 text-sm text-gray-600">Ensure your account is using a long, random password to stay secure.</p>
            </div>
            <div class="px-6 py-6 lg:px-8 lg:py-8">
                <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                    @csrf
                    @method('put')

                    <!-- Current Password -->
                    <div>
                        <label for="update_password_current_password" class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
                        <input 
                            id="update_password_current_password" 
                            name="current_password" 
                            type="password" 
                            autocomplete="current-password"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 text-gray-900 placeholder-gray-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                            placeholder="Enter your current password"
                        />
                        @if($errors->updatePassword->has('current_password'))
                            <p class="mt-2 text-sm text-red-600">{{ $errors->updatePassword->first('current_password') }}</p>
                        @endif
                    </div>

                    <!-- New Password -->
                    <div>
                        <label for="update_password_password" class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                        <input 
                            id="update_password_password" 
                            name="password" 
                            type="password" 
                            autocomplete="new-password"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 text-gray-900 placeholder-gray-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                            placeholder="Enter your new password"
                        />
                        @if($errors->updatePassword->has('password'))
                            <p class="mt-2 text-sm text-red-600">{{ $errors->updatePassword->first('password') }}</p>
                        @endif
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="update_password_password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                        <input 
                            id="update_password_password_confirmation" 
                            name="password_confirmation" 
                            type="password" 
                            autocomplete="new-password"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 text-gray-900 placeholder-gray-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                            placeholder="Confirm your new password"
                        />
                        @if($errors->updatePassword->has('password_confirmation'))
                            <p class="mt-2 text-sm text-red-600">{{ $errors->updatePassword->first('password_confirmation') }}</p>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-center gap-3 pt-4">
                        <button type="submit" class="px-4 lg:px-6 py-2.5 lg:py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                            Update Password
                        </button>

                        @if (session('status') === 'password-updated')
                            <p class="text-sm text-green-600 font-medium">✓ Password updated successfully</p>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Danger Zone -->
        <div class="bg-white rounded-xl shadow-sm border border-red-100 overflow-hidden">
            <div class="px-6 py-4 lg:px-8 lg:py-6 border-b border-red-100 bg-red-50">
                <h2 class="text-xl lg:text-2xl font-bold text-red-900">Danger Zone</h2>
                <p class="mt-1 text-sm text-red-700">Irreversible actions</p>
            </div>
            <div class="px-6 py-6 lg:px-8 lg:py-8">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</div>
@endsection
