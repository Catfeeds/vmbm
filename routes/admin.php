<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
//
Route::get('test', 'TestController@index');
Route::get('login', 'Auth\LoginController@showLoginForm')->name('admin.login');
Route::post('login','Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout');
Route::get('noauth', 'Auth\LoginController@noauth');
Route::get('changePassword', 'Auth\ResetPasswordController@showChangeForm')->name('password.reset');
Route::post('changePassword', 'Auth\ResetPasswordController@changePassword');


Route::group(['middleware' => ['auth.admin']], function() {

    $uri =  request()->path();
    $uri = str_replace('admin/' ,'', $uri);
    $uri = str_replace('admin' ,'', $uri);
    if ($uri == '') {
        Route::any('/', ['as' => 'admin',
            'uses' => 'Base\IndexController@index']);
    } else {
        $aUri = $baseUri = explode('/', $uri);
        if (count($aUri) > 1) {
            unset($aUri[count($aUri) - 1]);
            $file = app_path() . '/Http/Controllers/Admin/' . implode("/", $aUri) . "Controller.php";
            if (file_exists($file)) {
                $controller = implode("\\", $aUri) . "Controller";
                $action = $controller . "@" . $baseUri[count($aUri)];
                Route::any($uri, ['as' => 'admin',
                    'uses' => $action]);
            }
        }

    }

});