<?php

Route::group(array('module' => 'PropertyLog', 'namespace' => 'App\Modules\PropertyLog\Controllers'), function() {

    Route::resource('propertylog', 'PropertyLogController');
    
});	