<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Mail;
use App\Models\Menu;

// Landing Page
Route::get('/', function () {
    $menus = [
        (object)[
            'name' => 'Nasi Goreng',
            'description' => 'Nasi goreng lezat dengan bumbu spesial',
            'price' => 25000,
            'image' => 'asset/menu/nasigoreng.jpg'
        ],
        (object)[
            'name' => 'Mie Goreng',
            'description' => 'Mie goreng dengan bumbu rahasia',
            'price' => 20000,
            'image' => 'asset/menu/miegoreng.jpg'
        ],
        (object)[
            'name' => 'Mie Goreng',
            'description' => 'Mie goreng dengan bumbu rahasia',
            'price' => 20000,
            'image' => 'asset/menu/miegoreng.jpg'
        ],
        (object)[
            'name' => 'Mie Goreng',
            'description' => 'Mie goreng dengan bumbu rahasia',
            'price' => 20000,
            'image' => 'asset/menu/miegoreng.jpg'
        ]
    ];
    
    return view('landing', compact('menus'));
})->name('home');

Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');


Route::get('/menu',function (){
    $menus = Menu::all();
    return view('menu',compact('menus'));
})->name('menu');

//Contact routes
// Show contact form (GET)
Route::get('/contact', [ContactController::class, 'showForm'])->name('contact.form');

// Handle form submission (POST)
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

// Login routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); // Ini adalah logout global

// Redirect after login
Route::middleware('auth')->get('/redirect-role', function () {
    return redirect()->route('admin.dashboard');
});

// Admin routes (hanya admin yang bisa akses)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::get('/menu', [MenuController::class, 'adminIndex'])->name('menu.index');
    Route::get('/menu/create', [MenuController::class, 'create'])->name('menu.create');
    Route::post('/menu', [MenuController::class, 'store'])->name('menu.store');
    Route::get('/menu/{id}/edit', [MenuController::class, 'edit'])->name('menu.edit');
    Route::put('/menu/{id}', [MenuController::class, 'update'])->name('menu.update');
    Route::delete('/menu/{id}', [MenuController::class, 'destroy'])->name('menu.destroy');

    // Logout admin
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/admin/menu', [MenuController::class, 'adminIndex'])->name('admin.menu.index');


Route::get('/test-email', function() {
    try {
        Mail::raw('This is a test email', function($message) {
            $message->to('coderedem1500k@gmail.com')
                    ->subject('Test Email');
        });
        return 'Test email sent successfully!';
    } catch (\Exception $e) {
        return 'Error: '.$e->getMessage();
    }
});

Route::get('/order/{id}', [OrderController::class, 'show'])->name('order.show');
Route::post('/order', [OrderController::class, 'store'])->name('order.store');

