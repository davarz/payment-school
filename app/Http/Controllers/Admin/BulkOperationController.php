<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa; // Ganti User dengan Siswa
use App\Models\User;
use Illuminate\Http\Request;

class BulkOperationController extends Controller
{
    public function naikKelas()
    {
        // Mengambil data dari tabel siswa
        $siswa = Siswa::where('status_siswa', 'aktif')->get();   
        return view('admin.bulk.naik-kelas', compact('siswa'));
    }

    public function updateNaikKelas(Request $request)
    {
        $request->validate([
            'siswa_ids' => 'required|array',
            'tahun_ajaran' => 'required|string',
            'kelas' => 'required|string',
        ]);

        // Update ke tabel siswa
        Siswa::whereIn('id', $request->siswa_ids)
            ->update([
                'tahun_ajaran' => $request->tahun_ajaran,
                'kelas' => $request->kelas,
            ]);

        return redirect()->route('admin.bulk.naik-kelas')
            ->with('success', 'Data siswa berhasil diperbarui secara massal');
    }

    public function updateSemester(Request $request)
    {
        $request->validate([
            'semester' => 'required|in:ganjil,genap',
        ]);

        // Update logic untuk semester
        // Misalnya: update setting aplikasi atau data lainnya
        // session()->put('semester_aktif', $request->semester);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Semester berhasil diubah');
    }
}