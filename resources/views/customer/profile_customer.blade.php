<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Profil Saya</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
        }

        header {
            background-color: #0d6efd;
            color: #fff;
            padding: 2rem;
            text-align: center;
            border-bottom: 4px solid #0b5ed7;
        }

        .container {
            max-width: 960px;
            margin: -60px auto 0;
            padding: 2rem;
        }

        .profile-card {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
            padding: 2rem;
            display: flex;
            align-items: center;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background-color: #dee2e6;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: #6c757d;
            font-weight: bold;
        }

        .profile-info p {
            margin: 0.3rem 0;
            color: #333;
        }

        .section-title {
            font-size: 1.4rem;
            font-weight: bold;
            margin-bottom: 1rem;
            color: #0d6efd;
        }

        .order-history {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .order {
            border: 1px solid #e3e6f0;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1rem;
            background-color: #fdfdfd;
        }

        .order p {
            margin: 0.3rem 0;
        }

        ul {
            list-style: disc;
            margin-left: 1.5rem;
            color: #444;
        }

        .text-end {
            text-align: right;
        }

        .btn {
            padding: 0.6rem 1.2rem;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 6px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            transition: all 0.3s ease-in-out;
            background-color: #0d6efd;
            color: #fff;
            border: none;
        }

        .btn:hover {
            background-color: #084dbc;
        }
    </style>
</head>
<body>
    <header>
        <h1>Selamat Datang, {{ $user->name }}!</h1>
        <p>Ini adalah halaman profil akun kamu</p>
    </header>

    <div class="container">
        <div class="profile-card">
            <div class="avatar">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div class="profile-info">
                <p><strong>Nama:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Role:</strong> {{ ucfirst($user->role) }}</p>
            </div>
        </div>

        <div class="order-history">
            <div class="section-title">Riwayat Transaksi</div>
            @if($orders->isEmpty())
                <p>Belum ada transaksi.</p>
            @else
                @foreach($orders as $order)
                    <div class="order">
                        <p><strong>Tanggal:</strong> {{ $order->created_at->format('d M Y H:i') }}</p>
                        <p><strong>Total:</strong> Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                        <p><strong>Item:</strong></p>
                        <ul>
                            @foreach($order->items as $item)
                                <li>{{ $item->menu ? $item->menu->name : 'Menu Tidak Ditemukan' }} - Jumlah: {{ $item->quantity }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            @endif
        </div>

        <div class="text-end">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn">Logout</button>
            </form>
        </div>
    </div>

    <script>
        window.addEventListener('pageshow', function(event) {
            if (event.persisted || performance.getEntriesByType("navigation")[0].type === "back_forward") {
                window.location.reload();
            }
        });
    </script>
</body>
</html>
