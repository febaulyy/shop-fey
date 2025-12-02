@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4">Produk Tersedia</h2>

    <!-- Tombol Kategori dan Keranjang/Transaksi -->
    <div class="d-flex justify-content-between mb-4">
        <div class="dropdown">
        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="kategoriDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-tags"></i> Kategori
        </button>

            <ul class="dropdown-menu" aria-labelledby="kategoriDropdown">
                @foreach($kategoris as $kategori)
                    <li><a class="dropdown-item" href="{{ route('produk.index', ['kategori_id' => $kategori->id]) }}">{{ $kategori->nama }}</a></li>
                @endforeach
            </ul>
        </div>      

        <div class="d-flex gap-3">
        <a href="{{ route('keranjang.index') }}" class="btn btn-outline-success position-relative">
            <i class="bi bi-cart-fill"></i> Keranjang
            @if(isset($keranjangCount) && $keranjangCount > 0)
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    {{ $keranjangCount }}
                </span>
            @endif
        </a>

        <a href="{{ route('transaksi.transaksi') }}" class="btn btn-outline-success">
            <i class="bi bi-box-seam"></i> Transaksi
        </a>

        <a href="{{ route('profil') }}" class="btn btn-outline-primary">
            <i class="bi bi-person-circle"></i> Profil
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

                    <button class="btn btn-outline-primary btn-sm mt-2" type="button"
        data-bs-toggle="collapse"
        data-bs-target="#deskripsi-{{ $produk->id }}"
        aria-expanded="false"
        aria-controls="deskripsi-{{ $produk->id }}">
    <i class="bi bi-eye"></i> Lihat Deskripsi
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
                            <button type="submit" class="btn btn-outline-success btn-sm w-100">
    <i class="bi bi-cart-plus"></i> Tambah ke Keranjang
</button>

                        </form>

                        <a href="{{ route('produk.beli', $produk->id) }}" class="btn btn-outline-warning btn-sm w-100">
    <i class="bi bi-cash-coin"></i> Beli
</a>


                        @if ($produk->zip_file)
                        <button type="button" class="btn btn-outline-info btn-sm w-100"
                                data-bs-toggle="modal"
                                data-bs-target="#modalGame-{{ $produk->id }}">
                            <i class="bi bi-controller"></i> Mainkan Game
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

@section('scripts')

@section('scripts')
<script>
// Timer 20 detik untuk modal game
let timeoutId;

// Gunakan event delegation di seluruh dokumen
document.addEventListener('shown.bs.modal', function (event) {
    const modal = event.target;
    console.log('Modal terbuka, mulai timer 20 detik');

    timeoutId = setTimeout(function () {
        console.log('Timer selesai, tutup modal');

        const modalInstance = bootstrap.Modal.getInstance(modal);
        if (modalInstance) {
            modalInstance.hide();
        }

        alert("Waktu bermain telah habis (20 detik).");
    }, 20000);
});

document.addEventListener('hidden.bs.modal', function () {
    console.log('Modal ditutup, clear timeout & reset iframe');

    clearTimeout(timeoutId);

    // Reset iframe jika ada
    document.querySelectorAll('.modal iframe').forEach(iframe => {
        const src = iframe.src;
        iframe.src = '';
        iframe.src = src;
    });

    // Hapus backdrop & kembalikan scroll jika perlu
    document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
    document.body.classList.remove('modal-open');
    document.body.style.overflow = 'auto';
});
</script>
@endsection


<script>
// Script untuk reset iframe & bersihkan modal backdrop & scroll
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.modal').forEach(function(modal) {
        modal.addEventListener('hidden.bs.modal', function () {
            const iframe = modal.querySelector('iframe');
            if (iframe) {
                const src = iframe.src;
                iframe.src = '';
                iframe.src = src;
            }

            // Hapus backdrop yang mungkin masih tersisa
            document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());

            // Kembalikan scroll & interaksi normal
            document.body.classList.remove('modal-open');
            document.body.style.overflow = 'auto';
        });
    });
});
</script>
