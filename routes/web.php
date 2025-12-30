<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\HalamanController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\Admin\PesananAdminController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HalamanController::class, 'index']);
Route::get('/tentang', [HalamanController::class, 'tentang']);
Route::get('/kontak', [HalamanController::class, 'kontak']);

// Route::resource('siswa', SiswaController::class)->middleware('isLogin');

Route::get('/sesi', [SessionController::class, 'index']);
Route::post('/sesi/login', [SessionController::class, 'login']);
Route::get('/sesi/logout', [SessionController::class, 'logout']);

Route::get('/sesi/register', [SessionController::class, 'register']);
Route::post('/sesi/create', [SessionController::class, 'create']) ;

// Route::get('/admin', [HalamanController::class, 'admin'])->middleware('role:admin');
// Route::get('/dashboard', [CustomerController::class, 'index'])->middleware('role:customer');


///Produk
Route::resource('produk', ProdukController::class);
// Route::get('/produk/{id}', [ProdukController::class, 'show'])->name('produk.show');
// Route::get('/produk ', [ProdukController::class, 'index'])->name('produk.index');
Route::get('/semuaproduk', [ProdukController::class, 'semua'])->name('produk.semua');
Route::get('/sayuran', [ProdukController::class, 'kategoriSayur'])->name('produk.kategori.sayur');
Route::get('/buahan', [ProdukController::class, 'kategoriBuah'])->name('produk.kategori.buah');
Route::get('/rempahan', [ProdukController::class, 'kategoriRempah'])->name('produk.kategori.rempah');



//update

// //edit
// Route::get('/produk/{id}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
// Route::put('/produk/{id}', [ProdukController::class, 'update'])->name('produk.update');

// //delete
// Route::delete('/produk/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');

Route::get('/profile', [HalamanController::class, 'profile'])->middleware('auth');



// Keranjang
Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
Route::post('/keranjang/tambah/{produk_id}', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');
Route::delete('/keranjang/hapus/{id}', [KeranjangController::class, 'hapus'])->name('keranjang.hapus');

// Checkout
Route::get('/checkout', [CheckoutController::class, 'formCheckout'])->name('checkout.form');
Route::post('/checkout', [CheckoutController::class, 'prosesCheckout'])->name('checkout.proses');

Route::get('/pesanan-saya', [PesananController::class, 'index'])->name('pesanan.saya');
Route::post('/pesanan/{id}/selesai', [PesananController::class, 'selesai'])->name('pesanan.selesai');

Route::middleware('role:admin')->group(function () {
    Route::get('/admin', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/penjualan/print', [DashboardController::class, 'print'])->name('admin.penjualan.print');
    Route::get('/admin/penjualan/pdf', [DashboardController::class, 'pdf'])->name('admin.penjualan.pdf');

    Route::get('/admin/pesanan', [PesananAdminController::class, 'index'])->name('admin.pesanan.index');
    Route::post('/admin/pesanan/{id}/ubah-status', [PesananAdminController::class, 'ubahStatus'])->name('admin.pesanan.ubah-status');
});
