@extends('layouts.app')

@section('title', 'Registro | GameVault')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-xl-10">
            <div class="row g-0 auth-card glass-nav overflow-hidden">
                <div class="col-lg-5 auth-side p-4 p-lg-5 d-flex flex-column justify-content-between">
                    <div>
                        <span class="meta-chip mb-3"><i class="fa-solid fa-user-plus"></i> Registro</span>
                        <h1 class="display-6 fw-bold mb-3">Crie sua conta.</h1>
                        <p class="mb-0 opacity-75">Comece sua biblioteca agora.</p>
                    </div>

                    <div class="mt-4">
                        <div class="d-flex align-items-center gap-2 mb-2"><i class="fa-solid fa-chart-column"></i> Estatisticas</div>
                        <div class="d-flex align-items-center gap-2 mb-2"><i class="fa-solid fa-folder-open"></i> Biblioteca</div>
                        <div class="d-flex align-items-center gap-2"><i class="fa-solid fa-shield"></i> Conta pessoal</div>
                    </div>
                </div>

                <div class="col-lg-7 auth-body p-4 p-lg-5">
                    <div class="mb-4">
                        <h2 class="section-title">Registro</h2>
                        <p class="text-secondary mb-0">Preencha os campos abaixo.</p>
                    </div>

                    <form method="POST" action="{{ route('register.store') }}" class="row g-3">
                        @csrf
                        <div class="col-12">
                            <label class="form-label fw-semibold" for="name">Nome</label>
                            <input class="form-control @error('name') is-invalid @enderror" id="name" name="name" type="text" value="{{ old('name') }}" required autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold" for="email">E-mail</label>
                            <input class="form-control @error('email') is-invalid @enderror" id="email" name="email" type="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold" for="password">Senha</label>
                            <input class="form-control @error('password') is-invalid @enderror" id="password" name="password" type="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold" for="password_confirmation">Confirmar senha</label>
                            <input class="form-control" id="password_confirmation" name="password_confirmation" type="password" required>
                        </div>

                        <div class="col-12 d-flex flex-wrap gap-3 align-items-center">
                            <button class="btn btn-brand px-4" type="submit">Criar conta</button>
                            <span class="text-secondary">Já possui conta? <a href="{{ route('login') }}">Fazer login</a></span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
