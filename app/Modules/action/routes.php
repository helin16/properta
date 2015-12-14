<?php

Route::group(array('module' => 'Action', 'namespace' => 'App\Modules\Action\Controllers'), function() {

    Route::resource('action', 'ActionController');
    
});	