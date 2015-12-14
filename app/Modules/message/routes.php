<?php

Route::group(array('module' => 'Message', 'namespace' => 'App\Modules\Message\Controllers'), function() {

    Route::resource('message', 'MessageController');
    
});	