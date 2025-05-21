<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            /* Color Variables */
            --primary: #2563eb;
            --primary-dark: #1e40af;
            --primary-light: rgba(37, 99, 235, 0.1);
            --secondary: #10b981;
            --secondary-light: rgba(16, 185, 129, 0.1);
            --danger: #ef4444;
            --warning: #f59e0b;
            --warning-light: rgba(245, 158, 11, 0.1);
            --dark: #111827;
            --light: #f9fafb;
            --gray: #6b7280;
            --gray-light: #e5e7eb;
            --gray-lighter: #f3f4f6;
            --white: #ffffff;
            
            /* Spacing Variables */
            --space-xs: 0.25rem;
            --space-sm: 0.5rem;
            --space-md: 1rem;
            --space-lg: 1.5rem;
            --space-xl: 2rem;
            --space-2xl: 3rem;
            
            /* Border Radius */
            --radius-sm: 4px;
            --radius-md: 8px;
            --radius-lg: 12px;
            --radius-xl: 16px;
            
            /* Shadows */
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        /* Base Styles */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            background-color: var(--gray-lighter);
            font-family: 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            color: var(--dark);
            line-height: 1.5;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            background-color: var(--dark);
            color: var(--gray-light);
            width: 280px;
            padding: var(--space-xl) var(--space-md);
            display: flex;
            flex-direction: column;
            gap: var(--space-xs);
            box-shadow: var(--shadow-xl);
            position: fixed;
            height: 100vh;
            z-index: 100;
            transition: all 0.3s ease;
        }
        
        .sidebar-header {
            display: flex;
            align-items: center;
            gap: var(--space-sm);
            margin-bottom: var(--space-2xl);
            padding: 0 var(--space-sm);
        }
        
        .sidebar-title {
            color: var(--white);
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
        }
        
        .logo {
            width: 36px;
            height: 36px;
            background-color: var(--primary);
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-weight: bold;
        }

        /* Navigation Menu */
        .nav-menu {
            display: flex;
            flex-direction: column;
            gap: var(--space-xs);
        }
        
        .nav-item {
            display: flex;
            align-items: center;
            gap: var(--space-sm);
            color: var(--gray);
            text-decoration: none;
            font-weight: 500;
            padding: var(--space-sm) var(--space-md);
            border-radius: var(--radius-md);
            transition: all 0.2s ease;
        }
        
        .nav-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: var(--white);
        }
        
        .nav-item.active {
            background-color: var(--primary);
            color: var(--white);
            box-shadow: var(--shadow-md);
        }
        
        .nav-icon {
            width: 24px;
            text-align: center;
            font-size: 1rem;
        }

        /* Main Content Area */
        .main-content {
            flex: 1;
            padding: var(--space-xl) var(--space-2xl);
            margin-left: 280px;
            transition: all 0.3s ease;
        }

        /* Header Styles */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: var(--space-xl);
        }
        
        .page-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--dark);
        }

        /* User Profile */
        .user-profile {
            display: flex;
            align-items: center;
            gap: var(--space-sm);
        }
        
        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--primary);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        /* Container Styles */
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: var(--space-md);
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: var(--space-sm) var(--space-md);
            border-radius: var(--radius-md);
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            border: 1px solid transparent;
        }
        
        .btn-outline {
            border: 1px solid var(--gray-light);
            color: var(--dark);
            background-color: transparent;
        }
        
        .btn-outline:hover {
            background-color: var(--gray-lighter);
        }
        
        .btn-primary {
            background-color: var(--primary);
            color: var(--white);
        }
        
        .btn-primary:hover {
            background-color: var(--primary-dark);
        }

        .btn-primary:focus{
            background-color: var(--primary-dark);
        }

        /* Footer */
        .footer {
            background-color: black;
            color: white;
            text-align: center;
            padding: var(--space-md) 0;
            font-size: 0.9rem;
            margin-left: 280px;
            margin-top: 165px;
        }

        /* Responsive Adjustments */
        @media (max-width: 992px) {
            .sidebar {
                width: 80px;
                padding: var(--space-md) var(--space-xs);
            }
            
            .sidebar-header, .nav-item span {
                display: none;
            }
            
            .nav-item {
                justify-content: center;
                padding: var(--space-sm);
            }
            
            .main-content, .footer {
                margin-left: 80px;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                padding: var(--space-lg) var(--space-md);
            }
            
            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: var(--space-md);
            }
        }

        @media (max-width: 576px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: static;
                flex-direction: row;
                padding: var(--space-sm);
            }
            
            .nav-menu {
                flex-direction: row;
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .nav-item {
                padding: var(--space-xs) var(--space-sm);
            }
            
            .main-content, .footer {
                margin-left: 0;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Sidebar Navigation -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="logo">L</div>
            <h1 class="sidebar-title">Locallius</h1>
        </div>
        <nav class="nav-menu">
            <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
    <i class="fas fa-chart-line nav-icon"></i>
    <span>Dashboard</span>
    </a>
    <a href="{{ route('admin.menu.index') }}" class="nav-item {{ request()->routeIs('admin.menu.*') ? 'active' : '' }}">
    <i class="fas fa-utensils nav-icon"></i>
    <span>Menu</span>
    </a>
           <a href="{{ url('/admin/pesanan') }}" class="nav-item {{ request()->is('admin/pesanan*') ? 'active' : '' }}">

    <i class="fas fa-clipboard-list nav-icon"></i>
    <span>Pesanan</span>
            </a>
            <a href="#" class="nav-item"
   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
    <i class="fas fa-sign-out-alt nav-icon"></i>
    <span>Logout</span> <!-- pastikan ini ada dan tidak di-hide -->
</a>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>


        </nav>
    </aside>

    <!-- Main Content Area -->
    {{-- <div class="main-content">
        <header class="page-header">
            <h2 class="page-title">@yield('page-title', 'Dashboard')</h2>
            <div class="user-profile">
                <div class="avatar">AD</div>
                <span>Admin</span>
            </div>
        </header> --}}
        
        <main class="container">
            @yield('content')
        </main>
    </div>

    <!-- Footer -->
    <footer class="footer">
        &copy; {{ date('Y') }} Locallius Admin Panel. All rights reserved.
    </footer>

    @stack('scripts')
    <script>
    document.querySelectorAll('.nav-item').forEach(item => {
    item.addEventListener('click', function(e) {
        // e.preventDefault();  <-- hapus baris ini
        document.querySelectorAll('.nav-item').forEach(i => i.classList.remove('active'));
        this.classList.add('active');
    });
});
window.addEventListener('pageshow', function(event) {
        if (event.persisted || performance.getEntriesByType("navigation")[0].type === "back_forward") {
            window.location.reload();
        }
    });
</script>

</body>
</html>