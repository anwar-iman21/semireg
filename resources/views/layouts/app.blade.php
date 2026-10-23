<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SemiReg — ' . config('seminar.name'))</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,600;12..96,800&family=Instrument+Sans:wght@400;500;600;700&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/semireg.css">
</head>
<body>
    <header class="navbar">
        <div class="nav-container">
            <a href="{{ route('home', [], false) }}" class="brand">
                <span class="brand-badge">SR</span>
                <span class="brand-text">SemiReg</span>
            </a>
            <nav class="nav-links">
                @if(request()->routeIs('home'))
                    <a href="#agenda">Agenda</a>
                    <a href="{{ route('registration.lookup', [], false) }}">Cek tiket</a>
                    <a href="#daftar" class="btn btn-yellow btn-sm">Daftar sekarang</a>
                @elseif(request()->routeIs('admin.*'))
                    @if(session('admin_authenticated'))
                        <a href="{{ route('admin.dashboard', [], false) }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Peserta</a>
                        <a href="{{ route('admin.info', [], false) }}" class="{{ request()->routeIs('admin.info') ? 'active' : '' }}">Info Tunnel</a>
                        <form method="POST" action="{{ route('admin.logout', [], false) }}" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn-link">Keluar</button>
                        </form>
                    @endif
                @else
                    <a href="{{ route('home', [], false) }}">Beranda</a>
                    <a href="{{ route('registration.lookup', [], false) }}">Cek tiket</a>
                    <a href="{{ route('home', [], false) }}#daftar" class="btn btn-yellow btn-sm">Daftar sekarang</a>
                @endif
            </nav>
        </div>
    </header>

    <main class="page-content">
        @yield('content')
    </main>

    <footer class="footer">
        <div class="footer-container">
            <p>{{ config('seminar.name') }} &copy; {{ date('Y') }}. Pendaftaran mandiri berbasis Laravel.</p>
            <p class="footer-sub">
                <a href="{{ route('registration.lookup', [], false) }}">Cek tiket</a>
                &nbsp;·&nbsp;
                <a href="{{ route('admin.dashboard', [], false) }}">Panel Panitia</a>
            </p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
