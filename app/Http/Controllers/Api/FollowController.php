<?php

namespace App\Http\Controllers\Api;

use App\Events\UserFollowed;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FollowController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param User $user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, User $user)
    {
        $request->user()->toggleFollow($user);

        event(new UserFollowed($user));

        return response()->json([
            'success' => true,
        ]);
    }
}
