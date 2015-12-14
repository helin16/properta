<?php

Route::group(array('module' => 'Document', 'namespace' => 'App\Modules\Document\Controllers'), function() {

    Route::resource('document', 'DocumentController');
    
});	