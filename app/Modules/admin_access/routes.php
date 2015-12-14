<?php

Route::group(array('module' => 'AdminAccess', 'namespace' => 'App\Modules\AdminAccess\Controllers'), function() {

    Route::resource('adminaccess', 'AdminAccessController');
    
});	