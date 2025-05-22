@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4">Produk Tersedia</h2>

    <!-- Tombol Kategori dan Keranjang/Transaksi -->
    <div class="d-flex justify-content-between mb-4">
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

        <div class="d-flex gap-3">
            <a href="{{ route('keranjang.index') }}" class="btn btn-success position-relative">
                <i class="fa fa-shopping-cart"></i> Keranjang
                @if(isset($keranjangCount) && $keranjangCount > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $keranjangCount }}
                    </span>
                @endif
            </a>

            <a href="{{ route('transaksi.transaksi') }}" class="btn btn-success">
                <i class="fa fa-box"></i> Transaksi
            </a>

            <a href="{{ route('profil') }}" class="btn btn-primary">
                <i class="fa fa-user"></i> Profil
            </a>
        </div>
    </div>

    <form action="{{ route('produk.index') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Cari produk..." value="{{ request('search') }}">
            <button class="btn btn-outline-secondary" type="submit">
                <i class="bi bi-search"></i> Cari
            </button>
        </div>
    </form>

    <!-- Daftar Produk -->
    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach($produks as $produk)
        <div class="col">
            <div class="card shadow-sm border-light rounded d-flex flex-column h-100">
                <img src="{{ $produk->foto ? asset('storage/' . $produk->foto) : 'https://via.placeholder.com/200x200' }}"
                     class="card-img-top img-fluid"
                     alt="{{ $produk->nama }}"
                     style="object-fit: cover; height: 200px;">

                <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-truncate">{{ $produk->nama }}</h5>
                    <p class="card-text text-muted">Kode: {{ $produk->kode_produk }}</p>
                    <p class="card-text text-danger">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>

                    <button class="btn btn-sm btn-primary mt-2" type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#deskripsi-{{ $produk->id }}"
                            aria-expanded="false"
                            aria-controls="deskripsi-{{ $produk->id }}">
                        Lihat Deskripsi
                    </button>

                    <div class="collapse mt-2" id="deskripsi-{{ $produk->id }}">
                        <p class="card-text">{{ $produk->deskripsi }}</p>
                    </div>
                </div>

                <div class="card-footer text-center">
                    <div class="d-flex flex-column gap-2">
                        <form action="{{ route('keranjang.add') }}" method="POST" class="w-100">
                            @csrf
                            <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                            <button type="submit" class="btn btn-info btn-sm w-100">
                                <i class="fa fa-shopping-cart"></i> Tambah ke Keranjang
                            </button>
                        </form>

                        <a href="{{ route('produk.beli', $produk->id) }}" class="btn btn-warning btn-sm w-100">
                            <i class="fa fa-credit-card"></i> Beli
                        </a>

                        @if ($produk->zip_file)
                            <button class="btn btn-success btn-sm w-100" data-bs-toggle="modal" data-bs-target="#modalGame-{{ $produk->id }}">
                                <i class="fa fa-play"></i> Mainkan Game
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Modal untuk Mainkan Game -->
    @foreach($produks as $produk)
        @if ($produk->zip_file)
        <div class="modal fade" id="modalGame-{{ $produk->id }}" tabindex="-1" aria-labelledby="modalGameLabel-{{ $produk->id }}" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-fullscreen-md-down">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalGameLabel-{{ $produk->id }}">Mainkan: {{ $produk->nama }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body" style="height: 80vh;">
                        <iframe src="{{ url('games/' . $produk->id . '/index.html') }}"
                                frameborder="0"
                                width="100%"
                                height="100%"
                                allowfullscreen
                                style="border: none;"></iframe>
                    </div>
                </div>
            </div>
        </div>
        @endif
    @endforeach
</div>
@endsection
