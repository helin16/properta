<?php

Route::group(array('module' => 'PropertyDetail', 'namespace' => 'App\Modules\PropertyDetail\Controllers'), function() {

    Route::resource('propertydetail', 'PropertyDetailController');
    
});	