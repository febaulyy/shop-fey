@extends('layouts.app')

@section('content')
<div class="container mt-100">
    <h2 class="mb-4"><strong>Data Barang</strong></h2>

    <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3">
    <div class="d-flex gap-2">
        <a href="{{ route('produk.create') }}" class="btn btn-success">
            <i class="bi bi-plus-lg"></i> Tambah Barang
        </a>
        <a href="{{ route('kategori.index') }}" class="btn btn-primary">
            <i class="bi bi-folder2-open"></i> Daftar Kategori
        </a>
    </div>
        <a href="{{ route('transaksi.transaksiManager') }}" class="btn btn-info text-white">
            <i class="bi bi-receipt"></i> Lihat Transaksi
        </a>
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach($produks as $produk)
        <div class="col">
            <div class="card h-100 shadow-sm">
                <img src="{{ $produk->foto ? asset('storage/' . $produk->foto) : 'https://via.placeholder.com/150' }}" 
                    class="card-img-top" alt="Foto Produk" style="object-fit: cover; height: 200px; width: 100%;">
                <div class="card-body text-center">
                    <h5 class="card-title">{{ $produk->nama }}</h5>
                    <p class="card-text">Kode: {{ $produk->kode_produk }}</p>
                    <p class="card-text">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>

                    <!-- Menampilkan kategori -->
                    <p class="card-text">Kategori: {{ $produk->kategori->nama ?? 'Tidak ada kategori' }}</p>

                    <!-- Tombol untuk toggle deskripsi -->
                    <button class="btn btn-sm mt-2 text-white" type="button" 
                        style="background-color: #1e88e5; border: none;" 
                        data-bs-toggle="collapse" 
                        data-bs-target="#deskripsi-{{ $produk->id }}" 
                        aria-expanded="false" 
                        aria-controls="deskripsi-{{ $produk->id }}">
                        Lihat Deskripsi
                    </button>

                    <!-- Konten deskripsi -->
                    <div class="collapse mt-2" id="deskripsi-{{ $produk->id }}">
                        <div class="card card-body">
                            {{ $produk->deskripsi }}
                        </div>
                    </div>

                    <!-- Tombol untuk toggle Aksi -->
                    <button class="btn btn-secondary btn-sm mt-2" type="button" data-bs-toggle="collapse" data-bs-target="#aksi-{{ $produk->id }}" aria-expanded="false" aria-controls="aksi-{{ $produk->id }}">
                        Aksi
                    </button>

                    <!-- Konten aksi -->
                    <div class="collapse mt-2" id="aksi-{{ $produk->id }}">
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('produk.edit', $produk->id) }}" class="btn btn-warning btn-sm">
                                Edit
                            </a>
                            <form action="{{ route('produk.destroy', $produk->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        @endforeach
    </div>

</div>
@endsection
