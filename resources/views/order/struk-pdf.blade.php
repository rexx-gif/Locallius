<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Pesanan #{{ $order->id ?? 'Tidak Ditemukan' }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, sans-serif;
            font-size: 14px;
            color: #333;
            background: #fff;
            margin: 0;
            padding: 20px;
        }
        .receipt {
            max-width: 600px;
            margin: auto;
            border: 1px solid #ddd;
            padding: 24px;
            border-radius: 8px;
        }
        h2 {
            text-align: center;
            margin-bottom: 16px;
            border-bottom: 1px dashed #aaa;
            padding-bottom: 8px;
        }
        .section-title {
            margin-top: 20px;
            font-weight: bold;
            border-bottom: 1px solid #eee;
            padding-bottom: 4px;
        }
        .info, .items, .summary {
            margin-top: 12px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 4px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }
        th, td {
            border-bottom: 1px solid #ddd;
            padding: 8px 6px;
            text-align: left;
        }
        th {
            background: #f8f8f8;
        }
        td.text-end {
            text-align: right;
        }
        td.text-center {
            text-align: center;
        }
        .total {
            font-weight: bold;
            font-size: 16px;
        }
        .status-badge {
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 12px;
            color: #fff;
        }
        .status-pending { background-color: #f0ad4e; }
        .status-completed { background-color: #28a745; }
        .status-cancelled { background-color: #dc3545; }
    </style>
</head>
<body>
    <div class="receipt">
        @if(!$order)
            <p style="color: red; text-align: center;">Pesanan tidak ditemukan.</p>
        @else
            <h2>Struk Pesanan #{{ $order->id }}</h2>

            <div class="info">
                <div class="section-title">Informasi Pemesan</div>
                <div class="info-row"><span>Nama:</span><span>{{ $order->customer_name }}</span></div>
                <div class="info-row"><span>Telepon:</span><span>{{ $order->customer_phone }}</span></div>
                <div class="info-row"><span>Alamat:</span><span>{{ $order->customer_address ?? '-' }}</span></div>
                <div class="info-row"><span>Catatan:</span><span>{{ $order->notes ?? '-' }}</span></div>
            </div>

            <div class="info">
                <div class="section-title">Informasi Pesanan</div>
                <div class="info-row">
                    <span>Status:</span>
                    <span class="status-badge status-{{ $order->status }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
                <div class="info-row"><span>Tanggal:</span><span>{{ $order->created_at->format('d/m/Y H:i') }}</span></div>
                <div class="info-row">
                    <span>Metode Pembayaran:</span>
                    <span>
                        {{ strtoupper($order->payment_method) }}
                        @if($order->payment_channel)
                            ({{ $order->payment_channel }})
                        @endif
                    </span>
                </div>
                @if($order->payment_method == 'cod' && $order->location)
                    <div class="info-row">
                        <span>Lokasi Pengantaran:</span><span>{{ $order->location }}</span>
                    </div>
                @endif
            </div>

            <div class="items">
                <div class="section-title">Item Pesanan</div>
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Menu</th>
                            <th class="text-end">Harga</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($order->items as $i => $item)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>
                                {{ $item->menu->name ?? 'Menu Tidak Ditemukan' }}
                                @if($item->menu && $item->menu->description)
                                    <br><small style="color:#888;">{{ Str::limit($item->menu->description, 40) }}</small>
                                @endif
                            </td>
                            <td class="text-end">Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-end">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada item pesanan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="summary">
                @if($order->discount > 0)
                <div class="info-row">
                    <span>Diskon:</span>
                    <span style="color: red;">-Rp{{ number_format($order->discount, 0, ',', '.') }}</span>
                </div>
                @endif
                <div class="info-row total">
                    <span>Total Pembayaran:</span>
                    <span>Rp{{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
            </div>
        @endif
    </div>
</body>
</html>
