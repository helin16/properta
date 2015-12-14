<?php

Route::group(array('module' => 'Address', 'namespace' => 'App\Modules\Address\Controllers'), function() {

    Route::resource('address', 'AddressController');
    
});	