@extends('layouts.app')

@section('title', 'Login | GameVault')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-xl-10">
            <div class="row g-0 auth-card glass-nav overflow-hidden">
                <div class="col-lg-5 auth-side p-4 p-lg-5 d-flex flex-column justify-content-between">
                    <div>
                        <span class="meta-chip mb-3"><i class="fa-solid fa-right-to-bracket"></i> Login</span>
                        <h1 class="display-6 fw-bold mb-3">Volte para sua biblioteca.</h1>
                        <p class="mb-0 opacity-75">Entre e continue sua coleção.</p>
                    </div>

                    <div class="mt-4">
                        <div class="d-flex align-items-center gap-2 mb-2"><i class="fa-solid fa-gamepad"></i> Sua lista</div>
                        <div class="d-flex align-items-center gap-2 mb-2"><i class="fa-solid fa-magnifying-glass"></i> Seus filtros</div>
                        <div class="d-flex align-items-center gap-2"><i class="fa-solid fa-lock"></i> Seu acesso</div>
                    </div>
                </div>

                <div class="col-lg-7 auth-body p-4 p-lg-5">
                    <div class="mb-4">
                        <h2 class="section-title">Login</h2>
                        <p class="text-secondary mb-0">Informe seus dados.</p>
                    </div>

                    <form method="POST" action="{{ route('login.store') }}" class="row g-3">
                        @csrf
                        <div class="col-12">
                            <label class="form-label fw-semibold" for="email">E-mail</label>
                            <input class="form-control @error('email') is-invalid @enderror" id="email" name="email" type="email" value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold" for="password">Senha</label>
                            <input class="form-control @error('password') is-invalid @enderror" id="password" name="password" type="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" id="remember" name="remember" type="checkbox" value="1" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">Manter-se conectado</label>
                            </div>
                        </div>

                        <div class="col-12 d-flex flex-wrap gap-3 align-items-center">
                            <button class="btn btn-brand px-4" type="submit">Entrar</button>
                            <span class="text-secondary">Não possui conta? <a href="{{ route('register') }}">Criar agora</a></span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
