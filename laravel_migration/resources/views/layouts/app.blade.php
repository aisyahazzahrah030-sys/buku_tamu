<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Buku Tamu e-Government - Diskominfo Kota Padang')</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header class="header">
            <div class="header-content">
                <div class="logo-section">
                    <div class="logo">
                     <img src="{{ asset('assets/img/logo.jpeg') }}" alt="Logo Diskominfo">
                    </div>
                    <div class="logo-text">
                        <h1>Diskominfo Kota Padang</h1>
                        <p>Buku Tamu e-Government</p>
                    </div>
                </div>
                <div class="header-actions">
                    <a href="{{ route('admin.login') }}" class="btn-admin">
                        <i class="fas fa-user-shield"></i> Admin
                    </a>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="main-content">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="footer">
            <p>&copy; {{ date('Y') }} Dinas Komunikasi dan Informatika Kota Padang. All rights reserved.</p>
        </footer>
    </div>

    @yield('scripts')
</body>
</html>
