<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;


class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        
        // Pastikan hanya siswa yang bisa akses
        if ($user->role !== 'siswa') {
            abort(403, 'Unauthorized action.');
        }
        
        return view('siswa.profile.show', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        
        if ($user->role !== 'siswa') {
            abort(403, 'Unauthorized action.');
        }
        
        return view('siswa.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        if ($user->role !== 'siswa') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'telepon' => 'required|string|max:15',
            'alamat' => 'required|string|max:500',
            'tanggal_lahir' => 'required|date',
            'tempat_lahir' => 'required|string|max:255',
        ]);

        $user->update($request->only([
            'name', 'email', 'telepon', 'alamat', 
            'tanggal_lahir', 'tempat_lahir'
        ]));

        return redirect()->route('siswa.profile.show')
            ->with('success', 'Profile berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        
        // 1. VALIDASI INPUT
        $request->validate([
            'current_password' => ['required', 'current_password'], // Password lama harus benar
            'password' => ['required', 'confirmed', Rules\Password::defaults(), 'min:8'],
        ], [
            'current_password.required' => 'Password saat ini harus diisi.',
            'current_password.current_password' => 'Password saat ini tidak valid.',
            'password.required' => 'Password baru harus diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        // 2. UPDATE PASSWORD DI DATABASE
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // 3. REDIRECT DENGAN SUKSES MESSAGE
        return redirect()->route('siswa.profile.show')
            ->with('success', 'Password berhasil diubah!');
    }
}