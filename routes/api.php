<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::namespace('Api')
    ->group(function () {
        Route::post('auth/login', 'Auth\LoginController@login');
        Route::post('auth/register', 'Auth\RegisterController@register');

        Route::middleware('auth:api')
            ->group(function () {
                Route::get('auth/user', 'Auth\LoginController@me');
                Route::post('auth/logout', 'Auth\LoginController@logout');

                Route::get('email/verify/{id}', 'Auth\VerificationController@verify')
                    ->name('verification.verify');
                Route::get('email/resend', 'Auth\VerificationController@resend')
                    ->name('verification.resend');

                Route::get('user/{by}/{val}', 'UserController@show');

                Route::get('posts/{userId?}', 'PostController@index');
                Route::post('posts', 'PostController@store');

                Route::get('posts/{id}/comments', 'CommentController@index');
                Route::post('posts/{id}/comments', 'CommentController@store');
                Route::post('posts/{id}/like', 'LikeController@store');

                Route::post('users/{user}/follow', 'FollowController@store');

                Route::post('conversations/{user}', 'ConversationController@store');
                Route::get('conversations/{conversation}', 'ConversationController@show');
                Route::post('conversations/{conversation}/message', 'ConversationController@sendMessage');
            });
    });

