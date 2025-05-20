<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PromoController;

// Landing Page - accessible to all
Route::get('/', function () {
    $menus = [
        (object)[
            'name' => 'Nasi Goreng',
            'description' => 'Nasi goreng lezat dengan bumbu spesial',
            'price' => 25000,
            'image' => 'asset/menu/nasigoreng.jpg'
        ],
    ];
    $promos = App\Models\Promo::where('valid_until', '>=', now())
               ->orWhereNull('valid_until')
               ->whereColumn('uses', '<', 'max_uses')
               ->get();
    return view('landing', compact('menus', 'promos'));
})->name('home');

// Contact - accessible to all
Route::get('/contact', [ContactController::class, 'showForm'])->name('contact.form');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

// Auth - only for guests
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::get('/register/customer', [AuthController::class, 'showCustomerRegisterForm'])->name('customer.register');
Route::post('/register/customer', [AuthController::class, 'registerCustomer']);

// Logout - only for authenticated users
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Admin routes - requires login
Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/menu', [MenuController::class, 'adminIndex'])->name('menu.index');
    Route::get('/menu/create', [MenuController::class, 'create'])->name('menu.create');
    Route::post('/menu', [MenuController::class, 'store'])->name('menu.store');
    Route::get('/menu/{id}/edit', [MenuController::class, 'edit'])->name('menu.edit');
    Route::put('/menu/{id}', [MenuController::class, 'update'])->name('menu.update');
    Route::delete('/menu/{id}', [MenuController::class, 'destroy'])->name('menu.destroy');
});

// Public menu page - accessible to all
Route::get('/menu', [MenuController::class, 'index'])->name('menu');

// Order routes - accessible without login
Route::get('/menu/{id}/order', [OrderController::class, 'create'])->name('order.create');
Route::get('/history', [OrderController::class, 'index'])->name('order.history');
Route::get('/orders/{id}', [OrderController::class, 'show'])->name('order.show');

Route::post('/orders', [OrderController::class, 'store'])->name('order.store');
Route::get('/orders/{id}/download', [OrderController::class, 'downloadStruk'])->name('order.download');
Route::patch('/orders/{id}/cancel', [OrderController::class, 'cancel'])->name('order.cancel');
Route::post('/order/single', [OrderController::class, 'storeSingle'])->name('order.store.single');
Route::get('/checkout', [OrderController::class, 'showCheckoutForm'])->name('checkout');
Route::post('/checkout', [OrderController::class, 'checkout'])->name('order.checkout');

// Promo routes
Route::post('/promo/apply', [OrderController::class, 'applyPromo'])->name('promo.validate');
Route::post('/order/apply-promo', [OrderController::class, 'applyPromo'])->name('order.applyPromo');
Route::post('/promo/validate', [PromoController::class, 'validatePromo'])->name('promo.validate');

// Debug and test routes
Route::get('/debug-auth', function () {
    return auth()->check() ? 'Sudah login sebagai ' . auth()->user()->email : 'Belum login';
});
Route::get('/force-logout', function () {
    \Illuminate\Support\Facades\Auth::logout();
    return redirect('/login');
});
Route::get('/test-email', function () {
    try {
        \Illuminate\Support\Facades\Mail::raw('This is a test email', function ($message) {
            $message->to('coderedem1500k@gmail.com')
                    ->subject('Test Email');
        });
        return 'Test email sent successfully!';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});