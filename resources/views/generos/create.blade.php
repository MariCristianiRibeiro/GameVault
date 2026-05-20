@extends('layouts.app')

@section('title', 'Novo Gênero | GameVault')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="panel-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="section-title">Cadastrar gênero</h1>
                        <p class="text-secondary mb-0">Informe o nome do gênero.</p>
                    </div>
                    <a class="btn btn-soft" href="{{ route('generos.index') }}">Voltar</a>
                </div>

                <form method="POST" action="{{ route('generos.store') }}" class="row g-3">
                    @csrf
                    <div class="col-12">
                        <label class="form-label fw-semibold" for="nome">Nome</label>
                        <input class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" type="text" value="{{ old('nome') }}" placeholder="Ex.: RPG, Corrida, Aventura" required>
                        @error('nome')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 d-flex gap-2">
                        <button class="btn btn-brand" type="submit">Salvar gênero</button>
                        <a class="btn btn-accent" href="{{ route('generos.index') }}">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
