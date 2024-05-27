<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\TransaksiKeluar;
use App\Models\TransaksiMasuk;
use Illuminate\Http\Request;

class BahanBakuController extends Controller
{
    public function index()
    {
        $bahan = BahanBaku::OrderByDesc('id')->get();
        $bahanMasuk = TransaksiMasuk::OrderByDesc('id')->with('bahanBaku')->get();
        $bahanKeluar = TransaksiKeluar::OrderByDesc('id')->with(['bahanBaku', 'pesanan'])->get();
        return view('dashboard.bahan', compact('bahan', 'bahanMasuk', 'bahanKeluar'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required',
            'harga' => 'required',
            'qty' => 'required',
        ]);

        $bahan = BahanBaku::create([
            'nama' => $validatedData['nama'],
            'harga' => $validatedData['harga'],
            'qty' => $validatedData['qty'],
            'total_harga' => $validatedData['harga'] * $validatedData['qty']
        ]);

        if ($bahan) {
            TransaksiMasuk::create([
                'bahan_baku_id' => $bahan->id,
                'qty' => $validatedData['qty'],
            ]);

            return redirect()->route('bahan')->with('message', 'Data Berhasil Ditambahkan');
        } else {
            return back()->withInput()->with('error', 'Gagal menambahkan data');
        }
    }

    public function laporan_bahan()
    {
        $bahan = BahanBaku::with(['transaksiMasuk', 'transaksiKeluar'])->get();
        return view('dashboard.laporan-bahan', compact('bahan'));
    }
}
