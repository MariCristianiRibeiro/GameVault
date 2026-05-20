<?php

namespace App\Http\Controllers;

use App\Models\Plataforma;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PlataformaController extends Controller
{
    public function index(Request $request): View
    {
        $busca = trim((string) $request->input('q'));

        $plataformas = Plataforma::query()
            ->when($busca !== '', fn ($query) => $query->where('nome', 'like', '%' . $busca . '%'))
            ->orderBy('nome')
            ->paginate(10)
            ->withQueryString();

        return view('plataformas.index', compact('plataformas', 'busca'));
    }

    public function create(): View
    {
        return view('plataformas.create');
    }

    public function store(Request $request): RedirectResponse
    {
        Plataforma::create($this->validar($request));

        return redirect()->route('plataformas.index')->with('success', 'Plataforma cadastrada com sucesso.');
    }

    public function edit(string $plataforma): View
    {
        $plataforma = $this->findByEncryptedId(Plataforma::class, $plataforma);

        return view('plataformas.edit', compact('plataforma'));
    }

    public function update(Request $request, string $plataforma): RedirectResponse
    {
        /** @var Plataforma $plataformaModel */
        $plataformaModel = $this->findByEncryptedId(Plataforma::class, $plataforma);
        $plataformaModel->update($this->validar($request, $plataformaModel));

        return redirect()->route('plataformas.index')->with('success', 'Plataforma atualizada com sucesso.');
    }

    public function destroy(string $plataforma): RedirectResponse
    {
        /** @var Plataforma $plataformaModel */
        $plataformaModel = $this->findByEncryptedId(Plataforma::class, $plataforma);

        try {
            $plataformaModel->delete();

            return redirect()->route('plataformas.index')->with('success', 'Plataforma removida com sucesso.');
        } catch (QueryException) {
            return redirect()->route('plataformas.index')
                ->with('error', 'Nao foi possivel excluir a plataforma porque ela esta vinculada a um jogo.');
        }
    }

    private function validar(Request $request, ?Plataforma $plataforma = null): array
    {
        return $request->validate([
            'nome' => [
                'required',
                'string',
                'max:100',
                Rule::unique('plataformas', 'nome')->ignore($plataforma),
            ],
        ], [
            'nome.required' => 'Informe o nome da plataforma.',
            'nome.unique' => 'Esta plataforma ja esta cadastrada.',
        ]);
    }
}
