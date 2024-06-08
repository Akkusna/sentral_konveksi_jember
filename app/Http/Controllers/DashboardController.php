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
        $user = User::where('is_admin', '0')->count();
        $produk = Produk::count();
        $pesanan = Pesanan::count();
        $pengiriman = Pengiriman::count();
        $userLatest = User::OrderByDesc('id')->where('is_admin', '0')->take(5)->get();
        $pesananLatest = Pesanan::with('user')->OrderByDesc('id')->take(5)->get();
        return view('dashboard.dashboard', compact('user', 'produk', 'pesanan', 'pengiriman', 'userLatest', 'pesananLatest'));
    }

    public function index_user()
    {
        $user = auth()->user()->id;

        $pesanan = Pesanan::where('user_id', $user)->where('status', 'proses')->count();
        $pesananFinish = Pesanan::where('user_id', $user)->where('status', 'selesai')->count();

        $pengiriman = Pesanan::where('user_id', $user)
            ->where('status', 'dalam pengiriman')
            ->whereNotNull('pengiriman_id')
            ->count();

        $pengirimanFinish = Pesanan::where('user_id', $user)
            ->where('status', 'selesai')
            ->whereNotNull('pengiriman_id')
            ->count();

        return view('dashboard.user.home', compact('pesanan', 'pesananFinish', 'pengiriman', 'pengirimanFinish'));
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
        $pesanan = Pesanan::where('user_id', $idUser)
            ->where('pengiriman_id', '!=', null)
            // ->where('status', 'dalam pengiriman')
            ->get();
        return view('dashboard.user.pengiriman', compact('pesanan'));
    }

    public function update_pengiriman_user($id)
    {
        $pengiriman = Pesanan::findOrFail($id);

        $pengiriman->update([
            'status' => 'selesai'
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
