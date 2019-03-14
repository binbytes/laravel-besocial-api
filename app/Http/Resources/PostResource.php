<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\MediaLibrary\Models\Media;

class PostResource extends JsonResource
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
            'text' => $this->text,
            'author' => (new PostUserResource($this->author)),
            'totalComment' => $this->comments_count ?: 0,
            'isLiked' => $request->user() ? $request->user()->hasLiked($this->resource) : false,
            'likedCount' => $this->liker()->count(),
            'images' => $this->getMedia('images')->map(function (Media $image) {
                return $image->getFullUrl();
            }),
        ];
    }
}
