<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ConversationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->getKey(),
            'last_message' => $this->lastMessage,
            'unread_message_count' => $this->unread_message_count ?: 0,
            'users' => ConversationUserResource::collection($this->users),
            'messages' => MessageResource::collection($this->messages),
        ];
    }
}
