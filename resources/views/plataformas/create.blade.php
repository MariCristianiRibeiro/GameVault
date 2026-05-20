@extends('layouts.app')

@section('title', 'Nova Plataforma | GameVault')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="panel-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="section-title">Cadastrar plataforma</h1>
                        <p class="text-secondary mb-0">Informe o nome da plataforma.</p>
                    </div>
                    <a class="btn btn-soft" href="{{ route('plataformas.index') }}">Voltar</a>
                </div>

                <form method="POST" action="{{ route('plataformas.store') }}" class="row g-3">
                    @csrf
                    <div class="col-12">
                        <label class="form-label fw-semibold" for="nome">Nome</label>
                        <input class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" type="text" value="{{ old('nome') }}" placeholder="Ex.: PC, PS5, Xbox Series" required>
                        @error('nome')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 d-flex gap-2">
                        <button class="btn btn-brand" type="submit">Salvar plataforma</button>
                        <a class="btn btn-accent" href="{{ route('plataformas.index') }}">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
