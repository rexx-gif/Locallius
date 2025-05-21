@extends('layouts.app')

@section('title', 'Locallius - Warung UMKM Digital')

@section('content')
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        /* Hero Section */
        #hero {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('{{ asset("images/bg.jpg") }}') no-repeat center center;
            background-size: cover;
            color: white;
            padding: 120px 0;
            text-align: center;
        }

        #hero .btn {
            transition: all 0.3s ease;
            font-weight: 600;
        }

        #hero .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        /* About Section */
        .about-text {
            max-width: 800px;
            line-height: 1.8;
        }
        
        .about-card {
            background: white;
            height: 100%;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-radius: 8px;
        }
        
        .about-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .about-card-list {
            padding-left: 1.2rem;
            margin-bottom: 0;
        }

        .about-card-title {
            color: #2c3e50;
            font-weight: 600;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        /* Menu Section */
        .menu-card {
            background: linear-gradient(135deg, #2c3e50, #4ca1af);
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
        }
        
        .menu-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }
        
        .menu-image {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .price {
            font-size: 1.25rem;
            font-weight: bold;
            color: #ffc107;
            display: block;
            margin: 10px 0;
        }
        
        .see-details-btn {
            background: linear-gradient(135deg, #2c3e50, #4ca1af);
            color: white;
            border: none;
            transition: all 0.3s ease;
            font-weight: 600;
            padding: 10px 25px;
        }
        
        .see-details-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            color: white;
        }

        /* Promo Section */
        .promo-section {
            background: linear-gradient(135deg, #5b247a, #1e50a2);
            padding: 60px 0;
            margin: 40px 0;
            border-radius: 10px;
            position: relative;
            overflow: hidden;
        }
        
        .promo-carousel {
            position: relative;
            height: 300px;
            overflow: hidden;
            margin: 0 auto;
            max-width: 800px;
        }
        
        .promo-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            padding: 25px;
            text-align: center;
            position: absolute;
            width: 300px;
            left: 50%;
            transform: translateX(-50%);
            top: 0;
            opacity: 0;
            transition: all 0.5s ease;
            display: none;
        }
        
        .promo-card.active {
            opacity: 1;
            transform: translateX(-50%);
            z-index: 2;
            display: block;
        }
        
        .promo-card.prev {
            opacity: 0;
            transform: translateX(-150%);
            z-index: 1;
            display: block;
        }
        
        .promo-card.next {
            opacity: 0;
            transform: translateX(50%);
            z-index: 1;
            display: block;
        }
        
        .card-title {
            font-size: 24px;
            color: #5b247a;
            margin-bottom: 10px;
        }
        
        .card-text {
            color: #555;
            font-size: 16px;
            margin-bottom: 20px;
        }
        
        .promo-value {
            font-size: 32px;
            font-weight: bold;
            color: #e63946;
            margin: 15px 0;
        }
        
        .text-muted {
            display: block;
            font-size: 14px;
            color: #777;
            margin-top: 15px;
        }
        
        .carousel-buttons {
            text-align: center;
            margin-top: 30px;
        }
        
        .carousel-button {
            background: rgba(255,255,255,0.3);
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin: 0 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            color: white;
            font-size: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        
        .carousel-button:hover {
            background: rgba(255,255,255,0.5);
            transform: scale(1.1);
        }
        
        .carousel-indicators {
            text-align: center;
            margin-top: 20px;
        }
        
        .indicator {
            display: inline-block;
            width: 10px;
            height: 10px;
            background: rgba(255,255,255,0.3);
            border-radius: 50%;
            margin: 0 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .indicator.active {
            background: white;
            transform: scale(1.2);
        }

        /* Testimonial Styles */
        .testimonials-container {
            perspective: 1000px;
        }
        
        .testimonial-card {
            background: white;
            height: 100%;
            transition: all 0.5s ease;
            opacity: 0;
            transform: translateY(20px);
            border-radius: 8px;
            display: flex;
            flex-direction: column;
        }
        
        .testimonial-card.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Different animation delays for each card */
        .testimonial-card:nth-child(1) {
            transition-delay: 0.2s;
        }
        
        .testimonial-card:nth-child(2) {
            transition-delay: 0.4s;
        }
        
        .testimonial-card:nth-child(3) {
            transition-delay: 0.6s;
        }
        
        .testimonial-card:hover {
            transform: translateY(-5px) rotateX(5deg);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }
        
        .testimonial-rating {
            color: #ffc107;
            font-size: 1.1rem;
        }
        
        .testimonial-text {
            font-style: italic;
            color: #555;
            margin-bottom: 1rem;
            flex-grow: 1;
        }
        
        .testimonial-author {
            display: flex;
            align-items: center;
        }
        
        .testimonial-author img {
            object-fit: cover;
            box-shadow: 0 3px 8px rgba(0,0,0,0.1);
        }

        /* Section titles */
        .section-title {
            position: relative;
            display: inline-block;
            padding-bottom: 10px;
            margin-bottom: 30px;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: linear-gradient(to right, #2c3e50, #4ca1af);
        }

        /* Additional responsive styles */
        @media (max-width: 768px) {
            .promo-card {
                width: 90%;
                max-width: 300px;
            }
            
            #hero {
                padding: 80px 0;
            }
            
            .promo-carousel {
                height: 350px;
            }
            
            .section-title::after {
                width: 60px;
            }
        }

        /* Additional animation for better UX */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .fade-in-up {
            animation: fadeInUp 0.5s ease forwards;
        }
    </style>
</head>

{{-- Hero Section --}}
<section id="hero" data-aos="fade-up">
    <img src="/asset/images/bg.png" alt="">
    <div class="container">
        <h1 class="display-5 fw-bold mb-3">Local Food, Modern Way</h1>
        <p class="lead mb-4">Jelajahi menu dari warung-warung lokal terbaik di sekitarmu. <br> Pesan makanan UMKM favoritmu langsung dari genggaman.</p>
        <a href="{{ url('/menu') }}" class="btn btn-light btn-lg mt-3 px-4 shadow-sm">Lihat Menu Kami</a>
    </div>
</section>

{{-- About Section --}}
<section id="about" data-aos="fade-in" class="about-section py-5 bg-light">
    <div class="container text-center">
        <h2 class="section-title mb-4">Tentang Kami</h2>
        <p class="about-text mx-auto mb-5">
            Locallius hadir untuk menghubungkan Anda dengan warung-warung UMKM terbaik di sekitar.
            Kami percaya bahwa setiap produk lokal punya cerita dan kualitas yang patut dibanggakan.
            Bersama Locallius, nikmati pengalaman kuliner autentik sambil mendukung usaha kecil Indonesia.
        </p>

        <div class="row justify-content-center text-start">
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="about-card p-4 shadow-sm">
                    <h3 class="about-card-title">Visi</h3>
                    <p class="about-card-text">Menjadi platform utama yang memajukan UMKM kuliner lokal melalui teknologi yang mudah diakses.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="about-card p-4 shadow-sm">
                    <h3 class="about-card-title">Misi</h3>
                    <p class="about-card-text">Menghubungkan pelanggan dengan produk lokal berkualitas, serta membantu UMKM berkembang secara berkelanjutan.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="about-card p-4 shadow-sm">
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
<section id="menu" class="container py-5">
    <h2 class="text-center section-title">Menu Kami</h2>
    <div class="row g-4 justify-content-center">
        @foreach($menus as $menu)
        <div class="col-md-3 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
            <div class="card menu-card text-center text-white p-3 h-100">
                <img src="{{ asset($menu->image) }}" class="menu-image mx-auto d-block mb-3" alt="{{ $menu->name }}">
                <h5 class="card-title mb-2">{{ $menu->name }}</h5>
                <p class="card-text mb-3">{{ $menu->description }}</p>
                <span class="price">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
            </div>
        </div>
        @endforeach
    </div>
    
    <div class="text-center mt-5" data-aos="fade-up">
        <a href="{{ route('menu') }}" class="btn see-details-btn btn-lg shadow">Lihat Semua Menu</a>
    </div>
</section>

{{-- Promo Section --}}
<section id="promo" class="promo-section" data-aos="fade-up">
    <div class="container">
        <h2 class="text-center text-white mb-5">Promo Spesial Hari Ini</h2>
        
        <div class="promo-carousel">
            @foreach($promos as $index => $promo)
            <div class="promo-card {{ $index == 0 ? 'active' : '' }}">
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
            @endforeach
        </div>
        
        <div class="carousel-buttons">
            <button class="carousel-button prev-button"><i class="fas fa-chevron-left"></i></button>
            <button class="carousel-button next-button"><i class="fas fa-chevron-right"></i></button>
        </div>
        
        <div class="carousel-indicators">
            <!-- Indicators will be added by JavaScript -->
        </div>
    </div>
</section>

{{-- Testimonial Section --}}
<section id="testimonials" class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center section-title" data-aos="fade-up">Apa Kata Pelanggan Kami</h2>
        <div class="row testimonials-container">
            <div class="col-md-4 mb-4">
                <div class="testimonial-card p-4 shadow-sm">
                    <div class="testimonial-rating mb-3">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="testimonial-text">"Makanannya enak dan harga terjangkau. Pengiriman cepat dan packing rapi!"</p>
                    <div class="testimonial-author mt-3 d-flex align-items-center">
                        <img src="https://randomuser.me/api/portraits/women/32.jpg" alt="Customer" class="rounded-circle me-2" width="40" height="40">
                        <div>
                            <h6 class="mb-0">Sarah Wijaya</h6>
                            <small class="text-muted">Pelanggan sejak 2022</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="testimonial-card p-4 shadow-sm">
                    <div class="testimonial-rating mb-3">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <p class="testimonial-text">"Suka banget sama nasi padang warung Bu Siti, rasanya autentik banget!"</p>
                    <div class="testimonial-author mt-3 d-flex align-items-center">
                        <img src="https://randomuser.me/api/portraits/men/45.jpg" alt="Customer" class="rounded-circle me-2" width="40" height="40">
                        <div>
                            <h6 class="mb-0">Budi Santoso</h6>
                            <small class="text-muted">Pelanggan sejak 2023</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="testimonial-card p-4 shadow-sm">
                    <div class="testimonial-rating mb-3">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="testimonial-text">"Dengan Locallius, saya bisa menemukan warung-warung tersembunyi yang enak!"</p>
                    <div class="testimonial-author mt-3 d-flex align-items-center">
                        <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Customer" class="rounded-circle me-2" width="40" height="40">
                        <div>
                            <h6 class="mb-0">Dewi Lestari</h6>
                            <small class="text-muted">Pelanggan sejak 2021</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CTA Section --}}
<section id="cta" class="bg-gradient py-5 text-center text-black" data-aos="fade-up" style="background: linear-gradient(135deg, #2c3e50, #4ca1af);">
    <div class="container py-4">
        <h2 class="mb-4">Siap Mencoba Locallius?</h2>
        <p class="lead mb-4">Nikmati kemudahan memesan makanan lokal favorit Anda dan dukung UMKM di sekitar.</p>
        <div class="d-flex justify-content-center gap-3">
            <a href="{{ route('customer.register') }}" class="btn btn-light btn-lg px-4">Daftar Sekarang</a>
           <a href="{{ route('menu') }}" class="btn btn-light btn-lg px-4">Lihat Menu</a>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    // Initialize AOS animation
    AOS.init({
        duration: 800,
        once: true,
        easing: 'ease-in-out',
        offset: 100
    });

    // Make sure AOS is refreshed on window resize
    window.addEventListener('resize', function() {
        AOS.refresh();
    });

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const targetElement = document.querySelector(this.getAttribute('href'));
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });

    // Initialize the promo cards
    const promoCards = document.querySelectorAll('.promo-card');

    // Testimonial Animation with Intersection Observer
    const testimonialCards = document.querySelectorAll('.testimonial-card');
    const testimonialObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                // Unobserve after animation is triggered
                testimonialObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.2 });

    testimonialCards.forEach(card => {
        testimonialObserver.observe(card);
    });

    // Promo Carousel
    const carousel = document.querySelector('.promo-carousel');
    const cards = Array.from(document.querySelectorAll('.promo-card'));
    const prevButton = document.querySelector('.prev-button');
    const nextButton = document.querySelector('.next-button');
    const indicatorsContainer = document.querySelector('.carousel-indicators');

    if (cards.length > 0 && carousel) {
        let currentIndex = 0;
        let autoSlideTimer;

        // Create indicators
        indicatorsContainer.innerHTML = ''; // Clear any existing indicators
        cards.forEach((_, index) => {
            const indicator = document.createElement('span');
            indicator.classList.add('indicator');
            if (index === 0) indicator.classList.add('active');
            indicator.addEventListener('click', () => goToSlide(index));
            indicatorsContainer.appendChild(indicator);
        });

        const indicators = Array.from(document.querySelectorAll('.indicator'));

        function updateCarousel() {
            cards.forEach((card, index) => {
                card.classList.remove('active', 'prev', 'next');
                
                if (index === currentIndex) {
                    card.classList.add('active');
                } else if (index === getPrevIndex()) {
                    card.classList.add('prev');
                } else if (index === getNextIndex()) {
                    card.classList.add('next');
                }
            });

            indicators.forEach((indicator, index) => {
                indicator.classList.toggle('active', index === currentIndex);
            });
        }

        function goToSlide(index) {
            currentIndex = (index + cards.length) % cards.length;
            updateCarousel();
        }

        function getPrevIndex() {
            return (currentIndex - 1 + cards.length) % cards.length;
        }

        function getNextIndex() {
            return (currentIndex + 1) % cards.length;
        }

        function startAutoSlide() {
            clearInterval(autoSlideTimer); // Clear any existing timer
            autoSlideTimer = setInterval(() => {
                goToSlide(currentIndex + 1);
            }, 5000);
        }

        // Initialize carousel
        updateCarousel();
        startAutoSlide();

        // Event listeners
        prevButton.addEventListener('click', () => {
            goToSlide(currentIndex - 1);
            startAutoSlide(); // Reset timer on user interaction
        });

        nextButton.addEventListener('click', () => {
            goToSlide(currentIndex + 1);
            startAutoSlide(); // Reset timer on user interaction
        });
        
        // Pause autoSlide on hover
        carousel.addEventListener('mouseenter', () => {
            clearInterval(autoSlideTimer);
        });
        
        carousel.addEventListener('mouseleave', () => {
            startAutoSlide();
        });
    }
    
    // Ensure testimonial cards height are equal
    function equalizeTestimonialCardHeight() {
        let maxHeight = 0;
        const testimonialTexts = document.querySelectorAll('.testimonial-text');
        
        // Reset heights first
        testimonialTexts.forEach(text => {
            text.style.height = 'auto';
        });
        
        // Find the tallest
        testimonialTexts.forEach(text => {
            if (text.offsetHeight > maxHeight) {
                maxHeight = text.offsetHeight;
            }
        });
        
        // Set all to the tallest height
        if (maxHeight > 0) {
            testimonialTexts.forEach(text => {
                text.style.height = maxHeight + 'px';
            });
        }
    }
    
    // Call once on load and on window resize
    equalizeTestimonialCardHeight();
    window.addEventListener('resize', equalizeTestimonialCardHeight);
});
</script>
@endpush