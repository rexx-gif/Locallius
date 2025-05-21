<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Promo;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil promo aktif yang valid (valid_until belum lewat) dan belum habis kuota
        $promos = Promo::where(function($query) {
                $query->whereNull('valid_until')
                      ->orWhere('valid_until', '>=', now());
            })
            ->whereColumn('uses', '<', 'max_uses')
            ->take(3)
            ->get();

        // Ambil 4 menu terbaru dari DB
        $menus = Menu::take(4)->get();

        // Jika tidak ada menu di DB, pakai fallback data sample
        if ($menus->isEmpty()) {
            $menus = collect([
                (object)[
                    'name' => 'Nasi Goreng',
                    'description' => 'Nasi goreng lezat dengan bumbu spesial',
                    'price' => 25000,
                    'image' => 'images/menu/nasi-goreng.jpg',
                ],
                // Tambah menu sample lain jika perlu
            ]);
        }

        $promos = Promo::where('active', true)->get();

        // Kirim data ke view landing.blade.php
        return view('landing', compact('menus', 'promos'));
    }
    public function home(){
        $user = Auth::user();
        return view('landing', compact('user'));
    }
}
