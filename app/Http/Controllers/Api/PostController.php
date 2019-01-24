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
     * @return \App\Http\Resources\PostResources
     */
    public function index()
    {
        $posts = Post::with('author')
            ->latest()
            ->paginate(20);

        return new PostResources($posts);
    }

    /**
     * @param \App\User $user
     *
     * @return \App\Http\Resources\PostResources
     */
    public function userPosts(User $user)
    {
        $user->load('posts.author');

        return new UserResource($user);
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
