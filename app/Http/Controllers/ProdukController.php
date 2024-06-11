<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Ukuran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProdukController extends Controller
{
    public function index()
    {
        $produk = Produk::OrderByDesc('id')->with('kategori')->get();
        $kategori = Kategori::all();
        $color = Color::all();
        $ukuran = Ukuran::all();
        return view('dashboard.produk', compact('produk', 'kategori', 'color', 'ukuran'));
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kategori_id' => 'required',
            'nama' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required',
            'lengan' => 'required',
            'color' => 'required|array',
            'color.*' => 'exists:color,id',
            'ukuran' => 'required|array',
            'ukuran.*' => 'exists:ukuran,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'image.required' => 'Anda harus mengunggah gambar.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Gambar harus dalam format JPEG, PNG, JPG, atau GIF.',
            'image.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
        ]);


        $fileNameImage = time() . '.' . $request->image->extension();
        $request->image->move(public_path('foto/product/'), $fileNameImage);

        $produk = Produk::create([
            'kategori_id' => $validatedData['kategori_id'],
            'nama' => $validatedData['nama'],
            'lengan' => $validatedData['lengan'],
            'image' => $fileNameImage,
            'deskripsi' => $validatedData['deskripsi'],
            'harga' => $validatedData['harga'],
        ]);

        // Simpan warna
        foreach ($validatedData['color'] as $colorId) {
            $produk->produkColor()->create([
                'color_id' => $colorId,
            ]);
        }

        // Simpan ukuran
        foreach ($validatedData['ukuran'] as $ukuranId) {
            $produk->produkUkuran()->create([
                'ukuran_id' => $ukuranId,
            ]);
        }

        return redirect()->route('produk')->with('message', 'Produk berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'kategori_id' => 'required',
            'nama' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required',
            'color' => 'required|array',
            'color.*' => 'exists:color,id',
            'ukuran' => 'required|array',
            'ukuran.*' => 'exists:ukuran,id',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Gambar harus dalam format JPEG, PNG, JPG, atau GIF.',
            'image.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
        ]);

        $produk = Produk::findOrFail($id);

        $lengan = $request->has('customCheck') ? 1 : 0;

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if (file_exists(public_path('foto/product/' . $produk->image))) {
                unlink(public_path('foto/product/' . $produk->image));
            }

            // Simpan gambar baru
            $fileNameImage = time() . '.' . $request->image->extension();
            $request->image->move(public_path('foto/product/'), $fileNameImage);

            $produk->image = $fileNameImage;
        }

        // Update produk
        $produk->update([
            'kategori_id' => $validatedData['kategori_id'],
            'nama' => $validatedData['nama'],
            'deskripsi' => $validatedData['deskripsi'],
            'harga' => $validatedData['harga'],
            'lengan' => $lengan,
        ]);

        // Update warna
        $produk->produkColor()->delete();
        foreach ($validatedData['color'] as $colorId) {
            $produk->produkColor()->create([
                'color_id' => $colorId,
            ]);
        }

        // Update ukuran
        $produk->produkUkuran()->delete();
        foreach ($validatedData['ukuran'] as $ukuranId) {
            $produk->produkUkuran()->create([
                'ukuran_id' => $ukuranId,
            ]);
        }

        return redirect()->route('produk')->with('message', 'Produk berhasil diperbarui.');
    }



    public function delete($id)
    {
        $produk = Produk::findOrFail($id);
        $deleteimage = Produk::where('id', $id)->first();
        File::delete(public_path('foto/product') . '/' . $deleteimage->image);
        $produk->delete();
        return redirect()->route('produk')->with('message', 'Data berhasil dihapus.');
    }

    public function getProductById($id)
    {
        $produk = Produk::with('kategori')->findOrFail($id);

        return view('landing.item-produk', compact('produk'));
    }
}
