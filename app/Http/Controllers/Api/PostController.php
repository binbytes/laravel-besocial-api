<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PostRequest;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostResources;
use App\Post;

class PostController extends Controller
{
    /**
     * @param null $userId
     *
     * @return \App\Http\Resources\PostResources
     */
    public function index($userId = null)
    {
        $posts = Post::with('author')
            ->when($userId, function ($query) use ($userId) {
                return $query->whereUserId($userId);
            })
            ->unless($userId, function ($query) {
                $query->whereHas('author', function ($query) {
                    $query->whereHas('followers')
                        ->orWhere('id', auth()->id());
                });
            })
            ->latest('posts.created_at')
            ->paginate(20);

        return new PostResources($posts);
    }

    /**
     * @param \App\Http\Requests\Api\PostRequest $request
     *
     * @return \App\Http\Resources\PostResource
     */
    public function store(PostRequest $request)
    {
        $post = auth()->user()
            ->posts()
            ->create($request->persist());

        if ($request->hasMedia()) {
            $post->addMultipleMediaFromRequest(['images'])
                ->each(function ($fileAdder) {
                    $fileAdder->toMediaCollection('images');
                });
        }

        return new PostResource($post);
    }
}
