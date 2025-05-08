@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Riwayat Transaksi Saya</h3>

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
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksis as $transaksi)
                <tr>
                    <td>{{ $transaksi->user->name ?? '-' }}</td>
                    <td>Rp {{ number_format($transaksi->harga, 0, ',', '.') }}</td>
                    <td class="{{ $transaksi->status == 'Selesai' ? 'text-success' : 'text-danger' }}">
                        {{ $transaksi->status }}
                    </td>
                    <td>{{ $transaksi->created_at->format('d-m-Y H:i') }}</td>
                    <td class="text-center">
                        @if($transaksi->status == 'Disetujui Admin') 
                            {{-- Tombol Bayar --}}
                            <form action="{{ route('transaksi.bayar', $transaksi->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-primary">Bayar</button>
                            </form>
                        @elseif($transaksi->status == 'Pending')
                            {{-- Tulisan Sedang Diproses --}}
                            <span class="text-warning">Sedang Diproses</span>

                            {{-- Tombol Batal --}}
                            <form action="{{ route('transaksi.clear', $transaksi->id) }}" method="POST" class="d-inline ml-2">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger">Batal</button>
                            </form>
                        @elseif($transaksi->status == 'Selesai')
                            <a href="{{ route('transaksi.cetak', $transaksi->id) }}" target="_blank" class="btn btn-sm btn-success">
                                Cetak PDF
                            </a>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">Belum ada transaksi.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
