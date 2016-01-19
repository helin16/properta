<?php
Route::group(array('module' => 'Message', 'namespace' => 'App\Modules\Message\Controllers'), function() {
    Route::get('messages', [
        'as' => 'message.index',
        'uses' => 'MessageController@index',
//        'middleware' => ['roles'],
//        'roles' => ['agency admin'],
    ]);
    Route::get('messages/create', [
        'uses' => 'MessageController@createMessage',
//        'middleware' => ['roles'],
//        'roles' => ['agency admin'],
    ]);
    Route::post('messages/post-create', [
        'uses' => 'MessageController@postMessage',
//        'middleware' => ['roles'],
//        'roles' => ['agency admin'],
    ]);
    Route::get('messages/detail', [
        'uses' => 'MessageController@detail',
//        'middleware' => ['roles'],
//        'roles' => ['agency admin'],
    ]);
//Route::group(array('module' => 'Rental', 'namespace' => 'App\Modules\Rental\Controllers'), function() {
//    Route::get('rental', [
//        'as' => 'rental.index',
//        'uses' => 'RentalController@index',
////        'middleware' => ['roles'],
////        'roles' => ['agency admin'],
//    ]);
//    Route::get('rental/{id}', [
//        'as' => 'rental.show',
//        'uses' => 'RentalController@show',
////        'middleware' => ['roles'],
////        'roles' => ['agency admin'],
//    ]);
//    Route::post('rental/{id}', [
//        'as' => 'rental.store',
//        'uses' => 'RentalController@store',
////        'middleware' => ['roles'],
////        'roles' => ['agency admin'],
//    ]);
//    Route::delete('rental/{id}', [
//        'as' => 'rental.destroy',
//        'uses' => 'RentalController@show',
////        'middleware' => ['roles'],
////        'roles' => ['agency admin'],
//    ]);
});