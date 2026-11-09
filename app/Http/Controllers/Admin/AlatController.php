<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\Kategori;
use Illuminate\Http\Request;

class AlatController extends Controller
{
    // Menampilkan semua data alat
    public function index()
    {
        $alat = Alat::with('kategori')->get();

        return view('admin.alat.index', compact('alat'));
    }

    // Menampilkan form tambah alat
    public function create()
    {
        $kategori = Kategori::all();

        return view('admin.alat.create', compact('kategori'));
    }

    // Menyimpan alat baru
    public function store(Request $request)
    {
        $request->validate([
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'nama_alat' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
        ]);

        Alat::create($request->only([
            'id_kategori',
            'nama_alat',
            'stok',
        ]));

        return redirect('/admin/alat')
            ->with('success', 'Alat berhasil ditambahkan!');
    }

    // Menampilkan form edit alat
    public function edit($id)
    {
        $alat = Alat::findOrFail($id);
        $kategori = Kategori::all();

        return view('admin.alat.edit', compact('alat', 'kategori'));
    }

    // Memperbarui data alat
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'nama_alat' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
        ]);

        $alat = Alat::findOrFail($id);

        $alat->update($request->only([
            'id_kategori',
            'nama_alat',
            'stok',
        ]));

        return redirect('/admin/alat')
            ->with('success', 'Data alat berhasil diubah!');
    }

    // Menghapus alat
    public function destroy($id)
    {
        $alat = Alat::findOrFail($id);
        $alat->delete();

        return redirect('/admin/alat')
            ->with('success', 'Alat berhasil dihapus!');
    }
}