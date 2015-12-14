<?php

Route::group(array('module' => 'Issue', 'namespace' => 'App\Modules\Issue\Controllers'), function() {

    Route::resource('issue', 'IssueController');
    
});	