<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Locallius')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    @stack('styles')

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f9f9;
            color: #333;
        }

        nav{
            position: relative;
            bottom: 170%;
            width:100%;
            height: 90px;
        }

        nav.navbar {
            background-color: #ff7b00;
        }

        .navbar-brand, .nav-link {
            color: #fff !important;
            font-weight: 600;
        }

        footer {
            background-color: #ff7b00;
            color: #fff;
            text-align: center;
            padding: 1rem 0;
            margin-top: 3rem;
        }

        .cart-sidebar {
            position: fixed;
            top: 0;
            right: -350px;
            width: 350px;
            height: 100vh;
            overflow-y: auto;
            transition: right 0.3s ease;
            z-index: 1050;
            box-shadow: -2px 0 8px rgba(0,0,0,0.2);
        }

        .cart-sidebar.show {
            right: 0;
        }

        #cartOverlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.3);
            z-index: 1040;
        }
    </style>
</head>
<body>
    <div id="cartOverlay"></div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">Locallius</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('menu') }}">Menu</a>
                    </li>
                    {{-- <li class="nav-item">
                        <button id="cartToggleBtn" class="btn btn-outline-light position-relative">
                            <i class="fa fa-shopping-cart"></i>
                            @php
                                $cart = session('cart', []);
                                $cartCount = array_sum(array_column($cart, 'quantity'));
                            @endphp
                            @if($cartCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ $cartCount }}
                                    <span class="visually-hidden">items in cart</span>
                                </span>
                            @endif
                        </button>
                    </li> --}}
                </ul>
            </div>
        </div>
    </nav>

    <!-- Sidebar Cart -->
    {{-- <div id="cartSidebar" class="cart-sidebar bg-white shadow">
        <div class="cart-header p-3 d-flex justify-content-between align-items-center border-bottom">
            <h5 class="m-0">Keranjang Anda</h5>
            <button id="cartCloseBtn" class="btn btn-sm btn-danger">&times;</button>
        </div>
        <div class="cart-body p-3">
            @if(count($cart) > 0)
                <ul class="list-group">
                    @php $total = 0; @endphp
                    @foreach($cart as $item)
                        @php $subtotal = $item['price'] * $item['quantity']; @endphp
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $item['name'] }}</strong><br>
                                Rp{{ number_format($item['price'], 0, ',', '.') }} x {{ $item['quantity'] }}
                            </div>
                            <div>
                                Rp{{ number_format($subtotal, 0, ',', '.') }}
                            </div>
                        </li>
                        @php $total += $subtotal; @endphp
                    @endforeach
                </ul>
                <div class="cart-footer mt-3">
                     <h6>Total: Rp{{ number_format($total, 0, ',', '.') }}</h6>
                <a href="{{ route('order.show', array_key_first($cart)) }}" class="btn btn-primary w-100">
                    <i class="fas fa-shopping-bag me-2"></i> Pesan Sekarang
                </a>
            </div>
        @else
            <p>Keranjang kosong.</p>
        @endif
    </div>
</div> --}}

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p>&copy; {{ date('Y') }} Locallius. All rights reserved.</p>
        </div>
    </footer>

    <!-- JS Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
        
        document.addEventListener('DOMContentLoaded', () => {
            const cartSidebar = document.getElementById('cartSidebar');
            const cartToggleBtn = document.getElementById('cartToggleBtn');
            const cartCloseBtn = document.getElementById('cartCloseBtn');
            const cartOverlay = document.getElementById('cartOverlay');

            // Toggle cart sidebar
            cartToggleBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                cartSidebar.classList.add('show');
                cartOverlay.style.display = 'block';
            });

            cartCloseBtn.addEventListener('click', () => {
                cartSidebar.classList.remove('show');
                cartOverlay.style.display = 'none';
            });

            // Close when clicking outside
            window.addEventListener('click', (e) => {
                if (!cartSidebar.contains(e.target) && !cartToggleBtn.contains(e.target)) {
                    cartSidebar.classList.remove('show');
                    cartOverlay.style.display = 'none';
                }
            });

            // Add to cart functionality
            document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
                btn.addEventListener('click', async (e) => {
                    e.preventDefault();
                    const id = btn.dataset.id;

                    try {
                        const response = await fetch(`/cart/add/${id}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
                            }
                        });

                        if (!response.ok) {
                            throw new Error('Gagal menambahkan ke keranjang');
                        }

                        const result = await response.json();

                        if (cartSidebar && result.html) {
                            cartSidebar.innerHTML = result.html;
                            cartSidebar.classList.add('show');
                            cartOverlay.style.display = 'block';
                        }

                        // Update badge
                        let badge = cartToggleBtn.querySelector('.badge');
                        if (badge) {
                            badge.textContent = result.total_items;
                        } else {
                            badge = document.createElement('span');
                            badge.className = 'position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger';
                            badge.textContent = result.total_items;
                            cartToggleBtn.appendChild(badge);
                        }
                    } catch (error) {
                        alert(error.message);
                    }
                });
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>