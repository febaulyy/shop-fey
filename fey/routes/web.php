<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

// Halaman awal
Route::get('/', function () {
    return view('auth.login');
});

// Auth (Login & Register)
Auth::routes();

// Halaman home user biasa
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

// Halaman admin
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/home', [HomeController::class, 'adminHome'])->name('adminHome');
});

// ================== PRODUK ==================
Route::middleware(['auth'])->group(function () {
    Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
    Route::get('/produk/create', [ProdukController::class, 'create'])->name('produk.create');
    Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
    Route::get('/produk/{id}', [ProdukController::class, 'show'])->name('produk.show');
    Route::get('/produk/{id}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
    Route::put('/produk/{id}', [ProdukController::class, 'update'])->name('produk.update');
    Route::delete('/produk/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');

    // Fitur Beli (GET & POST)
    Route::get('/beli/{id}', [ProdukController::class, 'showBeli'])->name('produk.beli');
    Route::post('/beli/{id}', [ProdukController::class, 'prosesBeli'])->name('produk.beli.proses');
});

// ================== KERANJANG ==================
Route::prefix('keranjang')->name('keranjang.')->middleware('auth')->group(function () {
    Route::get('/', [KeranjangController::class, 'index'])->name('index');
    Route::post('/add', [KeranjangController::class, 'add'])->name('add');
    Route::get('/remove/{id}', [KeranjangController::class, 'remove'])->name('remove');
    Route::get('/clear', [KeranjangController::class, 'clear'])->name('clear');
});

// ================== CHECKOUT ==================
Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
});


// Transaksi User/Admin
Route::middleware(['auth'])->group(function () {
    Route::get('/transaksi', [PembelianController::class, 'transaksiIndex'])->name('transaksi.transaksi');
    Route::get('/transaksi/transaksiManager', [PembelianController::class, 'transaksiIndexManager'])->name('transaksi.transaksiManager');
    Route::post('/transaksi/{id}/konfirmasi', [PembelianController::class, 'konfirmasiStatus'])->name('transaksi.konfirmasi');
    Route::post('/transaksi/{id}/hapus', [PembelianController::class, 'hapus'])->name('transaksi.hapus');
    Route::post('/transaksi/{id}/clear', [PembelianController::class, 'clear'])->name('transaksi.clear');
    Route::get('/transaksi/{id}/cetak', [PembelianController::class, 'generatePdf'])->name('transaksi.cetak');
    Route::post('/pembelian/proses', [PembelianController::class, 'prosesPembelian'])->name('pembelian.proses');
    Route::post('/transaksi/{id}/bayar', [PembelianController::class, 'bayar'])->name('transaksi.bayar');
});

Route::get('/admin/transaksi', [HomeController::class, 'transaksiAdmin'])->name('admin.transaksi');

Route::resource('kategori', KategoriController::class);
Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

Route::get('/admin/produk', [ProdukController::class, 'adminIndex'])->name('admin.produk.index');


Route::middleware(['auth'])->group(function () {
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
    Route::get('/profil', [HomeController::class, 'profil'])->name('profil');
});

Route::get('/profil', [UserController::class, 'profil'])->name('profil')->middleware('auth');