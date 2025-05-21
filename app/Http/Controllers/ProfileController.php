<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class ProfileController extends Controller
{
    public function index()
    {
        // Ambil user yang sedang login
        $user = Auth::user();

        // Ambil riwayat transaksi milik user, bisa sesuaikan relasi dan modelnya
        // Contoh asumsi: Order punya kolom user_id sebagai foreign key
        $orders = Order::where('user_id', $user->id)
                       ->with('items.menu') // eager load items dan menu terkait
                       ->orderBy('created_at', 'desc')
                       ->get();

        // Kirim data user dan orders ke view profil
        return view('customer.profile_customer', compact('user', 'orders'));
    }
}
