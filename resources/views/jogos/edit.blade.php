@extends('layouts.app')

@section('title', 'Editar Jogo | GameVault')

@section('content')
    <div class="row justify-content-center">
        <div class="col-xl-10">
            <div class="panel-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="section-title">Editar jogo</h1>
                        <p class="text-secondary mb-0">Atualize os dados do jogo.</p>
                    </div>
                    <a class="btn btn-soft" href="{{ route('jogos.index') }}">Voltar</a>
                </div>

                <form method="POST" action="{{ route('jogos.update', $jogo->route_key) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @include('jogos._form')

                    <div class="d-flex flex-wrap gap-2 mt-4">
                        <button class="btn btn-brand" type="submit">Atualizar jogo</button>
                        <a class="btn btn-accent" href="{{ route('jogos.index') }}">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
