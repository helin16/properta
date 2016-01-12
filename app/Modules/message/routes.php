<?php

Route::group(array('module' => 'Message', 'namespace' => 'App\Modules\Message\Controllers'), function() {

    Route::get('message', [
        'as' => 'message.listall',
        'uses' => 'MessageController@listall',
        'middleware' => ['roles'],
        'roles' => ['agency admin'],
    ]);
    Route::get('message/{id}', [
        'as' => 'message.view',
        'uses' => 'MessageController@view',
        'middleware' => ['roles'],
        'roles' => ['agency admin'],
    ]);
    Route::get('message/{id}', [
    		'as' => 'message.delete',
    		'uses' => 'MessageController@delete',
    		'middleware' => ['roles'],
    		'roles' => ['agency admin'],
    ]);
    Route::get('message/new', [
    		'as' => 'message.new',
    		'uses' => 'MessageController@new',
    		'middleware' => ['roles'],
    		'roles' => ['agency admin'],
    ]);
    Route::get('message/{id}', [
        'as' => 'message.reply',
        'uses' => 'MessageController@reply',
        'middleware' => ['roles'],
        'roles' => ['agency admin'],
    ]);
    
    Route::get('message/{id}', [
    		'as' => 'message.forward',
    		'uses' => 'MessageController@forward',
    		'middleware' => ['roles'],
    		'roles' => ['agency admin'],
    ]);
    
    Route::resource('messages', 'MessageController', ['only' => ['listall', 'view', 'create', 'delete', 'reply','forward']]);

});	