<div class="receipt-container">
    <div class="text-center mb-4">
        <h3>{{ config('app.name') }}</h3>
        <p class="mb-1">Jl. Contoh No. 123, Kota Contoh</p>
        <p>Telp: 0812-3456-7890</p>
        <h4 class="mt-3">STRUK PESANAN</h4>
        <p>No: {{ $order->id }}</p>
        <p>Tanggal: {{ $order->created_at->format('d/m/Y H:i') }}</p>
    </div>

    <div class="mb-4">
        <p><strong>Pelanggan:</strong> {{ $order->customer_name }}</p>
        <p><strong>Telepon:</strong> {{ $order->customer_phone }}</p>
        @if($order->customer_address)
        <p><strong>Alamat:</strong> {{ $order->customer_address }}</p>
        @endif
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Menu</th>
                <th class="text-end">Harga</th>
                <th class="text-center">Qty</th>
                <th class="text-end">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->menu->name }}</td>
                <td class="text-end">Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                <td class="text-center">{{ $item->quantity }}</td>
                <td class="text-end">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            @if($order->discount > 0)
            <tr>
                <td colspan="3" class="text-end"><strong>Diskon</strong></td>
                <td class="text-end text-danger">-Rp{{ number_format($order->discount, 0, ',', '.') }}</td>
            </tr>
            @endif
            <tr>
                <td colspan="3" class="text-end"><strong>TOTAL</strong></td>
                <td class="text-end"><strong>Rp{{ number_format($order->total_price, 0, ',', '.') }}</strong></td>
            </tr>
        </tfoot>
    </table>

    <div class="payment-info mt-4">
        <p><strong>Metode Pembayaran:</strong> 
            {{ strtoupper($order->payment_method) }}
            @if($order->payment_channel)
                ({{ $order->payment_channel }})
            @endif
        </p>
        <p><strong>Status:</strong> 
            <span class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'cancelled' ? 'danger' : 'warning') }}">
                {{ ucfirst($order->status) }}
            </span>
        </p>
    </div>

    <div class="text-center mt-5">
        <p>Terima kasih telah memesan di {{ config('app.name') }}</p>
        <p>** Simpan struk ini sebagai bukti transaksi **</p>
    </div>
</div>

<style>
.receipt-container {
    font-family: Arial, sans-serif;
    max-width: 100%;
}
.table {
    width: 100%;
    margin-bottom: 1rem;
    color: #212529;
}
.table th, .table td {
    padding: 0.5rem;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
}
.table thead th {
    vertical-align: bottom;
    border-bottom: 2px solid #dee2e6;
}
.text-end { text-align: right; }
.text-center { text-align: center; }
</style>