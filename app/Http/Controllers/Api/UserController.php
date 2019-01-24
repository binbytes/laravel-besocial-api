<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{
    /**
     * @param \App\User $user
     *
     * @return \App\Http\Resources\UserResource
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }
}
