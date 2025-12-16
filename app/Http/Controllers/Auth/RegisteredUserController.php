<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Siswa;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            // Validasi untuk tabel users
            $userValidated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

            // Validasi untuk tabel siswa
            $siswaValidated = $request->validate([
                'nis' => ['required', 'string', 'max:20', 'unique:siswa'],
                'nik' => ['required', 'string', 'max:16', 'unique:siswa'],
                'nisn' => ['nullable', 'string', 'max:10', 'unique:siswa'],
                'tahun_ajaran' => ['required', 'string'],
                'kelas' => ['required', 'string'],
                'jenis_kelamin' => ['required', 'in:L,P'],
                'tempat_lahir' => ['required', 'string', 'max:100'],
                'tanggal_lahir' => ['required', 'date'],
                'telepon' => ['required', 'string', 'max:15'],
                'alamat' => ['required', 'string', 'max:500'],
                'nama_wali' => ['nullable', 'string', 'max:255'],
                'telepon_wali' => ['nullable', 'string', 'max:15'],
                'alamat_wali' => ['nullable', 'string', 'max:500'],
            ]);

            // Create user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'siswa',
            ]);

            // Create siswa data
            Siswa::create(array_merge(
                $siswaValidated,
                [
                    'user_id' => $user->id,
                    'status_siswa' => 'aktif',
                ]
            ));

            event(new Registered($user));

            Auth::login($user);

            return redirect()->route('siswa.dashboard')
                ->with('success', 'Registrasi berhasil! Akun Anda telah aktif.');

        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan saat registrasi: ' . $e->getMessage()]);
        }
    }
}