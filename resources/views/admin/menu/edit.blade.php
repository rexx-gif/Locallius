@extends('layouts.admin')

@section('content')
<style>
    .menu-edit-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 2rem;
    }
    
    .card {
        border: none;
        border-radius: 0.75rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }
    
    .card-header {
        background-color: #2d3748;
        color: white;
        padding: 1.25rem 1.5rem;
        border-bottom: none;
    }
    
    .card-header h2 {
        font-size: 1.5rem;
        font-weight: 600;
        margin: 0;
    }
    
    .card-body {
        padding: 2rem;
    }
    
    .form-label {
        font-weight: 500;
        color: #4a5568;
        margin-bottom: 0.5rem;
        display: block;
    }
    
    .form-control {
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
        padding: 0.75rem 1rem;
        transition: all 0.2s;
    }
    
    .form-control:focus {
        border-color: #4299e1;
        box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.2);
    }
    
    .text-danger {
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
    
    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 500;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }
    
    .btn-secondary {
        background-color: #e2e8f0;
        color: #4a5568;
        border: none;
    }
    
    .btn-secondary:hover {
        background-color: #cbd5e0;
    }
    
    .btn-primary {
        background-color: #4299e1;
        border: none;
    }
    
    .btn-primary:hover {
        background-color: #3182ce;
    }
    
    .action-buttons {
        display: flex;
        justify-content: space-between;
        margin-top: 2rem;
    }
    
    @media (max-width: 768px) {
        .menu-edit-container {
            padding: 1rem;
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        .action-buttons {
            flex-direction: column-reverse;
            gap: 1rem;
        }
        
        .action-buttons .btn {
            width: 100%;
        }
    }
</style>

<div class="menu-edit-container">
    <div class="card">
        <div class="card-header">
            <h2>Edit Menu</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label for="name" class="form-label">Nama Menu</label>
                    <input type="text" name="name" id="name" class="form-control" 
                           value="{{ old('name', $menu->name) }}" required>
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="price" class="form-label">Harga</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="price" id="price" class="form-control"
                               value="{{ old('price', $menu->price) }}" required min="0">
                    </div>
                    @error('price')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea name="description" id="description" class="form-control"
                              rows="4">{{ old('description', $menu->description) }}</textarea>
                    @error('description')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="image" class="form-label">Gambar Menu</label>
                    {{-- <input type="file" name="image" id="image" class="form-control" accept="image/*"> --}}
                    @error('image')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    @if($menu->image)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $menu->image) }}" alt="Current menu image" 
                                 class="img-thumbnail" style="max-height: 200px;">
                            <div class="form-check mt-2">
                                {{-- <input class="form-check-input" type="checkbox" name="remove_image" id="remove_image">
                                <label class="form-check-label" for="remove_image">
                                    Hapus gambar saat ini
                                </label> --}}
                            </div>
                        </div>
                    @endif
                </div>

                <div class="action-buttons">
                    <a href="{{ route('admin.menu.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection