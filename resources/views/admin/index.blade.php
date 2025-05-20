@extends('layouts.menu') {{-- ganti sesuai layout --}}
@section('title', 'Riwayat Transaksi')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Riwayat Pesanan</h2>

    {{-- Form pencarian --}}
    <form method="GET" action="{{ route('order.history') }}" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Cari nama pemesan..." value="{{ request('search') }}">
            <button class="btn btn-primary" type="submit">Cari</button>
        </div>
    </form>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Nama Pemesan</th>
                <th>Menu Dipesan</th>
                <th>Total Harga</th>
                <th>Tanggal Pembelian</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $order->name }}</td>
                    <td>{{ $order->menu->name ?? '-' }}</td>
                    <td>Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
                    <td>{{ $order->created_at->format('d-m-Y H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Belum ada pesanan</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
