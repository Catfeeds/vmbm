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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});



//
//$api = app('Dingo\Api\Routing\Router');
//
//$api->version('v1', ['namespace' => 'App\Http\Controllers\Api\V1'], function ($api) {
//    // test
//    $api->get('test', [
//        'as' => 'test',
//        'uses' => 'AuthController@test',
//    ]);
//    // Auth
//    // signin
//    $api->post('auth/login', [
//        'as' => 'auth.login',
//        'uses' => 'AuthController@login',
//    ]);
//    $api->post('auth/logout', [
//        'as' => 'auth.logout',
//        'uses' => 'AuthController@logout',
//    ]);
//    $api->post('auth/code', [
//        'as' => 'auth.code',
//        'uses' => 'AuthController@getCode',
//    ]);
//    // signup
//    $api->post('auth/register', [
//        'as' => 'auth.register',
//        'uses' => 'AuthController@register',
//    ]);
//    $api->post('auth/password', [
//        'as' => 'auth.reset',
//        'uses' => 'AuthController@setPassword',
//    ]);
//    $api->post('auth/check_password', [
//        'as' => 'auth.check_password',
//        'uses' => 'AuthController@check_password',
//    ]);
//    $api->post('auth/reset', [
//        'as' => 'auth.reset',
//        'uses' => 'AuthController@reset',
//    ]);
//    $api->get('auth/is_login', [
//        'as' => 'auth.is_login',
//        'uses' => 'AuthController@isLogin',
//    ]);
//});