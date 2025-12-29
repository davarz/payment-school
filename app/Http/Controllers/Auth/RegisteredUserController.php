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

            // Validasi untuk tabel siswa (hanya field yang diperlukan saat registrasi)
            $siswaValidated = $request->validate([
                'nis' => ['nullable', 'string', 'max:20', 'unique:siswa'],
                'nik' => ['nullable', 'string', 'max:16', 'unique:siswa'],
                'nisn' => ['nullable', 'string', 'max:10', 'unique:siswa'],
                'tahun_ajaran' => ['nullable', 'string'],
                'kelas' => ['nullable', 'string'],
                'jenis_kelamin' => ['nullable', 'in:L,P'],
                'tempat_lahir' => ['nullable', 'string', 'max:100'],
                'tanggal_lahir' => ['nullable', 'date'],
                'telepon' => ['nullable', 'string', 'max:15'],
                'alamat' => ['nullable', 'string', 'max:500'],
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

            // Check if any student data was provided
            $hasStudentData = false;
            foreach ($siswaValidated as $value) {
                if (!empty($value)) {
                    $hasStudentData = true;
                    break;
                }
            }

            // Create siswa data only if any student data was provided, otherwise create with minimal data
            if ($hasStudentData) {
                Siswa::create(array_merge(
                    $siswaValidated,
                    [
                        'user_id' => $user->id,
                        'status_siswa' => 'aktif',
                    ]
                ));
            } else {
                // Create with minimal required data
                Siswa::create([
                    'user_id' => $user->id,
                    'status_siswa' => 'aktif',
                    'nis' => null,
                    'nik' => null,
                    'nisn' => null,
                    'tahun_ajaran' => null,
                    'kelas' => null,
                    'jenis_kelamin' => null,
                    'tempat_lahir' => null,
                    'tanggal_lahir' => null,
                    'telepon' => null,
                    'alamat' => null,
                    'nama_wali' => null,
                    'telepon_wali' => null,
                    'alamat_wali' => null,
                ]);
            }

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