<?php

Route::group(array('module' => 'UserRelationship', 'namespace' => 'App\Modules\UserRelationship\Controllers'), function() {

    Route::resource('userrelationship', 'UserRelationshipController');
    
});	