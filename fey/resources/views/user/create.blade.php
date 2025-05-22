@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-center text-uppercase"><strong>Tambah Game</strong></h2>

    <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

        <div class="mb-3">
            <label class="form-label fw-bold text-dark">Kode Produk</label>
            <input type="text" name="kode_produk" class="form-control shadow-sm" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold text-dark">Nama Game</label>
            <input type="text" name="nama" class="form-control shadow-sm" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold text-dark">Harga</label>
            <input type="number" name="harga" class="form-control shadow-sm" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold text-dark">Deskripsi</label>
            <textarea name="deskripsi" class="form-control shadow-sm" required></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold text-dark">Kategori</label>
            <select name="kategori_id" class="form-control shadow-sm" required>
                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold text-dark">Foto Game</label>
            <input type="file" name="foto" class="form-control shadow-sm" accept="image/*">
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold text-dark">File ZIP Game</label>
            <input type="file" name="zip_file" class="form-control shadow-sm" accept=".zip" required>
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Tambah Game</button>
    </form>
</div>
@endsection
