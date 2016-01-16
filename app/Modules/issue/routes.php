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
        'uses' => 'IssueController@destroy',
//        'middleware' => ['roles'],
//        'roles' => ['agency admin'],
    ]);
});

Route::group(array('module' => 'IssueDetail', 'namespace' => 'App\Modules\Issue\Controllers'), function() {
    Route::get('issue_detail', [
        'as' => 'issue_detail.index',
        'uses' => 'IssueDetailController@index',
//        'middleware' => ['roles'],
//        'roles' => ['agency admin'],
    ]);
    Route::get('issue_detail/{id}', [
        'as' => 'issue_detail.show',
        'uses' => 'IssueDetailController@show',
//        'middleware' => ['roles'],
//        'roles' => ['agency admin'],
    ]);
    Route::post('issue_detail/{id}', [
        'as' => 'issue_detail.store',
        'uses' => 'IssueDetailController@store',
//        'middleware' => ['roles'],
//        'roles' => ['agency admin'],
    ]);
    Route::delete('issue_detail/{id}', [
        'as' => 'issue_detail.destroy',
        'uses' => 'IssueDetailController@destroy',
//        'middleware' => ['roles'],
//        'roles' => ['agency admin'],
    ]);
});