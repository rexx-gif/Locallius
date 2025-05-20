<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Locallius - Warung UMKM')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
    <!-- Welcome Screen -->
<div id="welcome-screen">
  <h1>Welcome to <span>Locallius</span> </h1>
</div>
 <audio id="dingSound" src="https://cdn.pixabay.com/audio/2022/03/15/audio_7b038e232d.mp3" preload="auto"></audio>

    {{-- Navbar --}}
    <div class="fixed-top" data-aos="fade-up">
        <div class="navbar-container" data-aos="fade-up">
            <div class="email-info">
                <p>
                    <a href="mailto:info@locallius.com">
                        <i class="fas fa-envelope"></i> info@locallius.com || 
                        <i class="fas fa-phone"></i> +62-838-4728-8793
                    </a>
                </p>
            </div>
            <a class="navbar-brand fw-bold" href="#">
                Localli<img src="{{ asset('images/logonopng.png') }}" alt="Logo" class="logo-icon">s
            </a>
        </div>

        <nav class="navbar navbar-expand-lg navbar-light shadow-sm">
            <div class="container justify-content-center">
                <div class="social-logo">
                    <span class="social-icon"><a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a></span>
                    <span class="social-icon"><a href="#" target="_blank"><i class="fab fa-instagram"></i></a></span>
                    <span class="social-icon"><a href="#" target="_blank"><i class="fab fa-whatsapp"></i></a></span>
                    <span class="social-icon"><a href="#" target="_blank"><i class="fab fa-telegram"></i></a></span>
                </div>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a href="#hero" class="nav-link">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="#about">Tentang Kami</a></li>
                        <li class="nav-item"><a class="nav-link" href="#menu">Menu</a></li>
                        <li class="nav-item"><a class="nav-link" href="#promo">Promo Hari Ini</a></li>
                        <li class="nav-item"><a class="nav-link" href="#testimonials">Review</a></li>
                        <li class="nav-item"><a href="#partners" class="nav-link">Partner</a></li>
                        <li class="nav-item"><a class="nav-link" href="#contact">Kontak</a></li>
                        <li class="nav-item"><a href="/login" class="nav-link">Login</a></li>
                        <li class="nav-item"><a href="{{ route('customer.register') }}" class="nav-link">Register</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <main style="padding-top: 70px;">
        @yield('content')
    </main>

    <section id="partners" class="py-5" style="background-color: #000;">
    <div class="container" data-aos="fade-up">
        <h2 class="text-center mb-5" style="color: #ff7b00;">PARTNER KAMI</h2>
        <div class="d-flex flex-wrap justify-content-center align-items-center gap-3">
            <div class="partner-logo">
                <h5>Head Chef</h5>
                <img src="{{ asset('asset/partner/partner.png') }}" alt="Partner 1" class="img-fluid grayscale-hover">
                <h3>Adam</h3>
            </div>
            <div class="partner-logo">
                <h5>Sous Chef</h5>
                <img src="{{ asset('asset/partner/partner.png') }}" alt="Partner 2" class="img-fluid grayscale-hover">
                <h3>Adam</h3>
            </div>
            <div class="partner-logo">
                <h5>Pastry Chef</h5>
                <img src="{{ asset('asset/partner/partner.png') }}" alt="Partner 3" class="img-fluid grayscale-hover">
                <h3>Adam</h3>
            </div>
            <div class="partner-logo">
                <h5>Fish Chef</h5>
                <img src="{{ asset('asset/partner/partner.png') }}" alt="Partner 4" class="img-fluid grayscale-hover">
                <h3>Adam</h3>
            </div>
            <div class="partner-logo">
                <h5>Prep Chef</h5>
                <img src="{{ asset('asset/partner/partner.png') }}" alt="Partner 5" class="img-fluid grayscale-hover">
                <h3>Adam</h3>
            </div>
            <!-- Tambah partner lain di sini -->
        </div>
    </div>
</section>


    <section id="why-us" class="py-5" style="background-color: #111;">
    <div class="container" data-aos="fade-up">
        <h2 class="text-center mb-5" style="color: #ff7b00;">KENAPA MEMILIH LOCALLIUS?</h2>
        <div class="row text-white">
            <div class="col-md-4 mb-4">
                <div class="card bg-dark h-100 border-0 shadow" style="border-left: 4px solid #ff7b00;">
                    <div class="card-body text-center">
                        <i class="fas fa-utensils fa-3x mb-3" style="color: #ff7b00;"></i>
                        <h5 class="card-title" style="color: #ff7b00;">Masakan Lezat</h5>
                        <p class="card-text text-light">Kami menyajikan menu favorit dengan rasa khas lokal yang menggugah selera.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card bg-dark h-100 border-0 shadow" style="border-left: 4px solid #ff7b00;">
                    <div class="card-body text-center">
                        <i class="fas fa-clock fa-3x mb-3" style="color: #ff7b00;"></i>
                        <h5 class="card-title" style="color: #ff7b00;">Cepat & Tepat</h5>
                        <p class="card-text text-light">Pesanan Anda akan kami siapkan dan antar dengan cepat dan tepat waktu.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card bg-dark h-100 border-0 shadow" style="border-left: 4px solid #ff7b00;">
                    <div class="card-body text-center">
                        <i class="fas fa-hand-holding-heart fa-3x mb-3" style="color: #ff7b00;"></i>
                        <h5 class="card-title" style="color: #ff7b00;">Dukung UMKM</h5>
                        <p class="card-text text-light">Dengan membeli dari Locallius, Anda turut memberdayakan warung-warung lokal Indonesia.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


    <footer class="bg-dark text-white py-5">
        <section id="contact" class="contact-section py-5" data-aos="fade-up" style="background-color: #000;">
            <div class="container">
                <h2 class="text-center mb-5" style="color: #ff7b00;">GET IN TOUCH</h2>
                <div class="row">
                    <div class="col-md-6 mb-4 mb-md-0">
                        <div class="contact-info p-4" style="background-color: #111; border-radius: 8px; border-left: 4px solid #ff7b00;">
                            <h3 style="color: #ff7b00; border-bottom: 2px solid #ff7b00; padding-bottom: 10px;">CONTACT INFO</h3>
                            <ul class="list-unstyled mt-4">
                                <li class="mb-3 d-flex align-items-center">
                                    <i class="fas fa-map-marker-alt me-3" style="color: #ff7b00;"></i>
                                    <span style="color: #ccc;">Jl. Contoh No. 123, Kota Anda</span>
                                </li>
                                <li class="mb-3 d-flex align-items-center">
                                    <i class="fas fa-phone me-3" style="color: #ff7b00;"></i>
                                    <span style="color: #ccc;">+62 123 4567 890</span>
                                </li>
                                <li class="mb-3 d-flex align-items-center">
                                    <i class="fas fa-envelope me-3" style="color: #ff7b00;"></i>
                                    <span style="color: #ccc;">hello@locallius.com</span>
                                </li>
                                <li class="mb-3 d-flex align-items-center">
                                    <i class="fas fa-clock me-3" style="color: #ff7b00;"></i>
                                    <span style="color: #ccc;">Senin - Minggu: 08.00 - 22.00 WIB</span>
                                </li>
                            </ul>
                            <div class="text-center mt-4 pt-3" style="border-top: 1px solid #333;">
                                <h5 class="mb-4" style="color: #ff7b00;">FOLLOW US</h5>
                                <div class="social-icons-container">
                                    <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                                    <a href="#" class="social-icon"><i class="fab fa-facebook"></i></a>
                                    <a href="#" class="social-icon"><i class="fab fa-whatsapp"></i></a>
                                    <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <form action="{{ route('contact.send') }}" method="POST" class="contact-form p-4" style="background-color: #111; border-radius: 8px; border-left: 4px solid #ff7b00;">
                            @csrf
                            <div class="mb-3">
                                <input type="text" name="name" class="form-control bg-dark text-white border-dark" placeholder="Your Name" required>
                            </div>
                            <div class="mb-3">
                                <input type="email" name="email" class="form-control bg-dark text-white border-dark" placeholder="Your Email" required>
                            </div>
                            <div class="mb-3">
                                <input type="text" name="subject" class="form-control bg-dark text-white border-dark" placeholder="Subject">
                            </div>
                            <div class="mb-3">
                                <textarea name="message" class="form-control bg-dark text-white border-dark" rows="5" placeholder="Your Message" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-lg w-100" style="background-color: #ff7b00; color: #000; font-weight: 600; border: none;">
                                SEND MESSAGE <i class="fas fa-paper-plane ms-2"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    
    @stack('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof AOS !== 'undefined') {
                AOS.init({ duration: 500, once: false });
            }
        });

        window.addEventListener("scroll", function () {
    const navbar = document.querySelector(".navbar");
    const navbarContainer = document.querySelector(".navbar-container");

    if (window.scrollY > 0) {
        // Sembunyikan .fixed-top dan tambahkan class transparent ke navbar
        navbarContainer.style.visibility = "hidden";
        navbar.style.position = 'relative';
        navbar.style.bottom = '50px';
        navbar.style.borderRadius = '16px';
        navbar.style.margin = '15px'
        navbar.classList.add("transparent");
    } else {
        // Tampilkan kembali .fixed-top saat di atas
        navbarContainer.style.visibility = "visible";
        navbar.style.position = 'relative';
        navbar.style.bottom = '0px';
        navbar.style.borderRadius = '0px';
        navbar.style.margin = '0px'
        navbar.classList.remove("transparent");
    }})

     setTimeout(() => {
    const welcomeScreen = document.getElementById('welcome-screen');
    welcomeScreen.style.display = 'none';
  }, 4000); // waktu total animasi (2s masuk + 2s tampil)
    </script>
</body>
</html>
