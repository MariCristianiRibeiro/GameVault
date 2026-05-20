@extends('layouts.app')

@section('title', 'Gêneros | GameVault')

@section('content')
    <div class="panel-card">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">
            <div>
                <h1 class="section-title">Gêneros</h1>
                <p class="text-secondary mb-0">Lista de gêneros.</p>
            </div>
            <a class="btn btn-brand" href="{{ route('generos.create') }}">Novo gênero</a>
        </div>

        <form method="GET" action="{{ route('generos.index') }}" class="row g-3 mb-4">
            <div class="col-md-8">
                <input class="form-control" name="q" type="text" placeholder="Pesquisar por nome..." value="{{ $busca }}">
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button class="btn btn-soft w-100" type="submit">Pesquisar</button>
                <a class="btn btn-accent w-100" href="{{ route('generos.index') }}">Limpar</a>
            </div>
        </form>

        @if ($generos->isEmpty())
            <div class="empty-state">
                <h2 class="h5 mb-2">Nenhum gênero cadastrado</h2>
                <p class="text-secondary mb-3">Adicione o primeiro gênero.</p>
                <a class="btn btn-brand" href="{{ route('generos.create') }}">Cadastrar gênero</a>
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
                        @foreach ($generos as $genero)
                            <tr>
                                <td class="fw-semibold">{{ $genero->nome }}</td>
                                <td>{{ $genero->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <div class="action-btns justify-content-end">
                                        <a class="btn btn-sm btn-soft" href="{{ route('generos.edit', $genero->route_key) }}">Editar</a>
                                        <form method="POST" action="{{ route('generos.destroy', $genero->route_key) }}" data-confirm="Excluir gênero?" data-confirm-text="Jogos vinculados impedem a exclusão.">
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
                {{ $generos->links() }}
            </div>
        @endif
    </div>
@endsection
