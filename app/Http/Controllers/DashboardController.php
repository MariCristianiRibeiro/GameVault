<?php

namespace App\Http\Controllers;

use App\Models\Jogo;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $baseQuery = $request->user()->jogos();

        $estatisticas = [
            'total' => (clone $baseQuery)->count(),
            'finalizados' => (clone $baseQuery)->where('status', 'Finalizado')->count(),
            'jogando' => (clone $baseQuery)->where('status', 'Jogando')->count(),
            'backlog' => (clone $baseQuery)->where('status', 'Backlog')->count(),
            'horas' => (clone $baseQuery)->sum('horas_jogadas'),
            'media_notas' => round((float) ((clone $baseQuery)->whereNotNull('nota')->avg('nota') ?? 0), 1),
        ];

        $jogosRecentes = $request->user()
            ->jogos()
            ->with(['plataforma', 'genero', 'desenvolvedora'])
            ->latest()
            ->take(5)
            ->get();

        $graficoStatus = [
            'labels' => Jogo::STATUSS,
            'values' => collect(Jogo::STATUSS)->map(
                fn (string $status) => $request->user()->jogos()->where('status', $status)->count()
            )->values(),
        ];

        return view('dashboard', compact('estatisticas', 'jogosRecentes', 'graficoStatus'));
    }
}
