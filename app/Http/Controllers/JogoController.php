<?php

//localização
namespace App\Http\Controllers;

//importando funcionalidades
use App\Models\Desenvolvedora;
use App\Models\Genero;
use App\Models\Jogo;
use App\Models\Plataforma;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

////jogo herdando funcionalidades de Controller
class JogoController extends Controller
{
    //todos os filtros e de quem esta logado
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
        
            //retorno para o usuario ver o resultado
        return view('jogos.index', [
            'jogos' => $jogos,
            'filtros' => $filtros,
            ...$this->opcoesRelacionamentos(),
        ]);
    }

    //criando um novo jogo
    public function create(): View
    {
        return view('jogos.create', $this->opcoesRelacionamentos());
    }

    //quando clicar em salvar
    public function store(Request $request): RedirectResponse
    {
        $dados = $this->validar($request);
        $dados['user_id'] = $request->user()->id;
        $dados['horas_jogadas'] = $dados['horas_jogadas'] ?? 0;

        //se salvar uma imagem de capa do jogo a url
        if ($request->hasFile('imagem_arquivo')) {
            $dados['imagem_url'] = $this->salvarImagemDoArquivo($request->file('imagem_arquivo'));
        }

        //jogo cadastrado
        Jogo::create($dados);

        return redirect()->route('jogos.index')->with('success', 'Jogo cadastrado com sucesso.');
    }

    //busca por detalhes
    public function show(Request $request, string $jogo): View
    {
        $jogo = $this->buscarJogoDoUsuario($request, $jogo);

        return view('jogos.show', compact('jogo'));
    }

    //editar o jogo
    public function edit(Request $request, string $jogo): View
    {
        $jogo = $this->buscarJogoDoUsuario($request, $jogo);

        return view('jogos.edit', [
            'jogo' => $jogo,
            ...$this->opcoesRelacionamentos(),
        ]);
    }

    //atualiza o jogo
    public function update(Request $request, string $jogo): RedirectResponse
    {
        $jogoModel = $this->buscarJogoDoUsuario($request, $jogo);
        $dados = $this->validar($request);
        $dados['horas_jogadas'] = $dados['horas_jogadas'] ?? 0;

        //se é uma capa nova
        if ($request->hasFile('imagem_arquivo')) {
            if ($jogoModel->imagem_url && str_contains($jogoModel->imagem_url, '/storage/jogos/')) {
                $oldPath = str_replace('/storage/jogos/', '', $jogoModel->imagem_url);
                Storage::disk('public')->delete('jogos/' . $oldPath);
            }
            $dados['imagem_url'] = $this->salvarImagemDoArquivo($request->file('imagem_arquivo'));
        }

        //atualiza o jogo
        $jogoModel->update($dados);

        return redirect()->route('jogos.index')->with('success', 'Jogo atualizado com sucesso.');
    }

    //excluir o jogo
    public function destroy(Request $request, string $jogo): RedirectResponse
    {
        $jogoModel = $this->buscarJogoDoUsuario($request, $jogo);
        $jogoModel->delete();

        return redirect()->route('jogos.index')->with('success', 'Jogo removido com sucesso.');
    }

    //traz do banco as informações na ordem alfabética 
    {
        return [
            'plataformas' => Plataforma::query()->orderBy('nome')->get(),
            'generos' => Genero::query()->orderBy('nome')->get(),
            'desenvolvedoras' => Desenvolvedora::query()->orderBy('nome')->get(),
            'statusDisponiveis' => Jogo::STATUSS,
        ];
    }

    //validações
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
            'imagem_url' => ['nullable', 'url', 'max:500'],
            'imagem_arquivo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,gif', 'max:5120'],
        ], [
            'titulo.required' => 'Informe o título do jogo.',
            'horas_jogadas.integer' => 'As horas jogadas devem ser um número inteiro.',
            'horas_jogadas.min' => 'As horas jogadas não podem ser negativas.',
            'nota.numeric' => 'Informe uma nota numérica.',
            'nota.between' => 'A nota deve ficar entre 0 e 10.',
            'status.required' => 'Selecione o status do jogo.',
            'plataforma_id.required' => 'Selecione uma plataforma.',
            'genero_id.required' => 'Selecione um gênero.',
            'desenvolvedora_id.required' => 'Selecione uma desenvolvedora.',
            'imagem_url.url' => 'Informe uma URL válida para a capa do jogo.',
            'imagem_url.max' => 'A URL da imagem é muito longa.',
            'imagem_arquivo.image' => 'O arquivo deve ser uma imagem válida.',
            'imagem_arquivo.mimes' => 'A imagem deve estar em formato JPEG, PNG, WebP ou GIF.',
            'imagem_arquivo.max' => 'A imagem não pode ter mais de 5MB.',
        ]);
    }

    //para tratar a imagem enviada
    private function salvarImagemDoArquivo($arquivo): ?string
    {
        if (! $arquivo) {
            return null;
        }

        $filename = 'capa_' . time() . '_' . uniqid() . '.' . $arquivo->getClientOriginalExtension();
        Storage::disk('public')->putFileAs('jogos', $arquivo, $filename);

        return '/storage/jogos/' . $filename;
    }

    //organiza os filtros
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

    //segurança para buscar apenas os jogos do logado
    private function buscarJogoDoUsuario(Request $request, string $jogo): Jogo
    {
        return Jogo::query()
            ->with(['plataforma', 'genero', 'desenvolvedora'])
            ->where('user_id', $request->user()->id)
            ->findOrFail($this->decryptRouteKey($jogo));
    }
}
