@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Detail Pembelian Produk</h2>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="row g-0">
                    <div class="col-md-5">
                        <img src="{{ $produk->foto ? asset('storage/' . $produk->foto) : 'https://via.placeholder.com/400x400' }}"
                             class="img-fluid rounded-start w-100 h-100 object-fit-cover"
                             alt="{{ $produk->nama }}">
                    </div>

                    <div class="col-md-7">
                        <div class="card-body">
                            <h4 class="card-title">{{ $produk->nama }}</h4>
                            <p class="text-muted mb-1">Kode Produk: {{ $produk->kode_produk }}</p>
                            <h5 class="text-danger">Harga: Rp {{ number_format($produk->harga, 0, ',', '.') }}</h5>
                            <p class="mt-3">{{ $produk->deskripsi }}</p>

                            @if($produk->stok > 0)
                                <form action="{{ route('pembelian.proses') }}" method="POST" class="mt-4">
                                    @csrf
                                    <input type="hidden" name="produk_id" value="{{ $produk->id }}">

                                    <div class="mb-3">
                                        <label for="jumlah" class="form-label">Jumlah Beli</label>
                                        <input type="number" name="jumlah" id="jumlah" class="form-control"
                                               min="1" max="{{ $produk->stok }}" value="1" required oninput="updateSubtotal()">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Subtotal</label>
                                        <input type="text" id="subtotal" class="form-control" value="Rp {{ number_format($produk->harga, 0, ',', '.') }}" readonly>
                                    </div>

                                    <button type="submit" class="btn btn-success w-100">
                                        <i class="fa fa-shopping-cart me-1"></i> Lanjutkan Transaksi
                                    </button>
                                </form>
                            @else
                                <div class="alert alert-danger mt-3">
                                    Stok habis. Produk tidak tersedia saat ini.
                                </div>
                            @endif

                            <div class="mt-3">
                                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="fa fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateSubtotal() {
            let harga = {{ $produk->harga }};
            let jumlah = document.getElementById('jumlah').value;
            let subtotal = harga * jumlah;

            let formatter = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            });

            // Update subtotal field
            document.getElementById('subtotal').value = formatter.format(subtotal);
        }
    </script>
</div>
@endsection
