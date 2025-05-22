<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\Kategori;
use ZipArchive;

use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{

    public function index(Request $request)
    {
        // Ambil nilai kategori_id dari query parameter
        $kategori_id = $request->get('kategori_id');
        
        // Ambil nilai search dari query parameter
        $search = $request->get('search');

        // Query produk berdasarkan kategori dan pencarian
        $produks = Produk::query();

        if ($kategori_id) {
            $produks = $produks->where('kategori_id', $kategori_id);
        }

        if ($search) {
            $produks = $produks->where('nama', 'like', '%' . $search . '%')
                            ->orWhere('kode_produk', 'like', '%' . $search . '%');
        }

        // Ambil data produk berdasarkan query
        $produks = $produks->get();

        // Ambil data kategori untuk dropdown
        $kategoris = Kategori::all();

        return view('home', [
            'produks' => $produks,
            'kategoris' => $kategoris,
            'keranjangCount' => auth()->user()->keranjang->count(), // contoh keranjang count
        ]);
    }

    public function adminIndex(Request $request)
    {
        $query = Produk::query();

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%')
                ->orWhere('kode_produk', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        $produks = $query->get();
        $kategoris = Kategori::all();

        return view('adminHome', compact('produks', 'kategoris'));
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
            'zip_file' => 'required|mimes:zip',
            'deskripsi' => 'required|string',
            'kategori_id' => 'required|exists:kategoris,id',
        ]);

        $fotoPath = $request->file('foto')?->store('produk', 'public');

        $zipPath = null;
        if ($request->hasFile('zip_file')) {
            $zipPath = $request->file('zip_file')->store('zip_files', 'public');
        }

        $produk = Produk::create([
            'kode_produk' => $request->kode_produk,
            'nama' => $request->nama,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'foto' => $fotoPath,
            'zip_file' => $zipPath,
            'deskripsi' => $request->deskripsi,
            'kategori_id' => $request->kategori_id,
        ]);

        // ✅ Ekstrak file ZIP ke folder public/games/{id}
        if ($zipPath) {
            $zip = new ZipArchive;
            $zipFilePath = storage_path('app/public/' . $zipPath);
            $extractPath = public_path('games/' . $produk->id);

        if ($zip->open($zipFilePath) === true) {
            if (!file_exists($extractPath)) {
                mkdir($extractPath, 0755, true);
            }
            $zip->extractTo($extractPath);
            $zip->close();
            }
        }

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
            'zip_file' => 'nullable|mimes:zip',
            'deskripsi' => 'required|string',
            'kategori_id' => 'required|exists:kategoris,id',
        ]);

        $produk = Produk::findOrFail($id);

        $fotoPath = $produk->foto;
        if ($request->hasFile('foto')) {
            if ($fotoPath) {
                Storage::disk('public')->delete($fotoPath);
            }
            $fotoPath = $request->file('foto')->store('produk', 'public');
        }

        $zipPath = $produk->zip_file;
        if ($request->hasFile('zip_file')) {
            if ($zipPath) {
                Storage::disk('public')->delete($zipPath);
                // Hapus folder game lama
                Storage::deleteDirectory('public/games/' . $produk->id);
            }

            $zipPath = $request->file('zip_file')->store('zip_files', 'public');

            // ✅ Ekstrak ulang file ZIP
            $zip = new ZipArchive;
            $zipFilePath = storage_path('app/public/' . $zipPath);
            $extractPath = public_path('games/' . $produk->id);

            if ($zip->open($zipFilePath) === true) {
                if (!file_exists($extractPath)) {
                    mkdir($extractPath, 0755, true);
                }
                $zip->extractTo($extractPath);
                $zip->close();
            }
        }

        $produk->update([
            'kode_produk'  => $request->kode_produk,
            'nama'         => $request->nama,
            'harga'        => $request->harga,
            'stok'         => $request->stok,
            'foto'         => $fotoPath,
            'zip_file'     => $zipPath,
            'deskripsi'    => $request->deskripsi,
            'kategori_id'  => $request->kategori_id,
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
