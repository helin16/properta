<?php

Route::group(array('module' => 'User', 'namespace' => 'App\Modules\User\Controllers'), function() {


    Route::get('user/login', [
        'uses' => 'UserController@login'
    ]);



    //Route::get('user/data', 'UserController@data');
    //Route::get( 'user/upload', 'UserController@upload');
    //Route::post('user/upload', 'UserController@do_upload');
    Route::model('userModel','Employee');
    Route::resource('user', 'UserController');
});	