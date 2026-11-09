<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;


class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::all();

        return view('admin.kategori.index', compact('kategori'));
    }

    public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori,nama_kategori',
        ]);

        Kategori::create([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect('/admin/kategori')
            ->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);

        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori,nama_kategori,' . $id . ',id_kategori',
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect('/admin/kategori')
            ->with('success', 'Kategori berhasil diubah!');
    }

    public function destroy($id)
{
    $kategori = Kategori::findOrFail($id);

  
    if ($kategori->alat()->exists()) {
        return redirect('/admin/kategori')
            ->with('error', 'Kategori tidak bisa dihapus karena masih digunakan oleh data alat!');
    }

    $kategori->delete();

    return redirect('/admin/kategori')
        ->with('success', 'Kategori berhasil dihapus!');
}
}