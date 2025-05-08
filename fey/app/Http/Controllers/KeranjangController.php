<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use Illuminate\Support\Facades\Session;

class KeranjangController extends Controller
{
    public function add(Request $request)
    {
        $produk = Produk::findOrFail($request->produk_id);

        $keranjang = Session::get('keranjang', []);

        if (isset($keranjang[$produk->id])) {
            $keranjang[$produk->id]['jumlah']++;
        } else {
            $keranjang[$produk->id] = [
                'nama' => $produk->nama,
                'harga' => $produk->harga,
                'jumlah' => 1,
                'foto' => $produk->foto,
            ];
        }

        Session::put('keranjang', $keranjang);

        return redirect()->route('keranjang.index')->with('success', 'Produk berhasil ditambahkan ke keranjang');
    }
    // KeranjangController.php
    public static function count()
    {
        $userId = auth()->id();
        return \App\Models\Keranjang::where('user_id', $userId)->count();
    }

    public function index()
    {
        $keranjang = Session::get('keranjang', []);
        return view('keranjang.index', compact('keranjang'));
    }

    public function remove($id)
    {
        $keranjang = Session::get('keranjang', []);
        unset($keranjang[$id]);
        Session::put('keranjang', $keranjang);

        return redirect()->route('keranjang.index')->with('success', 'Produk berhasil dihapus dari keranjang');
    }

    public function clear()
    {
        Session::forget('keranjang');
        return redirect()->route('keranjang.index')->with('success', 'Keranjang berhasil dikosongkan');
    }
}
