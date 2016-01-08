<?php

Route::group(array('module' => 'Message', 'namespace' => 'App\Modules\Message\Controllers'), function() {

    Route::get('messages', [
        'as' => 'message.index',
        'uses' => 'MessageController@index',
        'middleware' => ['roles'],
        'roles' => ['agency admin'],
    ]);
    Route::get('message/{id}', [
        'as' => 'message.show',
        'uses' => 'MessageController@show',
        'middleware' => ['roles'],
        'roles' => ['agency admin'],
    ]);
    Route::get('message/{id}', [
    		'as' => 'message.edit',
    		'uses' => 'MessageController@compose',
    		'middleware' => ['roles'],
    		'roles' => ['agency admin'],
    ]);
    Route::get('message/compose', [
    		'as' => 'message.compose',
    		'uses' => 'MessageController@compose',
    		'middleware' => ['roles'],
    		'roles' => ['agency admin'],
    ]);
    Route::delete('message/{id}', [
        'as' => 'message.destroy',
        'uses' => 'MessageController@show',
        'middleware' => ['roles'],
        'roles' => ['agency admin'],
    ]);
    Route::resource('messages', 'MessageController', ['only' => ['index', 'show', 'store', 'destroy']]);

});	