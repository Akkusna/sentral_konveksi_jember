<?php

namespace App\Http\Controllers;

use App\Models\Pengiriman;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class PengirimanController extends Controller
{
    public function index()
    {
        $pengiriman = Pengiriman::with('pesanan')->OrderByDesc('id')->get();
        return view('dashboard.pengiriman', compact('pengiriman'));
    }

    public function indexPengirimanPesanan()
    {
        $pengiriman = Pengiriman::with(['pesanan', 'pesanan.user', 'pesanan.produk'])->OrderByDesc('id')->get();
        $pesanan_user = Pesanan::with(['user', 'produk'])
            ->where('status_pembayaran', 'lunas')
            ->where('status', 'proses')
            ->where('pengiriman', 'pengiriman')
            ->where('pengiriman_id', null)
            ->get();
        return view('dashboard.pesanan_pengiriman', compact('pengiriman', 'pesanan_user'));
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'tanggal_pengiriman' => 'required',
            'estimasi' => 'required',
            'tanggal_tiba' => 'required',
            'alamat' => 'required',
            'alamat_tujuan' => 'required',
            'jasa_ekspedisi' => 'required',
            'harga_ongkir' => 'required',
        ]);

        Pengiriman::create($validateData);

        return redirect()->route('pengiriman')->with('message', 'Data berhasil ditambah');
    }

    public function update(Request $request, $id)
    {
        $pengiriman = Pengiriman::findOrFail($id);

        $validateData = $request->validate([
            'tanggal_pengiriman' => 'required',
            'estimasi' => 'required',
            'tanggal_tiba' => 'required',
            'alamat' => 'required',
            'alamat_tujuan' => 'required',
            'jasa_ekspedisi' => 'required',
            'harga_ongkir' => 'required',
        ]);

        $pengiriman->update($validateData);


        return redirect()->route('pengiriman')->with('message', 'Data berhasil diupdate');
    }

    public function updatePesanan(Request $request)
    {
        $request->validate([
            'pengiriman_id' => 'required',
            'pesanan_id' => 'required'
        ]);

        $pesanan = Pesanan::findOrFail($request->pesanan_id);

        $pesanan->update([
            'status' => "dalam pengiriman",
            'pengiriman_id' => $request->pengiriman_id,
        ]);

        return redirect()->route('pengiriman.pesanan')->with('message', 'Barang berhasil dikirim');
    }
}
