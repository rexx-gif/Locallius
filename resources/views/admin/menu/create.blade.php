@extends('layouts.admin')

@section('content')
<head>
    <style>
        .container {
    max-width: 600px;
    margin: 0 auto;
}

.card {
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    border-radius: 8px;
    background-color: #fff;
    padding: 20px;
}

.card-header h2 {
    font-weight: 600;
    color: #333;
}

.form-label {
    font-weight: 500;
    color: #555;
}

.form-control {
    border: 1px solid #ccc;
    border-radius: 6px;
    padding: 8px 12px;
    font-size: 1rem;
    transition: border-color 0.3s ease;
}

.form-control:focus {
    border-color: #0d6efd; /* Bootstrap primary blue */
    outline: none;
    box-shadow: 0 0 5px rgba(13, 110, 253, 0.5);
}

.text-danger {
    font-size: 0.875rem;
}

.btn-primary {
    background-color: #0d6efd;
    border-color: #0d6efd;
    padding: 10px 20px;
    font-weight: 600;
    border-radius: 6px;
    transition: background-color 0.3s ease;
}

.btn-primary:hover {
    background-color: #084dbc;
    border-color: #084dbc;
}

.btn-secondary {
    background-color: #6c757d;
    border-color: #6c757d;
    padding: 10px 20px;
    font-weight: 600;
    border-radius: 6px;
}

.btn-secondary:hover {
    background-color: #565e64;
    border-color: #565e64;
}

.d-flex.justify-content-between {
    margin-top: 20px;
}

    </style>
</head>
<div class="container py-4">
    <div class="card">
        <div class="card-header">
            <h2 class="mb-0">Tambah Menu Baru</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.menu.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Menu</label>
                    <input type="text" name="name" id="name" class="form-control" 
                           value="{{ old('name') }}" required>
                    @error('name')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Harga</label>
                    <input type="number" name="price" id="price" class="form-control"
                           value="{{ old('price') }}" required min="0">
                    @error('price')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Gambar Menu</label>
                    <input type="file" name="image" id="image" class="form-control" required>
                    @error('image')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Format: JPEG, PNG, JPG | Maks: 2MB</small>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea name="description" id="description" class="form-control"
                              rows="3">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                <label for="stock" class="form-label">Stok</label>
               <input type="number" name="stock" class="form-control" required min="0">
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.menu.index') }}" class="btn btn-secondary">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Tambah Menu
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection