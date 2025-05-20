<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;



class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

   public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    // Cek user berdasarkan email dulu
    $user = User::where('email', $credentials['email'])->first();

    if (!$user) {
        return back()->withErrors(['email' => 'Email tidak ditemukan']);
    }

    // Cek password dan login
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        // Arahkan berdasarkan role
        if ($user->role === 'admin') {
            return redirect()->intended(route('admin.dashboard'));
        } elseif ($user->role === 'customer') {
            return redirect()->intended(route('home'));
        } else {
            Auth::logout();
            return back()->withErrors(['email' => 'Akun tidak memiliki akses yang valid.']);
        }
    }

    return back()->withErrors(['password' => 'Password salah']);
}

public function showCustomerRegisterForm()
{
    return view('auth.register_customer');
}



    public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login');
}
public function registerCustomer(Request $request){
    $request->validate([
        'name'=>'required|string|max:255',
        'email'=>'required|string|email|max:255',
        'password'=>'required|string|min:6|confirmed',
    ]);
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'customer', // atau 'pelanggan'
    ]);
    Auth::login(user);
    $request->session()->regenerate();

    return redirect()->intended(route('home'));
}
}



