<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return Redirect::route('user.index');
});

Route::get('utility/map', [
    'as' => 'utility.map',
    function(){
        return view('abstracts::utilities.map', ['id' => 'google_map_auto_complete']);
    }
]);