<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class OrderController extends Controller
{
    public function show($id){
        $menu = Menu::findOrFail($id);
        return view('order.show',compact('menu'));
    }
}
