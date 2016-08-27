<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return response()->json([
        'Hello' => 'World'
    ]);
});

Route::group(['prefix' => 'v1'], function() {

    Route::post('oauth/access_token', function() {
        return response()->json(Authorizer::issueAccessToken());
    });

    Route::group(['prefix' => 'user'], function() {

        Route::post('/', [
            'as'   => 'v1.user.create',
            'uses' => '\\App\\Http\\Controllers\\UserController@create'
        ]);

        Route::get('/', [
            'as'   => 'v1.user.get',
            'uses' => '\\App\\Http\\Controllers\\UserController@get',
            'middleware' => 'oauth:read'
        ]);

        Route::get('/inverso', [
            'as'   => 'v1.user.revert',
            'uses' => '\\App\\Http\\Controllers\\UserController@revert',
            'middleware' => 'oauth:read'
        ]);

        Route::put('/', [
            'as'   => 'v1.user.update',
            'uses' => '\\App\\Http\\Controllers\\UserController@update',
            'middleware' => 'oauth:update'
        ]);

        Route::delete('/', [
            'as'   => 'v1.user.delete',
            'uses' => '\\App\\Http\\Controllers\\UserController@delete',
            'middleware' => 'oauth:delete'
        ]);
    });
});
