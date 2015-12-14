<?php

Route::group(array('module' => 'Api', 'namespace' => 'App\Modules\Api\Controllers'), function() {

    Route::resource('api', 'ApiController');
    
});	