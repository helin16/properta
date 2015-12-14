<?php

Route::group(array('module' => 'IssueDetail', 'namespace' => 'App\Modules\IssueDetail\Controllers'), function() {

    Route::resource('issuedetail', 'IssueDetailController');
    
});	