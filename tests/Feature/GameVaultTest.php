<?php

namespace Tests\Feature;

use App\Models\Desenvolvedora;
use App\Models\Genero;
use App\Models\Jogo;
use App\Models\Plataforma;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GameVaultTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_view_the_landing_page(): void
    {
        $response = $this->get('/');

        $response
            ->assertOk()
            ->assertSee('GameVault')
            ->assertSee('Criar conta');
    }

    public function test_user_can_register_and_is_redirected_to_dashboard(): void
    {
        $response = $this->post('/registro', [
            'name' => 'Ana Gamer',
            'email' => 'ana@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'email' => 'ana@example.com',
        ]);
    }

    public function test_authenticated_user_can_create_and_view_a_game_with_encrypted_route(): void
    {
        $user = User::factory()->create();
        $plataforma = Plataforma::create(['nome' => 'PC']);
        $genero = Genero::create(['nome' => 'RPG']);
        $desenvolvedora = Desenvolvedora::create(['nome' => 'FromSoftware']);

        $response = $this
            ->actingAs($user)
            ->post('/jogos', [
                'titulo' => 'Elden Ring',
                'descricao' => 'Exploracao e combate em mundo aberto.',
                'horas_jogadas' => 48,
                'nota' => 9.5,
                'status' => 'Jogando',
                'data_lancamento' => '2022-02-25',
                'plataforma_id' => $plataforma->id,
                'genero_id' => $genero->id,
                'desenvolvedora_id' => $desenvolvedora->id,
            ]);

        $response->assertRedirect(route('jogos.index'));
        $this->assertDatabaseHas('jogos', [
            'titulo' => 'Elden Ring',
            'user_id' => $user->id,
        ]);

        $jogo = Jogo::firstOrFail();

        $this->assertNotSame((string) $jogo->id, $jogo->route_key);

        $this->actingAs($user)
            ->get(route('jogos.show', $jogo->route_key))
            ->assertOk()
            ->assertSee('Elden Ring')
            ->assertSee('FromSoftware');

        $this->actingAs($user)
            ->get('/pesquisa?q=Elden')
            ->assertOk()
            ->assertSee('Elden Ring');
    }
}
