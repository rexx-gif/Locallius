@extends('layouts.admin')

@section('content')
<style>
    .page-container {
        padding: var(--space-md);
        width: 100%;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: var(--space-lg);
    }

    .page-title {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--dark);
    }

    .btn-add {
        background-color: var(--secondary);
        color: var(--white);
        padding: var(--space-sm) var(--space-md);
        border-radius: var(--radius-md);
        text-decoration: none;
        font-weight: 500;
        transition: background-color 0.2s;
        display: inline-flex;
        align-items: center;
        gap: var(--space-xs);
    }

    .btn-add:hover {
        background-color: var(--primary-dark);
    }

    .btn-add i {
        font-size: 0.875rem;
    }

    .alert-success {
        background-color: var(--secondary-light);
        color: var(--secondary);
        padding: var(--space-sm) var(--space-md);
        border-radius: var(--radius-md);
        margin-bottom: var(--space-md);
        border-left: 4px solid var(--secondary);
    }

    .table-container {
        overflow-x: auto;
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-sm);
        background-color: var(--white);
        position: relative;
        left: 230px;
        width: 85%;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 600px;
    }

    thead {
        background-color: var(--dark);
        color: var(--white);
    }

    th, td {
        padding: var(--space-sm) var(--space-md);
        border: 1px solid var(--gray-light);
        text-align: left;
    }

    th {
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    td img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: var(--radius-sm);
    }

    .action-group {
        display: flex;
        gap: var(--space-xs);
    }

    .btn-sm {
        padding: var(--space-xs) var(--space-sm);
        border: none;
        border-radius: var(--radius-sm);
        font-size: 0.75rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: var(--space-xs);
    }

    .btn-sm i {
        font-size: 0.75rem;
    }

    .btn-edit {
        background-color: var(--primary-light);
        color: var(--primary);
    }

    .btn-edit:hover {
        background-color: var(--primary);
        color: var(--white);
    }

    .btn-delete {
        background-color: rgba(239, 68, 68, 0.1);
        color: var(--danger);
    }

    .btn-delete:hover {
        background-color: var(--danger);
        color: var(--white);
    }

    .text-muted {
        color: var(--gray);
        font-size: 0.875rem;
    }

    .text-center {
        text-align: center;
    }

    .empty-state {
        padding: var(--space-xl) var(--space-md);
        text-align: center;
        color: var(--gray);
    }

    .empty-state i {
        font-size: 2rem;
        margin-bottom: var(--space-sm);
        color: var(--gray-light);
    }

    .page-title{
        position: relative;
        left: 250px;
    }

    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: var(--space-sm);
        }
        
        .btn-add {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="page-container">
    <div class="page-header">
        <h3 class="page-title">Kelola Menu</h3>
        <a href="{{ route('admin.menu.create') }}" class="btn-add">
            <i class="fas fa-plus"></i> Tambah Menu
        </a>
    </div>

    @if(session('success'))
        <div class="alert-success" style="width:650px; position: relative; left:245px;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="table-container">
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
                        <td>
                            <span class="text-muted">{{ Str::limit($menu->description, 50) }}</span>
                        </td>
                        <td>Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                        <td>
                            @if ($menu->image)
                                <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}">
                            @else
                                <span class="text-muted">Tidak ada gambar</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-group">
                                <a href="{{ route('admin.menu.edit', $menu->id) }}" class="btn-sm btn-edit">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.menu.destroy', $menu->id) }}" method="POST" onsubmit="return confirm('Hapus menu ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-sm btn-delete">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <i class="fas fa-utensils"></i>
                                <p>Belum ada menu yang tersedia</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    // Confirm before deleting
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function(e) {
            if (!confirm('Apakah Anda yakin ingin menghapus menu ini?')) {
                e.preventDefault();
            }
        });
    });
</script>
@endsection