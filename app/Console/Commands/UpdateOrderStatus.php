<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use Carbon\Carbon;

class UpdateOrderStatus extends Command
{
    protected $signature = 'orders:update-status';
    protected $description = 'Update order status from pending to processing after 10 minutes';

    public function handle()
    {
        $orders = Order::where('status', 'pending')
            ->where('created_at', '<=', Carbon::now()->subMinutes(10))
            ->get();

        foreach ($orders as $order) {
            $order->status = 'processing';
            $order->save();

            // Kirim notifikasi, misal dispatch event, atau kirim ke log
            $this->info("Order #{$order->id} status updated to processing.");
        }
    }
}
