<?php

Route::group(array('module' => 'Personnel', 'namespace' => 'App\Modules\Personnel\Controllers'), function() {

    Route::resource('personnel', 'PersonnelController');
    
});	