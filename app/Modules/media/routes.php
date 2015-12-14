<?php

Route::group(array('module' => 'Media', 'namespace' => 'App\Modules\Media\Controllers'), function() {

    Route::resource('media', 'MediaController');
    
});	