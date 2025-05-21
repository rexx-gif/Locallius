<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- wajib ada

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan']);
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

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
        return redirect()->route('home');
    }

    public function registerCustomer(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $extension = $file->getClientOriginalExtension();
            $filename = 'profile_'.time().'.'.$extension;
            $path = $file->storeAs('public/profile_pictures', $filename);
            $validated['profile_picture'] = 'profile_pictures/'.$filename;
        }

        $validated['password'] = Hash::make($request->password);
        $validated['role'] = 'customer';

        $user = User::create($validated);
        Auth::login($user);

        return redirect()->intended(route('home'));
    }

    public function home()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Cegah cache halaman home customer
        $response = response()->view('landing', compact('user'));
        return $response->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                        ->header('Pragma', 'no-cache')
                        ->header('Expires', '0');
    }
}
