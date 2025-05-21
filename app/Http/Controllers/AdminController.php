<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\MenuControllers;

class AdminController extends Controller
{
    public function dashboard()
{
    if (!Auth::check() || Auth::user()->role !== 'admin') {
        return redirect()->route('login');
    }

    $response = response()->view('admin.dashboard');
    return $response->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                    ->header('Pragma', 'no-cache')
                    ->header('Expires', '0');
}


}
