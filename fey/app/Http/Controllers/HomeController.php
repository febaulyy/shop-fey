<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Transaksi;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Fungsi utama dashboard (admin atau user)

    public function index()
    {
        // Ambil semua produk beserta data kategorinya
        $produks = Produk::with('kategori')->get();

        // Ambil semua kategori untuk dropdown
        $kategoris = Kategori::all();

        // Kirim data ke view
        return view('home', [
            'produks' => $produks,
            'kategoris' => $kategoris,  // Pastikan ini ada
            'keranjangCount' => auth()->user()->keranjang->count(), // contoh keranjang count
        ]);
    }
    // Menampilkan halaman admin dengan semua data produk
    public function adminHome()
    {
        $produks = Produk::all();
        $transaksis = Transaksi::latest()->get();

        return view('adminHome', compact('produks', 'transaksis'));
    }

    public function transaksiAdmin()
    {
        $transaksis = Transaksi::latest()->get();
        return view('adminTransaksi', compact('transaksis'));
    }

    // Tambah produk baru
    public function store(Request $request) 
    { 
        $request->validate([ 
            'kode_produk' => 'required|unique:produks', 
            'nama' => 'required', 
            'harga' => 'required', 
        ]); 

        Produk::create($request->all()); 

        return redirect()->route('adminHome')->with('success', 'Produk berhasil ditambahkan'); 
    }

    // Form edit produk
    public function edit($id) 
    { 
        $produk = Produk::findOrFail($id); 
        return view('produk.edit', compact('produk')); 
    } 

    // Update produk
    public function update(Request $request, $id) 
    { 
        $request->validate([ 
            'kode_produk' => 'required', 
            'nama' => 'required', 
            'harga' => 'required', 
        ]); 

        $produk = Produk::findOrFail($id); 
        $produk->update($request->all()); 

        return redirect()->route('adminHome')->with('success', 'Produk berhasil diperbarui'); 
    }

    // Hapus produk
    public function destroy($id) 
    { 
        $produk = Produk::findOrFail($id); 
        $produk->delete(); 

        return redirect()->route('adminHome')->with('success', 'Produk berhasil dihapus'); 
    }

    // Tambahkan fungsi baru untuk menampilkan keranjang
    public function keranjang()
    {
        // Mendapatkan semua produk yang ada di keranjang milik pengguna yang sedang login
        $keranjangs = Auth::user()->keranjang;

        // Mendapatkan detail produk di keranjang
        $produkIds = $keranjangs->pluck('produk_id');
        $produks = Produk::whereIn('id', $produkIds)->get();

        return view('keranjang', compact('produks', 'keranjangs'));
    }

}
