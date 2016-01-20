<?php namespace App\Modules\Rental\Models;

use App\Modules\Abstracts\Models\BaseModel;
use App\Modules\User\Models\User;
use App\Modules\User\Models\Role;

class RentalUser extends BaseModel
{
	protected $table = 'rental_user';
	protected $primaryKey = null;
	public $incrementing = false;
	protected $fillable= ['user_id', 'role_id', 'rental_id'];

	public static function store(User $user, Rental $rental, Role $role)
	{
		$data = ['user_id' => $user->id,
			'role_id' => $role->id,
			'rental_id' => $rental->id,
		];
		$obj =  self::where($data)->first();
		if(!$obj instanceof self)
			self::create($data);
		return $obj;
	}
}