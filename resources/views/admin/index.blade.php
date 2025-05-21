@extends('layouts.admin')
@section('title', 'Riwayat Transaksi')

@section('content')
<style>
.transaction-container {
    max-width: 900px;
    margin: 0 auto;
    transform: translateX(145px); /* geser 50px ke kiri */
    padding: 2rem 1rem;
    background: #fff;
    border-radius: 0.75rem;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
}


.page-title {
    font-size: 1.75rem;
    font-weight: bold;
    color: #2d3748;
    margin-bottom: 1.5rem;
    border-bottom: 2px solid #e2e8f0;
    padding-bottom: 0.5rem;
}

.search-form {
    margin-bottom: 1.5rem;
}

.input-group {
    display: flex;
}

.search-input {
    flex: 1;
    border-radius: 0.5rem 0 0 0.5rem;
    border: 1px solid #cbd5e0;
    padding: 0.5rem 1rem;
    transition: all 0.2s ease-in-out;
}

.search-input:focus {
    border-color: #3182ce;
    outline: none;
    box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.3);
}

.search-btn {
    border-radius: 0 0.5rem 0.5rem 0;
    padding: 0 1rem;
    background: #3182ce;
    color: white;
    border: 1px solid #3182ce;
    transition: 0.2s ease-in-out;
    font-size: 0.875rem;
}

.search-btn:hover {
    background: #2b6cb0;
    border-color: #2b6cb0;
}

.transaction-table {
    width: 100%;
    border-collapse: collapse;
    overflow: hidden;
    border-radius: 0.5rem;
}

.transaction-table thead th {
    background-color: #1a202c;
    color: white;
    padding: 1rem;
    font-weight: 600;
    text-align: left;
    font-size: 0.875rem;
}

.transaction-table tbody tr {
    transition: background 0.2s;
}

.transaction-table tbody tr:hover {
    background-color: #f7fafc;
}

.transaction-table tbody td {
    padding: 1rem;
    border-bottom: 1px solid #e2e8f0;
    vertical-align: top;
    font-size: 0.875rem;
}

.transaction-table tbody tr:last-child td {
    border-bottom: none;
}

.text-right { text-align: right; }
.text-center { text-align: center; }

.empty-state {
    text-align: center;
    color: #a0aec0;
    padding: 2rem 1rem;
}

.empty-state-icon {
    font-size: 2.5rem;
    color: #cbd5e0;
    margin-bottom: 1rem;
}

.status-badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    font-size: 0.75rem;
    font-weight: 600;
    border-radius: 9999px;
    text-transform: uppercase;
}

.status-completed {
    background: #e6fffa;
    color: #2c7a7b;
}

.status-pending {
    background: #fefcbf;
    color: #d69e2e;
}

.status-cancelled {
    background: #fed7d7;
    color: #c53030;
}

.pagination-container {
    margin-top: 2rem;
    display: flex;
    justify-content: center;
}

/* Pagination Styling */
.pagination {
    display: flex;
    justify-content: center;
    gap: 0.25rem;
    font-size: 0.75rem;
    margin-top: 1.5rem;
    list-style-type: none;
}

.page-item .page-link {
    padding: 0.25rem 0.5rem;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    color: #2d3748;
    text-decoration: none;
    transition: 0.2s;
}

.page-item.active .page-link {
    background-color: #3182ce;
    color: white;
    border-color: #3182ce;
}

.page-link:hover {
    background-color: #edf2f7;
}


/* Responsive */
@media (max-width: 768px) {
    .transaction-container {
        padding: 1rem;
    }

    .transaction-table thead {
        display: none;
    }

    .transaction-table tbody tr {
        display: block;
        margin-bottom: 1rem;
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
    }

    .transaction-table tbody td {
        display: flex;
        justify-content: space-between;
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #e2e8f0;
    }

    .transaction-table tbody td::before {
        content: attr(data-label);
        font-weight: bold;
        color: #4a5568;
        flex: 1;
        margin-right: 1rem;
    }

    .transaction-table tbody td:last-child {
        border-bottom: none;
    }
}
</style>


<div class="transaction-container">
    <h1 class="page-title">Riwayat Transaksi</h1>

    {{-- Search Form --}}
    <form method="GET" action="{{ route('order.history') }}" class="search-form">
        <div class="input-group">
            <input type="text" name="search" class="form-control search-input" placeholder="Cari nama pemesan..." value="{{ request('search') }}">
            <button class="btn btn-primary search-btn" type="submit">
                <i class="fas fa-search"></i> Cari
            </button>
        </div>
    </form>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-responsive">
        <table class="transaction-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Pemesan</th>
                    <th>Menu</th>
                    <th class="text-right">Total</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <td data-label="No">{{ $loop->iteration }}</td>
                        <td data-label="Nama Pemesan">{{ $order->customer_name }}</td>
                        <td data-label="Menu">
                            @foreach ($order->items as $item)
                                <span class="d-block">{{ $item->menu->name ?? '-' }}</span>
                            @endforeach
                        </td>
                        <td data-label="Total" class="text-right">Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td data-label="Tanggal">{{ $order->created_at->format('d M Y H:i') }}</td>
                        <td data-label="Status">
                            <span class="status-badge status-{{ $order->status }}">
                                @if($order->status == 'completed')
                                    <i class="fas fa-check-circle me-1"></i> Selesai
                                @elseif($order->status == 'pending')
                                    <i class="fas fa-clock me-1"></i> Pending
                                @else
                                    <i class="fas fa-times-circle me-1"></i> Dibatalkan
                                @endif
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="fas fa-receipt"></i>
                                </div>
                                <h3>Belum ada transaksi</h3>
                                <p>Tidak ada riwayat pesanan yang ditemukan</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($orders->hasPages())
    <div class="pagination-container">
        {{ $orders->links('vendor.pagination.default') }}
    </div>
@endif

</div>
<script>
    window.addEventListener('pageshow', function(event) {
        if (event.persisted || performance.getEntriesByType("navigation")[0].type === "back_forward") {
            window.location.reload();
        }
    });
</script>
@endsection
