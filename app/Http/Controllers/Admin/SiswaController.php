<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'siswa');

        // Search
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('nis', 'like', '%' . $request->search . '%');
            });
        }

        // Filter Status
        if ($request->has('status') && $request->status) {
            $query->where('status_siswa', $request->status);
        }

        // Filter Kelas
        if ($request->has('kelas') && $request->kelas) {
            $query->where('kelas', $request->kelas);
        }

        $siswa = $query->latest()->paginate(20);

        // Get unique kelas for filter dropdown
        $kelasList = User::where('role', 'siswa')
            ->distinct()
            ->pluck('kelas')
            ->filter()
            ->values();

        return view('admin.siswa.index', compact('siswa', 'kelasList'));
    }

    public function create()
    {
        return view('admin.siswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'nis' => 'required|unique:users',
            'nik' => 'required|unique:users',
            'tahun_ajaran' => 'required|string',
            'kelas' => 'required|string',
            'alamat' => 'required|string',
            'telepon' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'tempat_lahir' => 'required|string',
        ]);

        // Auto generate password dari nama + NIS
        $nama = strtolower(str_replace(' ', '', $request->name)); // Hilangkan spasi dan jadikan lowercase
        $nis = $request->nis;

        // Ambil 3 karakter pertama nama + 4 digit terakhir NIS
        $password = substr($nama, 0, 3) . substr($nis, -4);

        // Jika nama kurang dari 3 karakter, pakai full nama
        if (strlen($nama) < 3) {
            $password = $nama . substr($nis, -4);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($password),
            'nis' => $request->nis,
            'nik' => $request->nik,
            'tahun_ajaran' => $request->tahun_ajaran,
            'kelas' => $request->kelas,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
            'tanggal_lahir' => $request->tanggal_lahir,
            'tempat_lahir' => $request->tempat_lahir,
            'status_siswa' => 'aktif',
            'role' => 'siswa',
        ]);

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Siswa berhasil ditambahkan. Email: ' . $request->email . ' | Password: ' . $password);
    }

    public function edit(User $siswa)
    {
        return view('admin.siswa.edit', compact('siswa'));
    }

    public function update(Request $request, User $siswa)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $siswa->id,
            'nis' => 'required|unique:users,nis,' . $siswa->id,
            'nik' => 'required|unique:users,nik,' . $siswa->id,
            'tahun_ajaran' => 'required|string',
            'kelas' => 'required|string',
            'alamat' => 'required|string',
            'telepon' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'tempat_lahir' => 'required|string',
            'status_siswa' => 'required|in:aktif,pindah,dikeluarkan',
        ]);

        $siswa->update($request->all());

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil diperbarui');
    }



    public function destroy(User $siswa)
    {
        $siswa->delete();
        return redirect()->route('admin.siswa.index')
            ->with('success', 'Siswa berhasil dihapus');
    }

    public function resetPassword(User $siswa)
    {
        try {
            // 1. Generate unique reset token
            $token = Str::random(64);

            // 2. Delete existing tokens for this email
            DB::table('password_reset_tokens')->where('email', $siswa->email)->delete();

            // 3. Insert new token dengan hash
            DB::table('password_reset_tokens')->insert([
                'email' => $siswa->email,
                'token' => Hash::make($token),
                'created_at' => now()
            ]);

            // 4. Generate reset URL
            $resetUrl = route('password.reset', [
                'token' => $token,
                'email' => $siswa->email
            ]);

            // 5. Send professional notification
            $siswa->notify(new \App\Notifications\AdminTriggeredPasswordReset($resetUrl, $siswa->name));

            return redirect()->route('admin.siswa.index')
                ->with('success', '✅ Link reset password telah dikirim ke email: ' . $siswa->email);

        } catch (\Exception $e) {
            // Log error untuk debugging
            \Log::error('Password reset error for student ' . $siswa->id . ': ' . $e->getMessage());

            return redirect()->route('admin.siswa.index')
                ->with('error', '❌ Gagal mengirim link reset password. Silakan coba lagi.');
        }
    }

    //Test aja ini
    public function getJson(User $siswa)
    {
        // Pastikan hanya admin/operator yang bisa akses
        if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'operator') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json($siswa);
    }
}