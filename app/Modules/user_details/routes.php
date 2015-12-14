<?php

Route::group(array('module' => 'UserDetails', 'namespace' => 'App\Modules\UserDetails\Controllers'), function() {

    Route::resource('userdetails', 'UserDetailsController');
    
});	