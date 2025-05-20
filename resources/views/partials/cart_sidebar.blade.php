
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
        <a href="{{ route('cart.index') }}" class="btn btn-primary w-100">Lihat Keranjang</a>
    </div>
@else
    <p>Keranjang kosong.</p>
@endif
