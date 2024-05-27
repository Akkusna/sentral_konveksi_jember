<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $kategori = Kategori::withTotalProduk()->get();
        $latestProduk = Produk::latest()->take(6)->get();
        return view('landing.home', compact('kategori', 'latestProduk'));
    }

    public function shop()
    {
        $produk = Produk::orderByDesc('id')->with('kategori')->paginate(9);

        return view('landing.shop', compact('produk'));
    }

    public function searchProduk(Request $request)
    {
        if ($request->ajax()) {
            $query = $request->get('query');
            $produk = Produk::where('nama', 'like', '%' . $query . '%')->paginate(9);
            return response()->json($produk);
        }
    }

    public function category()
    {
        $kategori = Kategori::all();
        $produk = Produk::orderByDesc('id')->with('kategori')->paginate(9);

        return view('landing.kategori', compact('produk', 'kategori'));
    }
    public function getProdukByKategori($kategori_id)
    {
        $produk = Produk::where('kategori_id', $kategori_id)->get();
        return response()->json($produk);
    }

    public function contact()
    {
        return view('landing.contact');
    }
}
