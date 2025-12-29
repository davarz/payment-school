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

    public function downloadTemplate()
    {
        // Return template file untuk import siswa
        $file = storage_path('app/templates/template-siswa.xlsx');
        
        if (!file_exists($file)) {
            return back()->with('error', 'Template file tidak ditemukan');
        }
        
        return response()->download($file);
    }

    public function processSiswa(Request $request)
    {
        $request->validate([
            'siswa_file' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        try {
            return back()->with('success', 'Data siswa berhasil diimpor! (Fitur masih dalam pengembangan)');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengimpor data siswa: ' . $e->getMessage());
        }
    }

    public function exportSiswa(Request $request)
    {
        try {
            $format = $request->get('format', 'excel');
            
            $siswaData = Siswa::with('user')
                ->where('status_siswa', 'aktif')
                ->get();
            
            if ($format === 'csv') {
                return $this->exportAsCSV($siswaData, 'siswa');
            }
            
            return back()->with('info', 'Fitur export Excel akan segera tersedia. Silakan install package Laravel Excel.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengekspor data: ' . $e->getMessage());
        }
    }

    public function exportPembayaran(Request $request)
    {
        try {
            $pembayaranData = Pembayaran::with(['user.siswa', 'kategori', 'verifikator'])
                ->where('status', 'paid')
                ->get();
            
            return back()->with('info', 'Fitur export Excel akan segera tersedia. Silakan install package Laravel Excel.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengekspor data: ' . $e->getMessage());
        }
    }

    public function exportTagihan(Request $request)
    {
        try {
            $tagihanData = Tagihan::with(['user.siswa', 'kategori'])
                ->get();
            
            return back()->with('info', 'Fitur export Excel akan segera tersedia. Silakan install package Laravel Excel.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengekspor data: ' . $e->getMessage());
        }
    }

    private function exportAsCSV($data, $filename)
    {
        $csvData = [];
        
        foreach ($data as $row) {
            $csvData[] = $row->toArray();
        }
        
        return response()->streamDownload(function () use ($csvData) {
            $file = fopen('php://output', 'w');
            
            if (count($csvData) > 0) {
                fputcsv($file, array_keys($csvData[0]->toArray()));
                foreach ($csvData as $row) {
                    fputcsv($file, $row->toArray());
                }
            }
            
            fclose($file);
        }, $filename . '-' . date('Y-m-d') . '.csv');
    }
}