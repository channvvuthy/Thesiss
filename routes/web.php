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

Route::get('logout',function(){
    \Auth::logout();
    return redirect()->route('login');
})->name('logout');

/*
 * Route auth
 */
Route::group(['prefix' => 'administrator'], function () {
    /*
     * get post login
     */
    Route::post('/login', [
        'uses' => 'LoginController@postLogin',

    ])->name('login');
    Route::get('/index', [
        'uses' => 'AdminController@getIndex',
        'as' => 'admin.index'

    ]);
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
    Route::group(['middleware' => 'admin'], function () {
        Route::get('/admin', [
            'uses' => 'AdminController@getIndex',
            'as' => 'admin.index'
        ]);
        Route::get('create-user',[
            'uses'=>'AdminController@getCreateUser',
            'as'=>'createUser'
        ]);
        Route::post('create-user',[
            'uses'=>'AdminController@postCreateUser'
        ]);
        Route::get('delete-user/{id}',[
            'uses'=>'AdminController@getDeleteUser',
            'as'=>'deleteUser'
        ]);
        Route::get('edit-user/{id}',[

            'uses'=>'AdminController@getEditUser',
            'as'=>'editUser'
        ]);
        Route::post('update-user',[
            'uses'=>'AdminController@postUpdateUser',
            'as'=>'updateUser'
        ]);

        Route::get('active-user/{id}',[

            'uses'=>'AdminController@getActiveUser',
            'as'=>'activeUser'
        ]);

        Route::get('create-group',[
            'uses'=>'AdminController@getCreateGroup',
            'as'=>'createGroup'
        ]);
        Route::post('create-group',[
            'uses'=>'AdminController@postCreateGroup'
        ]);
        Route::get('group-active/{id}',[
            'uses'=> 'AdminController@getActive',
            'as'=>'groupActive'
        ]);
        Route::get('edit-group/{id}',[
            'uses'=>'AdminController@getEditGroup',
            'as'=>'editGroup'
        ]);
        Route::get('delete-group/{id}',[
            'uses'=>'AdminController@getDeleteGroup',
            'as'=>'deleteGroup'
        ]);

        Route::post('update-group',[
            'uses'=>'AdminController@postUpdateGroup',
            'as'=>'updateGroup'
        ]);

        Route::get('search-group',[
            'uses'=>'AdminController@getSearchGroup',
            'as'=>'searchGroup'
        ]);
        Route::get('create-role',[
            'uses'=>'AdminController@getCreateRole',
            'as'=>'createRole'
        ]);
        Route::post('create-role',[
            'uses'=>'AdminController@postCreateRole',
        ]);
        Route::get('edit-role/{id}',[
            'uses'=>'AdminController@getEditRole',
            'as'=>'editRole'
        ]);

        Route::get('delete-role/{id}',[
            'uses'=>'AdminController@getDeleteRole',
            'as'=>'deleteRole'
        ]);

        Route::post('update-role',[
            'uses'=>'AdminController@postUpdateRole',
            'as'=>'updateRole'
        ]);

        Route::get('system-seting',[
            'uses'=>'AdminController@getSetting',
            'as'=>'getSetting'
        ]);


    });

});
