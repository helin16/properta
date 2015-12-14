<?php

Route::group(array('module' => 'Role', 'namespace' => 'App\Modules\Role\Controllers'), function() {

    Route::resource('role', 'RoleController');
    
});	