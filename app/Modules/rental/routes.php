<?php

Route::group(array('module' => 'Rental', 'namespace' => 'App\Modules\Rental\Controllers'), function() {
    Route::get('template', function(){
        return view('rental::list.inspinia');
    });
    Route::resource('rental', 'RentalController');
    Route::resource('property', 'PropertyController');
});