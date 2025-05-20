@extends('layouts.admin')

@section('content')
<style>
    .page-container {
        padding: 2rem;
        max-width: 1200px;
        margin: auto;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .page-header h3 {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 700;
    }

    .btn-add {
        background-color: #10b981;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        text-decoration: none;
        font-weight: 600;
        transition: background-color 0.3s;
    }

    .btn-add:hover {
        background-color: #059669;
    }

    .alert-success {
        background-color: #d1fae5;
        color: #065f46;
        padding: 1rem;
        border-radius: 0.5rem;
        margin-bottom: 1rem;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        border-radius: 0.5rem;
        overflow: hidden;
    }

    thead {
        background-color: #1f2937;
        color: white;
    }

    th, td {
        padding: 1rem;
        border: 1px solid #e5e7eb;
        text-align: left;
        vertical-align: top;
    }

    td img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 0.5rem;
        transition: transform 0.3s;
    }

    .btn-sm {
        padding: 0.4rem 0.8rem;
        border: none;
        border-radius: 0.4rem;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-primary {
        background-color: #3b82f6;
        color: white;
        margin-right: 0.25rem;
    }

    .btn-primary:hover {
        background-color: #2563eb;
    }

    .btn-danger {
        background-color: #ef4444;
        color: white;
    }

    .btn-danger:hover {
        background-color: #dc2626;
    }

    .text-muted {
        color: #9ca3af;
    }

    .text-center {
        text-align: center;
    }
</style>

<div class="page-container">
    <div class="page-header">
        <h3>Kelola Menu</h3>
        <a href="{{ route('admin.menu.create') }}" class="btn-add">+ Tambah Menu</a>
    </div>

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Deskripsi</th>
                <th>Harga</th>
                <th>Foto</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($menus as $menu)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $menu->name }}</td>
                    <td>{{ $menu->description }}</td>
                    <td>Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                    <td>
                        @if ($menu->image)
                            <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}">
                        @else
                            <span class="text-muted">No image</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.menu.edit', $menu->id) }}" class="btn-sm btn-primary">Edit</a>
                        <form action="{{ route('admin.menu.destroy', $menu->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus menu ini?')" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Belum ada menu.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
