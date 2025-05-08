@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4">Produk Tersedia</h2>

    <!-- Tombol Kategori dan Keranjang/Transaksi -->
    <div class="d-flex justify-content-between mb-4">
        <!-- Tombol Kategori di kiri -->
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="kategoriDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                Kategori
            </button>
            <ul class="dropdown-menu" aria-labelledby="kategoriDropdown">
                @foreach($kategoris as $kategori)
                    <li><a class="dropdown-item" href="{{ route('produk.index', ['kategori_id' => $kategori->id]) }}">{{ $kategori->nama }}</a></li>
                @endforeach
            </ul>
        </div>

        <!-- Tombol Keranjang dan Transaksi di kanan -->
        <div class="d-flex gap-3">
            <!-- Tombol Keranjang -->
            <a href="{{ route('keranjang.index') }}" class="btn btn-success position-relative">
                <i class="fa fa-shopping-cart"></i> Keranjang
                @if(isset($keranjangCount) && $keranjangCount > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $keranjangCount }}
                    </span>
                @endif
            </a>

            <!-- Tombol Transaksi -->
            <a href="{{ route('transaksi.transaksi') }}" class="btn btn-success position-relative">
                <i class="fa fa-box"></i> Transaksi
            </a>
        </div>
    </div>

    <!-- Daftar Produk -->
    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach($produks as $produk)
        <div class="col">
            <div class="card shadow-sm border-light rounded d-flex flex-column h-100">
                <!-- Gambar Produk -->
                <img src="{{ $produk->foto ? asset('storage/' . $produk->foto) : 'https://via.placeholder.com/200x200' }}"
                     class="card-img-top img-fluid"
                     alt="{{ $produk->nama }}"
                     style="object-fit: cover; height: 200px;">

                <!-- Informasi Produk -->
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-truncate">{{ $produk->nama }}</h5>
                    <p class="card-text text-muted">Kode: {{ $produk->kode_produk }}</p>
                    <p class="card-text text-danger">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>

                    <!-- Tombol Lihat Deskripsi -->
                    <button class="btn btn-sm btn-primary mt-2" type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#deskripsi-{{ $produk->id }}"
                            aria-expanded="false"
                            aria-controls="deskripsi-{{ $produk->id }}">
                        Lihat Deskripsi
                    </button>

                    <!-- Deskripsi Collapse -->
                    <div class="collapse mt-2" id="deskripsi-{{ $produk->id }}">
                        <p class="card-text">{{ $produk->deskripsi }}</p>
                    </div>
                </div>

                <!-- Footer Tombol -->
                <div class="card-footer text-center">
                    <div class="d-flex justify-content-between gap-2">
                        <!-- Tombol Masukkan Keranjang -->
                        <form action="{{ route('keranjang.add') }}" method="POST" class="w-50">
                            @csrf
                            <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                            <button type="submit" class="btn btn-info btn-sm w-100">
                                <i class="fa fa-shopping-cart"></i> Tambah
                            </button>
                        </form>

                        <!-- Tombol Beli -->
                        <a href="{{ route('produk.beli', $produk->id) }}" class="btn btn-warning btn-sm w-50">
                            <i class="fa fa-credit-card"></i> Beli
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
