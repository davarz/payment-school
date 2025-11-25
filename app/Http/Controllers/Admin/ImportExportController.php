<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pembayaran;
use App\Models\KategoriPembayaran;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\DbDumper\Databases\MySql;

class ImportExportController extends Controller
{
    public function exportData()
    {
        return view('admin.import-export.export');
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

        // Logic untuk restore database
        // Ini akan diimplementasikan di bagian berikutnya

        return redirect()->route('admin.import-export.import')
            ->with('success', 'Data berhasil diimport');
    }
}