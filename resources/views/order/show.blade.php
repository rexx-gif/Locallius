@extends('layouts.menu')

@section('title', 'Pesan: ' . ($menu->name ?? 'Menu'))
@section('content')

<head>
    <style>
        .row{
            position: relative;
            top: 70px;
        }
        .container h2{
            position: relative;
            top: 80px;
        }
    </style>
</head>

<div class="container mt-4">
    <h2 class="mb-4">Pesan: {{ $menu->name }}</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('order.store') }}" method="POST">
        @csrf
        <input type="hidden" name="menu_id" value="{{ $menu->id }}">
        
        @php
            $quantity = old('quantity', 1);
            $totalPrice = $menu->price * $quantity;
        @endphp

        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Detail Menu</h5>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Nama Menu:</span>
                            <strong>{{ $menu->name }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Harga Satuan:</span>
                            <strong>Rp{{ number_format($menu->price, 0, ',', '.') }}</strong>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Jumlah Pesan</label>
                           <input type="number" name="quantity" id="quantity" class="form-control" 
                            min="1" max="{{ $menu->stock }}" value="{{ $quantity }}" required>
                            @error('quantity') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Total Harga:</span>
                            <strong id="totalPriceTop">Rp{{ number_format($totalPrice, 0, ',', '.') }}</strong>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Data Pemesan</h5>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Pemesan</label>
                            <input type="text" name="name" id="name" class="form-control" 
                                   value="{{ old('name') }}" required>
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Alamat</label>
                            <textarea name="address" id="address" class="form-control">{{ old('address') }}</textarea>
                            @error('address') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Nomor Telepon</label>
                            <input type="text" name="phone" id="phone" class="form-control" 
                                   value="{{ old('phone') }}" required>
                            @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-10">
                            <label for="notes" class="form-label">Catatan (opsional)</label>
                            <textarea name="notes" id="notes" class="form-control">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-2 mt-5" style="margin-top: 100px; position: relative; top:50px;">
            <div class="card-body">
                <h5 class="card-title">Promo</h5>
                <div class="mb-3">
                    <label for="promo_code" class="form-label">Kode Promo (opsional)</label>
                    <div class="input-group">
                        <input type="text" name="promo_code" id="promo_code" class="form-control" 
                               value="{{ old('promo_code') }}">
                        <button type="button" class="btn btn-outline-primary" id="applyPromo">Terapkan</button>
                    </div>
                    @error('promo_code') <small class="text-danger">{{ $message }}</small> @enderror
                    <div id="promoMessage" class="mt-2 small"></div>
                </div>
                
                <div class="d-flex justify-content-between mb-1" id="discountRow" style="display:none;">
                    <span>Diskon:</span>
                    <strong id="discountAmount">-Rp0</strong>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Total Bayar:</span>
                    <strong id="totalPriceBottom">Rp{{ number_format($totalPrice, 0, ',', '.') }}</strong>
                </div>
                <input type="hidden" name="discount" id="discount" value="0">
            </div>
        </div>

        <div class="card mb-4 mt-5">
            <div class="card-body">
                <h5 class="card-title">Metode Pembayaran</h5>
                <div class="mb-3">
                    <label for="payment_method" class="form-label">Pilih Metode</label>
                    <select name="payment_method" id="payment_method" class="form-select" required>
                        <option value="">-- Pilih --</option>
                        <option value="cod" {{ old('payment_method') == 'cod' ? 'selected' : '' }}>COD (Bayar di tempat)</option>
                        <option value="online" {{ old('payment_method') == 'online' ? 'selected' : '' }}>Online</option>
                    </select>
                </div>

                <div class="mb-3" id="payment_channel_group" style="display: none;">
                    <label for="payment_channel" class="form-label">Pilih Channel Pembayaran</label>
                    <select name="payment_channel" id="payment_channel" class="form-select">
                        <option value="">-- Pilih Channel --</option>
                        <option value="dana" {{ old('payment_channel') == 'dana' ? 'selected' : '' }}>DANA</option>
                        <option value="gopay" {{ old('payment_channel') == 'gopay' ? 'selected' : '' }}>GoPay</option>
                        <option value="ovo" {{ old('payment_channel') == 'ovo' ? 'selected' : '' }}>OVO</option>
                        <option value="shopeepay" {{ old('payment_channel') == 'shopeepay' ? 'selected' : '' }}>ShopeePay</option>
                    </select>
                </div>

                <div class="mb-3" id="location_group" style="display: none;">
                    <label for="location" class="form-label">Lokasi Anda (untuk pengantaran)</label>
                    <textarea name="location" id="location" class="form-control" placeholder="Contoh: Jalan Mawar No. 12, RT 01 RW 02, Depan Indomaret">{{ old('location') }}</textarea>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fas fa-paper-plane me-2"></i> Kirim Pesanan
            </button>
        </div>
    </form>
</div>

@if(session('order_created'))
    @php
        $order = \App\Models\Order::with('items.menu')->find(session('order_id'));
    @endphp
    
    <div class="modal fade show" style="display:block;" tabindex="-1" id="receiptModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Struk Pemesanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Nama:</strong> {{ $order->customer_name }}</p>
                    @foreach($order->items as $item)
                    <p><strong>Menu:</strong> {{ $item->menu ? $item->menu->name : 'Menu Tidak Ditemukan' }}</p>
                    <p><strong>Jumlah:</strong> {{ $item->quantity }}</p>
                    <p><strong>Subtotal:</strong> Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                    @endforeach
                    <p><strong>Diskon:</strong> Rp {{ number_format($order->discount, 0, ',', '.') }}</p>
                    <p><strong>Total:</strong> Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="window.location='{{ route('menu') }}'">Tutup</button>
                    <a href="{{ route('order.download', $order->id) }}" class="btn btn-success">Download Struk</a>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show"></div>
@endif

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const paymentMethod = document.getElementById('payment_method');
        const paymentChannelGroup = document.getElementById('payment_channel_group');
        const locationGroup = document.getElementById('location_group');

        function togglePaymentFields() {
            if (paymentMethod.value === 'online') {
                paymentChannelGroup.style.display = 'block';
                locationGroup.style.display = 'none';
            } else if (paymentMethod.value === 'cod') {
                paymentChannelGroup.style.display = 'none';
                locationGroup.style.display = 'block';
            } else {
                paymentChannelGroup.style.display = 'none';
                locationGroup.style.display = 'none';
            }
        }

        paymentMethod.addEventListener('change', togglePaymentFields);
        togglePaymentFields();

        const quantityInput = document.getElementById('quantity');
        const totalPriceTop = document.getElementById('totalPriceTop');
        const totalPriceBottom = document.getElementById('totalPriceBottom');
        const applyPromoBtn = document.getElementById('applyPromo');
        const promoCodeInput = document.getElementById('promo_code');
        const promoMessage = document.getElementById('promoMessage');
        const discountRow = document.getElementById('discountRow');
        const discountAmount = document.getElementById('discountAmount');
        const discountInput = document.getElementById('discount');
        const menuPrice = {{ $menu->price }};

        function updateTotalPriceDisplay(value) {
            const formatted = 'Rp' + value.toLocaleString('id-ID');
            totalPriceTop.textContent = formatted;
            totalPriceBottom.textContent = formatted;
        }

        function resetPromoUI() {
            const quantity = parseInt(quantityInput.value) || 0;
            const totalPrice = quantity * menuPrice;
            discountRow.style.display = 'none';
            discountAmount.textContent = '-Rp0';
            discountInput.value = 0;
            updateTotalPriceDisplay(totalPrice);
        }

        quantityInput.addEventListener('input', function() {
            resetPromoUI();
        });

        applyPromoBtn.addEventListener('click', function() {
            const promoCode = promoCodeInput.value.trim();
            if (!promoCode) {
                promoMessage.innerHTML = '<span class="text-danger">Masukkan kode promo terlebih dahulu</span>';
                return;
            }

            fetch('{{ route("promo.validate") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    promo_code: promoCode,
                    menu_id: {{ $menu->id }},
                    quantity: quantityInput.value
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    discountRow.style.display = 'flex';
                    discountAmount.textContent = '-Rp' + parseInt(data.discount).toLocaleString('id-ID');
                    updateTotalPriceDisplay(parseInt(data.total));
                    discountInput.value = data.discount;
                    promoMessage.innerHTML = `<span class="text-success">${data.message}</span>`;
                } else {
                    promoMessage.innerHTML = `<span class="text-danger">${data.message}</span>`;
                    resetPromoUI();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                promoMessage.innerHTML = '<span class="text-danger">Terjadi kesalahan saat memvalidasi promo</span>';
                resetPromoUI();
            });
        });

        @if(session('order_created'))
            const form = document.getElementById('downloadForm');
            if (form) {
                form.addEventListener('submit', function() {
                    setTimeout(() => {
                        window.location.href = "{{ route('menu') }}";
                    }, 1000);
                });
            }
        @endif
    });
</script>
@endpush