<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Promo;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Spatie\Browsershot\Browsershot;
use Carbon\Carbon;

class OrderController extends Controller
{
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
        $orders = Order::with('items.menu')
            ->latest()
            ->when($request->search, function ($query) use ($request) {
                $query->where('customer_name', 'like', '%' . $request->search . '%');
            })
            ->paginate(10);

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

    public function dashboard()
    {
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', 'completed')->sum('total_price');
        $pendingOrders = Order::where('status', 'pending')->count();
        $completedOrders = Order::where('status', 'completed')->count();

        $recentOrder = Order::with('items.menu')->latest()->first();
        if ($recentOrder) {
            $recentOrder->time_ago = Carbon::parse($recentOrder->created_at)->diffForHumans();
        }

        $recentCompletedOrder = Order::with('items.menu')->where('status', 'completed')->latest()->first();
        if ($recentCompletedOrder) {
            $recentCompletedOrder->time_ago = Carbon::parse($recentCompletedOrder->updated_at)->diffForHumans();
        }

        $salesData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $salesData[] = [
                'day' => $date->format('D'),
                'total' => Order::whereDate('created_at', $date)->where('status', 'completed')->sum('total_price'),
                'count' => Order::whereDate('created_at', $date)->where('status', 'completed')->count(),
                'pending' => Order::whereDate('created_at', $date)->where('status', 'pending')->count()
            ];
        }

        return view('admin.dashboard', compact(
            'totalOrders',
            'totalRevenue',
            'pendingOrders',
            'completedOrders',
            'recentOrder',
            'recentCompletedOrder',
            'salesData'
        ));
    }

   public function store(Request $request)
{
    // Ambil menu dulu
    $menu = Menu::findOrFail($request->menu_id);

    // Baru lakukan validasi, sekarang $menu->stock bisa dipakai
    $validated = $request->validate([
        'menu_id' => 'required|exists:menus,id',
        'quantity' => ['required', 'integer', 'min:1', 'max:' . $menu->stock],
        'name' => 'required|string',
        'address' => 'required|string',
        'phone' => 'required|string',
        'notes' => 'nullable|string',
        'payment_method' => 'required|in:online,cod',
        'location' => 'nullable|required_if:payment_method,cod|string',
        'discount' => 'nullable|integer|min:0',
    ]);

    $quantity = $validated['quantity'];

    // Cek stok cukup
    if ($menu->stock < $quantity) {
        return back()->with('error', 'Stok menu tidak mencukupi.');
    }

    $discount = $validated['discount'] ?? 0;
    $subtotal = $menu->price * $quantity;
    $totalPrice = $subtotal - $discount;

    $order = new Order();
    $order->menu_id = $menu->id;
    $order->quantity = $quantity;
    $order->customer_name = $validated['name'];
    $order->customer_address = $validated['address'];
    $order->customer_phone = $validated['phone'];
    $order->notes = $validated['notes'] ?? null;
    $order->total_price = $totalPrice;
    $order->discount = $discount;
    $order->payment_method = $validated['payment_method'];
    $order->payment_channel = $request->payment_channel;
    $order->location = $validated['payment_method'] === 'cod' ? $validated['location'] : null;
    $order->status = 'completed';
    $order->user_id = auth()->id();
    $order->save();

    $order->items()->create([
        'menu_id' => $menu->id,
        'quantity' => $quantity,
        'price' => $menu->price,
        'subtotal' => $subtotal,
    ]);

    $menu->stock -= $quantity;
    $menu->save();

    return back()->with([
        'order_created' => true,
        'order_id' => $order->id,
        'success' => 'Pesanan berhasil dibuat dan selesai!'
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
