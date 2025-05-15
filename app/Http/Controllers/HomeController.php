<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;

use App\Models\Menu;

class HomeController extends Controller
{
    public function index()
    {
        $menus = Menu::all(); // Get all menus from database
        
        // If no menus exist (for development), create sample data
        if ($menus->isEmpty()) {
            $menus = collect([
                (object)[
                    'name' => 'Nasi Goreng',
                    'description' => 'Nasi goreng lezat dengan bumbu spesial',
                    'price' => 25000,
                    'image' => 'images/menu/nasi-goreng.jpg'
                ],
                // Add more sample menus as needed
            ]);
        }

        return view('landing', compact('menus'));
    }
}