<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua produk beserta data kategorinya
        $produks = Produk::with('kategori')->get();
        
        // Ambil semua kategori untuk dropdown
        $kategoris = Kategori::all();

        // Kirim data ke view
        return view('kategori.index', [
            'produks' => $produks,
            'kategoris' => $kategoris,
            'keranjangCount' => auth()->user()->keranjang->count(),  // contoh keranjang count
        ]);
    }


    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori_id' => 'nullable|exists:kategoris,id',
        ]);

        Kategori::create([
            'nama' => $request->nama,
            'kategori_id' => $validated['kategori_id'] ?? null,
        ]);

        return redirect()->route('kategori.create')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|max:255',
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->update($request->all());
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui');
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus');
    }

}
