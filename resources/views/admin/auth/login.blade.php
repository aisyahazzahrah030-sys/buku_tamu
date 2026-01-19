<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Buku Tamu Diskominfo</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 2rem;
        }
        .login-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .login-header {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            padding: 2rem;
            text-align: center;
        }
        .login-header .logo {
            background: rgba(255,255,255,0.2);
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.8rem;
        }
        .login-form {
            padding: 2rem;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #495057;
        }
        .form-group input {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102,126,234,0.1);
        }
        .btn-login {
            width: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.75rem;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102,126,234,0.3);
        }
        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .login-footer {
            padding: 1.5rem;
            text-align: center;
            background: #f8f9fa;
            border-top: 1px solid #dee2e6;
        }
        .login-footer p {
            color: #6c757d;
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
        }
        .login-footer a {
            color: #667eea;
            text-decoration: none;
            font-size: 0.875rem;
        }
        .login-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="logo">🏛️</div>
                <h2>Login Admin</h2>
                <p>Diskominfo Kota Padang</p>
            </div>
            
            @if ($errors->any())
                <div class="alert alert-error">
                    <span>⚠️</span>
                    {{ $errors->first() }}
                </div>
            @endif
            
            <form method="POST" action="{{ route('admin.login.post') }}" class="login-form">
                @csrf
                <div class="form-group">
                    <label for="username">
                        👤 Username
                    </label>
                    <input type="text" id="username" name="username" required 
                           placeholder="Masukkan username" value="{{ old('username') }}">
                </div>
                
                <div class="form-group">
                    <label for="password">
                        🔒 Password
                    </label>
                    <input type="password" id="password" name="password" required 
                           placeholder="Masukkan password">
                </div>
                
                <button type="submit" class="btn-login">
                    🔑 Login
                </button>
            </form>
            
            <div class="login-footer">
                <p>📝 Default: admin / admin123</p>
                <a href="{{ route('guest.form') }}">← Kembali ke Buku Tamu</a>
            </div>
        </div>
    </div>
</body>
</html>
