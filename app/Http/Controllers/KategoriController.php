<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::OrderByDesc('id')->get();
        return view('dashboard.kategori', compact('kategori'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required',
        ]);

        Kategori::create($validatedData);
        return redirect()->route('kategori')->with('message', 'Data berhasil disimpan.');
    }

    public function delete($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();
        return redirect()->route('kategori')->with('message', 'Data berhasil dihapus.');
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama' => 'required',
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->update($validatedData);
        return redirect()->route('kategori')->with('message', 'Data berhasil diperbarui.');
    }

    public function produkByKategori($id)
    {
        $kategori = Kategori::findOrFail($id);

        $produk = $kategori->produk()->get();

        return view('landing.produk-list', compact('produk'));
    }

    
}
