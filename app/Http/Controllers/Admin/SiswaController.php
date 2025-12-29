<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Siswa; // Tambahkan model Siswa
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = Siswa::with('user'); // Query dari tabel siswa

        // Search
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nis', 'like', '%' . $request->search . '%')
                  ->orWhere('nisn', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function ($userQuery) use ($request) {
                      $userQuery->where('name', 'like', '%' . $request->search . '%')
                               ->orWhere('email', 'like', '%' . $request->search . '%');
                  });
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

        // Filter Tahun Ajaran
        if ($request->has('tahun_ajaran') && $request->tahun_ajaran) {
            $query->where('tahun_ajaran', $request->tahun_ajaran);
        }

        $siswa = $query->latest()->paginate(20);

        // Get unique kelas for filter dropdown
        $kelasList = Siswa::distinct()->pluck('kelas')->filter()->values();
        $tahunAjaranList = Siswa::distinct()->pluck('tahun_ajaran')->filter()->values();

        return view('admin.siswa.index', compact('siswa', 'kelasList', 'tahunAjaranList'));
    }

    public function create()
    {
        return view('admin.siswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nis' => 'required|unique:siswa,nis',
            'nik' => 'required|unique:siswa,nik',
            'nisn' => 'nullable|unique:siswa,nisn',
            'tahun_ajaran' => 'required|string',
            'kelas' => 'required|string',
            'alamat' => 'required|string',
            'telepon' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'tempat_lahir' => 'required|string',
            'jenis_kelamin' => 'required|in:L,P',
            'nama_wali' => 'required|string',
            'telepon_wali' => 'required|string',
            'alamat_wali' => 'required|string',
        ], [
            'email.unique' => 'Email ini sudah terdaftar di sistem. Silahkan gunakan email lain.',
            'nis.unique' => 'NIS ini sudah terdaftar. Silahkan periksa kembali nomor NIS.',
            'nik.unique' => 'NIK ini sudah terdaftar. Silahkan periksa kembali nomor NIK.',
            'nisn.unique' => 'NISN ini sudah terdaftar. Silahkan gunakan NISN yang lain.',
            'name.required' => 'Nama lengkap harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'nis.required' => 'NIS harus diisi.',
            'nik.required' => 'NIK harus diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir harus diisi.',
            'tanggal_lahir.date' => 'Format tanggal lahir tidak valid.',
            'tempat_lahir.required' => 'Tempat lahir harus diisi.',
            'alamat.required' => 'Alamat harus diisi.',
            'telepon.required' => 'Nomor telepon harus diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin harus dipilih.',
            'kelas.required' => 'Kelas harus dipilih.',
            'tahun_ajaran.required' => 'Tahun ajaran harus diisi.',
            'nama_wali.required' => 'Nama wali/orang tua harus diisi.',
            'telepon_wali.required' => 'Nomor telepon wali/orang tua harus diisi.',
            'alamat_wali.required' => 'Alamat wali/orang tua harus diisi.',
        ]);

        // Generate password from 3 first letters of name + last 4 digits of NIS
        // Example: Name "Dava" + NIS "2010809" = Password "dav0809"
        $nama = strtolower(str_replace(' ', '', $request->name));
        $nis = $request->nis;
        $password = substr($nama, 0, 3) . substr($nis, -4);
        
        if (strlen($nama) < 3) {
            $password = $nama . substr($nis, -4);
        }

        DB::transaction(function () use ($request, $password) {
            // 1. Create User
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($password),
                'role' => 'siswa',
            ]);

            // 2. Create Siswa
            Siswa::create([
                'user_id' => $user->id,
                'nis' => $request->nis,
                'nik' => $request->nik,
                'nisn' => $request->nisn,
                'tahun_ajaran' => $request->tahun_ajaran,
                'kelas' => $request->kelas,
                'alamat' => $request->alamat,
                'telepon' => $request->telepon,
                'tanggal_lahir' => $request->tanggal_lahir,
                'tempat_lahir' => $request->tempat_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'nama_wali' => $request->nama_wali,
                'telepon_wali' => $request->telepon_wali,
                'alamat_wali' => $request->alamat_wali,
                'status_siswa' => 'aktif',
            ]);
        });

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Siswa berhasil ditambahkan. Email: ' . $request->email . ' | Password: ' . $password);
    }

    public function show(Siswa $siswa)
    {
        $siswa->load('user');
        return view('admin.siswa.show', compact('siswa'));
    }

    public function checkEmail(Request $request)
    {
        $email = $request->query('email');
        $currentId = $request->query('current_id'); // ID user saat ini (untuk update)

        if (!$email) {
            return response()->json(['available' => true]);
        }

        $query = User::where('email', $email);

        // Jika ada current_id, exclude dari pengecekan (untuk update)
        if ($currentId) {
            $query->where('id', '!=', $currentId);
        }

        $exists = $query->exists();

        return response()->json([
            'available' => !$exists,
            'email' => $email,
        ]);
    }

    public function edit(Siswa $siswa)
    {
        $siswa->load('user');
        return view('admin.siswa.edit', compact('siswa'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $siswa->user_id,
            'nis' => 'required|unique:siswa,nis,' . $siswa->id,
            'nik' => 'required|unique:siswa,nik,' . $siswa->id,
            'nisn' => 'nullable|unique:siswa,nisn,' . $siswa->id,
            'tahun_ajaran' => 'required|string',
            'kelas' => 'required|string',
            'alamat' => 'required|string',
            'telepon' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'tempat_lahir' => 'required|string',
            'jenis_kelamin' => 'required|in:L,P',
            'status_siswa' => 'required|in:aktif,pindah,dikeluarkan,lulus',
            'nama_wali' => 'required|string',
            'telepon_wali' => 'required|string',
            'alamat_wali' => 'required|string',
        ]);

        DB::transaction(function () use ($request, $siswa) {
            // 1. Update User
            $siswa->user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            // 2. Update Siswa
            $siswa->update([
                'nis' => $request->nis,
                'nik' => $request->nik,
                'nisn' => $request->nisn,
                'tahun_ajaran' => $request->tahun_ajaran,
                'kelas' => $request->kelas,
                'alamat' => $request->alamat,
                'telepon' => $request->telepon,
                'tanggal_lahir' => $request->tanggal_lahir,
                'tempat_lahir' => $request->tempat_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'status_siswa' => $request->status_siswa,
                'nama_wali' => $request->nama_wali,
                'telepon_wali' => $request->telepon_wali,
                'alamat_wali' => $request->alamat_wali,
            ]);
        });

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil diperbarui');
    }

    public function destroy(Siswa $siswa)
    {
        DB::transaction(function () use ($siswa) {
            // Hapus data siswa terlebih dahulu
            $siswa->delete();
            
            // Hapus user jika ingin (opsional)
            // $siswa->user->delete();
        });

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Siswa berhasil dihapus');
    }

    public function resetPassword(Siswa $siswa)
    {
        try {
            $user = $siswa->user;
            
            // 1. Generate unique reset token
            $token = Str::random(64);

            // 2. Delete existing tokens for this email
            DB::table('password_reset_tokens')->where('email', $user->email)->delete();

            // 3. Insert new token dengan hash
            DB::table('password_reset_tokens')->insert([
                'email' => $user->email,
                'token' => Hash::make($token),
                'created_at' => now()
            ]);

            // 4. Generate reset URL
            $resetUrl = route('password.reset', [
                'token' => $token,
                'email' => $user->email
            ]);

            // 5. Send professional notification
            $user->notify(new \App\Notifications\AdminTriggeredPasswordReset($resetUrl, $user->name));

            return redirect()->route('admin.siswa.index')
                ->with('success', '✅ Link reset password telah dikirim ke email: ' . $user->email);

        } catch (\Exception $e) {
            Log::error('Password reset error for student ' . $siswa->id . ': ' . $e->getMessage());

            return redirect()->route('admin.siswa.index')
                ->with('error', '❌ Gagal mengirim link reset password. Silakan coba lagi.');
        }
    }

    public function getJson(Siswa $siswa)
    {
        if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'operator') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $siswa->load('user');
        return response()->json($siswa);
    }
}