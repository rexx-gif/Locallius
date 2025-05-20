<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promo;
use App\Models\Menu;

class PromoController extends Controller
{
    public function validateCart(Request $request)
{
    $promo = Promo::where('code', $request->promo_code)->first();
    
    if (!$promo) {
        return response()->json([
            'success' => false,
            'message' => 'Kode promo tidak valid'
        ]);
    }
    
    $total = 0;
    $validItems = 0;
    
    foreach ($request->items as $item) {
        $menu = Menu::find($item['menu_id']);
        if ($promo->applicable_to_all || $promo->menus->contains($menu)) {
            $total += $menu->price * $item['quantity'];
            $validItems++;
        }
    }
    
    if ($validItems === 0) {
        return response()->json([
            'success' => false,
            'message' => 'Promo tidak berlaku untuk item di cart'
        ]);
    }
    
    $discount = $this->calculateDiscount($total, $promo);
    
    return response()->json([
        'success' => true,
        'discount' => $discount,
        'total' => $total - $discount,
        'message' => 'Promo berhasil diterapkan'
    ]);
}
    public function validatePromo(Request $request)
    {
        $request->validate([
            'promo_code' => 'required|string',
            'menu_id' => 'required|exists:menus,id',
            'quantity' => 'required|integer|min:1'
        ]);
        
        $promo = Promo::where('code', $request->promo_code)
            ->where(function($query) {
                $query->whereNull('valid_until')
                    ->orWhere('valid_until', '>=', now());
            })
            ->where('max_uses', '>', \DB::raw('uses'))
            ->first();
            
        if (!$promo) {
            return response()->json([
                'success' => false,
                'message' => 'Kode promo tidak valid atau sudah kadaluarsa'
            ]);
        }
        
        $menu = Menu::findOrFail($request->menu_id);
        $subtotal = $menu->price * $request->quantity;
        
        // Hitung diskon
        if ($promo->type === 'percentage') {
            $discount = $subtotal * ($promo->value / 100);
        } else {
            $discount = min($promo->value, $subtotal);
        }
        
        $total = $subtotal - $discount;
        
        return response()->json([
            'success' => true,
            'message' => 'Promo berhasil diterapkan',
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $total,
            'promo' => $promo->only(['code', 'description'])
        ]);
    }
}