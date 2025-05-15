@extends('layouts.app')
@section('title', 'Pesan ' . $menu->name)

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Pesan: {{ $menu->name }}</h2>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-5">
                    @if($menu->image)
                        <img src="{{ asset('storage/'.$menu->image) }}" alt="{{ $menu->name }}" class="img-fluid rounded">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                            <span class="text-muted">No Image</span>
                        </div>
                    @endif
                </div>
                <div class="col-md-7">
                    <p><strong>Deskripsi:</strong> {{ $menu->description }}</p>
                    <p><strong>Harga:</strong> Rp{{ number_format($menu->price, 0, ',', '.') }}</p>
                    
                    <form action="{{ route('order.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                        
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Pemesan</label>
                            <input type="text" name="nama" id="nama" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea name="alamat" id="alamat" rows="3" class="form-control" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="catatan" class="form-label">Catatan (opsional)</label>
                            <input type="text" name="catatan" id="catatan" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-primary">Kirim Pesanan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
