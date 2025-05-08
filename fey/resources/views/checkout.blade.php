@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Checkout</h2>

    @if(count($keranjang) > 0)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($keranjang as $id => $item)
                    <tr>
                        <td><img src="{{ Storage::url($item['foto']) }}" width="100" alt="{{ $item['nama'] }}"></td>
                        <td>{{ $item['nama'] }}</td>
                        <td>{{ number_format($item['harga'], 0, ',', '.') }}</td>
                        <td>{{ $item['jumlah'] }}</td>
                        <td>{{ number_format($item['harga'] * $item['jumlah'], 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Form Checkout -->
        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf

            <div class="form-group mb-3">
                <label for="nama_penerima">Nama Penerima</label>
                <input type="text" name="nama_penerima" id="nama_penerima" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label for="alamat">Alamat</label>
                <textarea name="alamat" id="alamat" class="form-control" required></textarea>
            </div>

            <div class="form-group mb-3">
                <label for="telepon">Nomor Telepon</label>
                <input type="text" name="telepon" id="telepon" class="form-control" required>
            </div>

            <div class="form-group mb-4">
                <label for="catatan">Catatan</label>
                <textarea name="catatan" id="catatan" class="form-control"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Proses Checkout</button>
        </form>
    @else
        <p>Keranjang Anda kosong, silakan tambahkan produk terlebih dahulu.</p>
    @endif
</div>
@endsection
