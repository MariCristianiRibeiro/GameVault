<?php

namespace App\Http\Controllers;

use App\Models\Desenvolvedora;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class DesenvolvedoraController extends Controller
{
    public function index(Request $request): View
    {
        $busca = trim((string) $request->input('q'));

        $desenvolvedoras = Desenvolvedora::query()
            ->when($busca !== '', fn ($query) => $query->where('nome', 'like', '%' . $busca . '%'))
            ->orderBy('nome')
            ->paginate(10)
            ->withQueryString();

        return view('desenvolvedoras.index', compact('desenvolvedoras', 'busca'));
    }

    public function create(): View
    {
        return view('desenvolvedoras.create');
    }

    public function store(Request $request): RedirectResponse
    {
        Desenvolvedora::create($this->validar($request));

        return redirect()->route('desenvolvedoras.index')->with('success', 'Desenvolvedora cadastrada com sucesso.');
    }

    public function edit(string $desenvolvedora): View
    {
        $desenvolvedora = $this->findByEncryptedId(Desenvolvedora::class, $desenvolvedora);

        return view('desenvolvedoras.edit', compact('desenvolvedora'));
    }

    public function update(Request $request, string $desenvolvedora): RedirectResponse
    {
        /** @var Desenvolvedora $desenvolvedoraModel */
        $desenvolvedoraModel = $this->findByEncryptedId(Desenvolvedora::class, $desenvolvedora);
        $desenvolvedoraModel->update($this->validar($request, $desenvolvedoraModel));

        return redirect()->route('desenvolvedoras.index')->with('success', 'Desenvolvedora atualizada com sucesso.');
    }

    public function destroy(string $desenvolvedora): RedirectResponse
    {
        /** @var Desenvolvedora $desenvolvedoraModel */
        $desenvolvedoraModel = $this->findByEncryptedId(Desenvolvedora::class, $desenvolvedora);

        try {
            $desenvolvedoraModel->delete();

            return redirect()->route('desenvolvedoras.index')->with('success', 'Desenvolvedora removida com sucesso.');
        } catch (QueryException) {
            return redirect()->route('desenvolvedoras.index')
                ->with('error', 'Nao foi possivel excluir a desenvolvedora porque ela esta vinculada a um jogo.');
        }
    }

    private function validar(Request $request, ?Desenvolvedora $desenvolvedora = null): array
    {
        return $request->validate([
            'nome' => [
                'required',
                'string',
                'max:100',
                Rule::unique('desenvolvedoras', 'nome')->ignore($desenvolvedora),
            ],
        ], [
            'nome.required' => 'Informe o nome da desenvolvedora.',
            'nome.unique' => 'Esta desenvolvedora ja esta cadastrada.',
        ]);
    }
}
