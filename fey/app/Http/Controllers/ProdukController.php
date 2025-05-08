<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\Kategori;

use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index(Request $request)
{
    // Jika ada kategori_id di query parameter
    if ($request->has('kategori_id')) {
        $kategori_id = $request->get('kategori_id');
        $produks = Produk::where('kategori_id', $kategori_id)->get();
    } else {
        // Jika tidak ada kategori_id, tampilkan semua produk
        $produks = Produk::all();
    }

    $kategoris = Kategori::all();

    return view('home', [
        'produks' => $produks,
        'kategoris' => $kategoris,
        'keranjangCount' => auth()->user()->keranjang->count(), // contoh keranjang count
    ]);
}

    public function create()
    {
        // Ambil semua kategori
        $kategoris = Kategori::all();
        
        // Kirimkan kategori ke view
        return view('produk.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_produk' => 'required|unique:produks',
            'nama' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'deskripsi' => 'required|string',
            'kategori_id' => 'required|exists:kategoris,id',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('produk', 'public');
        }

        Produk::create([
            'kode_produk' => $request->kode_produk,
            'nama' => $request->nama,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'foto' => $fotoPath,
            'deskripsi' => $request->deskripsi,
            'kategori_id' => $request->kategori_id,
        ]);

        return redirect()->route('adminHome')->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        $kategoris = Kategori::all();
        return view('produk.edit', compact('produk', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_produk' => 'required',
            'nama' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'deskripsi' => 'required|string', 'kategori_id' => 'required|exists:kategoris,id',
        ]);

        $produk = Produk::findOrFail($id);

        if ($request->hasFile('foto')) {
            if ($produk->foto) {
                Storage::disk('public')->delete($produk->foto);
            }
            $fotoPath = $request->file('foto')->store('produk', 'public');
        } else {
            $fotoPath = $produk->foto;
        }

        $produk->update([
            'kode_produk' => $request->kode_produk,
            'nama' => $request->nama,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'foto' => $fotoPath,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('adminHome')->with('success', 'Produk berhasil diperbarui');
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);

        if ($produk->foto) {
            Storage::disk('public')->delete($produk->foto);
        }

        $produk->delete();

        return redirect()->route('adminHome')->with('success', 'Produk berhasil dihapus');
    }

    // ✅ Menampilkan halaman beli
    public function showBeli($id)
    {
        $produk = Produk::findOrFail($id);
        return view('produk.beli', compact('produk'));
    }

    // ✅ Proses pembelian produk
    public function prosesBeli(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        if ($produk->stok > 0) {
            $produk->stok -= 1;
            $produk->save();

            return redirect()->route('produk.show', $produk->id)->with('success', 'Pembelian berhasil!');
        }

        return redirect()->route('produk.show', $produk->id)->with('error', 'Stok produk tidak mencukupi.');
    }

    // Opsional: Menampilkan detail produk (jika ada route 'produk.show')
    public function show($id)
    {
        $produk = Produk::findOrFail($id);
        return view('produk.show', compact('produk'));
    }
}
