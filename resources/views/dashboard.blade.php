@extends('layouts.app')

@section('title', 'Dashboard | GameVault')

@section('content')
    <section class="hero-card p-4 p-lg-5 mb-4">
        <div class="row g-4 align-items-center">
            <div class="col-lg-7">
                <span class="meta-chip mb-3"><i class="fa-solid fa-chart-pie"></i> Dashboard</span>
                <h1 class="display-6 fw-bold mb-3">Sua coleção, seu ritmo.</h1>
                <p class="text-secondary mb-4">Veja tudo rapidamente e siga para o próximo jogo.</p>
                <div class="d-flex flex-wrap gap-3">
                    <a class="btn btn-brand" href="{{ route('jogos.create') }}">Cadastrar jogo</a>
                    <a class="btn btn-soft" href="{{ route('pesquisa.index') }}">Abrir pesquisa</a>
                    <a class="btn btn-accent" href="{{ route('plataformas.index') }}">Gerenciar cadastros</a>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="panel-card">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2 class="section-title">Distribuição de status</h2>
                        <span class="meta-chip"><i class="fa-solid fa-layer-group"></i> Status</span>
                    </div>
                    <canvas id="statusChart" height="240"></canvas>
                </div>
            </div>
        </div>
    </section>

    <section class="row g-4 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-label">Total de jogos</div>
                <div class="stat-value mt-2">{{ $estatisticas['total'] }}</div>
                <p class="mb-0 text-secondary">Na biblioteca.</p>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-label">Finalizados</div>
                <div class="stat-value mt-2">{{ $estatisticas['finalizados'] }}</div>
                <p class="mb-0 text-secondary">Concluídos.</p>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-label">Horas jogadas</div>
                <div class="stat-value mt-2">{{ $estatisticas['horas'] }}</div>
                <p class="mb-0 text-secondary">Acumuladas.</p>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-label">Média de notas</div>
                <div class="stat-value mt-2">{{ number_format($estatisticas['media_notas'], 1, ',', '.') }}</div>
                <p class="mb-0 text-secondary">Das avaliações.</p>
            </div>
        </div>
    </section>

    <section class="row g-4">
        <div class="col-lg-8">
            <div class="panel-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="section-title">Jogos recentes</h2>
                    <a class="btn btn-sm btn-soft" href="{{ route('jogos.index') }}">Ver biblioteca completa</a>
                </div>

                @if ($jogosRecentes->isEmpty())
                    <div class="empty-state">
                        <h3 class="h5 mb-2">Sua biblioteca ainda está vazia</h3>
                        <p class="text-secondary mb-3">Adicione seu primeiro jogo para começar.</p>
                        <a class="btn btn-brand" href="{{ route('jogos.create') }}">Cadastrar primeiro jogo</a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Jogo</th>
                                    <th>Status</th>
                                    <th>Plataforma</th>
                                    <th>Horas</th>
                                    <th>Nota</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jogosRecentes as $jogo)
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
                                            <small class="text-secondary">{{ $jogo->genero->nome }} - {{ $jogo->desenvolvedora->nome }}</small>
                                        </td>
                                        <td><span class="status-pill {{ $statusClass }}">{{ $jogo->status }}</span></td>
                                        <td>{{ $jogo->plataforma->nome }}</td>
                                        <td>{{ $jogo->horas_jogadas }} h</td>
                                        <td>{{ $jogo->nota !== null ? number_format((float) $jogo->nota, 1, ',', '.') : 'Sem nota' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-lg-4">
                <div class="panel-card h-100">
                <h2 class="section-title mb-3">Resumo rápido</h2>
                <div class="d-grid gap-3">
                    <div class="stat-card shadow-none">
                        <div class="stat-label">Jogando agora</div>
                        <div class="stat-value mt-2">{{ $estatisticas['jogando'] }}</div>
                    </div>
                    <div class="stat-card shadow-none">
                        <div class="stat-label">Backlog</div>
                        <div class="stat-value mt-2">{{ $estatisticas['backlog'] }}</div>
                    </div>
                    <div class="panel-card bg-transparent shadow-none border">
                        <p class="mb-2 fw-semibold">Acesso rápido</p>
                        <p class="text-secondary mb-3">Abra sua pesquisa e encontre qualquer título.</p>
                        <a class="btn btn-soft w-100" href="{{ route('pesquisa.index') }}">Ir para pesquisa</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        const chart = document.getElementById('statusChart');

        if (chart) {
            new Chart(chart, {
                type: 'doughnut',
                data: {
                    labels: @json($graficoStatus['labels']),
                    datasets: [{
                        data: @json($graficoStatus['values']),
                        backgroundColor: ['#60a5fa', '#a855f7', '#d946ef'],
                        borderWidth: 0
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }
    </script>
@endpush
