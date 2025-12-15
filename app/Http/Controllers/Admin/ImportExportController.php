<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pembayaran;
use App\Models\KategoriPembayaran;
use App\Models\Tagihan;
use App\Models\Siswa; // Tambahkan model Siswa
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Spatie\DbDumper\Databases\MySql;

class ImportExportController extends Controller
{
    public function exportData()
    {
        // Hitung jumlah data untuk informasi
        $counts = [
            'siswa' => Siswa::count(),
            'users' => User::count(),
            'pembayaran' => Pembayaran::count(),
            'tagihan' => Tagihan::count(),
            'kategori' => KategoriPembayaran::count(),
        ];

        return view('admin.import-export.export', compact('counts'));
    }

    public function downloadBackup()
    {
        $filename = 'backup-school-' . date('Y-m-d-H-i-s') . '.sql';
        
        MySql::create()
            ->setDbName(config('database.connections.mysql.database'))
            ->setUserName(config('database.connections.mysql.username'))
            ->setPassword(config('database.connections.mysql.password'))
            ->dumpToFile(storage_path('app/backups/' . $filename));

        return response()->download(storage_path('app/backups/' . $filename))
            ->deleteFileAfterSend(true);
    }

    public function importData()
    {
        return view('admin.import-export.import');
    }

    public function processImport(Request $request)
    {
        $request->validate([
            'backup_file' => 'required|file|mimes:sql',
        ]);

        try {
            // Upload file
            $file = $request->file('backup_file');
            $filePath = $file->storeAs('temp-imports', 'import.sql');
            
            // Baca isi file SQL
            $sql = Storage::get($filePath);
            
            // Eksekusi SQL (HATI-HATI! Ini akan overwrite data)
            DB::unprepared($sql);
            
            // Hapus file temporary
            Storage::delete($filePath);
            
            return redirect()->route('admin.import-export.import')
                ->with('success', 'Database berhasil di-restore dari backup!');

        } catch (\Exception $e) {
            return redirect()->route('admin.import-export.import')
                ->with('error', 'Gagal mengimport data: ' . $e->getMessage());
        }
    }

    // Method baru untuk export data tertentu (opsional)
    public function exportExcel(Request $request)
    {
        $request->validate([
            'data_type' => 'required|in:siswa,pembayaran,tagihan,kategori',
        ]);

        // Logic untuk export Excel berdasarkan tipe data
        // Bisa menggunakan Laravel Excel package
        
        return back()->with('info', 'Fitur export Excel akan segera tersedia');
    }
}