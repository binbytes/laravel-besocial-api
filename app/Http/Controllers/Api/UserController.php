<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{
    /**
     * @param $by 'id' or 'username'
     * @param $val
     *
     * @return \App\Http\Resources\UserResource
     */
    public function show($by, $val)
    {
        abort_unless(in_array($by, [
            'id',
            'username'
        ]), 404);

        return new UserResource(
            User::where($by, $val)
                ->first()
        );
    }

    /**
     * @param $username
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function search($username)
    {
        return UserResource::collection(
            User::where('username', 'like', "%$username%")
                ->get()
        );
    }
}
