<!DOCTYPE html>
<html>
<head>
    <title>Register Pelanggan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding: 20px;
            max-width: 600px;
            margin: 0 auto;
        }
        .error-list {
            color: red;
            padding: 10px;
            border: 1px solid #f5c6cb;
            background-color: #f8d7da;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h2 class="text-center mb-4">Register Pelanggan</h2>

    @if ($errors->any())
        <div class="error-list">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('customer.register') }}" enctype="multipart/form-data" class="mb-4">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nama:</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email:</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Foto Profil:</label>
            <input type="file" name="profile_picture" accept="image/*" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Password:</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Konfirmasi Password:</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Daftar</button>
    </form>

    <p class="text-center">Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></p>
</body>
</html>