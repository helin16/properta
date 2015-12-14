<?php

Route::group(array('module' => 'Rental', 'namespace' => 'App\Modules\Rental\Controllers'), function() {

    Route::resource('rental', 'RentalController');
    
});	