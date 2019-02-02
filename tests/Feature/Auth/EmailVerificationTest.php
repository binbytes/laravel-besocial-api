<?php

namespace Tests\Feature\Auth;

use App\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Tests\Feature\TestCase;

class EmailVerificationTest extends TestCase
{
    /**
     * @test
     */
    public function guest_cannot_see_the_verification_route()
    {
        $this->getJson('/api/email/verify/sample-code')
            ->assertStatus(401);
    }

    /**
     * @test
     */
    public function user_sees_the_verification_route_when_not_verified()
    {
        $user = factory(User::class)->create([
            'email_verified_at' => null,
        ]);

        $this->getJson(
                $this->validVerificationVerifyRoute($user->getKey()),
                [ 'Authorization' => 'Bearer '.$this->getAccessToken($user) ]
            )
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
    public function user_cannot_verify_others()
    {
        $user = factory(User::class)->create([
            'email_verified_at' => null,
        ]);

        $user2 = factory(User::class)->create([
            'email_verified_at' => null,
        ]);

        $this->getJson(
            $this->validVerificationVerifyRoute($user->getKey()),
            [ 'Authorization' => 'Bearer '.$this->getAccessToken($user2) ]
        )->assertStatus(403);
    }

    /**
     * @test
     */
    public function forbidden_is_returned_when_signature_is_invalid_in_verification_verify_route()
    {
        $user = factory(User::class)->create([
            'email_verified_at' => null,
        ]);

        $this->getJson(
            $this->invalidVerificationVerifyRoute($user->getKey()),
            [ 'Authorization' => 'Bearer '.$this->getAccessToken($user) ]
        )->assertStatus(403);
    }

    /**
     * @test
     */
    public function guest_cannot_resend_verification_email()
    {
        $this->getJson('/api/email/resend')
            ->assertStatus(401);
    }

    /**
     * @test
     */
    public function user_is_unauthorized_resend_email_if_already_verified()
    {
        $user = factory(User::class)->create([
            'email_verified_at' => now(),
        ]);

        $this->getJson('/api/email/resend', [ 'Authorization' => 'Bearer '.$this->getAccessToken($user) ])
            ->assertStatus(403)
            ->assertSee('message');
    }

    /**
     * @test
     */
    public function user_can_resend_a_verification_email()
    {
        Notification::fake();
        $user = factory(User::class)->create([
            'email_verified_at' => null,
        ]);

        $this->getJson('/api/email/resend', [ 'Authorization' => 'Bearer '.$this->getAccessToken($user) ])
            ->assertOk();

        Notification::assertSentTo($user, VerifyEmail::class);
        ;
    }

    /**
     * @param int $id
     *
     * @return string
     */
    protected function validVerificationVerifyRoute($id)
    {
        return URL::signedRoute('verification.verify', ['id' => $id]);
    }

    /**
     * @param int $id
     *
     * @return string
     */
    protected function invalidVerificationVerifyRoute($id)
    {
        return route('verification.verify', ['id' => $id]) . '?signature=invalid-signature';
    }
}
