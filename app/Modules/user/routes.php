<?php

Route::group(array('module' => 'User', 'namespace' => 'App\Modules\User\Controllers'), function() {


    Route::get('user/index', [
        'uses' => 'UserController@index'
    ]);

    Route::get('user/logout', [
        'uses' => 'UserController@logout'
    ]);

    Route::post('user/login', 'UserController@login');


    Route::get('user/edit-password', [
        'middleware' => ['roles'],
        'uses' => 'UserController@editPassword',
        'roles' => ['agency admin', 'landlord']
    ]);

    Route::post('user/update-password', [
        'uses' => 'UserController@updatePassword'
    ]);

    Route::get('user/edit-profile', [
        'uses' => 'UserController@editProfile'
    ]);

    Route::post('user/update-profile', [
        'uses' => 'UserController@updateProfile'
    ]);

    Route::get('user/create-user', [
        'uses' => 'UserController@createUser'
    ]);

    Route::post('user/create-user', [
        'uses' => 'UserController@postCreateUser'
    ]);

    //Route::get('user/data', 'UserController@data');
    //Route::get( 'user/upload', 'UserController@upload');
    //Route::post('user/upload', 'UserController@do_upload');
    Route::model('userModel','Employee');
    Route::resource('user', 'UserController');
});	