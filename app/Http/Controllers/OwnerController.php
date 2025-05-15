<?php

namespace App\Http\Controllers;
use App\Models\Order;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    public function dashboard()
    {
        $sales = Order::selectRaw('DATE(created_at) as date, SUM(total_price) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('owner.dashboard', compact('sales'));
    }
}

