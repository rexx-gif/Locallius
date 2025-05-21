@extends('layouts.admin')

@section('content')
<style>
    :root {
        --primary: #2563eb;
        --primary-dark: #1e40af;
        --secondary: #10b981;
        --danger: #ef4444;
        --warning: #f59e0b;
        --dark: #111827;
        --light: #f9fafb;
        --gray: #6b7280;
        --gray-light: #e5e7eb;
    }
    
    .main-content {
        flex: 1;
        padding: 2rem 3rem;
        margin-left: 280px;
        transition: all 0.3s ease;
    }
    
    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }
    
    h2 {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--dark);
    }
    
    .user-profile {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    overflow: hidden;
    background-color: #4299e1;
    display: flex;
    align-items: center;
    justify-content: center;
}

.avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
    
    /* Dashboard Grid */
    .grid {
        display: grid;
        grid-template-columns: repeat(1, 1fr);
        gap: 1.5rem;
        margin-bottom: 2.5rem;
    }
    
    @media (min-width: 768px) {
        .grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    @media (min-width: 1024px) {
        .grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }
    
    /* Cards */
    .card {
        background-color: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        padding: 1.5rem;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border: 1px solid var(--gray-light);
    }
    
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
    }
    
    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }
    
    .card h3 {
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--gray);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .card-icon {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }
    
    .icon-blue {
        background-color: rgba(37, 99, 235, 0.1);
        color: var(--primary);
    }
    
    .icon-green {
        background-color: rgba(16, 185, 129, 0.1);
        color: var(--secondary);
    }
    
    .icon-emerald {
        background-color: rgba(5, 150, 105, 0.1);
        color: #059669;
    }
    
    .icon-yellow {
        background-color: rgba(245, 158, 11, 0.1);
        color: var(--warning);
    }
    
    .card-value {
        font-size: 1.75rem;
        font-weight: 700;
        margin: 0.5rem 0;
    }
    
    .card-footer {
        display: flex;
        align-items: center;
        font-size: 0.875rem;
        color: var(--gray);
    }
    
    .trend-up {
        color: var(--secondary);
        margin-right: 0.25rem;
    }
    
    .trend-down {
        color: var(--danger);
        margin-right: 0.25rem;
    }
    
    /* Chart Section */
    .chart-section {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.5rem;
        margin-bottom: 2.5rem;
    }
    
    @media (min-width: 1024px) {
        .chart-section {
            grid-template-columns: 2fr 1fr;
        }
    }
    
    .chart-card {
        background-color: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        padding: 1.5rem;
        border: 1px solid var(--gray-light);
    }
    
    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    
    .chart-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--dark);
    }
    
    .chart-container {
        position: relative;
        height: 300px;
    }
    
    .chart-legend {
        display: flex;
        justify-content: center;
        gap: 1.5rem;
        margin-top: 1rem;
        flex-wrap: wrap;
    }
    
    .legend-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
    }
    
    .legend-color {
        width: 12px;
        height: 12px;
        border-radius: 3px;
    }
    
    /* Recent Activity */
    .activity-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    
    .activity-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 0.75rem;
        border-radius: 8px;
        transition: background-color 0.2s;
    }
    
    .activity-item:hover {
        background-color: var(--gray-light);
    }
    
    .activity-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: rgba(37, 99, 235, 0.1);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    
    .activity-content {
        flex: 1;
    }
    
    .activity-title {
        font-weight: 500;
        margin-bottom: 0.25rem;
    }
    
    .activity-time {
        font-size: 0.75rem;
        color: var(--gray);
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .main-content {
            margin-left: 80px;
            padding: 1.5rem;
        }
    }
</style>

<main class="main-content">
    <div class="header">
        <h2>Ringkasan Penjualan</h2>
        <div class="user-profile">
            <span>Rexx</span>
            <div class="avatar"><img src="/asset/pp/download (1).jpg" alt="a"></div>
        </div>
    </div>
    
    <div class="grid">
        <div class="card">
            <div class="card-header">
                <h3>Total Pesanan</h3>
                <div class="card-icon icon-blue">
                    <i class="fas fa-shopping-bag"></i>
                </div>
            </div>
            <p class="card-value">{{ $totalOrders }}</p>
            <div class="card-footer">
                <i class="fas fa-arrow-up trend-up"></i>
                <span>12% dari bulan lalu</span>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h3>Total Pemasukan</h3>
                <div class="card-icon icon-green">
                    <i class="fas fa-wallet"></i>
                </div>
            </div>
            <p class="card-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            <div class="card-footer">
                <i class="fas fa-arrow-up trend-up"></i>
                <span>8% dari bulan lalu</span>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h3>Pesanan Selesai</h3>
                <div class="card-icon icon-emerald">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
            <p class="card-value">{{ $completedOrders }}</p>
            <div class="card-footer">
                <i class="fas fa-arrow-up trend-up"></i>
                <span>5% dari bulan lalu</span>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h3>Menunggu Pembayaran</h3>
                <div class="card-icon icon-yellow">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
            <p class="card-value">{{ $pendingOrders }}</p>
            <div class="card-footer">
                <i class="fas fa-arrow-down trend-down"></i>
                <span>3% dari bulan lalu</span>
            </div>
        </div>
    </div>
    
    <!-- Chart Section -->
    <div class="chart-section">
        <div class="chart-card">
            <div class="chart-header">
                <h3 class="chart-title">Statistik Penjualan 7 Hari Terakhir</h3>
                <select class="chart-period" style="padding: 0.5rem; border-radius: 6px; border: 1px solid var(--gray-light);">
                    <option>7 Hari</option>
                    <option>30 Hari</option>
                    <option>3 Bulan</option>
                </select>
            </div>
            <div class="chart-container">
                <canvas id="salesChart"></canvas>
            </div>
            <div class="chart-legend">
                <div class="legend-item">
                    <span class="legend-color" style="background-color: #3b82f6;"></span>
                    <span>Total Pesanan</span>
                </div>
                <div class="legend-item">
                    <span class="legend-color" style="background-color: #10b981;"></span>
                    <span>Pesanan Selesai</span>
                </div>
                <div class="legend-item">
                    <span class="legend-color" style="background-color: #f59e0b;"></span>
                    <span>Pending</span>
                </div>
            </div>
        </div>
        
        <div class="chart-card">
            <div class="chart-header">
                <h3 class="chart-title">Aktivitas Terkini</h3>
                <i class="fas fa-ellipsis-h" style="color: var(--gray);"></i>
            </div>
            <div class="activity-list">
                <div class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-title">Pesanan baru dari {{ $recentOrder->customer_name }}</div>
                        <div class="activity-time">{{ $recentOrder->time_ago }}</div>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-icon" style="background-color: rgba(16, 185, 129, 0.1); color: var(--secondary);">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="activity-content">
                         <div class="activity-title">Pesanan dari {{ $recentCompletedOrder->customer_name }} selesai</div>
                        <div class="activity-time">{{ $recentCompletedOrder->time_ago }}</div>
                    </div>
                </div>
                <div class="chart-container">
    <h3 style="margin-bottom: 5px;">Pesanan Terbaru</h3>

   @if($recentOrder)
    <div class="activity-item">
        <div class="activity-icon">
            @if($recentOrder->status == 'completed')
                <i class="fas fa-check-circle"></i>
            @elseif($recentOrder->status == 'pending')
                <i class="fas fa-clock"></i>
            @else
                <i class="fas fa-times-circle"></i>
            @endif
        </div>
        <div class="activity-content">
            <p><strong>{{ $recentOrder->customer_name }}</strong> memesan {{ $recentOrder->items->first()->menu->name }}</p>
            <small>{{ $recentOrder->time_ago }}</small>
        </div>
    </div>
@else
    <p>Tidak ada pesanan terbaru.</p>
@endif
</div>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Sales Chart Data
    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
            datasets: [
                {
                    label: 'Total Pesanan',
                    data: [12, 19, 15, 8, 14, 22, 18],
                    backgroundColor: 'rgba(59, 130, 246, 0.7)',
                    borderRadius: 4
                },
                {
                    label: 'Pesanan Selesai',
                    data: [8, 12, 10, 5, 9, 15, 12],
                    backgroundColor: 'rgba(16, 185, 129, 0.7)',
                    borderRadius: 4
                },
                {
                    label: 'Pending',
                    data: [4, 7, 5, 3, 5, 7, 6],
                    backgroundColor: 'rgba(245, 158, 11, 0.7)',
                    borderRadius: 4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    grid: {
                        display: false
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#1f2937',
                    titleFont: {
                        size: 14,
                        weight: 'bold'
                    },
                    bodyFont: {
                        size: 12
                    },
                    padding: 12,
                    cornerRadius: 8,
                    displayColors: false
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });
    window.addEventListener('pageshow', function(event) {
        if (event.persisted || performance.getEntriesByType("navigation")[0].type === "back_forward") {
            window.location.reload();
        }
    });
</script>
@endsection