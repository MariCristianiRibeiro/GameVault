<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $dados = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'remember' => ['nullable', 'boolean'],
        ], [
            'email.required' => 'Informe seu e-mail.',
            'email.email' => 'Informe um e-mail valido.',
            'password.required' => 'Informe sua senha.',
        ]);

        $chaveRateLimit = 'login:' . $request->ip();

        if (RateLimiter::tooManyAttempts($chaveRateLimit, 5)) {
            throw ValidationException::withMessages([
                'email' => 'Muitas tentativas. Aguarde alguns minutos e tente novamente.',
            ]);
        }

        if (! Auth::attempt([
            'email' => $dados['email'],
            'password' => $dados['password'],
        ], (bool) ($dados['remember'] ?? false))) {
            RateLimiter::hit($chaveRateLimit, 120);

            throw ValidationException::withMessages([
                'email' => 'Credenciais invalidas.',
            ]);
        }

        RateLimiter::clear($chaveRateLimit);

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'))->with('success', 'Login realizado com sucesso.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Sessao encerrada com sucesso.');
    }
}
