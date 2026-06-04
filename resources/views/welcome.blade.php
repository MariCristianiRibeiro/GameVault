@extends('layouts.app')

@section('title', 'GameVault | Sua biblioteca de games')

@section('content')
    <section class="hero-card p-4 p-lg-5">
        <div class="hero-grid align-items-center">
            <div>
                <span class="meta-chip mb-3"><i class="fa-solid fa-shield-halved"></i> Sua biblioteca</span>
                <h1 class="display-5 fw-bold mb-3">Todos os seus jogos em um so lugar.</h1>
                <p class="lead text-secondary mb-4">Entre, cadastre e acompanhe sua coleção do seu jeito.</p>
                <div class="d-flex flex-wrap gap-3">
                    <a class="btn btn-brand btn-lg" href="{{ route('register') }}">Criar conta</a>
                    <a class="btn btn-soft btn-lg" href="{{ route('login') }}">Já tenho login</a>
                </div>
            </div>

            <div class="hero-accent">
                <div class="row g-3">
                    <div class="col-12">
                        <div class="stat-card p-4">
                            <div class="stat-label">Atalhos</div>
                            <div class="mt-3 d-grid gap-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>Adicionar jogos</span>
                                    <strong>Rapido</strong>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>Buscar na colecao</span>
                                    <strong>Filtros</strong>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>Acompanhar progresso</span>
                                    <strong>Status</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="stat-card">
                            <div class="stat-label">Controle</div>
                            <div class="stat-value mt-2">Play</div>
                            <p class="mb-0 text-secondary">Sua lista sempre por perto.</p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="stat-card">
                            <div class="stat-label">Acesso</div>
                            <div class="stat-value mt-2">Now</div>
                            <p class="mb-0 text-secondary">Entre e continue de onde parou.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="row g-4 mt-2">
        <div class="col-lg-4">
            <div class="panel-card h-100">
                <h2 class="section-title mb-3">Jogando</h2>
                <p class="text-secondary mb-0">Veja o que está em andamento sem perder o ritmo.</p>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="panel-card h-100">
                <h2 class="section-title mb-3">Backlog</h2>
                <p class="text-secondary mb-0">Separe os próximos títulos da sua fila.</p>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="panel-card h-100">
                <h2 class="section-title mb-3">Finalizados</h2>
                <p class="text-secondary mb-0">Guarde seu historico e suas notas favoritas.</p>
            </div>
        </div>
    </section>
@endsection
