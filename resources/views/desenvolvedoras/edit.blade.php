@extends('layouts.app')

@section('title', 'Editar Desenvolvedora | GameVault')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="panel-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="section-title">Editar desenvolvedora</h1>
                        <p class="text-secondary mb-0">Atualize o nome da desenvolvedora.</p>
                    </div>
                    <a class="btn btn-soft" href="{{ route('desenvolvedoras.index') }}">Voltar</a>
                </div>

                <form method="POST" action="{{ route('desenvolvedoras.update', $desenvolvedora->route_key) }}" class="row g-3">
                    @csrf
                    @method('PUT')
                    <div class="col-12">
                        <label class="form-label fw-semibold" for="nome">Nome</label>
                        <input class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" type="text" value="{{ old('nome', $desenvolvedora->nome) }}" required>
                        @error('nome')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 d-flex gap-2">
                        <button class="btn btn-brand" type="submit">Atualizar desenvolvedora</button>
                        <a class="btn btn-accent" href="{{ route('desenvolvedoras.index') }}">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
