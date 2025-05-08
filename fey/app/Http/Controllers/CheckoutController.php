<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keranjang;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $keranjangs = Keranjang::with('produk')
            ->where('user_id', auth()->id())
            ->get();

        if ($keranjangs->isEmpty()) {
            return redirect()->route('keranjang')->with('error', 'Keranjang kamu masih kosong!');
        }

        $total = $keranjangs->sum(function ($item) {
            return $item->produk->harga * $item->jumlah;
        });

        return view('checkout', compact('checkout', 'total'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'alamat' => 'required|string|max:255',
            'telepon' => 'required|string|max:20',
            'catatan' => 'nullable|string|max:255',
            'nama_penerima' => 'required|string|max:255', // Menambahkan validasi untuk nama penerima
        ]);

        DB::beginTransaction();

        try {
            $user = auth()->user();
            $keranjangs = Keranjang::with('produk')->where('user_id', $user->id)->get();

            if ($keranjangs->isEmpty()) {
                return redirect()->route('keranjang')->with('error', 'Keranjang kamu kosong.');
            }

            $total = $keranjangs->sum(function ($item) {
                return $item->produk->harga * $item->jumlah;
            });

            $transaksi = Transaksi::create([
                'user_id' => $user->id,
                'tanggal' => now(),
                'total' => $total,
                'status' => 'pending',
                'alamat' => $request->alamat,
                'telepon' => $request->telepon,
                'catatan' => $request->catatan,
                'nama_penerima' => $request->nama_penerima, // Menambahkan nama penerima
            ]);

            foreach ($keranjangs as $item) {
                TransaksiDetail::create([
                    'transaksi_id' => $transaksi->id,
                    'produk_id' => $item->produk_id,
                    'jumlah' => $item->jumlah,
                    'harga' => $item->produk->harga,
                ]);
            }

            Keranjang::where('user_id', $user->id)->delete();

            DB::commit();

            return redirect()->route('checkout.success')->with('success', 'Transaksi berhasil!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

}
