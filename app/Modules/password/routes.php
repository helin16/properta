<?php

Route::group(array('module' => 'Password', 'namespace' => 'App\Modules\Password\Controllers'), function() {

    Route::resource('password', 'PasswordController');
    
});	