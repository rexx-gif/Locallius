@extends('layouts.menu')

@section('title', 'Daftar Menu')

@push('styles')
<style>
    /* Card styling */
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

    /* Tombol Pesan Sekarang */
    .btn-pesan {
        background-color: #ff7b00;
        color: #000;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        width: 100%;            /* penuh di container */
        max-width: 500px;       /* maksimal lebar */
        border-radius: 16px;
        text-align: center;
        padding: 12px 0;
        display: inline-block;
        box-shadow: 0 3px 6px rgba(0,0,0,0.1);
        cursor: pointer;
        text-decoration: none;  /* hilangkan underline */
    }

    .btn-pesan:hover {
        background-color: #e56e00;
        color: #fff;
        box-shadow: 0 5px 12px rgba(229, 110, 0, 0.5);
    }

    /* Tombol keranjang */
    .keranjang button {
        width: 70px;
        height: 50px;
        border-radius: 16px;
        background-color: #ff7b00;
        color: #000;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .keranjang button:hover {
        background-color: #e56e00;
        color: #fff;
        box-shadow: 0 5px 12px rgba(229, 110, 0, 0.5);
    }

    /* Container tombol */
    .container-button {
        display: flex;
        gap: 16px;
        /* flex-wrap: wrap; */
        align-items: center;
        justify-content: flex-start;
        margin-top: auto; /* agar tombol berada di bawah card-body */
    }

    /* Responsif untuk layar kecil */
    @media (max-width: 576px) {
        .container-button {
            flex-direction: column;
            gap: 12px;
        }

        .btn-pesan,
        .keranjang button {
            width: 100%;
            max-width: none;
        }
    }
</style>
@endpush

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center">Daftar Menu</h2>
    <div class="row">
        @forelse($menus as $menu)
            <div class="col-md-4 mb-4">
                <div class="card h-100 d-flex flex-column">
                    @if($menu->image)
                        <img src="{{ asset('storage/'.$menu->image) }}" class="card-img-top" alt="{{ $menu->name }}">
                    @else
                        <div class="card-img-top bg-light text-center d-flex align-items-center justify-content-center" style="height: 200px;">
                            <span class="text-muted">No Image</span>
                        </div>
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $menu->name }}</h5>
                        <p class="card-text">{{ $menu->description }}</p>
                        <p class="card-text fw-bold">Rp{{ number_format($menu->price, 0, ',', '.') }}</p>
                        <div class="container-button">
                            <a href="{{ route('order.show', $menu->id) }}" class="btn-pesan">
                                <i class="fas fa-plus me-1"></i> Pesan Sekarang
                            </a>
                            {{-- <div class="keranjang">
                                <button 
                                    class="btn btn-pesan add-to-cart-btn" 
                                    data-id="{{ $menu->id }}" 
                                    data-name="{{ $menu->name }}" 
                                    data-price="{{ $menu->price }}"
                                    title="Tambah ke Keranjang"
                                >
                                    <i class="fas fa-shopping-cart"></i>
                                </button> --}}
                            {{-- </div> --}}
                        </div>
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
