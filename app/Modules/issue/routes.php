<?php
Route::group(array('module' => 'Issue', 'namespace' => 'App\Modules\Issue\Controllers'), function() {
    Route::get('issue', [
        'as' => 'issue.index',
        'uses' => 'IssueController@index',
//        'middleware' => ['roles'],
//        'roles' => ['agency admin'],
    ]);
    Route::get('issue/{id}', [
        'as' => 'issue.show',
        'uses' => 'IssueController@show',
//        'middleware' => ['roles'],
//        'roles' => ['agency admin'],
    ]);
    Route::post('issue/{id}', [
        'as' => 'issue.store',
        'uses' => 'IssueController@store',
//        'middleware' => ['roles'],
//        'roles' => ['agency admin'],
    ]);
    Route::delete('issue/{id}', [
        'as' => 'issue.destroy',
        'uses' => 'IssueController@show',
//        'middleware' => ['roles'],
//        'roles' => ['agency admin'],
    ]);
});