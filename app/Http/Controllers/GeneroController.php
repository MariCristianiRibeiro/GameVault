<?php

namespace App\Http\Controllers;

use App\Models\Genero;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class GeneroController extends Controller
{
    public function index(Request $request): View
    {
        //jbjhgjhgjhk
        $busca = trim((string) $request->input('q'));

        $generos = Genero::query()
            ->when($busca !== '', fn ($query) => $query->where('nome', 'like', '%' . $busca . '%'))
            ->orderBy('nome')
            ->paginate(10)
            ->withQueryString();

        return view('generos.index', compact('generos', 'busca'));
    }

    public function create(): View
    {
        return view('generos.create');
    }

    public function store(Request $request): RedirectResponse
    {
        Genero::create($this->validar($request));

        return redirect()->route('generos.index')->with('success', 'Gênero cadastrado com sucesso.');
    }

    public function edit(string $genero): View
    {
        $genero = $this->findByEncryptedId(Genero::class, $genero);

        return view('generos.edit', compact('genero'));
    }

    public function update(Request $request, string $genero): RedirectResponse
    {
        /** @var Genero $generoModel */
        $generoModel = $this->findByEncryptedId(Genero::class, $genero);
        $generoModel->update($this->validar($request, $generoModel));

        return redirect()->route('generos.index')->with('success', 'Gênero atualizado com sucesso.');
    }

    public function destroy(string $genero): RedirectResponse
    {
        /** @var Genero $generoModel */
        $generoModel = $this->findByEncryptedId(Genero::class, $genero);

        try {
            $generoModel->delete();

            return redirect()->route('generos.index')->with('success', 'Gênero removido com sucesso.');
        } catch (QueryException) {
            return redirect()->route('generos.index')
                ->with('error', 'Não foi possível excluir o gênero porque ele está vinculado a um jogo.');
        }
    }

    private function validar(Request $request, ?Genero $genero = null): array
    {
        return $request->validate([
            'nome' => [
                'required',
                'string',
                'max:100',
                Rule::unique('generos', 'nome')->ignore($genero),
            ],
        ], [
            'nome.required' => 'Informe o nome do gênero.',
            'nome.unique' => 'Este gênero já está cadastrado.',
        ]);
    }
}
