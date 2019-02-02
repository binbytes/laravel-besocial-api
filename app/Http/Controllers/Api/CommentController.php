<?php

namespace App\Http\Controllers\Api;

use App\Comment;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\CommentResources;
use App\Post;

class CommentController extends Controller
{
    /**
     * @param int $id
     *
     * @return \App\Http\Resources\CommentResources
     */
    public function index($id)
    {
        $comments = Comment::where('post_id', $id)
            ->with('author')
            ->latest()
            ->paginate(20);

        return new CommentResources($comments);
    }

    /**
     * @param \App\Http\Requests\Api\CommentRequest $request
     * @param int $id
     *
     * @return \App\Http\Resources\CommentResource
     */
    public function store(CommentRequest $request, $id)
    {
        $post = Post::findOrFail($id);

        $comment = $post->comments()
            ->create($request->persist());

        return new CommentResource($comment);
    }
}
