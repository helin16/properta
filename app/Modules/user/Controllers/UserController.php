<?php namespace App\Modules\User\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\User\Models\User;

class UserController extends Controller
{
	//
    public function index()
    {
        return view('user::index');
    }

    public function login(){
        //$user = new App\Modules\User\Models\User();
        User::checkLogin();
        if( User::checkLogin() ){

            

        }else{
            return view('user::index');
        }
    }

}
