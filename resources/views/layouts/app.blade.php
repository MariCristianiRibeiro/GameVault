<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'GameVault')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Sora:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/gamevault.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body class="page-shell">
    <div class="container pb-5">
        <nav class="navbar navbar-expand-lg glass-nav px-3 px-lg-4 py-3">
            <div class="container-fluid px-0">
                <a class="navbar-brand d-flex align-items-center gap-2" href="{{ auth()->check() ? route('dashboard') : route('home') }}">
                    <span class="fs-4 brand-mark"><i class="fa-solid fa-gamepad"></i></span>
                    <span class="brand-title fw-bold">GameVault</span>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarGameVault">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarGameVault">
                    @auth
                        <ul class="navbar-nav me-auto mb-3 mb-lg-0 gap-lg-2">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active fw-semibold' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('jogos.*') ? 'active fw-semibold' : '' }}" href="{{ route('jogos.index') }}">Jogos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('pesquisa.*') ? 'active fw-semibold' : '' }}" href="{{ route('pesquisa.index') }}">Pesquisa</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle {{ request()->routeIs('plataformas.*', 'generos.*', 'desenvolvedoras.*') ? 'active fw-semibold' : '' }}" href="#" data-bs-toggle="dropdown">
                                    Cadastros
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end border-0 shadow">
                                    <li><a class="dropdown-item" href="{{ route('plataformas.index') }}">Plataformas</a></li>
                                    <li><a class="dropdown-item" href="{{ route('generos.index') }}">Gêneros</a></li>
                                    <li><a class="dropdown-item" href="{{ route('desenvolvedoras.index') }}">Desenvolvedoras</a></li>
                                </ul>
                            </li>
                        </ul>

                        <div class="d-flex align-items-center gap-2">
                            <span class="meta-chip"><i class="fa-solid fa-user"></i> {{ auth()->user()->name }}</span>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="btn btn-sm btn-accent" type="submit">Sair</button>
                            </form>
                        </div>
                    @else
                        <div class="ms-auto d-flex gap-2">
                            <a class="btn btn-soft" href="{{ route('login') }}">Login</a>
                            <a class="btn btn-brand" href="{{ route('register') }}">Registro</a>
                        </div>
                    @endauth
                </div>
            </div>
        </nav>

        <main class="pt-4 pt-lg-5">
            @yield('content')
        </main>
    </div>

    <script>
        window.GameVaultFlash = {!! json_encode([
            'type' => session('error') ? 'error' : (session('success') ? 'success' : null),
            'text' => session('error') ?? session('success'),
        ]) !!};
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/gamevault.js') }}"></script>
    @stack('scripts')
</body>
</html>
