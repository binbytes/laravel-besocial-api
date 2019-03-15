<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
            'body' => $this->body,
            'user_id' => $this->user_id,
            'sender' => (new PostUserResource($this->sender)),
            'type' => $this->type,
            'is_seen' => $this->is_seen,
        ];
    }
}
