@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Keranjang Belanja</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(count($keranjang) > 0)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                    <th>Action</th>
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
                        <td>
                            <a href="{{ route('produk.beli', $item['id']) }}" class="btn btn-success btn-sm">
                                Checkout
                            </a>
                            <a href="{{ route('keranjang.remove', $id) }}"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Yakin ingin menghapus item ini dari keranjang?')">
                                Hapus
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Form Checkout -->
        <div class="text-right mt-3">
            <a href="{{ route('keranjang.clear') }}"
               class="btn btn-warning ml-2"
               onclick="return confirm('Yakin ingin mengosongkan seluruh keranjang?')">
                Kosongkan Keranjang
            </a>
        </div>
    @else
        <p class="text-center">Keranjang Anda kosong</p>
    @endif
</div>
@endsection
