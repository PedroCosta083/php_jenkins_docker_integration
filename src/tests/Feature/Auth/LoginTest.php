<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_login_with_valid_credentials()
    {
        // Cria um usuário
        $user = User::factory()->create([
            'email' => 'user@example.com',
            'password' => bcrypt('password123'),
        ]);

        // Tenta fazer login
        $response = $this->post('/login', [
            'email' => 'user@example.com',
            'password' => 'password123',
        ]);

        // Verifica se o redirecionamento ocorreu corretamente
        $response->assertRedirect('/dashboard'); // Ajuste a rota conforme sua aplicação
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function user_cannot_login_with_invalid_credentials()
    {
        // Tenta fazer login com credenciais inválidas
        $response = $this->post('/login', [
            'email' => 'invalid@example.com',
            'password' => 'wrongpassword',
        ]);

        // Verifica se a resposta foi um erro de validação
        $response->assertSessionHasErrors(['email']);
        $this->assertGuest();
    }
}
