@extends('layouts.app')

@section('title', 'Detalhes do Jogo | GameVault')

@section('content')
    @php
        $statusClass = match ($jogo->status) {
            'Finalizado' => 'status-finalizado',
            'Backlog' => 'status-backlog',
            default => 'status-jogando',
        };
    @endphp

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="panel-card h-100">
                <div class="d-flex flex-wrap justify-content-between gap-3 mb-4">
                    <div>
                        <span class="status-pill {{ $statusClass }}">{{ $jogo->status }}</span>
                        <h1 class="display-6 fw-bold mt-3 mb-2">{{ $jogo->titulo }}</h1>
                        <p class="text-secondary mb-0">Registrado em {{ $jogo->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <a class="btn btn-soft" href="{{ route('jogos.edit', $jogo->route_key) }}">Editar</a>
                        <a class="btn btn-accent" href="{{ route('jogos.index') }}">Voltar</a>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-4"><span class="meta-chip"><i class="fa-solid fa-desktop"></i> {{ $jogo->plataforma->nome }}</span></div>
                    <div class="col-md-4"><span class="meta-chip"><i class="fa-solid fa-tags"></i> {{ $jogo->genero->nome }}</span></div>
                    <div class="col-md-4"><span class="meta-chip"><i class="fa-solid fa-building"></i> {{ $jogo->desenvolvedora->nome }}</span></div>
                </div>

                <div class="panel-card bg-transparent shadow-none border">
                    <h2 class="section-title mb-3">Descrição</h2>
                    <p class="mb-0 text-secondary">{{ $jogo->descricao ?: 'Nenhuma descrição cadastrada para este jogo.' }}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="panel-card">
                @if($jogo->imagem_url)
                    <div class="mb-3 text-center">
                        <img src="{{ $jogo->imagem_url }}" alt="Capa de {{ $jogo->titulo }}" class="img-fluid rounded" style="max-height:400px; width:auto;">
                    </div>
                @endif
                <h2 class="section-title mb-4">Informações adicionais</h2>
                <dl class="detail-list mb-0">
                    <dt>Horas jogadas</dt>
                    <dd>{{ $jogo->horas_jogadas }} horas</dd>

                    <dt>Nota</dt>
                    <dd>{{ $jogo->nota !== null ? number_format((float) $jogo->nota, 1, ',', '.') : 'Sem avaliação' }}</dd>

                    <dt>Data de lançamento</dt>
                    <dd>{{ $jogo->data_lancamento?->format('d/m/Y') ?? 'Não informada' }}</dd>

                    <dt>Última atualização</dt>
                    <dd>{{ $jogo->updated_at->format('d/m/Y H:i') }}</dd>
                </dl>
            </div>
        </div>
    </div>
@endsection
