<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Order;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        return view('cart.index', compact('cart'));
    }

    public function add($id)
{
    // Logika tambah ke cart, misal:
    $menu = Menu::find($id);
    if (!$menu) {
        return response()->json(['error' => 'Menu tidak ditemukan'], 404);
    }

    $cart = session()->get('cart', []);

    if(isset($cart[$id])) {
        $cart[$id]['quantity']++;
    } else {
        $cart[$id] = [
            "name" => $menu->name,
            "quantity" => 1,
            "price" => $menu->price,
        ];
    }

    session()->put('cart', $cart);

    return response()->json([
        'message' => 'Berhasil ditambahkan ke keranjang',
        'cartCount' => array_sum(array_column($cart, 'quantity'))
    ]);
}


    public function remove(Request $request)
{
    $cart = session()->get('cart', []);
    
    if(isset($cart[$request->id])) {
        unset($cart[$request->id]);
        session()->put('cart', $cart);
    }

    $totalItems = array_sum(array_column($cart, 'quantity'));
    
    return response()->json([
        'html' => view('partials.cart_sidebar')->render(),
        'total_items' => $totalItems
    ]);
}

public function clear(Request $request)
{
    $request->session()->forget('cart');
    return response()->json(['success' => true]);
}

    public function checkout(Request $request)
    {
        $cart = session('cart', []);
        if(empty($cart)) {
            return redirect()->back()->with('error', 'Keranjang kosong!');
        }

        $request->validate([
            'name' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $totalPrice = 0;

        foreach($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        // Simpan setiap item jadi order (atau buat order master + detail kalau pakai relasi lebih kompleks)
        foreach($cart as $item) {
            Order::create([
                'menu_id' => $item['id'],
                'name' => $request->name,
                'address' => $request->address,
                'phone' => $request->phone,
                'notes' => $request->notes,
                'total_price' => $item['price'] * $item['quantity'],
            ]);
        }

        session()->forget('cart');

        return redirect()->route('menu')->with('success', 'Pesanan berhasil dibuat!');
    }
}
