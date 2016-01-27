<?php

namespace App\Modules\MoneyPool\Models;

use App\Modules\Abstracts\Models\BaseModel;
use App\Modules\System\Models\User;


class Group_User extends BaseModel
{
   /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'group_user';
    public function group()
    {
    	return $this->belongsTo(Group::class, 'group_id');
    }
    public function user()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }
}
