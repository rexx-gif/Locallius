@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Owner Dashboard</h2>
    <canvas id="salesChart"></canvas>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($sales->pluck('date')) !!},
            datasets: [{
                label: 'Total Penjualan',
                data: {!! json_encode($sales->pluck('total')) !!},
                borderColor: 'green',
                fill: false
            }]
        }
    });
</script>
@endpush
