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

/**
 * @var \Dingo\Api\Routing\Router
 */
$api = app('Dingo\Api\Routing\Router');
$api->version('v1', ['namespace' => 'App\Api\Controllers'], function ($api) {
    // auth
    $api->group(['prefix' => 'auth'], function ($api) {
        $api->post('login', 'AuthController@login');
        $api->post('logout', 'AuthController@logout');
        $api->post('refresh', 'AuthController@refresh');
        $api->get('identity', 'AuthController@identity');
    });

    // public
    $api->group(['prefix' => 'page'], function ($api) {
        $api->get('/published', 'PageController@fetchPublished');
        $api->get('/{path}', 'PageController@fetchByPath');
    });
    $api->get('/file/{id}/{download}', 'MediaController@file');
    $api->get('/image/{id}/{size}', 'MediaController@image');

    // restricted
    $api->group(['prefix' => '-'], function ($api) {
        $api->group(['prefix' => 'user'], function ($api) {
            $api->get('/', 'UserController@fetchAll');
            $api->get('/{id}', 'UserController@fetch');
            $api->post('/', 'UserController@create');
            $api->patch('/{id}', 'UserController@update');
            $api->delete('/{id}', 'UserController@delete');
        });

        $api->group(['prefix' => 'page'], function ($api) {
            $api->get('/', 'PageController@fetchAll');
            $api->get('/{id}', 'PageController@fetch');
            $api->post('/', 'PageController@create');
            $api->patch('/{id}', 'PageController@update');
            $api->delete('/{id}', 'PageController@delete');
        });

        $api->group(['prefix' => 'media'], function ($api) {
            $api->get('/', 'MediaController@fetchAll');
            $api->get('/{id}', 'MediaController@fetch');
            $api->post('/', 'MediaController@create');
            $api->patch('/{id}', 'MediaController@update');
            $api->delete('/{id}', 'MediaController@delete');
            $api->post('/optimize', 'MediaController@optimize');
            // $api->post('/clean', 'MediaController@clean');
        });
    });
});

Route::get('/', function () {
    return response()->json(['status' => '200'], 200);
});
