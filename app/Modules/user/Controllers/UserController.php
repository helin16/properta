<?php namespace App\Modules\User\Controllers;

use App\Http\Requests;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\Modules\User\Models\User;
use App\Modules\User\Models\Role;
use Session;
use Hash;
use App\Modules\Personnel\Models\Personnel;


class UserController extends Controller

{
    protected $currentUserId;

    protected function checkCurrentUser(){
        $value = Session::get('currentUserId');
        $this->currentUserId = $value;
        if(!$value){
            Redirect::to('user')->send();
        }
    }

	//
    public function index()
    {
        return view('user::index');
    }

    public function login() {
        // Getting all post data
        $data = Input::all();
        // Applying validation rules.
        $rules = array(
            'email' => 'required|email',
            'password' => 'required|min:6',
        );

        $validator = Validator::make($data, $rules);
        if ($validator->fails()){
            // If validation falis redirect back to login.
            return Redirect::to('user/index')->withInput(Input::except('password'))->withErrors($validator);
        }
        else {
            $user = User::checkLogin(Input::get('email'),Hash::make(Input::get('password')));
            //var_dump($user);exit;
            // login.
            if (count($user) > 0 ) {
                //if( Hash::check(Input::get('password'), $user[0]->password) ){
                    Session::put('currentUserId', $user[0]->id);
                    $userDetailModel = User::getCurrentUserProfile($user[0]->id);
                    $currentUserDetails = array(
                        'firstName' => $userDetailModel->firstName,
                        'lastName' => $userDetailModel->lastName
                    )
                    ;
                    $currentUserRole = Role::getCurrentRole($user[0]->role_id)->name;
                    Session::put('currentUserDetails', $currentUserDetails );
                    Session::put('currentUserRole', $currentUserRole );
                    return Redirect::to('dashboard');
//                 }else{
//                     Session::flash('error', 'Incorrect password combination');
//                     return Redirect::back()->withErrors('Incorrect password');
//                 }

            }else {
                // if any error send back with message.
                Session::flash('error', 'Incorrect password combination');
                return Redirect::back()->withErrors('Incorrect password');
            }
        }
    }

    public function logout(){
        Session::forget('currentUserId');
        Session::flash('error', 'You successfully logout');
        return Redirect::to('user');
    }

    public function editProfile(){

        $this->checkCurrentUser();
        $userCurrentProfile = User::getCurrentUserProfile($this->currentUserId);
        $data = array(
            'firstName'  => $userCurrentProfile->firstName,
            'lastName' => $userCurrentProfile->lastName,
            'contactNumber' => $userCurrentProfile->contactNumber
        );
        return view('user::editProfile')->with('data', $data);
    }

    public function updateProfile(){

        $this->checkCurrentUser();

        $data = Input::all();
        // Applying validation rules.
        $rules = array(
            'firstName' => 'required',
            'lastName' => 'required',
            'contactNumber' => 'required'
        );

        $validator = Validator::make($data, $rules);
        if ($validator->fails()){
            // If validation falis redirect back to login.
            return Redirect::to('user/index')->withInput(Input::except('firstName'))->withErrors($validator);
        }else{
            User::updateCurrentUserProfile($this->currentUserId,$data);
            Session::flash('error', 'Your profile has been saved');
            return Redirect::back()->withErrors('Your profile has been saved!');
        }


    }

    public function editPassword(){
        $this->checkCurrentUser();
        //echo $currentId = Session::get('currentUserId');exit;
        return view('user::editPassword');
    }

    public function updatePassword(){
        $this->checkCurrentUser();

        $rules = array(
            'now_password'          => 'required',
            'password'              => 'min:5|confirmed|different:now_password',
            'password_confirmation' => 'required_with:password|min:5'
        );
        //password update.
        $nowPassword       = Input::get('now_password');
        $password           = Input::get('password');
        $passwordconf       = Input::get('password_confirmation');

        $validator = Validator::make(Input::only('now_password', 'password', 'password_confirmation'), $rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        //var_dump(Hash::make($nowPassword));exit;
        $currentUserP = User::findCurrentPassword($this->currentUserId, Hash::make($nowPassword));

        if( !Hash::check(Input::get('now_password'), $currentUserP[0]->password) ){
            Session::flash('error', 'incorrect current password');
            return Redirect::back()->withErrors('Password incorrect');
        }

        User::updatePassword($this->currentUserId,Hash::make($password));

        return Redirect::back()->with('success', true)->with('message',"User's password updated.");
    }

    public function createUser(){
        $this->checkCurrentUser();
        //echo $currentId = Session::get('currentUser');
        echo Personnel::checkUserAccess();
        return view('user::createUser');
    }

    public function postCreateUser(){
        $this->checkCurrentUser();
        $data = Input::all();

        $rules = array(
            'firstName' => 'required',
            'lastName' => 'required',
            'contactNumber' => 'required',
            'email' => 'required|email',
            'password'      => 'min:5|confirmed',
            'password_confirmation' => 'required_with:password|min:5'
        );

        $validator = Validator::make($data, $rules);

        if ($validator->fails()){
            // If validation falis redirect back to login.
            return Redirect::back()->withErrors($validator);

        }else{
            User::updateCurrentUserProfile($this->currentUserId,$data);
            Session::flash('error', 'Your profile has been saved');
            return Redirect::back()->withErrors('Your profile has been saved!');
        }


    }


}
