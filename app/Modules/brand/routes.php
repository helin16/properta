<?php

Route::group(array('module' => 'Brand', 'namespace' => 'App\Modules\Brand\Controllers'), function() {

    Route::resource('brand', 'BrandController');
    
});	