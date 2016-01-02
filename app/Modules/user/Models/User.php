<?php namespace App\Modules\User\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Hash;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
	use Authenticatable, CanResetPassword;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['email','role_id', 'brand_id'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['remember_token'];

    protected function checkLogin($email,$password ){
        // do logic

        $user = DB::table('users')
                ->leftJoin('passwords', 'users.id', '=', 'passwords.user_id')
                ->where('users.email', '=', $email)
                //->where('passwords.password', '=', $password)
                ->get();

        return $user;

    }

    protected function findCurrentPassword($id,$password){
        // do logic
        $currentPassword = DB::table('passwords')
            ->where('user_id', '=', $id)
            //->where('password', '=', $password)
            ->get();

        return $currentPassword;
    }

    protected function getCurrentUserProfile($id){

        $currentUserProfile = DB::table('user_details')
            ->where('user_id', '=', $id)
            ->first();

        return $currentUserProfile;
    }

    protected function updateCurrentUserProfile($id,$data){
        DB::table('user_details')
            ->where('user_id', $id)
            ->update(['firstName' => $data['firstName'] , 'lastName' => $data['lastName'] , 'contactNumber' => $data['contactNumber'] ])
           ;
    }



}