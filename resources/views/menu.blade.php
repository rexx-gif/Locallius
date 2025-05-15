@extends('layouts.app') {{-- atau layouts.landing kalau beda --}}
@section('title', 'Daftar Menu')

@push('styles')
<style>
    .card {
        border: none;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }

    .card-img-top {
        border-bottom: 1px solid #eee;
        height: 200px;
        object-fit: cover;
    }

    .card-title {
        color: #ff7b00;
        font-weight: 700;
    }

    .card-text {
        font-size: 0.95rem;
        color: #444;
    }

    .fw-bold {
        color: #000;
    }

    .text-muted {
        color: #888 !important;
    }

    .btn-pesan {
        background-color: #ff7b00;
        color: #000;
        font-weight: 600;
        transition: all 0.3s;
        border: none;
    }

    .btn-pesan:hover {
        background-color: #e56e00;
        color: #fff;
    }
</style>
@endpush

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center" data-aos="fade-down">Daftar Menu</h2>
    <div class="row">
        @forelse($menus as $menu)
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="card h-100">
                    @if($menu->image)
                        <img src="{{ asset('storage/'.$menu->image) }}" class="card-img-top" alt="{{ $menu->name }}">
                    @else
                        <div class="card-img-top bg-light text-center d-flex align-items-center justify-content-center">
                            <span class="text-muted">No Image</span>
                        </div>
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $menu->name }}</h5>
                        <p class="card-text">{{ $menu->description }}</p>
                        <p class="card-text fw-bold">Rp{{ number_format($menu->price, 0, ',', '.') }}</p>
                        {{-- Optional button --}}
                        <a href="{{ route('order.show', $menu->id) }}" class="btn btn-pesan mt-auto">
                            <i class="fas fa-shopping-cart me-1"></i> Pesan Sekarang
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <p class="text-muted">Belum ada menu tersedia.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
