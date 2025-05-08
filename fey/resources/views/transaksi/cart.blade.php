@extends('layouts.app') 
 
@section('content') 
<div class="container"> 
    <div class="row justify-content-center"> 
        <div class="col-md-8"> 
            <div class="card"> 
             <div class="card-header d-flex justify-content-between"> 
                <div>{{ __('Data Tiket') }}</div> 
                <div><a href="{{ route('home') }}" style="text-decoration: none;">{{ __('Beranda') 
}}</a></div> 
                <div><a href="{{ route('transaksi.transaksi') }}" style="text-decoration: none;">{{ __('Bayar 
Tiket') }}</a></div> 
            </div> 
 
                <div class="card-body"> 
    @if(session('success')) 
        <div class="alert alert-success">{{ session('success') }}</div> 
    @endif 
 
    <table class="table"> 
        <thead> 
            <tr> 
               <th>Kode Produk</th> 
               <th>Nama Pembeli</th> 
               <th>Harga</th> 
                <th>Status</th> 
               <th>Tanggal Transaksi</th> 
               <th class="text-center">Aksi</th> 
 
            </tr> 
        </thead> 
        <tbody> 
            @foreach($carts as $cart) 
                <tr> 
                    <td>{{ $cart->kode_produk }}</td> 
                    <td>{{ $cart->nama_user}}</td> 
                    <td>{{ $cart->harga }}</td> 
                    <td style="color: {{ $cart->status == 'Selesai' ? 'green' : ($cart->status == 'Pending' ? 
'red' : 'black') }};"> 
                        {{ $cart->status }} 
                    </td> 
                    <td>{{ $cart->created_at }}</td> 
<td> 
    <a href="{{ route('home') }}" class="btn btn-sm btn-primary">Beranda</a> 
</td> 
<td> 
    <form action="{{ route('transaksi.bayar') }}" method="POST"> 
        @csrf 
        <input type="hidden" name="cart_id" value="{{ $cart->id }}"> 
        <button type="submit" class="btn btn-sm btn-success">Bayar</button> 
    </form> 
</td> 
 
<td> 
        <form action="{{ route('transaksi.clearcart', $cart->id) }}" method="POST"> 
 
        @csrf 
        @method('POST') 
 
        <!-- Cek status transaksi --> 
        @if($cart->status == 'Pending') 
            <!-- Jika status Pending, tampilkan tombol Batal --> 
            <button type="submit" class="btn btn-sm btn-danger me-0">Batal</button> 
        @elseif($cart->status == 'Selesai') 
            <!-- Jika status Selesai, tampilkan tombol Cetak --> 
            <a href="{{ route('transaksi.cetak', $transaksi->id) }}" target="_blank" class="btn btn-sm btn
success me-0">Cetak</a> 
        @endif 
    </form> 
</td> 
 
                            </tr> 
                        @endforeach 
                    </tbody> 
                </table> 
            </div> 
        </div> 
    </div> 
</div> 
@endsection