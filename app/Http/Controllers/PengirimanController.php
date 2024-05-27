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
        $pesanan = Pesanan::with(['color', 'user', 'produk'])
            ->where('status_pembayaran', 'lunas')
            ->where('status', 'proses')
            ->where('pengiriman', 'pengiriman')
            ->get();
        return view('dashboard.pesanan_pengiriman', compact('pengiriman', 'pesanan'));
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
            'status' => 'required',
            'tanggal_pengiriman' => 'required|date',
            'estimasi' => 'required',
            'tanggal_tiba' => 'required|date',
            'jasa_ekspedisi' => 'required|string',
            'harga_ongkir' => 'required|numeric',
        ]);

        $pengiriman->update([
            'status' => $validateData['status'],
            'tanggal_pengiriman' => $validateData['tanggal_pengiriman'],
            'estimasi' => $validateData['estimasi'],
            'tanggal_tiba' => $validateData['tanggal_tiba'],
        ]);

        $pesanan = $pengiriman->pesanan;
        if ($pesanan) {
            $pesanan->update([
                'jasa_ekspedisi' => $validateData['jasa_ekspedisi'],
                'harga_ongkir' => $validateData['harga_ongkir'],
            ]);
        }


        return redirect()->route('pengiriman')->with('message', 'Data berhasil diupdate');
    }
}
