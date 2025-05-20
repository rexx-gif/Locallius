<head>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" />

</head>
@extends('layouts.app')

@section('title', 'Locallius - Warung UMKM Digital')

@section('content')
{{-- Hero Section --}}
    <section id="hero" data-aos="fade-up">
        <div class="container">
            <h1 class="display-5 fw-bold">Local Food, Modern Way</h1>
            <p class="lead">Jelajahi menu dari warung-warung lokal terbaik di sekitarmu. <br> Pesan makanan UMKM favoritmu langsung dari genggaman.</p>
            <a href="{{ url('/menu') }}" class="btn btn-light btn-lg mt-3">Lihat Menu Kami</a>
        </div>
    </section>

    {{-- About Section --}}
    <section id="about" data-aos="fade-in" class="about-section py-5 bg-light">
    <div class="container text-center">
        <h1 class="section-title mb-4">Tentang Kami</h1>
        <p class="about-text mx-auto mb-5">
            Locallius hadir untuk menghubungkan Anda dengan warung-warung UMKM terbaik di sekitar.
            Kami percaya bahwa setiap produk lokal punya cerita dan kualitas yang patut dibanggakan.
            Bersama Locallius, nikmati pengalaman kuliner autentik sambil mendukung usaha kecil Indonesia.
        </p>

        <div class="row justify-content-center text-start">
            <div class="col-md-4 mb-4">
                <div class="about-card p-4 shadow-sm rounded">
                    <h3 class="about-card-title">Visi</h3>
                    <p class="about-card-text">Menjadi platform utama yang memajukan UMKM kuliner lokal melalui teknologi yang mudah diakses.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="about-card p-4 shadow-sm rounded">
                    <h3 class="about-card-title">Misi</h3>
                    <p class="about-card-text">Menghubungkan pelanggan dengan produk lokal berkualitas, serta membantu UMKM berkembang secara berkelanjutan.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="about-card p-4 shadow-sm rounded">
                    <h3 class="about-card-title">Nilai Kami</h3>
                    <ul class="about-card-list">
                        <li>Autentik & Berkualitas</li>
                        <li>Dukungan untuk UMKM</li>
                        <li>Inovasi dan Kemudahan</li>
                        <li>Kepercayaan dan Keberlanjutan</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

    
    {{-- Menu Section --}}
    <section id="menu" class="container py-5" data-aos="fade-up">
        <h2 class="text-center mb-4">Menu Kami</h2>
        <div class="row g-4 justify-content-center">
            @foreach($menus as $menu)
            <div class="col-md-3">
                <div class="card menu-card text-center text-white p-3">
                    <img src="{{ asset($menu->image) }}" class="menu-image mx-auto d-block mb-2" alt="{{ $menu->name }}">
                    <h5 class="card-title">{{ $menu->name }}</h5>
                    <p class="card-text">{{ $menu->description }}</p>
                    <span class="price">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-4">
            <a href="{{ route('menu') }}" class="btn see-details-btn btn-lg">Lihat Semua Menu</a>
        </div>
    </section>
    
    {{-- Promo Section --}}
    {{-- Promo Section --}}
<section id="promo" class="promo-section" data-aos="fade-up">
    <div class="container">
        <h2 class="text-center text-white mb-4">Promo Spesial Hari Ini</h2>
        <div class="row">
            @foreach($promos as $promo)
            <div class="col-md-4 mb-4">
                <div class="card promo-card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $promo->code }}</h5>
                        <p class="card-text">{{ $promo->description }}</p>
                        <div class="promo-value">
                            @if($promo->type === 'percentage')
                                {{ $promo->value }}% OFF
                            @else
                                Rp{{ number_format($promo->value, 0, ',', '.') }} OFF
                            @endif
                        </div>
                        <small class="text-muted">
                            Sisa kuota: {{ $promo->max_uses - $promo->uses }} dari {{ $promo->max_uses }}
                        </small>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

    {{-- Testimonial Section --}}
    <section id="testimonials" data-aos="fade-up">
        <div class="container">
            <h2 class="text-center mb-5">Apa Kata Pelanggan Kami</h2>
            <div class="testimonial-slider">
                
            </div>
        </div>
    </section>
    @endsection

@push('scripts')
<script src="asset{{ 'js/app.js' }}"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    // JavaScript for animations and interactive elements
    document.addEventListener('DOMContentLoaded', function () {
        AOS.init({
            duration: 500,
            once: false
        });

        // Optional: jika konten halaman diubah secara dinamis (pakai AJAX/Inertia)
        setTimeout(() => {
            AOS.refresh();
        }, 100); // kasih delay sedikit agar elemen sempat masuk ke DOM
    });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // You can add more interactive elements here
</script>
@endpush