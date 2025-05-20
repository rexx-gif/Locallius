@extends('layouts.menu')
<div class="d-flex">
    <!-- Sidebar Keranjang -->
    <div style="width: 300px; border-right: 1px solid #ddd; padding: 15px;">
        <h5>Keranjang Anda</h5>

        @php
            $cart = session('cart', []);
        @endphp

        @if(count($cart) > 0)
            <ul class="list-group mb-3">
                @foreach($cart as $item)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $item['name'] }} x {{ $item['quantity'] }}
                        <span>Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
                    </li>
                @endforeach
            </ul>
            <a href="{{ route('cart.index') }}" class="btn btn-primary w-100">Lihat Keranjang</a>
        @else
            <p>Keranjang kosong</p>
        @endif
    </div>

    <!-- Konten Halaman Menu -->
    <div class="flex-grow-1 p-3">
        {{-- Konten halaman menu kamu di sini --}}
        @yield('menu-content')
    </div>
</div>
