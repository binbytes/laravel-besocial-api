<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use DatabaseTransactions;

    /**
     * @param null $user
     *
     * @return mixed
     */
    public function getAccessToken($user = null)
    {
        if (! $user) {
            $user = factory(User::class)->create();
        }

        return $user->generateAccessToken();
    }
}
