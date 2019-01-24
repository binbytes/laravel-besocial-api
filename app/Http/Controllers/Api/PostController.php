<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\PostRequest;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostResources;
use App\Http\Resources\UserResource;
use App\Post;
use App\Http\Controllers\Controller;
use App\User;

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
            ->when($userId, function ($query) use($userId) {
                return $query->whereUserId($userId);
            })
            ->latest()
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

        return new PostResource($post);
    }
}
