<?php

Route::group(array('module' => 'Dashboard', 'namespace' => 'App\Modules\Dashboard\Controllers'), function() {

    Route::resource('dashboard', 'DashboardController');
    
});	