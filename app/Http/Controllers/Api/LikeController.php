<?php

namespace App\Http\Controllers\Api;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LikeController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $request->user()->toggleLike($post);

        return response()->json([
            'success' => true,
        ]);
    }
}
