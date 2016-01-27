<?php
Route::group(['as' => 'API::', 'prefix' => 'api', 'namespace' => 'App\Modules\API\Controllers'], function() {
    Route::resource('user', 'UserController');
    Route::resource('group', 'GroupController');
    Route::resource('transaction', 'TransactionController');
    Route::resource('role', 'RoleController');
    Route::resource('group.user', 'GroupUserController');
    Route::resource('group.transaction', 'GroupTransactionController', ['only' => ['show', 'store', 'edit', 'destroy']]);
});