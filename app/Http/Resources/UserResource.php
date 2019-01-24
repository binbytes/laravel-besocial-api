<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public static $wrap = false;

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
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'postsCount' => $this->posts()->count(),
            'followersCount' => $this->followers()->count(),
            'followingCount' => $this->followings()->count(),
            'posts' => new PostResources($this->whenLoaded('posts'))
        ];
    }
}
