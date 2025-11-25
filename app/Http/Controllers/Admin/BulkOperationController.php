<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class BulkOperationController extends Controller
{
    public function naikKelas()
    {
        $siswa = User::where('role', 'siswa')->where('status_siswa', 'aktif')->get();   
        return view('admin.bulk.naik-kelas', compact('siswa'));
    }

    public function updateNaikKelas(Request $request)
    {
        $request->validate([
            'siswa_ids' => 'required|array',
            'tahun_ajaran' => 'required|string',
            'kelas' => 'required|string',
        ]);

        User::whereIn('id', $request->siswa_ids)
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
        // Ini akan diimplementasikan di bagian berikutnya

        return redirect()->route('admin.dashboard')
            ->with('success', 'Semester berhasil diubah');
    }
}