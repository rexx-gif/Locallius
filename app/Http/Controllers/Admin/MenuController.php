<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; // <- ini penting
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    // Tampilkan semua menu di halaman pelanggan (landing page)
    public function index()
    {
        $menus = Menu::all();
        return view('menu', compact('menus'));
    }

    // Tampilkan halaman daftar menu untuk admin
    public function adminIndex()
    {
        $menus = Menu::all();
        return view('admin.menu.index', compact('menus'));
    }

    // Tampilkan form untuk membuat menu baru
    public function create()
    {
        return view('admin.menu.create');
    }

    // Simpan menu baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'description' => 'nullable',
                'stock' => 'required|integer|min:0',

            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('menu_images', 'public');
            $validated['image'] = $imagePath;
        }

        Menu::create($validated);

        return redirect()->route('admin.menu.index')
                         ->with('success', 'Menu created successfully');
    }

    // Tampilkan form edit menu
    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        return view('admin.menu.edit', compact('menu'));
    }

    // Update menu
    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'description' => 'nullable',
                'stock' => 'required|integer|min:0',

            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($menu->image && Storage::disk('public')->exists($menu->image)) {
                Storage::disk('public')->delete($menu->image);
            }

            // Simpan gambar baru
            $imagePath = $request->file('image')->store('menu_images', 'public');
            $validated['image'] = $imagePath;
        }

        $menu->update($validated);

        return redirect()->route('admin.menu.index')
                         ->with('success', 'Menu updated successfully');
    }

    // Hapus menu
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);

        if ($menu->image && Storage::disk('public')->exists($menu->image)) {
            Storage::disk('public')->delete($menu->image);
        }

        $menu->delete();

        return redirect()->route('admin.menu.index')
                         ->with('success', 'Menu deleted successfully');
    }
}
