<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;


class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        $user = Auth::user(); // Ambil user yang berhasil login

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // Kalau bukan admin, logout dan tolak akses
        Auth::logout();
        return back()->withErrors([
            'email' => 'Akun ini tidak memiliki akses sebagai admin.',
        ]);
    }

    return back()->withErrors([
        'email' => 'Login gagal. Cek kembali email dan password.',
    ])->onlyInput('email');
}


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}

