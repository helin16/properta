<?php namespace App\Modules\User\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Role extends Model
{
    protected $table = 'roles';

    public function users()
    {
        return $this->hasMany('App\User', 'id', 'id');
    }

    protected function getCurrentRole($id){

        $currentUserRole = Role::where('id', $id)->first();
        return $currentUserRole;
    }
}