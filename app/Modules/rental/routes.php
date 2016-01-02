<?php
Route::group(array('module' => 'Rental', 'namespace' => 'App\Modules\Rental\Controllers'), function() {
    Route::get('property', [
        'as' => 'property.index',
        'uses' => 'PropertyController@index',
        'middleware' => ['roles'],
        'roles' => ['agency admin'],
    ]);
    Route::get('property/{id}', [
        'as' => 'property.show',
        'uses' => 'PropertyController@show',
        'middleware' => ['roles'],
        'roles' => ['agency admin'],
    ]);
    Route::delete('property/{id}', [
        'as' => 'property.destroy',
        'uses' => 'PropertyController@show',
        'middleware' => ['roles'],
        'roles' => ['agency admin'],
    ]);
    Route::resource('rental', 'RentalController', ['only' => ['index', 'show', 'store', 'destroy']]);
});