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
        Route::post('login', 'Auth\LoginController@login');
        Route::post('register', 'Auth\RegisterController@register');

        Route::middleware('auth:api')
            ->group(function () {
                Route::get('user', 'Auth\LoginController@me');
                Route::post('logout', 'Auth\LoginController@logout');

                Route::get('email/verify/{id}', 'Auth\VerificationController@verify')
                    ->name('verification.verify');
                Route::get('email/resend', 'Auth\VerificationController@resend')
                    ->name('verification.resend');
            });
    });

