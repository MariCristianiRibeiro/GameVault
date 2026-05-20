<?php

namespace App\Http\Controllers;

use App\Models\Desenvolvedora;
use App\Models\Genero;
use App\Models\Jogo;
use App\Models\Plataforma;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class JogoController extends Controller
{
    public function index(Request $request): View
    {
        $filtros = $this->filtros($request);

        $jogos = Jogo::query()
            ->with(['plataforma', 'genero', 'desenvolvedora'])
            ->doUsuario((int) $request->user()->id)
            ->pesquisar($filtros['q'])
            ->filtrar($filtros)
            ->ordenar($filtros['ordem'])
            ->paginate(10)
            ->withQueryString();

        return view('jogos.index', [
            'jogos' => $jogos,
            'filtros' => $filtros,
            ...$this->opcoesRelacionamentos(),
        ]);
    }

    public function create(): View
    {
        return view('jogos.create', $this->opcoesRelacionamentos());
    }

    public function store(Request $request): RedirectResponse
    {
        $dados = $this->validar($request);
        $dados['user_id'] = $request->user()->id;
        $dados['horas_jogadas'] = $dados['horas_jogadas'] ?? 0;

        Jogo::create($dados);

        return redirect()->route('jogos.index')->with('success', 'Jogo cadastrado com sucesso.');
    }

    public function show(Request $request, string $jogo): View
    {
        $jogo = $this->buscarJogoDoUsuario($request, $jogo);

        return view('jogos.show', compact('jogo'));
    }

    public function edit(Request $request, string $jogo): View
    {
        $jogo = $this->buscarJogoDoUsuario($request, $jogo);

        return view('jogos.edit', [
            'jogo' => $jogo,
            ...$this->opcoesRelacionamentos(),
        ]);
    }

    public function update(Request $request, string $jogo): RedirectResponse
    {
        $jogoModel = $this->buscarJogoDoUsuario($request, $jogo);
        $dados = $this->validar($request);
        $dados['horas_jogadas'] = $dados['horas_jogadas'] ?? 0;

        $jogoModel->update($dados);

        return redirect()->route('jogos.index')->with('success', 'Jogo atualizado com sucesso.');
    }

    public function destroy(Request $request, string $jogo): RedirectResponse
    {
        $jogoModel = $this->buscarJogoDoUsuario($request, $jogo);
        $jogoModel->delete();

        return redirect()->route('jogos.index')->with('success', 'Jogo removido com sucesso.');
    }

    private function opcoesRelacionamentos(): array
    {
        return [
            'plataformas' => Plataforma::query()->orderBy('nome')->get(),
            'generos' => Genero::query()->orderBy('nome')->get(),
            'desenvolvedoras' => Desenvolvedora::query()->orderBy('nome')->get(),
            'statusDisponiveis' => Jogo::STATUSS,
        ];
    }

    private function validar(Request $request): array
    {
        return $request->validate([
            'titulo' => ['required', 'string', 'max:150'],
            'descricao' => ['nullable', 'string'],
            'horas_jogadas' => ['nullable', 'integer', 'min:0'],
            'nota' => ['nullable', 'numeric', 'between:0,10'],
            'status' => ['required', Rule::in(Jogo::STATUSS)],
            'data_lancamento' => ['nullable', 'date'],
            'plataforma_id' => ['required', 'exists:plataformas,id'],
            'genero_id' => ['required', 'exists:generos,id'],
            'desenvolvedora_id' => ['required', 'exists:desenvolvedoras,id'],
        ], [
            'titulo.required' => 'Informe o titulo do jogo.',
            'horas_jogadas.integer' => 'As horas jogadas devem ser um numero inteiro.',
            'horas_jogadas.min' => 'As horas jogadas nao podem ser negativas.',
            'nota.numeric' => 'Informe uma nota numerica.',
            'nota.between' => 'A nota deve ficar entre 0 e 10.',
            'status.required' => 'Selecione o status do jogo.',
            'plataforma_id.required' => 'Selecione uma plataforma.',
            'genero_id.required' => 'Selecione um genero.',
            'desenvolvedora_id.required' => 'Selecione uma desenvolvedora.',
        ]);
    }

    private function filtros(Request $request): array
    {
        return [
            'q' => trim((string) $request->input('q')),
            'status' => $request->input('status'),
            'plataforma_id' => $request->input('plataforma_id'),
            'genero_id' => $request->input('genero_id'),
            'desenvolvedora_id' => $request->input('desenvolvedora_id'),
            'ordem' => $request->input('ordem', 'recentes'),
        ];
    }

    private function buscarJogoDoUsuario(Request $request, string $jogo): Jogo
    {
        return Jogo::query()
            ->with(['plataforma', 'genero', 'desenvolvedora'])
            ->where('user_id', $request->user()->id)
            ->findOrFail($this->decryptRouteKey($jogo));
    }
}
