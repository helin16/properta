<?php namespace App\Modules\User\Models;

use App\Modules\Abstracts\Models\BaseModel;
use DB;

class Role extends BaseModel
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