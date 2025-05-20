<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Promo;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Spatie\Browsershot\Browsershot;


class OrderController extends Controller
{
    // New method to show the order form for a specific menu
    // public function create($id)
    // {
    //     $menu = Menu::findOrFail($id);
    //     return view('order.create', compact('menu'));
    // }

    public function downloadStruk($id)
    {
           $order = Order::with('items.menu')->findOrFail($id);
    $html = view('order.struk-pdf', compact('order'))->render();

    $fileName = 'Struk-' . \Str::slug($order->customer_name) . '.png';

    $path = storage_path('app/public/' . $fileName);

    Browsershot::html($html)
        ->windowSize(800, 1000)
        ->save($path);

    return response()->download($path)->deleteFileAfterSend(true);

    }

    public function index(Request $request)
    {
        $query = Order::with('items.menu')->latest();
        if ($request->filled('search')) {
            $query->where('customer_name', 'like', '%' . $request->search . '%');
        }
        $orders = $query->get();
        return view('admin.index', compact('orders'));
    }

    public function applyPromo(Request $request)
    {
        $request->validate([
            'promo_code' => 'required|string|exists:promos,code',
            'menu_id' => 'required|exists:menus,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $promo = Promo::where('code', $request->promo_code)
                      ->where('active', true)
                      ->first();

        if (!$promo) {
            return response()->json([
                'success' => false,
                'message' => 'Kode promo tidak valid atau sudah tidak berlaku.'
            ], 422);
        }

        if ($promo->uses >= $promo->max_uses) {
            return response()->json([
                'success' => false,
                'message' => 'Kuota promo sudah habis.'
            ], 422);
        }

        $menu = Menu::findOrFail($request->menu_id);
        $quantity = $request->quantity;
        $subtotal = $menu->price * $quantity;
        $discount = $promo->type === 'percentage' 
            ? $subtotal * ($promo->value / 100) 
            : $promo->value;
        $total = $subtotal - $discount;

        session(['applied_promo' => $promo]);

        return response()->json([
            'success' => true,
            'message' => "Promo '{$promo->code}' berhasil diterapkan! Diskon: " . ($promo->type === 'percentage' ? $promo->value . '%' : 'Rp' . number_format($promo->value, 0, ',', '.')),
            'discount' => $discount,
            'total' => $total
        ]);
    }

    public function show($id)
{
    $menu = Menu::findOrFail($id);
    return view('order.show', compact('menu'));
}

    public function store(Request $request)
{
    $validated = $request->validate([
        'menu_id' => 'required|exists:menus,id',
        'quantity' => 'required|integer|min:1',
        'name' => 'required|string',
        'address' => 'required|string',
        'phone' => 'required|string',
        'notes' => 'nullable|string',
        'payment_method' => 'required|in:online,cod',
        'location' => 'nullable|required_if:payment_method,cod|string',
        'discount' => 'nullable|integer|min:0',
    ]);

     $menu = Menu::findOrFail($request->menu_id);
    $quantity = $request->quantity;
    $discount = $request->discount ?? 0;

    $subtotal = $menu->price * $quantity;
    $totalPrice = $subtotal - $discount;

    $order = new Order();
    $order->menu_id = $request->menu_id;
    $order->quantity = $quantity;
    $order->customer_name = $request->name;
    $order->customer_address = $request->address;
    $order->customer_phone = $request->phone;
    $order->notes = $request->notes;
    $order->total_price = $totalPrice;
    $order->discount = $discount;
    $order->payment_method = $request->payment_method;
    $order->payment_channel = $request->payment_channel;
    $order->location = $request->payment_method === 'cod' ? $request->location : null;
    $order->status = 'pending';
    $order->save();

    $order->items()->create([
        'menu_id' => $menu->id,
        'quantity' => $quantity,
        'price' => $menu->price,
        'subtotal' => $subtotal,
    ]);

    // Instead of redirecting, return back with the order data
    return back()->with([
        'order_created' => true,
        'order_id' => $order->id,
        'success' => 'Pesanan berhasil dibuat!'
    ]);
}


    public function storeSingle(Request $request)
    {
        return $this->store($request);
    }

    public function showCheckoutForm(Request $request)
    {
        return redirect()->route('menu')->with('error', 'Checkout tidak tersedia tanpa keranjang.');
    }

    public function checkout(Request $request)
    {
        return redirect()->route('menu')->with('error', 'Checkout tidak tersedia tanpa keranjang.');
    }

    public function cancel($id)
    {
        $order = Order::findOrFail($id);
        if ($order->status === 'pending') {
            $order->status = 'cancelled';
            $order->save();
            return redirect()->route('order.show', $order->id)->with('success', 'Pesanan telah dibatalkan.');
        }
        return redirect()->route('order.show', $order->id)->with('error', 'Pesanan tidak dapat dibatalkan.');
    }
}