<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - Buku Tamu Diskominfo')</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <style>
        /* Admin specific additions if needed */
        .admin-header {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            padding: 1rem 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="admin-page">
    <!-- Header -->
    <header class="admin-header">
        <div class="header-content">
            <div class="logo-section">
                <div class="logo">
                    <img src="{{ asset('assets/img/logo.jpeg') }}" alt="Logo" style="height: 40px; border-radius: 50%;">
                </div>
                <div class="logo-text">
                    <h1>Diskominfo Padang</h1>
                    <span>Buku Tamu e-Government</span>
                </div>
            </div>
            <div class="user-menu">
                <span>👤 {{ Auth::guard('admin')->user()->nama_lengkap ?? 'Admin' }}</span>
                <form action="{{ route('admin.logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="logout-btn" style="border:none; cursor:pointer;">
                        🚪 Logout
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="admin-main">
        <div class="dashboard-container">
            @yield('content')
        </div>
    </main>
    
    @yield('scripts')
</body>
</html>
