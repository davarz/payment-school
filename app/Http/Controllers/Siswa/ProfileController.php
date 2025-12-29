<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Siswa; // Tambahkan model Siswa
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
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

        // Ambil data siswa dari tabel siswa
        $siswa = Siswa::where('user_id', $user->id)->first();

        // Check if profile is incomplete
        $profileIncomplete = !$siswa || empty($siswa->nis) || empty($siswa->nik) || empty($siswa->kelas) || empty($siswa->tempat_lahir) || empty($siswa->tanggal_lahir);

        // Jika data siswa belum ada, redirect ke edit profile
        if (!$siswa) {
            return redirect()->route('siswa.profile.edit')
                ->with('info', 'Silakan lengkapi data siswa terlebih dahulu.');
        }

        return view('siswa.profile.show', compact('user', 'siswa', 'profileIncomplete'));
    }

    public function edit()
    {
        $user = Auth::user();

        if ($user->role !== 'siswa') {
            abort(403, 'Unauthorized action.');
        }

        // Ambil data siswa jika sudah ada
        $siswa = Siswa::where('user_id', $user->id)->first();

        // Check if profile is incomplete
        $profileIncomplete = !$siswa || empty($siswa->nis) || empty($siswa->nik) || empty($siswa->kelas) || empty($siswa->tempat_lahir) || empty($siswa->tanggal_lahir);

        return view('siswa.profile.edit', compact('user', 'siswa', 'profileIncomplete'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        if ($user->role !== 'siswa') {
            abort(403, 'Unauthorized action.');
        }

        // Validasi untuk data user
        $userValidated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        // Validasi untuk data siswa - sekarang semua field opsional untuk mendukung pelengkapan profil bertahap
        $siswaValidated = $request->validate([
            'telepon' => 'nullable|string|max:15',
            'telepon_wali' => 'nullable|string|max:15',
            'alamat' => 'nullable|string|max:500',
            'alamat_wali' => 'nullable|string|max:500',
            'tanggal_lahir' => 'nullable|date',
            'tempat_lahir' => 'nullable|string|max:255',
            'jenis_kelamin' => 'nullable|in:L,P',
            'nama_wali' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($user, $userValidated, $siswaValidated) {
            // Update data user
            $user->update($userValidated);

            // Update atau create data siswa
            Siswa::updateOrCreate(
                ['user_id' => $user->id],
                array_merge($siswaValidated, ['user_id' => $user->id])
            );
        });

        return redirect()->route('siswa.profile.show')
            ->with('success', 'Profile berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        
        // Validasi input
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Rules\Password::defaults(), 'min:8'],
        ], [
            'current_password.required' => 'Password saat ini harus diisi.',
            'current_password.current_password' => 'Password saat ini tidak valid.',
            'password.required' => 'Password baru harus diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        // Update password di database
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Redirect dengan sukses message
        return redirect()->route('siswa.profile.show')
            ->with('success', 'Password berhasil diubah!');
    }

    /**
     * Tampilkan riwayat pembayaran
     */
    public function riwayatPembayaran()
    {
        $user = Auth::user();

        if ($user->role !== 'siswa') {
            abort(403, 'Unauthorized action.');
        }

        // Ambil data siswa dari tabel siswa
        $siswa = Siswa::where('user_id', $user->id)->first();

        // Check if profile is incomplete
        $profileIncomplete = !$siswa || empty($siswa->nis) || empty($siswa->nik) || empty($siswa->kelas) || empty($siswa->tempat_lahir) || empty($siswa->tanggal_lahir);

        $pembayaran = Pembayaran::where('user_id', $user->id)
            ->with('kategori')
            ->latest()
            ->paginate(10);

        return view('siswa.profile.riwayat-pembayaran', compact('pembayaran', 'profileIncomplete'));
    }

    /**
     * Tampilkan riwayat tagihan
     */
    public function riwayatTagihan()
    {
        $user = Auth::user();

        if ($user->role !== 'siswa') {
            abort(403, 'Unauthorized action.');
        }

        // Ambil data siswa dari tabel siswa
        $siswa = Siswa::where('user_id', $user->id)->first();

        // Check if profile is incomplete
        $profileIncomplete = !$siswa || empty($siswa->nis) || empty($siswa->nik) || empty($siswa->kelas) || empty($siswa->tempat_lahir) || empty($siswa->tanggal_lahir);

        $tagihan = Tagihan::where('user_id', $user->id)
            ->with('kategori')
            ->latest()
            ->paginate(10);

        return view('siswa.profile.riwayat-tagihan', compact('tagihan', 'profileIncomplete'));
    }
}