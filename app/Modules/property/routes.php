<?php

Route::group(array('module' => 'Property', 'namespace' => 'App\Modules\Property\Controllers'), function() {

    Route::resource('property', 'PropertyController');
    
});	