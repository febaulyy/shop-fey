@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-center text-uppercase"><strong>Tambah Barang</strong></h2>

    <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="kode_produk" class="form-label fw-bold text-dark">Kode Produk</label>
            <input type="text" name="kode_produk" class="form-control shadow-sm" value="{{ old('kode_produk') }}" required placeholder="Masukkan kode produk">
        </div>

        <div class="mb-3">
            <label for="nama" class="form-label fw-bold text-dark">Nama Produk</label>
            <input type="text" name="nama" class="form-control shadow-sm" value="{{ old('nama') }}" required placeholder="Masukkan nama produk">
        </div>

        <div class="mb-3">
            <label for="harga" class="form-label fw-bold text-dark">Harga Produk</label>
            <input type="text" name="harga" class="form-control shadow-sm" value="{{ old('harga') }}" required placeholder="Masukkan harga produk">
        </div>

        <div class="mb-3">
            <label for="stok" class="form-label fw-bold text-dark">Stok Produk</label>
            <input type="number" name="stok" class="form-control shadow-sm" value="{{ old('stok') }}" required placeholder="Masukkan stok produk">
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label fw-bold text-dark">Deskripsi Produk</label>
            <textarea name="deskripsi" class="form-control shadow-sm" required placeholder="Deskripsikan produk">{{ old('deskripsi') }}</textarea>
        </div>

        <!-- Dropdown untuk kategori -->
        <div class="mb-3">
            <label for="kategori_id" class="form-label fw-bold text-dark">Kategori Produk</label>
            <select name="kategori_id" class="form-control shadow-sm" required>
                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="foto" class="form-label fw-bold text-dark">Foto Produk</label>
            <input type="file" name="foto" class="form-control shadow-sm" accept="image/*">
        </div>

        <div class="mb-4">
            <label for="zip_file" class="form-label fw-bold text-dark">File ZIP Game</label>
            <input type="file" name="zip_file" class="form-control shadow-sm" accept=".zip" required>
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Tambah Produk</button>
    </form>
</div>
@endsection
