<?php

namespace Tests\Feature\Auth;

use App\User;
use Tests\Feature\TestCase;

class RegisterTest extends TestCase
{
    /**
     * @test
     */
    public function user_cannot_register_without_email_name_and_password()
    {
        $this->postJson('/api/auth/register', [])
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'email',
                'username',
                'name',
                'password'
            ]);
    }

    /**
     * @test
     */
    public function user_cannot_register_with_invalid_email()
    {
        $this->postJson('/api/auth/register', [
                'name' => 'User Name',
                'email' => '_hi_dummy',
                'password' => "123456"
            ])
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'email',
                'username',
            ]);
    }

    /**
     * @test
     */
    public function user_can_register()
    {
        $user = factory(User::class)->make();

        $this->postJson('/api/auth/register', [
                'name' => $user->name,
                'username' => $user->username,
                'email' => $user->email,
                'password' => "secret"
            ])
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email'
                ]
            ])
            ->assertJson([
                'data' => [
                    'name' => $user->name,
                    'email' => $user->email,
                ]
            ]);
    }
}
