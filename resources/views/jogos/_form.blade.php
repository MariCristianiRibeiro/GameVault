@php
    $cadastrosProntos = $plataformas->isNotEmpty() && $generos->isNotEmpty() && $desenvolvedoras->isNotEmpty();
@endphp

@if (! $cadastrosProntos)
    <div class="alert alert-warning border-0 rounded-4">
        Cadastre ao menos uma plataforma, um gênero e uma desenvolvedora antes de salvar jogos.
        <div class="d-flex flex-wrap gap-2 mt-3">
            <a class="btn btn-sm btn-soft" href="{{ route('plataformas.create') }}">Nova plataforma</a>
            <a class="btn btn-sm btn-soft" href="{{ route('generos.create') }}">Novo gênero</a>
            <a class="btn btn-sm btn-soft" href="{{ route('desenvolvedoras.create') }}">Nova desenvolvedora</a>
        </div>
    </div>
@endif

<div class="row g-3">
    <div class="col-md-8">
        <label class="form-label fw-semibold" for="titulo">Título</label>
        <input class="form-control @error('titulo') is-invalid @enderror" id="titulo" name="titulo" type="text" value="{{ old('titulo', $jogo->titulo ?? '') }}" required>
        @error('titulo')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold" for="status">Status</label>
        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
            @foreach ($statusDisponiveis as $status)
                <option value="{{ $status }}" @selected(old('status', $jogo->status ?? 'Backlog') === $status)>{{ $status }}</option>
            @endforeach
        </select>
        @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold" for="plataforma_id">Plataforma</label>
        <select class="form-select @error('plataforma_id') is-invalid @enderror" id="plataforma_id" name="plataforma_id" required>
            <option value="">Selecione</option>
            @foreach ($plataformas as $plataforma)
                <option value="{{ $plataforma->id }}" @selected((string) old('plataforma_id', $jogo->plataforma_id ?? '') === (string) $plataforma->id)>{{ $plataforma->nome }}</option>
            @endforeach
        </select>
        @error('plataforma_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold" for="genero_id">Gênero</label>
        <select class="form-select @error('genero_id') is-invalid @enderror" id="genero_id" name="genero_id" required>
            <option value="">Selecione</option>
            @foreach ($generos as $genero)
                <option value="{{ $genero->id }}" @selected((string) old('genero_id', $jogo->genero_id ?? '') === (string) $genero->id)>{{ $genero->nome }}</option>
            @endforeach
        </select>
        @error('genero_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold" for="desenvolvedora_id">Desenvolvedora</label>
        <select class="form-select @error('desenvolvedora_id') is-invalid @enderror" id="desenvolvedora_id" name="desenvolvedora_id" required>
            <option value="">Selecione</option>
            @foreach ($desenvolvedoras as $desenvolvedora)
                <option value="{{ $desenvolvedora->id }}" @selected((string) old('desenvolvedora_id', $jogo->desenvolvedora_id ?? '') === (string) $desenvolvedora->id)>{{ $desenvolvedora->nome }}</option>
            @endforeach
        </select>
        @error('desenvolvedora_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold" for="horas_jogadas">Horas jogadas</label>
        <input class="form-control @error('horas_jogadas') is-invalid @enderror" id="horas_jogadas" name="horas_jogadas" type="number" min="0" value="{{ old('horas_jogadas', $jogo->horas_jogadas ?? 0) }}">
        @error('horas_jogadas')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold" for="nota">Nota</label>
        <input class="form-control @error('nota') is-invalid @enderror" id="nota" name="nota" type="number" min="0" max="10" step="0.1" value="{{ old('nota', $jogo->nota ?? '') }}" placeholder="0 a 10">
        @error('nota')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold" for="data_lancamento">Data de lançamento</label>
        <input class="form-control @error('data_lancamento') is-invalid @enderror" id="data_lancamento" name="data_lancamento" type="date" value="{{ old('data_lancamento', isset($jogo) && $jogo->data_lancamento ? $jogo->data_lancamento->format('Y-m-d') : '') }}">
        @error('data_lancamento')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold" for="descricao">Descrição</label>
        <textarea class="form-control @error('descricao') is-invalid @enderror" id="descricao" name="descricao" rows="5" placeholder="Anote o que faz esse jogo ser especial para você.">{{ old('descricao', $jogo->descricao ?? '') }}</textarea>
        @error('descricao')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
