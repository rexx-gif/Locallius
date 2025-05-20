@extends('layouts.menu')
@section('title', 'Struk Pesanan')

@section('content')
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-body">
            <h3 class="text-center text-success">✅ Pesanan Berhasil!</h3>
            <hr>
            <p><strong>Nama Pemesan:</strong> {{ $order->name }}</p>
            <p><strong>Menu:</strong> {{ $menu->name }}</p>
            <p><strong>Harga:</strong> Rp{{ number_format($order->total_price, 0, ',', '.') }}</p>
            <p><strong>Alamat:</strong> {{ $order->address }}</p>
            <p><strong>Telepon:</strong> {{ $order->phone }}</p>
            <p><strong>Catatan:</strong> {{ $order->notes ?: '-' }}</p>
            <p><strong>Waktu Pemesanan:</strong> {{ $order->created_at->format('d-m-Y H:i') }}</p>
            <div class="text-center mt-4">
                <a href="{{ route('home') }}" class="btn btn-primary">Kembali ke Menu</a>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
        title: 'Berhasil!',
        text: 'Pesanan Anda telah dikirim!',
        icon: 'success',
        confirmButtonText: 'OK'
    });
</script>
@endpush
