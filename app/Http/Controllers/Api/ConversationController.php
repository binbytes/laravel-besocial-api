<?php

namespace App\Http\Controllers\Api;

use App\Conversation;
use App\Http\Controllers\Controller;
use App\User;

class ConversationController extends Controller
{
    /**
     * Start conversation with
     *
     * @param \App\User $user
     *
     * @return \App\Http\Resources\UserResource
     */
    public function store(User $user)
    {
        abort_if($user->id == auth()->id(), 403);

        $conversation = Conversation::start([
            auth()->id(),
            $user->id
        ]);

        return response()->json($conversation);
    }
}
