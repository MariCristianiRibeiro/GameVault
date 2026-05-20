@extends('layouts.app')

@section('title', 'Plataformas | GameVault')

@section('content')
    <div class="panel-card">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">
            <div>
                <h1 class="section-title">Plataformas</h1>
                <p class="text-secondary mb-0">Lista de plataformas.</p>
            </div>
            <a class="btn btn-brand" href="{{ route('plataformas.create') }}">Nova plataforma</a>
        </div>

        <form method="GET" action="{{ route('plataformas.index') }}" class="row g-3 mb-4">
            <div class="col-md-8">
                <input class="form-control" name="q" type="text" placeholder="Pesquisar por nome..." value="{{ $busca }}">
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button class="btn btn-soft w-100" type="submit">Pesquisar</button>
                <a class="btn btn-accent w-100" href="{{ route('plataformas.index') }}">Limpar</a>
            </div>
        </form>

        @if ($plataformas->isEmpty())
            <div class="empty-state">
                <h2 class="h5 mb-2">Nenhuma plataforma cadastrada</h2>
                <p class="text-secondary mb-3">Adicione a primeira plataforma.</p>
                <a class="btn btn-brand" href="{{ route('plataformas.create') }}">Cadastrar plataforma</a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Criado em</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($plataformas as $plataforma)
                            <tr>
                                <td class="fw-semibold">{{ $plataforma->nome }}</td>
                                <td>{{ $plataforma->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <div class="action-btns justify-content-end">
                                        <a class="btn btn-sm btn-soft" href="{{ route('plataformas.edit', $plataforma->route_key) }}">Editar</a>
                                        <form method="POST" action="{{ route('plataformas.destroy', $plataforma->route_key) }}" data-confirm="Excluir plataforma?" data-confirm-text="Jogos vinculados impedem a exclusão.">
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
                {{ $plataformas->links() }}
            </div>
        @endif
    </div>
@endsection
