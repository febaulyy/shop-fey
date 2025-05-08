@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Manajemen Transaksi</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Nama Pembeli</th>
                <th>Harga</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th class="text-center" colspan="2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksis as $transaksi)
                <tr>
                    <td>{{ $transaksi->user->name }}</td>
                    <td>Rp {{ number_format($transaksi->harga, 0, ',', '.') }}</td>
                    <td class="{{ $transaksi->status == 'Selesai' ? 'text-success' : 'text-danger' }}">
                        {{ $transaksi->status }}
                    </td>
                    <td>{{ $transaksi->created_at->format('d-m-Y H:i') }}</td>
                    <td class="text-center">
                        <form action="{{ route('transaksi.hapus', $transaksi->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                    <td class="text-center">
                        @if($transaksi->status == 'Pending')
                            <form action="{{ route('transaksi.konfirmasi', $transaksi->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success">Konfirmasi</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center">Tidak ada data transaksi.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
