<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriPembayaran;
use Illuminate\Http\Request;

class KategoriPembayaranController extends Controller
{
    public function index()
    {
        $kategori = KategoriPembayaran::latest()->get();
        return view('admin.kategori.index', compact('kategori'));
    }

    public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'jumlah' => 'required|numeric|min:0',
            'tahun_ajaran' => 'required|string',
            'semester' => 'required|in:ganjil,genap',
            'frekuensi' => 'required|in:bulanan,semester,tahunan',
            'auto_generate' => 'sometimes|boolean', // 🔥 FIXED
        ]);

        KategoriPembayaran::create([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi' => $request->deskripsi,
            'jumlah' => $request->jumlah,
            'tahun_ajaran' => $request->tahun_ajaran,
            'semester' => $request->semester,
            'frekuensi' => $request->frekuensi,
            'auto_generate' => $request->boolean('auto_generate'), // 🔥 FIXED - gunakan boolean()
            'status' => 'active',
        ]);

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori pembayaran berhasil ditambahkan');
    }

    public function edit(KategoriPembayaran $kategori)
    {
        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, KategoriPembayaran $kategori)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'jumlah' => 'required|numeric|min:0',
            'tahun_ajaran' => 'required|string',
            'semester' => 'required|in:ganjil,genap',
            'frekuensi' => 'required|in:bulanan,semester,tahunan',
            'auto_generate' => 'sometimes|boolean', // 🔥 FIXED
            'status' => 'required|in:active,inactive',
        ]);

        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi' => $request->deskripsi,
            'jumlah' => $request->jumlah,
            'tahun_ajaran' => $request->tahun_ajaran,
            'semester' => $request->semester,
            'frekuensi' => $request->frekuensi,
            'auto_generate' => $request->boolean('auto_generate'), // 🔥 FIXED - gunakan boolean()
            'status' => $request->status,
        ]);

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori pembayaran berhasil diperbarui');
    }

    public function destroy(KategoriPembayaran $kategori)
    {
        $kategori->delete();
        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori pembayaran berhasil dihapus');
    }
}