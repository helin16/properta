<?php namespace App\Modules\User\Models;

use App\Modules\Abstracts\Models\BaseModel;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends BaseModel implements AuthenticatableContract, CanResetPasswordContract
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

    public static function getAll($pageSize)    {
        $query = self::orderBy(array_keys(self::$orderBy)[0], array_values(self::$orderBy)[0]);
        return $query->paginate($pageSize ?: self::$pageSize);
    }
    protected function checkLogin($email,$password ){
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
    public function details()	{
        return $this->hasMany(UserDetail::class);
    }
    public function inline()	{
        return ($this->details->first() ? $this->details->first()->fullName() : '') . ' (' . $this->email . ')';
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