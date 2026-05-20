@extends('layouts.app')

@section('title', 'Jogos | GameVault')

@section('content')
    <div class="panel-card mb-4">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">
                <div>
                <h1 class="section-title">Minha biblioteca</h1>
                <p class="text-secondary mb-0">Seus jogos cadastrados.</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a class="btn btn-soft" href="{{ route('pesquisa.index') }}">Tela de pesquisa</a>
                <a class="btn btn-brand" href="{{ route('jogos.create') }}">Novo jogo</a>
            </div>
        </div>

        <form method="GET" action="{{ route('jogos.index') }}" class="row g-3">
            <div class="col-lg-4">
                <label class="form-label fw-semibold" for="q">Pesquisar</label>
                <input class="form-control" id="q" name="q" type="text" value="{{ $filtros['q'] }}" placeholder="Título ou descrição">
            </div>
            <div class="col-md-6 col-lg-2">
                <label class="form-label fw-semibold" for="status">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="">Todos</option>
                    @foreach ($statusDisponiveis as $status)
                        <option value="{{ $status }}" @selected($filtros['status'] === $status)>{{ $status }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 col-lg-2">
                <label class="form-label fw-semibold" for="ordem">Ordenar por</label>
                <select class="form-select" id="ordem" name="ordem">
                    <option value="recentes" @selected($filtros['ordem'] === 'recentes')>Mais recentes</option>
                    <option value="titulo_asc" @selected($filtros['ordem'] === 'titulo_asc')>Título A-Z</option>
                    <option value="titulo_desc" @selected($filtros['ordem'] === 'titulo_desc')>Título Z-A</option>
                    <option value="nota_desc" @selected($filtros['ordem'] === 'nota_desc')>Melhor nota</option>
                    <option value="mais_jogados" @selected($filtros['ordem'] === 'mais_jogados')>Mais jogados</option>
                </select>
            </div>
            <div class="col-md-4 col-lg-2">
                <label class="form-label fw-semibold" for="plataforma_id">Plataforma</label>
                <select class="form-select" id="plataforma_id" name="plataforma_id">
                    <option value="">Todas</option>
                    @foreach ($plataformas as $plataforma)
                        <option value="{{ $plataforma->id }}" @selected((string) $filtros['plataforma_id'] === (string) $plataforma->id)>{{ $plataforma->nome }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 col-lg-2">
                <label class="form-label fw-semibold" for="genero_id">Gênero</label>
                <select class="form-select" id="genero_id" name="genero_id">
                    <option value="">Todos</option>
                    @foreach ($generos as $genero)
                        <option value="{{ $genero->id }}" @selected((string) $filtros['genero_id'] === (string) $genero->id)>{{ $genero->nome }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 col-lg-2">
                <label class="form-label fw-semibold" for="desenvolvedora_id">Desenvolvedora</label>
                <select class="form-select" id="desenvolvedora_id" name="desenvolvedora_id">
                    <option value="">Todas</option>
                    @foreach ($desenvolvedoras as $desenvolvedora)
                        <option value="{{ $desenvolvedora->id }}" @selected((string) $filtros['desenvolvedora_id'] === (string) $desenvolvedora->id)>{{ $desenvolvedora->nome }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 d-flex flex-wrap gap-2">
                <button class="btn btn-soft" type="submit">Aplicar filtros</button>
                <a class="btn btn-accent" href="{{ route('jogos.index') }}">Limpar</a>
            </div>
        </form>
    </div>

    <div class="panel-card">
        @if ($jogos->isEmpty())
            <div class="empty-state">
                <h2 class="h5 mb-2">Nenhum jogo encontrado</h2>
                <p class="text-secondary mb-3">Ajuste os filtros ou adicione um novo jogo.</p>
                <a class="btn btn-brand" href="{{ route('jogos.create') }}">Cadastrar jogo</a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Jogo</th>
                            <th>Status</th>
                            <th>Plataforma</th>
                            <th>Gênero</th>
                            <th>Horas</th>
                            <th>Nota</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jogos as $jogo)
                            @php
                                $statusClass = match ($jogo->status) {
                                    'Finalizado' => 'status-finalizado',
                                    'Backlog' => 'status-backlog',
                                    default => 'status-jogando',
                                };
                            @endphp
                            <tr>
                                <td>
                                    <div class="fw-semibold">{{ $jogo->titulo }}</div>
                                    <small class="text-secondary">{{ \Illuminate\Support\Str::limit($jogo->descricao ?? 'Sem descrição cadastrada.', 70) }}</small>
                                </td>
                                <td><span class="status-pill {{ $statusClass }}">{{ $jogo->status }}</span></td>
                                <td>{{ $jogo->plataforma->nome }}</td>
                                <td>{{ $jogo->genero->nome }}</td>
                                <td>{{ $jogo->horas_jogadas }} h</td>
                                <td>{{ $jogo->nota !== null ? number_format((float) $jogo->nota, 1, ',', '.') : '--' }}</td>
                                <td>
                                    <div class="action-btns justify-content-end">
                                        <a class="btn btn-sm btn-soft" href="{{ route('jogos.show', $jogo->route_key) }}">Ver</a>
                                        <a class="btn btn-sm btn-soft" href="{{ route('jogos.edit', $jogo->route_key) }}">Editar</a>
                                        <form method="POST" action="{{ route('jogos.destroy', $jogo->route_key) }}" data-confirm="Excluir jogo?" data-confirm-text="O registro sera removido da sua biblioteca.">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-accent" type="submit">Excluir</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $jogos->links() }}
            </div>
        @endif
    </div>
@endsection
