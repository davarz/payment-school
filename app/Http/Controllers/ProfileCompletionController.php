<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileCompletionController extends Controller
{
    /**
     * Show the profile completion form.
     */
    public function show()
    {
        $user = Auth::user();
        $siswa = $user->siswa; // Assuming there's a relationship defined

        return view('profile.complete', compact('user', 'siswa'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $request->validate([
            'nis' => ['nullable', 'string', 'max:20', 'unique:siswa,nis,' . (Auth::user()->siswa ? Auth::user()->siswa->id : 'NULL') . ',id'],
            'nik' => ['nullable', 'string', 'max:16', 'unique:siswa,nik,' . (Auth::user()->siswa ? Auth::user()->siswa->id : 'NULL') . ',id'],
            'nisn' => ['nullable', 'string', 'max:10', 'unique:siswa,nisn,' . (Auth::user()->siswa ? Auth::user()->siswa->id : 'NULL') . ',id'],
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

        $user = Auth::user();

        // Update or create student data
        $siswa = $user->siswa;
        if ($siswa) {
            // Update existing student record
            $siswa->update($request->only([
                'nis', 'nik', 'nisn', 'tahun_ajaran', 'kelas',
                'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir',
                'telepon', 'alamat', 'nama_wali', 'telepon_wali', 'alamat_wali'
            ]));
        } else {
            // Create new student record
            $user->siswa()->create(array_merge(
                $request->only([
                    'nis', 'nik', 'nisn', 'tahun_ajaran', 'kelas',
                    'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir',
                    'telepon', 'alamat', 'nama_wali', 'telepon_wali', 'alamat_wali'
                ]),
                [
                    'user_id' => $user->id,
                    'status_siswa' => 'aktif',
                ]
            ));
        }

        return redirect()->route('siswa.dashboard')
            ->with('success', 'Profil berhasil dilengkapi!');
    }
}