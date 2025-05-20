<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --primary: #1f1f2e;
            --secondary: #2c2c3e;
            --accent: #ff6b6b;
            --text: #ffffff;
            --muted: #b0b0b0;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--secondary);
            color: var(--text);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        nav.navbar {
            background-color: var(--primary);
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .navbar-brand {
            font-size: 1.3rem;
            font-weight: bold;
            color: var(--accent) !important;
            text-decoration: none;
        }

        .navbar-nav {
            display: flex;
            gap: 1rem;
        }

        .nav-link {
            color: var(--text);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: var(--accent);
        }

        .btn-outline-light {
            border: 1px solid var(--accent);
            color: var(--accent);
            padding: 5px 12px;
            border-radius: 8px;
            background: transparent;
            transition: 0.3s ease;
        }

        .btn-outline-light:hover {
            background-color: var(--accent);
            color: #fff;
        }

        main.container {
            flex: 1;
            max-width: 1000px;
            margin: 2rem auto;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.02);
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.3);
        }

        footer {
            background-color: #111;
            color: var(--muted);
            text-align: center;
            padding: 1rem 0;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            nav.navbar {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .navbar-nav {
                flex-direction: column;
                gap: 0.5rem;
            }

            main.container {
                padding: 1.5rem;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    {{-- Navbar --}}
    <nav class="navbar">
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">Locallius Admin</a>
        <div class="d-flex align-items-center gap-3">
            <div class="navbar-nav">
                <a class="nav-link" href="{{ route('admin.menu.index') }}"><i class="fas fa-utensils me-1"></i> Kelola Menu</a>
                 <li class="nav-item"><a href="{{ route('order.history') }}" class="nav-link">Riwayat Pembelian</a>
</li>            </div>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button class="btn btn-outline-light btn-sm"><i class="fas fa-sign-out-alt"></i> Logout</button>
            </form>
        </div>
    </nav>

    {{-- Content --}}
    <main class="container">
        @yield('content')
    </main>

    <footer>
        &copy; {{ date('Y') }} Locallius Admin Panel. All rights reserved.
    </footer>

    @stack('scripts')
</body>
</html>
