<?php

Route::group(array('module' => 'IssueProgress', 'namespace' => 'App\Modules\IssueProgress\Controllers'), function() {

    Route::resource('issueprogress', 'IssueProgressController');
    
});	