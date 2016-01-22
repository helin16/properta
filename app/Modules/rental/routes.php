<?php
Route::group(array('module' => 'Property', 'namespace' => 'App\Modules\Rental\Controllers'), function() {
    Route::get('property', [
        'as' => 'property.index',
        'uses' => 'PropertyController@index',
        'middleware' => ['roles'],
        'roles' => ['agency admin','agent', 'landlord', 'tenant'],
    ]);
    Route::get('property/{id}', [
        'as' => 'property.show',
        'uses' => 'PropertyController@show',
        'middleware' => ['roles'],
        'roles' => ['agency admin','agent', 'landlord', 'tenant'],
    ]);
    Route::post('property/{id}', [
        'as' => 'property.store',
        'uses' => 'PropertyController@store',
        'middleware' => ['roles'],
        'roles' => ['agency admin'],
    ]);
    Route::delete('property/{id}', [
        'as' => 'property.destroy',
        'uses' => 'PropertyController@destroy',
        'middleware' => ['roles'],
        'roles' => ['agency admin'],
    ]);
});
Route::group(array('module' => 'Rental', 'namespace' => 'App\Modules\Rental\Controllers'), function() {
    Route::get('rental', [
        'as' => 'rental.index',
        'uses' => 'RentalController@index',
        'middleware' => ['roles'],
        'roles' => ['agency admin','agent', 'tenant', 'landlord'],
    ]);
    Route::get('rental/{id}', [
        'as' => 'rental.show',
        'uses' => 'RentalController@show',
        'middleware' => ['roles'],
        'roles' => ['agency admin','agent', 'tenant', 'landlord'],
    ]);
    Route::post('rental/{id}', [
        'as' => 'rental.store',
        'uses' => 'RentalController@store',
        'middleware' => ['roles'],
        'roles' => ['agency admin'],
    ]);
    Route::delete('rental/{id}', [
        'as' => 'rental.destroy',
        'uses' => 'RentalController@destroy',
        'middleware' => ['roles'],
        'roles' => ['agency admin'],
    ]);
});