<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @param $by 'id' or 'username'
     * @param $val
     *
     * @return \App\Http\Resources\UserResource
     */
    public function show($by, $val)
    {
        abort_unless(in_array($by, [
            'id',
            'username'
        ]), 404);

        return new UserResource(
            User::where($by, $val)
                ->first()
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Validation\ValidationException
     */
    public function search(Request $request)
    {
        $this->validate($request, [
            'query' => 'required|string'
        ]);

        $query = $request->get('query');

        return UserResource::collection(
            User::where('username', 'like', '%'.$query.'%')
                ->orWhere('name', 'like', '%'.$query.'%')
                ->take(10)
                ->get()
        );
    }
}
