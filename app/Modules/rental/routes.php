<?php
Route::group(array('module' => 'Rental', 'namespace' => 'App\Modules\Rental\Controllers'), function() {
    Route::resource('property', 'PropertyController', ['only' => ['index', 'show', 'store', 'destroy']]);
    Route::resource('rental', 'RentalController', ['only' => ['index', 'show', 'store', 'destroy']]);
});