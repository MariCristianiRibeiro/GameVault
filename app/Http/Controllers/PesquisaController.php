<?php

namespace App\Http\Controllers;

use App\Models\Desenvolvedora;
use App\Models\Genero;
use App\Models\Jogo;
use App\Models\Plataforma;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PesquisaController extends Controller
{
    public function index(Request $request): View
    {
        $filtros = [
            'q' => trim((string) $request->input('q')),
            'status' => $request->input('status'),
            'plataforma_id' => $request->input('plataforma_id'),
            'genero_id' => $request->input('genero_id'),
            'desenvolvedora_id' => $request->input('desenvolvedora_id'),
            'ordem' => $request->input('ordem', 'recentes'),
        ];

        $jogos = Jogo::query()
            ->with(['plataforma', 'genero', 'desenvolvedora'])
            ->doUsuario((int) $request->user()->id)
            ->pesquisar($filtros['q'])
            ->filtrar($filtros)
            ->ordenar($filtros['ordem'])
            ->paginate(12)
            ->withQueryString();

        return view('pesquisa.index', [
            'jogos' => $jogos,
            'filtros' => $filtros,
            'plataformas' => Plataforma::query()->orderBy('nome')->get(),
            'generos' => Genero::query()->orderBy('nome')->get(),
            'desenvolvedoras' => Desenvolvedora::query()->orderBy('nome')->get(),
            'statusDisponiveis' => Jogo::STATUSS,
        ]);
    }
}
