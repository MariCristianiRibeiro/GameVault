@extends('layouts.app')

@section('title', 'Pesquisa | GameVault')

@section('content')
    <section class="hero-card p-4 p-lg-5 mb-4">
        <div class="row g-4 align-items-end">
            <div class="col-lg-5">
                <span class="meta-chip mb-3"><i class="fa-solid fa-magnifying-glass"></i> Tela de pesquisa</span>
                <h1 class="display-6 fw-bold mb-3">Encontre qualquer jogo da sua biblioteca em segundos.</h1>
                <p class="text-secondary mb-0">Pesquise e filtre sua coleção.</p>
            </div>
            <div class="col-lg-7">
                <form method="GET" action="{{ route('pesquisa.index') }}" class="row g-3">
                    <div class="col-12">
                        <input class="form-control" name="q" type="text" value="{{ $filtros['q'] }}" placeholder="Pesquisar por título ou descrição">
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <select class="form-select" name="status">
                            <option value="">Todos os status</option>
                            @foreach ($statusDisponiveis as $status)
                                <option value="{{ $status }}" @selected($filtros['status'] === $status)>{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <select class="form-select" name="plataforma_id">
                            <option value="">Todas as plataformas</option>
                            @foreach ($plataformas as $plataforma)
                                <option value="{{ $plataforma->id }}" @selected((string) $filtros['plataforma_id'] === (string) $plataforma->id)>{{ $plataforma->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <select class="form-select" name="genero_id">
                            <option value="">Todos os gêneros</option>
                            @foreach ($generos as $genero)
                                <option value="{{ $genero->id }}" @selected((string) $filtros['genero_id'] === (string) $genero->id)>{{ $genero->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <select class="form-select" name="desenvolvedora_id">
                            <option value="">Todas as desenvolvedoras</option>
                            @foreach ($desenvolvedoras as $desenvolvedora)
                                <option value="{{ $desenvolvedora->id }}" @selected((string) $filtros['desenvolvedora_id'] === (string) $desenvolvedora->id)>{{ $desenvolvedora->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <select class="form-select" name="ordem">
                            <option value="recentes" @selected($filtros['ordem'] === 'recentes')>Mais recentes</option>
                            <option value="titulo_asc" @selected($filtros['ordem'] === 'titulo_asc')>Título A-Z</option>
                            <option value="titulo_desc" @selected($filtros['ordem'] === 'titulo_desc')>Título Z-A</option>
                            <option value="nota_desc" @selected($filtros['ordem'] === 'nota_desc')>Melhor nota</option>
                            <option value="mais_jogados" @selected($filtros['ordem'] === 'mais_jogados')>Mais jogados</option>
                        </select>
                    </div>
                    <div class="col-md-6 d-flex gap-2">
                        <button class="btn btn-brand w-100" type="submit">Pesquisar</button>
                        <a class="btn btn-accent w-100" href="{{ route('pesquisa.index') }}">Limpar</a>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">
        <div>
            <h2 class="section-title">Resultados encontrados</h2>
            <p class="text-secondary mb-0">{{ $jogos->total() }} jogo(s) localizado(s) com os filtros atuais.</p>
        </div>
        <a class="btn btn-soft" href="{{ route('jogos.create') }}">Cadastrar novo jogo</a>
    </div>

    @if ($jogos->isEmpty())
        <div class="panel-card empty-state">
            <h3 class="h5 mb-2">Nenhum resultado encontrado</h3>
            <p class="text-secondary mb-3">Tente outro termo ou ajuste os filtros.</p>
            <a class="btn btn-brand" href="{{ route('jogos.index') }}">Voltar para biblioteca</a>
        </div>
    @else
        <div class="row g-4">
            @foreach ($jogos as $jogo)
                @php
                    $statusClass = match ($jogo->status) {
                        'Finalizado' => 'status-finalizado',
                        'Backlog' => 'status-backlog',
                        default => 'status-jogando',
                    };
                @endphp
                <div class="col-md-6 col-xl-4">
                    <div class="panel-card game-card">
                        <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                            <div>
                                <span class="status-pill {{ $statusClass }}">{{ $jogo->status }}</span>
                                <h3 class="h5 mt-3 mb-1">{{ $jogo->titulo }}</h3>
                                <p class="text-secondary mb-0">{{ $jogo->plataforma->nome }} - {{ $jogo->genero->nome }}</p>
                            </div>
                            <span class="meta-chip">{{ $jogo->horas_jogadas }} h</span>
                        </div>

                        <p class="text-secondary">{{ \Illuminate\Support\Str::limit($jogo->descricao ?? 'Sem descrição cadastrada.', 110) }}</p>

                        <div class="d-flex flex-wrap gap-2 mb-3">
                            <span class="meta-chip"><i class="fa-solid fa-building"></i> {{ $jogo->desenvolvedora->nome }}</span>
                            <span class="meta-chip"><i class="fa-solid fa-star"></i> {{ $jogo->nota !== null ? number_format((float) $jogo->nota, 1, ',', '.') : 'Sem nota' }}</span>
                        </div>

                        <div class="action-btns mt-auto">
                            <a class="btn btn-sm btn-soft" href="{{ route('jogos.show', $jogo->route_key) }}">Detalhes</a>
                            <a class="btn btn-sm btn-soft" href="{{ route('jogos.edit', $jogo->route_key) }}">Editar</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $jogos->links() }}
        </div>
    @endif
@endsection
