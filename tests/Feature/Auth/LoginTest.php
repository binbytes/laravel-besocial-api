<?php

namespace Tests\Feature\Auth;

use App\User;
use Tests\Feature\TestCase;

class LoginTest extends TestCase
{
    /**
     * @test
     */
    public function user_cannot_login_without_email_and_password()
    {
        $this->postJson('/api/auth/login', [])
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'email',
                'password'
            ]);
    }

    /**
     * @test
     */
    public function user_cannot_login_with_email_that_does_not_exist()
    {
        factory(User::class)->create([
            'email' => 'johndeo@gmail.com',
        ]);

        $this->postJson('/api/auth/login', [
                'email' => 'johndeo_123@gmail.com',
                'password' => "123456"
            ])
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'email'
            ]);
    }

    /**
     * @test
     */
    public function user_cannot_login_with_password_that_does_not_exist()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt('secret'),
        ]);

        $response = $this->postJson('/api/auth/login', [
                'email' => $user->email,
                'password' => "secret"
            ])
            ->assertOk()
            ->assertSee('token');

        $this->getJson('/api/auth/user', [ 'Authorization' => 'Bearer '.$response->json('token') ])
            ->assertOk()
            ->assertJson([
                'data' => [
                    'id' => $user->getKey(),
                    'name' => $user->name,
                    'email' => $user->email,
                ]
            ]);
    }

    /**
     * @test
     */
    public function user_can_logout()
    {
        $token = $this->getAccessToken();

        $this->postJson('/api/auth/logout', [], [ 'Authorization' => 'Bearer '.$token ])
            ->assertOk();
    }

    /**
     * @test
     */
    public function user_can_not_logout_when_not_authenticated()
    {
        $this->postJson('/api/auth/logout')
            ->assertStatus(401);
    }
}
