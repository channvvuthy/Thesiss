<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*
 * Route auth
 */
Route::group(['prefix' => 'administrator'], function () {
    /*
     * get post login
     */
    Route::post('/login', [
        'uses' => 'LoginController@postLogin',

    ]);
    Route::get('/index',[
       'uses'=>'AdminController@getIndex',
        'as'=>'admin.index'

    ])->middleware('admin');
    /*
     * Route guest
     */
    Route::group(['middleware' => 'guest'], function () {
        Route::get('/login', [
            'uses' => 'LoginController@getLogin',
            'as' => 'user.login'
        ]);
    });
    /*
     * Route admin
     */
    Route::get('/admin', [
        'uses' => 'AdminController@getIndex',
        'as' => 'admin.index'
    ]);

});
