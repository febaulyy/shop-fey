<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class PembelianController extends Controller
{
    // ✅ Menampilkan transaksi user
    public function transaksiIndex()
    {
        $user = Auth::user();
        $transaksis = Transaksi::with(['produk', 'user']) // ini penting
            ->where('user_id', $user->id)
            ->get();
            $kategoris = Kategori::all();

        return view('transaksi.transaksi', compact('transaksis'));
    }

    public function kategoriIndex($id) 
    { 
        $kategori = Kategori::findOrFail($id); 
        $produks = Produk::where('kategori_id', $id)->get(); 
        $kategoris = Kategori::all(); 
        $users = User::all(); 
 
        return view('transaksi.transaksi', compact('produks', 'users', 'keranjangs', 
        'kategoris')); 
    }

    public function bayar($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        if ($transaksi->status != 'Pending') {
            return redirect()->back()->with('error', 'Transaksi sudah dibayar atau tidak valid.');
        }

        // Simulasi pembayaran
        $transaksi->status = 'Selesai';
        $transaksi->save();

        // Langsung download PDF
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('transaksi.pdf', compact('transaksi'));
        return $pdf->download('transaksi-' . $transaksi->id . '.pdf');
    }



    // ✅ Menampilkan transaksi untuk admin
    public function transaksiIndexManager()
    {
        $transaksis = Transaksi::all();
        return view('transaksi.transaksiManager', compact('transaksis'));
    }

    // ✅ Konfirmasi transaksi oleh admin
    public function konfirmasiStatus($id)
    {
        $transaksi = Transaksi::find($id);
        if ($transaksi) {
            $transaksi->status = 'Selesai';
            $transaksi->save();
            return redirect()->route('transaksi.transaksiManager')->with('success', 'Transaksi dikonfirmasi.');
        }
        return redirect()->back()->with('error', 'Transaksi tidak ditemukan.');
    }

    // ✅ Hapus transaksi oleh admin
    public function hapus($id)
    {
        $transaksi = Transaksi::find($id);
        if ($transaksi) {
            $transaksi->delete();
            return redirect()->route('transaksi.transaksiManager')->with('success', 'Transaksi dihapus.');
        }
        return redirect()->back()->with('error', 'Transaksi tidak ditemukan.');
    }

    // ✅ Clear transaksi oleh user
    public function clear($id)
    {
        $transaksi = Transaksi::find($id);
        if ($transaksi) {
            $transaksi->delete();
            return redirect()->route('transaksi.transaksi')->with('success', 'Transaksi dihapus.');
        }
        return redirect()->back()->with('error', 'Transaksi tidak ditemukan.');
    }

    // ✅ Cetak PDF transaksi
    public function generatePdf($id)
    {
        $transaksi = Transaksi::find($id);
        if (!$transaksi) {
            return redirect()->back()->with('error', 'Transaksi tidak ditemukan.');
        }

        $pdf = Pdf::loadView('transaksi.pdf', compact('transaksi'));
        return $pdf->download('transaksi-' . $transaksi->id . '.pdf');
    }

    public function prosesPembelian(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $user = Auth::user();
        $produk = Produk::findOrFail($request->produk_id);

        if ($produk->stok < $request->jumlah) {
            return back()->with('error', 'Stok tidak mencukupi.');
        }

        $totalHarga = $produk->harga * $request->jumlah;

        $transaksi = Transaksi::create([
            'user_id' => $user->id,
            'produk_id' => $produk->id,
            'nama' => $produk->id,
            'nama_penerima' => $user->name,
            'harga' => $totalHarga,
            'status' => 'Pending',
        ]);

        $produk->decrement('stok', $request->jumlah);

        return redirect()->route('transaksi.transaksi')->with('success', 'Transaksi berhasil dilakukan.');
    }

}
