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

Route::get('logout', function () {
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
        Route::get('create-user', [
            'uses' => 'AdminController@getCreateUser',
            'as' => 'createUser'
        ]);
        Route::post('create-user', [
            'uses' => 'AdminController@postCreateUser'
        ]);
        Route::get('delete-user/{id}', [
            'uses' => 'AdminController@getDeleteUser',
            'as' => 'deleteUser'
        ]);
        Route::get('edit-user/{id}', [

            'uses' => 'AdminController@getEditUser',
            'as' => 'editUser'
        ]);
        Route::post('update-user', [
            'uses' => 'AdminController@postUpdateUser',
            'as' => 'updateUser'
        ]);

        Route::get('active-user/{id}', [

            'uses' => 'AdminController@getActiveUser',
            'as' => 'activeUser'
        ]);

        Route::get('create-group', [
            'uses' => 'AdminController@getCreateGroup',
            'as' => 'createGroup'
        ]);
        Route::post('create-group', [
            'uses' => 'AdminController@postCreateGroup'
        ]);
        Route::get('group-active/{id}', [
            'uses' => 'AdminController@getActive',
            'as' => 'groupActive'
        ]);
        Route::get('edit-group/{id}', [
            'uses' => 'AdminController@getEditGroup',
            'as' => 'editGroup'
        ]);
        Route::get('delete-group/{id}', [
            'uses' => 'AdminController@getDeleteGroup',
            'as' => 'deleteGroup'
        ]);

        Route::post('update-group', [
            'uses' => 'AdminController@postUpdateGroup',
            'as' => 'updateGroup'
        ]);

        Route::get('search-group', [
            'uses' => 'AdminController@getSearchGroup',
            'as' => 'searchGroup'
        ]);
        Route::get('create-role', [
            'uses' => 'AdminController@getCreateRole',
            'as' => 'createRole'
        ]);
        Route::post('create-role', [
            'uses' => 'AdminController@postCreateRole',
        ]);
        Route::get('edit-role/{id}', [
            'uses' => 'AdminController@getEditRole',
            'as' => 'editRole'
        ]);

        Route::get('delete-role/{id}', [
            'uses' => 'AdminController@getDeleteRole',
            'as' => 'deleteRole'
        ]);

        Route::post('update-role', [
            'uses' => 'AdminController@postUpdateRole',
            'as' => 'updateRole'
        ]);

        Route::get('system-setting', [
            'uses' => 'AdminController@getSetting',
            'as' => 'getSetting'
        ]);
        Route::post('system-setting', [
            'uses' => 'AdminController@postSetting',
            'as' => 'getSetting'
        ]);


    });

});

Route::group(['prefix' => 'leader'], function () {
    Route::group(['middleware' => 'leader'], function () {
        Route::get('/', [
            'uses' => 'LeaderController@getIndex',
            'as' => 'leader.index'
        ]);
        Route::get('create-variation', [

            'uses' => 'LeaderController@getCreateBaseType',
            'as' => 'createBaseType'
        ]);
        Route::post('create-variation', [
            'uses' => 'LeaderController@postCreateVariation',
            'as' => 'createVariation'
        ]);
        Route::get('edit-variation/{id}', [
            'uses' => 'LeaderController@getEditVariation',
            'as' => 'editVariation'
        ]);
        Route::post('edit-variation', [
            'uses' => 'LeaderController@postUpdateVariation',
            'as' => 'updateVariation'
        ]);
        Route::get('active-variation/{id}', [
            'uses' => 'LeaderController@getActiveVariation',
            'as' => 'activeVriation'
        ]);
        Route::get('delete-variation/{id}', [
            'uses' => 'LeaderController@getDeleteVariation',
            'as' => 'deleteVariation'
        ]);
        Route::get('create-pattern', [
            'uses' => 'LeaderController@getCreatePattern',
            'as' => 'createPattern'
        ]);
        Route::post('create-pattern', [
            'uses' => 'LeaderController@postCreatePattern',
            'as' => 'createPattern'
        ]);
        Route::get('edit-pattern/{id}', [
            'uses' => 'LeaderController@getEditPattern',
            'as' => 'editPattern'
        ]);
        Route::post('update-pattern', [
            'uses' => 'LeaderController@postUpdatePattern',
            'as' => 'updatePattern'
        ]);
        Route::get('delete-pattern/{id}', [
            'uses' => 'LeaderController@getDeletePattern',
            'as' => 'deletePattern'
        ]);
        Route::get('active-pattern/{id}', [
            'uses' => 'LeaderController@getActivePattern',
            'as' => 'activePattern'
        ]);
        Route::get('create-layout', [
            'uses' => 'LayoutController@getLayout',
            'as' => 'createLayout'
        ]);
        Route::post('create-layout', [
            'uses' => 'LayoutController@postLayout'
        ]);
        Route::get('active-layout/{id}', [
            'uses' => 'LayoutController@getActiveLayout',
            'as' => 'activeLayout'
        ]);
        Route::get('delete-layout/{id}', [
            'uses' => 'LayoutController@getDeleteLayout',
            'as' => 'deleteLayout'
        ]);
        Route::get('edit-layout/{id}', [
            'uses' => 'LayoutController@getEditLayout',
            'as' => 'editLayout'
        ]);
        Route::post('update-layout', [
            'uses' => 'LayoutController@postUpdateLayout',
            'as' => 'updateLayout'
        ]);

        Route::get('upload-layout', [
            'uses' => 'LayoutController@getUploadLayout',
            'as' => 'uploadLayout'
        ]);
        Route::post('upload-layout', [
            'uses' => 'LayoutController@postUploadLayout'
        ]);
        Route::get('preview-file/{name}/{type}', [
            'uses' => 'LayoutController@getPreview',
            'as' => 'previewFile'
        ]);
        Route::get('base-member', [
            'uses' => 'MemberController@getBaseMember',
            'as' => 'getMemberBase'
        ]);
        Route::get('get-variation-default', [
            'uses' => 'MemberController@getVariationDefault',
            'as' => 'getVariationDefault'
        ]);
        Route::post('assign-member', [
            'uses' => 'MemberController@getAssignMember',
            'as' => 'assignMember'
        ]);

        Route::get('edit-base-assign/{id}', [
            'uses' => 'MemberController@getBaseAssign',
            'as' => 'editBaseAssign'
        ]);
        Route::get('delete-base-assign/{id}', [
            'uses' => 'MemberController@getDeleteBaseAssign',
            'as' => 'deleteBaseAssign'
        ]);
        Route::get('base-directory', [
            'uses' => 'LeaderController@getBaseDirectory',
            'as' => 'baseDirectory'
        ]);
        Route::post('base-directory', [
            'uses' => 'LeaderController@postBaseDirectory',

        ]);
        Route::get('list-base-member',[
            'uses'=>'LeaderController@getBaseList',
            'as'=>'listBaseMember'
        ]);

    });

});

Route::group(['prefix' => 'member'], function () {
    Route::get('/', [
        'uses' => 'MemberController@getIndex',
        'as' => 'member.index'
    ]);

    Route::get('create-base', [
        'uses' => 'MemberController@getCreateBase',
        'as' => 'createBase'
    ]);
    /*
 * List folder
 *
 * */
    Route::get('list-folder', [
        'uses' => 'MemberController@getListFolder',
        'as' => 'listFolder'
    ]);
    Route::get('read-file/{path}/{fileName}', [
        'uses' => 'MemberController@getReadFile',
        'as' => 'readFile'
    ]);

    Route::get('edit-file', [
        'uses' => 'MemberController@getEditFile',
        'as' => 'editFile'
    ]);

    Route::post('save-file', [
        'uses' => 'MemberController@postSaveFile',
        'as' => 'saveFile'
    ]);
    Route::get('sub-directory', [
        'uses' => 'MemberController@getReadDirectory',
        'as' => 'subDirectory'
    ]);

    Route::get('edit-file-sub-directory', [
        'uses' => 'MemberController@getEditFileSubDirectory',

        'as' => 'editFileSubDirectory'
    ]);
    Route::post('save-directory-file', [
        'uses' => 'MemberController@postSaveDirectoryFile',
        'as' => 'saveDirectoryFile'
    ]);

    Route::get('create-folder', [
        'uses' => 'MemberController@getCreateFolder',
        'as' => 'createFolder'
    ]);
    Route::get('create-file', [
        'uses' => 'MemberController@getCreateFile',
        'as' => 'createFile'
    ]);

    Route::get('create-path', [
        'uses' => 'MemberController@getCreatePath',
        'as' => 'createPath'
    ]);
    Route::post('create-path', [
        'uses' => 'MemberController@postCreatePath',
        'as' => 'createPath'
    ]);

    Route::get('copy-and-save', [
        'uses' => 'MemberController@getCopyAndSave',
        'as' => 'copayAndSave'
    ]);

    Route::get('tool',[
        'uses'=>'MemberController@getTool',
        'as'=>'tool'
    ]);

    Route::get('member-view-base',[
        'uses'=>'MemberController@getMemberViewBase',
        'as'=>'memberViewBase'
    ]);
});
