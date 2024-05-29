<?php

use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NotaController;
use App\Http\Controllers\PengirimanController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UkuranController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [LandingController::class, 'index'])->name('home');
Route::get('/shop', [LandingController::class, 'shop'])->name('shop');
Route::get('/shop-serch', [LandingController::class, 'searchProduk'])->name('search.produk');
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.store');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.store');

Route::get('/category/{id}', [KategoriController::class, 'produkByKategori'])->name('kategori.id');
Route::get('/produk/{id}', [ProdukController::class, 'getProductById'])->name('produk.id');
Route::get('/checkout/{id}', [CheckoutController::class, 'index'])->name('checkout')->middleware('isAuthUser');
Route::post('/checkout-store', [CheckoutController::class, 'store_pesanan'])->name('checkout-store')->middleware('isAuthUser');
Route::get('/category-landing', [LandingController::class, 'category'])->name('kategori-landing');
Route::get('/category-landing/{id}', [LandingController::class, 'getProdukByKategori'])->name('kategori-landing-id');

Route::get('/contact', [LandingController::class, 'contact'])->name('contact');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('isAuth');
Route::get('/dashboard/user', [DashboardController::class, 'index_user'])->name('dashboard-user')->middleware('isAuthUser');
Route::get('/pesanan/user', [DashboardController::class, 'pesanan_user'])->name('pesanan-user')->middleware('isAuthUser');
Route::get('/pengiriman/user', [DashboardController::class, 'pengiriman_user'])->name('pengiriman-user')->middleware('isAuthUser');
Route::put('/pengiriman/user/acc/{id}', [DashboardController::class, 'update_pengiriman_user'])->name('pengiriman-user-acc')->middleware('isAuthUser');
Route::put('/pesanan/user/{id}', [DashboardController::class, 'update_pelunasan'])->name('pemesanan-user-pelunasan')->middleware('isAuthUser');

Route::get('/user', [UserController::class, 'index'])->name('user')->middleware('isAuth');
Route::put('/user-update', [UserController::class, 'updateUser'])->name('user-update')->middleware(['isAuth']);
Route::put('/user-update-password-admin', [UserController::class, 'updatePassword'])->name('user-update-password-admin')->middleware(['isAuth']);
Route::put('/user-update-profile', [UserController::class, 'update User'])->name('user-update-profile')->middleware(['isAuthUser']);
Route::put('/user-update-password', [UserController::class, 'updatePassword'])->name('user-update-password')->middleware(['isAuthUser']);
Route::get('/profile-admin', [DashboardController::class, 'profile_admin'])->name('profile-admin')->middleware('isAuth');
Route::get('/profile-user', [DashboardController::class, 'profile_user'])->name('profile-user')->middleware('isAuthUser');

Route::get('/colors', [ColorController::class, 'index'])->name('colors')->middleware('isAuth');
Route::post('/colors/store', [ColorController::class, 'store'])->name('colors.store')->middleware('isAuth');
Route::put('/colors/{id}/update', [ColorController::class, 'update'])->name('colors.update')->middleware('isAuth');
Route::delete('/colors/{id}/delete', [ColorController::class, 'delete'])->name('colors.delete')->middleware('isAuth');

Route::get('/bank', [BankController::class, 'index'])->name('bank')->middleware('isAuth');
Route::post('/bank/store', [BankController::class, 'store'])->name('bank.store')->middleware('isAuth');
Route::put('/bank/{id}/update', [BankController::class, 'update'])->name('bank.update')->middleware('isAuth');
Route::delete('/bank/{id}/delete', [BankController::class, 'delete'])->name('bank.delete')->middleware('isAuth');

Route::get('/ukuran', [UkuranController::class, 'index'])->name('ukuran')->middleware('isAuth');
Route::post('/ukuran/store', [UkuranController::class, 'store'])->name('ukuran.store')->middleware('isAuth');
Route::put('/ukuran/{id}/update', [UkuranController::class, 'update'])->name('ukuran.update')->middleware('isAuth');
Route::delete('/ukuran/{id}/delete', [UkuranController::class, 'delete'])->name('ukuran.delete')->middleware('isAuth');

Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori')->middleware('isAuth');
Route::post('/kategori/store', [KategoriController::class, 'store'])->name('kategori.store')->middleware('isAuth');
Route::put('/kategori/{id}/update', [KategoriController::class, 'update'])->name('kategori.update')->middleware('isAuth');
Route::delete('/kategori/{id}/delete', [KategoriController::class, 'delete'])->name('kategori.delete')->middleware('isAuth');

Route::get('/produk', [ProdukController::class, 'index'])->name('produk')->middleware('isAuth');
Route::post('/produk/store', [ProdukController::class, 'store'])->name('produk.store')->middleware('isAuth');
Route::put('/produk/{id}/update', [ProdukController::class, 'update'])->name('produk.update')->middleware('isAuth');
Route::delete('/produk/{id}/delet', [ProdukController::class, 'delete'])->name('produk.delete')->middleware('isAuth');

Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan')->middleware('isAuth');
Route::put('/pesanan/{id}/update', [PesananController::class, 'update'])->name('pesanan-update')->middleware('isAuth');
Route::get('/pesanan/{id}/nota', [PesananController::class, 'cetakNota'])->name('pesanan-nota')->middleware('isAuth');
Route::post('/pesanan-bahan-baku', [PesananController::class, 'storeOrUpdateBahanBaku'])->name('pesanan.bahan-baku.store-or-update')->middleware('isAuth');
Route::get('/laporan-pesanan', [PesananController::class, 'laporan_pesanan'])->name('pesanan.laporan')->middleware('isAuth');
Route::get('/export-excel', [PesananController::class, 'exportExcel'])->name('export.excel')->middleware('isAuth');


Route::get('/bahan', [BahanBakuController::class, 'index'])->name('bahan')->middleware('isAuth');
Route::post('/bahan/store', [BahanBakuController::class, 'store'])->name('bahan-store')->middleware('isAuth');
Route::get('/laporan-bahan', [BahanBakuController::class, 'laporan_bahan'])->name('bahan.laporan')->middleware('isAuth');
Route::get('/export-bahan-excel', [BahanBakuController::class, 'exportBahanExcel'])->name('export.bahan.excel')->middleware('isAuth');


Route::get('/pengiriman', [PengirimanController::class, 'index'])->name('pengiriman')->middleware('isAuth');
Route::get('/pengiriman-pesanan', [PengirimanController::class, 'indexPengirimanPesanan'])->name('pengiriman.pesanan')->middleware('isAuth');
Route::put('/pengiriman-pesanan-store', [PengirimanController::class, 'updatePesanan'])->name('pengiriman.pesanan.store')->middleware('isAuth');
Route::post('/pengiriman-store', [PengirimanController::class, 'store'])->name('pengiriman.store')->middleware('isAuth');
Route::put('/pengiriman-update/{id}', [PengirimanController::class, 'update'])->name('pengiriman.update')->middleware('isAuth');

Route::get('/nota-scan', [NotaController::class, 'index'])->name('nota.scan')->middleware('isAuthUser');
