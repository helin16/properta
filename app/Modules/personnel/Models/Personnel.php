<?php namespace App\Modules\Personnel\Models;

use Illuminate\Database\Eloquent\Model;
use Session;
use DB;
use App;
use App\Modules\User\Models\Role;
use App\Modules\User\Models\User;

class Personnel extends Model {

    protected $table = 'admin_accesses';

	protected function checkUserAccess(){
        $currentUserId = Session::get('currentUser');
        $currentUserRole = User::getCurrentUser($currentUserId);
        $currentRole = Role::getCurrentRole($currentUserRole->role_id)->name;


        if($currentUserRole->role_id == 1 || $currentUserRole->role_id == 2){
            return true;
        }



        return App::abort(403, 'Access denied');

        //return $currentUserID;
    }

}
