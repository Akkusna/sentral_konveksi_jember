<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\DetailPesanan;
use App\Models\DetailProduk;
use App\Models\Pengiriman;
use App\Models\Pesanan;
use App\Models\PesananColor;
use App\Models\PesananUkuran;
use App\Models\Produk;
use App\Models\ProdukColor;
use App\Models\ProdukUkuran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index($id, Request $request)
    {
        $bank = Bank::all();
        $produk = Produk::with('kategori')->findOrFail($id);
        $warna = ProdukColor::where('produk_id', $id)->with('color')->get();
        $ukuran = ProdukUkuran::where('produk_id', $id)->with('ukuran')->get();
        $userId = Auth::id();
        $pengiriman = Pengiriman::whereHas('pesanan', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->get();
        $lengan = $produk->lengan;
        return view('landing.checkout', compact('produk', 'bank', 'warna', 'ukuran', 'pengiriman', 'lengan'));
    }

    public function store_pesanan(Request $request)
    {
        $request->validate([
            'color_id' => 'required|array',
            'produk_id' => 'required',
            'ukuran_id' => 'required|array',
            'qty' => 'required|array',
            'qty.*' => 'required|numeric|min:1',
            'pengiriman' => 'required',
            'grand_total' => 'required',
            'bukti' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'detail_pesanan' => 'required',
            'detail_alamat' => 'required',
        ], [
            'bukti.required' => 'Anda harus mengunggah gambar.',
            'bukti.image' => 'File harus berupa gambar.',
            'bukti.mimes' => 'Gambar harus dalam format JPEG, PNG, JPG, atau GIF.',
            'bukti.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
        ]);

        $fileNameImage = time() . '.' . $request->bukti->extension();
        $request->bukti->move(public_path('foto/bukti/'), $fileNameImage);
        $totalQty = array_sum($request->qty);
        $pesanan = Pesanan::create([
            'user_id' => auth()->user()->id,
            'produk_id' => $request->produk_id,
            'qty' => $totalQty,
            'grand_total' => $request->grand_total,
            'status' => "menunggu konfirmasi",
            'bukti' => $fileNameImage,
            'pengiriman' => $request->pengiriman,
            'status_pembayaran' => "belum_bayar",
            'detail_pesanan' => $request->detail_pesanan,
            'detail_alamat' => $request->detail_alamat,
        ]);

        foreach ($request->color_id as $key => $color_id) {
            DetailPesanan::create([
                'pesanan_id' => $pesanan->id,
                'color_id' => $color_id,
                'ukuran_id' => $request->ukuran_id[$key],
                'qty' => $request->qty[$key],
            ]);
        }

        if ($request->pengiriman === 'pengiriman') {
            $pesanan->pengiriman_id = $request->pengiriman_id;
        } else {
            $pesanan->pengiriman_id = null;
        }

        $pesanan->save();

        return redirect()->route('dashboard-user')->with('message', 'Berhasil melakukan pemesanan.');
    }
}
