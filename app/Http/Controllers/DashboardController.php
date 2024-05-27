<?php

namespace App\Http\Controllers;

use App\Models\Pengiriman;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = User::count();
        $produk = Produk::count();
        $pesanan = Pesanan::count();
        $pengiriman = Pengiriman::count();
        $userLatest = User::OrderByDesc('id')->take(5)->get();
        $pesananLatest = Pesanan::OrderByDesc('id')->take(5)->get();
        return view('dashboard.dashboard', compact('user', 'produk', 'pesanan', 'pengiriman', 'userLatest'));
    }

    public function index_user()
    {
        $user = auth()->user()->id;
        $pesanan = Pesanan::where('user_id', $user)->count();
        $pesanan = Pesanan::where('user_id', $user)
            ->whereNotNull('pengiriman_id')
            ->count();

        return view('dashboard.user.home', compact('pesanan', 'pengiriman'));
    }

    public function pesanan_user()
    {

        $idUser = Auth::user()->id;
        $pesanan = Pesanan::with(['user', 'detailPesanan.color', 'produk'])
            ->where('user_id', $idUser)
            ->orderByDesc('id')
            ->get();

        return view('dashboard.user.pesanan', compact('pesanan'));
    }

    public function pengiriman_user()
    {
        $idUser = Auth::user()->id;
        $pengiriman = Pengiriman::with('pesanan')
            ->whereHas('pesanan', function ($query) use ($idUser) {
                $query->where('user_id', $idUser);
            })
            ->get();
        return view('dashboard.user.pengiriman', compact('pengiriman'));
    }

    public function update_pengiriman_user($id)
    {
        $pengiriman = Pengiriman::findOrFail($id);

        $pengiriman->update([
            'status' => 'sampai'
        ]);

        return redirect()->back()->with('message', 'Paket telah diterima');
    }

    public function update_pelunasan(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $request->validate([
            'bukti_pelunasan' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $fileNameImage = time() . '.' . $request->bukti_pelunasan->extension();
        $request->bukti_pelunasan->move(public_path('foto/bukti/'), $fileNameImage);

        $pesanan->update([
            'bukti_pelunasan' => $fileNameImage
        ]);

        return redirect()->back()->with('message', 'Berhasil upload bukti pelunasan');
    }

    public function profile_admin()
    {
        return view('dashboard.profile');
    }
    public function profile_user()
    {
        return view('dashboard.user.profile');
    }
}
