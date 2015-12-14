<?php

Route::group(array('module' => 'Permission', 'namespace' => 'App\Modules\Permission\Controllers'), function() {

    Route::resource('permission', 'PermissionController');
    
});	