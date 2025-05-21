<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Admin - Locallius</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      height: 100vh;
      background: url('https://i.pinimg.com/736x/9d/1f/2e/9d1f2e441590c09d737125a61b5f5281.jpg') no-repeat center center/cover;
      display: flex;
      justify-content: center;
      align-items: center;
      overflow: hidden;
    }

    .glass-container {
      background: rgba(255, 255, 255, 0.05);
      backdrop-filter: blur(15px);
      -webkit-backdrop-filter: blur(15px);
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: 20px;
      padding: 40px;
      width: 100%;
      max-width: 400px;
      box-shadow: 0 0 40px rgba(0, 0, 0, 0.6);
      color: white;
      animation: fadeIn 1s ease;
    }

    h2 {
      text-align: center;
      margin-bottom: 25px;
      font-size: 24px;
      font-weight: bold;
      letter-spacing: 1px;
    }

    label {
      display: block;
      margin-bottom: 8px;
      font-size: 14px;
      color: #ddd;
    }

    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 12px;
      margin-bottom: 20px;
      border: none;
      border-radius: 10px;
      background: rgba(255, 255, 255, 0.1);
      color: white;
      font-size: 14px;
      transition: 0.3s ease;
    }

    input[type="email"]::placeholder,
    input[type="password"]::placeholder {
      color: rgba(255, 255, 255, 0.6);
    }

    input:focus {
      outline: none;
      background: rgba(255, 255, 255, 0.2);
    }

    .btn-login {
      width: 100%;
      padding: 12px;
      background: #188ddb;
      border: none;
      border-radius: 10px;
      color: white;
      font-weight: bold;
      font-size: 16px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .btn-login:hover {
      background: #11649b;
    }

    .alert {
      background-color: rgba(255, 0, 0, 0.3);
      padding: 12px;
      border-radius: 10px;
      color: white;
      margin-bottom: 15px;
      font-size: 14px;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: scale(0.95);
      }
      to {
        opacity: 1;
        transform: scale(1);
      }
    }

    @media (max-width: 480px) {
      .glass-container {
        padding: 30px 20px;
      }
    }
  </style>
</head>
<body>

  <div class="glass-container">
    <h2>Login To Locallius</h2>

    @if ($errors->any())
      <div class="alert">
        {{ $errors->first() }}
      </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
      @csrf
      <label for="email">Email</label>
      <input type="email" name="email" id="email" placeholder="Masukkan email" required>

      <label for="password">Password</label>
      <input type="password" name="password" id="password" placeholder="Masukkan password" required>

      <button type="submit" class="btn-login">Login</button>
      <a href="{{ route('customer.register') }}">Register Here</a>
    </form>
  </div>
<script>
    window.addEventListener('pageshow', function(event) {
        if (event.persisted || performance.getEntriesByType("navigation")[0].type === "back_forward") {
            window.location.reload();
        }
    });
</script>

</body>
</html>
