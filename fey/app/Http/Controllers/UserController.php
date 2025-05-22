<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game; // Model Game
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function profil()
    {
        $user = auth()->user(); // ambil data user yang login
        return view('user.profil', compact('user'));
    }

    // Menampilkan form tambah game
    public function create()
    {
        $kategoris = \App\Models\Kategori::all(); // Ambil semua kategori
        return view('user.create', compact('kategoris'));
    }

    // Menyimpan data game baru
    public function store(Request $request)
    {
        $request->validate([
            'kode_produk' => 'required|string|max:50',
            'nama' => 'required|string|max:100',
            'harga' => 'required|numeric',
            'deskripsi' => 'required|string',
            'kategori_id' => 'required|exists:kategoris,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'zip_file' => 'required|file|mimes:zip|max:10000',
        ]);

        // Simpan file
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('foto_games', 'public');
        }

        $zipPath = $request->file('zip_file')->store('zip_games', 'public');

        // Simpan ke database
        Game::create([
            'kode_produk' => $request->kode_produk,
            'nama' => $request->nama,
            'harga' => $request->harga,
            'deskripsi' => $request->deskripsi,
            'kategori_id' => $request->kategori_id,
            'foto' => $fotoPath,
            'zip_file' => $zipPath,
            'user_id' => Auth::id(), // Simpan user yang upload
        ]);

        return redirect()->route('profil')->with('success', 'Game berhasil ditambahkan!');
    }
}

