<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\MenuControllers;

class AdminController extends Controller
{
    public function dashboard()
{
    return view('admin.dashboard');
}

}
