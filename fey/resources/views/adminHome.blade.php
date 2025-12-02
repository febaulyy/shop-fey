@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #f5f7fa;
    }

    .card {
        background-color: #ffffff;
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    }

    .card-title {
        color: #2c3e50;
        font-weight: 600;
    }

    .card-text {
        color: #444;
    }

    .btn-primary {
        background-color: #6183af;
        border: none;
    }

    .btn-primary:hover {
        background-color: #4d6a91;
    }

    .btn-success {
        background-color: #f39c12;
        border: none;
    }

    .btn-success:hover {
        background-color: #d68910;
    }

    .btn-danger {
        background-color: #e74c3c;
        border: none;
    }

    .btn-danger:hover {
        background-color: #c0392b;
    }

    .btn-secondary {
        background-color: #bdc3c7;
        color: #2c3e50;
    }

    .btn-secondary:hover {
        background-color: #95a5a6;
    }

    .btn-info {
        background-color: #a5bbd6;
        color: #2c3e50;
        border: none;
    }

    .btn-info:hover {
        background-color: #8ea8c3;
    }

    .collapse-body {
        background-color: #eaf0f7;
        color: #2c3e50;
        border-radius: 10px;
    }
</style>


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
        <a href="{{ route('transaksi.transaksiManager') }}" class="btn btn-info">
            <i class="bi bi-receipt"></i> Lihat Transaksi
        </a>
    </div>

    <form action="{{ route('admin.produk.index') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Cari produk..." value="{{ request('search') }}">
            <button class="btn btn-outline-secondary" type="submit">
                <i class="bi bi-search"></i> Cari
            </button>
        </div>
    </form>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach($produks as $produk)
        <div class="col">
            <div class="card h-100">
                <img src="{{ $produk->foto ? asset('storage/' . $produk->foto) : 'https://via.placeholder.com/150' }}" 
                    class="card-img-top" alt="Foto Produk" style="object-fit: cover; height: 200px;">
                <div class="card-body text-center">
                    <h5 class="card-title">{{ $produk->nama }}</h5>
                    <p class="card-text">Kode: {{ $produk->kode_produk }}</p>
                    <p class="card-text">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                    <p class="card-text">Kategori: {{ $produk->kategori->nama ?? 'Tidak ada kategori' }}</p>

                    <button class="btn btn-sm btn-toggle-deskripsi mt-2" type="button" 
                        data-bs-toggle="collapse" 
                        data-bs-target="#deskripsi-{{ $produk->id }}" 
                        aria-expanded="false" 
                        aria-controls="deskripsi-{{ $produk->id }}">
                        <i class="bi bi-eye"></i> Lihat Deskripsi
                    </button>


                    <div class="collapse mt-2" id="deskripsi-{{ $produk->id }}">
                        <div class="card-body collapse-body">
                            {{ $produk->deskripsi }}
                        </div>
                    </div>

                    <button class="btn btn-sm btn-aksi-toggle mt-2" type="button" 
                        data-bs-toggle="collapse" 
                        data-bs-target="#aksi-{{ $produk->id }}" 
                        aria-expanded="false" 
                        aria-controls="aksi-{{ $produk->id }}">
                        <i class="bi bi-gear"></i> Aksi
                    </button>


                    <div class="collapse mt-2" id="aksi-{{ $produk->id }}">
                        <div class="d-flex justify-content-center gap-2">
                        <a href="{{ route('produk.edit', $produk->id) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>

                        <form action="{{ route('produk.destroy', $produk->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
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
