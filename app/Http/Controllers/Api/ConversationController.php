<?php

namespace App\Http\Controllers\Api;

use App\Conversation;
use App\Http\Controllers\Controller;
use App\Message;
use App\User;

class ConversationController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(
            Conversation::with('lastMessage', 'users')
                ->withCount('unreadMessage')
                ->forUser()
                ->get()
        );
    }

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

        $conversation = Conversation::firstOrStart(
            $user->id
        );

        return response()->json($conversation);
    }

    /**
     * @param \App\Conversation $conversation
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Conversation $conversation)
    {
        $conversation->unreadMessage()->update([
            'is_seen' => true
        ]);

        return response()->json($conversation->load('messages'));
    }

    /**
     * @param \App\Conversation $conversation
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function sendMessage(Conversation $conversation)
    {
        $this->validate(request(), [
            'text' => 'required|max:500' // Yeah
        ]);

        return response()->json(Message::send($conversation, request('text'), auth()->id()));
    }
}
